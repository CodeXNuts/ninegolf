<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders','id');
            $table->foreignId('payment_gateway_id')->constrained('payment_gateways','id');
            $table->float('amount');
            $table->string('transaction_id')->nullable();
            $table->longText('transaction_payload')->nullable();
            $table->integer('transaction_type'); // 1 - payment, 2 - void/refunded 
            $table->integer('transaction_status'); // 0 - failed , 1 - successfull
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_transactions');
    }
};
