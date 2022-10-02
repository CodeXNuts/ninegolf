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
        Schema::create('club_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained();
            $table->string('loc_name');
            $table->float('price');
            $table->string('price_unit');
            $table->text('address');
            $table->string('lat');
            $table->string('lng');
            $table->string('locType');
            $table->boolean('locFor')->default(false); // 1 - pickup, 0 - drop
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
        Schema::dropIfExists('club_addresses');
    }
};
