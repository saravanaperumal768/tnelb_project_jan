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
        Schema::create('tnelb_registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('gender');
            $table->string('mobile', 10)->unique();
            $table->string('email')->nullable()->unique();
            $table->text('address');
            $table->string('state');
            $table->string('district');
            $table->string('pincode', 6);
            $table->string('aadhaar', 12);
            $table->string('pancard')->nullable()->unique();
            $table->string('login_id')->default('');
            $table->string('password')->default('');
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
        Schema::dropIfExists('registers');
    }
};
