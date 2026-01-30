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
        Schema::create('mst_workflows', function (Blueprint $table) {
            $table->id();
            $table->string('login_id');
            $table->string('application_id');
            $table->text('payment_status');
            $table->text('formname_appliedfor');
            $table->text('license_name');
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
        Schema::dropIfExists('mst_workflows');
    }
};
