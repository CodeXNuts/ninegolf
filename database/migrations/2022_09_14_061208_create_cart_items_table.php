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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts','id');
            $table->foreignId('club_id')->constrained('clubs','id');
            $table->string('from_date');
            $table->string('from_time');
            $table->string('to_date');
            $table->string('to_time');
            $table->string('days');
            $table->foreignId('club_address_id')->constrained('club_addresses','id');
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
        Schema::dropIfExists('cart_items');
    }
};
