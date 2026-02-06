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
        Schema::create('tnelb_temp_uploaded_documents', function (Blueprint $table) {
            $table->id();
            $table->string('login_id');
            $table->string('application_id');
            $table->string('form_name');
            $table->string('license_name');
            $table->string('module');
            $table->string('ownership_type')->nullable();
            $table->string('document_category')->nullable();
            $table->string('document_sub_category')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->dateTime('uploaded_at');
            $table->integer('is_final'); //status
            $table->string('moved_as')->nullable();
            // $table->string('login_id');

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
        Schema::dropIfExists('tnelb__temp__tbls');
    }
};
