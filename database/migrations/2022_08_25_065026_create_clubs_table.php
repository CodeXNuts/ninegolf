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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('set_name')->nullable();
            $table->string('slug');
            $table->string('type');
            $table->string('gender');
            $table->string('dexterity');
            $table->string('adv_time');
            $table->float('set_price')->nullable();
            $table->string('set_price_unit')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('inventory')->nullable()->default(0);
            $table->foreignId('user_id')->constrained('users','id');
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
        Schema::dropIfExists('clubs');
    }
};
