<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Admin\ApplicationModel;
use App\Models\Admin\FormaModel;
use App\Models\Admin\UserModel;
use App\Models\TnelbApplicantPhoto;

class CompletedApplsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($applicant_id)
    {
  
        $returnForwardUser = null;
        // Fetch applicant details
        $applicant = DB::table('tnelb_application_tbl')
        ->join('payments', 'tnelb_application_tbl.application_id', '=', 'payments.application_id')
        ->where('tnelb_application_tbl.application_id', $applicant_id)
        ->select('tnelb_application_tbl.*', 'payments.*')
        ->first();
        

        
        if (!$applicant) {
            return abort(403, 'Applicant not found');
        }


        // var_dump($applicant);die;
        
        if($applicant->appl_type == "R"){
            
            $ids = [$applicant->old_application, $applicant_id];
            
            // Fetch educational qualifications
            $educationalQualifications = DB::table('tnelb_applicants_edu')
            ->where('application_id', $ids)
                ->get();
                
                // Fetch work experience
                $workExperience = DB::table('tnelb_applicants_exp')
                ->where('application_id', $ids)
                ->get();
                
            // Fetch documents
            $documents = DB::table('tnelb_applicants_doc')
            ->where('application_id', $ids)
            ->get();
            
            // Get the last uploaded photo (if available)
            $uploadedPhoto = TnelbApplicantPhoto::where('application_id', $ids)
            ->whereNotNull('upload_path')
            ->orderByDesc('id')
            ->first();

            // var_dump($workExperience);die;
                
        }else{
            
            // Fetch educational qualifications
            $educationalQualifications = DB::table('tnelb_applicants_edu')
            ->where('application_id', $applicant_id)
            ->get();
            
                // Fetch work experience
            $workExperience = DB::table('tnelb_applicants_exp')
                ->where('application_id', $applicant_id)
                ->get();

            // Fetch documents
            $documents = DB::table('tnelb_applicants_doc')
                ->where('application_id', $applicant_id)
                ->get();
                
            // Get the last uploaded photo (if available)
            $uploadedPhoto = TnelbApplicantPhoto::where('application_id', $applicant_id)
            ->whereNotNull('upload_path')
            ->orderByDesc('id')
            ->first();

        }

       
        

        // Get the current user's role ID
        $staff = Auth::user();


        if (!$staff || !$staff->roles_id) {
            return abort(403, 'Unauthorized');
        }

        // Fetch next role dynamically from the roles table
        if ($staff->name === "Supervisor") {

            if ($applicant->status == 'RE') {

                $processed_by = match ($applicant->processed_by) {
                    'PR'  => 'President',
                    'SE'  => 'Secretary',
                    'S'  => 'Supervisor',
                    'A'  => 'Auditor'
                };
                
                $nextForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', $processed_by)
                    ->select('name', 'roles_id')
                    ->first();

            } else {
                $nextForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'Auditor')
                    ->select('name', 'roles_id')
                    ->first();
            }
        }


        if ($staff->name === "Supervisor2") {
            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Auditor')
                ->select('name', 'roles_id')
                ->first();
        }


        if ($staff->name === "Auditor") {
            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Secretary')
                ->select('name', 'roles_id')
                ->first();
        }
        if ($staff->name === "Secretary") {

            if ($applicant->form_id == 1) {

                $nextForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'President')
                    ->select('name', 'roles_id')
                    ->first();

                $returnForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'Supervisor')
                    ->select('name', 'roles_id')
                    ->first();
            } else {

                $nextForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'Secretary')
                    ->select('name', 'roles_id')
                    ->first();

                $returnForwardUser = DB::table('mst__staffs__tbls')
                    ->where('name', 'Supervisor')
                    ->select('name', 'roles_id')
                    ->first();
            }
        }

        if ($staff->name === "President") {

            $nextForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'President')
                ->select('roles_id')
                ->first();

            $returnForwardUser = DB::table('mst__staffs__tbls')
                ->where('name', 'Supervisor')
                ->select('name', 'roles_id')
                ->first();
        }


        $user_entry = DB::table('tnelb_application_tbl')
            ->where('application_id', $applicant_id) // Filter by specific application
            ->select('*')
            ->first();


        $workflows = DB::table('tnelb_workflow')
            ->leftjoin('tnelb_application_tbl', 'tnelb_workflow.application_id', '=', 'tnelb_application_tbl.application_id')
            ->leftjoin('mst__roles', 'tnelb_workflow.forwarded_to', '=', 'mst__roles.id')
            ->where('tnelb_workflow.application_id', $applicant_id) // Filter by specific application
            ->select('tnelb_workflow.*', 'mst__roles.name', 'tnelb_application_tbl.form_name', 'tnelb_application_tbl.license_name')
            ->orderBy('tnelb_workflow.created_at', 'desc')
            ->get();



        // $queries = DB::table('tnelb_query_applicable as qa')
        // ->leftJoin('tnelb_application_tbl as ta', 'qa.application_id', '=', 'ta.application_id')
        // ->where('qa.application_id', $applicant_id) // Filter by specific application
        // ->where('qa.query_status', 'P') // Filter by query status
        // //->where('qa.forwarded_to', $staff->roles_id) // Filter by query status
        // ->select('qa.*')
        // ->first();

        $queries = DB::table('tnelb_query_applicable as qa')
        ->leftJoin('tnelb_application_tbl as ta', 'qa.application_id', '=', 'ta.application_id')
        ->where('qa.application_id', $applicant_id)
        ->select('qa.*')
        ->orderByDesc('qa.id')
        ->get();
    


        // var_dump($queries);die;


        // Determine view based on user role
        $view = match ($staff->name) {
            'President'  => 'admin.completedappls.index',
            'Secretary'  => 'admin.completedappls.index',
            'Supervisor' => 'admin.completedappls.index',
            'Supervisor2' => 'admin.completedappls.index',
            'Auditor'    => 'admin.completedappls.index',

            default      => abort(403, 'Unauthorized'),
        };

        return view($view, compact('applicant', 'educationalQualifications', 'workExperience', 'uploadedPhoto', 'documents', 'nextForwardUser', 'returnForwardUser', 'workflows', 'queries', 'user_entry'));
    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
