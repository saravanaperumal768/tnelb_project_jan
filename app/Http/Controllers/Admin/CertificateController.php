<?php

namespace App\Http\Controllers;

use App\Models\Admin\Mst_equipment_tbl;
use App\Models\Tnelb_bankguarantee_a;
use App\Models\Tnelb_banksolvency_a;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function verifycertificate($application_id) {

         $application = DB::table('tnelb_ea_applications')->where('application_id', $application_id)->first() ??
                        DB::table('tnelb_esa_applications')->where('application_id', $application_id)->first() ?? 
                        DB::table('tnelb_eb_applications')->where('application_id', $application_id)->first() ??
                        DB::table('tnelb_esb_applications')->where('application_id', $application_id)->first() ;
        if($application){

            $proprietors = DB::table('proprietordetailsform_A')
                ->where('application_id', $application_id)
                ->where('proprietor_flag', '1')
                ->orderBy('id')->get();
                $draftCount = $proprietors->count();

            $staffs = DB::table('tnelb_applicant_cl_staffdetails')->where('application_id', $application_id)->orderBy('id', 'ASC')->get();
            $document = DB::table('tnelb_applicant_doc_A')->where('application_id', $application_id)->first();

            $license_details = DB::table('tnelb_license')
            ->where('application_id', $application_id)
            ->select('*')
            ->first();

              
        $banksolvency = Tnelb_banksolvency_a::where('application_id', $application_id)->where('status','1')->first()??
                        Tnelb_bankguarantee_a::where('application_id', $application_id)->where('status','1')->first();

         $equiplist = Mst_equipment_tbl::where('equip_licence_name', 7)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            // ->where('login_id', Auth::user()->login_id)
            ->where('application_id', $application_id)
            ->get();

            dd(
                $application,
                $proprietors,
                $staffs,
                $document,
                $license_details,
                $banksolvency,
                $equiplist,
                $equipmentlist
            );



        }
        else{
            dd('No Data Found');
        }
            


       
    }
}
