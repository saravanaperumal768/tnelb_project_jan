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
        Schema::create('mst__form_s_ws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('applicant_name');
            $table->string('fathers_name');
            $table->string('applicants_address');
            $table->string('d_o_b');
            $table->string('age');
            $table->string('previously_number')->nullable();
            $table->string('previously_date')->nullable();
            $table->string('wireman_details')->nullable();
            $table->string('login_id');
            $table->string('application_id');
            $table->text('form_name');
            $table->text('license_name');
            $table->text('application_status');
            $table->text('license_number');
            
            $table->string('payment_status')->nullable();
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
        Schema::dropIfExists('mst__form_s_ws');

        Schema::table('mst__form_s_ws', function (Blueprint $table) {
            if (!Schema::hasColumn('mst__form_s_ws', 'application_id')) {
                $table->string('application_id')->nullable();
            }
        });
    }
};
