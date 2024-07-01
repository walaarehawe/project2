<?php

use App\Enums\StatusTable;
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
            Schema::create('tablesizes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('size');
                $table->integer('type');
                $table->integer('count');
                $table->timestamps();
    


        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
