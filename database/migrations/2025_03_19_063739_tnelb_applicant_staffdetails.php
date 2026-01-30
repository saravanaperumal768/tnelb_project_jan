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
        Schema::create('tnelb_applicant_formA_staffdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');
            $table->string('application_id');
            $table->string('staff_name');
            $table->string('staff_qualification');
            $table->string('cc_number');
            $table->string('cc_validity');
      
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
        //
    }
};
