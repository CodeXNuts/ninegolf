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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders','id');
            $table->foreignId('club_id')->constrained('clubs','id');
            $table->float('club_amount');
            $table->string('from_date');
            $table->string('from_time');
            $table->string('to_date');
            $table->string('to_time');
            $table->integer('days');
            $table->foreignId('club_address_id')->constrained('club_addresses','id');
            $table->float('club_address_amount');
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
        Schema::dropIfExists('order_details');
    }
};
