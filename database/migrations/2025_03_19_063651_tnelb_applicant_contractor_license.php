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
        Schema::create('tnelb_applicant_formA', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');
            $table->string('application_id');
            $table->text('form_name');
            $table->text('license_name');
            $table->text('application_status');
            $table->text('license_number');
            
            $table->string('payment_status')->nullable();

            $table->string('applicant_name');
            $table->text('business_address');
        
            $table->string('authorised_name_designation')->nullable();
            $table->string('authorised_name')->nullable();
            $table->string('authorised_designation')->nullable();
            $table->string('previous_contractor_license')->nullable();
            $table->string('previous_application_number')->nullable();

            $table->text('bank_address');
            $table->string('bank_validity');
            $table->string('bank_amount');
            $table->string('criminal_offence')->nullable();
            $table->string('consent_letter_enclose')->nullable();
            $table->string('cc_holders_enclosed')->nullable();
            $table->string('purchase_bill_enclose')->nullable();
            $table->string('test_reports_enclose')->nullable();
            $table->string('specimen_signature_enclose')->nullable();
            
            // $table->enum('authorised_to_sign', ['yes', 'no']);
            $table->string('name_of_authorised_to_sign')->nullable();
            $table->string('separate_sheet')->nullable();
            $table->enum('declaration1', ['1', '0']);
            $table->enum('declaration2', ['1', '0']);
            $table->enum('enclosure', ['1', '0']);
            
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
