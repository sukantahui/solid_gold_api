<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\ProductResource;
use App\Helper\ResponseHelper;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        if (($products->isEmpty())){
          return ResponseHelper::error("No products found", null, 404);
        }
        return ResponseHelper::success("products retrieved successfully",data: ProductResource::collection(resource: $products));
    }
    
    function products_by_category($productCategoryId){
        $products = Product::where('product_category_id', $productCategoryId)->get();
        if (($products->isEmpty())){
          return ResponseHelper::error("No products found", null, 404);
        }
        return ResponseHelper::success("products retrieved successfully",data: ProductResource::collection(resource: $products));
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
    public function store(StoreProductRequest $request)
    {
        return "Product created successfully";
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return "aalu";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
