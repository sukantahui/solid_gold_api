<?php

namespace App\Http\Controllers;

use App\Models\ProductRate;
use App\Http\Requests\StoreProductRateRequest;
use App\Http\Requests\UpdateProductRateRequest;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRateController extends Controller
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
    public function store(StoreProductRateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductRate $productRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductRate $productRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRateRequest $request, ProductRate $productRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductRate $productRate)
    {
        //
    }
}
