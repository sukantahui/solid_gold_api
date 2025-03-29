<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Helper\ResponseHelper;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Http\Resources\ProductCategoryResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;  // Add this import
use Illuminate\Support\Facades\Log; // Add this import

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        DB::beginTransaction();

        try {

            // Convert camelCase to snake_case and prepare data
            $validatedData = collect($request->validated())
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->toArray();
            // The request is already validated at this point
            $productCategory = ProductCategory::create($validatedData);
            DB::commit();
            return ResponseHelper::success('Product category created', new ProductCategoryResource($productCategory),200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("Product Category not found: {$e->getMessage()}");
            return ResponseHelper::error('Product Category not found', 404);

        } catch (QueryException $e) {
            DB::rollBack();
            Log::error("Database error updating Product Category: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update Product Category due to database error', 500);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error updating Product Category: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update Product Category',$validatedData, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $product_category = ProductCategory::findOrFail($id);

            // Convert camelCase to snake_case and prepare data
            $validatedData = collect($request->validated())
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->toArray();

            // Handle unique fields carefully
            //$this->handleUniqueFields($validatedData, $customer);

            // Update product category
            $product_category->update($validatedData);

            DB::commit();
            return ResponseHelper::success('Product Category updated successfully',new ProductCategoryResource($product_category->fresh()), 200);
            // return ResponseHelper::success('Product Category updated successfully',$validatedData, 200);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("Product Category not found: {$e->getMessage()}");
            return ResponseHelper::error('Customer not found', 404);

        } catch (QueryException $e) {
            DB::rollBack();
            Log::error("Database error updating Product Category: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update Product Category due to database error', 500);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error updating Product Category: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update customer',$validatedData, 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
    }
}
