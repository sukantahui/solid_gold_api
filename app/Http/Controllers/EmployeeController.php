<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Requests\EmployeeRequest;
use App\Helper\ResponseHelper;
use App\Requests\StoreEmployeeReques;
use App\Traits\HandlesTransactions;
class EmployeeController extends Controller
{
    use HandlesTransactions;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        if ($employees->isEmpty()) {
            return ResponseHelper::error("No employees found", null, statusCode: 404);
        }
        return ResponseHelper::success("employees retrieved successfully",$employees);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        return $this->executeInTransaction(function() use ($request) {
            $employee = Employee::create($request->validated());
            return ResponseHelper::success('Employee Created', $employee->fresh(), 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return ResponseHelper::success('Created', new Employee($id->fresh()), 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
