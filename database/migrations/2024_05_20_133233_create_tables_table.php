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
        Schema::create('tables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('table_types');
            $table->boolean('reservation_status')->default(StatusTable::NON_RESERVED)->comment('0 mean  non_reserved and 1 mean Reserved');
            $table->boolean('table_status')->default(StatusTable::ACTIVE)->comment('0 mean  non_active and 1 mean active');
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
