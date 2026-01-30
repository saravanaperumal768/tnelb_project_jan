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
        Schema::create('equipment_storetmp_a', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->string('login_id');
            $table->string('application_id');
            $table->string('equip_check')->nullable();

            $table->string('tested_documents')->nullable();
            $table->string('tested_report_id')->nullable();
            $table->string('validity_date_eq1')->nullable();

            $table->string('original_invoice_instr')->nullable();
            $table->string('invoice_report_id')->nullable();
            $table->string('validity_date_eq2')->nullable();


            $table->string('instrument3_yes')->nullable();
            $table->string('instrument3_id')->nullable();
            $table->string('validity_date_eq3')->nullable();

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
        Schema::dropIfExists('equipment_storetmp_a');
    }
};
