<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Exception;

class CustomerController extends Controller
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
    public function store(StoreCustomerRequest $request)
    {
        try{
            $customer = Customer::create([
                'customer_name'=>$request->customerName,
                'customer_category_id' => $request->customerCategoryId,
                'mailing_name' => $request->mailingName,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'pin_code' => $request->pinCode,
                'opening_gold_balance' => $request->openingGoldBalance,
                'opening_cash_balance' => $request->openingCashBalance,
            ]);

            if($customer){
                // Optionally, generate an authentication token for the user
                return ResponseHelper::success('success','Customer created',$customer,200);
            }else{
                return ResponseHelper::error('Failed to register user');
            }
        }catch(Exception $e){
            return ResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
