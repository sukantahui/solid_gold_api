<?php

namespace App\Http\Controllers;

use App\Traits\HandlesTransactions;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helper\ResponseHelper;
use App\Models\GoldTransaction;
use App\Http\Requests\StoreGoldTransactionRequest;
use App\Http\Requests\UpdateGoldTransactionRequest;

use Exception;


class GoldTransactionController extends Controller
{
   use HandlesTransactions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = GoldTransaction::all();
        return ResponseHelper::success('Gold Transaction fetchedd', $transactions, 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGoldTransactionRequest $request)
    {
       
        return $this->executeInTransaction(function() use ($request) {
            $transaction = GoldTransaction::create($request->validated());
            return ResponseHelper::success('Created', $transaction->fresh(), 201);
        });

    }


    public function update(UpdateGoldTransactionRequest $request, $id)
    {
        $transaction = GoldTransaction::findOrFail($id);
        $transaction->update($request->validated());

        return response()->json([
            'message' => 'Gold transaction updated successfully.',
            'data' => $transaction,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoldTransaction $goldTransaction)
    {
        //
    }
}
