<?php

namespace App\Http\Controllers;

use App\Models\PriceCode;
use App\Traits\HandlesTransactions;
use App\Http\Requests\StorePriceCodeRequest;
use App\Http\Requests\UpdatePriceCodeRequest;
use App\Helper\ResponseHelper;
use App\Http\Resources\PriceCodeResource;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PriceCodeController extends Controller
{
    use HandlesTransactions;
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
        return $this->executeInTransaction(function() use ($request) {
            
            
            $priceCode = PriceCode::create($request->validated());
            return ResponseHelper::success('Created', $priceCode->fresh(), 201);
        });
        
        
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
    public function update(UpdatePriceCodeRequest $request, $priceCodeId)
    {
        return $this->executeInTransaction(function() use ($request, $priceCodeId) {
            $priceCode = PriceCode::findOrFail($priceCodeId);
            $priceCode->update($request->validated());
            
            return ResponseHelper::success('Updated', $priceCode->fresh(), 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($priceCodeId)
    {
        return $this->executeInTransaction(function() use ($priceCodeId) {
            $priceCode = PriceCode::findOrFail($priceCodeId);
            
            // Check if deletable
            if ($this->isDeletable($priceCode)) {
                $priceCode->delete();
                return ResponseHelper::success('Price code deleted', [], 200);
            }
            
            return ResponseHelper::error(
                'Cannot delete - price code is in use', 
                ['references' => $this->getReferences($priceCode)],
                409
            );
        });
    }
    protected function isDeletable(PriceCode $priceCode): bool
    {
        // Example checks (customize based on your relationships)
        return !$priceCode->products()->exists()
                && !$priceCode->productRates()->exists();
    }

    protected function getReferences(PriceCode $priceCode): array
    {
        return [
            'product_count' => $priceCode->products()->count(),
            'product_rate_count' => $priceCode->productRates()->count()
        ];
    }
}
