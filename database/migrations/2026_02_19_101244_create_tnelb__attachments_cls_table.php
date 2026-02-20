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
        Schema::create('tnelb_attachments_cl', function (Blueprint $table) {
            $table->id();
            $table->string('login_id', 50);
            $table->string('application_id', 100);
            $table->string('form_name', 10);
            $table->string('license_name', 25);
            

            $table->string('document_category', 25)->nullable();
            $table->string('type', 25)->nullable();
            
            $table->string('file_doc');



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
        Schema::dropIfExists('tnelb_attachments_cl');
    }
};
