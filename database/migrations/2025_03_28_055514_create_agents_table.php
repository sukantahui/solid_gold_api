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
            $table->foreignId('agent_category_id')->references('id')->on('agent_categories');
            $table->string('agent_name')->unique();
            $table->string('short_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('pin_code');
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
