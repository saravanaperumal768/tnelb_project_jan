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
        Schema::create('proprietordetailsform_A', function (Blueprint $table) {
            $table->id();
            $table->string('login_id');
            $table->string('application_id');

            $table->text('proprietor_name');
            $table->text('proprietor_address');
            
            $table->string('age');
            $table->string('qualification');
            $table->string('fathers_name')->nullable();
            $table->string('present_business')->nullable();
            // $table->string('competency_certificate_holding');
            $table->enum('competency_certificate_holding', ['yes', 'no']);
            $table->string('competency_certificate_number')->nullable();
            $table->string('competency_certificate_validity')->nullable();
            $table->enum('presently_employed', ['yes', 'no']);
            $table->string('presently_employed_name')->nullable();
            $table->string('presently_employed_address')->nullable();
            $table->enum('previous_experience', ['yes', 'no']);
            $table->string('previous_experience_name')->nullable();
            $table->string('previous_experience_address')->nullable();
            $table->string('previous_experience_lnumber')->nullable();
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
        Schema::dropIfExists('proprietorform_a_s');
    }
};
