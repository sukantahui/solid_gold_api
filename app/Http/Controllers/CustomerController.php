<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;  // Add this import
use Illuminate\Support\Facades\Log; // Add this import
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return ResponseHelper::success('Customer fetchedd', CustomerResource::collection($customers),200);
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
                return ResponseHelper::success('Customer created', new CustomerResource($customer),200);
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
            return ResponseHelper::success('Customer fetched', new CustomerResource($customer),200);
        } else {
            return ResponseHelper::error('Customer not found', null, 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            // Find the customer or fail with 404
            $customer = Customer::findOrFail($id);

            // Convert camelCase to snake_case and prepare data
            $validatedData = collect($request->validated())
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->toArray();

            // Handle unique fields carefully
            //$this->handleUniqueFields($validatedData, $customer);

            // Update customer
            $customer->update($validatedData);

            DB::commit();

            return ResponseHelper::success(
                'Customer updated successfully',
                new CustomerResource($customer->fresh()),
                200
            );

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("Customer not found: {$e->getMessage()}");
            return ResponseHelper::error('Customer not found', 404);

        } catch (QueryException $e) {
            DB::rollBack();
            Log::error("Database error updating customer: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update customer due to database error', 500);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error updating customer: {$e->getMessage()}");
            return ResponseHelper::error('Failed to update customer', 500);
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        try {
            DB::beginTransaction();

            $customer = Customer::findOrFail($id);

            $customer->delete();

            DB::commit();
            return ResponseHelper::success('success','Customer deleted successfully.',200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("Customer not found: " . $e->getMessage());
            return ResponseHelper::error('Customer not found',null,200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting customer: " . $e->getMessage());
            return ResponseHelper::error('Error deleting customer',500);
        }
    }
}
