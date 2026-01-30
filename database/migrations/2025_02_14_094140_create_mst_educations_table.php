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
        Schema::create('mst_educations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');
            $table->string('application_id')->nullable();
            $table->string('edu_serial');
            $table->string('educational_level');
            $table->string('institute_name');
            $table->year('year_of_passing');
            $table->float('percentage');
            $table->string('document')->nullable();
            
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
        Schema::dropIfExists('mst_educations');
        
    }
};
