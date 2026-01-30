<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\FeesValidity;
use App\Models\Admin\Mst_equipment_tbl;
use Illuminate\Http\Request;



use App\Models\Admin\WorkflowA;

use App\Models\Equipment_storetmp_A;
use App\Models\Equipment_storetmp_sb;
use App\Models\ESA_Application_model;
use App\Models\B_Application;
use App\Models\MstLicence;
use App\Models\Tnelb_banksolvency_a;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormBprocessController extends Controller
{
     public function view_formb()
    {
        $userRole = Auth::user()->roles_id;

        $assignedForms = DB::table('tnelb_eb_applications as ta')
            ->whereIn('ta.application_status', ['P', 'RE']) // Filter by status
            ->select('ta.*') // Select all columns from applicant_formA
            ->get();


        // var_dump($assignedForms);die;

        $workflows = DB::table('tnelb_eb_applications')
            ->whereIn('application_status', ['P', 'RE'])
            ->where('payment_status', 'paid')
            ->orderBy('updated_at', 'DESC')
            ->select('*')
            ->get();


        $pendinglist_sa = DB::table('tnelb_eb_applications')
            ->whereIn('application_status', ['P', 'RE'])
            ->where('payment_status', 'paid')
            ->orderBy('updated_at', 'DESC')
            ->select('*')
            ->get();

            
        return view('admin.supervisor.formb.view_formb', compact('pendinglist_sa'));
        
        // return view('admin.supervisor.view_forma', compact('workflows'));
    }

        public function view_formb_completed()
    {
        $userRole = Auth::user()->roles_id;

        $workflows = B_Application::whereIn('application_status', ['F', 'A', 'RE', 'SPRE'])
            ->whereIn('processed_by', ['A', 'SE', 'PR', 'SPRE'])
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

           
        return view('admin.auditor.formb.completed_formb',compact('workflows','licenses',
        'renewalLicenses'));
    }


    // --------------View formb---------------------

     public function applicants_detail_formb($applicant_id)
    {

        
        $returnForwardUser = null;

        $staff = Auth::user();


        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }



  

    $applicant = DB::table('tnelb_eb_applications')
        ->leftJoin('payments', 'tnelb_eb_applications.application_id', '=', 'payments.application_id')
        ->where('tnelb_eb_applications.application_id', $applicant_id)
        ->where('payments.payment_status', 'success')
        ->select(
            'tnelb_eb_applications.*',
                'payments.transaction_id',
                'payments.payment_status',
                'payments.amount',
                'payments.payment_mode',
                'payments.created_at as payment_date',
                'payments.application_fee',
                'payments.late_fee',
                
        )->orderByDesc('dt_submit')
        ->first();

 


        $formname = $applicant->form_name;

        $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();
      
      

        if (!$applicant) {
            return abort(404, 'Applicant not found');
        }


        if ($staff->name === "Supervisor") {

            if ($applicant->application_status == 'RE') {

                // $processed_by = match ($applicant->processed_by) {
                //     'PR'  => 'President',
                //     'SE'  => 'Secretary',
                //     'S'  => 'Supervisor',
                //     'A'  => 'Accountant'
                // };

                // $nextForwardUser = DB::table('mst__staffs__tbls')
                //     ->where('name', $processed_by)
                //     ->select('name', 'roles_id')
                //     ->first(); 

                $nextForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'Secretary')
                    ->select('name', 'roles_id')
                    ->first();
            } else {
                $nextForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'Accountant')
                    ->select('name', 'roles_id')
                    ->first();
            }

            // if ($applicant->application_status == 'RE') {

            //     $processed_by = match ($applicant->processed_by) {
            //         'PR'  => 'President',
            //         'SE'  => 'Secretary',
            //         'S'  => 'Supervisor',
            //         'A'  => 'Accountant'
            //     };

            //     $nextForwardUser = DB::table('mst__staffs__tbls')
            //         ->where('name', $processed_by)
            //         ->select('name', 'roles_id')
            //         ->first();

            //         // dd($nextForwardUser);
            //         // exit;
            // } else {
            //     $nextForwardUser = DB::table('mst__staffs__tbls')
            //         ->where('name', 'Accountant')
            //         ->select('name', 'roles_id')
            //         ->first();

            // }
        }

        if ($staff->name === "Supervisor2") {
            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Accountant')
                ->select('name', 'roles_id')
                ->first();
        }


        if ($staff->name === "Accountant") {
            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Secretary')
                ->select('name', 'roles_id')
                ->first();
        }
        if ($staff->name === "Secretary") {

            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'President')
                ->select('name', 'roles_id')
                ->first();


            $returnForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Supervisor')
                ->select('name', 'roles_id')
                ->first();
        }

        if ($staff->name === "President") {

            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'President')
                ->select('name', 'roles_id')
                ->first();

            $returnForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Supervisor')
                ->select('name', 'roles_id')
                ->first();
        }



        $proprietordetailsform_A = DB::table('proprietordetailsform_A')
            ->where('application_id', $applicant_id)
            ->orderBy('id', 'Desc')
            ->where('proprietor_flag', '1')
            ->get();


        $staffdetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $applicant_id)
            ->orderby('id')
            ->get();

        $showQcWarning = false;


        $licence_name_validitystaff = MstLicence::where('form_code', $formname)->first();

        if ($licence_name_validitystaff && $staffdetails->count() > 0) {

            $today = Carbon::today()->toDateString();
            $applType = trim($applicant->appl_type); // N or R

            /* -----------------------------
       Get fees validity
    ------------------------------ */
            $licence_validitystaff = FeesValidity::where('licence_id', $licence_name_validitystaff->id)
                ->where('form_type', $applType === 'N' ? 'N' : 'R')
                ->where('status', 1)
                ->whereDate('validity_start_date', '<=', $today)
                ->orderBy('validity_start_date', 'desc')
                ->first();

            if ($licence_validitystaff && $licence_validitystaff->validity) {

                /* -----------------------------
                Compare FIRST QC validity
                ------------------------------ */
                $firstQcValidity = Carbon::parse($staffdetails->first()->cc_validity);

                // dd($staffdetails->first()->cc_validity);
                // exit;



                // Licence period (months)
                $licencePeriodEnd = Carbon::now()->addMonths((int) $licence_validitystaff->validity);
                // dd($licencePeriodEnd);
                // exit;

                if ($firstQcValidity->lt($licencePeriodEnd)) {
                    $showQcWarning = true;
                }
            }
        }



        $staff = Auth::user();
        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }


        $user_entry = DB::table('tnelb_eb_applications')
            ->where('application_id', $applicant_id)
            ->select('*')
        
        ->first();

        $documents = DB::table('tnelb_applicant_doc_A')
            ->where('application_id', $applicant_id)
            ->select('*')
          
            ->first();


        $workflows = DB::table('tnelb_workflow_a')
            ->leftjoin('tnelb_eb_applications', 'tnelb_workflow_a.application_id', '=', 'tnelb_eb_applications.application_id')
            ->leftjoin('mst__roles', 'tnelb_workflow_a.forwarded_to', '=', 'mst__roles.id')
            ->where('tnelb_workflow_a.application_id', $applicant_id)
            ->select('tnelb_workflow_a.*', 'mst__roles.name', 'tnelb_eb_applications.form_name', 'tnelb_eb_applications.license_name')
            ->orderBy('tnelb_workflow_a.id', 'desc')
            ->get();

        // var_dump($workflows);die;

        $queries = DB::table('tnelb_query_applicable as qa')
            ->leftJoin('tnelb_eb_applications as ta', 'qa.application_id', '=', 'ta.application_id')
            ->where('qa.application_id', $applicant_id)
            ->where('qa.query_status', 'P')
            ->select('qa.*')
            ->first() ?? null;

          $showbankWarning = false;

        $banksolvency = Tnelb_banksolvency_a::where('application_id', $applicant_id)->where('status', '1')->first();



        $bankValidity = Carbon::parse($banksolvency->bank_validity);

        // dd($licence_validitystaff->validity);
        // exit;



        // Licence period (months)
        $bankvalidityend = Carbon::now()->addMonths((int) $licence_validitystaff->validity);
        // dd($licencePeriodEnd);
        // exit;

        if ($bankValidity->lt($bankvalidityend)) {
            $showbankWarning = true;
        }

       $equiplist = Mst_equipment_tbl::where('equip_licence_name', 10)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            // ->where('login_id', Auth::user()->login_id)
            ->where('application_id', $applicant_id) // IMPORTANT
            ->get();


        // $view = match ($staff->name) {
        //     'President'  => 'admin.dashboard.applicants_president_forma',
        //     'Secretary'  => 'admin.dashboard.applicants_detail_sec_forma',
        //     'Supervisor' => 'admin.dashboard.applicants_detail_forma',
        //     // 'Supervisor2' => 'admin.dashboard.applicants_detail_supervisor',
        //     'Accountant'    => 'admin.dashboard.applicants_detail_auditor_forma',

        //     default      => abort(403, 'Unauthorized'),
        // };



                    $view = match ($staff->name) {
                    'President'  => 'admin.dashboard.formb.applicants_detail_formb',
                    'Secretary'  => 'admin.dashboard.formb.applicants_detail_formb',
                    'Supervisor' => 'admin.dashboard.formb.applicants_detail_formb',
                    // 'Supervisor2' => 'admin.dashboard.applicants_detail_supervisor',
                    'Accountant'    => 'admin.dashboard.formb.applicants_detail_auditor_formb',

                    default      => abort(403, 'Unauthorized'),
                };
            

        return view($view, compact(
            'applicant',
            'proprietordetailsform_A',
            'showQcWarning',
            'staffdetails',
            'nextForwardUser',
            'returnForwardUser',
            'user_entry',
            'workflows',
            'queries',
            'documents',
            'banksolvency',
            'equipmentlist',
            'license_name',
            'equiplist',
            'showbankWarning'
        ));
    }

     // forward application-------------------------------------------------------------------
      public function forwardApplicationformb(Request $request, $role)
    {

     

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


        


        $applicant = B_Application::where('application_id', $request->application_id)
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


        // $formType = DB::table('tnelb_eb_applications')
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

        // dd($workflow);
        // exit;


        
             WorkflowA::where('application_id', $request->application_id)
              ->where('processed_by', $request->processed_by)
              ->where('role_id', $request->role_id)
                ->orderByDesc('id')
                ->limit(1)
                ->update([
                    'created_at' => DB::raw('NOW()'),
                ]);
        

        B_Application::where('application_id', $request->application_id)
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


       // ---------------approve application--------------------

     public function approveApplicationformb(Request $request)
    {

    // dd($request->oldapplicationId);
    // exit;

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

        $application = DB::table('tnelb_eb_applications')
            ->where('application_id', $request->application_id)
            ->first();

        if (!$application) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        DB::beginTransaction();

        try {
            /* -------------------- BASIC UPDATE -------------------- */

            $processed = Auth::user()->name === 'President' ? 'PR' : 'SE';

            DB::table('tnelb_eb_applications')
                ->where('application_id', $request->application_id)
                ->update([
                    'application_status' => 'A',
                    'processed_by'       => $processed,
                    'updated_at'         => DB::raw('NOW()'),
                ]);

            $appl_type = trim($application->appl_type); // R or N
            // $issuedAt  = DB::raw('NOW()');

            $issuedAt  = $application->dt_submit;

            // dd($issuedAt);
            // exit;
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
                    'created_at'     => DB::raw('NOW()'),
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

            DB::table('tnelb_workflow_a')->insert([
                'application_id' => $request->application_id,
                'processed_by'   => $request->processed_by,
                'role_id'        => Auth::user()->roles_id,
                'appl_status'    => 'A',
                'remarks'        => $request->remarks ?? 'No remarks provided',
                'forwarded_to'   => $request->forwarded_to,
                'created_at'     => now(),
            ]);

            //   WorkflowA::where('application_id', $request->application_id)
            //   ->where('processed_by', $request->processed_by)
            //   ->where('role_id', Auth::user()->roles_id)
            //     ->update([
                
            //         'created_at' => DB::raw('NOW()'),
            //     ]);

             WorkflowA::where('application_id', $request->application_id)
              ->where('processed_by', $request->processed_by)
              ->where('role_id', Auth::user()->roles_id)
                ->orderByDesc('id')
                ->limit(1)
                ->update([
                    'created_at' => DB::raw('NOW()'),
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


      // ------------------return ------------------------------------------
    public function returntoSupervisorformb(Request $request){

        $staff = Auth::user();
        
        $staffID = Auth::user()->id;

// dd($request->forwaded_to);
// exit;
        $request->validate([
            'application_id' => 'required|string',
            'return_by'      => 'required|string',
            'forwarded_to'   => 'required|string',
            'checkboxes'     => 'nullable|string',
            'queryswitch'    => 'nullable|string',
            'queryType'      => 'array',
            'remarks'        => 'nullable|string'
        ]);
        
        
             $query_status = null;
        $queryTypeJson = json_encode($request->queryType);

        
    if ($request->queryswitch == 'Yes' && !empty($request->queryType) || ($request->queryswitch == 'true')) {
            $query_status = "P";
        }
        

        $formType = DB::table('tnelb_eb_applications')
                        ->where('application_id', $request->application_id)
                       
                        ->first();

// dd($formType->form_name);
// exit;

        // $status = match ($staff->name) {
        //     'President' => 'A',
        //     'Secretary'  => ($formType->form_id == 1 ? 'F' : 'A'),
        //     'Supervisor' => 'F',
        //     'Auditor'    => 'F',
        //     default      => abort(403, 'Unauthorized'),
        // };
                      
        $processed_by = match ($staff->name) {
            'President'  => 'PR',
            'Secretary'  => 'SE',
            'Supervisor' => 'S',
            'Accountant'    => 'A',
            default      => abort(403, 'Unauthorized'),
        };

        $raised_by    = ($request->queryswitch === 'Yes') ? $processed_by : $staffID;
        // var_dump($queryTypeJson);die;

        // Insert data into tnelb_workflow table
        $workflow = WorkflowA::create([ // Ensure this is the correct model
            'application_id' => $request->application_id,
            'appl_status'    => 'RE', // Forwarded
            'processed_by'   => $request->return_by,
            'forwarded_to'   => $request->forwarded_to,
            'role_id'        => $staffID,
            'is_verified'    => $request->checkboxes,
            'query_status'   => $query_status,
            // "Yes" or "No"
            'remarks'        => $request->remarks,
            'created_at'     => now(), // Automatically managed if model has timestamps
            'login_id'       => $staffID,
            'queries'        => $queryTypeJson,
            'raised_by'      => $query_status == 'P' ? $raised_by : ''
        ]);


        // Update application status
       
              WorkflowA::where('application_id', $request->application_id)
                 ->where('processed_by', $request->return_by)
                 ->where('role_id', $staffID)
                ->orderByDesc('id')
                ->limit(1)
                ->update([
                    'created_at' => DB::raw('NOW()'),
                ]);
        

        B_Application::where('application_id', $request->application_id)
            ->update([
                'application_status' =>  'RE', 
                'processed_by'  => $processed_by, 
                'updated_at' => DB::raw('NOW()'),
            ]);


        //Get Role 
        $role = DB::table('mst__roles')
        ->where('id', $request->forwarded_to)
        ->select('name')
        ->first();
        // var_dump($role->name);die;
        

        return response()->json([
            'status' => "success",
            'message' => "Application Returned to $role->name successfully!",
        ], 201);
    }

 // --------------------completed SA ---------------------------------
    public function completed_formb()
    {

   
        $userRole = Auth::user()->roles_id;

        // $assignedForms = DB::table('tnelb_eb_applications as ta')
        // ->whereIn('ta.application_status', ['F', 'RF','A']) // Filter by status
        // ->select('ta.*') // Select all columns from applicant_formA
        // ->get();


        // var_dump($assignedForms);die;

        $workflows = DB::table('tnelb_eb_applications')
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


        return view('admin.supervisor.formb.completed_formb', compact('workflows',
                'licenses',
                'renewalLicenses'));
    }
    // -----------Auditor------------------

      public function view_formb_pending()
    {

        
// dd('111');exit;
        $userRole = Auth::user()->roles_id;

    

        // ESA Applications Query
        $unionQuery = DB::table('tnelb_eb_applications')
            ->whereIn('application_status', ['F'])
            ->whereIn('processed_by', ['S'])
            ->select(
                'application_id',
                'form_name',
                'application_status',
                'processed_by',
                'dt_submit',
                DB::raw("'EB' as source_table")
            );

        // Combine both queries
      

        // Execute the union and order globally
        $workflows = DB::query()
            ->fromSub($unionQuery, 'combined')
            ->orderBy('dt_submit', 'DESC')
            ->get();

     

        // Identify source (EA or ESA) using the alias we added
        $sourceTable = $workflows->first()->source_table ?? null;
    

        $workflows_esa = DB::table('tnelb_eb_applications')
            ->whereIn('application_status', ['F'])
            ->whereIn('processed_by', ['S'])
            ->orderBy('dt_submit', 'DESC')
            ->get();
    
        // Load view based on type
        
        return view('admin.auditor.formb.view_formb', compact('workflows_esa'));
       
    }


        // ------------secretary-------------------------

     public function view_sec_formsa_completed(Request $request)
    {
     $workflows = DB::table('tnelb_eb_applications as ta')
        ->whereIn('ta.application_status', ['F','A', 'RE'])
        ->orderByDesc('updated_at')
            // ->where('ta.form_id', $formId)
            ->select('ta.*')
            ->get();
        // $formId = $request->query('form_id');
    
       // $workflows = DB::table('tnelb_eb_applications as ta')
       //      ->whereIn('ta.processed_by', ['A', 'SPRE']) 
       //      ->orWhere('ta.application_status', 'RF')
       //      // ->where('ta.form_id', $formId)
       //      ->select('ta.*')
       //      ->get();
    
        return view('admin.secretary.formsa.view_completed_formsa', compact('workflows'));
    
    }


    public function view_sec_formb_pending(Request $request)
    {

        // return $type;
 
      $workflows_esa = DB::table('tnelb_eb_applications as ta')
            ->whereIn('ta.processed_by', ['A', 'SPRE']) 
            // ->orWhere('ta.application_status', 'F')
            ->orderByDesc('updated_at')
            // ->where('ta.form_id', $formId)
            ->select('ta.*')
           
            ->get();

    // $workflows_esa = DB::table('tnelb_eb_applications as ta')
    //         ->whereIn('ta.processed_by', ['A', 'SPRE']) 
    //         ->orWhere('ta.application_status', 'F')
    //         ->orderByDesc('updated_at')
    //         // ->where('ta.form_id', $formId)
    //         ->select('ta.*')
           
    //         ->get();

            // ---------------

    //    $workflows = DB::table('tnelb_eb_applications as ta')
    // ->where(function($q) {
    //     $q->where('ta.processed_by', '=', 'A')
    //       ->orWhereIn('ta.application_status', ['RF', 'F']);
    // })
    // ->orderby('updated_at', 'DESC')
    // // ->where('ta.appl_type', '=', 'N')
    // ->select('ta.*')
    // ->get();

        // $workflows = DB::table('tnelb_eb_applications as ta')
        //     ->where('ta.processed_by', 'A')
        //     ->orWhere('ta.application_status', 'RF')
        //     // ->where('ta.form_id', $formId)
        //     ->select('ta.*')
        //     ->get();

        // dd($workflows->first()->form_name);
        // exit;

         
    return view('admin.secretary.formb.view_pending_formb', compact('workflows_esa'));
            
            
    
       
    
    }


        public function view_sec_formb_completed(Request $request)
    {
     $workflows = DB::table('tnelb_eb_applications as ta')
        ->whereIn('ta.application_status', ['F','A', 'RE'])
        ->orderByDesc('updated_at')
            // ->where('ta.form_id', $formId)
            ->select('ta.*')
            ->get();
        // $formId = $request->query('form_id');
    
       // $workflows = DB::table('tnelb_eb_applications as ta')
       //      ->whereIn('ta.processed_by', ['A', 'SPRE']) 
       //      ->orWhere('ta.application_status', 'RF')
       //      // ->where('ta.form_id', $formId)
       //      ->select('ta.*')
       //      ->get();

       $applicationIds = $workflows->pluck('application_id');

    // Fetch from both tables
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
    
        return view('admin.secretary.formb.view_completed_formb', compact('workflows',
        'licenses',
        'renewalLicenses'));
    
    }


    // ---------------president----------------
    
     public function president_completed_formb(Request $request)
    {
        // dd($request->application_id);
        // exit;
        // return $type;

        $formId = $request->query('form_id');

        $workflows = B_Application::whereIn('application_status', ['A', 'RF'])
                ->where('processed_by', 'PR')
                ->orderBy('updated_at', 'DESC')
                ->get();

                 $applicationIds = $workflows->pluck('application_id');

    // Fetch from both tables
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

        return view('admin.president.formb.formb_completed', compact( 'workflows',
        'licenses',
        'renewalLicenses'));
     
    }

        public function president_pending_formb(Request $request)
    {


        $formId = $request->query('form_id');


        $workflows_esa = B_Application::whereIn('application_status', ['F', 'RF'])
            ->whereIn('processed_by', ['SE'])
            ->orderBy('updated_at', 'DESC')
            ->get();

       
            return view('admin.president.formb.formb_pendings', compact('workflows_esa'));
       
    }


    // ----------completed--------------

     public function applicants_detail_formb_completed($applicant_id)
    {
        $returnForwardUser = null;

        $staff = Auth::user();


        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }



  

    $applicant = DB::table('tnelb_eb_applications')
        ->leftJoin('payments', 'tnelb_eb_applications.application_id', '=', 'payments.application_id')
        ->where('tnelb_eb_applications.application_id', $applicant_id)
        ->where('payments.payment_status', 'success')
        ->select(
            'tnelb_eb_applications.*',
                'payments.transaction_id',
                'payments.payment_status',
                'payments.amount',
                'payments.payment_mode',
                'payments.created_at as payment_date',
                'payments.application_fee',
                'payments.late_fee',
                
        )->orderByDesc('dt_submit')
        ->first();

 


        $formname = $applicant->form_name;

        $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();
      
      

        if (!$applicant) {
            return abort(404, 'Applicant not found');
        }


        if ($staff->name === "Supervisor") {

            if ($applicant->application_status == 'RE') {

                // $processed_by = match ($applicant->processed_by) {
                //     'PR'  => 'President',
                //     'SE'  => 'Secretary',
                //     'S'  => 'Supervisor',
                //     'A'  => 'Accountant'
                // };

                // $nextForwardUser = DB::table('mst__staffs__tbls')
                //     ->where('name', $processed_by)
                //     ->select('name', 'roles_id')
                //     ->first(); 

                $nextForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'Secretary')
                    ->select('name', 'roles_id')
                    ->first();
            } else {
                $nextForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'Accountant')
                    ->select('name', 'roles_id')
                    ->first();
            }

            // if ($applicant->application_status == 'RE') {

            //     $processed_by = match ($applicant->processed_by) {
            //         'PR'  => 'President',
            //         'SE'  => 'Secretary',
            //         'S'  => 'Supervisor',
            //         'A'  => 'Accountant'
            //     };

            //     $nextForwardUser = DB::table('mst__staffs__tbls')
            //         ->where('name', $processed_by)
            //         ->select('name', 'roles_id')
            //         ->first();

            //         // dd($nextForwardUser);
            //         // exit;
            // } else {
            //     $nextForwardUser = DB::table('mst__staffs__tbls')
            //         ->where('name', 'Accountant')
            //         ->select('name', 'roles_id')
            //         ->first();

            // }
        }

        if ($staff->name === "Supervisor2") {
            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Accountant')
                ->select('name', 'roles_id')
                ->first();
        }


        if ($staff->name === "Accountant") {
            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Secretary')
                ->select('name', 'roles_id')
                ->first();
        }
        if ($staff->name === "Secretary") {

            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'President')
                ->select('name', 'roles_id')
                ->first();


            $returnForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Supervisor')
                ->select('name', 'roles_id')
                ->first();
        }

        if ($staff->name === "President") {

            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'President')
                ->select('name', 'roles_id')
                ->first();

            $returnForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Supervisor')
                ->select('name', 'roles_id')
                ->first();
        }



        $proprietordetailsform_A = DB::table('proprietordetailsform_A')
            ->where('application_id', $applicant_id)
            ->orderBy('id', 'Desc')
            ->where('proprietor_flag', '1')
            ->get();


         $staffdetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $applicant_id)
            ->orderBy('id')
            ->get();

        $showQcWarning = false;


        $licence_name_validitystaff = MstLicence::where('form_code', $formname)->first();

        if ($licence_name_validitystaff && $staffdetails->count() > 0) {

            $today = Carbon::today()->toDateString();
            $applType = trim($applicant->appl_type); // N or R

            /* -----------------------------
       Get fees validity
    ------------------------------ */
            $licence_validitystaff = FeesValidity::where('licence_id', $licence_name_validitystaff->id)
                ->where('form_type', $applType === 'N' ? 'N' : 'R')
                ->where('status', 1)
                ->whereDate('validity_start_date', '<=', $today)
                ->orderBy('validity_start_date', 'desc')
                ->first();

            if ($licence_validitystaff && $licence_validitystaff->validity) {

                /* -----------------------------
                Compare FIRST QC validity
                ------------------------------ */
                $firstQcValidity = Carbon::parse($staffdetails->first()->cc_validity);

                // dd($staffdetails->first()->cc_validity);
                // exit;



                // Licence period (months)
                $licencePeriodEnd = Carbon::now()->addMonths((int) $licence_validitystaff->validity);
                // dd($licencePeriodEnd);
                // exit;

                if ($firstQcValidity->lt($licencePeriodEnd)) {
                    $showQcWarning = true;
                }
            }
        }


       


        $staff = Auth::user();
        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }


        $user_entry = DB::table('tnelb_eb_applications')
            ->where('application_id', $applicant_id)
            ->select('*')
        
        ->first();

        $documents = DB::table('tnelb_applicant_doc_A')
            ->where('application_id', $applicant_id)
            ->select('*')
          
            ->first();


        $workflows = DB::table('tnelb_workflow_a')
            ->leftjoin('tnelb_eb_applications', 'tnelb_workflow_a.application_id', '=', 'tnelb_eb_applications.application_id')
            ->leftjoin('mst__roles', 'tnelb_workflow_a.forwarded_to', '=', 'mst__roles.id')
            ->where('tnelb_workflow_a.application_id', $applicant_id)
            ->select('tnelb_workflow_a.*', 'mst__roles.name', 'tnelb_eb_applications.form_name', 'tnelb_eb_applications.license_name')
            ->orderBy('tnelb_workflow_a.id', 'desc')
            ->get();

        // var_dump($workflows);die;

        $queries = DB::table('tnelb_query_applicable as qa')
            ->leftJoin('tnelb_eb_applications as ta', 'qa.application_id', '=', 'ta.application_id')
            ->where('qa.application_id', $applicant_id)
            ->where('qa.query_status', 'P')
            ->select('qa.*')
            ->first() ?? null;

        $showbankWarning = false;

        $banksolvency = Tnelb_banksolvency_a::where('application_id', $applicant_id)->where('status', '1')->first();



        $bankValidity = Carbon::parse($banksolvency->bank_validity);

       $equiplist = Mst_equipment_tbl::where('equip_licence_name', 10)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            // ->where('login_id', Auth::user()->login_id)
            ->where('application_id', $applicant_id) // IMPORTANT
            ->get();



        // $view = match ($staff->name) {
        //     'President'  => 'admin.dashboard.applicants_president_forma',
        //     'Secretary'  => 'admin.dashboard.applicants_detail_sec_forma',
        //     'Supervisor' => 'admin.dashboard.applicants_detail_forma',
        //     // 'Supervisor2' => 'admin.dashboard.applicants_detail_supervisor',
        //     'Accountant'    => 'admin.dashboard.applicants_detail_auditor_forma',

        //     default      => abort(403, 'Unauthorized'),
        // };



                    $view = match ($staff->name) {
                    'President'  => 'admin.completedappls.formb.applicants_formb_completed',
                    'Secretary'  => 'admin.completedappls.formb.applicants_formb_completed',
                    'Supervisor' => 'admin.completedappls.formb.applicants_formb_completed',
                    // 'Supervisor2' => 'admin.dashboard.applicants_detail_supervisor',
                    'Accountant'    => 'admin.completedappls.formb.applicants_detail_auditor_formb_completed',

                    default      => abort(403, 'Unauthorized'),
                };
            

        return view($view, compact(
            'applicant',
            'proprietordetailsform_A',
            'staffdetails',
            'showQcWarning',
            'nextForwardUser',
            'returnForwardUser',
            'user_entry',
            'workflows',
            'queries',
            'documents',
            'banksolvency',
            'equipmentlist',
            'license_name',
            'equiplist',
            'equipmentlist',
            'showbankWarning'
        ));
    }
}
