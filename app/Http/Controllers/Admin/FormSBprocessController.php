<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mst_equipment_tbl;
use Illuminate\Http\Request;


use App\Models\Admin\WorkflowA;
use App\Models\Equipment_storetmp_A;
use App\Models\Equipment_storetmp_sb;
use App\Models\ESA_Application_model;
use App\Models\ESB_Application_model;
use App\Models\Tnelb_banksolvency_a;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormSBprocessController extends Controller
{
     public function view_formsb()
    {
        $userRole = Auth::user()->roles_id;

        $assignedForms = DB::table('tnelb_esb_applications as ta')
            ->whereIn('ta.application_status', ['P', 'RE']) // Filter by status
            ->select('ta.*') // Select all columns from applicant_formA
            ->get();


        // var_dump($assignedForms);die;

        $workflows = DB::table('tnelb_esb_applications')
            ->whereIn('application_status', ['P', 'RE'])
            ->where('payment_status', 'paid')
            ->orderBy('updated_at', 'DESC')
            ->select('*')
            ->get();


        $pendinglist_sa = DB::table('tnelb_esb_applications')
            ->whereIn('application_status', ['P', 'RE'])
            ->where('payment_status', 'paid')
            ->orderBy('updated_at', 'DESC')
            ->select('*')
            ->get();

            
        return view('admin.supervisor.formsb.view_formsb', compact('pendinglist_sa'));
        
        // return view('admin.supervisor.view_forma', compact('workflows'));
    }

        public function view_formsb_completed()
    {
        $userRole = Auth::user()->roles_id;

        $workflows = ESB_Application_model::whereIn('application_status', ['F', 'A', 'RE'])
            ->whereIn('processed_by', ['A', 'SE', 'PR'])
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

           
        return view('admin.auditor.formsb.completed_formsb', compact('workflows','licenses',
        'renewalLicenses'));
    }


    // --------------View Formsb---------------------

     public function applicants_detail_formsb($applicant_id)
    {

        
        $returnForwardUser = null;

        $staff = Auth::user();


        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }



  

    $applicant = DB::table('tnelb_esb_applications')
        ->leftJoin('payments', 'tnelb_esb_applications.application_id', '=', 'payments.application_id')
        ->where('tnelb_esb_applications.application_id', $applicant_id)
        ->where('payments.payment_status', 'success')
        ->select(
            'tnelb_esb_applications.*',
                'payments.transaction_id',
                'payments.payment_status',
                'payments.amount',
                'payments.payment_mode',
                'payments.created_at as payment_date',
                'payments.application_fee',
                'payments.late_fee',
                
        )->orderByDesc('created_at')
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

       


        $staff = Auth::user();
        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }


        $user_entry = DB::table('tnelb_esb_applications')
            ->where('application_id', $applicant_id)
            ->select('*')
        
        ->first();

        $documents = DB::table('tnelb_applicant_doc_A')
            ->where('application_id', $applicant_id)
            ->select('*')
          
            ->first();


        $workflows = DB::table('tnelb_workflow_a')
            ->leftjoin('tnelb_esb_applications', 'tnelb_workflow_a.application_id', '=', 'tnelb_esb_applications.application_id')
            ->leftjoin('mst__roles', 'tnelb_workflow_a.forwarded_to', '=', 'mst__roles.id')
            ->where('tnelb_workflow_a.application_id', $applicant_id)
            ->select('tnelb_workflow_a.*', 'mst__roles.name', 'tnelb_esb_applications.form_name', 'tnelb_esb_applications.license_name')
            ->orderBy('tnelb_workflow_a.created_at', 'desc')
            ->get();

        // var_dump($workflows);die;

        $queries = DB::table('tnelb_query_applicable as qa')
            ->leftJoin('tnelb_esb_applications as ta', 'qa.application_id', '=', 'ta.application_id')
            ->where('qa.application_id', $applicant_id)
            ->where('qa.query_status', 'P')
            ->select('qa.*')
            ->first() ?? null;

        $banksolvency = Tnelb_banksolvency_a::where('application_id', $applicant_id)->where('status','1')->first();

        // $equipmentlist = Equipment_storetmp_sb::where('application_id', $applicant_id)->first();

        $equiplist = Mst_equipment_tbl::where('equip_licence_name', 5)
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
                    'President'  => 'admin.dashboard.formsb.applicants_detail_formsb',
                    'Secretary'  => 'admin.dashboard.formsb.applicants_detail_formsb',
                    'Supervisor' => 'admin.dashboard.formsb.applicants_detail_formsb',
                    // 'Supervisor2' => 'admin.dashboard.applicants_detail_supervisor',
                    'Accountant'    => 'admin.dashboard.formsb.applicants_detail_auditor_formsb',

                    default      => abort(403, 'Unauthorized'),
                };
            

        return view($view, compact(
            'applicant',
            'proprietordetailsform_A',
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
            'equiplist'
        ));
    }

     // forward application-------------------------------------------------------------------
      public function forwardApplicationformsb(Request $request, $role)
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


        $applicant = ESB_Application_model::where('application_id', $request->application_id)
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


        // $formType = DB::table('tnelb_esb_applications')
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



        // Update application status
     
             ESB_Application_model::where('application_id', $request->application_id)
                ->update([
                    'application_status' => $status, // Role-based forwarding
                    'processed_by'  => $processed_by, // Role-based forwarding
                    'updated_at' => now(),
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

     public function approveApplicationFormsb(Request $request)
    {
//    dd($request->all());
//         exit;
        $request->validate([
            'application_id' => 'required|string',
            'processed_by'   => 'required|string',
            'forwarded_to'   => 'integer',
            'remarks'        => 'nullable|string',
        ]);

      

        // Fetch the application details
        $application = DB::table('tnelb_esb_applications')
            ->where('application_id', $request->application_id)
            
            ->first();

        if (!$application) {
            return response()->json(['error' => 'Application not found.'], 404);
        }
        $login_id = $application->login_id;


        $formname = $application->form_name;

          $licensename = $request->licensename;

        

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

        
          
              $result =  DB::table('tnelb_esb_applications')
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

                        // dd('R');
                        // exit;

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

//                         dd($request->oldapplicationId);
// exit;

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

                 
                     $formid = DB::table('mst_licences')
                        ->where('cert_licence_code', $licensename)
                        ->where('status', '1')
                        ->first();

                        // dd('N');
                        // exit;

                  $today = Carbon::today()->toDateString();

                    $licenseperiod = DB::table('mst_fees_validity')
                    ->where('licence_id', $formid->id)
                    ->where('form_type', $appl_type)
                    ->where('status', 1)
                    ->whereDate('validity_start_date', '<=', $today)
                    ->orderBy('validity_start_date', 'desc') 
                    ->first();

                    // dd($formid->id);
                    // exit;

                        // dd($appl_type);
                        // exit;
                   
                    $monthsToAdd = $licenseperiod->validity ?? 0;

                    // dd($licenseperiod->validity);
                    // exit;

// H:i:s
                    $expiresAt = now()->copy()->addMonths($monthsToAdd)->format('Y-m-d');


                    // dd($expiresAt);

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


      // ------------------return ------------------------------------------
    public function returntoSupervisorformsb(Request $request){

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
        

        $formType = DB::table('tnelb_esb_applications')
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
       
             DB::table('tnelb_esb_applications')
            ->where('application_id', $request->application_id)
            ->update([
                'application_status'  => 'RE',
                'processed_by'  => $processed_by, 
                'updated_at' => now(),
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
    public function completed_formsb()
    {
        $userRole = Auth::user()->roles_id;

        // $assignedForms = DB::table('tnelb_esb_applications as ta')
        // ->whereIn('ta.application_status', ['F', 'RF','A']) // Filter by status
        // ->select('ta.*') // Select all columns from applicant_formA
        // ->get();


        // var_dump($assignedForms);die;

        $workflows = DB::table('tnelb_esb_applications')
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


        return view('admin.supervisor.formsb.completed_formsb', compact('workflows',
                'licenses',
                'renewalLicenses'));
    }
    // -----------Auditor------------------

      public function view_formsb_pending()
    {

        
// dd('111');exit;
        $userRole = Auth::user()->roles_id;

    

        // ESA Applications Query
        $unionQuery = DB::table('tnelb_esb_applications')
            ->whereIn('application_status', ['F'])
            ->whereIn('processed_by', ['S'])
            ->select(
                'application_id',
                'form_name',
                'application_status',
                'processed_by',
                'created_at',
                DB::raw("'ESB' as source_table")
            );

        // Combine both queries
      

        // Execute the union and order globally
        $workflows = DB::query()
            ->fromSub($unionQuery, 'combined')
            ->orderBy('created_at', 'DESC')
            ->get();

     

        // Identify source (EA or ESA) using the alias we added
        $sourceTable = $workflows->first()->source_table ?? null;
    

        $workflows_esa = DB::table('tnelb_esb_applications')
            ->whereIn('application_status', ['F'])
            ->whereIn('processed_by', ['S'])
            ->orderBy('created_at', 'DESC')
            ->get();
    
        // Load view based on type
        
        return view('admin.auditor.formsb.view_formsb', compact('workflows_esa'));
       
    }


        // ------------secretary-------------------------

     public function view_sec_formsa_completed(Request $request)
    {
     $workflows = DB::table('tnelb_esb_applications as ta')
        ->whereIn('ta.application_status', ['F','A', 'RE'])
        ->orderByDesc('updated_at')
            // ->where('ta.form_id', $formId)
            ->select('ta.*')
            ->get();
        // $formId = $request->query('form_id');
    
       // $workflows = DB::table('tnelb_ea_applications as ta')
       //      ->whereIn('ta.processed_by', ['A', 'SPRE']) 
       //      ->orWhere('ta.application_status', 'RF')
       //      // ->where('ta.form_id', $formId)
       //      ->select('ta.*')
       //      ->get();
    
        return view('admin.secretary.formsa.view_completed_formsa', compact('workflows'));
    
    }


    public function view_sec_formsb_pending(Request $request)
    {

        // return $type;
 
  

    $workflows_esa = DB::table('tnelb_esb_applications as ta')
            ->whereIn('ta.processed_by', ['A', 'SPRE']) 
            ->orWhere('ta.application_status', 'F')
            ->orderByDesc('updated_at')
            // ->where('ta.form_id', $formId)
            ->select('ta.*')
           
            ->get();

            // ---------------

    //    $workflows = DB::table('tnelb_esb_applications as ta')
    // ->where(function($q) {
    //     $q->where('ta.processed_by', '=', 'A')
    //       ->orWhereIn('ta.application_status', ['RF', 'F']);
    // })
    // ->orderby('updated_at', 'DESC')
    // // ->where('ta.appl_type', '=', 'N')
    // ->select('ta.*')
    // ->get();

        // $workflows = DB::table('tnelb_esb_applications as ta')
        //     ->where('ta.processed_by', 'A')
        //     ->orWhere('ta.application_status', 'RF')
        //     // ->where('ta.form_id', $formId)
        //     ->select('ta.*')
        //     ->get();

        // dd($workflows->first()->form_name);
        // exit;

         
    return view('admin.secretary.formsb.view_pending_formsb', compact('workflows_esa'));
            
            
    
       
    
    }


    // ---------------president----------------
    
     public function president_completed_formsb(Request $request)
    {
        // dd($request->application_id);
        // exit;
        // return $type;

        $formId = $request->query('form_id');

        $workflows = ESB_Application_model::whereIn('application_status', ['A', 'RF'])
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

                return view('admin.president.formsb.formsb_completed', compact(  'workflows',
                'licenses',
                'renewalLicenses'
            ));
     
    }

        public function president_pending_formsb(Request $request)
    {


        $formId = $request->query('form_id');


        $workflows_esa = ESB_Application_model::whereIn('application_status', ['F', 'RF'])
            ->whereIn('processed_by', ['SE'])
            ->orderBy('updated_at', 'DESC')
            ->get();

       
            return view('admin.president.formsb.formsb_pendings', compact('workflows_esa'));
       
    }


    // ----------completed--------------

     public function applicants_detail_formsb_completed($applicant_id)
    {
           $returnForwardUser = null;

        $staff = Auth::user();


        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }



  

    $applicant = DB::table('tnelb_esb_applications')
        ->leftJoin('payments', 'tnelb_esb_applications.application_id', '=', 'payments.application_id')
        ->where('tnelb_esb_applications.application_id', $applicant_id)
        ->where('payments.payment_status', 'success')
        ->select(
            'tnelb_esb_applications.*',
                'payments.transaction_id',
                'payments.payment_status',
                'payments.amount',
                'payments.payment_mode',
                'payments.created_at as payment_date',
                'payments.application_fee',
                'payments.late_fee',
                
        )->orderByDesc('created_at')
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

       


        $staff = Auth::user();
        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }


        $user_entry = DB::table('tnelb_esb_applications')
            ->where('application_id', $applicant_id)
            ->select('*')
        
        ->first();

        $documents = DB::table('tnelb_applicant_doc_A')
            ->where('application_id', $applicant_id)
            ->select('*')
          
            ->first();


        $workflows = DB::table('tnelb_workflow_a')
            ->leftjoin('tnelb_esb_applications', 'tnelb_workflow_a.application_id', '=', 'tnelb_esb_applications.application_id')
            ->leftjoin('mst__roles', 'tnelb_workflow_a.forwarded_to', '=', 'mst__roles.id')
            ->where('tnelb_workflow_a.application_id', $applicant_id)
            ->select('tnelb_workflow_a.*', 'mst__roles.name', 'tnelb_esb_applications.form_name', 'tnelb_esb_applications.license_name')
            ->orderBy('tnelb_workflow_a.created_at', 'desc')
            ->get();

        // var_dump($workflows);die;

        $queries = DB::table('tnelb_query_applicable as qa')
            ->leftJoin('tnelb_esb_applications as ta', 'qa.application_id', '=', 'ta.application_id')
            ->where('qa.application_id', $applicant_id)
            ->where('qa.query_status', 'P')
            ->select('qa.*')
            ->first() ?? null;

        $banksolvency = Tnelb_banksolvency_a::where('application_id', $applicant_id)->where('status','1')->first();

          $equiplist = Mst_equipment_tbl::where('equip_licence_name', 5)
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

// dd('111');
// exit;

                    $view = match ($staff->name) {
                     'President'  => 'admin.completedappls.formsb.applicants_formsb_completed',
            'Secretary'  => 'admin.completedappls.formsb.applicants_formsb_completed',
            'Supervisor' => 'admin.completedappls.formsb.applicants_formsb_completed',
            // 'Supervisor2' => 'admin.dashboard.applicants_detail_supervisor',
            'Accountant'    => 'admin.completedappls.formsb.applicants_detail_auditor_formsb_completed',

                    default      => abort(403, 'Unauthorized'),
                };
            

        return view($view, compact(
            'applicant',
            'proprietordetailsform_A',
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
            'equiplist'
        ));
    }


      public function view_sec_formsb_completed(Request $request)
    {
     $workflows = DB::table('tnelb_esb_applications as ta')
        ->whereIn('ta.application_status', ['F','A', 'RE'])
        ->orderByDesc('updated_at')
            // ->where('ta.form_id', $formId)
            ->select('ta.*')
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

  
        // $formId = $request->query('form_id');
    
       // $workflows = DB::table('tnelb_ea_applications as ta')
       //      ->whereIn('ta.processed_by', ['A', 'SPRE']) 
       //      ->orWhere('ta.application_status', 'RF')
       //      // ->where('ta.form_id', $formId)
       //      ->select('ta.*')
       //      ->get();
    
        return view('admin.secretary.formsb.view_completed_formsb', compact('workflows',
        'licenses',
        'renewalLicenses'));
    
    }
  


}
