<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function checkStaffExists(Request $request)
{
    // dd('111');
    // exit;
    $cc_number = $request->cc_number;
    // $cc_validity = $request->cc_validity;

    // dd($cc_number);
    // dd($cc_validity);
    // exit;

    $exists = DB::table('tnelb_applicant_cl_staffdetails as s')
        ->join('tnelb_license as l', 's.application_id', '=', 'l.application_id')
        ->leftJoin('tnelb_renewal_license as rl', 's.application_id', '=', 'rl.application_id')
        ->where('s.cc_number', $cc_number)
        // ->where('s.cc_validity', $cc_validity)
        // ->where(function($query) {
        //     $query->whereNotNull('l.expires_at')
        //           ->orWhereNotNull('rl.expires_at');
        // })
        ->exists();

    return response()->json(['exists' => $exists]);
}
}
