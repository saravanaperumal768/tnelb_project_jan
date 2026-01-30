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
        Schema::create('tnelb_bankguarantee_sb', function (Blueprint $table) {
            $table->id();
            $table->string("login_id");
            $table->string("application_id");
            $table->string("bank_guarantee_address");
            $table->date("bank_guarantee_validity");
            $table->string("bank_guarantee_amount");
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
        Schema::dropIfExists('tnelb_bankguarantee_sb');
    }
};
