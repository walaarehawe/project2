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
        Schema::table('order_external_users', function (Blueprint $table) {
            $table->foreignId('trnsporation_costs_id')->constrained('transportation_costs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_order_external_users', function (Blueprint $table) {
            Schema::dropIfExists('trnsporation_costs_id');
        });
    }
};
