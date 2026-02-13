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
        Schema::create('mst_filepath_module_cl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cert_license_id')
            ->nullable()
            ->constrained('mst_licences')
            ->cascadeOnDelete();
            $table->string('module_name',100)->unique();
            $table->string('module_code',20)->unique();
            $table->tinyInteger('status')->default(1)->comment('1=Active, 0=Inactive');
            $table->string('created_by', 20);
            $table->string('updated_by', 20);
            $table->string('ipaddress', 70);
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
        Schema::dropIfExists('mst_filepath_modules');
    }
};
