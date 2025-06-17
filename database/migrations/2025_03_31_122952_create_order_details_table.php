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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_master_id')->constrained('order_masters')->restrictOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->integer('quantity')->nullable(false)->comment('Quantity of the product');
            $table->decimal('gini', 6, 3)->nullable(false)->comment('Expected gold of the product');
            $table->decimal('wastege_percentage', 5, 3)->nullable(false)->comment('wastage to be charged on the gold value');
            $table->string('product_size',10)->nullable(false)->default('0-0-0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
