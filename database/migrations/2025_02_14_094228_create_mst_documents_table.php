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
        Schema::create('mst_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');
            $table->string('application_id')->nullable();
            $table->text('education_serial')->nullable();
            $table->text('experience_serial')->nullable();
            // $table->binary('education_doc')->nullable();
            // $table->binary('experience_doc')->nullable();
            // $table->binary('upload_photo')->nullable();
            // $table->binary('upload_sign')->nullable();

            $table->text('education_doc')->nullable();
            $table->text('experience_doc')->nullable();
            $table->text('upload_photo')->nullable();
            $table->text('upload_sign')->nullable();


            // $table->string('application_id');
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
        Schema::dropIfExists('mst_documents');
    }
};
