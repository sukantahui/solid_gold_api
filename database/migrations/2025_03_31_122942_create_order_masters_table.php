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
        Schema::create('order_masters', function (Blueprint $table) {
            $table->id();
            $table->string('order_number',15)->unique()->nullable(false)->comment('Unique order number');
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('agent_id')->constrained('agents')->restrictOnDelete();
            $table->string('order_note',2555)->nullable(true)->comment('Order note');
            $table->date('order_date')->default(now()->toDateString())->comment('Date of order, without time');
            $table->foreignId('employee_id')->constrained('employees')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_masters');
    }
};
