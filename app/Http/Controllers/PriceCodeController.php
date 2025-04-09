<?php

namespace App\Http\Controllers;

use App\Models\PriceCode;
use App\Http\Requests\StorePriceCodeRequest;
use App\Http\Requests\UpdatePriceCodeRequest;
use App\Helper\ResponseHelper;
use App\Http\Resources\PriceCodeResource;
use Exception;

class PriceCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priceCodes = PriceCode::all();
        return ResponseHelper::success('Price Code fetched', PriceCodeResource::collection($priceCodes),200);
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
    public function store(StorePriceCodeRequest $request)
    {
        try{
            $priceCode = PriceCode::create([
                'price_code_name'=>$request->priceCodeName
            ]);

            if($priceCode){
                // Optionally, generate an authentication token for the user
                return ResponseHelper::success('Price Code created',new PriceCodeResource($priceCode),200);
            }else{
                return ResponseHelper::error('Failed to create Price Code');
            }
        }catch(Exception $e){
            return ResponseHelper::error($e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceCode $priceCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePriceCodeRequest $request, PriceCode $priceCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceCode $priceCode)
    {
        //
    }
}
