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
        Schema::create('merchant_payouts', function (Blueprint $table) {
            $table->id();
            $table->text('transaction_id')->nullable();
            $table->foreignId('seller_id')->constrained('users','id');
            $table->foreignId('user_id')->constrained('users','id');
            $table->foreignId('order_id')->constrained('orders','id');
            $table->foreignId('order_detail_id')->constrained('order_details','id');
            $table->foreignId('user_stripe_connected_account_id')->constrained('user_stripe_connected_accounts','id');
            $table->double('payout_merchant_amount');
            $table->double('payout_admin_amount');
            $table->string('transfer_group');
            $table->text('merchant_desc');
            $table->text('admin_desc');
            $table->text('transaction_payload')->nullable();
           // $table->integer('transaction_type'); // 1 - payment, 2 - void/refunded 
            $table->integer('transaction_status'); // 0 - failed , 1 - successfull
            $table->softDeletes();
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
        Schema::dropIfExists('merchant_payouts');
    }
};
