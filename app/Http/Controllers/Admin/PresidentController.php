<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\EA_Application_model;
use App\Models\ESA_Application_model;
use Illuminate\Http\Request;

class PresidentController extends Controller
{
    public function index()
    {
        $applications = DB::table('tnelb_application_tbl')
            ->where('status', '!=', 'R') // President only sees approved applications
            ->get();

        return view('admin.dashboards.president', compact('applications'));
    }

    public function completed_president(Request $request)
    {

        $formId = $request->query('form_id');

        $workflows = EA_Application_model::where('status', 'A')
            ->where('form_id', $formId)
            ->get();

        return view('admin.secretary.completed', compact('workflows'));
    }

    public function president_pending_forma(Request $request, $type)
    {


        $formId = $request->query('form_id');

        $workflows = EA_Application_model::whereIn('application_status', ['F', 'RF'])
            ->whereIn('processed_by', ['SE'])
            ->orderBy('updated_at', 'DESC')
            ->get();

        $workflows_esa = ESA_Application_model::whereIn('application_status', ['F', 'RF'])
            ->whereIn('processed_by', ['SE'])
            ->orderBy('updated_at', 'DESC')
            ->get();

    

        return view('admin.president.forma_pendings', compact('workflows'));
        
    }

    public function president_completed_forma(Request $request)
    {
        // dd($request->application_id);
        // exit;
        // return $type;

        $formId = $request->query('form_id');


             $workflows = EA_Application_model::whereIn('application_status', ['A', 'RF'])
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

            return view('admin.president.forma_completed', compact( 'workflows',
        'licenses',
        'renewalLicenses'
    ));
        


    }
}
