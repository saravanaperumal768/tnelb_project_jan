<?php

namespace App\Http\Controllers;

use App\Models\Admin\Mst_equipment_tbl;
use App\Models\EA_Application_model;
use App\Models\Equipment_storetmp_A;
use App\Models\mst_workflow;
use App\Models\Payment;
use App\Models\ProprietorformA;
use App\Models\Tnelb_banksolvency_a;
use App\Models\TnelbApplicantStaffDetail;
// use Illuminate\Contracts\Validation\Rule;
use App\Models\TnelbApplicantPhoto;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EA_RenewalController extends BaseController
{


// ------------form A draft and renew-------------
      public function renew_form($appl_id)
    {

        if (!Auth::check()) {
            return redirect()->route('logout');
        }

        if (!$appl_id) {
            return redirect()->route('dashboard')->with('error', 'Application ID is required.');
        }

        $application_details = DB::table('tnelb_application_tbl')
            ->where('application_id', $appl_id)
            ->select('*')
            ->first();


        if (!$application_details) {
            return redirect()->route('dashboard')->with('error', 'Application not found.');
        }
        $licence_name = DB::table('mst_licences')->where('form_code', $application_details->form_name)->first();

        $edu_details = DB::table('tnelb_applicants_edu')
            ->where('application_id', $appl_id)
            ->select('*')
            ->get();

        $exp_details = DB::table('tnelb_applicants_exp')
            ->where('application_id', $appl_id)
            ->select('*')
            ->get();

        $apps_doc = DB::table('tnelb_applicants_doc')
            ->where('application_id', $appl_id)
            ->select('*')
            ->get();


        $license_details = DB::table('tnelb_license')
            ->where('application_id', $appl_id)
            ->select('*')
            ->first();

        $applicant_photo = TnelbApplicantPhoto::where('application_id', $appl_id)->first();



         $uploadedPhotos = $apps_doc->pluck('upload_photo')->filter()->values();

        $uploadedPhotos = $uploadedPhotos->isEmpty() ? '' : $uploadedPhotos;

        //  $banksolvency = Tnelb_banksolvency_a::where('application_id', $appl_id)->where('status','1')->first();

        // $equipmentlist = Equipment_storetmp_A::where('application_id', $appl_id)->first();


        $applicationid = $appl_id;
        return view('user_login.renew-form', compact('applicationid', 'application_details', 'edu_details', 'exp_details', 'apps_doc', 'license_details', 'uploadedPhotos', 'applicant_photo', 'licence_name'));
    }


     public function renew_form_ea($application_id){

   

        if (!Auth::check()) {
            return redirect()->route('logout');
        }

        if (!$application_id) {
            return redirect()->route('dashboard')->with('error', 'Application ID is required.');
        }
        
        // $application = EA_Application_model::where('application_id', $application_id)->first();
        
        $old_license_number= DB::table('tnelb_license')->where('application_id', $application_id)->first();

        // var_dump($license_deatails->license_number);die;

        
        $application = null;
        $proprietors = collect();
        $staffs = collect();
        $document = collect();

        if ($application_id) {
            $application = DB::table('tnelb_ea_applications')->where('application_id', $application_id)->first();
            $proprietors = DB::table('proprietordetailsform_A')
                ->where('application_id', $application_id)
                ->where('proprietor_flag', '1')
                ->orderBy('id')->get();
                $draftCount = $proprietors->count();

            $staffs = DB::table('tnelb_applicant_cl_staffdetails')->where('application_id', $application_id)->orderBy('id', 'ASC')->get();
            $document = DB::table('tnelb_applicant_doc_A')->where('application_id', $application_id)->first();

            $today = \Carbon\Carbon::today();
            // dd($today);
            // exit;

            $license_details = DB::table('tnelb_license')
            ->where('application_id', $application_id)
            ->where('expires_at','<', $today)
            ->select('*')
            ->first();
            // dd($license_details->expires_at);
            // exit;

            // if($license_details){
            //    return redirect()
            //     ->route('apply-form-a')
            //     ->with('expired_license', true)
            //     ->with('expired_date', \Carbon\Carbon::parse($license_details->expires_at)->format('d-m-Y'));
            // }
            

            
        $banksolvency = Tnelb_banksolvency_a::where('application_id', $application_id)->where('status','1')->first();

        // $equipmentlist = Equipment_storetmp_A::where('application_id', $application_id)->first();

         

             $equiplist = Mst_equipment_tbl::where('equip_licence_name', 8)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            ->where('login_id', Auth::user()->login_id)
            ->where('application_id', $application_id) // IMPORTANT
            ->get();


        }

        return view('user_login.renew-form_ea', compact ('application', 'proprietors', 'staffs', 'draftCount', 'document','license_details', 'banksolvency', 'equiplist', 'equipmentlist', 'old_license_number'));
    }


     // ----------------------------draft
    public function edit($application_id)
    {
        $application = null;
        $proprietors = collect();
        $staffs = collect();
        $document = collect();

        if ($application_id) {
            $application = DB::table('tnelb_ea_applications')->where('application_id', $application_id)->first();
            $proprietors = DB::table('proprietordetailsform_A')
                ->where('application_id', $application_id)
                ->where('proprietor_flag', '1')
                ->orderBy('id')->get();
                $draftCount = $proprietors->count();

            $staffs = DB::table('tnelb_applicant_cl_staffdetails')->where('application_id', $application_id)->orderBy('id', 'ASC')->get();
            $document = DB::table('tnelb_applicant_doc_A')->where('application_id', $application_id)->first();
            $banksolvency = Tnelb_banksolvency_a::where('application_id', $application_id)->where('status','1')->first();

            $equipmentlist = Equipment_storetmp_A::where('application_id', $application_id)->first();

             $equiplist = Mst_equipment_tbl::where('equip_licence_name', 8)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            ->where('login_id', Auth::user()->login_id)
            ->where('application_id', $application_id) // IMPORTANT
            ->get();

            // var_dump()
        }

        return view('user_login.apply-form-a', compact('application', 'proprietors', 'draftCount', 'staffs', 'document', 'banksolvency' , 'equipmentlist', 'equiplist'));
    }



      public function edit_renewaldraft($application_id)
    {

        // dd($application_id);
        // exit;
        $application = null;
        $proprietors = collect();
        $staffs = collect();
        $document = collect();

        if ($application_id) {
            $application = DB::table('tnelb_ea_applications')->where('application_id', $application_id)->first();
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

              
        $banksolvency = Tnelb_banksolvency_a::where('application_id', $application_id)->where('status','1')->first();

        $equipmentlist = Equipment_storetmp_A::where('application_id', $application_id)->first();

            // dd($license_details);
            // exit;
        }

        return view('user_login.renew-form_ea', compact('application', 'proprietors', 'draftCount', 'staffs', 'document', 'license_details', 'banksolvency', 'equipmentlist'));
    }
    public function updatePaymentStatus(Request $request)
    {

        // dd($request->all())
        $request->validate([
            'application_id' => 'required|string',
            'payment_status' => 'required|in:draft,pending,paid',
        ]);

        EA_Application_model::where('application_id', $request->application_id)
            ->update(['payment_status' => $request->payment_status]);

        return response()->json(['status' => 'updated']);
    }

    // ----------------A draft and renew end---------------

    public function renew_form_ea_old($appl_id){

        if (!Auth::check()) {
            return redirect()->route('logout');
        }

        if (!$appl_id) {
            return redirect()->route('dashboard')->with('error', 'Application ID is required.');
        }
        
        $application = EA_Application_model::where('application_id', $appl_id)->first();
        
        $license_deatails = DB::table('tnelb_license')->where('application_id', $appl_id)->first();

        // var_dump($license_deatails->license_number);die;

        $proprietors = DB::table('proprietordetailsform_A')
        ->where('application_id', $appl_id)
        ->get();

        $staffs = DB::table('tnelb_applicant_cl_staffdetails')
        ->where('application_id', $appl_id)
        ->get();

        
        $document = DB::table('tnelb_applicant_doc_A')
        ->where('application_id', $appl_id)
        ->first();

        return view('user_login.renew-form_ea', compact ('application', 'proprietors', 'staffs', 'document','license_deatails'));
    }

    public function store(Request $request)
    {
        $isDraft = $request->input('form_action') === 'draft';

        // ✅ Validation Rules
        $rules = [
            'applicant_name'                => 'required|string|max:255',
            'business_address'              => 'required|string|max:500',
            'authorised_name_designation'   => 'required',
            'authorised_name'               => 'nullable|string|max:255',
            'authorised_designation'        => 'nullable|string|max:255',
            'previous_contractor_license'   => 'required|string|max:10',
            'previous_application_number'   => 'nullable|string|max:50',
            'bank_address'                  => 'required|string|max:500',
            'bank_validity'                 => 'required|date',
            'bank_amount'                   => 'required|numeric|min:1',
            'criminal_offence'              => ['required', 'string', Rule::in(['yes', 'no'])],
            'consent_letter_enclose'        => ['required', 'string', Rule::in(['yes', 'no'])],
            'cc_holders_enclosed'           => ['required', 'string', Rule::in(['yes', 'no'])],
            'purchase_bill_enclose'         => ['required', 'string', Rule::in(['yes', 'no'])],
            'test_reports_enclose'          => ['required', 'string', Rule::in(['yes', 'no'])],
            'specimen_signature_enclose'    => ['required', 'string', Rule::in(['yes', 'no'])],
            'separate_sheet'                => ['required', 'string', Rule::in(['yes', 'no'])], 
            'form_name'                     => 'required|string|max:255',
            'license_name'                  => 'required|string|max:255',
            'aadhaar'                       => 'required|digits:12',
            'pancard'                       => 'required|string|size:10',
            'declaration1'                  => 'required|string|max:255',
            'declaration2'                  => 'required|string|max:255',
        ];

        // Relax validation for Draft
        if ($isDraft) {
            foreach ($rules as $key => $rule) {
                $rules[$key] = str_replace('required', 'nullable', $rule);
            }
        }

        // Validate Data
        $validatedData = $request->validate($rules);

        // Generate Application ID
        $lastApplication    = EA_Application_model::latest('id')->value('application_id');
        $nextNumber         = $lastApplication ? ((int) substr($lastApplication, -7)) + 1 : 1111111;
        $newApplicationId   = $request->form_name . $request->license_name . date('y') . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

        // Save Main Form Data
        $form = EA_Application_model::create([
            'login_id' => $request->login_id_store,
            'application_id' => $newApplicationId,
            'application_status' => 'P',
            'license_number' => '',
            'payment_status' => $isDraft ? 'draft' : 'paid',
            'name_of_authorised_to_sign' => !empty($request->name_of_authorised_to_sign)? json_encode($request->name_of_authorised_to_sign): null,
            'enclosure' => '1',
            'previous_contractor_license' => $request->previous_contractor_license,
            'criminal_offence' => $request->criminal_offence,
            'consent_letter_enclose' => $request->consent_letter_enclose,
            'cc_holders_enclosed' => $request->cc_holders_enclosed,
            'purchase_bill_enclose' => $request->purchase_bill_enclose,
            'test_reports_enclose' => $request->test_reports_enclose,
            'specimen_signature_enclose' => $request->specimen_signature_enclose,
            'separate_sheet' => $request->separate_sheet,

        ] + $validatedData);
        
        if ($request->has('staff_name')) {
            foreach ($request->staff_name as $index => $staffName) {
                TnelbApplicantStaffDetail::create([
                    'login_id' => $request->login_id_store,
                    'application_id' => $newApplicationId,
                    'staff_name' => $staffName,
                    'staff_qualification' => $request->staff_qualification[$index] ?? null,
                    'cc_number' => $request->cc_number[$index] ?? null,
                    'cc_validity' => $request->cc_validity[$index] ?? null,
                ]);
            }
        }

        
        if ($request->has('proprietor_name')) {
           
            foreach ($request->proprietor_name as $index => $proprietor_name) {

                $competencyHolding = $request->competency_certificate_holding[$index] ?? 'no';
                $list =ProprietorformA::create([
                    'login_id' => $request->login_id_store,
                    'application_id' => $newApplicationId,
                    'proprietor_name' => $proprietor_name,
                    'proprietor_address' => $request->proprietor_address[$index] ?? null,
                    'age' => $request->age[$index] ?? null,
                    'qualification' => $request->qualification[$index] ?? null,
                    'fathers_name' => $request->fathers_name[$index] ?? 'Not Provided',
                    'present_business' => $request->present_business[$index] ?? null,

                    'competency_certificate_holding' => $competencyHolding,
                    'competency_certificate_number' => ($competencyHolding === 'yes')
                        ? ($request->competency_certificate_number[$index] ?? null)
                        : null,
                    'competency_certificate_validity' => ($competencyHolding === 'yes')
                        ? ($request->competency_certificate_validity[$index] ?? null)
                        : null,

                    'presently_employed' => $request->presently_employed[$index] ?? 'no',

                    'presently_employed_name' => ($request->presently_employed[$index] === 'yes')
                        ? ($request->presently_employed_name[$index] ?? null)
                        : null,
                    'presently_employed_address' => ($request->presently_employed[$index] === 'yes')
                        ? ($request->presently_employed_address[$index] ?? null)
                        : null,
                    'previous_experience' => $request->previous_experience[$index] ?? 'no',
                    'previous_experience_name' => ($request->previous_experience[$index] === 'yes')
                        ? ($request->previous_experience_name[$index] ?? null)
                        : null,
                    'previous_experience_address' => ($request->previous_experience[$index] === 'yes')
                        ? ($request->previous_experience_address[$index] ?? null)
                        : null,
                    'previous_experience_lnumber' => ($request->previous_experience[$index] === 'yes')
                        ? ($request->previous_experience_lnumber[$index] ?? null)
                        : null,
                ]);

            }
        }

        if (!$isDraft) {
            $transactionId = 'TXN' . rand(100000, 999999);

            Payment::create([
                'login_id' => $request->login_id_store,
                'application_id' => $newApplicationId,
                'transaction_id' => $transactionId,
                'payment_status' => 'success',
                'amount' => $request->amount,
                'form_name' => $form->form_name,
                'license_name' => $form->license_name,
            ]);

            mst_workflow::create([
                'login_id' => $request->login_id_store,
                'application_id' => $newApplicationId,
                'transaction_id' => $transactionId,
                'payment_status' => 'success',
                'formname_appliedfor' => $form->form_name,
                'license_name' => $form->license_name,
            ]);

            return response()->json([
                'message' => 'Payment Processed!',
                'login_id' => $newApplicationId,
                'transaction_id' => $transactionId,
            ]);
        }

        // Return Draft Response
        return response()->json([
            'message' => 'Form saved as draft',
            'login_id' => $newApplicationId,
        ], 200);
    }
}
