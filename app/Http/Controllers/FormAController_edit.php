<?php

namespace App\Http\Controllers;

use App\Models\B_Application;
use App\Models\EA_Application_model;
use App\Models\Equipment_storetmp_A;
use App\Models\Equipmentforma_tbl;
use App\Models\ESA_Application_model;
use App\Models\ESB_Application_model;
use App\Models\mst_workflow;
use App\Models\Payment;
use App\Models\ProprietorformA;
use App\Models\Tnelb_banksolvency_a;
use App\Models\Tnelb_cl_validitycheck;
use App\Models\TnelbApplicantStaffDetail;
use Carbon\Carbon;
use Exception;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;


class FormAController extends BaseController
{
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

    public function store(Request $request)
    {

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
            $existing = EA_Application_model::where('application_id', $recordId)->first();
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
        // $dataToSave['created_at'] = DB::raw('NOW()');
        $dataToSave['updated_at'] = DB::raw('NOW()');
        



        // $dataToSave['submit_date'] = DB::raw('NOW()');





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
        // $equipCheck = $request->has('equip_check') ? 1 : 0;
        // $testedDocuments = $request->tested_documents ?? 'no';


        // $originalInvoice = $request->original_invoice_instr ?? 'no';
        // $instrument3 = $request->instrument3 ?? 'no';

        // $equipmentlist = [
        //     'form_name' => $request->form_name ?? null,
        //     'login_id' => $request->login_id_store,
        //     'application_id' => $applicationId,

        //     'equip_id' => $request->equip_id,
        //     'licence_id' => $request->licence_id,
        //     'ipaddress'=> $request->ip()


        // ];




        //     $equiplist = Equipmentforma_tbl::where('application_id', $applicationId)->get();

        //     if ($equiplist) {

        //         $equiplist->update($equipmentlist);
        //     } else {
        //         Equipment_storetmp_A::create($equipmentlist);
        //     }

        // dd($request->equip_id);
        // exit;
        //       $equipmentData = [
        //     'form_name'      => $request->form_name ?? null,
        //     'login_id'       => $request->login_id_store,
        //     'application_id' => $applicationId,
        //     'equip_id'       => $request->equip_id ?? null,
        //     'licence_id'     => $request->licence_id ?? null,
        //     'ipaddress'      => $request->ip(),
        // ];

        // // -----------------------------------
        // // 3. Loop dynamic radio buttons
        // // equipment1, equipment2, equipment3...
        // // -----------------------------------
        // $valuesTxt = [];

        // foreach ($request->all() as $key => $value) {

        //     if (preg_match('/^equipment\d+$/', $key)) {

        //         // normalize value
        //         $finalValue = in_array($value, ['yes', 'no']) ? $value : 'no';

        //         // store individual column
        //         $equipmentData[$key] = $finalValue;

        //         // store combined data
        //         $valuesTxt[$key] = $finalValue;
        //     }
        // }

        // // -----------------------------------
        // // 4. Store combined JSON
        // // -----------------------------------
        // $equipmentData['values_txt'] = json_encode($valuesTxt);

        // // -----------------------------------
        // // 5. Update or Insert
        // // -----------------------------------
        // Equipmentforma_tbl::updateOrCreate(
        //     [
        //         'application_id' => $applicationId,
        //         'login_id'       => $request->login_id_store,
        //     ],
        //     $equipmentData
        // );


        // 1. Remove old rows for this application
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

          $Tnelb_cl_validitycheck_existing = Tnelb_cl_validitycheck::where('application_id', $applicationId)
                ->where('login_id', $request->login_id_store)
                ->first();

            $data = [
                'application_id' => $applicationId,
                'login_id'       => $request->login_id_store,
                'form_name'      => $request->form_name,
                'license_name'   => $request->license_name,
                'check_value'    => $request->check_value,
                'ipaddress'      => $request->ip(),
            ];

            if ($Tnelb_cl_validitycheck_existing) {
                
                $Tnelb_cl_validitycheck_existing->update($data);
            } else {
                
                Tnelb_cl_validitycheck::create($data);
            }


        //  dd($applicationId);
        //         exit;

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
            'updated_at'     => DB::raw('NOW()'),
        ];

