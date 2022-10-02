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
        Schema::create('user_stripe_connected_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('stripe_connected_account');
            $table->string('email')->nullable();
            $table->string('company_country')->nullable();
            $table->string('company_state')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_postal_code')->nullable();
            $table->text('company_addr_line_1')->nullable();
            $table->text('company_addr_line_2')->nullable();
            $table->string('business_profile_name')->nullable();
            $table->text('business_profile_desc')->nullable();
            $table->string('ac_holder_dob')->nullable();
            $table->string('ac_holder_state')->nullable();
            $table->string('ac_holder_city')->nullable();
            $table->string('ac_addr_line_1')->nullable();
            $table->string('ac_addr_postal_code')->nullable();
            $table->string('ac_holder_ssn')->nullable();
            $table->string('ac_holder_bank_ac')->nullable();
            $table->string('currency')->nullable();
            $table->string('ac_holder_routing')->nullable();
            $table->boolean('is_completed');
            $table->boolean('is_active');
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
        Schema::dropIfExists('user_stripe_connected_accounts');
    }
};
