<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Models\Admin\SupervisorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Helpers\RoleHelper;
use App\Models\Mst_Form_s_w;

use App\Models\EA_Application_model;

use App\Models\Admin\WorkflowA;
use App\Models\ESA_Application_model;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class SupervisorController extends Controller
{
    public function index()
    {
        $userFormID = Auth::user()->form_id;
        $applications = DB::table('tnelb_application_tbl')
            ->where('form_id', $userFormID)
            ->select('*')
            ->get();

        return view('admin.dashboards.supervisor', compact('applications'));
    }

    public function view_applications()
    {
        $userRole = Auth::user()->roles_id; // Supervisor Role ID

        $workflows = DB::table('tnelb_application_tbl as ta')
            ->leftJoin('tnelb_forms as f', 'ta.form_id', '=', 'f.id') // Join forms table
            ->where('ta.form_name', 'Form S') // Filter by Form S
            ->where('ta.status', 'P') // Only show new applications
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tnelb_workflow as tw')
                    ->whereRaw('tw.application_id = ta.application_id'); // Ensure it's NOT in workflow yet
            })
            ->select('ta.*', 'f.form_name')
            ->distinct()
            ->get();


        return view('admin.supervisor.recentapply', compact('workflows'));
    }

    public function view_auditor()
    {
        $userRole = Auth::user()->roles_id; // Auditor's Role ID (2)

        $workflows = DB::table('tnelb_application_tbl as ta')
            ->join('tnelb_workflow as tw', 'ta.application_id', '=', 'tw.application_id') // Ensure it's processed
            ->join('tnelb_forms as f', 'ta.form_id', '=', 'f.id') // Join forms table
            ->where('tw.forwarded_to', $userRole) // Assigned to Auditor
            ->where('tw.appl_status', 'F') // Status must be Forwarded
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tnelb_workflow as sub_tw')
                    ->whereRaw('sub_tw.application_id = ta.application_id')
                    ->whereRaw('sub_tw.role_id != tw.forwarded_to'); // Ensure it's processed by someone else
            })
            ->select('ta.*', 'f.form_name')
            ->distinct()
            ->get();

        return view('admin.supervisor.recentapply', compact('workflows'));
    }



    public function get_completed()
    {

        $userRole = Auth::user()->roles_id; // Get logged-in user's role
        $assignedFormID = Auth::user()->form_id;


        $workflows = DB::table('tnelb_application_tbl')
            ->where('form_id', $assignedFormID) // Filter by Form S
            ->whereIn('status', ['F', 'A', 'RF']) // Only show new applications
            ->whereIn('processed_by', ['S', 'A', 'SE', 'PR']) // Only show new applications
            ->select('*')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.supervisor.completed', compact('workflows'));
    }
    public function get_completed_wh()
    {

        $userRole = Auth::user()->roles_id; // Get logged-in user's role
        $assignedFormID = 3;


        $workflows = DB::table('tnelb_application_tbl')
            ->where('form_id', $assignedFormID) // Filter by Form S
            ->whereIn('status', ['F', 'A', 'RF']) // Only show new applications
            ->whereIn('processed_by', ['S2', 'A', 'SE', 'PR']) // Only show new applications
            ->select('*')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.supervisor.completed', compact('workflows'));
    }


    /*
    * Get the FORM A applications
    */
    public function view_forma($type)
    {
        $userRole = Auth::user()->roles_id;

        $assignedForms = DB::table('tnelb_ea_applications as ta')
            ->whereIn('ta.application_status', ['P', 'RE']) // Filter by status
            ->select('ta.*') // Select all columns from applicant_formA
            ->get();


        // var_dump($assignedForms);die;

        $workflows = DB::table('tnelb_ea_applications')
            ->whereIn('application_status', ['P', 'RE'])
            ->where('payment_status', 'paid')
            ->orderBy('updated_at', 'DESC')
            ->select('*')
            ->get();


        $pendinglist_sa = DB::table('tnelb_esa_applications')
            ->whereIn('application_status', ['P', 'RE'])
            ->where('payment_status', 'paid')
            ->orderBy('updated_at', 'DESC')
            ->select('*')
            ->get();

            if (strtoupper($type) === 'SA') {
                    return view('admin.supervisor.formsa.view_formsa', compact('pendinglist_sa'));
                } else {
                    return view('admin.supervisor.view_forma', compact('workflows'));
                }

        // return view('admin.supervisor.view_forma', compact('workflows'));
    }

    public function completed_forma()
    {
        $userRole = Auth::user()->roles_id;

        // $assignedForms = DB::table('tnelb_ea_applications as ta')
        // ->whereIn('ta.application_status', ['F', 'RF','A']) // Filter by status
        // ->select('ta.*') // Select all columns from applicant_formA
        // ->get();


        // var_dump($assignedForms);die;

        $workflows = DB::table('tnelb_ea_applications')
            ->whereIn('application_status', ['F', 'RF', 'A'])
            ->orderby('updated_at', 'DESC')
            ->select('*')
            ->get();

        $applicationIds = $workflows->pluck('application_id');

    
            $licenses = DB::table('tnelb_license')
                ->whereIn('application_id', $applicationIds)
                ->select('application_id', 'license_number')
                ->get()
                ->keyBy('application_id');

            $renewalLicenses = DB::table('tnelb_renewal_license')
                ->whereIn('application_id', $applicationIds)
                ->select('application_id', 'license_number')
                ->get()
                ->keyBy('application_id');

            return view('admin.supervisor.completed_forma', compact(
                'workflows',
                'licenses',
                'renewalLicenses'
            ));
    }


    public function forwardApplication(Request $request, $role)
    {

        // var_dump($role);die;


        $staff = Auth::user();

        $staffID = Auth::user()->id;

        $request->validate([
            'application_id' => 'required|string',
            'processed_by'   => 'required|string',
            'forwarded_to'   => 'required|string',
            'role_id'        => 'required|integer',
            'checkboxes'     => 'nullable|string',
            'queryswitch'    => 'nullable|string',
            'queryType'      => 'array',
            'remarks'        => 'nullable|string'
        ]);


        $applicant = Mst_Form_s_w::where('application_id', $request->application_id)
            ->select('*')
            ->first();



        $queryTypeJson = $request->queryType && is_array($request->queryType) && count($request->queryType) > 0
            ? json_encode($request->queryType) : null;

        $processed_by = match ($staff->name) {
            'President'   => 'PR',
            'Secretary'   => 'SE',
            'Supervisor'  => 'S',
            'Supervisor2' => 'S2',
            'Accountant'     => 'A',
            default       => abort(403, 'Unauthorized'),
        };

        $query_status = ($request->queryswitch === 'Yes') ? 'P' : null;
        $raised_by    = ($request->queryswitch === 'Yes') ? $processed_by : $staffID;


        if ($processed_by == 'A') {
            $last_workflow = SupervisorModel::where('application_id', $request->application_id)
                ->orderBy('id', 'desc')   // latest entry first
                ->first();

            $query_status = $last_workflow->query_status == 'P' ? 'P' : '';
            if ($last_workflow->query_status == 'P') {
                $query_status = 'P';
                $queryTypeJson = $last_workflow->queries;
            }
        }




        // DB::table('tnelb_query_applicable')->insert([
        //     'application_id' => $request->application_id,
        //     'query_type'     => $queryTypeJson,
        //     'raised_by'      => $raised_by,
        //     'query_status'   => $query_status,
        //     'created_at'     => now(),
        // ]);


        $formType = DB::table('tnelb_application_tbl')
            ->where('application_id', $request->application_id)
            ->select('form_id')
            ->first();



        $status = match ($staff->name) {
            'President' => 'A',
            'Secretary'  => $formType->form_id == 1 ? 'F' : 'A',
            'Supervisor' => $applicant->status == 'RE' ? 'RF' : 'F',
            'Supervisor2' => $applicant->status == 'RE' ? 'RF' : 'F',
            'Accountant'    => 'F',
            default      => abort(403, 'Unauthorized'),
        };


        // Insert data into tnelb_workflow table
        $workflow = SupervisorModel::create([ // Ensure this is the correct model
            'application_id' => $request->application_id,
            'appl_status'    => $applicant->status == 'RE' ? 'RF' : 'F', // Forwarded
            'processed_by'   => $request->processed_by,
            'forwarded_to'   => $request->forwarded_to,
            'role_id'        => $request->role_id,
            'is_verified'    => $request->checkboxes ?? 'Yes',
            'query_status'   => $query_status,
            // "Yes" or "No"
            'remarks'        => $request->remarks,
            'created_at'     => now(), // Automatically managed if model has timestamps
            'login_id'       => $staffID,
            'queries'        => $queryTypeJson,
            'raised_by'      => $query_status == 'P' ? $raised_by : '',
        ]);



        // Update application status
        Mst_Form_s_w::where('application_id', $request->application_id)
            ->update([
                'status'        => $status, // Role-based forwarding
                'processed_by'  => $processed_by, // Role-based forwarding
                'updated_at' => now(),
            ]);

        return response()->json([
            'status' => "success",
            'message' => "Application Forwarded to $role successfully!",
        ], 201);
    }

    // Forwarded for application  FORM A



    public function forwardApplicationforma(Request $request, $role)
    {

        // var_dump($request->all());die;

        $staff = Auth::user();

        $staffID = Auth::user()->id;

        $request->validate([
            'application_id' => 'required|string',
            'processed_by'   => 'required|string',
            'forwarded_to'   => 'required|string',
            'role_id'        => 'required|integer',
            'checkboxes'     => 'nullable|string',
            'queryswitch'    => 'nullable|string',
            'queryType'      => 'array',
            'remarks'        => 'nullable|string'
        ]);


        $applicant = EA_Application_model::where('application_id', $request->application_id)
            ->select('*')
          
            ->first();

         



        $queryTypeJson = $request->queryType && is_array($request->queryType) && count($request->queryType) > 0
            ? json_encode($request->queryType) : null;

        if ($request->application_status === 'RE') {
            $processed_by = match ($staff->name) {
                'President'   => 'PR',
                'Secretary'   => 'SE',
                'Supervisor'  => 'SPRE',
                'Supervisor2' => 'S2',
                'Accountant'     => 'A',
                default       => abort(403, 'Unauthorized'),
            };
        } else {
            $processed_by = match ($staff->name) {
                'President'   => 'PR',
                'Secretary'   => 'SE',
                'Supervisor'  => 'S',
                'Supervisor2' => 'S2',
                'Accountant'     => 'A',
                default       => abort(403, 'Unauthorized'),
            };
        }


        $query_status = ($request->queryswitch === 'Yes') ? 'P' : null;
        $raised_by    = ($request->queryswitch === 'Yes') ? $processed_by : $staffID;


        if ($processed_by == 'A') {
            $last_workflow = WorkflowA::where('application_id', $request->application_id)
                ->orderBy('id', 'desc')   // latest entry first
                ->first();

            $query_status = $last_workflow->query_status == 'P' ? 'P' : '';
            if ($last_workflow->query_status == 'P') {
                $query_status = 'P';
                $queryTypeJson = $last_workflow->queries;
            }
        }




        // DB::table('tnelb_query_applicable')->insert([
        //     'application_id' => $request->application_id,
        //     'query_type'     => $queryTypeJson,
        //     'raised_by'      => $raised_by,
        //     'query_status'   => $query_status,
        //     'created_at'     => now(),
        // ]);


        // $formType = DB::table('tnelb_ea_applications')
        //     ->where('application_id', $request->application_id)
        //     ->select('form_id')
        //     ->first();



        $status = match ($staff->name) {
            'President' => 'A',
            // 'Secretary'  => $formType->form_id == 1 ? 'F' : 'A',
            'Secretary' => $applicant->status == 'RE' ? 'RF' : 'F',
            'Supervisor' => $applicant->status == 'RE' ? 'RF' : 'F',
            'Supervisor2' => $applicant->status == 'RE' ? 'RF' : 'F',
            'Accountant'    => 'F',
            default      => abort(403, 'Unauthorized'),
        };

        // dd($request->queryswitch);

        // die;

        // Insert data into tnelb_workflow table
          $workflow = WorkflowA::create([ // Ensure this is the correct model
            'application_id' => $request->application_id,
            'appl_status'    => $applicant->status == 'RE' ? 'RF' : 'F', // Forwarded
            'processed_by'   => $request->processed_by,
            'forwarded_to'   => $request->forwarded_to,
            'role_id'        => $request->role_id,
            'is_verified'    => $request->checkboxes ?? 'Yes',
            'query_status'   => $query_status,
            // "Yes" or "No"
            'remarks'        => $request->remarks,
            'created_at'     => now(), // Automatically managed if model has timestamps
            'login_id'       => $staffID,
            'queries'        => $queryTypeJson,
            'raised_by'      => $query_status == 'P' ? $raised_by : '',
        ]);

         WorkflowA::where('application_id', $request->application_id)
              ->where('processed_by', $request->processed_by)
              ->where('role_id', $request->role_id)
                ->orderByDesc('id')
                ->limit(1)
                ->update([
                    'created_at' => DB::raw('NOW()'),
                ]);



        

        EA_Application_model::where('application_id', $request->application_id)
            ->update([
                'application_status' => $status, // Role-based forwarding
                'processed_by'  => $processed_by, // Role-based forwarding
                'updated_at' => DB::raw('NOW()'),
            ]);

        

        if ($request->application_status === 'RE') {
            $role1 = 'Secretary';
            $message = "Application Forwarded to $role1 successfully!";
        } else {
            $message = "Application Forwarded to $role successfully!";
        }

        return response()->json([
            'status'  => 'success',
            'message' => $message,
        ], 201);
    }


    
    public function approveApplicationForma(Request $request)
    {
        $request->validate([
            'application_id'    => 'required|string',
            'processed_by'      => 'required|string',
            'forwarded_to'      => 'nullable|integer',
            'remarks'           => 'nullable|string',
            'validity_override' => 'nullable|string',
            'oldapplicationId'  => 'nullable|string',
            'qc_validity_date'  => 'nullable|date',
            'bank_validity'     => 'nullable|date',
            'licensename'       => 'required|string',
        ]);

        $application = DB::table('tnelb_ea_applications')
            ->where('application_id', $request->application_id)
            ->first();

        if (!$application) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        DB::beginTransaction();

        try {
            /* -------------------- BASIC UPDATE -------------------- */

            $processed = Auth::user()->name === 'President' ? 'PR' : 'SE';

            DB::table('tnelb_ea_applications')
                ->where('application_id', $request->application_id)
                ->update([
                    'application_status' => 'A',
                    'processed_by'       => $processed,
                    'updated_at'         => now(),
                ]);

            $appl_type = trim($application->appl_type); // R or N
            // $issuedAt  = now()->format('Y-m-d H:i:s');
            $issuedAt  = $application->dt_submit;
            $expiresAt = null;
            $newSerial = null;

            /* -------------------- GET LICENCE VALIDITY MONTHS -------------------- */

            $form = DB::table('mst_licences')
                ->where('cert_licence_code', $request->licensename)
                ->where('status', 1)
                ->first();

            $validity = DB::table('mst_fees_validity')
                ->where('licence_id', $form->id)
                ->where('form_type', $appl_type)
                ->where('status', 1)
                ->whereDate('validity_start_date', '<=', now())
                ->orderBy('validity_start_date', 'desc')
                ->first();

            $monthsToAdd = $validity->validity ?? 0;

            /* -------------------- NORMAL EXPIRY CALCULATION -------------------- */

            if ($appl_type === 'R') {

                // Renewal → old expiry + months
                $oldExpiry = DB::table('tnelb_renewal_license')
                    ->where('application_id', $request->oldapplicationId)
                    ->value('expires_at');

                $baseExpiry = $oldExpiry
                    ? Carbon::parse($oldExpiry)
                    : now();

                $expiresAt = $baseExpiry->copy()->addMonths($monthsToAdd)->toDateString();

            } else {

                // Fresh → today + months
                $expiresAt = now()->addMonths($monthsToAdd)->toDateString();
            }

            /* -------------------- OVERRIDE (POPUP CONFIRMED) -------------------- */

            if ($request->validity_override === 'YES') {

            // dd('111');
            // exit;

                $qcValidity   = $request->qc_validity_date
                    ? Carbon::parse($request->qc_validity_date)
                    : null;

                $bankValidity = $request->bank_validity
                    ? Carbon::parse($request->bank_validity)
                    : null;

                $expiresAt = collect([
                    Carbon::parse($expiresAt),
                    $qcValidity,
                    $bankValidity,
                ])->filter()->min()->toDateString();

                // dd($expiresAt);
                // exit;
            }

            /* -------------------- LICENSE INSERT / UPDATE -------------------- */

            if ($appl_type === 'R') {

                DB::table('tnelb_renewal_license')->insert([
                    'login_id'       => $application->login_id,
                    'license_number' => $application->license_number,
                    'application_id' => $request->application_id,
                    'issued_by'      => $request->processed_by,
                    'issued_at'      => $issuedAt,
                    'expires_at'     => $expiresAt,
                    'created_at'     => now(),
                ]);

                $newSerial = $application->license_number;

            } else {

                $prefix    = $application->license_name;
                $yearMonth = now()->format('Ym');

                $lastSerial = DB::table('tnelb_license')
                    ->where('license_number', 'LIKE', "L{$prefix}{$yearMonth}%")
                    ->orderByDesc('license_number')
                    ->value('license_number');

                $next = $lastSerial ? str_pad((int)substr($lastSerial, -5) + 1, 5, '0', STR_PAD_LEFT) : '00001';

                $newSerial = "L{$prefix}{$yearMonth}{$next}";

                DB::table('tnelb_license')->insert([
                    'application_id' => $request->application_id,
                    'license_number' => $newSerial,
                    'issued_by'      => $request->processed_by,
                    'issued_at'      => $issuedAt,
                    'expires_at'     => $expiresAt,
                ]);
            }

            /* -------------------- WORKFLOW -------------------- */

//            $workflow_change = DB::table('tnelb_workflow_a')->insert([
//                 'application_id' => $request->application_id,
//                 'processed_by'   => $request->processed_by,
//                 'role_id'        => Auth::user()->roles_id,
//                 'appl_status'    => 'A',
//                 'remarks'        => $request->remarks ?? 'No remarks provided',
//                 'forwarded_to'   => $request->forwarded_to,
//                 'created_at'     => now(),
//             ]);



//          $workflow_change1 = WorkflowA::where('application_id', $request->application_id)
//               ->where('processed_by', $request->processed_by)
//               ->where('role_id', $request->role_id)
//                 ->orderByDesc('id')
//                 ->limit(1)
//                 ->update([
//                     'created_at' => DB::raw('NOW()'),
//                 ]);
// dd($workflow_change1->created_at);exit;


               $workflowId = DB::table('tnelb_workflow_a')->insertGetId([
        'application_id' => $request->application_id,
        'processed_by'   => $request->processed_by,
        'role_id'        => Auth::user()->roles_id,
        'appl_status'    => 'A',
        'remarks'        => $request->remarks ?? 'No remarks provided',
        'forwarded_to'   => $request->forwarded_to,
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    // 2️⃣ UPDATE SAME RECORD (guaranteed)
    DB::table('tnelb_workflow_a')
        ->where('id', $workflowId)
        ->update([
          'created_at' => DB::raw('NOW()'),
          'updated_at' => DB::raw('NOW()'),
        ]);


            DB::commit();

            return response()->json([
                'status'         => 'success',
                'message'        => $appl_type === 'R'
                    ? "Renewal approved till " . date('d/m/Y', strtotime($expiresAt))
                    : "License issued till " . date('d/m/Y', strtotime($expiresAt)),
                'license_number' => $newSerial,
                'issued_at'      => $issuedAt,
                'expires_at'     => $expiresAt,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Approval failed',
                'msg'   => $e->getMessage()
            ], 500);
        }
    }
    public function approveApplicationForma_beforepopup_bk(Request $request)
    {

        // DB::table('tnelb_application_tbl')
//     ->where('application_id', 'WB251111111')
//     ->update([
//         'd_o_b' => '01-01-1945'
//     ]);

//     DB::table('tnelb_ea_applications')
//     ->where('application_id', 'AEA25000001')
//     ->update([
//         'payment_status' => 'paid',
//         'application_status' => 'P',

//     ]);

// $show = DB::table('tnelb_ea_applications')
//         ->where('application_id', 'AEA25000001')
//         ->first();

  // $show = DB::table('tnelb_license')->get()->toArray();

//         $show = DB::table('tnelb_license')
//           ->where('application_id', 'AEA25000004')
//           ->delete();
// if ($show) {
//     echo "Record deleted successfully";
// } else {
//     echo "No record found";
// }

 

//  dd($show);
// exit;

        // dd($request->all());
        // exit;

        $request->validate([
            'application_id' => 'required|string',
            'processed_by'   => 'required|string',
            'forwarded_to'   => 'integer',
            'remarks'        => 'nullable|string',
        ]);

        // Fetch the application details
        $application = DB::table('tnelb_ea_applications')
            ->where('application_id', $request->application_id)
            
            ->first();

        if (!$application) {
            return response()->json(['error' => 'Application not found.'], 404);
        }
        $login_id = $application->login_id;


        $formname = $application->form_name;

        $licensename = $request->licensename;

        // dd($licensename);
        // exit;

        

        // Get form type
        // $formType = DB::table('tnelb_forms')->where('id', $application->form_id)->first();


        // if (!in_array($formType->form_name, ['FORM S', 'FORM W'])) {
        //     return response()->json(['error' => 'This application cannot be approved by the secretary.'], 403);
        // }

        DB::beginTransaction();
        try {
            // ...  earlier code to update application_status etc ...
            $staff = Auth::user()->name;

            if ($staff == "President") {
                $processed = 'PR';
            } else {
                $processed = 'SE';
            }

       
          
                 DB::table('tnelb_ea_applications')
                ->where('application_id', $request->application_id)
                ->update([
                    'application_status'     => 'A',
                    'processed_by' => isset($processed) ? $processed : 'PR',
                    'updated_at' => now(),
                ]);
            
         

            $appl_type = preg_replace('/\s+/', '', $application->appl_type);

            // Ensure these are defined for later use
            $issuedAt = null;
            $expiresAt = null;
            $newSerial = null;



            if ($appl_type == "R") {



                $license_details = DB::table('tnelb_renewal_license')
                    ->where('application_id', $request->application_id)
                    ->first();

                $now = now();

                // If no renewal record OR renewal expired -> proceed to renew
                if (!$license_details || $now->greaterThan(Carbon::parse($license_details->expires_at))) {

                    $formid = DB::table('mst_licences')
                        ->where('cert_licence_code', $licensename)
                        ->where('status', '1')
                        ->first();


                    $today = Carbon::today()->toDateString();

                    $licenseperiod = DB::table('mst_fees_validity')
                    ->where('licence_id', $formid->id)
                    ->where('form_type', $appl_type)
                    ->where('status', 1)
                    ->whereDate('validity_start_date', '<=', $today)
                    ->orderBy('validity_start_date', 'desc') 
                    ->first();

                    $monthsToAdd = $licenseperiod->validity ?? 0;
// dd($monthsToAdd);
// exit;
                    // 🔥 Get original expiry date from tnelb_license table
                    $oldExpiry = DB::table('tnelb_license')
                        ->where('application_id', $request->oldapplicationId)
                        ->value('expires_at');   // single column

                    // If no expiry found, use NOW as fallback
                    $expirySourceDate = $oldExpiry ? Carbon::parse($oldExpiry) : now();

                

                    // 🔥 Add the validity months to old expiry
                    $expiresAt = $expirySourceDate->copy()->addMonths($monthsToAdd)->format('Y-m-d');

      // dd($expiresAt);
      //           exit;

                    $issuedAt = now()->format('Y-m-d H:i:s');

                    DB::table('tnelb_renewal_license')->insert([
                        'login_id'       => $login_id,
                        'license_number' => $application->license_number,
                        'application_id' => $request->application_id,
                        'issued_by'      => $request->processed_by,
                        'issued_at'      => $issuedAt,
                        'expires_at'     => $expiresAt,
                        'created_at'     => now(),
                    ]);

                    $newSerial = $application->license_number;

                
                } else {
                    // existing renewal record still valid -> reuse its values
                    $newSerial = $license_details->license_number;
                    $issuedAt = $license_details->issued_at;
                    $expiresAt = $license_details->expires_at;
                }
            } else {


                // Fresh license (N)
                $license_details = DB::table('tnelb_license')
                    ->where('application_id', $request->application_id)
                    ->first();

                     

                if ($license_details) {

                    //                    dd('exist');
                    // exit;
                    // use existing license
                    $newSerial = $license_details->license_number;
                    $issuedAt = $license_details->issued_at;
                    $expiresAt = $license_details->expires_at;
                } else {
                    //                                dd('new');
                    // exit;
                    // create new license
                    $prefix = $application->license_name;
                    $yearMonth = date('Ym');

                    $lastSerial = DB::table('tnelb_license')
                        ->where('license_number', 'LIKE', "L{$prefix}{$yearMonth}%")
                        ->orderBy('license_number', 'desc')
                        ->value('license_number');

                    if ($lastSerial) {
                        $lastNumber = (int) substr($lastSerial, -5);
                        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                    } else {
                        $newNumber = '00001';
                    }

                    $newSerial = "L{$prefix}{$yearMonth}{$newNumber}";
                    $issuedAt = now()->format('Y-m-d H:i:s');

                //  dd($licensename);
                //  exit;
               $formid = DB::table('mst_licences')
                        ->where('cert_licence_code', $licensename)
                        ->where('status', '1')
                        ->first();

                 $today = Carbon::today()->toDateString();

                // $today = '2025-12-31';

                //  dd($today);
                //  exit;

                    $licenseperiod = DB::table('mst_fees_validity')
                    ->where('licence_id', $formid->id)
                    ->where('form_type', $appl_type)
                    ->where('status', 1)
                    ->whereDate('validity_start_date', '<=', $today)
                    ->orderBy('validity_start_date', 'desc') 
                    ->first();
                        

                    // dd($formid->id);
                    // exit;

                        // dd($licenseperiod->validity);
                        // exit;
                   
                    $monthsToAdd = $licenseperiod->validity ?? 0;

                    // dd($monthsToAdd);
                    // exit;

// H:i:s
                    $expiresAt = now()->copy()->addMonths($monthsToAdd)->format('Y-m-d');

                    // dd($licenseperiod->validity);
                    // exit;

                    //   dd([
                    //     'issuedAt'   => $issuedAt,
                    //     'expiresAt'  => $expiresAt,
                    //     'newSerial'  => $newSerial,
                    //     'app_id'     => $request->application_id,
                    //     'processed'  => $request->processed_by,
                    // ]);
                    //             exit;
                    DB::table('tnelb_license')->insert([
                        'application_id' => $request->application_id,
                        'license_number' => $newSerial,
                        'issued_by'      => $request->processed_by,
                        'issued_at'      => $issuedAt,
                        'expires_at'     => $expiresAt,
                    ]);
                }
            }

            // store workflow entry etc (your existing code)
            DB::table('tnelb_workflow_a')->insert([
                'application_id' => $request->application_id,
                'processed_by'   => $request->processed_by,
                'role_id'        => Auth::user()->roles_id,
                'appl_status'    => 'A',
                'remarks'        => $request->remarks ?? 'No remarks provided',
                'forwarded_to'   => $request->forwarded_to ?? null,
                'created_at'     => now(),
            ]);

            DB::commit();

            $message = ($appl_type === "R")
                // $message = str_starts_with($request->application_id, 'R')
                ? "Renewal Application Extended from " . date('d/m/Y', strtotime($issuedAt)) . " to " . date('d/m/Y', strtotime($expiresAt)) . " successfully!"
                : "Fresh Application  Extended from " . date('d/m/Y', strtotime($issuedAt)) . " to " . date('d/m/Y', strtotime($expiresAt)) . " successfully!";



            return response()->json([
                'status'        => 'success',
                'message'       => $message,
                'license_number' => $newSerial,
                'issued_at'     => $issuedAt,
                'expires_at'    => $expiresAt,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }


    public function approveApplication(Request $request)
    {

        $request->validate([
            'application_id' => 'required|string',
            'processed_by'   => 'required|string',
            'forwarded_to'   => 'integer',
            'remarks'        => 'nullable|string',
        ]);

        // dd($request->all());
        // exit;
        // Fetch the application details
        $application = DB::table('tnelb_application_tbl')
            ->where('application_id', $request->application_id)
            ->first();


        if (!$application) {
            return response()->json(['error' => 'Application not found.'], 404);
        }

        $login_id = $application->login_id;


        $formname = $application->form_name;
        // Get form type
        $formType = DB::table('tnelb_forms')->where('id', $application->form_id)->first();


        // if (in_array($formType->form_name, ['FORM S'])) {
        //     return response()->json(['error' => 'This application cannot be approved by the secretary.'], 403);
        // }

        DB::beginTransaction();
        try {
            // Update application status to "Approved"
            $staff = Auth::user()->name;

            if ($staff == "President") {
                $processed = 'PR';
            } else {
                $processed = 'SE';
            }
        $appl_type = preg_replace('/\s+/', '', $application->appl_type);
            DB::table('tnelb_application_tbl')
                ->where('application_id', $request->application_id)
                ->update([
                    'status'     => 'A',
                    'processed_by' => isset($processed) ? $processed : 'PR',
                    'updated_at' => now(),
                ]);

             if ($appl_type == "R") {

                // if (str_starts_with($request->application_id, 'R')) {
                $license_details = DB::table('tnelb_renewal_license')
                    ->where('application_id', $request->application_id)
                    ->first();

                $now = now();

                // If no renewal record OR existing record already expired -> create new renewal
                if (!$license_details || $now->greaterThan(Carbon::parse($license_details->expires_at))) {
                    $issuedAt = $now->format('Y-m-d H:i:s');
                   $formid = DB::table('mst_licences')
                        ->where('cert_licence_code', 'ESB')
                        ->where('status', '1')
                        ->first();

                          $licenseperiod = DB::table('mst_fees_validity')
                        ->where('licence_id', $formid->id)
                        ->where('form_type', $appl_type)
                         ->where('validity_start_date','<=', now())
                        ->first();
                        

                    // dd($formid->id);
                    // exit;

                        // dd($licenseperiod->validity);
                        // exit;
                   
                    $monthsToAdd = $licenseperiod->validity ?? 0;

// H:i:s
                    $expiresAt = now()->copy()->addMonths($monthsToAdd)->format('Y-m-d');
// dd($expiresAt);
// exit;
              

                    // safe fallback if licenseperiod missing
                    // $yearsToAdd = $licenseperiod->renewal_period ?? 1;
                    // $expiresAt = $now->copy()->addYears($yearsToAdd)->format('Y-m-d H:i:s');

                    DB::table('tnelb_renewal_license')->insert([
                        'login_id'       => $login_id,
                        'license_number' => $application->license_number,
                        'application_id' => $request->application_id,
                        'issued_by'      => $request->processed_by,
                        'issued_at'      => $issuedAt,
                        'expires_at'     => $expiresAt,
                        'created_at'     => now(),
                    ]);

                    $newSerial = $application->license_number;
                } else {
                    // existing renewal record still valid -> reuse its values
                    $newSerial = $license_details->license_number;
                    $issuedAt = $license_details->issued_at;
                    $expiresAt = $license_details->expires_at;
                }
            } else {


                // Fresh license (N)
                $license_details = DB::table('tnelb_license')
                    ->where('application_id', $request->application_id)
                    ->first();

                     

                if ($license_details) {

                    //                    dd('exist');
                    // exit;
                    // use existing license
                    $newSerial = $license_details->license_number;
                    $issuedAt = $license_details->issued_at;
                    $expiresAt = $license_details->expires_at;
                } else {
                    //                                dd('new');
                    // exit;
                    // create new license
                    $prefix = $application->license_name;
                    $yearMonth = date('Ym');

                    $lastSerial = DB::table('tnelb_license')
                        ->where('license_number', 'LIKE', "L{$prefix}{$yearMonth}%")
                        ->orderBy('license_number', 'desc')
                        ->value('license_number');

                    if ($lastSerial) {
                        $lastNumber = (int) substr($lastSerial, -5);
                        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                    } else {
                        $newNumber = '00001';
                    }

                    $newSerial = "L{$prefix}{$yearMonth}{$newNumber}";
                    $issuedAt = now()->format('Y-m-d H:i:s');

                 
               $formid = DB::table('mst_licences')
                        ->where('cert_licence_code', 'ESB')
                        ->where('status', '1')
                        ->first();

                          $licenseperiod = DB::table('mst_fees_validity')
                        ->where('licence_id', $formid->id)
                        ->where('form_type', $appl_type)
                        ->where('status', '1')
                        ->first();
                        

                    // dd($formid->id);
                    // exit;

                        // dd($licenseperiod->validity);
                        // exit;
                   
                    $monthsToAdd = $licenseperiod->validity ?? 0;


                    // dd()

// H:i:s
                    $expiresAt = now()->copy()->addMonths($monthsToAdd)->format('Y-m-d');
                        // dd($expiresAt);
                        // exit;
                    // dd($licenseperiod->validity);
                    // exit;

                    //   dd([
                    //     'issuedAt'   => $issuedAt,
                    //     'expiresAt'  => $expiresAt,
                    //     'newSerial'  => $newSerial,
                    //     'app_id'     => $request->application_id,
                    //     'processed'  => $request->processed_by,
                    // ]);
                    //             exit;
                    DB::table('tnelb_license')->insert([
                        'application_id' => $request->application_id,
                        'license_number' => $newSerial,
                        'issued_by'      => $request->processed_by,
                        'issued_at'      => $issuedAt,
                        'expires_at'     => $expiresAt,
                    ]);
                }
            }


            DB::table('tnelb_workflow')->insert([
                'application_id' => $request->application_id,
                'processed_by'   => $request->processed_by,
                'role_id'        => Auth::user()->roles_id, // Current user role (Secretary)
                'appl_status'    => 'A',
                'remarks'        => $request->remarks ?? 'No remarks provided',
                'forwarded_to'   => $request->forwarded_to ?? null, // No forwarding since it's approved
                'created_at'     => now(),
            ]);


            DB::commit();

            if ($application->appl_type == "R") {

                return response()->json([
                    'status'        => 'success',
                    'message'        => 'Application Renewed successfully!',
                    'license_number' => $application->license_number,
                    'issued_at'      => $issuedAt,
                    'expires_at'     => $expiresAt,
                ], 200);
            } else {

                return response()->json([
                    'status'        => 'success',
                    'message'        => 'Application approved successfully!',
                    'license_number' => $newSerial,
                    'issued_at'      => $issuedAt,
                    'expires_at'     => $expiresAt,
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
            //\log()::error("Approve Application Error: " . $e->getMessage()); // Log the exact error
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }
}