        if (!$existingDoc) {
            $documentData['created_at'] = DB::raw('NOW()');
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

            // dd($request->all());
            // exit;
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



            EA_Application_model::where('application_id', $existing->application_id)
                ->update($updateData);
        } else {
            $dataToSave['created_at'] = DB::raw('NOW()');
            
            $createData = collect($dataToSave)
                ->except(['aadhaar_doc', 'pancard_doc', 'gst_doc'])
                ->toArray();

            EA_Application_model::create($createData);
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

            } else {


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

                // dd($fees_details['basic_fees']);
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

    // ------------application id-----------------------
    private function generateApplicationId($isRenewal, $formName, $licenseName)
    {
        $model = $isRenewal ? EA_Application_model::class : EA_Application_model::class;

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


    // ----------------ownership type-------------------------

    public function saveTemp(Request $request)
    {
        $sessionId = session()->getId();
        $proprietors = $request->input('proprietors', []);

        $saved = []; // collect inserted/updated proprietors

        foreach ($proprietors as $p) {
            if (empty($p['proprietor_name'])) continue;

            $data = [
                'login_id' => $request->login_id_store,
                'application_id' => $sessionId,
                'ownership_type' => strtoupper($p['ownership_type'] ?? ''),
                'proprietor_name' => strtoupper($p['proprietor_name']),
                'fathers_name' => strtoupper($p['fathers_name'] ?? ''),
                'age' => $p['age'] ?? null,
                'proprietor_address' => strtoupper($p['proprietor_address'] ?? ''),
                'qualification' => strtoupper($p['qualification'] ?? ''),
                'present_business' => strtoupper($p['present_business'] ?? ''),
                'competency_certificate_holding' => $p['competency_certificate_holding'] ?? 'no',
                'competency_certificate_number' => $p['competency_certificate_number'] ?? null,
                'competency_certificate_validity' => $p['competency_certificate_validity'] ?? null,
                'presently_employed' => $p['presently_employed'] ?? 'no',
                'presently_employed_name' => strtoupper($p['presently_employed_name'] ?? ''),
                'presently_employed_address' => strtoupper($p['presently_employed_address'] ?? ''),
                'previous_experience' => $p['previous_experience'] ?? 'no',
                'previous_experience_name' => strtoupper($p['previous_experience_name'] ?? ''),
                'previous_experience_address' => strtoupper($p['previous_experience_address'] ?? ''),
                'previous_experience_lnumber' => $p['previous_experience_lnumber'] ?? null,
                'previous_experience_lnumber_validity' => $p['previous_experience_lnumber_validity'] ?? null,
                'proprietor_flag' => '1'
            ];


            // dd($p['proprietor_id']);
            // exit;
            // $record = ProprietorformA::updateOrCreate(
            //     ['id' => $p['proprietor_id'] ?? 0], 
            //     $data
            // );

            // $saved[] = $record;
            // dd($p['proprietor_id']);
            // exit;

            if (!empty($p['proprietor_id'])) {
                $record = ProprietorformA::where('id', $p['proprietor_id'])->first();
                if ($record) {
                    $record->update($data);
                } else {
                    $record = ProprietorformA::create($data);
                }
            } else {
                $record = ProprietorformA::create($data);
            }

            $saved[] = $record;
        }

        return response()->json([
            'success' => true,
            'message' => 'Proprietor saved successfully',
            'proprietors' => $saved
        ]);
    }

    // data from table onwership-------------------------
    public function getProprietors(Request $request)
    {
        $sessionId = session()->getId();

        $proprietors = ProprietorformA::where('application_id', $sessionId)
            ->where('proprietor_flag', '1')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'proprietors' => $proprietors
        ]);
    }

    // -------------------------------deleteProprietor----------------------




    // ------------------------renewal-----------------------------------


