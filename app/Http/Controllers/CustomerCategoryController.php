<?php

namespace App\Http\Controllers;

use App\Models\CustomerCategory;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerCategoryRequest;
use App\Http\Requests\UpdateCustomerCategoryRequest;
use App\Helper\ResponseHelper;
use Illuminate\Support\Facades\DB;  // Add this import
use Illuminate\Support\Facades\Log; // Add this import
use Illuminate\Support\Str;
use Exception;
use App\Http\Resources\CustomerCategoryResource;
use Illuminate\Http\Response;

class CustomerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CustomerCategory::all();
        return ResponseHelper::success('Customer fetchedd', $categories,200);

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
    public function store(StoreCustomerCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerCategory $customerCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerCategory $customerCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerCategoryRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $customer_category = CustomerCategory::findOrFail($id);

            // Convert camelCase to snake_case and prepare data
            $validatedData = collect($request->validated())
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->toArray();

            // Handle unique fields carefully
            //$this->handleUniqueFields($validatedData, $customer);

            // Update customer category
            $customer_category->update($validatedData);

            DB::commit();
            return ResponseHelper::success(
                'Customer Category updated successfully',
                new CustomerCategoryResource($customer_category->fresh()),
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
            return ResponseHelper::error('Failed to update customer',$validatedData, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $category = CustomerCategory::findOrFail($id);

            // Check if customer has related records before deletion
            if ($this->hasDependentRecords($category)) {
                return ResponseHelper::error('Cannot delete customer because it has associated records.',null,422);
            }

            $category->delete();

            DB::commit();
            return ResponseHelper::success('success','Customer category deleted successfully.',200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("Customer category not found: " . $e->getMessage());
            return ResponseHelper::error('Customer category not found',null,200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting customer category: " . $e->getMessage());
            return ResponseHelper::error('Error deleting customer category',500);
        }
    }
    protected function hasDependentRecords(CustomerCategory $category)
    {
        // Check for customers in this category
        if (Customer::where('customer_category_id', $category->id)->exists()) {
            return true;
        }

        return false;
    }

}
