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
        Schema::create('club_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained();
            $table->string('name');
            $table->string('slug');
            $table->float('price')->nullable();
            $table->string('priceUnit')->nullable();
            $table->string('brand');
            $table->string('length');
            $table->string('flex');
            $table->string('loft');
            $table->boolean('is_adjustable');
            $table->boolean('is_set');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('club_lists');
    }
};