    public function storerenewal(Request $request)
    {

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
        $dataToSave['created_at'] = DB::raw('NOW()');
        
        $dataToSave['updated_at'] = DB::raw('NOW()');
        
        $dataToSave['appl_type'] = $request->appl_type;


        // Determine if record exists

        $existing = null;
        if ($recordId) {

            // Search by application_id, not numeric id
            $existing = EA_Application_model::where('application_id', $recordId)->first();


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
        // $dataToSave['created_at'] = DB::raw('NOW()');
        $dataToSave['updated_at'] = DB::raw('NOW()');



        // ----------equipment list-------------------
        // $equipCheck = $request->has('equip_check') ? 1 : 0;
        // $testedDocuments = $request->tested_documents ?? 'no';


        // $originalInvoice = $request->original_invoice_instr ?? 'no';
        // $instrument3 = $request->instrument3 ?? 'no';

        // $equipmentlist = [
        //     'form_name' => $request->form_name ?? null,
        //     'login_id' => $request->login_id_store,
        //     'application_id' => $applicationId,

        //     'equip_check' => $equipCheck,
        //     'tested_documents' => $testedDocuments,
        //     'tested_report_id' => $testedDocuments === 'yes' ? $request->tested_report_id : null,
        //     'validity_date_eq1' => $testedDocuments === 'yes' ? $request->validity_date_eq1 : null,

        //     'original_invoice_instr' => $originalInvoice,
        //     'invoice_report_id' => $originalInvoice === 'yes' ? $request->invoice_report_id : null,
        //     'validity_date_eq2' => $originalInvoice === 'yes' ? $request->validity_date_eq2 : null,

        //     'instrument3_yes' => $instrument3,
        //     'instrument3_id' => $instrument3 === 'yes' ? $request->instrument3_id : null,
        //     'validity_date_eq3' => $instrument3 === 'yes' ? $request->validity_date_eq3 : null,
        // ];


        // if (!empty($equipCheck) || !empty($testedDocuments) || !empty($originalInvoice)  || !empty($instrument3)) {

        //     $equiplist = Equipment_storetmp_A::where('application_id', $applicationId)->first();

        //     if ($equiplist) {

        //         $equiplist->update($equipmentlist);
        //     } else {
        //         //                 dd('111');
        //         // exit;
        //         Equipment_storetmp_A::create($equipmentlist);
        //     }
        // }


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
            if (preg_match('/^AEA/i', trim($existing->application_id))) {
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
                $formData['created_at'] = DB::raw('NOW()');
                $formData['updated_at'] = DB::raw('NOW()');
                // $dataToSave['created_at'] = DB::raw('NOW()');

                $formData['appl_type'] = $request->appl_type;

                // dd($formData['appl_type']);
                // exit;

                // Insert as new record
                EA_Application_model::create($formData);

                $message = $isDraft
                    ? 'Draft saved successfully with new RAEA ID!'
                    : 'Application submitted successfully with new RAEA ID!';
            } else {
                // Normal update
                $updateData = collect($dataToSave)
                    ->except(['aadhaar_doc', 'pancard_doc', 'gst_doc'])
                    ->toArray();

                EA_Application_model::where('application_id', $existing->application_id)
                    ->update($updateData);

                $message = $isDraft
                    ? 'Draft updated successfully!'
                    : 'Application updated successfully!';
            }
        } else {
            //    $dataToSave['old_application'] = $recordId ?? null;
            $dataToSave['created_at'] = DB::raw('NOW()');


            EA_Application_model::create($dataToSave);

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
            'updated_at'     => DB::raw('NOW()'),
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
            $documentData['created_at'] = DB::raw('NOW()');
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
                ->where('ownership_type', 'partner') 
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

            $issued_licence = $request->get('license_number') ?? 0;

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

            } else {


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
            'message' => $message,
            'login_id' => $applicationId,
            'transaction_id' => $isDraft ? 'DRAFT' . rand(100000, 999999) : 'TXN' . rand(100000, 999999),
            'draft_status' => $isDraft
        ]);
    }

    // -----------instructions--------------------

    public function getFormInstructions(Request $request)
    {
        try {
            $formName  = $request->get('form_name');
            $appl_type = $request->get('appl_type');

            $issued_licence = $request->get('issued_licence');


            // dd($issued_licence);
            // exit;
            // $form = \DB::table('tnelb_forms')
            //     ->where('form_name', $formName)
            //     ->where('status', '1')
            //     ->first();

            $form = DB::table('mst_licences')
                ->where('form_code', $formName)
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


            // dd($fees_form->fees_status);
            // exit;

            if (!$form) {
                return response()->json([
                    'instructions' => null,
                    'fees'         => null,
                    'fees_start_date' => null
                ], 404);
            }

            if ($appl_type === 'R') {


                // $issued_licence = 'LA20251000001';

                $paymentDetails = DB::select("
                SELECT * FROM calc_fees(:appl_type, :licence_id, :issued_licence)
                ", [
                    'appl_type' => $appl_type,
                    'licence_id' => $form->id,
                    'issued_licence' => $issued_licence,
                ]);


                // dd($paymentDetails);
                // exit;

            } else {

                // dd($request->all());
                // exit;


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

                $fees_start_date = $fees_form->fees;

                //   dd($fees_form->fees);
                // exit;
                // HH24:MI:SS
                $dbNow  = DB::selectOne("SELECT TO_CHAR(NOW(), 'DD-MM-YYYY ') AS db_now")->db_now;
                $fees_details['dbNow'] = $dbNow;
                $fees_details['total_fees'] = $paymentDetails[0]->total_fee;
                $fees_details['lateFees'] = $paymentDetails[0]->late_fee;
                $fees_details['late_months'] = $paymentDetails[0]->late_months;
                $fees_details['basic_fees'] = $paymentDetails[0]->base_fee;

                // $fees_details['basic_fees'] = $paymentDetails[0]->base_fee;



            }

            // dd( $fees_details['total_fees']);
            // exit;

            return response()->json([
                'status' => 'success',
                'instructions' => $instructions,
                'licenseName' => $licence_name,
                'fees_details' => $fees_details,
                'fees_start_date' => $fees_form->start_date
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. ' . $e->getMessage(),
            ], 500);
        }

        // if ($appl_type === 'R') {
        //     $instructions = $form->instructions;
        //     $fees = $fees_form->fees;

        //     $late_fees = \DB::table('tnelb_fees')

        //     ->where('fees_type', 'L')
        //     ->first();
        //      return response()->json([
        //     'instructions' => $instructions,
        //     'fees'         => $fees,
        //     'late_fees'    => $late_fees
        // ]);

        //     // $late_fees = $fees_form->fees;

        // } else {
        //     $instructions = $form->instructions;

        //     $fees = $fees_form->fees;

        //      return response()->json([
        //     'instructions' => $instructions,
        //     'fees'         => $fees
        // ]);
        // }


    }




    // -----------------A latest ---------end-------------

    public function store_bk(Request $request)
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
            'previous_application_validity' => 'nullable',
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

            // ✅ Proprietor Validation Rules

            // 'proprietor_name' => 'required|string|max:255',
            // 'proprietor_address' => 'nullable|string|max:500',
            // 'age' => 'nullable|integer|min:18|max:100',
            // 'qualification' => 'nullable|string|max:255',
            // 'fathers_name' => 'nullable|string|max:255',
            // 'present_business' => 'nullable|string|max:500',

            // 'competency_certificate_holding' => ['required', Rule::in(['Y', 'N'])],
            // 'competency_certificate_number' => 'nullable|string|max:50',
            // 'competency_certificate_validity' => 'nullable|date',

            // 'presently_employed' => ['required', Rule::in(['Y', 'N'])],
            // 'presently_employed_name' => 'nullable|string|max:255',
            // 'presently_employed_address' => 'nullable|string|max:500',

            // 'previous_experience' => ['required', Rule::in(['Y', 'N'])],
            // 'previous_experience_name' => 'nullable|string|max:255',
            // 'previous_experience_address' => 'nullable|string|max:500',
            // 'previous_experience_lnumber' => 'nullable|string|max:50',
        ];

        // $rules += [
        //     'proprietor_name' => ['required', 'array', 'min:1'],  
        //     // 'proprietor_name.*' => ['required', 'string', 'max:255'],

        //     'proprietor_address' => ['required', 'array', 'min:1'],  
        //     'proprietor_address.*' => ['required', 'string', 'max:500'],

        //     'age' => ['required', 'array', 'min:1'],
        //     'age.*' => ['required', 'integer', 'min:18', 'max:100'],  

        //     'qualification' => ['required', 'array', 'min:1'],
        //     'qualification.*' => ['required', 'string', 'max:255'],  

        //     'fathers_name' => ['required', 'array', 'min:1'],
        //     'fathers_name.*' => ['required', 'string', 'max:255'],

        //     'present_business' => ['nullable', 'array'],
        //     'present_business.*' => ['nullable', 'string', 'max:255'],

        //     'competency_certificate_holding' => ['required', 'array'],
        //     'competency_certificate_holding.*' => ['required', 'in:yes,no'],  

        //     'competency_certificate_number' => ['nullable', 'array'],
        //     'competency_certificate_number.*' => ['nullable', 'string', 'max:255'],

        //     'competency_certificate_validity' => ['nullable', 'array'],
        //     'competency_certificate_validity.*' => ['nullable', 'date'],

        //     'presently_employed' => ['required', 'array'],
        //     'presently_employed.*' => ['required', 'in:yes,no'],  

        //     'presently_employed_name' => ['nullable', 'array'],
        //     'presently_employed_name.*' => ['nullable', 'string', 'max:255'],

        //     'presently_employed_address' => ['nullable', 'array'],
        //     'presently_employed_address.*' => ['nullable', 'string', 'max:500'],

        //     'previous_experience' => ['required', 'array'],
        //     'previous_experience.*' => ['required', 'in:yes,no'],

        //     'previous_experience_name' => ['nullable', 'array'],
        //     'previous_experience_name.*' => ['nullable', 'string', 'max:255'],

        //     'previous_experience_address' => ['nullable', 'array'],
        //     'previous_experience_address.*' => ['nullable', 'string', 'max:500'],

        //     'previous_experience_lnumber' => ['nullable', 'array'],
        //     'previous_experience_lnumber.*' => ['nullable', 'string', 'max:100'],
        // ];
        // $rules += [
        //     'staff_name' => 'required|string|max:255',
        //     'staff_qualification' => 'nullable|string|max:255',
        //     'cc_number' => 'nullable|string|max:50',
        //     'cc_validity' => 'nullable|date',
        // ];    

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




        $aadhaarFilename = null;
        if ($request->hasFile('aadhaar_doc')) {
            $aadhaarPath = 'documents/aadhaar_' . time() . '.' . $request->file('aadhaar_doc')->getClientOriginalExtension();
            $request->file('aadhaar_doc')->move(public_path('documents'), basename($aadhaarPath));
            $aadhaarFilename = Crypt::encryptString($aadhaarPath); // Encrypt file path
        }

        $panFilename = null;
        if ($request->hasFile('pancard_doc')) {
            $panPath = 'documents/pan_' . time() . '.' . $request->file('pancard_doc')->getClientOriginalExtension();
            $request->file('pancard_doc')->move(public_path('documents'), basename($panPath));
            $panFilename = Crypt::encryptString($panPath); // Encrypt file path
        }

        $gstFilename = null;
        if ($request->hasFile('gst_doc')) {
            $gstPath = 'documents/gst_' . time() . '.' . $request->file('gst_doc')->getClientOriginalExtension();
            $request->file('gst_doc')->move(public_path('documents'), basename($gstPath));
            $gstFilename = Crypt::encryptString($gstPath); // Encrypt file path
        }



        DB::table('tnelb_applicant_doc_A')->insert([
            'login_id'       => $request->login_id_store,
            'application_id' => $newApplicationId,
            'aadhaar_doc'    => $aadhaarFilename,
            'pancard_doc'    => $panFilename,
            'gst_doc'        => $gstFilename,
            'created_at'     => DB::raw('NOW()'),
            'updated_at'     => DB::raw('NOW()')
        ]);

        $validatedData['aadhaar'] = Crypt::encryptString($validatedData['aadhaar']);
        $validatedData['pancard'] = Crypt::encryptString($validatedData['pancard']);
        $validatedData['gst_number'] = Crypt::encryptString($validatedData['gst_number']);

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
                // dd($request->all());
                // die;
                $list = ProprietorformA::create([
                    'login_id' => $request->login_id_store,
                    'application_id' => $newApplicationId,
                    'proprietor_name' => $proprietor_name ?? null,

                    //         'proprietor_address' => '123 Test Street',
                    // 'age' => 35,
                    // 'qualification' => 'B.Tech',
                    // 'fathers_name' => 'John Doe',
                    // 'present_business' => 'Electrical Works',

                    // 'competency_certificate_holding' => 'yes',
                    // 'competency_certificate_number' => 'CC123456',
                    // 'competency_certificate_validity' => '2026-12-31',

                    // 'presently_employed' => 'no',
                    // 'presently_employed_name' => null,
                    // 'presently_employed_address' => null,

                    // 'previous_experience' => 'yes',
                    // 'previous_experience_name' => 'XYZ Pvt Ltd',
                    // 'previous_experience_address' => '456 Business Park',
                    // 'previous_experience_lnumber' => 'LN789012',

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

                    'previous_experience_lnumber_validity' => data_get($request->previous_experience, $index) === 'yes'
                        ? data_get($request->previous_experience_lnumber_validity, $index)
                        : null,






                    // 'competency_certificate_holding' => $request->competency_certificate_holding[$index] ?? 'no',
                    // 'competency_certificate_number' => $request->competency_certificate_number[$index] ?? null,
                    // 'competency_certificate_validity' => $request->competency_certificate_validity[$index] ?? null,
                    // 'competency_certificate_number' => 
                    //     ($request->competency_certificate_holding[$index] === 'yes') ? 
                    //     ($request->competency_certificate_number[$index] ?? null) : null,
                    // 'competency_certificate_validity' => 
                    //     ($request->competency_certificate_holding[$index] === 'yes') ? 
                    //     ($request->competency_certificate_validity[$index] ?? null) : null,
                    // 'competency_certificate_holding' => 'yes',
                    // 'competency_certificate_number' => 'CC123456',
                    // 'competency_certificate_validity' => '2026-12-31',

                    // 'presently_employed' => 'no',
                    // 'presently_employed_name' => null,
                    // 'presently_employed_address' => null,

                    // 'previous_experience' => 'yes',
                    // 'previous_experience_name' => 'XYZ Pvt Ltd',
                    // 'previous_experience_address' => '456 Business Park',
                    // 'previous_experience_lnumber' => 'LN789012',
                    // 'competency_certificate_number' => ($request->competency_certificate_holding[$index] === 'yes')
                    //     ? ($request->competency_certificate_number[$index] ?? null)
                    //     : null,
                    // 'competency_certificate_validity' => ($request->competency_certificate_holding[$index] === 'yes')
                    //     ? ($request->competency_certificate_validity[$index] ?? null)
                    //     : null,

                    // 'presently_employed' => $request->presently_employed[$index] ?? 'no',
                    // 'presently_employed_name' => ($request->presently_employed[$index] === 'yes')
                    //     ? ($request->presently_employed_name[$index] ?? null)
                    //     : null,
                    // 'presently_employed_address' => ($request->presently_employed[$index] === 'yes')
                    //     ? ($request->presently_employed_address[$index] ?? null)
                    //     : null,

                    // 'previous_experience' => $request->previous_experience[$index] ?? 'no',
                    // 'previous_experience_name' => ($request->previous_experience[$index] === 'yes')
                    //     ? ($request->previous_experience_name[$index] ?? null)
                    //     : null,
                    // 'previous_experience_address' => ($request->previous_experience[$index] === 'yes')
                    //     ? ($request->previous_experience_address[$index] ?? null)
                    //     : null,
                    // 'previous_experience_lnumber' => ($request->previous_experience[$index] === 'yes')
                    //     ? ($request->previous_experience_lnumber[$index] ?? null)
                    //     : null,
                ]);
            }
            // var_dump($list);
            // die;
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

    public function update(Request $request, $id)
    {

        dd($id);
        exit;

        $isDraft = $request->input('form_action') === 'draft';


        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);

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

            // $ApplicationId = $request->application_id;
            // dd($id);
            $form = EA_Application_model::where('application_id', $id)->firstOrFail();

            $appl_type = $request->appl_type ?? '';


            // generate Application ID
            $lastApplication = EA_Application_model::latest('id')->value('application_id');
            $nextNumber = $lastApplication ? ((int) substr($lastApplication, -7)) + 1 : 1111111;
            $newApplicationId = $appl_type . $request->form_name . $request->license_name . date('y') . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

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



            $document_ea = DB::table('tnelb_applicant_doc_A')->insert([
                'login_id'       => $request->login_id_store,
                'application_id' => $newApplicationId,
                'aadhaar_doc'    => $aadhaarFilename,
                'pancard_doc'    => $panFilename,
                'gst_doc'        => $gst_Filename,
                'created_at'     => DB::raw('NOW()'),
                'updated_at'     => DB::raw('NOW()')
            ]);

            // dd($document_ea);
            // exit;


            // Main form insert
            $form = EA_Application_model::create([
                'login_id'                     => $request->login_id_store,
                'application_id'              => $newApplicationId,
                'application_status'          => 'P',
                'license_number'              => '',
                'payment_status'              => 'paid',  //: 'paid',
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
                        'competency_certificate_holding' => $competencyHolding,
                        'competency_certificate_number' => $competencyHolding === 'yes' ? ($request->competency_certificate_number[$index] ?? null) : null,
                        'competency_certificate_validity' => $competencyHolding === 'yes' ? ($request->competency_certificate_validity[$index] ?? null) : null,
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
                'status' => '200',
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


    public function updatePaymentStatus(Request $request)
    {
// dd('111');
// exit;

        $request->validate([
            'application_id' => 'required|string',
            'payment_status' => 'required|in:draft,pending,paid',
        ]);

        $application =
            DB::table('tnelb_ea_applications')->where('application_id', $request->application_id)->first()
            ?? DB::table('tnelb_esa_applications')->where('application_id', $request->application_id)->first()
            ?? DB::table('tnelb_esb_applications')->where('application_id', $request->application_id)->first()
            ?? DB::table('tnelb_eb_applications')->where('application_id', $request->application_id)->first();



        $formname = $application->form_name;

        $payment = $request->payment_status;



// ALTER TABLE tnelb_eb_applications ADD COLUMN dt_submit date NULL ;
        if ($formname == 'SA') {
            ESA_Application_model::where('application_id', $request->application_id)
                ->update(['payment_status' => $request->payment_status]);
        } elseif ($formname == 'SB') {
            //                 dd($payment);
            // exit;
            ESB_Application_model::where('application_id', $request->application_id)
                ->update(['payment_status' => $request->payment_status]);
        } elseif ($formname == 'B') {
            //                 dd($payment);
            // exit;
            B_Application::where('application_id', $request->application_id)
                ->update(['payment_status' => $request->payment_status]);
        } else {
            EA_Application_model::where('application_id', $request->application_id)
                ->update(['payment_status' => $request->payment_status]);
        }

        if($payment === 'paid'){

            if ($formname == 'SA') {
               ESA_Application_model::where('application_id', $request->application_id)
                ->update([
                    'dt_submit'  => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            } elseif ($formname == 'SB') {
                //                 dd($payment);
                // exit;
                ESB_Application_model::where('application_id', $request->application_id)
                ->update([
                    'dt_submit'  => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            } elseif ($formname == 'B') {
                //                 dd($payment);
                // exit;
                B_Application::where('application_id', $request->application_id)
                ->update([
                    'dt_submit'  => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            } else {
                EA_Application_model::where('application_id', $request->application_id)
                ->update([
                    'dt_submit'  => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }
            
            // $paid = EA_Application_model::where('application_id', $request->application_id)
            //         ->update(['dt_submit' => DB::raw('NOW()') ]);
            // dd($paid);
            // exit;
        }
  


        return response()->json(['status' => 'updated']);
    }


    public function expiry_date_change()
    {

        $licensedates = DB::table('tnelb_license')
            ->select('id', 'application_id', 'license_number', 'expires_at')
            ->unionAll(
                DB::table('tnelb_renewal_license')
                    ->select('id', 'application_id', 'license_number', 'expires_at')
            )
            ->orderBy('id', 'ASC')
            ->get();
        return view('user_login.license_datechange.index', compact('licensedates'));
    }


    // -------------------------------storevaliditycheck_cl----------------------------
    public function storevaliditycheck_cl(Request $request)
{

    // dd('1111');
    // exit;
    DB::table('tnelb_cl_validitychecks')->insert([
        'login_id'      => auth()->id(),
        'application_id'=> $request->application_id,
        'form_name'     => $request->form_name,
        'license_name'  => $request->license_name,
        'check_value'   => $request->check_value, 
        'ipaddress'     => $request->ip(),
        'created_at'    => DB::raw('NOW()'),
        'updated_at'    => DB::raw('NOW()'),
    ]);

    return response()->json(['status' => 'success']);
}

}
