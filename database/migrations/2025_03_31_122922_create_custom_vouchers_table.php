<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('custom_vouchers', function (Blueprint $table) {
            $currentYear = Carbon::now()->year;
            $currentMonth = Carbon::now()->month;

            // Determine accounting year (e.g., April 2024 - March 2025 → "2425")
            $accountingYear = ($currentMonth < 4)
                ? sprintf("%02d%02d", ($currentYear - 1)%100, $currentYear % 100)
                : sprintf("%02d%02d", $currentYear%100, ($currentYear + 1) % 100);
            $table->id();
            $table->string('voucher_name',100);
            $table->bigInteger('last_counter')->default(1);
            $table->string('accounting_year',50)->default($accountingYear);

            $table->string('prefix',10)->nullable(true);
            $table->string('suffix',10)->nullable(true);
            $table->string('delimiter',5)->default('-');
            $table->unsignedTinyInteger('min_digits')->default(4)->comment('Zero padding length');
            $table->boolean('inforce')->default(true)->comment('Whether voucher is active');

            $table->unique(['voucher_name','accounting_year']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_vouchers');
    }

};
