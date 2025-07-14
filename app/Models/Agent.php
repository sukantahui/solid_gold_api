<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    /** @use HasFactory<\Database\Factories\AgentFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'active' => 'boolean',
        'inforce' => 'boolean',
    ];
    public function agentCategory()
    {
        return $this->belongsTo(AgentCategory::class);
    }

    public function orderMasters()
    {
        return $this->hasMany(OrderMaster::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'agent_id');
    }
}
