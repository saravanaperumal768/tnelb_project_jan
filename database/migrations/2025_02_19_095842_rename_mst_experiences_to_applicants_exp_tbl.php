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
        Schema::table('mst_experiences', function (Blueprint $table) {
            Schema::rename('mst_experiences', 'tnelb_applicants_exp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_experiences', function (Blueprint $table) {
            Schema::rename('tnelb_applicants_exp', 'mst_experiences');
        });
    }
};
