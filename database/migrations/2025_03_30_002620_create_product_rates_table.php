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
        Schema::create('product_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_category_id')->constrained('customer_categories')->restrictOnDelete();
            $table->foreignId('price_code_id')->constrained('price_codes')->restrictOnDelete();
            $table->decimal('wastege_percentage',5,3)->nullable(false)->comment('The charge on finished product in percentage');
            $table->integer('labour_charge')->default(0)->comment('Labourcharge in rupees');
            $table->index('customer_category_id');
            $table->index('price_code_id');
            // Composite unique index to prevent duplicate rate entries
            $table->unique(['customer_category_id', 'price_code_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_rates');
    }
};
