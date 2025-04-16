<?php

namespace App\Http\Controllers;

use App\Models\OrderMaster;
use App\Http\Requests\StoreOrderMasterRequest;
use App\Http\Requests\UpdateOrderMasterRequest;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderMasterController extends Controller
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
    public function store(StoreOrderMasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderMasterRequest $request, OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderMaster $orderMaster)
    {
        //
    }
}
