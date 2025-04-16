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
        Schema::create('gold_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date')->default(now()->toDateString())->comment('Date of transaction, without time');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('agent_id')->constrained('agents');
            $table->foreignId('order_master_id')->nullable()->constrained('order_masters');
            $table->decimal('gold_value',10,3);
            $table->integer('gold_rate')->nullable()->comment('Rate of 10 Gram Gold');
            $table->integer('gold_cash')->nullable()->comment('When value received in cas instead of gold');

            $table->foreignId('transaction_type_id')->constrained('transaction_types')->restrictOnDelete();

            $table->boolean('inforce')->default(true);
            $table->timestamps();

            $table->index('transaction_date');
            $table->index('customer_id');
            $table->index('agent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_transactions');
    }
};
