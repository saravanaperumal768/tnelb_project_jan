<?php

namespace App\Http\Controllers\Admin;

use App\Models\EA_Application_model;
use App\Models\ESA_Application_model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditorController extends Controller
{
    public function index()
    {
        $applications = DB::table('tnelb_application_tbl')
            ->select('*')
            ->get();

        return view('admin.dashboards.auditor', compact('applications'));
    }

    public function view(Request $request)
    {
// dd('111');
// exit;
        $formId = $request->query('form_id');

        $new_applications = DB::table('tnelb_application_tbl as ta')
            ->where('ta.appl_type', 'N')
            ->where('ta.form_id', $formId)
            ->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereIn('ta.status', ['F'])
                        ->where('ta.processed_by', 'S');
                })
                    ->orWhere('ta.processed_by', 'S2');
            })
            ->select('ta.*')
            ->orderByDesc('ta.id')
            ->get();


        // var_dump($new_applications);die;

        $renewal_applications = DB::table('tnelb_application_tbl as ta')
            ->where('ta.appl_type', 'R')
            ->where('ta.form_id', $formId)
            ->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereIn('ta.status', ['F'])
                        ->where('ta.processed_by', 'S');
                })
                    ->orWhere('ta.processed_by', 'S2');
            })
            ->select('ta.*')
            ->orderByDesc('ta.id')
            ->get();



        return view('admin.auditor.view', compact('new_applications', 'renewal_applications'));
    }
    public function view_completed(Request $request)
    {

        $formId = $request->query('form_id');

        if ($formId == 2) {

            $workflows = DB::table('tnelb_application_tbl as ta')
                ->whereIn('ta.processed_by', ['S2', 'A', 'SE', 'PR'])
                ->where('ta.form_id', $formId)
                ->where(function ($query) {
                    $query->where('ta.status', 'A')
                        ->orWhere('ta.status', 'F');
                })
                ->select('ta.*')
                ->orderByDesc('ta.id')
                ->get();
        } else {
            $workflows = DB::table('tnelb_application_tbl as ta')
                ->whereIn('ta.processed_by', ['SE', 'PR', 'A'])
                ->where('ta.form_id', $formId)
                ->where(function ($query) {
                    $query->where('ta.status', 'A')
                        ->orWhere('ta.status', 'F');
                })
                ->select('ta.*')
                ->orderByDesc('ta.id')
                ->get();


            // $workflows = DB::table('tnelb_application_tbl as ta')
            // ->where('ta.status',['F','A'])
            // ->where('ta.processed_by',['A'])
            // ->where('ta.status', '!=', 'RF')
            // ->where('ta.appl_type','N')
            // ->orWhere('ta.processed_by','S2')
            // ->where('ta.form_id', $formId)
            // ->select('ta.*')
            // ->orderByDesc('ta.id')
            // ->get();

            // dd($workflows);die;

        }


        return view('admin.supervisor.completed', compact('workflows'));
    }

   public function view_forma_pending($type)
    {

        $userRole = Auth::user()->roles_id;

        // EA Applications Query
        $eaQuery = DB::table('tnelb_ea_applications')
            ->whereIn('application_status', ['F'])
            ->whereIn('processed_by', ['S'])
            ->select(
                'application_id',
                'form_name',
                'application_status',
                'processed_by',
                'dt_submit',
                DB::raw("'EA' as source_table")
            );

     

        // Combine both queries
        $unionQuery = $eaQuery;

        // Execute the union and order globally
        $workflows = DB::query()
            ->fromSub($unionQuery, 'combined')
            ->orderBy('dt_submit', 'DESC')
            ->get();

        // Handle if no results
      

        // Identify source (EA or ESA) using the alias we added
        $sourceTable = $workflows->first()->source_table ?? null;
    

        // Prepare individual lists (for passing to respective views)
        $workflows_ea = DB::table('tnelb_ea_applications')
            ->whereIn('application_status', ['F'])
            ->whereIn('processed_by', ['S'])
            ->orderBy('dt_submit', 'DESC')
            ->get();

           
        // Load view based on type
     
            return view('admin.auditor.view_forma', compact('workflows_ea'));
        
    }



    public function view_forma_completed()
    {
        $userRole = Auth::user()->roles_id;

// , 'RE'
   $workflows = EA_Application_model::whereIn('application_status', ['F', 'A', 'RE', 'SPRE'])
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


           
        return view('admin.auditor.completed_forma', compact( 'workflows',
        'licenses',
        'renewalLicenses'));
    }

    public function view_rejected(Request $request)
    {

        $page_title = 'Rejected';
        $formId = $request->query('form_id');



        if ($formId == 2) {

            $workflows = DB::table('tnelb_application_tbl as ta')
                // ->whereIn('ta.processed_by', ['S2','A','SE'])
                ->where('ta.form_id', $formId)
                ->where('ta.status', 'RJ')
                ->select('ta.*')
                ->get();
        } else {
            $workflows = DB::table('tnelb_application_tbl as ta')
                // ->whereIn('ta.processed_by', ['SE','PR','A'])
                ->where('ta.form_id', $formId)
                ->where('ta.status', 'RJ')
                ->select('ta.*')
                ->get();
        }


        return view('admin.supervisor.rejected', compact('workflows', 'page_title'));
    }
}
