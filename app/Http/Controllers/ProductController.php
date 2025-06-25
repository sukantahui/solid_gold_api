<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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

   function getProductsByCustomer($customerId){
    $customer = Customer::with('customerCategory')->findOrFail($customerId);

    $products = Product::join('product_rates', function ($join) use ($customer) {
            $join->on('products.price_code_id', '=', 'product_rates.price_code_id')
                 ->where('product_rates.customer_category_id', '=', $customer->customer_category_id);
        })
        ->join('price_codes', 'products.price_code_id', '=', 'price_codes.id')
        ->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
        ->select(
            'products.id as product_id',
            'products.product_name',
            'products.product_number',
            'products.product_category_id',
            'products.price_code_id',
            'price_codes.price_code_name',
            'product_categories.product_category_name as product_category_name', // ✅ Corrected
            'product_rates.wastege_percentage',
            'product_rates.labour_charge'
        )
        ->get();

    return ResponseHelper::success("products", data: ProductResource::collection($products));
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
