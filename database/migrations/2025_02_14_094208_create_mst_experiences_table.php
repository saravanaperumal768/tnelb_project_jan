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
        Schema::create('mst_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');
            $table->string('application_id');
            $table->string('exp_serial');
            $table->string('company_name');
            $table->integer('experience');
            $table->string('designation');
            // $table->string('document')->nullable();
           
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
        Schema::dropIfExists('mst_experiences');
    }
};
