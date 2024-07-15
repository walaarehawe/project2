<?php

use App\Enums\InvoiceStatus;
use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('price')->default('0');
            $table->integer('status_order')->default(OrderStatus::UNREADY)->comment('1 is   Ready and 0 unReady');
            $table->string('status_invoice')->default(InvoiceStatus::UNPAID)->comment('1 is Paid and 0 unPaid');
            $table->foreign('type_id')->references('id')->on('type_orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tables');
    }
};
