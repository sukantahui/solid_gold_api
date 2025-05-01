<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use App\Helper\ResponseHelper;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Traits\HandlesTransactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;  // Add this import
use Illuminate\Support\Facades\Log; // Add this import
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductCategoryController extends Controller
{
    use HandlesTransactions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ProductCategories = ProductCategory::withCount('products')->get();
        return ResponseHelper::success('Customer fetchedd', ProductCategoryResource::collection($ProductCategories), 200);
    }

    public function show($productCategoryId)
    {
        // Find or fail with custom error handling
        $category = ProductCategory::withCount('products')->find($productCategoryId);

        if (!$category) {
            return ResponseHelper::error('Product does not exist',null,404);
        }

        return ResponseHelper::success('fetched', new ProductCategoryResource($category), 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        return $this->executeInTransaction(function () use ($request) {
            $productCategory = ProductCategory::create($request->validated());
            return ResponseHelper::success('Created', new ProductCategoryResource($productCategory->fresh()), 201);
        });
    }





    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, $productCategoryId)
    {
        return $this->executeInTransaction(function() use ($request, $productCategoryId) {
            $productCategory = ProductCategory::findOrFail($productCategoryId);
            $productCategory->update($request->validated());
            
            return ResponseHelper::success('Updated', new ProductCategoryResource($productCategory->fresh()), 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productCategoryId)
    {
        return $this->executeInTransaction(function() use ($productCategoryId) {
            $productCategory = ProductCategory::findOrFail($productCategoryId);
            
            // Check if deletable
            if ($this->isDeletable($productCategory)) {
                $productCategory->delete();
                return ResponseHelper::success('Product Category deleted', $productCategory, 200);
            }
            
            return ResponseHelper::error(
                'Cannot delete - Product Category is in use', 
                ['references' => $this->getReferences($productCategory)],
                409
            );
        });
        
    }

    protected function isDeletable(ProductCategory $productCategory): bool
    {
        // Example checks (customize based on your relationships)
        return !$productCategory->products()->exists();
    }

    protected function getReferences(ProductCategory $productCategory): array
    {
        return [
            'product_count' => $productCategory->products()->count()
        ];
    }
}
