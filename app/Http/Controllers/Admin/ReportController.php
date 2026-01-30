<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\ReportsModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
                return DataTables::eloquent(ReportsModel::query())->make(true);
            // $data = ReportsModel::get_wcert_all();
        }

        return view('admin.reports.wcert_reports');
    }

    public function get_whcert(Request $request)
    {
        if ($request->ajax()) {
            $get_all_cert = DB::table('whcert')
            ->orderBy('appsno', 'asc')
            ->limit(10)->get();

            return DataTables::of($get_all_cert)->make(true);

        }

        return view('admin.reports.whcert_reports');
    }

    public function get_filter_data(Request $request)
    {

        $query = DB::table('wcert')
        ->select([
            'sno', 'appsno', 'certcode', 'certno', 'recdate', 'issuedt',
            'fromdate', 'todate', 'rstatus', 'status', 'rendate1', 'rendate2',
            'rencount', 'prnflag', 'dupprnflag', 'appname', 'fname', 'add1',
            'add2', 'add3', 'add4', 'district', 'pincode', 'place', 'qualdet',
            'issuedby', 'renid', 'dt', 'frdate1', 'frdate2', 'print', 'editauth',
            'vdate', 'city1', 'qual1', 'workwith', 'remark'
        ])
        ->unionAll(
            DB::table('whcert')->select([
                'sno', 'appsno', 'certcode', 'certno', 'recdate', 'issuedt',
                'fromdate', 'todate', 'rstatus', 'status', 'rendate1', 'rendate2',
                'rencount', 'prnflag', 'dupprnflag', 'appname', 'fname', 'add1',
                'add2', 'add3', 'add4', 'district', 'pincode', 'place', 'qualdet',
                'issuedby', 'renid', 'dt', 'frdate1', 'frdate2', 'print', 'editauth',
                'vdate', DB::raw('NULL as city1'), DB::raw('NULL as qual1'),
                DB::raw('NULL as workwith'), DB::raw('NULL as remark')
            ])
        );

        $query = DB::query()->fromSub($query, 'merged');


        // var_dump($request->cert_no);die;


        if ($request->filled('certcode')) {
            $query->where('certcode', $request->certcode);
        }
        if ($request->filled('appsno')) {
            $query->where('appsno', $request->appsno);
        }
        if ($request->filled('certno')) {
            $query->where('certno', $request->certno);
        }
        if ($request->filled('renid')) {
            $query->where('renid', $request->ren_id);
        }
        // if ($request->filled('from_date')) {
        //     $query->whereDate('recdate', '>=', $request->input('from_date'));
        // }
        // if ($request->filled('to_date')) {
        //     $query->whereDate('recdate', '<=', $request->input('to_date'));
        // }

        $results = $query->orderBy('appsno', 'asc');

        // return response()->json($results);
        return DataTables::of($results)->make(true);

    
    }

    public function mic_report()
    {
        return view('admin.reports.mic_reports');
    }

    public function get_mic_report(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('tnelb_application_tbl');

            if ($request->filled('form_type')) {
                $query->where('form_name', $request->form_type);
            }

            if ($request->filled('license_name')) {
                $query->where('license_name', $request->license_name);
            }

            if ($request->filled('apps_status')) {
                $query->where('status', $request->apps_status);
            }

            if ($request->filled('date_range')) {
                $range = explode(' to ', $request->date_range);
                if (count($range) === 2) {
                    $from = date('Y-m-d 00:00:00', strtotime($range[0]));
                    $to   = date('Y-m-d 23:59:59', strtotime($range[1]));
                    $query->whereBetween('created_at', [$from, $to]);
                }
            }


            return DataTables::of($query)->make(true);
        }

        return view('admin.reports.mic_reports');
    }

}
