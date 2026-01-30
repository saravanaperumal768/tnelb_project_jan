<?php

namespace App\Http\Controllers;

use App\Models\Mst_Form_s_w;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Colors\Rgb\Channels\Red;

use Carbon\Carbon;

use Illuminate\Support\Str;

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

        if ($query == true) {
            if(!empty($request->type)){
                if ($request->type == "License") {
                    Mst_Form_s_w::where('application_id', $request->application_id)
                    ->update(['adminLverify' => 1]);
                }else{
                    Mst_Form_s_w::where('application_id', $request->application_id)
                    ->update(['adminCverify' => 1]);
                }
            }
        }else {
            if(!empty($request->type)){
                if ($request->type == "License") {
                    Mst_Form_s_w::where('application_id', $request->application_id)
                    ->update(['adminLverify' => 2]);
                }else{
                    Mst_Form_s_w::where('application_id', $request->application_id)
                    ->update(['adminCverify' => 2]);
                }
            }
        }

        return response()->json(['exists' => $query]);
    }



    public function verifylicenseformAcc(Request $request)
    {
        $request->validate([
            'license_number' => 'required|string|max:12',
            'date' => 'required|date',
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
            'date' => 'required|date',
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





    // --------------formA verifylicense------------------------

    public function verifylicenseformAccc(Request $request)
    {
        $input = $request->all();

        // Convert dd-mm-yyyy to Y-m-d BEFORE validation
        if (!empty($input['date'])) {
            try {
                $input['date'] = Carbon::createFromFormat('d-m-Y', $input['date'])->format('Y-m-d');
            } catch (\Exception $e) {
            }
        }

        // Use manual validator instead of $request->validate()
        $validator = Validator::make($input, [
            'license_number' => 'required|string|max:50',
            'date' => 'required|date',
        ], [
            'date.before' => 'Enter the valid date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Use sanitized $input
        $licenseNumber = $input['license_number'];
        $date = $input['date'];



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

    // ---------------------------------------------Admin panel check license ----------------------

    // ----------------------Admin Panel CC check----------------------------
  public function verifyLicenseFormAccc_adminstaff(Request $request)
{


    $request->validate([
        'license_number' => 'required|string|max:15',
        'date' => 'required|date_format:d-m-Y',
    ], [
        'date.date_format' => 'Enter the valid date in DD-MM-YYYY format'
    ]);

    // Get input
    $inputLicense = strtoupper(trim($request->license_number));
    $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

    // Preserve original for DB match
    $original = $inputLicense;

    // Remove prefix (C, B, H, WH) to check stripped version also
    $stripped = preg_replace('/^(C|B|H|WH)/i', '', $inputLicense);

    // Main queries
    $query1 = DB::table('wcert')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

    $query2 = DB::table('whcert')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

    $query3 = DB::table('scert')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

    $query4 = DB::table('tnelb_license')
        ->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");

    // Merge and search using both original and stripped versions
    $exists = DB::query()
        ->fromSub(
            $query1->unionAll($query2)->unionAll($query3)->unionAll($query4),
            'all_licenses'
        )
        ->whereIn('license_number', [$original, $stripped])   // check both
        ->whereDate('expires_at', $date)
        ->exists();

    return response()->json([
        'exists' => $exists
    ]);
}


// -----------------------history-------------------------------
public function history_resultstaff(Request $request)
{
    $request->validate([
        'license_number' => 'required|string|max:15',
        'date' => 'required|date_format:d-m-Y',
    ], [
        'date.date_format' => 'Enter the valid date in DD-MM-YYYY format'
    ]);

    // Get license and date
    $license = $request->license_number;

    // Remove prefixes (C, B, H, WH)
    // $license = preg_replace('/^(C|B|H|WH)/i', '', $licenseNumber);

    // Convert date format to Y-m-d
    $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
// dd($date);
// exit;
    $history = DB::table('tnelb_applicant_cl_staffdetails as s')
        ->leftJoin('tnelb_ea_applications as a', 's.application_id', '=', 'a.application_id')
        ->where('s.cc_number', $license)
        // ->where('s.cc_validity', $date)
        ->where('a.application_status', 'A')
        ->get();

    if ($history->count() == 0) {
        return response()->json(['exists' => false]);
    }

    $html ='' ;
    foreach ($history as $h) {
        $licenseData = DB::table('tnelb_license')
            ->where('application_id', $h->application_id)
            ->first();

        $renewalData = DB::table('tnelb_renewal_license')
            ->where('application_id', $h->application_id)
            ->first();

        $final = $licenseData ?? $renewalData;
        if ($final) {
            $expiry = \Carbon\Carbon::parse($final->expires_at)->format('d-m-Y');
            $issued_at = \Carbon\Carbon::parse($final->issued_at)->format('d-m-Y');
            $active = \Carbon\Carbon::parse($final->expires_at)->isFuture() ? 
                '<span class="fw-bold text-success">Active</span>' : 
                '<span class="fw-bold text-danger">Expired</span>';

           $html .= "<tr>
                <td class='text-center'>{$final->license_number}</td>
                <td class='text-center'>{$issued_at}</td>
                <td class='text-center'>{$expiry}</td>
                <td class='text-center'>{$active}</td>
            </tr>";

        } else {
            $html .= "<li><span class='text-muted'>No license record found.</span></li>";
        }
    }
    $html .= '';

    return response()->json(['exists' => true, 'html' => $html]);
}





    //    --------------------Admin Panel EA Check --------------------------------------------------
  public function verifylicenseformAea_admin(Request $request)
{
    
    $input = $request->all();

    // Convert dd-mm-yyyy to Y-m-d before validation
    if (!empty($input['date'])) {
        try {
            $input['date'] = Carbon::createFromFormat('d-m-Y', $input['date'])->format('Y-m-d');
        } catch (\Exception $e) {
        }
    }

   

    // Validate the converted input
    $validator = Validator::make($input, [
        'license_number' => 'required|string|max:50',
        'date' => 'required|date',
    ], [
        'date.before' => 'Enter a valid date'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $licenseNumber = strtoupper(trim($input['license_number']));
    $date = $input['date']; // Already in Y-m-d format

// dd($licenseNumber);
// exit;

    // Handle prefixes
    if (Str::startsWith($licenseNumber, ['C','B','H','WH'])) {
        $licenseNumber = preg_replace('/^(C|B|H|WH)/', '', $licenseNumber);
    } elseif (Str::startsWith($licenseNumber,['EA','ESA','ESB','EB'])) {
        $licenseNumber = preg_replace('/^(EA|ESB|EB|ESA)/', '', $licenseNumber);
    } elseif (Str::startsWith($licenseNumber, 'L')) {
        // keep as is (allowed)
    }

    // Build queries
    $query1 = DB::table('ealicense')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

    $query2 = DB::table('esalicense')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

    $query3 = DB::table('esblicense')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

    $query4 = DB::table('tnelb_license')
        ->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");

    $query5 = DB::table('eblicense')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

    $exists = DB::query()
        ->fromSub(
            $query1->unionAll($query2)->unionAll($query3)->unionAll($query4)->unionAll($query5),
            'all_licenses'
        )
        ->where('license_number', (string) $licenseNumber)
        ->whereDate('expires_at', $date)
        ->exists();

    return response()->json([
        'exists' => $exists
    ]);
}






    // ----------------------Admin Panel CC check----------------------------

  public function verifyLicenseFormAccc_admin(Request $request)
{
    $request->validate([
        'license_number' => 'required|string|max:15',
        'date' => 'required|date_format:d-m-Y',
    ], [
        'date.date_format' => 'Enter the valid date in DD-MM-YYYY format'
    ]);

    // Get license and date
    $licenseNumber = $request->license_number;

    // Remove prefixes (C, B, H, WH)
    $licenseNumber = preg_replace('/^(C|B|H|WH)/i', '', $licenseNumber);

    // Convert date format to Y-m-d
    $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

    // Queries
    $query1 = DB::table('wcert')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
    $query2 = DB::table('whcert')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
    $query3 = DB::table('scert')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
    $query4 = DB::table('tnelb_license')
        ->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");

    // Union all queries
    $exists = DB::query()
        ->fromSub(
            $query1->unionAll($query2)->unionAll($query3)->unionAll($query4),
            'all_licenses'
        )
        ->where('license_number', $licenseNumber) // stripped license
        ->whereDate('expires_at', $date)
        ->exists();

    return response()->json([
        'exists' => $exists
    ]);
}




    // ---------------S cert---------------------------

   public function verifylicensecc_slicense(Request $request)
{
    $request->validate([
        'license_number' => 'required|string|max:50',
        'date' => 'required|date',
    ], [
        'date.before' => 'Enter the valid date'
    ]);

    $licenseNumber = trim($request->license_number);

    // 🔥 If license starts with C202 → convert to LC202
    if (str_starts_with($licenseNumber, 'C202')) {
        $licenseNumber = 'L' . $licenseNumber;  // C202*** → LC202***
    }

    $date = $request->date;

    // Build union table
    $querySCERT = DB::table('scert')
        ->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

    $queryTNELB = DB::table('tnelb_license')
        ->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");

    $exists = DB::query()
        ->fromSub(
            $querySCERT->unionAll($queryTNELB),
            'all_licenses'
        )
        ->where('license_number', $licenseNumber)
        ->whereDate('expires_at', $date)
        ->exists();

    return response()->json([
        'exists' => $exists
    ]);
}

    // -----------------------------------



    public function verifylicenseformAea_appl(Request $request)
    {
        $input = $request->all();

        // Convert dd-mm-yyyy to Y-m-d before validation
        if (!empty($input['date'])) {
            try {
                $input['date'] = Carbon::createFromFormat('d-m-Y', $input['date'])->format('Y-m-d');
            } catch (\Exception $e) {
            }
        }

        // Validate the converted input
        $validator = Validator::make($input, [
            'license_number' => 'required|string|max:50',
            'date' => 'required|date',
        ], [
            'date.before' => 'Enter a valid date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $licenseNumber = $input['license_number'];
        $date = $input['date']; // Already in Y-m-d format

        $query1 = DB::table('ealicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
        $query4 = DB::table('tnelb_license')->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");

        $query3 = DB::table('esblicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $query2 = DB::table('eblicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $query5 = DB::table('esalicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $exists = DB::query()
            ->fromSub(
                $query1->unionAll($query4)->unionAll($query3)->unionAll($query2)->unionAll($query5),
                'all_licenses'
            )
            ->where('license_number', (string) $licenseNumber)
            ->whereDate('expires_at', $date)
            ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    // ---------------------------------------------------------------------

    // -----------verifysblicence-----------------

    public function verifylicenseformsb_appl(Request $request)
    {

      
        $input = $request->all();

        // Convert dd-mm-yyyy to Y-m-d before validation
        if (!empty($input['date'])) {
            try {
                $input['date'] = Carbon::createFromFormat('d-m-Y', $input['date'])->format('Y-m-d');
            } catch (\Exception $e) {
            }
        }

        // Validate the converted input
        $validator = Validator::make($input, [
            'license_number' => 'required|string|max:50',
            'date' => 'required|date',
        ], [
            'date.before' => 'Enter a valid date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $licenseNumber = $input['license_number'];
        $date = $input['date']; // Already in Y-m-d format

        $query1 = DB::table('esblicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
        $query4 = DB::table('tnelb_license')->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");
        
       $query3 = DB::table('ealicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $query2 = DB::table('eblicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $query5 = DB::table('esalicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

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


     // -----------verifysalicence-----------------

    public function verifylicenseformsa_appl(Request $request)
    {
// dd($request->all());
// exit;
      
        $input = $request->all();

        // Convert dd-mm-yyyy to Y-m-d before validation
        if (!empty($input['date'])) {
            try {
                $input['date'] = Carbon::createFromFormat('d-m-Y', $input['date'])->format('Y-m-d');
            } catch (\Exception $e) {
            }
        }

        // Validate the converted input
        $validator = Validator::make($input, [
            'license_number' => 'required|string|max:50',
            'date' => 'required|date',
        ], [
            'date.before' => 'Enter a valid date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $licenseNumber = $input['license_number'];
        $date = $input['date']; // Already in Y-m-d format

        $query1 = DB::table('esalicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
        $query4 = DB::table('tnelb_license')->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");
        
       $query3 = DB::table('ealicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $query2 = DB::table('eblicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $query5 = DB::table('esblicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

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

      // -----------verifyeblicence-----------------

    public function verifylicenseformeb_appl(Request $request)
    {

      
        $input = $request->all();

        // Convert dd-mm-yyyy to Y-m-d before validation
        if (!empty($input['date'])) {
            try {
                $input['date'] = Carbon::createFromFormat('d-m-Y', $input['date'])->format('Y-m-d');
            } catch (\Exception $e) {
            }
        }

        // Validate the converted input
        $validator = Validator::make($input, [
            'license_number' => 'required|string|max:50',
            'date' => 'required|date',
        ], [
            'date.before' => 'Enter a valid date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $licenseNumber = $input['license_number'];
        $date = $input['date']; // Already in Y-m-d format

        $query1 = DB::table('eblicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
        $query4 = DB::table('tnelb_license')->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");
        
       $query3 = DB::table('ealicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $query2 = DB::table('esalicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

        $query5 = DB::table('esblicense')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");

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

    // QC DOB check--------------------
    public function checkLcAge(Request $request)
{
    $cc = $request->cc_number;

    // Step 1: Find application from tnelb_license using lc number
    $license = DB::table('tnelb_license')->where('license_number', $cc)->first()??
       DB::table('tnelb_renewal_license')->where('license_number', $cc)->first();

    if (!$license) {
        return response()->json(['status' => 'not_found']);
    }

    // Step 2: Get d_o_b from tnelb_application_tbl using application_id
    $applicant = DB::table('tnelb_application_tbl')
        ->where('application_id', $license->application_id)
        ->first();

        // dd($applicant->d_o_b);
        // exit;

    if (!$applicant || !$applicant->d_o_b) {
        return response()->json(['status' => 'not_found']);
    }

    // Step 3: Age calculation
    $dob = \Carbon\Carbon::parse($applicant->d_o_b);
    $age = $dob->diffInYears(now());

    if ($age > 75) {
        return response()->json(['status' => 'age_above_limit']);
    }

    return response()->json(['status' => 'ok']);
}


// ----------atleast one year validity--------------

// --------checkvalidity_ea-----------------------

public function checkCertificateValidity(Request $request)
{
    // dd($request->all());
    // exit;
    $l_number = $request->l_number;
    $validity_date = $request->validity_date;

    $cert_order = $request->cert_order;

      $result = DB::selectOne(
        "SELECT * FROM check_certificate_validity_ea(:l_number, :validity_date, :cert_order)",
        [
            'l_number'      => $request->l_number,
            'validity_date' => $request->validity_date,
            'cert_order'    => (int) $request->cert_order,
        ]
    );

    return response()->json([
        'status' => $result->status,
        'msg' => $result->message,
        'form_name' => $result-> result_license_name
    ]);
}
// tnelb_applicant_cl_staffdetails tnelb_applicant_cl_staffdetails

// --------------------------------------------------------

// b certificate check------------------
public function checkCertificateValidity_b(Request $request)
{
    // dd($request->all());
    // exit;
    $l_number = $request->l_number;
    $validity_date = $request->validity_date;

    $cert_order = $request->cert_order;

      $result = DB::selectOne(
        "SELECT * FROM check_certificate_validity_eb(:l_number, :validity_date, :cert_order)",
        [
            'l_number'      => $request->l_number,
            'validity_date' => $request->validity_date,
            'cert_order'    => (int) $request->cert_order,
        ]
    );

    return response()->json([
        'status' => $result->status,
        'msg' => $result->message,
        'form_name' => $result-> result_license_name
    ]);
}
// ----------------------------------------------------------------------

public function checkBankValidity(Request $request)
{
    $bankValidity = $request->bank_validity;

    // ---------------------------
    // BASIC VALIDATION
    // ---------------------------
    if (!$bankValidity) {
        return response()->json([
            'status' => 'invalid_bank',
            'msg'    => 'Bank Validity date is required.'
        ]);
    }

    try {
        $validityDate = Carbon::parse($bankValidity)->startOfDay();
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'invalid_bank',
            'msg'    => 'Invalid Bank Validity date.'
        ]);
    }

    $today = Carbon::today();

    // ---------------------------
    // MUST BE GREATER THAN TODAY
    // ---------------------------
    if ($validityDate->lte($today)) {
        return response()->json([
            'status' => 'invalid_bank',
            'msg'    => 'Bank Validity must be a future date.'
        ]);
    }

    // ---------------------------
    // MUST HAVE AT LEAST 1 YEAR
    // ---------------------------
    if ($validityDate->lt($today->copy()->addYear())) {
        return response()->json([
            'status' => 'invalid_bank',
            'msg'    => 'Minimum 1 year required for Bank Solvency Validity Period.'
        ]);
    }

    // ---------------------------
    // VALID
    // ---------------------------
    return response()->json([
        'status' => 'valid',
        'msg'    => 'Bank Validity is valid.'
    ]);
}




// --------------------------

public function checkCertificateValidity_ea_a(Request $request)
{
// dd($request->all());
// exit;



    $licenseNumber = trim($request->l_number);


    // $originalLicense = $licenseNumber;

// ✅ Extract numeric part for DB comparison


    $validityDate  = $request->validity_date;
    $order         = (int) $request->cert_order; // 1,2,3...

    $isFirst = ($order === 1);

    // dd($licenseNumber);
    // exit;

    // -------------------------------
    // BASIC VALIDATION
    // -------------------------------
    if (!$licenseNumber) {
        return response()->json([
            'status' => 'invalid_license',
            'msg' => 'Certificate number is required.'
        ]);
    }

    // -------------------------------
    // FIRST CERTIFICATE RULE
    // -------------------------------
    if ($isFirst && !preg_match('/^C\d+$/i', $licenseNumber)) {
        return response()->json([
            'status' => 'invalid_license',
            'msg' => 'First certificate must be a valid C Certificate.'
        ]);
    }
    $licenseNumber = preg_replace('/[^0-9]/', '', $licenseNumber);

    // Normalize non-first
    if (!$isFirst) {
        $licenseNumber = preg_replace('/[^0-9]/', '', $licenseNumber);
    }

    // -------------------------------
    // CHECK FROM TABLES
    // -------------------------------
    $query1 = DB::table('wcert')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
    $query2 = DB::table('whcert')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
    $query3 = DB::table('scert')->selectRaw("CAST(certno AS VARCHAR) AS license_number, vdate AS expires_at");
    $query4 = DB::table('tnelb_license')->selectRaw("CAST(license_number AS VARCHAR) AS license_number, expires_at");

    $license = DB::query()
        ->fromSub(
            $query1->unionAll($query2)->unionAll($query3)->unionAll($query4),
            'all_licenses'
        )
        ->where('license_number', $licenseNumber)
        ->first();

    if (!$license) {
        return response()->json([
            'status' => 'invalid_license',
            'msg' => 'Invalid certificate number or date.'
        ]);
    }

    // -------------------------------
    // DATE MATCH CHECK (ALL ROWS)
    // -------------------------------
    // if ($validityDate) {
    //     $entered = Carbon::parse($validityDate)->startOfDay();
    //     $dbDate  = Carbon::parse($license->expires_at)->startOfDay();

    //     if (!$entered->equalTo($dbDate)) {
    //         return response()->json([
    //             'status' => 'invalid_license',
    //             'msg' => 'Invalid certificate or validity date.'
    //         ]);
    //     }
    // }

    // -------------------------------
    // FIRST CERTIFICATE → 1 YEAR RULE
    // -------------------------------
    if ($isFirst) {
        // dd('11111');
        // exit;
        $dbDate  = Carbon::parse($validityDate);
        // dd($dbDate);
        // exit;
        $today = Carbon::today();
        if ($dbDate->lt($today->copy()->addYear())) {
            return response()->json([
                'status' => 'less_than_one_year',
                'msg' => 'Validity must be at least 1 year from today.'
            ]);
        }
    }

    return response()->json([
        'status' => 'valid'
    ]);
}

public function check_ealicence_validity_bk(Request $request)
{

// dd($request->all());
// exit;
    try {

    $firstCertNo = $request->firstCertNo;
    $qc_validity_date = $request->qc_validity_date;
    $bank_validity = $request->bank_validity;
    $appl_type = $request->appl_type;
    $form_name = $request->form_name;


        $qc_validity_date = $request->qc_validity_date;  
        $bank_validity    = $request->bank_validity;      

        $result = DB::selectOne(
           "SELECT * FROM check_ealicence_validity(:form_name, :firstCertNo, :qc_validity_date, :bank_validity, appl_type)",
            [
                'firstCertNo'   => $request->firstCertNo,
                'qc_validity_date'   => $request->qc_validity_date,
                'bank_validity' => $request->bank_validity,
                'appl_type'     => $request->appl_type,
                'form_code' => $request->form_name
            ]
        );

        return response()->json([
            'status'    => $result->status,                // OK / WARNING
            'msg'       => $result->message,               // warning text
            'form_name' => $result->result_license_name
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'msg'    => 'Validity check failed'
        ], 500);
    }
}


public function check_ealicence_validity(Request $request)
{
//     dd($request->all());
// exit;
    try {

        $result = DB::selectOne(
            "SELECT * FROM check_ealicence_validity(
                :form_code,
                :licence_no,
                :qc_validity,
                :bank_validity,
                :appl_type
            )",
            [
                'form_code'     => $request->form_name,
                'licence_no'    => $request->firstCertNo,
                'qc_validity'   => $request->qc_validity_date,
                'bank_validity' => $request->bank_validity,
                'appl_type'     => $request->appl_type,
            ]
        );

        return response()->json([
            'status'         => $result->status,
            'message'        => $result->based_on,
            'renewal_period' => $result->renewal_period,
            'licence_validitydate' => $result->licence_validitydate
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'message' => $e->getMessage()
        ], 500);
    }
}


}
