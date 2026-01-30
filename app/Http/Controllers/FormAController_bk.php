<?php

namespace App\Http\Controllers;

use App\Models\EA_Application_model;
use App\Models\mst_workflow;
use App\Models\Payment;
use App\Models\ProprietorformA;
use App\Models\TnelbApplicantStaffDetail;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FormAController extends Controller
{

    public function store(Request $request)
    {
        $isDraft = $request->input('form_action') === 'draft';
        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);

        // ✅ Validation Rules
        $rules = [
            'applicant_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'authorised_name_designation' => 'required',
            'authorised_name' => 'nullable|string|max:255',
            'authorised_designation' => 'nullable|string|max:255',
            'previous_contractor_license' => 'required|string|max:10',
            'previous_application_number' => 'nullable|string|max:50',
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

           
        ];

        // ✅ Relax validation for Draft
        if ($isDraft) {
            foreach ($rules as $key => $rule) {
                $rules[$key] = str_replace('required', 'nullable', $rule);
            }
        }


        $validatedData = $request->validate($rules);

        $lastApplication = EA_Application_model::latest('id')->value('application_id');

        $nextNumber = '0000001'; 

        if ($lastApplication && preg_match('/(\d{7})$/', $lastApplication, $matches)) {
            $lastNumber = (int) $matches[1];
            $nextNumber = str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT); 
        }

        
        $newApplicationId = $request->form_name . $request->license_name . date('y') . $nextNumber;

        $form = EA_Application_model::create([
            'login_id' => $request->login_id_store,
            'application_id' => $newApplicationId,
            'application_status' => 'P',
            'license_number' => '',
            'payment_status' => $isDraft ? 'draft' : 'paid',
            'name_of_authorised_to_sign' => !empty($request->name_of_authorised_to_sign)
                ? json_encode($request->name_of_authorised_to_sign)
                : null,

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
                    'staff_category' => $request->staff_category[$index],
                ]);
            }
        }



        if ($request->has('proprietor_name')) {

            foreach ($request->proprietor_name as $index => $proprietor_name) {

                $competencyHolding = $request->competency_certificate_holding[$index] ?? 'no';

                $list = ProprietorformA::create([
                    'login_id' => $request->login_id_store,
                    'application_id' => $newApplicationId,
                    'proprietor_name' => $proprietor_name ?? null,
                    'proprietor_address' => data_get($request->proprietor_address, $index),
                    'age' => data_get($request->age, $index),
                    'qualification' => data_get($request->qualification, $index),
                    'fathers_name' => data_get($request->fathers_name, $index, 'Not Provided'),
                    'present_business' => data_get($request->present_business, $index),

                    'competency_certificate_holding' => data_get($request->competency_certificate_holding, $index, 'no'),
                    'competency_certificate_number' => data_get($request->competency_certificate_holding, $index) === 'yes'
                        ? data_get($request->competency_certificate_number, $index)
                        : null,
                    'competency_certificate_validity' => data_get($request->competency_certificate_holding, $index) === 'yes'
                        ? data_get($request->competency_certificate_validity, $index)
                        : null,

                    'presently_employed' => data_get($request->presently_employed, $index, 'no'),
                    'presently_employed_name' => data_get($request->presently_employed, $index) === 'yes'
                        ? data_get($request->presently_employed_name, $index)
                        : null,
                    'presently_employed_address' => data_get($request->presently_employed, $index) === 'yes'
                        ? data_get($request->presently_employed_address, $index)
                        : null,

                    'previous_experience' => data_get($request->previous_experience, $index, 'no'),
                    'previous_experience_name' => data_get($request->previous_experience, $index) === 'yes'
                        ? data_get($request->previous_experience_name, $index)
                        : null,
                    'previous_experience_address' => data_get($request->previous_experience, $index) === 'yes'
                        ? data_get($request->previous_experience_address, $index)
                        : null,
                    'previous_experience_lnumber' => data_get($request->previous_experience, $index) === 'yes'
                        ? data_get($request->previous_experience_lnumber, $index)
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

        // ✅ Return Draft Response
        return response()->json([
            'message' => 'Payment Processed!',
            'login_id' => $newApplicationId,
            'transaction_id' => '11111',
        ]);
    }


    // public function store(Request $request)
    // {
    //     $isDraft = $request->input('form_action') === 'draft';

    //     $rules = [
    //         'applicant_name' => 'required|string|max:255',
    //         'business_address' => 'required|string|max:500',
    //         'authorised_name_designation' => 'required',
    //         'authorised_name' => 'nullable|string|max:255',
    //         'authorised_designation' => 'nullable|string|max:255',
    //         'previous_contractor_license' => 'required|string|max:10',
    //         'previous_application_number' => 'nullable|string|max:50',
    //         'bank_address' => 'required|string|max:500',
    //         'bank_validity' => 'required|date',
    //         'bank_amount' => 'required|numeric|min:1',
    //         'criminal_offence' => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'consent_letter_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'cc_holders_enclosed' => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'purchase_bill_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'test_reports_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'specimen_signature_enclose' => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'separate_sheet' => ['required', 'string', Rule::in(['yes', 'no'])], 
    //         'form_name' => 'required|string|max:255',
    //         'license_name' => 'required|string|max:255',
    //         'aadhaar'=> 'required|string|digits:12',
    //         'pancard'=> 'required|string|size:10',
    //         'gst_number'=> 'required|string|size:15',
    //         'declaration1' => 'required|string|max:255',
    //         'declaration2' => 'required|string|max:255',

    //     ];

    //     if ($isDraft) {
    //         foreach ($rules as $key => $rule) {
    //             $rules[$key] = str_replace('required', 'nullable', $rule);
    //         }
    //     }

    //     $validatedData = $request->validate($rules);

    //     DB::beginTransaction();

    //     try {
    //         // generate Application ID
    //         $lastApplication = EA_Application_model::latest('id')->value('application_id');
    //         $nextNumber = $lastApplication ? ((int) substr($lastApplication, -7)) + 1 : 1111111;
    //         $newApplicationId = $request->form_name . $request->license_name . date('y') . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

    //         // file uploads
    //         $aadhaarFilename = null;
    //         if ($request->hasFile('aadhaar_doc')) {
    //             $aadhaarFilename = 'documents/aadhaar_' . time() . '.' . $request->file('aadhaar_doc')->getClientOriginalExtension();
    //             $request->file('aadhaar_doc')->move(public_path('documents'), $aadhaarFilename);
    //         }

    //         $panFilename = null;
    //         if ($request->hasFile('pancard_doc')) {
    //             $panFilename = 'documents/pan_' . time() . '.' . $request->file('pancard_doc')->getClientOriginalExtension();
    //             $request->file('pancard_doc')->move(public_path('documents'), $panFilename);
    //         }

    //         $gst_Filename = null;
    //         if ($request->hasFile('gst_card_doc')) {
    //             $gst_Filename = 'documents/gst__' . time() . '.' . $request->file('gst_card_doc')->getClientOriginalExtension();
    //             $request->file('gst_doc')->move(public_path('documents'), $gst_Filename);
    //         }

    //         $appl_type = $request->appl_type ?? 'N';

    //         // Main form insert
    //         $form = EA_Application_model::create([
    //             'login_id'                     => $request->login_id_store,
    //             'application_id'              => $newApplicationId,
    //             'application_status'          => 'P',
    //             'license_number'              => '',
    //             'payment_status'              => 'draft',  //: 'paid',
    //             'name_of_authorised_to_sign'  => !empty($request->name_of_authorised_to_sign) ? json_encode($request->name_of_authorised_to_sign) : null,
    //             'enclosure'                   => '1',
    //             'previous_contractor_license' => $request->previous_contractor_license,
    //             'criminal_offence'            => $request->criminal_offence,
    //             'consent_letter_enclose'      => $request->consent_letter_enclose,
    //             'cc_holders_enclosed'         => $request->cc_holders_enclosed,
    //             'purchase_bill_enclose'       => $request->purchase_bill_enclose,
    //             'test_reports_enclose'        => $request->test_reports_enclose,
    //             'specimen_signature_enclose'  => $request->specimen_signature_enclose,
    //             'separate_sheet'              => $request->separate_sheet,
    //             'aadhaar'                     => $request->aadhaar,
    //             'pancard'                     => $request->pancard,
    //             'gst_number'                  => $request->gst_number,
    //             'appl_type'                   => $appl_type,
    //             'aadhaar_doc'                 => $aadhaarFilename,
    //             'pan_doc'                     => $panFilename,
    //             'gst_doc'                     => $gst_Filename,
    //         ] + $validatedData);

    //         // Staff details
    //         if ($request->has('staff_name')) {
    //             foreach ($request->staff_name as $index => $staffName) {
    //                 TnelbApplicantStaffDetail::create([
    //                     'login_id'          => $request->login_id_store,
    //                     'application_id'    => $newApplicationId,
    //                     'staff_name'        => $staffName,
    //                     'staff_qualification' => $request->staff_qualification[$index] ?? null,
    //                     'cc_number'         => $request->cc_number[$index] ?? null,
    //                     'cc_validity'       => $request->cc_validity[$index] ?? null,
    //                 ]);
    //             }
    //         }

    //         // Proprietors
    //         if ($request->has('proprietor_name')) {
    //             foreach ($request->proprietor_name as $index => $proprietor_name) {
    //                 $competencyHolding = $request->competency_certificate_holding[$index] ?? 'no';

    //                 ProprietorformA::create([
    //                     'login_id'                      => $request->login_id_store,
    //                     'application_id'                => $newApplicationId,
    //                     'proprietor_name'               => $proprietor_name,
    //                     'proprietor_address'            => $request->proprietor_address[$index] ?? null,
    //                     'age'                           => $request->age[$index] ?? null,
    //                     'qualification'                 => $request->qualification[$index] ?? null,
    //                     'fathers_name'                  => $request->fathers_name[$index] ?? 'Not Provided',
    //                     'present_business'              => $request->present_business[$index] ?? null,
    //                     'competency_certificate_holding'=> $competencyHolding,
    //                     'competency_certificate_number' => $competencyHolding === 'yes' ? ($request->competency_certificate_number[$index] ?? null) : null,
    //                     'competency_certificate_validity'=> $competencyHolding === 'yes' ? ($request->competency_certificate_validity[$index] ?? null) : null,
    //                     'presently_employed'            => $request->presently_employed[$index] ?? 'no',
    //                     'presently_employed_name'       => ($request->presently_employed[$index] === 'yes') ? ($request->presently_employed_name[$index] ?? null) : null,
    //                     'presently_employed_address'    => ($request->presently_employed[$index] === 'yes') ? ($request->presently_employed_address[$index] ?? null) : null,
    //                     'previous_experience'           => $request->previous_experience[$index] ?? 'no',
    //                     'previous_experience_name'      => ($request->previous_experience[$index] === 'yes') ? ($request->previous_experience_name[$index] ?? null) : null,
    //                     'previous_experience_address'   => ($request->previous_experience[$index] === 'yes') ? ($request->previous_experience_address[$index] ?? null) : null,
    //                     'previous_experience_lnumber'   => ($request->previous_experience[$index] === 'yes') ? ($request->previous_experience_lnumber[$index] ?? null) : null,
    //                 ]);
    //             }
    //         }

    //         DB::commit();

    //             return response()->json([
    //                 'status' =>'200',
    //                 'message' => 'Form saved as draft',
    //                 'application_id' => $newApplicationId,
    //                 'applicantName' => $form->applicant_name
    //             ], 200);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error("Form store failed: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

    //         return response()->json([
    //             'message' => 'Something went wrong. Please try again later.',
    //             'error'   => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function update(Request $request, $id)
    {

        $isDraft = $request->input('form_action') === 'draft';

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
        ];

        if ($isDraft) {
            foreach ($rules as $key => $rule) {
                $rules[$key] = str_replace('required', 'nullable', $rule);
            }
        }

        $validatedData = $request->validate($rules);

        DB::beginTransaction();

        try {

            $form = EA_Application_model::where('application_id', $id)->firstOrFail();

            $appl_type = $request->appl_type ?? '';


            // generate Application ID
            $lastApplication = EA_Application_model::latest('id')->value('application_id');
            $nextNumber = $lastApplication ? ((int) substr($lastApplication, -7)) + 1 : 1111111;
            $newApplicationId = $appl_type.$request->form_name . $request->license_name . date('y') . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

            // file uploads
            $aadhaarFilename = null;
            if ($request->hasFile('aadhaar_doc')) {
                $aadhaarFilename = 'documents/aadhaar_' . time() . '.' . $request->file('aadhaar_doc')->getClientOriginalExtension();
                $request->file('aadhaar_doc')->move(public_path('documents'), $aadhaarFilename);
            }

            $panFilename = null;
            if ($request->hasFile('pancard_doc')) {
                $panFilename = 'documents/pan_' . time() . '.' . $request->file('pancard_doc')->getClientOriginalExtension();
                $request->file('pancard_doc')->move(public_path('documents'), $panFilename);
            }

            $gst_Filename = null;
            if ($request->hasFile('gst_card_doc')) {
                $gst_Filename = 'documents/gst__' . time() . '.' . $request->file('gst_card_doc')->getClientOriginalExtension();
                $request->file('gst_doc')->move(public_path('documents'), $gst_Filename);
            }


            // Main form insert
            $form = EA_Application_model::create([
                'login_id'                     => $request->login_id_store,
                'application_id'              => $newApplicationId,
                'application_status'          => 'P',
                'license_number'              => '',
                'payment_status'              => 'draft',  //: 'paid',
                'name_of_authorised_to_sign'  => !empty($request->name_of_authorised_to_sign) ? json_encode($request->name_of_authorised_to_sign) : null,
                'enclosure'                   => '1',
                'license_number'              => $request->previous_application_number,
                'criminal_offence'            => $request->criminal_offence,
                'consent_letter_enclose'      => $request->consent_letter_enclose,
                'cc_holders_enclosed'         => $request->cc_holders_enclosed,
                'purchase_bill_enclose'       => $request->purchase_bill_enclose,
                'test_reports_enclose'        => $request->test_reports_enclose,
                'specimen_signature_enclose'  => $request->specimen_signature_enclose,
                'separate_sheet'              => $request->separate_sheet,
                'aadhaar'                     => $request->aadhaar,
                'pancard'                     => $request->pancard,
                'gst_number'                  => $request->gst_number,
                'appl_type'                   => $appl_type,
                'aadhaar_doc'                 => $aadhaarFilename,
                'pan_doc'                     => $panFilename,
                'gst_doc'                     => $gst_Filename,
                'old_application'             => $id,
            ] + $validatedData);


            // Staff details
            if ($request->has('staff_name')) {
                foreach ($request->staff_name as $index => $staffName) {
                    TnelbApplicantStaffDetail::create([
                        'login_id'          => $request->login_id_store,
                        'application_id'    => $newApplicationId,
                        'staff_name'        => $staffName,
                        'staff_qualification' => $request->staff_qualification[$index] ?? null,
                        'cc_number'         => $request->cc_number[$index] ?? null,
                        'cc_validity'       => $request->cc_validity[$index] ?? null,
                    ]);
                }
            }

            // Proprietors
            if ($request->has('proprietor_name')) {
                foreach ($request->proprietor_name as $index => $proprietor_name) {
                    $competencyHolding = $request->competency_certificate_holding[$index] ?? 'no';

                    ProprietorformA::create([
                        'login_id'                      => $request->login_id_store,
                        'application_id'                => $newApplicationId,
                        'proprietor_name'               => $proprietor_name,
                        'proprietor_address'            => $request->proprietor_address[$index] ?? null,
                        'age'                           => $request->age[$index] ?? null,
                        'qualification'                 => $request->qualification[$index] ?? null,
                        'fathers_name'                  => $request->fathers_name[$index] ?? 'Not Provided',
                        'present_business'              => $request->present_business[$index] ?? null,
                        'competency_certificate_holding'=> $competencyHolding,
                        'competency_certificate_number' => $competencyHolding === 'yes' ? ($request->competency_certificate_number[$index] ?? null) : null,
                        'competency_certificate_validity'=> $competencyHolding === 'yes' ? ($request->competency_certificate_validity[$index] ?? null) : null,
                        'presently_employed'            => $request->presently_employed[$index] ?? 'no',
                        'presently_employed_name'       => ($request->presently_employed[$index] === 'yes') ? ($request->presently_employed_name[$index] ?? null) : null,
                        'presently_employed_address'    => ($request->presently_employed[$index] === 'yes') ? ($request->presently_employed_address[$index] ?? null) : null,
                        'previous_experience'           => $request->previous_experience[$index] ?? 'no',
                        'previous_experience_name'      => ($request->previous_experience[$index] === 'yes') ? ($request->previous_experience_name[$index] ?? null) : null,
                        'previous_experience_address'   => ($request->previous_experience[$index] === 'yes') ? ($request->previous_experience_address[$index] ?? null) : null,
                        'previous_experience_lnumber'   => ($request->previous_experience[$index] === 'yes') ? ($request->previous_experience_lnumber[$index] ?? null) : null,
                    ]);
                }
            }

            DB::commit();

                return response()->json([
                    'status' =>'200',
                    'message' => 'Form saved as draft',
                    'application_id' => $newApplicationId,
                    'applicantName' => $form->applicant_name
                ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Form store failed: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    // public function store(Request $request)
    // {
    //     $isDraft = $request->input('form_action') === 'draft';

    //     // ✅ Validation Rules
    //     $rules = [
    //         'applicant_name'                => 'required|string|max:255',
    //         'business_address'              => 'required|string|max:500',
    //         'authorised_name_designation'   => 'required',
    //         'authorised_name'               => 'nullable|string|max:255',
    //         'authorised_designation'        => 'nullable|string|max:255',
    //         'previous_contractor_license'   => 'required|string|max:10',
    //         'previous_application_number'   => 'nullable|string|max:50',
    //         'bank_address'                  => 'required|string|max:500',
    //         'bank_validity'                 => 'required|date',
    //         'bank_amount'                   => 'required|numeric|min:1',
    //         'criminal_offence'              => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'consent_letter_enclose'        => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'cc_holders_enclosed'           => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'purchase_bill_enclose'         => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'test_reports_enclose'          => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'specimen_signature_enclose'    => ['required', 'string', Rule::in(['yes', 'no'])],
    //         'separate_sheet'                => ['required', 'string', Rule::in(['yes', 'no'])], 
    //         'form_name'                     => 'required|string|max:255',
    //         'license_name'                  => 'required|string|max:255',
    //         // 'aadhaar'                       => 'required|digits:12',
    //         // 'pancard'                       => 'required|string|size:10',
    //         // 'declaration1'                  => 'required|string|max:255',
    //         // 'declaration2'                  => 'required|string|max:255',
    //     ];

    //     // Relax validation for Draft
    //     if ($isDraft) {
    //         foreach ($rules as $key => $rule) {
    //             $rules[$key] = str_replace('required', 'nullable', $rule);
    //         }
    //     }

    //     // Validate Data
    //     $validatedData = $request->validate($rules);

    //     // Generate Application ID
    //     $lastApplication    = EA_Application_model::latest('id')->value('application_id');
    //     $nextNumber         = $lastApplication ? ((int) substr($lastApplication, -7)) + 1 : 1111111;
    //     $newApplicationId   = $request->form_name . $request->license_name . date('y') . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

    //       // Initialize paths
    //       $aadhaarFilename = null;
    //       $panFilename = null;

    //       // Aadhaar doc
    //       if ($request->hasFile('aadhaar_doc')) {
    //           $aadhaarFilename = 'documents/'.'aadhaar_' . time() . '.' . $request->file('aadhaar_doc')->getClientOriginalExtension();
    //           $destinationPath = public_path('documents');
    //           $request->file('aadhaar_doc')->move($destinationPath, $aadhaarFilename);
    //       }

    //       // PAN doc
    //       if ($request->hasFile('pancard_doc')) {
    //           $panFilename = 'documents/'.'pan_' . time() . '.' . $request->file('pancard_doc')->getClientOriginalExtension();
    //           $destinationPath = public_path('documents');
    //           $request->file('pancard_doc')->move($destinationPath, $panFilename);
    //       }

    //     // Save Main Form Data
    //     $form = EA_Application_model::create([
    //         'login_id' => $request->login_id_store,
    //         'application_id' => $newApplicationId,
    //         'application_status' => 'P',
    //         'license_number' => '',
    //         'payment_status' => $isDraft ? 'draft' : 'paid',
    //         'name_of_authorised_to_sign' => !empty($request->name_of_authorised_to_sign)? json_encode($request->name_of_authorised_to_sign): null,
    //         'enclosure' => '1',
    //         'previous_contractor_license' => $request->previous_contractor_license,
    //         'criminal_offence' => $request->criminal_offence,
    //         'consent_letter_enclose' => $request->consent_letter_enclose,
    //         'cc_holders_enclosed' => $request->cc_holders_enclosed,
    //         'purchase_bill_enclose' => $request->purchase_bill_enclose,
    //         'test_reports_enclose' => $request->test_reports_enclose,
    //         'specimen_signature_enclose' => $request->specimen_signature_enclose,
    //         'separate_sheet' => $request->separate_sheet,
    //         'aadhaar_doc'         => $aadhaarFilename, 
    //         'pan_doc'             => $panFilename,  


    //     ] + $validatedData);
        
    //     if ($request->has('staff_name')) {
    //         foreach ($request->staff_name as $index => $staffName) {
    //             TnelbApplicantStaffDetail::create([
    //                 'login_id' => $request->login_id_store,
    //                 'application_id' => $newApplicationId,
    //                 'staff_name' => $staffName,
    //                 'staff_qualification' => $request->staff_qualification[$index] ?? null,
    //                 'cc_number' => $request->cc_number[$index] ?? null,
    //                 'cc_validity' => $request->cc_validity[$index] ?? null,
    //             ]);
    //         }
    //     }

        
    //     if ($request->has('proprietor_name')) {
           
    //         foreach ($request->proprietor_name as $index => $proprietor_name) {

    //             $competencyHolding = $request->competency_certificate_holding[$index] ?? 'no';
    //             $list =ProprietorformA::create([
    //                 'login_id' => $request->login_id_store,
    //                 'application_id' => $newApplicationId,
    //                 'proprietor_name' => $proprietor_name,
    //                 'proprietor_address' => $request->proprietor_address[$index] ?? null,
    //                 'age' => $request->age[$index] ?? null,
    //                 'qualification' => $request->qualification[$index] ?? null,
    //                 'fathers_name' => $request->fathers_name[$index] ?? 'Not Provided',
    //                 'present_business' => $request->present_business[$index] ?? null,

    //                 'competency_certificate_holding' => $competencyHolding,
    //                 'competency_certificate_number' => ($competencyHolding === 'yes')
    //                     ? ($request->competency_certificate_number[$index] ?? null)
    //                     : null,
    //                 'competency_certificate_validity' => ($competencyHolding === 'yes')
    //                     ? ($request->competency_certificate_validity[$index] ?? null)
    //                     : null,

    //                 'presently_employed' => $request->presently_employed[$index] ?? 'no',

    //                 'presently_employed_name' => ($request->presently_employed[$index] === 'yes')
    //                     ? ($request->presently_employed_name[$index] ?? null)
    //                     : null,
    //                 'presently_employed_address' => ($request->presently_employed[$index] === 'yes')
    //                     ? ($request->presently_employed_address[$index] ?? null)
    //                     : null,
    //                 'previous_experience' => $request->previous_experience[$index] ?? 'no',
    //                 'previous_experience_name' => ($request->previous_experience[$index] === 'yes')
    //                     ? ($request->previous_experience_name[$index] ?? null)
    //                     : null,
    //                 'previous_experience_address' => ($request->previous_experience[$index] === 'yes')
    //                     ? ($request->previous_experience_address[$index] ?? null)
    //                     : null,
    //                 'previous_experience_lnumber' => ($request->previous_experience[$index] === 'yes')
    //                     ? ($request->previous_experience_lnumber[$index] ?? null)
    //                     : null,
    //             ]);

    //         }
    //     }

    //     if ($isDraft) {
        
    //         return response()->json([
    //             'message' => 'Form saved as draft',
    //             'login_id' => $newApplicationId,
    //         ], 200);
    //     }

        
    // }
}
