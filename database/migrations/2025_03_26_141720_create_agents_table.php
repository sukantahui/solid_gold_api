<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_category_id')->constrained('agent_categories')->restrictOnDelete();
            $table->string('agent_name',200)->unique();
            $table->string('short_name',200);
            $table->string('email',200)->unique();
            $table->string('phone',50);
            $table->string('address',200);
            $table->string('pin_code',10);
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('inforce')->default(1);

            //Optional but recommended for performance
            $table->index('agent_category_id'); // Foreign key index
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
