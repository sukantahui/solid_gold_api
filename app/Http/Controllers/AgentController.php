<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Agent;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Http\Resources\AgentResource;
use Exception;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $agents=Agent::all();
        
        return ResponseHelper::success('Agents fetched successfully',AgentResource::collection($agents),200);
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
    public function store(StoreAgentRequest $request)
    {
        try{
            $customer = Agent::create([
                'agent_name'=>$request->agentName,
                'agent_category_id' => $request->agentCategoryId,
                'short_name' => $request->shortName,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'pin_code' => $request->pinCode

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
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agent $agent)
    {
        //
    }
}
