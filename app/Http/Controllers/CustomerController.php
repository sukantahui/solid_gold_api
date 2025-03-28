<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Str;
use Exception;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return ResponseHelper::success('success','Customer fetchedd', CustomerResource::collection($customers),200);
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
                'mobile1' => $request->mobile1,
                'mobile2' => $request->mobile2,
                'whatsapp' => $request->whatsapp,
                'address' => $request->address,
                'pin_code' => $request->pinCode,
                'opening_gold_balance' => $request->openingGoldBalance,
                'opening_cash_balance' => $request->openingCashBalance,
            ]);

            if($customer){
                // Optionally, generate an authentication token for the user
                return ResponseHelper::success('success','Customer created', new CustomerResource($customer),200);
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
    public function get_customer($custId)
    {
        $customer = Customer::find($custId);

        // Check if the customer exists


        if ($customer) {
            return ResponseHelper::success('success','Customer fetched', new CustomerResource($customer),200);
        } else {
            return ResponseHelper::error('Customer not found', null, 404);
        }
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
    public function update(UpdateCustomerRequest $request, $id)
    {
        // Find the customer or return a 404 response if not found
        $customer = Customer::findOrFail($id);

        // Convert request data keys from camelCase to snake_case
        $validatedData = collect($request->validated())->mapWithKeys(function ($value, $key) {
            return [Str::snake($key) => $value];
        })->toArray();

        // Update the customer with validated data
        $customer->update($validatedData);

        // Return a success response
        return ResponseHelper::success('success','Customer fetched', new CustomerResource($customer),200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
