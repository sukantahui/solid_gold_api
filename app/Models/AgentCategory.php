<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCategory extends Model
{
    /** @use HasFactory<\Database\Factories\AgentCategoryFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
