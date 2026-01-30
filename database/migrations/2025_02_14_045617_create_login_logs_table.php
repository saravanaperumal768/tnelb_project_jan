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
        Schema::create('tnelb_login_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');
            $table->string('ipaddress');
            $table->timestamp('Idate')->nullable(); // If you want a custom timestamp column
            $table->string('attempt');
            $table->decimal('duration', 8, 2);
            $table->timestamps(); // Adds 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_logs');
    }
};
