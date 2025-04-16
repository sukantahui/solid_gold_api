<?php

namespace App\Http\Controllers;

use App\Models\CustomVoucher;
use App\Http\Requests\StoreCustomVoucherRequest;
use App\Http\Requests\UpdateCustomVoucherRequest;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomVoucherController extends Controller
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
    public function store(StoreCustomVoucherRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomVoucher $customVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomVoucher $customVoucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomVoucherRequest $request, CustomVoucher $customVoucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomVoucher $customVoucher)
    {
        //
    }


    function updateOrCreateVoucher($voucherName, $attributes = []) {
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Determine accounting year (e.g., "2425" for FY 2024-25)
        $accountingYear = ($currentMonth < 4)
            ? sprintf("%02d%02d", ($currentYear - 1) % 100, $currentYear % 100)
            : sprintf("%02d%02d", $currentYear % 100, ($currentYear + 1) % 100);

        // Default attributes for new records
        $defaultAttributes = array_merge([
            'last_counter' => 1,
            'delimiter' => '-',
            'inforce' => 1
        ], $attributes);

        // Find existing record or create new one
        $voucher = CustomVoucher::firstOrNew([
            'voucher_name' => $voucherName,
            'accounting_year' => $accountingYear
        ]);

        if ($voucher->exists) {
            // If record exists, only increment last_counter
            $voucher->increment('last_counter');
        } else {
            // If new record, set all attributes
            $voucher->fill($defaultAttributes)->save();
        }

        return $voucher;
    }
}
