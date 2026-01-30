<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificatedatechangeController extends BaseController
{
     // -------licence_date-------------------------

    public function index(){

        // $s_cert = DB::table('scert')->get();
        // $w_cert = DB::table('wcert')->get();

         $s_cert = DB::table('scert')
        
        
        ->orderBy('sno', 'asc')
        ->take(30)
        ->get();

        $w_cert = DB::table('wcert')
        ->orderBy('sno', 'asc')
        ->take(30)
        ->get();


        // $w_cert = DB::table('wcert')
        
        
        // ->orderBy('sno', 'asc')
        // ->get();

     return view('user_login.license_datechange.previous_licence_date_change', compact('s_cert', 'w_cert'));

    }


    public function getExpiry(Request $request)
{

// dd($request->all());
// exit;
    $table = $request->type === 'S' ? 'scert' : 'wcert';

    $data = DB::table($table)
        ->where('certno', $request->certno)
        ->first();

    return response()->json([
        'vdate' => $data->vdate ?? null
    ]);
}

public function updateExpiry(Request $request)
{
    $table = $request->type === 'S' ? 'scert' : 'wcert';

    DB::table($table)
        ->where('certno', $request->certno)
        ->update([
            'vdate' => $request->vdate
        ]);

    return response()->json(['status' => 'success']);
}

}
