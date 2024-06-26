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
        Schema::create('transportation_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transport_id')->constrained('transports')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('addresses')->onDelete('cascade');
            $table->double('cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_transportation_costs');
    }
};
