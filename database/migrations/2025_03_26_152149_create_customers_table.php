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
            $table->foreignId('customer_category_id')->constrained('customer_categories')->restrictOnDelete();
            $table->unsignedBigInteger('agent_id')->default(1);
            $table->foreign('agent_id')->references('id')->on('agents')->restrictOnDelete();
            $table->string('customer_name', 200)->unique();
            $table->string('mailing_name', 200);
            $table->string('email', 200)->unique()->nullable();
            $table->string('phone', 15)->unique()->nullable();
            $table->string('mobile1', 15)->unique()->nullable();
            $table->string('mobile2', 15)->unique()->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('address', 200);
            $table->string('pin_code', 20);
            $table->decimal('opening_gold_balance')->default(0);
            $table->integer('opening_cash_balance')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('order_active')->default(true);
            $table->boolean('bill_active')->default(true);
            $table->boolean('job_active')->default(true);
            $table->boolean('inforce')->default(true);
            //Optional but recommended for performance
            $table->index('customer_category_id'); // Foreign key index
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
