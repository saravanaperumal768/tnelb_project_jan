<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\ApplicationModel;
use App\Models\Admin\FormaModel;
use App\Models\Admin\UserModel;
use App\Models\Mst_Form_s_w;
use App\Models\TnelbApplicantPhoto;
use PharIo\Manifest\License;

class LicenseController extends Controller
{
    public function index()
    {
        return view('previous_licenses');
    }

    public function verifylicense(Request $request)
    {


        $request->validate([
            'license_number' => 'required|string',
            'date' => 'required|date',
        ], [
            'date' => 'Enter the valid date'
        ]);

        $licenseNumber = $request->license_number;

        // ✅ Split letters and numbers
        if (preg_match('/^([A-Za-z]+)(\d+)$/', $licenseNumber, $matches)) {
            $licensePrefix = strtoupper($matches[1]); // W, WH, S
            $licenseNum    = $matches[2];             // 87810
        } else {
            return response()->json(['exists' => false]);
        }

        // ✅ Determine table dynamically
        $tableMap = [
            'B'  => 'wcert',
            'H' => 'whcert',
            'C'  => 'scert'
        ];


        $table = $tableMap[$licensePrefix] ?? 'tnelb_license';

        if($table == 'tnelb_license'){
            $licenseNum = $licenseNumber;
            $column_name = 'license_number';
        }


        // ✅ Correct column names for each table
        $query = DB::table($table)
        ->selectRaw($table === 'tnelb_license'
            ? "CAST(license_number AS VARCHAR) AS license_number, expires_at"
            : "CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at"
        )
        ->where($column_name ?? 'certno', $licenseNum) // or license_number for tnelb_license
        ->whereDate($table === 'tnelb_license' ? 'expires_at' : 'vdate', $request->date)
        ->exists();

        // if ($query == true) {
        //     if(!empty($request->type)){
        //         if ($request->type == "License") {
        //             Mst_Form_s_w::where('application_id', $request->application_id)
        //             ->update(['adminLverify' => 1]);
        //         }else{
        //             Mst_Form_s_w::where('application_id', $request->application_id)
        //             ->update(['adminCverify' => 1]);
        //         }
        //     }
        // }else {
        //     if(!empty($request->type)){
        //         if ($request->type == "License") {
        //             Mst_Form_s_w::where('application_id', $request->application_id)
        //             ->update(['adminLverify' => 2]);
        //         }else{
        //             Mst_Form_s_w::where('application_id', $request->application_id)
        //             ->update(['adminCverify' => 2]);
        //         }
        //     }
        // }

        return response()->json(['exists' => $query]);
    }


    
    public function verifylicenseformAcc(Request $request)
    {
      
        $request->validate([
            'license_number' => 'required|string|max:12',
            'date' => 'required|date|before:today',
        ], [
            'date.before' => 'Enter the valid date'
        ]);

        $licenseNumber = $request->license_number;

        $date = $request->date;

        $query1 = DB::table('wcert')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
        $query2 = DB::table('whcert')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
        $query3 = DB::table('scert')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
        $query4 = DB::table('tnelb_license')->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");

        $exists = DB::query()
            ->fromSub(
                $query1
                    ->unionAll($query2)
                    ->unionAll($query3)
                    ->unionAll($query4),
                'all_licenses'
            )
            ->where('license_number', (string) $licenseNumber)
            ->whereDate('expires_at', $date)
            ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }



   public function verifylicenseformAea(Request $request)
{
    $request->validate([
        'license_number' => 'required|string|max:50',
        'date' => 'required|date|before:today',
    ], [
        'date.before' => 'Enter a valid date'
    ]);

    $licenseNumber = $request->license_number;
    $date = $request->date;

    $query1 = DB::table('ealicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
    $query4 = DB::table('tnelb_license')->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");

    $exists = DB::query()
        ->fromSub(
            $query1->unionAll($query4),
            'all_licenses'
        )
        ->where('license_number', (string) $licenseNumber)
        ->whereDate('expires_at', $date)
        ->exists();

    return response()->json([
        'exists' => $exists
    ]);
}
}
