<?php

namespace App\Http\Controllers;

use App\Models\Admin\Mst_equipment_tbl;
use Illuminate\Http\Request;


use App\Models\EA_Application_model;
use App\Models\Equipment_storetmp_A;
use App\Models\Equipmentforma_tbl;
use App\Models\ESA_Application_model;
use App\Models\mst_workflow;
use App\Models\Payment;
use App\Models\ProprietorformA;
use App\Models\Tnelb_banksolvency_a;
use App\Models\TnelbApplicantStaffDetail;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


class FormSAController extends BaseController
{
    
    public function index()  {


          $equiplist = Mst_equipment_tbl::where('equip_licence_name', 7)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            ->where('login_id', Auth::user()->login_id)
            // ->where('application_id', $applicant_id) // IMPORTANT
            ->get();

        return view('user_login.formsa.apply-form-sa', compact('equiplist'));
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
            $application = DB::table('tnelb_esa_applications')->where('application_id', $application_id)->first();
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

         $equiplist = Mst_equipment_tbl::where('equip_licence_name', 7)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            ->where('login_id', Auth::user()->login_id)
            // ->where('application_id', $applicant_id) // IMPORTANT
            ->get();

            // dd($license_details);
            // exit;
        }

        return view('user_login.formsa.renew-form_esa', compact('application', 'proprietors', 'draftCount', 'staffs', 'document', 'license_details', 'banksolvency', 'equipmentlist', 'equiplist'));
    }

    public function storerecords(Request $request)
    {
// dd($request->all());
// exit;
        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);
        $isDraft = $request->input('form_action') === 'draft';
        $recordId = $request->input('record_id');
        // dd($request->input('form_action'));
        // dd($request->all());
        // exit;
        // Format date fields
        $this->formatDatesToDMY([
            // 'bank_validity',
            // 'cc_validity',
            // 'competency_certificate_validity',
            // 'previous_experience_lnumber_validity'
        ], $request);

        if ($isDraft) {
            // Draft mode: minimal required fields, rest nullable
            $rules = [
                'applicant_name' => 'required|string|max:255',
                'business_address' => 'required|string|max:500',
                'form_name' => 'required|string|max:255',
                'license_name' => 'required|string|max:255',
                'appl_type' => 'required',

                'application_ownershiptype' => 'nullable|string',

                // Optional fields in draft mode
                'authorised_name_designation' => 'nullable|string|max:255',
                'authorised_name' => 'nullable|string|max:255',
                'authorised_designation' => 'nullable|string|max:255',
                'previous_contractor_license' => 'nullable|string|max:10',
                'previous_application_number' => 'nullable|string|max:50',
                'previous_application_validity' => 'nullable',
                'bank_address' => 'nullable|string|max:500',
                'bank_validity' => 'nullable|date',
                'bank_amount' => 'nullable|numeric|min:0',

                'previous_contractor_license_verify' => 'nullable|numeric',
                // 'criminal_offence' => 'nullable|string|in:yes,no',
                'consent_letter_enclose' => 'nullable|string|in:yes,no',
                'cc_holders_enclosed' => 'nullable|string|in:yes,no',
                'purchase_bill_enclose' => 'nullable|string|in:yes,no',
                'test_reports_enclose' => 'nullable|string|in:yes,no',
                'specimen_signature_enclose' => 'nullable|string|in:yes,no',
                'separate_sheet' => 'nullable|string|in:yes,no',
                'aadhaar' => 'nullable',
                'pancard' => 'nullable',
                'gst_number' => 'nullable',
                'declaration1' => 'nullable|string|max:255',
                'declaration2' => 'nullable|string|max:255',
                // 'aadhaar_doc' => 'nullable|file|max:2048',
                // 'pancard_doc' => 'nullable|file|max:2048',
                // 'gst_doc' => 'nullable|file|max:2048',
            ];
        } else {
            // Final submission: all required fields
            $rules = [
                'applicant_name' => 'required|string|max:255',
                'business_address' => 'required|string|max:500',

                'application_ownershiptype' => 'required|string',
                
                'authorised_name_designation' => 'required',
                'authorised_name' => 'nullable|string|max:255',
                'authorised_designation' => 'nullable|string|max:255',
                'previous_contractor_license' => 'required|string|max:10',
                'previous_application_number' => 'nullable|string|max:50',
                'previous_application_validity' => 'nullable',
                'previous_contractor_license_verify' => 'nullable|numeric',

                'bank_address' => 'required|string|max:500',
                'bank_validity' => 'required|date',
                'bank_amount' => 'required|numeric|min:0',

                // 'criminal_offence' => ['required', 'string', Rule::in(['yes', 'no'])],
                'consent_letter_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
                'cc_holders_enclosed' => ['required', 'string', Rule::in(['yes', 'no'])],
                'purchase_bill_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
                'test_reports_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
                'specimen_signature_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
                'separate_sheet' => ['required', 'string', Rule::in(['yes', 'no'])],
                'form_name' => 'required|string|max:255',
                'license_name' => 'required|string|max:255',
                'aadhaar' => 'required|digits:12',
                'pancard' => 'required|alpha_num|size:10',
                'gst_number' => 'required|string|min:15',
                'declaration1' => 'required|string|max:255',
                'declaration2' => 'required|string|max:255',
                'aadhaar_doc' => $request->hasFile('aadhaar_doc') ? 'required|file|max:2048' : 'nullable|string',
                'pancard_doc' => $request->hasFile('pancard_doc') ? 'required|file|max:2048' : 'nullable|string',
                'gst_doc'     => $request->hasFile('gst_doc')     ? 'required|file|max:2048' : 'nullable|string',


            ];
        }
        // dd($request->all());
        // exit;
        $validatedData = $request->validate($rules);

        $validatedData['name_of_authorised_to_sign'] = !empty($request->name_of_authorised_to_sign)
            ? json_encode($request->name_of_authorised_to_sign)
            : null;

        $validatedData['age_of_authorised_to_sign'] = !empty($request->age_of_authorised_to_sign)
            ? json_encode($request->age_of_authorised_to_sign)
            : null;

        $validatedData['qualification_of_authorised_to_sign'] = !empty($request->qualification_of_authorised_to_sign)
            ? json_encode($request->qualification_of_authorised_to_sign)
            : null;

        // Convert to uppercase for certain fields
        foreach (
            [
                'applicant_name',
                'business_address',
                'authorised_name',
                'authorised_designation',
                'bank_address',
                'form_name',
                'license_name',
                'pancard',
                'gst_number'
            ] as $field
        ) {
            if (!empty($validatedData[$field])) {
                $validatedData[$field] = strtoupper($validatedData[$field]);
            }
        }

        // Encrypt sensitive fields only if they exist
        if (!empty($validatedData['aadhaar'])) {
            $validatedData['aadhaar'] = Crypt::encryptString($validatedData['aadhaar']);
        }
        if (!empty($validatedData['pancard'])) {
            $validatedData['pancard'] = Crypt::encryptString($validatedData['pancard']);
        }
        if (!empty($validatedData['gst_number'])) {
            $validatedData['gst_number'] = Crypt::encryptString($validatedData['gst_number']);
        }

        // Determine if record exists
        $applicationId = null;
        $existing = null;

        if ($recordId) {
            $existing = ESA_Application_model::where('application_id', $recordId)->first();
            if ($existing) {
                $applicationId = $existing->application_id;
            }
        }
        if (!$applicationId) {
            $applicationId = $this->generateApplicationId(
                $request->appl_type !== 'N',
                $request->form_name,
                $request->license_name
            );
        }

        // Final data to save
        $dataToSave = $validatedData;
        $dataToSave['application_id'] = $applicationId;
        $dataToSave['login_id'] = $request->login_id_store;
        $dataToSave['payment_status'] = $isDraft ? 'draft' : 'pending';
        $dataToSave['application_status'] = 'P';
        // $dataToSave['created_at'] = now();
        $dataToSave['updated_at'] = now();


        // 🔹 Save Bank Solvency data in separate table
        if (!empty($request->bank_address) || !empty($request->bank_validity) || !empty($request->bank_amount)) {


            $bankData = [
                'application_id' => $applicationId,
                'login_id'       => $request->login_id_store,
                'bank_address'   => strtoupper($request->bank_address) ?? null,
                'bank_validity'  => $request->bank_validity ?? null,
                'bank_amount'    => $request->bank_amount ?? null,
                'status'         => '1'
            ];
            //             dd($request->login_id_store);
            // exit;

            // dd([
            //     'login_id_store' => $request->login_id_store,
            //     'bank_address' => $request->bank_address,
            //     'bank_validity' => $request->bank_validity,
            //     'bank_amount' => $request->bank_amount,
            // ]);


            $existingBank = Tnelb_banksolvency_a::where('application_id', $applicationId)->first();

            // dd($existingBank);
            // exit;

            if ($existingBank) {
                $existingBank->update($bankData);
            } else {
                Tnelb_banksolvency_a::create($bankData);
            }
        }

        // ----------equipment list-------------------
       Equipmentforma_tbl::where('application_id', $applicationId)
            ->where('login_id', $request->login_id_store)
            ->delete();

        // 2. Insert fresh rows
        foreach ($request->equipments as $row) {

            Equipmentforma_tbl::create([
                'application_id'   => $applicationId,
                'login_id'         => $request->login_id_store,
                'equip_id'         => $row['equip_id'],
                'licence_id'       => $row['licence_id'],
                'form_name'        => $request->form_name,
                'equipment_value'  => $row['value'] ?? 'no',
                'ipaddress'        => $request->ip(),
            ]);
        }



        unset($dataToSave['bank_address'], $dataToSave['bank_validity'], $dataToSave['bank_amount']);


        $existingDoc = DB::table('tnelb_applicant_doc_A')
            ->where('application_id', $applicationId)
            ->first();

        $aadhaarFilename = $existingDoc->aadhaar_doc ?? null;
        $panFilename = $existingDoc->pancard_doc ?? null;
        $gstFilename = $existingDoc->gst_doc ?? null;

        // Aadhaar upload
        if ($request->hasFile('aadhaar_doc')) {
            $aadhaarPath = 'documents/' . time() . '.' . $request->file('aadhaar_doc')->getClientOriginalExtension();
            $request->file('aadhaar_doc')->move(public_path('documents'), basename($aadhaarPath));
            $aadhaarFilename = Crypt::encryptString($aadhaarPath);
        }

        // PAN upload
        if ($request->hasFile('pancard_doc')) {
            $panPath = 'documents/' . time() . '.' . $request->file('pancard_doc')->getClientOriginalExtension();
            $request->file('pancard_doc')->move(public_path('documents'), basename($panPath));
            $panFilename = Crypt::encryptString($panPath);
        }

        // GST upload
        if ($request->hasFile('gst_doc')) {
            $gstPath = 'documents/' . time() . '.' . $request->file('gst_doc')->getClientOriginalExtension();
            $request->file('gst_doc')->move(public_path('documents'), basename($gstPath));
            $gstFilename = Crypt::encryptString($gstPath);
        }

        // Insert or Update Document
        $documentExists = DB::table('tnelb_applicant_doc_A')
            ->where('application_id', $applicationId)
            ->exists();

        $documentData = [
            'login_id'       => $request->login_id_store,
            'application_id' => $applicationId,
            'aadhaar_doc'    => $aadhaarFilename,
            'pancard_doc'    => $panFilename,
            'gst_doc'        => $gstFilename,
            'updated_at'     => now(),
        ];

        if (!$existingDoc) {
            $documentData['created_at'] = now();
            DB::table('tnelb_applicant_doc_A')->insert($documentData);
        } else {
            DB::table('tnelb_applicant_doc_A')
                ->where('application_id', $applicationId)
                ->update($documentData);
        }
        // dd($request->all());
        // exit;



        if ($request->has('staff_name')) {
            $processedStaffIds = [];
            if ($request->appl_type === 'N') {
                $staffIdsFromForm = $request->staff_id ?? [];
                $existingStaffIds = TnelbApplicantStaffDetail::where('application_id', $applicationId)->pluck('id')->toArray();

                // $processedStaffIds = [];

                foreach ($request->staff_name as $index => $staffName) {
                    if (
                        !empty($staffName) ||
                        // !empty($request->staff_qualification[$index]) ||
                        !empty($request->cc_number[$index]) ||
                        !empty($request->cc_validity[$index]) ||
                        !empty($request->staff_category[$index])
                    ) {
                        $staffId = $staffIdsFromForm[$index] ?? null;
                        $validity = $request->cc_validity[$index] ?? null;

                        $staffData = [
                            'application_id'      => $applicationId,
                            'login_id'            => $request->login_id_store,
                            'staff_name'          => strtoupper($staffName),
                            'staff_qualification' => strtoupper($request->staff_qualification[$index] ?? ''),
                            'cc_number'           => strtoupper($request->cc_number[$index] ?? ''),
                            'cc_validity'         => $validity,
                            'staff_category'      => strtoupper($request->staff_category[$index] ?? ''),
                            'staff_cc_verify'     => $request->staff_cc_verify[$index]
                        ];

                        if ($staffId && in_array($staffId, $existingStaffIds)) {
                            $existingStaff = TnelbApplicantStaffDetail::find($staffId);

                            if (
                                strtoupper($existingStaff->staff_name) !== strtoupper($staffName) ||
                                strtoupper($existingStaff->staff_qualification) !== strtoupper($request->staff_qualification[$index] ?? '') ||
                                strtoupper($existingStaff->cc_number) !== strtoupper($request->cc_number[$index] ?? '') ||
                                $existingStaff->cc_validity !== $validity ||
                                strtoupper($existingStaff->staff_category) !== strtoupper($request->staff_category[$index] ?? '')
                            ) {
                                $existingStaff->update($staffData);
                            }

                            $processedStaffIds[] = $staffId;
                        } else {
                            // Create new entry
                            $newStaff = TnelbApplicantStaffDetail::create($staffData);
                            $processedStaffIds[] = $newStaff->id;
                        }
                    }
                }
            } elseif ($request->appl_type === 'R') {
                foreach ($request->staff_name as $index => $staffName) {
                    if (!empty($staffName) || !empty($request->cc_number[$index]) || !empty($request->cc_validity[$index]) || !empty($request->staff_category[$index])) {

                        $validity = $request->cc_validity[$index] ?? null;

                        $staffData = [
                            'application_id'      => $applicationId,
                            'login_id'            => $request->login_id_store,
                            'staff_name'          => strtoupper($staffName),
                            'staff_qualification' => strtoupper($request->staff_qualification[$index] ?? ''),
                            'cc_number'           => strtoupper($request->cc_number[$index] ?? ''),
                            'cc_validity'         => $validity,
                            'staff_category'      => strtoupper($request->staff_category[$index] ?? ''),
                            'staff_cc_verify'     => $request->staff_cc_verify[$index] ?? null
                        ];

                        TnelbApplicantStaffDetail::create($staffData);
                    }
                }
            }


            // Remove deleted staff
            TnelbApplicantStaffDetail::where('application_id', $applicationId)
                ->whereNotIn('id', $processedStaffIds)
                ->delete();
        }

        // Update only staff_cc_verify values by staff_id (if they exist)
        if ($request->has('staff_cc_verify') && $request->has('staff_id')) {
            foreach ($request->staff_cc_verify as $index => $verifyValue) {
                $staffId = $request->staff_id[$index] ?? null;

                if ($staffId) {
                    TnelbApplicantStaffDetail::where('id', $staffId)->update([
                        'staff_cc_verify' => $verifyValue
                    ]);
                }
            }
        }

        //    dd($request->all());
        // exit;

        $newProprietorIds = [];
        if ($request->has('proprietor_name')) {
            foreach ($request->proprietor_name as $index => $name) {
                if (empty(trim($name))) continue;

                $competencyHolding = data_get($request->competency, $index);

                //                     // dd($competencyHolding);
                //                     // exit;
                $presently_employed = data_get($request->employed, $index);
                $previous_experience = data_get($request->experience, $index);
                //                     // Skip if no name (avoid empty row)
                //                     if (empty(trim($proprietor_name))) {
                //                         continue;
                //                     }


                $proprietorId = $request->proprietor_id[$index] ?? null;
                $data = [
                    'login_id' => $request->login_id_store,
                    'application_id' => $applicationId,
                    'proprietor_name' => strtoupper($name ?? ''),
                    'ownership_type' => $request->ownership_type[$index],
                    'proprietor_address' => strtoupper(data_get($request->proprietor_address, $index, '')),
                    'age' => data_get($request->age, $index),
                    'qualification' => strtoupper(data_get($request->qualification, $index, '')),
                    'fathers_name' => strtoupper(data_get($request->fathers_name, $index, '')),
                    'present_business' => strtoupper(data_get($request->present_business, $index, '')),
                    'competency_certificate_holding' => $competencyHolding,
                    'competency_certificate_number' => $competencyHolding === 'yes' ? strtoupper(data_get($request->competency_certno, $index)) : null,
                    'competency_certificate_validity' => $competencyHolding === 'yes' ? data_get($request->competency_validity, $index) : null,
                    'proprietor_cc_verify' => $competencyHolding === 'yes' ? data_get($request->ccverify, $index) : null,


                    'presently_employed' => $presently_employed,

                    'presently_employed_name' => $presently_employed === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,

                    'presently_employed_address' => $presently_employed === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

                    // 'presently_employed_name' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,
                    // 'presently_employed_address' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

                    'previous_experience' => $previous_experience,

                    'previous_experience_name' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_name, $index)) : null,

                    'previous_experience_address' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_address, $index)) : null,


                    'previous_experience_lnumber' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_license, $index)) : null,

                    'previous_experience_lnumber_validity' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_validity, $index)) : null,



                    // 'previous_experience_name' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_name, $index)) : null,
                    // 'previous_experience_address' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_address, $index)) : null,
                    // 'previous_experience_lnumber' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_lnumber, $index)) : null,

                    // 'previous_experience_lnumber_validity' => data_get($request->previous_experience, $index) === 'yes' ? data_get($request->previous_experience_lnumber_validity, $index) : null,

                    'proprietor_contractor_verify' => $previous_experience === 'yes' ? data_get($request->expverify, $index) : null,
                    'proprietor_flag' => 1,
                ];


                if ($proprietorId) {
                    ProprietorformA::where('id', $proprietorId)->update($data);
                    $newProprietorIds[] = $proprietorId;
                } else {
                    $new = ProprietorformA::create($data);
                    $newProprietorIds[] = $new->id;
                }
            }

            // Deactivate removed rows
            ProprietorformA::where('application_id', $applicationId)
                ->whereNotIn('id', $newProprietorIds)
                ->update(['proprietor_flag' => 0]);
        }

        // Partners
        $newPartnerIds = [];
        if ($request->has('partner_name')) {
            foreach ($request->partner_name as $index => $name) {
                if (empty(trim($name))) continue;

                $partnerId = $request->partner_id[$index] ?? null;
                if (empty(trim($name))) continue;

                $competencyHolding = data_get($request->partner_competency, $index);

                //                     // dd($competencyHolding);
                //                     // exit;
                $presently_employed = data_get($request->partner_employed, $index);
                $previous_experience = data_get($request->partner_experience, $index);
                //                     // Skip if no name (avoid empty row)
                //                     if (empty(trim($proprietor_name))) {
                //                         continue;
                //                     }


                // $proprietorId = $request->proprietor_id[$index] ?? null;
                $data = [
                    'login_id' => $request->login_id_store,
                    'application_id' => $applicationId,
                    'proprietor_name' => strtoupper($name ?? ''),
                    'ownership_type' => $request->partner_ownership_type[$index],
                    'proprietor_address' => strtoupper(data_get($request->partner_proprietor_address, $index, '')),
                    'age' => data_get($request->partner_age, $index),
                    'qualification' => strtoupper(data_get($request->partner_qualification, $index, '')),
                    'fathers_name' => strtoupper(data_get($request->partner_fathers_name, $index, '')),
                    'present_business' => strtoupper(data_get($request->partner_present_business, $index, '')),
                    'competency_certificate_holding' => $competencyHolding,
                    'competency_certificate_number' => $competencyHolding === 'yes' ? strtoupper(data_get($request->partner_competency_certno, $index)) : null,
                    'competency_certificate_validity' => $competencyHolding === 'yes' ? data_get($request->partner_competency_validity, $index) : null,
                    'proprietor_cc_verify' => $competencyHolding === 'yes' ? data_get($request->partner_ccverify, $index) : null,


                    'presently_employed' => $presently_employed,

                    'presently_employed_name' => $presently_employed === 'yes' ? strtoupper(data_get($request->partner_employer_name, $index)) : null,

                    'presently_employed_address' => $presently_employed === 'yes' ? strtoupper(data_get($request->partner_employer_address, $index)) : null,

                    // 'presently_employed_name' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,
                    // 'presently_employed_address' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

                    'previous_experience' => $previous_experience,

                    'previous_experience_name' => $previous_experience === 'yes' ? strtoupper(data_get($request->partner_exp_name, $index)) : null,

                    'previous_experience_address' => $previous_experience === 'yes' ? strtoupper(data_get($request->partner_exp_address, $index)) : null,


                    'previous_experience_lnumber' => $previous_experience === 'yes' ? strtoupper(data_get($request->partner_exp_license, $index)) : null,

                    'previous_experience_lnumber_validity' => $previous_experience === 'yes' ? strtoupper(data_get($request->partner_exp_validity, $index)) : null,



                    // 'previous_experience_name' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_name, $index)) : null,
                    // 'previous_experience_address' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_address, $index)) : null,
                    // 'previous_experience_lnumber' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_lnumber, $index)) : null,

                    // 'previous_experience_lnumber_validity' => data_get($request->previous_experience, $index) === 'yes' ? data_get($request->previous_experience_lnumber_validity, $index) : null,

                    'proprietor_contractor_verify' => $previous_experience === 'yes' ? data_get($request->partner_expverify, $index) : null,
                    'proprietor_flag' => 1,
                ];

                if ($partnerId) {
                    ProprietorformA::where('id', $partnerId)->update($data);
                    $newPartnerIds[] = $partnerId;
                } else {
                    $new = ProprietorformA::create($data);
                    $newPartnerIds[] = $new->id;
                }
            }

            // Deactivate removed partner rows
            ProprietorformA::where('application_id', $applicationId)
                ->whereNotIn('id', $newPartnerIds)
                ->where('ownership_type', 'partner') // optional if you differentiate ownership
                ->update(['proprietor_flag' => 0]);
        }

        // ----------------director------------------------

        $newdirectorIds = [];
        if ($request->has('director_name')) {

            // dd($request->ownership_type);
            // dd($request->director_name);
            // exit;
            foreach ($request->director_name as $index => $name) {
                if (empty(trim($name))) continue;

                $directorId = $request->director_id[$index] ?? null;
                if (empty(trim($name))) continue;

                $competencyHolding = data_get($request->director_competency, $index);

                //                     // dd($competencyHolding);
                //                     // exit;
                $presently_employed = data_get($request->director_employed, $index);
                $previous_experience = data_get($request->director_experience, $index);
                //                     // Skip if no name (avoid empty row)
                //                     if (empty(trim($proprietor_name))) {
                //                         continue;
                //                     }


                // $proprietorId = $request->proprietor_id[$index] ?? null;
                $data = [
                    'login_id' => $request->login_id_store,
                    'application_id' => $applicationId,
                    'proprietor_name' => strtoupper($name ?? ''),
                    'ownership_type' => $request->director_ownership_type[$index],
                    'proprietor_address' => strtoupper(data_get($request->director_proprietor_address, $index, '')),
                    'age' => data_get($request->director_age, $index),
                    'qualification' => strtoupper(data_get($request->director_qualification, $index, '')),
                    'fathers_name' => strtoupper(data_get($request->director_fathers_name, $index, '')),
                    'present_business' => strtoupper(data_get($request->director_present_business, $index, '')),
                    'competency_certificate_holding' => $competencyHolding,
                    'competency_certificate_number' => $competencyHolding === 'yes' ? strtoupper(data_get($request->director_competency_certno, $index)) : null,
                    'competency_certificate_validity' => $competencyHolding === 'yes' ? data_get($request->director_competency_validity, $index) : null,
                    'proprietor_cc_verify' => $competencyHolding === 'yes' ? data_get($request->director_ccverify, $index) : null,


                    'presently_employed' => $presently_employed,

                    'presently_employed_name' => $presently_employed === 'yes' ? strtoupper(data_get($request->director_employer_name, $index)) : null,

                    'presently_employed_address' => $presently_employed === 'yes' ? strtoupper(data_get($request->director_employer_address, $index)) : null,

                    // 'presently_employed_name' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,
                    // 'presently_employed_address' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

                    'previous_experience' => $previous_experience,

                    'previous_experience_name' => $previous_experience === 'yes' ? strtoupper(data_get($request->director_exp_name, $index)) : null,

                    'previous_experience_address' => $previous_experience === 'yes' ? strtoupper(data_get($request->director_exp_address, $index)) : null,


                    'previous_experience_lnumber' => $previous_experience === 'yes' ? strtoupper(data_get($request->director_exp_license, $index)) : null,

                    'previous_experience_lnumber_validity' => $previous_experience === 'yes' ? strtoupper(data_get($request->director_exp_validity, $index)) : null,



                    // 'previous_experience_name' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_name, $index)) : null,
                    // 'previous_experience_address' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_address, $index)) : null,
                    // 'previous_experience_lnumber' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_lnumber, $index)) : null,

                    // 'previous_experience_lnumber_validity' => data_get($request->previous_experience, $index) === 'yes' ? data_get($request->previous_experience_lnumber_validity, $index) : null,

                    'proprietor_contractor_verify' => $previous_experience === 'yes' ? data_get($request->director_expverify, $index) : null,
                    'proprietor_flag' => 1,
                ];

                if ($directorId) {
                    ProprietorformA::where('id', $directorId)->update($data);
                    $newdirectorIds[] = $directorId;
                } else {
                    $new = ProprietorformA::create($data);
                    $newdirectorIds[] = $new->id;
                }
            }

            // Deactivate removed partner rows
            ProprietorformA::where('application_id', $applicationId)
                ->whereNotIn('id', $newdirectorIds)
                ->where('ownership_type', 'partner') // optional if you differentiate ownership
                ->update(['proprietor_flag' => 0]);
        }



        //         $newProprietorIds = [];
        //         if ($request->has('ownership_type')) {
        //             //   dd('entry');
        //                dd($request->proprietor_id);
        //                         exit; 

        //                         //                 exit;

        //             //    dd($request->expverify);
        //             //                 exit;
        //             if ($request->appl_type === 'N') {

        //                 // dd($request->all());
        //                 // dd($request->ownership_type);
        //                 // exit;

        //                 foreach ($request->proprietor_name as $index => $proprietor_name) {
        //                     $competencyHolding = data_get($request->competency, $index);

        //                     // dd($competencyHolding);
        //                     // exit;
        //                     $presently_employed = data_get($request->employed, $index);
        //                     $previous_experience = data_get($request->experience, $index);
        //                     // Skip if no name (avoid empty row)
        //                     if (empty(trim($proprietor_name))) {
        //                         continue;
        //                     }

        //                     $proprietorId = $request->proprietor_id[$index] ?? null;


        //                     // $proprietorId = $request->proprietor_id[$index] ?? null;


        //                     $data = [
        //                         'login_id' => $request->login_id_store,
        //                         'application_id' => $applicationId,
        //                         'proprietor_name' => strtoupper($proprietor_name ?? ''),
        //                         'ownership_type' => $request->ownership_type[$index],
        //                         'proprietor_address' => strtoupper(data_get($request->proprietor_address, $index, '')),
        //                         'age' => data_get($request->age, $index),
        //                         'qualification' => strtoupper(data_get($request->qualification, $index, '')),
        //                         'fathers_name' => strtoupper(data_get($request->fathers_name, $index, '')),
        //                         'present_business' => strtoupper(data_get($request->present_business, $index, '')),
        //                         'competency_certificate_holding' => $competencyHolding,
        //                         'competency_certificate_number' => $competencyHolding === 'yes' ? strtoupper(data_get($request->competency_certno, $index)) : null,
        //                         'competency_certificate_validity' => $competencyHolding === 'yes' ? data_get($request->competency_validity, $index) : null,
        //                         'proprietor_cc_verify' => $competencyHolding === 'yes' ? data_get($request->ccverify, $index) : null,


        //                         'presently_employed' => $presently_employed,

        //                         'presently_employed_name' => $presently_employed === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,

        //                         'presently_employed_address' => $presently_employed === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

        //                         // 'presently_employed_name' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,
        //                         // 'presently_employed_address' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

        //                         'previous_experience' => $previous_experience,

        //                         'previous_experience_name' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_name, $index)) : null,

        //                         'previous_experience_address' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_address, $index)) : null,


        //                         'previous_experience_lnumber' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_license, $index)) : null,

        //                         'previous_experience_lnumber_validity' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_validity, $index)) : null,



        //                         // 'previous_experience_name' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_name, $index)) : null,
        //                         // 'previous_experience_address' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_address, $index)) : null,
        //                         // 'previous_experience_lnumber' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_lnumber, $index)) : null,

        //                         // 'previous_experience_lnumber_validity' => data_get($request->previous_experience, $index) === 'yes' ? data_get($request->previous_experience_lnumber_validity, $index) : null,

        //                         'proprietor_contractor_verify' => $previous_experience === 'yes' ? data_get($request->expverify, $index) : null,
        //                         'proprietor_flag' => 1,
        //                     ];



        //                     if (!empty($proprietorId)) {

        //                          dd($proprietorId);
        //                         exit;

        //                         ProprietorformA::where('id', $proprietorId)->update($data);
        //                         $newProprietorIds[] = $proprietorId;
        //                     } else {

        //    dd($data);
        //                         exit;
        //                         //                                                dd($data);
        //                         // exit;
        //                         // Insert new record
        //                         $new = ProprietorformA::create($data);
        //                         $newProprietorIds[] = $new->id;
        //                     }
        //                 }
        //             } 

        //             // 🧹 Deactivate removed rows (not in current request)
        //             ProprietorformA::where('application_id', $applicationId)
        //                 ->whereNotIn('id', $newProprietorIds)
        //                 ->update(['proprietor_flag' => 0]);
        //         }





        if ($existing) {

            $updateData = collect($dataToSave)
                ->except(['aadhaar_doc', 'pancard_doc', 'gst_doc'])
                ->toArray();

            ESA_Application_model::where('application_id', $existing->application_id)
                ->update($updateData);
        } else {
            $dataToSave['created_at'] = now();
            $createData = collect($dataToSave)
                ->except(['aadhaar_doc', 'pancard_doc', 'gst_doc'])
                ->toArray();

            ESA_Application_model::create($createData);
            $message = $isDraft ? 'Draft saved successfully!' : 'Application submitted successfully!';
        }
        $transactionId = 'TXN' . rand(100000, 999999);

        $payment = $isDraft ? 'draft' : 'success';

          if (!$isDraft) {



            $form = \DB::table('tnelb_forms')
                ->where('form_code', $request->form_name)
                ->where('status', '1')
                ->first();
 
            // if (!$form) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Form not found or inactive.'
            //     ]);
            // }

           $appl_type = $request->appl_type; 

            $form = \DB::table('mst_licences')
            ->where('form_code', $request->form_name)
            // ->where('status', '1')
            ->first();

            // dd($form->id);
            // exit;
            $today = Carbon::today()->toDateString();

            $fees_form = DB::table('tnelb_fees')
                ->where('cert_licence_id', $form->id)
                ->where('fees_type', $appl_type)
                ->whereDate('start_date', '<=', $today)
                ->orderBy('start_date', 'desc')
                ->first();
            
        if (!$form) {
            return response()->json([
                'instructions' => null,
                'fees'         => null
            ], 404);
        }
      $formName  = $request->get('form_name');
        $appl_type = $request->get('appl_type');

        $issued_licence = $request->issued_licence ?? 0;

        // dd($issued_licence);
        // exit;

        
           if ($appl_type === 'R') {
           
    
        
         
                $paymentDetails = DB::select("
                SELECT * FROM calc_fees(:appl_type, :licence_id, :issued_licence)
                ", [
                    'appl_type' => $appl_type,
                    'licence_id' => $form->id,
                    'issued_licence' => $issued_licence,
                ]);


                // dd($paymentDetails);
                // exit;

            } 
            else {

    
                $paymentDetails = DB::select("
                    SELECT * FROM calc_fees(:appl_type, :licence_id, :issued_licence)
                ", [
                    'appl_type' => $appl_type,
                    'licence_id' => $form->id,
                    'issued_licence' => null,
                ]);

            //         dd($paymentDetails);
            // exit;
            }

             if (!empty($paymentDetails)) {
                $instructions = $form->instructions;
                $licence_name = $form->licence_name;

                //   dd($licence_name);
                // exit;
                // HH24:MI:SS
                $dbNow  = DB::selectOne("SELECT TO_CHAR(NOW(), 'DD-MM-YYYY ') AS db_now")->db_now;
                $fees_details['dbNow'] = $dbNow;
                $fees_details['total_fees'] = $paymentDetails[0]->total_fee;
                $fees_details['lateFees'] = $paymentDetails[0]->late_fee;
                $fees_details['late_months'] = $paymentDetails[0]->late_months;
                $fees_details['basic_fees'] = $paymentDetails[0]->base_fee;

                // $fees_details['basic_fees'] = $paymentDetails[0]->base_fee;
              
// dd($fees_details['total_fees']);
// exit;
               
            }

            // dd($form->license_name);
            // exit;
        Payment::create([
            'login_id'       => $request->login_id_store,
            'application_id' => $applicationId,
            'transaction_id' => $transactionId,
            'payment_status' => $payment,
            'payment_mode' => 'UPI',
            'amount'         => $fees_details['total_fees'], 
            'late_fee'       => $fees_details['lateFees'] ?? 0,
            'late_months'    => $fees_details['late_months'] ?? 0,
            'application_fee'     => $fees_details['basic_fees'],
            'form_name'      => $request->form_name,
            'license_name'   => $request->license_name,
        ]);

            mst_workflow::create([
                'login_id' => $request->login_id_store,
                'application_id' => $applicationId,
                'transaction_id' => $transactionId,
                'payment_status' => $payment,
                'formname_appliedfor' => $request->form_name,
                'license_name' => $request->license_name,
            ]);

            return response()->json([
                'draft_status' => $isDraft,
                'message' => 'Payment Processed!',
                'login_id' => $applicationId,
                'transaction_id' => $transactionId,
            ]);


        }

        return response()->json([
            'message' => 'Draft',
            'login_id' => $applicationId,
            'transaction_id' => $isDraft ? 'DRAFT' . rand(100000, 999999) : 'TXN' . rand(100000, 999999),
            'draft_status' => $isDraft
        ]);
    }

     private function generateApplicationId($isRenewal, $formName, $licenseName)
    {
        $model = $isRenewal ? ESA_Application_model::class : ESA_Application_model::class;

        $prefix = $isRenewal ? 'R' : '';
        $year = date('y');

        // Get last application for this specific prefix & year
        $lastApplication = $model::where('application_id', 'LIKE', $prefix . $formName . $licenseName . $year . '%')
            ->latest('id')
            ->value('application_id');

        $nextNumber = '000001';

        if ($lastApplication && preg_match('/(\d{6})$/', $lastApplication, $matches)) {
            $lastNumber = (int) $matches[1];
            $nextNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        }

        return strtoupper($prefix . $formName . $licenseName . $year . $nextNumber);
    }




    private function toUpperCaseRecursive($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->toUpperCaseRecursive($value);
            } elseif (is_string($value)) {
                $data[$key] = strtoupper($value);
            }
        }
        return $data;
    }
    public function formatDatesToDMY(array $fields, Request $request)
    {
        foreach ($fields as $field) {
            $original = $request->input($field);

            if (is_array($original)) {
                $converted = [];

                foreach ($original as $index => $value) {
                    $converted[$index] = $value ? $this->convertToDMY($value) : null;
                }

                // Merge back into request
                $request->merge([
                    $field => $converted
                ]);
            } else {
                if ($original) {
                    $request->merge([
                        $field => $this->convertToDMY($original)
                    ]);
                }
            }
        }
    }

    private function convertToDMY($value)
    {
        try {
            // Ensure Carbon can handle the string, and return formatted date
            return Carbon::parse($value)->format('d/m/Y'); // or 'Y-m-d' based on DB expectations
        } catch (\Exception $e) {
            // Optional: log error for debugging
            // \log()::error("Date parse error for value: $value", ['exception' => $e]);
            return null;
        }
    }

    // -------draft-----------------------

     public function draft($application_id)
    {
        $application = null;
        $proprietors = collect();
        $staffs = collect();
        $document = collect();

        if ($application_id) {
            $application = DB::table('tnelb_esa_applications')->where('application_id', $application_id)->first();
            $proprietors = DB::table('proprietordetailsform_A')
                ->where('application_id', $application_id)
                ->where('proprietor_flag', '1')
                ->orderBy('id')->get();
                $draftCount = $proprietors->count();

            $staffs = DB::table('tnelb_applicant_cl_staffdetails')->where('application_id', $application_id)->orderBy('id', 'ASC')->get();
            $document = DB::table('tnelb_applicant_doc_A')->where('application_id', $application_id)->first();
            $banksolvency = Tnelb_banksolvency_a::where('application_id', $application_id)->where('status','1')->first();

             $equiplist = Mst_equipment_tbl::where('equip_licence_name', 7)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            ->where('login_id', Auth::user()->login_id)
            // ->where('application_id', $applicant_id) // IMPORTANT
            ->get();
        }

        return view('user_login.formsa.apply-form-sa', compact('application', 'proprietors', 'draftCount', 'staffs', 'document', 'banksolvency' , 'equipmentlist','equiplist'));
    }

    // --------------------getFormsaInstructions------------------------

    


    // -------renew process-------------------

    public function renew_form_esa($application_id){

   

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
            $application = DB::table('tnelb_esa_applications')->where('application_id', $application_id)->first();
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

         $equiplist = Mst_equipment_tbl::where('equip_licence_name', 7)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

            $equipmentlist = DB::table('equipmentforma_tbls')
            ->where('login_id', Auth::user()->login_id)
            // ->where('application_id', $applicant_id) // IMPORTANT
            ->get();


        }

        return view('user_login.formsa.renew-form_esa', compact ('application', 'proprietors', 'staffs', 'draftCount', 'document','license_details', 'banksolvency', 'equipmentlist', 'equiplist', 'old_license_number'));
    }

    // --renew store--------------------------------------------------
     public function storerenewal(Request $request)
    {

        // dd($request->all());
        // exit;
        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);
        $isDraft = $request->input('form_action') === 'draft';
        $recordId = $request->input('record_id');

        // Format date fields
        $this->formatDatesToDMY([
            // 'bank_validity',
            // 'cc_validity',
            // 'competency_certificate_validity',
            // 'previous_experience_lnumber_validity'
        ], $request);

        if ($isDraft) {
            // Draft mode: minimal required fields, rest nullable
            $rules = [
                'applicant_name' => 'required|string|max:255',
                'business_address' => 'required|string|max:500',
                'form_name' => 'required|string|max:255',
                'license_name' => 'required|string|max:255',
                'appl_type' => 'required',

                'application_ownershiptype' => 'nullable|string',

                // Optional fields in draft mode
                'authorised_name_designation' => 'nullable|string|max:255',
                'authorised_name' => 'nullable|string|max:255',
                'authorised_designation' => 'nullable|string|max:255',
                'previous_contractor_license' => 'nullable|string|max:10',
                'previous_application_number' => 'nullable|string|max:50',
                'previous_application_validity' => 'nullable',
                'previous_contractor_license_verify' => 'nullable|numeric',
                'bank_address' => 'nullable|string|max:500',
                'bank_validity' => 'nullable|date',
                'bank_amount' => 'nullable|numeric|min:0',
                'criminal_offence' => 'nullable|string|in:yes,no',
                'consent_letter_enclose' => 'nullable|string|in:yes,no',
                'cc_holders_enclosed' => 'nullable|string|in:yes,no',
                'purchase_bill_enclose' => 'nullable|string|in:yes,no',
                'test_reports_enclose' => 'nullable|string|in:yes,no',
                'specimen_signature_enclose' => 'nullable|string|in:yes,no',
                'separate_sheet' => 'nullable|string|in:yes,no',
                'aadhaar' => 'nullable',
                'pancard' => 'nullable',
                'gst_number' => 'nullable',
                // 'declaration1' => 'nullable|string|max:255',
                // 'declaration2' => 'nullable|string|max:255',
                // 'aadhaar_doc' => 'nullable|file|max:2048',
                // 'pancard_doc' => 'nullable|file|max:2048',
                // 'gst_doc' => 'nullable|file|max:2048',
            ];
        } else {

            $rules = [
                'applicant_name' => 'required|string|max:255',
                'business_address' => 'required|string|max:500',

                'application_ownershiptype' => 'required|string',
                'authorised_name_designation' => 'required',
                'authorised_name' => 'nullable|string|max:255',
                'authorised_designation' => 'nullable|string|max:255',
                'previous_contractor_license' => 'required|string|max:10',
                'previous_application_number' => 'nullable|string|max:50',
                'previous_application_validity' => 'nullable',
                'previous_contractor_license_verify' => 'nullable|numeric',
                'bank_address' => 'required|string|max:500',
                'bank_validity' => 'required|date',
                'bank_amount' => 'required|numeric|min:1',
                'criminal_offence' => ['required', 'string', Rule::in(['yes', 'no'])],
                'consent_letter_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
                'cc_holders_enclosed' => ['required', 'string', Rule::in(['yes', 'no'])],
                'purchase_bill_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
                'test_reports_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
                'specimen_signature_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
                'separate_sheet' => ['required', 'string', Rule::in(['yes', 'no'])],
                'form_name' => 'required|string|max:255',
                'license_name' => 'required|string|max:255',
                'aadhaar' => 'required|digits:12',
                'pancard' => 'required|alpha_num|size:10',
                'gst_number' => 'required|string|min:15',
                'declaration1' => 'required|string|max:255',
                'declaration2' => 'required|string|max:255',
                'aadhaar_doc' => $request->hasFile('aadhaar_doc') ? 'required|file|max:2048' : 'nullable|string',
                'pancard_doc' => $request->hasFile('pancard_doc') ? 'required|file|max:2048' : 'nullable|string',
                'gst_doc'     => $request->hasFile('gst_doc')     ? 'required|file|max:2048' : 'nullable|string',

            ];
        }

        $validatedData = $request->validate($rules);

        $validatedData['name_of_authorised_to_sign'] = !empty($request->name_of_authorised_to_sign)
            ? json_encode($request->name_of_authorised_to_sign)
            : null;

        $validatedData['age_of_authorised_to_sign'] = !empty($request->age_of_authorised_to_sign)
            ? json_encode($request->age_of_authorised_to_sign)
            : null;

        $validatedData['qualification_of_authorised_to_sign'] = !empty($request->qualification_of_authorised_to_sign)
            ? json_encode($request->qualification_of_authorised_to_sign)
            : null;

        // Convert to uppercase for certain fields
        foreach (
            [
                'applicant_name',
                'business_address',
                'authorised_name',
                'authorised_designation',
                'bank_address',
                'form_name',
                'license_name',
                'appl_type',
                'pancard',
                'gst_number'
            ] as $field
        ) {
            if (!empty($validatedData[$field])) {
                $validatedData[$field] = strtoupper($validatedData[$field]);
            }
        }

        // Encrypt sensitive fields only if they exist
        if (!empty($validatedData['aadhaar'])) {
            $validatedData['aadhaar'] = Crypt::encryptString($validatedData['aadhaar']);
        }
        if (!empty($validatedData['pancard'])) {
            $validatedData['pancard'] = Crypt::encryptString($validatedData['pancard']);
        }
        if (!empty($validatedData['gst_number'])) {
            $validatedData['gst_number'] = Crypt::encryptString($validatedData['gst_number']);
        }

        // Determine if record exists
        $applicationId = null;

        if (!$applicationId) {
            $applicationId = $this->generateApplicationId(
                $request->appl_type !== 'N',
                $request->form_name,
                $request->license_name
            );
        }


        // Final data to save
        $dataToSave = $validatedData;
        $dataToSave['application_id'] = $applicationId;
        $dataToSave['login_id'] = $request->login_id_store;
        $dataToSave['payment_status'] = $isDraft ? 'draft' : 'pending';
        $dataToSave['application_status'] = 'P';
        $dataToSave['created_at'] = now();
        $dataToSave['updated_at'] = now();
        $dataToSave['updated_at'] = now();
        $dataToSave['appl_type'] = $request->appl_type;


        // Determine if record exists

        $existing = null;
        if ($recordId) {

            // Search by application_id, not numeric id
            $existing = ESA_Application_model::where('application_id', $recordId)->first();


            if ($existing) {
                if (!str_starts_with($existing->application_id, 'R')) {
                    $applicationId = $this->generateApplicationId(
                        $request->appl_type !== 'N',
                        $request->form_name,
                        $request->license_name
                    );
                } else {
                    $applicationId = $existing->application_id;
                }
            }
        }

        if (!$applicationId) {
            $applicationId = $this->generateApplicationId(
                $request->appl_type !== 'N',
                $request->form_name,
                $request->license_name
            );
        }

        $dataToSave['application_id'] = $applicationId;
        // dd($existing);
        // exit;
        // Final data to save
        $dataToSave = $validatedData;

          // 🔹 Save Bank Solvency data in separate table
        if (!empty($request->bank_address) || !empty($request->bank_validity) || !empty($request->bank_amount)) {


            $bankData = [
                'application_id' => $applicationId,
                'login_id'       => $request->login_id_store,
                'bank_address'   => strtoupper($request->bank_address) ?? null,
                'bank_validity'  => $request->bank_validity ?? null,
                'bank_amount'    => $request->bank_amount ?? null,
                'status'         => '1'
            ];
            //             dd($request->login_id_store);
            // exit;

            // dd([
            //     'login_id_store' => $request->login_id_store,
            //     'bank_address' => $request->bank_address,
            //     'bank_validity' => $request->bank_validity,
            //     'bank_amount' => $request->bank_amount,
            // ]);


            $existingBank = Tnelb_banksolvency_a::where('application_id', $applicationId)->first();

            // dd($existingBank);
            // exit;

            if ($existingBank) {
                $existingBank->update($bankData);
            } else {
                Tnelb_banksolvency_a::create($bankData);
            }
        }
        unset($dataToSave['bank_address'], $dataToSave['bank_validity'], $dataToSave['bank_amount']);

        $dataToSave['application_id'] = $applicationId;
        $dataToSave['login_id'] = $request->login_id_store;
        $dataToSave['payment_status'] = $isDraft ? 'draft' : 'pending';
        $dataToSave['application_status'] = 'P';
        // $dataToSave['created_at'] = now();
        $dataToSave['updated_at'] = now();


      
        // ----------equipment list-------------------
       Equipmentforma_tbl::where('application_id', $applicationId)
            ->where('login_id', $request->login_id_store)
            ->delete();

        // 2. Insert fresh rows
        foreach ($request->equipments as $row) {

            Equipmentforma_tbl::create([
                'application_id'   => $applicationId,
                'login_id'         => $request->login_id_store,
                'equip_id'         => $row['equip_id'],
                'licence_id'       => $row['licence_id'],
                'form_name'        => $request->form_name,
                'equipment_value'  => $row['value'] ?? 'no',
                'ipaddress'        => $request->ip(),
            ]);
        }


        if ($existing) {
            // AEA
            if (preg_match('/^SAESA/i', trim($existing->application_id))) {
                // Generate a new RAEA ID
                $newApplicationId = $this->generateApplicationId(
                    $request->appl_type !== 'N',
                    $request->form_name,
                    $request->license_name,
                    'RAEA'
                );

                // Use validated form data to avoid missing fields
                $formData = collect($validatedData)
                    ->except(['aadhaar_doc', 'pancard_doc', 'gst_doc'])
                    ->toArray();

                $formData['application_id'] = $newApplicationId;
                $formData['login_id'] = $request->login_id_store;
                $formData['payment_status'] = $isDraft ? 'draft' : 'pending';
                $formData['application_status'] = 'P';

                $formData['old_application'] = $recordId;

                $formData['license_number'] = $request->license_number;
                // $formData['created_at'] = now();
                $formData['updated_at'] = now();

                $formData['appl_type'] = $request->appl_type;

                // dd($formData['appl_type']);
                // exit;

                // Insert as new record
                ESA_Application_model::create($formData);

                $message = $isDraft
                    ? 'Draft saved successfully with new RAEA ID!'
                    : 'Application submitted successfully with new RAEA ID!';
            } else {
                // Normal update
                $updateData = collect($dataToSave)
                    ->except(['aadhaar_doc', 'pancard_doc', 'gst_doc'])
                    ->toArray();

                ESA_Application_model::where('application_id', $existing->application_id)
                    ->update($updateData);

                $message = $isDraft
                    ? 'Draft updated successfully!'
                    : 'Application updated successfully!';
            }
        } else {
            //    $dataToSave['old_application'] = $recordId ?? null;
            $dataToSave['created_at'] = now();


            ESA_Application_model::create($dataToSave);

            $message = $isDraft
                ? 'Draft saved successfully!'
                : 'Application submitted successfully!';
        }




        $transactionId = 'TXN' . rand(100000, 999999);

        $payment = $isDraft ? 'draft' : 'success';



        // dd($applicationId);
        // exit;
        // Upload documents
        // Choose lookup id: if you're cloning old record use $recordId (old AEA), else use $applicationId
        $docLookupId = $recordId ?? $applicationId;

        $existingDoc = DB::table('tnelb_applicant_doc_A')
            ->where('application_id', $docLookupId)
            ->first();

        // Start with existing encrypted DB values (may be null)
        $aadhaarFilename = $existingDoc->aadhaar_doc ?? null;
        $panFilename    = $existingDoc->pancard_doc  ?? null;
        $gstFilename    = $existingDoc->gst_doc      ?? null;

        // Try to decrypt existing paths (for safe comparison)
        $existingDecryptedAadhaar = null;
        $existingDecryptedPan     = null;
        $existingDecryptedGst     = null;

        if (!empty($existingDoc->aadhaar_doc)) {
            try {
                $existingDecryptedAadhaar = Crypt::decryptString($existingDoc->aadhaar_doc);
            } catch (\Exception $e) {
                $existingDecryptedAadhaar = null;
            }
        }
        if (!empty($existingDoc->pancard_doc)) {
            try {
                $existingDecryptedPan = Crypt::decryptString($existingDoc->pancard_doc);
            } catch (\Exception $e) {
                $existingDecryptedPan = null;
            }
        }
        if (!empty($existingDoc->gst_doc)) {
            try {
                $existingDecryptedGst = Crypt::decryptString($existingDoc->gst_doc);
            } catch (\Exception $e) {
                $existingDecryptedGst = null;
            }
        }

        // ---------- Aadhaar ----------
        if ($request->hasFile('aadhaar_doc')) {
            $aadhaarPath = 'documents/' . time() . '.' . $request->file('aadhaar_doc')->getClientOriginalExtension();
            $request->file('aadhaar_doc')->move(public_path('documents'), basename($aadhaarPath));
            $aadhaarFilename = Crypt::encryptString($aadhaarPath);
        } elseif ($request->filled('aadhaar_doc')) {
            // user submitted a hidden input (string path) — keep or encrypt appropriately
            $postedAadhaar = $request->input('aadhaar_doc');

            if ($existingDecryptedAadhaar && $postedAadhaar === $existingDecryptedAadhaar) {
                // keep existing encrypted value (already in $aadhaarFilename)
            } else {
                // encrypt the posted path before saving
                $aadhaarFilename = Crypt::encryptString($postedAadhaar);
            }
        } else {
            // no file and no hidden input => user removed the file
            $aadhaarFilename = null;
        }

        // ---------- PAN ----------
        if ($request->hasFile('pancard_doc')) {
            $panPath = 'documents/' . time() . '.' . $request->file('pancard_doc')->getClientOriginalExtension();
            $request->file('pancard_doc')->move(public_path('documents'), basename($panPath));
            $panFilename = Crypt::encryptString($panPath);
        } elseif ($request->filled('pancard_doc')) {
            $postedPan = $request->input('pancard_doc');

            if ($existingDecryptedPan && $postedPan === $existingDecryptedPan) {
                // keep existing encrypted
            } else {
                $panFilename = Crypt::encryptString($postedPan);
            }
        } else {
            $panFilename = null;
        }

        // ---------- GST ----------
        if ($request->hasFile('gst_doc')) {
            $gstPath = 'documents/' . time() . '.' . $request->file('gst_doc')->getClientOriginalExtension();
            $request->file('gst_doc')->move(public_path('documents'), basename($gstPath));
            $gstFilename = Crypt::encryptString($gstPath);
        } elseif ($request->filled('gst_doc')) {
            $postedGst = $request->input('gst_doc');

            if ($existingDecryptedGst && $postedGst === $existingDecryptedGst) {
                // keep existing encrypted
            } else {
                $gstFilename = Crypt::encryptString($postedGst);
            }
        } else {
            $gstFilename = null;
        }

        // Build document payload
        $documentData = [
            'login_id'       => $request->login_id_store,
            'application_id' => $applicationId,
            'aadhaar_doc'    => $aadhaarFilename,
            'pancard_doc'    => $panFilename,
            'gst_doc'        => $gstFilename,
            'updated_at'     => now(),
        ];
        // dd($documentData);
        // // dd($aadhaarFilename, $panFilename, $gstFilename);
        // exit;

        // Insert or update
        if (DB::table('tnelb_applicant_doc_A')->where('application_id', $applicationId)->exists()) {
            DB::table('tnelb_applicant_doc_A')
                ->where('application_id', $applicationId)
                ->update($documentData);
        } else {
            $documentData['created_at'] = now();
            DB::table('tnelb_applicant_doc_A')->insert($documentData);
        }

        // dd($request->all());
        // exit;

        $processedStaffIds = [];

        if ($request->has('staff_name')) {


            $staffIdsFromForm = $request->staff_id ?? [];
            $existingStaffIds = TnelbApplicantStaffDetail::where('application_id', $applicationId)->pluck('id')->toArray();

            // $processedStaffIds = [];

            foreach ($request->staff_name as $index => $staffName) {
                if (
                    !empty($staffName) ||
                    // !empty($request->staff_qualification[$index]) ||
                    !empty($request->cc_number[$index]) ||
                    !empty($request->cc_validity[$index]) ||
                    !empty($request->staff_category[$index])
                ) {
                    $staffId = $staffIdsFromForm[$index] ?? null;
                    $validity = $request->cc_validity[$index] ?? null;

                    $staffData = [
                        'application_id'      => $applicationId,
                        'login_id'            => $request->login_id_store,
                        'staff_name'          => strtoupper($staffName),
                        'staff_qualification' => strtoupper($request->staff_qualification[$index] ?? ''),
                        'cc_number'           => strtoupper($request->cc_number[$index] ?? ''),
                        'cc_validity'         => $validity,
                        'staff_category'      => strtoupper($request->staff_category[$index] ?? ''),
                        'staff_cc_verify'     => $request->staff_cc_verify[$index]
                    ];

                    if ($staffId && in_array($staffId, $existingStaffIds)) {
                        $existingStaff = TnelbApplicantStaffDetail::find($staffId);

                        if (
                            strtoupper($existingStaff->staff_name) !== strtoupper($staffName) ||
                            strtoupper($existingStaff->staff_qualification) !== strtoupper($request->staff_qualification[$index] ?? '') ||
                            strtoupper($existingStaff->cc_number) !== strtoupper($request->cc_number[$index] ?? '') ||
                            $existingStaff->cc_validity !== $validity ||
                            strtoupper($existingStaff->staff_category) !== strtoupper($request->staff_category[$index] ?? '')
                        ) {
                            $existingStaff->update($staffData);
                        }

                        $processedStaffIds[] = $staffId;
                    } else {
                        // Create new entry
                        $newStaff = TnelbApplicantStaffDetail::create($staffData);
                        $processedStaffIds[] = $newStaff->id;
                    }
                }
            }



            // Remove deleted staff
            TnelbApplicantStaffDetail::where('application_id', $applicationId)
                ->whereNotIn('id', $processedStaffIds)
                ->delete();
        }

        // Update only staff_cc_verify values by staff_id (if they exist)
        if ($request->has('staff_cc_verify') && $request->has('staff_id')) {
            foreach ($request->staff_cc_verify as $index => $verifyValue) {
                $staffId = $request->staff_id[$index] ?? null;

                if ($staffId) {
                    TnelbApplicantStaffDetail::where('id', $staffId)->update([
                        'staff_cc_verify' => $verifyValue
                    ]);
                }
            }
        }

        //    dd($request->all());
        // exit;



        $newProprietorIds = [];
        if ($request->has('proprietor_name')) {
            foreach ($request->proprietor_name as $index => $name) {
                if (empty(trim($name))) continue;

                $competencyHolding = data_get($request->competency, $index);

                //                     // dd($competencyHolding);
                //                     // exit;
                $presently_employed = data_get($request->employed, $index);
                $previous_experience = data_get($request->experience, $index);
                //                     // Skip if no name (avoid empty row)
                //                     if (empty(trim($proprietor_name))) {
                //                         continue;
                //                     }


                $proprietorId = $request->proprietor_id[$index] ?? null;
                $data = [
                    'login_id' => $request->login_id_store,
                    'application_id' => $applicationId,
                    'proprietor_name' => strtoupper($name ?? ''),
                    'ownership_type' => $request->ownership_type[$index],
                    'proprietor_address' => strtoupper(data_get($request->proprietor_address, $index, '')),
                    'age' => data_get($request->age, $index),
                    'qualification' => strtoupper(data_get($request->qualification, $index, '')),
                    'fathers_name' => strtoupper(data_get($request->fathers_name, $index, '')),
                    'present_business' => strtoupper(data_get($request->present_business, $index, '')),
                    'competency_certificate_holding' => $competencyHolding,
                    'competency_certificate_number' => $competencyHolding === 'yes' ? strtoupper(data_get($request->competency_certno, $index)) : null,
                    'competency_certificate_validity' => $competencyHolding === 'yes' ? data_get($request->competency_validity, $index) : null,
                    'proprietor_cc_verify' => $competencyHolding === 'yes' ? data_get($request->ccverify, $index) : null,


                    'presently_employed' => $presently_employed,

                    'presently_employed_name' => $presently_employed === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,

                    'presently_employed_address' => $presently_employed === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

                    // 'presently_employed_name' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,
                    // 'presently_employed_address' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

                    'previous_experience' => $previous_experience,

                    'previous_experience_name' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_name, $index)) : null,

                    'previous_experience_address' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_address, $index)) : null,


                    'previous_experience_lnumber' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_license, $index)) : null,

                    'previous_experience_lnumber_validity' => $previous_experience === 'yes' ? strtoupper(data_get($request->exp_validity, $index)) : null,



                    // 'previous_experience_name' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_name, $index)) : null,
                    // 'previous_experience_address' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_address, $index)) : null,
                    // 'previous_experience_lnumber' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_lnumber, $index)) : null,

                    // 'previous_experience_lnumber_validity' => data_get($request->previous_experience, $index) === 'yes' ? data_get($request->previous_experience_lnumber_validity, $index) : null,

                    'proprietor_contractor_verify' => $previous_experience === 'yes' ? data_get($request->expverify, $index) : null,
                    'proprietor_flag' => 1,
                ];

              $prapplicationId = ProprietorformA::where('application_id', $applicationId);

              

                if ($proprietorId) {
                 $existingRecord = ProprietorformA::where('id', $proprietorId)
                    ->where('application_id', $applicationId)
                    ->first();

                if ($existingRecord) {
                    // Update existing record
                    ProprietorformA::where('id', $proprietorId)->update($data);
                    $newProprietorIds[] = $proprietorId;
                } else {
                    // Create a new record if not found
                    $new = ProprietorformA::create($data);
                    $newProprietorIds[] = $new->id;
                }
                   
                } else {
                    $new = ProprietorformA::create($data);
                    $newProprietorIds[] = $new->id;
                }
            }

            // Deactivate removed rows
            ProprietorformA::where('application_id', $applicationId)
                ->whereNotIn('id', $newProprietorIds)
                ->update(['proprietor_flag' => 0]);
        }

        // Partners
        $newPartnerIds = [];
        if ($request->has('partner_name')) {
            foreach ($request->partner_name as $index => $name) {
                if (empty(trim($name))) continue;

                $partnerId = $request->partner_id[$index] ?? null;
                if (empty(trim($name))) continue;

                $competencyHolding = data_get($request->partner_competency, $index);

                //                     // dd($competencyHolding);
                //                     // exit;
                $presently_employed = data_get($request->partner_employed, $index);
                $previous_experience = data_get($request->partner_experience, $index);
                //                     // Skip if no name (avoid empty row)
                //                     if (empty(trim($proprietor_name))) {
                //                         continue;
                //                     }


                // $proprietorId = $request->proprietor_id[$index] ?? null;
                $data = [
                    'login_id' => $request->login_id_store,
                    'application_id' => $applicationId,
                    'proprietor_name' => strtoupper($name ?? ''),
                    'ownership_type' => $request->partner_ownership_type[$index],
                    'proprietor_address' => strtoupper(data_get($request->partner_proprietor_address, $index, '')),
                    'age' => data_get($request->partner_age, $index),
                    'qualification' => strtoupper(data_get($request->partner_qualification, $index, '')),
                    'fathers_name' => strtoupper(data_get($request->partner_fathers_name, $index, '')),
                    'present_business' => strtoupper(data_get($request->partner_present_business, $index, '')),
                    'competency_certificate_holding' => $competencyHolding,
                    'competency_certificate_number' => $competencyHolding === 'yes' ? strtoupper(data_get($request->partner_competency_certno, $index)) : null,
                    'competency_certificate_validity' => $competencyHolding === 'yes' ? data_get($request->partner_competency_validity, $index) : null,
                    'proprietor_cc_verify' => $competencyHolding === 'yes' ? data_get($request->partner_ccverify, $index) : null,


                    'presently_employed' => $presently_employed,

                    'presently_employed_name' => $presently_employed === 'yes' ? strtoupper(data_get($request->partner_employer_name, $index)) : null,

                    'presently_employed_address' => $presently_employed === 'yes' ? strtoupper(data_get($request->partner_employer_address, $index)) : null,

                    // 'presently_employed_name' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,
                    // 'presently_employed_address' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

                    'previous_experience' => $previous_experience,

                    'previous_experience_name' => $previous_experience === 'yes' ? strtoupper(data_get($request->partner_exp_name, $index)) : null,

                    'previous_experience_address' => $previous_experience === 'yes' ? strtoupper(data_get($request->partner_exp_address, $index)) : null,


                    'previous_experience_lnumber' => $previous_experience === 'yes' ? strtoupper(data_get($request->partner_exp_license, $index)) : null,

                    'previous_experience_lnumber_validity' => $previous_experience === 'yes' ? strtoupper(data_get($request->partner_exp_validity, $index)) : null,



                    // 'previous_experience_name' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_name, $index)) : null,
                    // 'previous_experience_address' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_address, $index)) : null,
                    // 'previous_experience_lnumber' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_lnumber, $index)) : null,

                    // 'previous_experience_lnumber_validity' => data_get($request->previous_experience, $index) === 'yes' ? data_get($request->previous_experience_lnumber_validity, $index) : null,

                    'proprietor_contractor_verify' => $previous_experience === 'yes' ? data_get($request->partner_expverify, $index) : null,
                    'proprietor_flag' => 1,
                ];

                if ($partnerId) {

                    $existingRecord = ProprietorformA::where('id', $partnerId)
                        ->where('application_id', $applicationId)
                        ->first();

                    if ($existingRecord) {
                        
                        ProprietorformA::where('id', $partnerId)->update($data);
                        $newPartnerIds[] = $partnerId;
                    } else {
                        
                        $new = ProprietorformA::create($data);
                        $newPartnerIds[] = $new->id;
                    }
               
                } else {
                    $new = ProprietorformA::create($data);
                    $newPartnerIds[] = $new->id;
                }
            }

            // Deactivate removed partner rows
            ProprietorformA::where('application_id', $applicationId)
                ->whereNotIn('id', $newPartnerIds)
                ->where('ownership_type', 'partner') // optional if you differentiate ownership
                ->update(['proprietor_flag' => 0]);
        }

        // ----------------director------------------------

        $newdirectorIds = [];
        if ($request->has('director_name')) {

            // dd($request->ownership_type);
            // dd($request->director_name);
            // exit;
            foreach ($request->director_name as $index => $name) {
                if (empty(trim($name))) continue;

                $directorId = $request->director_id[$index] ?? null;
                if (empty(trim($name))) continue;

                $competencyHolding = data_get($request->director_competency, $index);

                //                     // dd($competencyHolding);
                //                     // exit;
                $presently_employed = data_get($request->director_employed, $index);
                $previous_experience = data_get($request->director_experience, $index);
                //                     // Skip if no name (avoid empty row)
                //                     if (empty(trim($proprietor_name))) {
                //                         continue;
                //                     }


                // $proprietorId = $request->proprietor_id[$index] ?? null;
                $data = [
                    'login_id' => $request->login_id_store,
                    'application_id' => $applicationId,
                    'proprietor_name' => strtoupper($name ?? ''),
                    'ownership_type' => $request->director_ownership_type[$index],
                    'proprietor_address' => strtoupper(data_get($request->director_proprietor_address, $index, '')),
                    'age' => data_get($request->director_age, $index),
                    'qualification' => strtoupper(data_get($request->director_qualification, $index, '')),
                    'fathers_name' => strtoupper(data_get($request->director_fathers_name, $index, '')),
                    'present_business' => strtoupper(data_get($request->director_present_business, $index, '')),
                    'competency_certificate_holding' => $competencyHolding,
                    'competency_certificate_number' => $competencyHolding === 'yes' ? strtoupper(data_get($request->director_competency_certno, $index)) : null,
                    'competency_certificate_validity' => $competencyHolding === 'yes' ? data_get($request->director_competency_validity, $index) : null,
                    'proprietor_cc_verify' => $competencyHolding === 'yes' ? data_get($request->director_ccverify, $index) : null,


                    'presently_employed' => $presently_employed,

                    'presently_employed_name' => $presently_employed === 'yes' ? strtoupper(data_get($request->director_employer_name, $index)) : null,

                    'presently_employed_address' => $presently_employed === 'yes' ? strtoupper(data_get($request->director_employer_address, $index)) : null,

                    // 'presently_employed_name' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_name, $index)) : null,
                    // 'presently_employed_address' => data_get($presently_employed, $index) === 'yes' ? strtoupper(data_get($request->employer_address, $index)) : null,

                    'previous_experience' => $previous_experience,

                    'previous_experience_name' => $previous_experience === 'yes' ? strtoupper(data_get($request->director_exp_name, $index)) : null,

                    'previous_experience_address' => $previous_experience === 'yes' ? strtoupper(data_get($request->director_exp_address, $index)) : null,


                    'previous_experience_lnumber' => $previous_experience === 'yes' ? strtoupper(data_get($request->director_exp_license, $index)) : null,

                    'previous_experience_lnumber_validity' => $previous_experience === 'yes' ? strtoupper(data_get($request->director_exp_validity, $index)) : null,



                    // 'previous_experience_name' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_name, $index)) : null,
                    // 'previous_experience_address' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_address, $index)) : null,
                    // 'previous_experience_lnumber' => data_get($request->previous_experience, $index) === 'yes' ? strtoupper(data_get($request->previous_experience_lnumber, $index)) : null,

                    // 'previous_experience_lnumber_validity' => data_get($request->previous_experience, $index) === 'yes' ? data_get($request->previous_experience_lnumber_validity, $index) : null,

                    'proprietor_contractor_verify' => $previous_experience === 'yes' ? data_get($request->director_expverify, $index) : null,
                    'proprietor_flag' => 1,
                ];

                if ($directorId) {

                      $existingRecord = ProprietorformA::where('id', $directorId)
                        ->where('application_id', $applicationId)
                        ->first();

                    if ($existingRecord) {
                        
                        ProprietorformA::where('id', $directorId)->update($data);
                        $newdirectorIds[] = $directorId;
                    } else {
                        
                        $new = ProprietorformA::create($data);
                        $newdirectorIds[] = $new->id;
                    }
                    // ProprietorformA::where('id', $directorId)->update($data);
                    // $newdirectorIds[] = $directorId;
                } else {
                    $new = ProprietorformA::create($data);
                    $newdirectorIds[] = $new->id;
                }
            }

            // Deactivate removed partner rows
            ProprietorformA::where('application_id', $applicationId)
                ->whereNotIn('id', $newdirectorIds)
                ->where('ownership_type', 'partner') // optional if you differentiate ownership
                ->update(['proprietor_flag' => 0]);
        }




    if (!$isDraft) {



            $form = \DB::table('tnelb_forms')
                ->where('form_code', $request->form_name)
                ->where('status', '1')
                ->first();
 
            // if (!$form) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Form not found or inactive.'
            //     ]);
            // }

           $appl_type = $request->appl_type; 

            $form = \DB::table('mst_licences')
            ->where('form_code', $request->form_name)
            // ->where('status', '1')
            ->first();

            // dd($form->id);
            // exit;

           $today = Carbon::today()->toDateString();

            $fees_form = DB::table('tnelb_fees')
                ->where('cert_licence_id', $form->id)
                ->where('fees_type', $appl_type)
                ->whereDate('start_date', '<=', $today)
                ->orderBy('start_date', 'desc')
                ->first();
            
        if (!$form) {
            return response()->json([
                'instructions' => null,
                'fees'         => null
            ], 404);
        }
      $formName  = $request->get('form_name');
        $appl_type = $request->get('appl_type');

        $issued_licence = $request->get('license_number') ;

        // dd($appl_type);
        // exit;

        
           if ($appl_type === 'R') {
           
    
        
         
                $paymentDetails = DB::select("
                SELECT * FROM calc_fees(:appl_type, :licence_id, :issued_licence)
                ", [
                    'appl_type' => $appl_type,
                    'licence_id' => $form->id,
                    'issued_licence' => $issued_licence,
                ]);


                // dd($paymentDetails);
                // exit;

            } 
            else {

    
                $paymentDetails = DB::select("
                    SELECT * FROM calc_fees(:appl_type, :licence_id, :issued_licence)
                ", [
                    'appl_type' => $appl_type,
                    'licence_id' => $form->id,
                    'issued_licence' => null,
                ]);

            //         dd($paymentDetails);
            // exit;
            }

             if (!empty($paymentDetails)) {
                $instructions = $form->instructions;
                $licence_name = $form->licence_name;

                //   dd($licence_name);
                // exit;
                // HH24:MI:SS
                $dbNow  = DB::selectOne("SELECT TO_CHAR(NOW(), 'DD-MM-YYYY ') AS db_now")->db_now;
                $fees_details['dbNow'] = $dbNow;
                $fees_details['total_fees'] = $paymentDetails[0]->total_fee;
                $fees_details['lateFees'] = $paymentDetails[0]->late_fee;
                $fees_details['late_months'] = $paymentDetails[0]->late_months;
                $fees_details['basic_fees'] = $paymentDetails[0]->base_fee;

                // $fees_details['basic_fees'] = $paymentDetails[0]->base_fee;
              
// dd($fees_details['total_fees']);
// exit;
               
            }

            // dd($form->license_name);
            // exit;
        Payment::create([
            'login_id'       => $request->login_id_store,
            'application_id' => $applicationId,
            'transaction_id' => $transactionId,
            'payment_status' => $payment,
            'payment_mode' => 'UPI',
            'amount'         => $fees_details['total_fees'], 
            'late_fee'       => $fees_details['lateFees'] ?? 0,
            'late_months'    => $fees_details['late_months'] ?? 0,
            'application_fee'     => $fees_details['basic_fees'],
            'form_name'      => $request->form_name,
            'license_name'   => $request->license_name,
        ]);

            mst_workflow::create([
                'login_id' => $request->login_id_store,
                'application_id' => $applicationId,
                'transaction_id' => $transactionId,
                'payment_status' => $payment,
                'formname_appliedfor' => $request->form_name,
                'license_name' => $request->license_name,
            ]);

            return response()->json([
                'draft_status' => $isDraft,
                'message' => 'Payment Processed!',
                'login_id' => $applicationId,
                'transaction_id' => $transactionId,
            ]);


        }

        return response()->json([
            'message' => 'Draft',
            'login_id' => $applicationId,
            'transaction_id' => $isDraft ? 'DRAFT' . rand(100000, 999999) : 'TXN' . rand(100000, 999999),
            'draft_status' => $isDraft
        ]);
    }

    // -----------instructions--------------------

    public function getFormInstructions(Request $request)
    {

        // dd($request->get('appl_type'));
        // exit;

        $formName  = $request->get('form_name');
        $appl_type = $request->get('appl_type');

        $form = \DB::table('tnelb_forms')
            ->where('form_name', $formName)
            ->where('status', '1')
            ->first();

        if (!$form) {
            return response()->json([
                'instructions' => null,
                'fees'         => null
            ], 404);
        }

        if ($appl_type === 'R') {
            $instructions = $form->instructions;
            $fees = $form->renewal_amount;
        } else {
            $instructions = $form->instructions;
            $fees = $form->fresh_amount;
        }

        return response()->json([
            'instructions' => $instructions,
            'fees'         => $fees
        ]);
    }




}
