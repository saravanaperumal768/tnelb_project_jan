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
        Schema::create('tnelb_equimentsuser_cl', function (Blueprint $table) {
            $table->id();
            $table->string('login_id', 50);
            $table->string('application_id', 100);
            $table->string('form_name', 10);
            $table->string('license_name', 25);

            $table->integer('licence_id');
            $table->string('equipment_id', 5);

            $table->string('serial_no', 20);
            $table->string('model_no', 20);
            $table->string('testreport_file', 255);
            $table->string('purchasereport_file', 255);
            $table->string('dateoftest', 255);

            // $table->string('file_doc', 50);
            $table->string('ipaddress', 50);


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
        Schema::dropIfExists('tnelb_equimentsuser_cl');
    }
};
