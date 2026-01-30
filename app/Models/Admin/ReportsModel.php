<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportsModel extends Model
{
    protected $table = 'wcert';

    public static function get_wcert_all()
    {
        return DB::table('wcert')->orderBy('appsno', 'asc')->get();
    }
    public static function get_whcert_all()
    {
        return DB::table('whcert')->orderBy('appsno', 'asc')->get();
    }
    public static function get_mic_all()
    {
        return DB::table('tnelb_application_tbl')->get();
    }

}
