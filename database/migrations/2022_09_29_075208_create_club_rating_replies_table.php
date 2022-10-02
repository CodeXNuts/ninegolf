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
        Schema::create('club_rating_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_rating_id')->constrained('club_ratings','id');
            // $table->bigInteger('reply_parent_id');
            $table->foreignId('user_id')->constrained('users','id');
            $table->text('comment');
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
        Schema::dropIfExists('club_rating_replies');
    }
};
