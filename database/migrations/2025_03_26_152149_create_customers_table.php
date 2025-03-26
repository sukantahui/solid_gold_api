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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_category_id')->references('id')->on('customer_categories');
            $table->string('customer_name')->unique();
            $table->string('mailing_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('pin_code');
            $table->decimal('opening_gold_balance')->default(0);
            $table->integer('opening_cash_balance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
