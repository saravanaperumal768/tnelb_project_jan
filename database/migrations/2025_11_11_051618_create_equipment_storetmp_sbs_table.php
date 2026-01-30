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
        Schema::create('equipment_storetmp_sb', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->string('login_id');
            $table->string('application_id');

            $table->boolean('equip_check')->nullable(); 

            $table->enum('invoice', ['yes', 'no'])->nullable(); 

            $table->enum('lab_auth', ['yes', 'no'])->nullable(); 

            // $table->enum('lab_auth', ['yes', 'no'])->nullable(); 

            $table->enum('instrument3_yes', ['yes', 'no'])->nullable(); 

            $table->string('instrument3_id')->nullable();

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
        Schema::dropIfExists('equipment_storetmp_sb');
    }
};
