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
        Schema::create('tnelb_banksolvency_a', function (Blueprint $table) {
            $table->id();
            $table->string("login_id");
            $table->string("application_id");
            $table->string("bank_address");
            $table->date("bank_validity");
            $table->string("bank_amount");
            $table->string("status");
            
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
        Schema::dropIfExists('tnelb_banksolvency_a');
    }
};
