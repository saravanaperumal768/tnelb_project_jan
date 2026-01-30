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
        Schema::table('mst__form_s_ws', function (Blueprint $table) {
            Schema::rename('mst__form_s_ws', 'tnelb_application_tbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst__form_s_ws', function (Blueprint $table) {
            Schema::rename('tnelb_application_tbl', 'mst__form_s_ws');
        });
    }      
};
