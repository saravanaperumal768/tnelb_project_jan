<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Models\Admin\SupervisorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mst_Form_s_w;

use App\Models\Admin\WorkflowA;

use App\Models\EA_Application_model;


class ApplicationController extends Controller
{
    

    public function get_wh_apps()
    {
        $userRole = Auth::user()->roles_id; // Supervisor Role ID
        $assignedFormID = 3;
        $forms = self::getForms($assignedFormID);
    
        $new_applications = DB::table('tnelb_application_tbl')
        ->where('form_id', $assignedFormID) // Filter by Form S
        ->where('appl_type', 'N') // Filter by Form S
        ->where('payment_status', 'payment') // Filter by Form S
        ->whereIn('status', ['P','RE']) // Only show new applications
        ->select('*')
        ->orderByDesc('id')
        ->get();


        $renewal = DB::table('tnelb_application_tbl')
        ->where('form_id', $assignedFormID) // Filter by Form S
        ->where('appl_type', 'R') // Filter by Form S
        ->whereIn('status', ['P','RE']) // Only show new applications
        ->select('*')
        ->get();
    
        return view('admin.supervisor.view', compact('new_applications','renewal','forms'));
    }

    public function get_applications()
    {
        $userRole = Auth::user()->roles_id; // Supervisor Role ID
        $assignedFormID = Auth::user()->form_id;
        $forms = self::getForms($assignedFormID);
    
        $new_applications = DB::table('tnelb_application_tbl')
        ->where('form_id', $assignedFormID) // Filter by Form S
        ->where('appl_type', 'N') // Filter by Form S
        ->where('payment_status', 'payment') // Filter by Form S
        ->whereIn('status', ['P','RE']) // Only show new applications
        ->select('*')
        ->orderByDesc('id')
        ->get();


        $renewal = DB::table('tnelb_application_tbl')
        ->where('form_id', $assignedFormID) // Filter by Form S
        ->where('appl_type', 'R') // Filter by Form S
        ->whereIn('status', ['P','RE']) // Only show new applications
        ->select('*')
        ->orderByDesc('id')
        ->get();

        // var_dump($renewal);die;
    
        return view('admin.supervisor.view', compact('new_applications','renewal','forms'));
    }

    public function view_application(){
        
    }

    public function getForms($form_id){
        return DB::table('tnelb_forms')
        ->where('id', $form_id) // Filter by Form S
        ->select('*')
        ->first();
    }

    public function get_auditor()
    {
        $userRole = Auth::user()->roles_id; // Supervisor Role ID

        $workflows = DB::table('tnelb_application_tbl as ta')
        ->leftJoin('tnelb_forms as f', 'ta.form_id', '=', 'f.id') // Join forms table
        ->where('ta.status', 'A') // Only show new applications
        ->select('ta.*', 'f.form_name')
        ->get();
    
        return view('admin.application.view', compact('workflows'));
    }


