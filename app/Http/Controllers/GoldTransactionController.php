<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helper\ResponseHelper;
use App\Models\GoldTransaction;
use App\Http\Requests\StoreGoldTransactionRequest;
use App\Http\Requests\UpdateGoldTransactionRequest;
use Illuminate\Support\Facades\DB;  // Add this import
use Illuminate\Support\Facades\Log;
use Exception;


class GoldTransactionController extends Controller
{
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
        DB::beginTransaction();
        try {
            // Data will already be validated and converted to snake_case
            $validated = $request->validated();
            // Create transaction
            $transaction = GoldTransaction::create($validated);
            DB::commit();
            return ResponseHelper::success('Order created', $transaction->fresh(), 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("Module not found: {$e->getMessage()}");
            return ResponseHelper::error('Module not found', 404);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error("Database error updating Order: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update Order due to database error', $e->getMessage(), 500);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error updating Order: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update Order', $e->getMessage(), 500);
        }
        return ResponseHelper::success('Gold Transaction saving', [], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(GoldTransaction $goldTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoldTransaction $goldTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGoldTransactionRequest $request, GoldTransaction $goldTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoldTransaction $goldTransaction)
    {
        //
    }
}