    public function returntoSupervisor(Request $request){

        $staff = Auth::user();
        
        $staffID = Auth::user()->id;


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

        
        if ($request->queryswitch == 'Yes' && !empty($request->queryType)) {
            $query_status = "P";
        }
        


        $formType = DB::table('tnelb_application_tbl')
                        ->where('application_id', $request->application_id)
                        ->select('form_id')
                        ->first();



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
        $workflow = SupervisorModel::create([ // Ensure this is the correct model
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
        DB::table('tnelb_application_tbl')
            ->where('application_id', $request->application_id)
            ->update([
                'status'        => 'RE', // Role-based forwarding
                'processed_by'  => $processed_by, // Role-based forwarding
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

    public function renewal_apps()
    {

        $userRole = Auth::user()->roles_id; // Supervisor Role ID

    

        $assignedFormID = Auth::user()->form_id;

        $forms = self::getForms($assignedFormID);
        
        switch ($userRole) {

            case $userRole == '1':
                $application_details = DB::table('tnelb_application_tbl')
                ->where('form_id', $assignedFormID)
                ->whereIn('status', ['P','RE']) 
                ->where('appl_type', '2')
                ->select('*')
                ->get();
            break;

            case $userRole == '2':
                $application_details = DB::table('tnelb_application_tbl as ta')
                ->where('ta.status',['F','RF'])
                ->where('ta.processed_by','S')
                ->orWhere('ta.processed_by','S2')
                ->where('ta.form_id', $assignedFormID)
                ->where('appl_type', '2')
                ->select('ta.*')
                ->get();
            break;

            case $userRole == '3':
                $application_details = DB::table('tnelb_application_tbl as ta')
                ->where('ta.processed_by', 'A')
                ->orWhere('ta.status', 'RF')
                ->where('ta.form_id', $assignedFormID)
                ->where('appl_type', '2')
                ->select('ta.*')
                ->get();
            break;

            case $userRole == '4':

                $application_details = DB::table('tnelb_application_tbl as ta')
                ->where('ta.processed_by', 'SE')
                ->where('ta.appl_type', '2')
                ->select('ta.*')
                ->get();


            break;
            
            default:
                
            break;
        }


        return view('admin.renewal.renewalapps', compact('application_details'));
    }

     // ----------------forma--------------------------
     public function returntoSupervisorforma(Request $request){

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
        

        $formType = DB::table('tnelb_ea_applications')
                        ->where('application_id', $request->application_id)
                        ->unionAll(DB::table('tnelb_esa_applications')
                        ->where('application_id', $request->application_id))
                        // ->select('form_id')
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
             // DB::table('tnelb_ea_applications')
            //     ->where('application_id', $request->application_id)
            //     ->update([
            //         'application_status'  => 'RE',
            //         'processed_by'  => $processed_by, 
            //         'updated_at' => now(),
            //     ]);
            
          // WorkflowA::where('application_id', $request->application_id)
          //     ->where('processed_by', $request->return_by)
          //     ->where('role_id', $staffID)
          //       ->update([
                
          //           'created_at' => DB::raw('NOW()'),
          //       ]);

                WorkflowA::where('application_id', $request->application_id)
                 ->where('processed_by', $request->return_by)
                 ->where('role_id', $staffID)
                ->orderByDesc('id')
                ->limit(1)
                ->update([
                    'created_at' => DB::raw('NOW()'),
                ]);

        

        EA_Application_model::where('application_id', $request->application_id)
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


    public function rejectApplication(Request $request)
    {

        // Validate basic fields
        $request->validate([
            'application_id' => 'required|string',
            'appl_status'    => 'required|string|in:RJ',
            'action_by'      => 'required|string|max:255',
            'login_id'       => 'required|string',  // or your staff table
        ]);

        // Insert into workflow table (recommended approach)


        DB::table('tnelb_workflow')->insert([
            'application_id' => $request->application_id,
            'processed_by'   => $request->action_by,
            'role_id'        => Auth::user()->roles_id, // Current user role (Secretary)
            'appl_status'    => $request->appl_status,
            'reject_reason' => $request->reason??'',
            'created_at'     => now(),
            'login_id'         =>$request->login_id
        ]);


        // Also update applications table (set status to Rejected)
        Mst_Form_s_w::where('application_id', $request->input('application_id'))
            ->update([
                'status'     => $request->appl_status, // RJ
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Application rejected!',
        ]);
    }


    public function get_rejected()
    {
        $page_title = 'Rejected';
        $userRole = Auth::user()->roles_id; // Get logged-in user's role
        $assignedFormID = Auth::user()->form_id;

        $workflows = DB::table('tnelb_application_tbl')
            ->where('form_id', $assignedFormID) // Filter by Form S
            ->where('status', 'RJ') // Only show new applications
            // ->whereIn('processed_by', ['S', 'A', 'SE', 'PR']) // Only show new applications
            ->select('*')
            ->get();

        return view('admin.supervisor.rejected', compact('workflows', 'page_title'));
    }

}
