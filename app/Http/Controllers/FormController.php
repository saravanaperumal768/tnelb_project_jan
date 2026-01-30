<?php

namespace App\Http\Controllers;

use App\Models\Admin\LicenceCategory;
use App\Models\Admin\TnelbFee;
use App\Models\Mst_documents;
use App\Models\Mst_education;
use App\Models\Mst_experience;
use App\Models\Mst_Form_s_w;
use App\Models\mst_workflow;
use App\Models\MstLicence;
use App\Models\Payment;
use App\Models\Tnelb_Renewals;
use App\Models\TnelbApplicantPhoto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class FormController extends BaseController
{
//       public function __construct()
// {
//     parent::__construct();   
//     $this->middleware('web');
// }

    protected $today,$dbNow;
    public function __construct()
    {
        parent::__construct();   
        $this->middleware('web');
        $this->today = Carbon::today()->toDateString();
        $this->dbNow  = DB::selectOne("SELECT date_trunc('second', NOW()::timestamp) AS db_now")->db_now;


    }
    
    private function getApplicableFee($certLicenceId)
    {
        return TnelbFee::where('cert_licence_id', $certLicenceId)
        ->whereDate('start_date', '<=', $this->today)
        ->select('fees', 'start_date')
        ->orderBy('start_date', 'desc')
        ->first();
    }


 public function editApplication($appl_id)
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

        
        $form_details = MstLicence::where('status', 1)
            ->select('*')
            ->get()
            ->toArray();
        
        $current_form = collect($form_details)->firstWhere('form_code', $application_details->form_name);

         $licence_name = DB::table('mst_licences')->where('form_code', $application_details->form_name)->first();

        if (!$current_form) {
            abort(504, 'Form Not Found..');
        }
        
        $fees_details = $this->getApplicableFee($current_form['id']);

        if (!$fees_details) {
            abort(505, 'The requested form details could not be found.');
        }


        if (!$application_details) {
            return redirect()->route('dashboard')->with('error', 'Application not found.');
        }

        $edu_details = DB::table('tnelb_applicants_edu')
            ->where('application_id', $appl_id)
            ->select('*')
            ->orderBy('year_of_passing', 'desc')
            ->get();

        $exp_details = DB::table('tnelb_applicants_exp')
            ->where('application_id', $appl_id)
            ->select('*')
            ->orderBy('id', 'asc')
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

        $proof_doc = Mst_documents::where('application_id', $appl_id)->first();

        $applicationid = $appl_id;

        // dd($licence_name->licence_name);
        // exit;
      

        return view('user_login.edit_application', compact('applicationid', 'application_details', 'edu_details', 'exp_details', 'apps_doc', 'license_details', 'applicant_photo', 'proof_doc',
    'fees_details', 'form_details', 'licence_name'));

    }

   public function store(Request $request)
    {
        
        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);

        
        $request->validate([
            
            // basic fields
            'login_id'             => 'required|string',
            'applicant_name'       => 'required|string|max:255',
            'fathers_name'         => 'required|string|max:255',
            'applicants_address'   => 'required|string|max:500',
            'd_o_b'                => 'required|date',
            'age'                  => 'required|integer|min:18|max:100',
            'previously_number'    => 'nullable|string',
            'previously_date'      => 'nullable|date',
            'wireman_details'      => 'nullable|string|max:255',
            'aadhaar'              => 'required|string|digits:12',
            'pancard'              => 'required|string|size:10',
            'form_name'            => 'required|string|max:2',
            'license_name'         => 'required|string|max:2',
            'form_id'              => 'required|integer',
            // 'amount'               => 'required|numeric|min:0',
            'certificate_no'            => 'nullable|string',
            'certificate_date'              => 'nullable|date',
            
            
            // education arrays
            'educational_level'    => 'required|array|min:1',
            'educational_level.*'  => 'required|string|max:50',
            'institute_name'       => 'required|array|min:1',
            'institute_name.*'     => 'required|string|max:255',
            'year_of_passing'      => 'required|array|min:1',
            'year_of_passing.*'    => 'required|digits:4',
            'percentage'           => 'required|array|min:1',
            'percentage.*'         => 'required|numeric|min:0|max:100',
            
            // work experience arrays
            'work_level'           => 'required|array|min:1',
            'work_level.*'         => 'required|string|max:50',
            'experience'           => 'required|array|min:1',
            'experience.*'         => 'required|integer|min:0|max:50',
            'designation'          => 'required|array|min:1',
            'designation.*'        => 'required|string|max:100',
            
            // single files
            'upload_photo'         => 'required|image|mimes:jpg,jpeg,png|max:50', // 1MB
            'aadhaar_doc'          => 'required|mimes:pdf|min:10|max:250',
            'pancard_doc'          => 'required|mimes:pdf|min:10|max:250',
            
            // multiple files (arrays)
            'education_document'   => 'required|array|min:1',
            'education_document.*' => 'file|mimes:pdf,jpg,jpeg,png|max:200',
            'work_document'        => 'required|array|min:1',
            'work_document.*'      => 'file|mimes:pdf,jpg,jpeg,png|max:200',
            
        ], [
            
            // education arrays
            'educational_level.required'    => 'Please add at least one educational qualification.',
            'educational_level.*.required'  => 'Educational level is required.',
            'educational_level.*.string'    => 'Educational level must be a valid string.',
            'educational_level.*.max'       => 'Educational level may not be greater than 50 characters.',

            'institute_name.required'       => 'Please add at least one educational qualification.',
            'institute_name.*.required'     => 'Institute name is required.',
            'institute_name.*.string'       => 'Institute name must be a valid string.',
            'institute_name.*.max'          => 'Institute name may not be greater than 255 characters.',
            
            'year_of_passing.required'      => 'Please add at least one educational qualification.',
            'year_of_passing.*.required'    => 'Year of passing is required.',
            'year_of_passing.*.digits'      => 'Year of passing must be a 4-digit year.',
            
            'percentage.required'           => 'Please add at least one educational qualification.',
            'percentage.*.required'         => 'Percentage/Grade is required.',
            'percentage.*.numeric'          => 'Percentage/Grade must be a number.',
            'percentage.*.min'              => 'Percentage/Grade must be at least 0.',
            'percentage.*.max'              => 'Percentage/Grade may not exceed 100.',

            // work experience arrays
            'work_level.required'           => 'Please add at least one work experience.',
            'work_level.*.required'         => 'Work level is required.',
            'work_level.*.string'           => 'Work level must be a valid string.',
            'work_level.*.max'              => 'Work level may not be greater than 50 characters.',
            
            'experience.required'           => 'Please add at least one work experience.',
            'experience.*.required'         => 'Experience (in years) is required.',
            'experience.*.integer'          => 'Experience must be an integer.',
            'experience.*.min'              => 'Experience cannot be negative.',
            'experience.*.max'              => 'Experience may not exceed 50 years.',

            'designation.required'          => 'Please add at least one work experience.',
            'designation.*.required'        => 'Designation is required.',
            'designation.*.string'          => 'Designation must be a valid string.',
            'designation.*.max'             => 'Designation may not be greater than 100 characters.',
            
            'aadhaar.digits' => 'Aadhaar number should be 12 digits.',
            'pancard_doc.min' => 'PAN card file is too small.',
            
            'education_document.*.max'    => 'Educational document must not be greater than 200 kilobytes.',
            'work_document.*.max'    => 'Experience document must not be greater than 200 kilobytes.',
            
            'pancard_doc.max' => 'The pancard doc must not be greater than 250 kilobytes.',
        ]);
        
        
        $action = $request->input('form_action');
        $loginId = $request->login_id;
        
        
        DB::beginTransaction();
        
        $encrypted_aadhaar = Crypt::encryptString($request->aadhaar);
        $encrypted_pancard = Crypt::encryptString($request->pancard);
        
        try {
            // Generate New Application ID
            $appl_type = $request->appl_type ?? '';
            if ($appl_type == 'R') {
                $lastApplication = Mst_Form_s_w::latest('id')->value('application_id');
                if ($lastApplication) {
                    $lastNumber = (int) substr($lastApplication, -7);
                    $newApplicationId = $appl_type.$request->form_name . $request->license_name . date('y') . str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT);
                } else {
                    $newApplicationId = $appl_type.$request->form_name . $request->license_name . date('y') . '1111111';
                }     
            }else{
                $lastApplication = Mst_Form_s_w::latest('id')->value('application_id');
                if ($lastApplication) {
                    $lastNumber = (int) substr($lastApplication, -7);
                    $newApplicationId = $request->form_name . $request->license_name . date('y') . str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT);
                } else {
                    $newApplicationId = $request->form_name . $request->license_name . date('y') . '1111111';
                }
                
            }
            
            $aadhaarFilename = null;
            $panFilename = null;
            
            if ($request->hasFile('aadhaar_doc')) {
                $file = $request->file('aadhaar_doc');
                
                $contents = file_get_contents($file->getRealPath());
                
                $encrypted = Crypt::encrypt($contents);
                
                $aadhaarFilename = time() . '_' . rand(10000, 9999999) . '.bin';
                $destinationPath = storage_path('app/private_documents');
                
                
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                file_put_contents($destinationPath . '/' . $aadhaarFilename, $encrypted);
            }
            
            if ($request->hasFile('pancard_doc')) {
                $file = $request->file('pancard_doc');
                
                $contents = file_get_contents($file->getRealPath());
                
                $encrypted = Crypt::encrypt($contents);
                
                $panFilename = time() . '_' . rand(10000, 9999999) . '.bin';
                
                $destinationPath = storage_path('app/private_documents');
                
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                file_put_contents($destinationPath . '/' . $panFilename, $encrypted);
            }
            
            
            $form = Mst_Form_s_w::create([
                'login_id'            => $loginId,
                'applicant_name'      => $request->applicant_name ?? '',
                'fathers_name'        => $request->fathers_name ?? '',
                'applicants_address'  => $request->applicants_address,
                'd_o_b'               => $request->dob ?? $request->d_o_b,
                'age'                 => $request->age,
                'previously_number'   => $request->previously_number ?? 0,
                'previously_date'     => $request->previously_date ?? 0,
                'application_id'      => $newApplicationId,
                'wireman_details'     => $request->wireman_details,
                'form_name'           => $request->form_name,
                'form_id'             => $request->form_id,
                'license_name'        => $request->license_name,
                'aadhaar'             => $encrypted_aadhaar,
                'pancard'             => $encrypted_pancard,
                'status'              => 'P',
                'appl_type'           => $appl_type,
                'payment_status'      => ($action === 'draft') ? 'draft' : 'payment',
                'aadhaar_doc'         => $aadhaarFilename,
                'pan_doc'             => $panFilename,
                'certificate_no'      => $request->certificate_no,
                'certificate_date'    => $request->certificate_date,
                'cert_verify'         => $request->cert_verify ?? '0',
                'license_verify'      => $request->l_verify ?? '0',
                'submitted_date'      => $this->dbNow,
                'created_at'          => $this->dbNow,
            ]);


            $applicationId = $form->application_id;
            $loginId = $form->login_id;


            $form_details = MstLicence::where('status', 1)
            ->select('*')
            ->get()
            ->toArray();
            $form_category = LicenceCategory::where('status', 1)
            ->select('*')
            ->get()
            ->toArray();
       
            $current_form = collect($form_details)->firstWhere('cert_licence_code', $form->license_name);
            $category_type = collect($form_category)->firstWhere('id', $current_form['category_id']);

            $licence_details['licence_name'] = $current_form['licence_name'];
            // var_dump($licence_details);die;
            $licence_details['category_name'] = $category_type['category_name'];
            $licence_details['form_type'] = $form->appl_type;
            
            // process education
            if ($request->has('educational_level')) {
                foreach ($request->educational_level as $key => $level) {
                    // skip empty rows
                    if (empty($level) || empty($request->institute_name[$key])) continue;
                    
                    // compute edu_serial safely
                    $lastEdu = Mst_education::whereNotNull('edu_serial')->latest('id')->value('edu_serial');
                    if ($lastEdu) {
                        $lastNum = (int) str_replace('edu_', '', $lastEdu);
                        $newEduSerial = 'edu_' . ($lastNum + 1);
                    } else {
                        $newEduSerial = 'edu_1';
                    }
                    
                    $filePath = null;
                    if ($request->hasFile("education_document") && isset($request->file("education_document")[$key])) {
                        $file = $request->file("education_document")[$key];
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('education_document');
                        $file->move($destinationPath, $filename);
                        $filePath = 'education_document/' . $filename;
                    }
                    
                    Mst_education::create([
                        'login_id'           => $loginId,
                        'educational_level'  => $level,
                        'institute_name'     => $request->institute_name[$key],
                        'year_of_passing'    => $request->year_of_passing[$key],
                        'percentage'         => $request->percentage[$key],
                        'application_id'     => $newApplicationId,
                        'edu_serial'         => $newEduSerial,
                        'upload_document'    => $filePath,
                    ]);
                }
            }
            
            // process experience
            if ($request->has('work_level')) {
                foreach ($request->work_level as $key => $company) {
                    if (empty($company) || empty($request->experience[$key]) || empty($request->designation[$key])) {
                        continue;
                    }
                    
                    // compute exp_serial safely
                    $lastExp = Mst_experience::whereNotNull('exp_serial')->latest('id')->value('exp_serial');
                    if ($lastExp) {
                        $lastNum = (int) str_replace('exp_', '', $lastExp);
                        $newExpSerial = 'exp_' . ($lastNum + 1);
                    } else {
                        $newExpSerial = 'exp_1';
                    }
                    
                    $filePath = null;
                    if ($request->hasFile("work_document") && isset($request->file("work_document")[$key])) {
                        $file = $request->file("work_document")[$key];
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('work_experience');
                        $file->move($destinationPath, $filename);
                        $filePath = 'work_experience/' . $filename;
                    }
                    
                    Mst_experience::create([
                        'login_id'        => $loginId,
                        'company_name'    => $company,
                        'experience'      => $request->experience[$key],
                        'designation'     => $request->designation[$key],
                        'application_id'  => $newApplicationId,
                        'exp_serial'      => $newExpSerial,
                        'upload_document' => $filePath,
                    ]);
                }
            }
            
            // process photo
            if ($request->hasFile('upload_photo')) {
                $photoPath = 'user_' . time() . '.' . $request->file('upload_photo')->getClientOriginalExtension();
                $destinationPath = public_path('attached_documents');
                $request->file('upload_photo')->move($destinationPath, $photoPath);
                
                TnelbApplicantPhoto::create([
                    'login_id'       => $loginId,
                    'application_id' => $applicationId,
                    'upload_path'    => 'attached_documents/' . $photoPath,
                ]);
            }
            
            
            
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Form submitted successfully!',
                'application_id' => $applicationId,
                'applicantName' => $form->applicant_name,
                'form_name' => $form->form_name,
                'licence_name' => $licence_details['licence_name'],
                'type_of_apps' => $licence_details['category_name'],
                'form_type' => $licence_details['form_type'] == 'N'?'FRESH':'RENEWAL',
                'date_apps'      => $this->dbNow
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save form: ' . $e->getMessage()
            ], 500);
        }
    }


    // DRAFT UPDATE
    public function draft_update(Request $request, $applicationId)
    {
        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);

        $existingForm = Mst_Form_s_w::where('application_id', $applicationId)->first();
        $existingPhoto = TnelbApplicantPhoto::where('application_id', $applicationId)->first();

        if (!$existingForm) {
            return response()->json(['status' => 'error', 'message' => 'Draft not found!'], 404);
        }

        $uploadPhotoRule = (!$existingPhoto || empty($existingPhoto->upload_path))
            ? 'image|mimes:jpg,jpeg,png|max:50'
            : 'nullable|image|mimes:jpg,jpeg,png|max:50';

        $aadhaarDocRule = (!$existingForm->aadhaar_doc)
            ? 'required|mimes:pdf|max:250'
            : 'nullable|mimes:pdf|max:250';

        $pancardDocRule = (!$existingForm->pan_doc)
            ? 'required|mimes:pdf|max:250'
            : 'nullable|mimes:pdf|max:250';

        $request->validate([
            'login_id'           => 'required|string',
            'applicant_name'     => 'required|string|max:255',
            'fathers_name'       => 'required|string|max:255',
            'applicants_address' => 'required|string|max:500',
            'd_o_b'              => 'required|date',
            'age'                => 'required|integer|min:18|max:100',
            'previously_number'  => 'nullable|string',
            'previously_date'    => 'nullable|date',
            'wireman_details'    => 'nullable|string|max:255',
            'aadhaar'            => 'required|string|digits:12',
            'pancard'            => 'required|string|size:10',
            'form_name'          => 'required|string|max:2',
            'license_name'       => 'required|string|max:2',
            'form_id'            => 'required|integer',
            'amount'             => 'required|numeric|min:0',

            'educational_level'    => 'required|array|min:1',
            'educational_level.*'  => 'required|string|max:50',
            'institute_name'       => 'required|array|min:1',
            'institute_name.*'     => 'required|string|max:255',
            'year_of_passing'      => 'required|array|min:1',
            'year_of_passing.*'    => 'required|digits:4',
            'percentage'           => 'required|array|min:1',
            'percentage.*'         => 'required|numeric|min:0|max:100',

            'work_level'           => 'required|array|min:1',
            'work_level.*'         => 'required|string|max:50',
            'experience'           => 'required|array|min:1',
            'experience.*'         => 'required|integer|min:0|max:50',
            'designation'          => 'required|array|min:1',
            'designation.*'        => 'required|string|max:100',

            'upload_photo'   => $uploadPhotoRule,
            'aadhaar_doc'    => $aadhaarDocRule,
            'pancard_doc'    => $pancardDocRule,

            'education_document'   => 'nullable|array',
            'education_document.*' => 'file|mimes:pdf,jpg,jpeg,png|max:200',

            'work_document'        => 'nullable|array',
            'work_document.*'      => 'file|mimes:pdf,jpg,jpeg,png|max:200',
        ],[
            'education_document.*.max'    => 'Educational document size permitted only 5 KB to 200 KB.',
            'work_document.*.max'    => 'Experience document size permitted only 5 KB to 200 KB.',

            'pancard_doc.max' => 'The pancard doc size permitted only 5 KB to 250 KB.',


        ]);

        DB::beginTransaction();

        $loginId = $request->login_id;

        try {
            
            $encrypted_aadhaar = Crypt::encryptString($request->aadhaar);
            $encrypted_pancard = Crypt::encryptString($request->pancard);

            $aadhaarFilename = $existingForm ? $existingForm->aadhaar_doc : null;
            $panFilename     = $existingForm ? $existingForm->pan_doc     : null;

            if ($request->hasFile('aadhaar_doc')) {
            $file = $request->file('aadhaar_doc');

            $contents = file_get_contents($file->getRealPath());

            $encrypted = Crypt::encrypt($contents);

            $aadhaarFilename = time() . '_' . rand(10000, 9999999) . '.bin';
            $destinationPath = storage_path('app/private_documents');

            if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
            }

            file_put_contents($destinationPath . '/' . $aadhaarFilename, $encrypted);
            }


            if ($request->hasFile('pancard_doc')) {
            $file = $request->file('pancard_doc');

            $contents = file_get_contents($file->getRealPath());

            $encrypted = Crypt::encrypt($contents);

            $panFilename = time() . '_' . rand(10000, 9999999) . '.bin';
            $destinationPath = storage_path('app/private_documents');

            if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
            }

            file_put_contents($destinationPath . '/' . $panFilename, $encrypted);
            }

            // ✅ Update existing draft
            $existingForm->update([
                'login_id'          => $request->login_id,
                'applicant_name'    => $request->applicant_name,
                'fathers_name'      => $request->fathers_name,
                'applicants_address'=> $request->applicants_address,
                'd_o_b'             => $request->d_o_b,
                'age'               => $request->age,
                'previously_number' => $request->previously_number,
                'previously_date'   => $request->previously_date,
                'wireman_details'   => $request->wireman_details,
                'aadhaar'           => $encrypted_aadhaar,
                'pancard'           => $encrypted_pancard,
                'aadhaar_doc'       => $aadhaarFilename,
                'pan_doc'           => $panFilename,
                'payment_status'    => 'payment',
                'certificate_no'      => $request->certificate_no,
                'certificate_date'    => $request->certificate_date,
            ]);




            if ($request->has('educational_level')) {

                // ✅ Fetch the last edu_serial from DB
                $lastEdu = Mst_education::whereNotNull('edu_serial')->latest('id')->value('edu_serial');
                $lastNum = $lastEdu ? (int) str_replace('edu_', '', $lastEdu) : 0;
            
                foreach ($request->educational_level as $key => $level) {
            
                    // ✅ Validate required fields (skip incomplete rows)
                    if (
                        empty($level) ||
                        empty($request->institute_name[$key] ?? null) ||
                        empty($request->year_of_passing[$key] ?? null) ||
                        empty($request->percentage[$key] ?? null)
                    ) {
                        continue;
                    }
            
                    // ✅ Check if this is an existing row
                    $eduId = $request->edu_id[$key] ?? null;
                    $education = $eduId ? Mst_education::find($eduId) : null;
            
                    // ✅ File Handling
                    $filePath = $request->existing_document[$key] ?? null; // Default to existing file
            
                    if (isset($request->file("education_document")[$key])) {
                        $file = $request->file("education_document")[$key];
            
                        if ($file && $file->isValid()) {
                            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $destinationPath = public_path('education_document');
                            $file->move($destinationPath, $filename);
                            $filePath = 'education_document/' . $filename;
                        }
                    }
            
                    if ($education) {
                        // ✅ UPDATE existing record
                        $education->update([
                            'educational_level' => $level,
                            'institute_name'    => $request->institute_name[$key],
                            'year_of_passing'   => $request->year_of_passing[$key],
                            'percentage'        => $request->percentage[$key],
                            'upload_document'   => $filePath,
                        ]);
            
                    } else {
                        // ✅ INSERT new record
                        $lastNum++;
                        $newEduSerial = 'edu_' . $lastNum;
            
                        Mst_education::create([
                            'login_id'          => $loginId,
                            'educational_level' => $level,
                            'institute_name'    => $request->institute_name[$key],
                            'year_of_passing'   => $request->year_of_passing[$key],
                            'percentage'        => $request->percentage[$key],
                            'application_id'    => $applicationId,
                            'edu_serial'        => $newEduSerial,
                            'upload_document'   => $filePath,
                        ]);
                    }
                }
            }
            
            

            if ($request->has('work_level')) {
                // ✅ Fetch last exp_serial from DB once
                $lastExp = Mst_experience::whereNotNull('exp_serial')->latest('id')->value('exp_serial');
                $lastNum = $lastExp ? (int) str_replace('exp_', '', $lastExp) : 0;
            
                foreach ($request->work_level as $key => $company) {
                    // ✅ Skip empty rows
                    if (
                        empty($company) ||
                        empty($request->experience[$key] ?? null) ||
                        empty($request->designation[$key] ?? null)
                    ) {
                        continue;
                    }
            
                    // ✅ Check if row already exists
                    $workId = $request->work_id[$key] ?? null;
                    $work = $workId ? Mst_experience::find($workId) : null;
            
                    // ✅ Handle file upload
                    $filePath = $request->existing_work_document[$key] ?? null;
                    if ($request->hasFile("work_document.$key")) {
                        $file = $request->file("work_document")[$key];
                        if ($file && $file->isValid()) {
                            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $destinationPath = public_path('work_experience');
                            $file->move($destinationPath, $filename);
                            $filePath = 'work_experience/' . $filename;
                        }
                    }
            
                    if ($work) {
                        // 🔹 UPDATE existing record
                        $work->update([
                            'company_name'    => $company,
                            'experience'      => $request->experience[$key],
                            'designation'     => $request->designation[$key],
                            'upload_document' => $filePath,
                        ]);
                    } else {
                        // 🔹 INSERT new record
                        $lastNum++;
                        $newExpSerial = 'exp_' . $lastNum;
            
                        Mst_experience::create([
                            'login_id'        => $loginId,
                            'company_name'    => $company,
                            'experience'      => $request->experience[$key],
                            'designation'     => $request->designation[$key],
                            'application_id'  => $applicationId,
                            'exp_serial'      => $newExpSerial,
                            'upload_document' => $filePath,
                        ]);
                    }
                }
            }

            // 🔹 Save Photo if New Upload
            if ($request->hasFile('upload_photo')) {
                $photoName = 'user_' . time() . '.' . $request->file('upload_photo')->getClientOriginalExtension();
                $request->file('upload_photo')->move(public_path('attached_documents'), $photoName);

                TnelbApplicantPhoto::updateOrCreate(
                    ['application_id' => $applicationId],
                    [
                        'login_id' => $loginId,
                        'upload_path' => 'attached_documents/' . $photoName,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message'=> 'Draft updated and submitted successfully!',
                'application_id' => $applicationId,
                'applicantName' => $existingForm->applicant_name
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message'=> 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }



    public function delete_education(Request $request)
    {
        try {
            $id = $request->input('edu_id'); // Get edu_id from AJAX request

            $education = Mst_education::find($id);

            if (!$education) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Education record not found!'
                ], 404);
            }

            // Delete uploaded file if it exists
            if (!empty($education->upload_document)) {
                $filePath = public_path($education->upload_document);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $education->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Education record deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete record!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function delete_experience(Request $request)
    {
        try {
            $id = $request->input('exp_id'); // Get edu_id from AJAX request

            $experience = Mst_experience::find($id);

            if (!$experience) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Experience record not found!'
                ], 404);
            }

            // Delete uploaded file if it exists
            if (!empty($experience->upload_document)) {
                $filePath = public_path($experience->upload_document);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $experience->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Experience record deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete record!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function draft_submit(Request $request, $id = null)
    {
        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);


        $applicationId = $id;
        $existingForm = Mst_Form_s_w::where('application_id', $applicationId)->first();

        $existingPhoto = TnelbApplicantPhoto::where('application_id', $applicationId)->first();

        if (!$existingForm && $applicationId) {
            return response()->json(['status' => 'error', 'message' => 'Draft not found!'], 404);
        }

        $uploadPhotoRule = (!$existingPhoto || empty($existingPhoto->upload_path))
        ? 'image|mimes:jpg,jpeg,png|max:50'
        : 'nullable|image|mimes:jpg,jpeg,png|max:50';

        $aadhaarDocRule = ($existingForm && !$existingForm->aadhaar_doc)
            ? 'mimes:pdf|max:250'
            : 'nullable|mimes:pdf|max:250';

        $pancardDocRule = ($existingForm && !$existingForm->pan_doc)
            ? 'mimes:pdf|max:250'
            : 'nullable|mimes:pdf|max:250';

            $request->validate([
                'login_id'           => 'nullable|string',
                'applicant_name'     => 'nullable|string|max:255',
                'fathers_name'       => 'nullable|string|max:255',
                'applicants_address' => 'nullable|string|max:500',
                'd_o_b'              => 'nullable|date',
                'age'                => 'integer|min:18|max:100',
                'previously_number'  => 'nullable|string',
                'previously_date'    => 'nullable|date',
                'wireman_details'    => 'nullable|string|max:255',
                'form_name'          => 'nullable|string|max:2',
                'license_name'       => 'nullable|string|max:2',
                'form_id'            => 'nullable|integer',
                'amount'             => 'nullable|numeric|min:0',
    
                'educational_level'    => 'nullable|array|min:1',
                'educational_level.*'  => 'nullable|string|max:50',
                'institute_name'       => 'nullable|array|min:1',
                'institute_name.*'     => 'nullable|string|max:255',
                'year_of_passing'      => 'nullable|array|min:1',
                'year_of_passing.*'    => 'nullable',
                'percentage'           => 'nullable|array|min:1',
                'percentage.*'         => 'nullable|numeric|min:0|max:100',
    
    
                'upload_photo'   => $uploadPhotoRule,
                'aadhaar_doc'    => $aadhaarDocRule,
                'pancard_doc'    => $pancardDocRule,
    
                'education_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:200',
    
                'work_document'        => 'nullable|array',
                'work_document.*'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:200',
            ],[

            // education arrays
            'education_document.*'    => 'Educational document size permitted only 5 KB to 200 KB.',
            'work_document.*.max'    => 'Experience document size permitted only 5 KB to 200 KB.',


            'educational_level.*.string'    => 'Educational level must be a valid string.',
            'educational_level.*.max'       => 'Educational level may not be greater than 50 characters.',

            'institute_name.*.string'       => 'Institute name must be a valid string.',
            'institute_name.*.max'          => 'Institute name may not be greater than 255 characters.',


            'percentage.*.numeric'          => 'Percentage/Grade must be a number.',
            'percentage.*.min'              => 'Percentage/Grade must be at least 0.',
            'percentage.*.max'              => 'Percentage/Grade may not exceed 100.',

            // work experience arrays
            'work_level.*.string'           => 'Work level must be a valid string.',
            'work_level.*.max'              => 'Work level may not be greater than 50 characters.',

            'experience.*.integer'          => 'Experience must be an integer.',
            'experience.*.min'              => 'Experience cannot be negative.',
            'experience.*.max'              => 'Experience may not exceed 50 years.',

            'designation.*.string'          => 'Designation must be a valid string.',
            'designation.*.max'             => 'Designation may not be greater than 100 characters.',

            'aadhaar.digits' => 'Aadhaar number should be 12 digits.',

            'pancard_doc.max' => 'The pancard doc size permitted only 5 KB to 250 KB',
        ]);

        $action = $request->form_action; // "draft" or "submit"
        $loginId = $request->login_id;
        $appl_type = $request->appl_type ?? '';

        DB::beginTransaction();

        try {
            // 🔹 Find existing application if $id is passed
            
            $form = $id ? Mst_Form_s_w::where('application_id', $id)->first() : null;
            
            // 🔹 Determine Application ID
            if ($form) {
                $applicationId = $form->application_id;
            } else {

                // Create New Application ID
                $appl_type = $request->appl_type ?? '';
                
                $lastApplication = Mst_Form_s_w::latest('id')->value('application_id');
                if ($lastApplication) {
                    $lastNumber = (int) substr($lastApplication, -7);
                    $applicationId = $request->form_name . $request->license_name . date('y') . str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT);
                } else {
                    $applicationId = $request->form_name . $request->license_name . date('y') . '1111111';
                }

            }



            $encrypted_aadhaar = Crypt::encryptString($request->aadhaar);
            $encrypted_pancard = Crypt::encryptString($request->pancard);
        
            
            if ($request->hasFile('aadhaar_doc')) {
                $file = $request->file('aadhaar_doc');

                $contents = file_get_contents($file->getRealPath());

                $encrypted = Crypt::encrypt($contents);

                $aadhaarFilename = time() . '_' . rand(10000, 9999999) . '.bin';
                $destinationPath = storage_path('app/private_documents');

                if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                }

                file_put_contents($destinationPath . '/' . $aadhaarFilename, $encrypted);
            }elseif ($request->input('aadhaar_doc_removed') == "1") {
                // ✅ Removed but not replaced
                $aadhaarFilename = null;
            }else {
                // ✅ Keep the old one
                $aadhaarFilename = $form?->aadhaar_doc ?? null;
            }
           
             
            if ($request->hasFile('pancard_doc')) {
                // ✅ New file uploaded
                $file = $request->file('pancard_doc');
                $contents = file_get_contents($file->getRealPath());
                $encrypted = Crypt::encrypt($contents);
            
                $panFilename = time() . '_' . rand(10000, 9999999) . '.bin';
                $destinationPath = storage_path('app/private_documents');
            
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
            
                file_put_contents($destinationPath . '/' . $panFilename, $encrypted);
            } elseif ($request->input('pan_doc_removed') == "1") {
                // ✅ Removed but not replaced
                $panFilename = null;
            } else {
                // ✅ Keep the old one
                $panFilename = $form?->pan_doc ?? null;
            }
            

            // 🔹 Prepare Data
            $data = [
                'login_id'          => $loginId,
                'applicant_name'    => $request->applicant_name ?? $request->Applicant_Name,
                'fathers_name'      => $request->fathers_name ?? $request->Fathers_Name,
                'applicants_address'=> $request->applicants_address,
                'd_o_b'             => $request->d_o_b ?? null,
                'age'               => $request->age,
                'status'            => 'P', // Pending (for both draft/submit)
                'previously_number' => $request->previously_number ?? null,
                'previously_date'   => $request->previously_date ?? null,
                'wireman_details'   => $request->wireman_details,
                'form_name'         => $request->form_name,
                'form_id'           => $request->form_id,
                'license_name'      => $request->license_name,
                'aadhaar'           => $encrypted_aadhaar ?? null,
                'pancard'           => $encrypted_pancard ?? null,
                'appl_type'         => $request->appl_type,
                'license_number'    => $request->license_number,
                'payment_status'    => $action === 'draft' ? 'draft' : 'payment',
                'aadhaar_doc'         => $aadhaarFilename,
                'pan_doc'             => $panFilename,
                'certificate_no'      => $request->certificate_no ?? null,
                'certificate_date'   => $request->certificate_date ?? null,
                'application_id'    => $applicationId,
                'cert_verify'    => $request->cert_verify ?? '0',
                'license_verify'    => $request->l_verify ?? '0',
                'old_application'=> $form->old_application ?? null
            ];



            // 🔹 Insert or Update
            if ($form) {
                $data['updated_at'] = $this->dbNow;
                $form->update($data); // ✅ Update existing
            } else {
                $data['created_at'] = $this->dbNow;
                $form = Mst_Form_s_w::create($data); // ✅ Insert new
            }


            if ($request->has('educational_level')) {

                // ✅ Fetch the last edu_serial from DB
                $lastEdu = Mst_education::whereNotNull('edu_serial')->latest('id')->value('edu_serial');
                $lastNum = $lastEdu ? (int) str_replace('edu_', '', $lastEdu) : 0;
            
                foreach ($request->educational_level as $key => $level) {
            
                    if (
                        empty($level) &&
                        empty($request->institute_name[$key] ?? null) &&
                        empty($request->year_of_passing[$key] ?? null) &&
                        empty($request->percentage[$key] ?? null)
                    ) {
                        continue; // skip empty row
                    }
            
                    $eduId = $request->edu_id[$key] ?? null;
                    $education = $eduId ? Mst_education::find($eduId) : null;
            
                    // ✅ Check if file is removed via JS
                    $isFileRemoved = isset($request->removed_document[$key]) && $request->removed_document[$key] == '1';
            
                    // ✅ File Handling
                    $filePath = null;
            
                    // Case 1: File removed explicitly by user
                    if ($isFileRemoved) {
                        $filePath = null;
                    }
            
                    // Case 2: New file uploaded
                    elseif (isset($request->file('education_document')[$key]) && $request->file('education_document')[$key]->isValid()) {
                        $file = $request->file('education_document')[$key];
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('education_document');
                        $file->move($destinationPath, $filename);
                        $filePath = 'education_document/' . $filename;
                    }
            
                    // Case 3: No new file, not removed, keep existing
                    elseif (!empty($request->existing_document[$key] ?? null)) {
                        $filePath = $request->existing_document[$key];
                    }
            
                    // ✅ Update or Create record
                    if ($education) {
                        $education->update([
                            'educational_level' => $level ?? null,
                            'institute_name'    => $request->institute_name[$key] ?? null,
                            'year_of_passing'   => $request->year_of_passing[$key] ?? null,
                            'percentage'        => $request->percentage[$key] ?? null,
                            'upload_document'   => $filePath,
                        ]);
                    } else {
                        $lastNum++;
                        $newEduSerial = 'edu_' . $lastNum;
            
                        Mst_education::create([
                            'login_id'          => $loginId,
                            'educational_level' => $level,
                            'institute_name'    => $request->institute_name[$key],
                            'year_of_passing'   => $request->year_of_passing[$key],
                            'percentage'        => $request->percentage[$key],
                            'application_id'    => $applicationId,
                            'edu_serial'        => $newEduSerial,
                            'upload_document'   => $filePath,
                        ]);
                    }
                }
            }
            

            if ($request->has('work_level')) {
                // ✅ Fetch last exp_serial from DB once
                $lastExp = Mst_experience::whereNotNull('exp_serial')->latest('id')->value('exp_serial');
                $lastNum = $lastExp ? (int) str_replace('exp_', '', $lastExp) : 0;
            
                foreach ($request->work_level as $key => $company) {
                    // ✅ Skip empty rows
                    if (
                        empty($company) &&
                        empty($request->experience[$key] ?? null) &&
                        empty($request->designation[$key] ?? null)
                    ) {
                        continue;
                    }
            
                    // ✅ Check if row already exists
                    $workId = $request->work_id[$key] ?? null;
                    $work = $workId ? Mst_experience::find($workId) : null;
            
                    // ✅ File Handling
                    $filePath = null;
                    $isFileRemoved = isset($request->removed_document_work[$key]) && $request->removed_document_work[$key] == '1';
            
                    if (!$isFileRemoved && isset($request->file("work_document")[$key])) {
                        $file = $request->file("work_document")[$key];
            
                        if ($file && $file->isValid()) {
                            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $destinationPath = public_path('work_experience');
                            $file->move($destinationPath, $filename);
                            $filePath = 'work_experience/' . $filename;
                        }
                    }
            
                    if ($work) {
                        // 🔹 UPDATE existing record
                        $work->update([
                            'company_name'    => $company ?? null,
                            'experience'      => $request->experience[$key] ?? null,
                            'designation'     => $request->designation[$key] ?? null,
                            'upload_document' => $isFileRemoved ? null : ($filePath ?? $work->upload_document),
                        ]);
                    } else {
                        // 🔹 INSERT new record
                        $lastNum++;
                        $newExpSerial = 'exp_' . $lastNum;
            
                        Mst_experience::create([
                            'login_id'        => $loginId,
                            'company_name'    => $company,
                            'experience'      => $request->experience[$key],
                            'designation'     => $request->designation[$key],
                            'application_id'  => $applicationId,
                            'exp_serial'      => $newExpSerial,
                            'upload_document' => $filePath,
                        ]);
                    }
                }
            }
            

            // 🔹 Save Photo if New Upload
            if ($request->hasFile('upload_photo')) {
                $photoName = 'user_' . time() . '.' . $request->file('upload_photo')->getClientOriginalExtension();
                $request->file('upload_photo')->move(public_path('attached_documents'), $photoName);

                TnelbApplicantPhoto::updateOrCreate(
                    ['application_id' => $applicationId],
                    [
                        'login_id' => $loginId,
                        'upload_path' => 'attached_documents/' . $photoName,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => $action === 'draft' ? 'Draft saved successfully!' : 'Form submitted successfully!',
                'application_id' => $applicationId,
                'applicantName' => $form->applicant_name
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function draft_renewal_submit(Request $request, $id = null)
    {

        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);



        $applicationId = $id;

        $existingForm  = Mst_Form_s_w::where('application_id', $applicationId)->first();
        $existingPhoto = TnelbApplicantPhoto::where('application_id', $applicationId)->first();

        if (!$existingForm && $applicationId) {
            return response()->json(['status' => 'error', 'message' => 'Draft not found!'], 404);
        }

        $uploadPhotoRule = (!$existingPhoto || empty($existingPhoto->upload_path))
            ? 'image|mimes:jpg,jpeg,png|max:50'
            : 'nullable|image|mimes:jpg,jpeg,png|max:50';

        $aadhaarDocRule = ($existingForm && !$existingForm->aadhaar_doc)
            ? 'mimes:pdf|max:250'
            : 'nullable|mimes:pdf|max:250';

        $pancardDocRule = ($existingForm && !$existingForm->pan_doc)
            ? 'mimes:pdf|max:250'
            : 'nullable|mimes:pdf|max:250';

      

        $request->validate([
            'login_id'           => 'nullable|string',
            'applicant_name'     => 'nullable|string|max:255',
            'fathers_name'       => 'nullable|string|max:255',
            'applicants_address' => 'nullable|string|max:500',
            'd_o_b'              => 'nullable|date',
            'age'                => 'integer|min:18|max:100',
            'previously_number'  => 'nullable|string',
            'previously_date'    => 'nullable|date',
            'wireman_details'    => 'nullable|string|max:255',
            'form_name'          => 'nullable|string|max:2',
            'license_name'       => 'nullable|string|max:2',
            'form_id'            => 'nullable|integer',
            'amount'             => 'nullable|numeric|min:0',

            'educational_level'    => 'nullable|array|min:1',
            'educational_level.*'  => 'nullable|string|max:50',
            'institute_name'       => 'nullable|array|min:1',
            'institute_name.*'     => 'nullable|string|max:255',
            'year_of_passing'      => 'nullable|array|min:1',
            'year_of_passing.*'    => 'nullable',
            'percentage'           => 'nullable|array|min:1',
            'percentage.*'         => 'nullable|numeric|min:0|max:100',

            'upload_photo'   => $uploadPhotoRule,
            'aadhaar_doc'    => $aadhaarDocRule,
            'pancard_doc'    => $pancardDocRule,

            'education_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:200',

            'work_document'        => 'nullable|array',
            'work_document.*'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:200',
        ],[
            'education_document.*'   => 'Educational document size permitted only 5 KB to 200 KB.',
            'work_document.*.max'    => 'Experience document size permitted only 5 KB to 200 KB.',

            'educational_level.*.string' => 'Educational level must be a valid string.',
            'educational_level.*.max'    => 'Educational level may not be greater than 50 characters.',
            'institute_name.*.string'    => 'Institute name must be a valid string.',
            'institute_name.*.max'       => 'Institute name may not be greater than 255 characters.',
            'percentage.*.numeric'       => 'Percentage/Grade must be a number.',
            'percentage.*.min'           => 'Percentage/Grade must be at least 0.',
            'percentage.*.max'           => 'Percentage/Grade may not exceed 100.',

            'work_level.*.string'        => 'Work level must be a valid string.',
            'work_level.*.max'           => 'Work level may not be greater than 50 characters.',
            'experience.*.integer'       => 'Experience must be an integer.',
            'experience.*.min'           => 'Experience cannot be negative.',
            'experience.*.max'           => 'Experience may not exceed 50 years.',
            'designation.*.string'       => 'Designation must be a valid string.',
            'designation.*.max'          => 'Designation may not be greater than 100 characters.',

            'aadhaar.digits' => 'Aadhaar number should be 12 digits.',
            'pancard_doc.max' => 'The pancard doc size permitted only 5 KB to 250 KB',
        ]);

        $action    = $request->form_action; // "draft" or "submit"
        $loginId   = $request->login_id;
        $appl_type = $request->appl_type ?? 'R'; // ensure renewal

        DB::beginTransaction();

        try {
            // find current renewal (editing same renewal draft) or create fresh ID
            $form = $id ? Mst_Form_s_w::where('application_id', $id)
                ->where('appl_type','R')
                ->first() : null;

            if ($form) {
                $applicationId = $form->application_id; // keep same ID while editing the renewal draft
            } else {
                // create new renewal application_id
                $lastApplication = Mst_Form_s_w::latest('id')->value('application_id');
                if ($lastApplication) {
                    $lastNumber    = (int) substr($lastApplication, -7);
                    $applicationId = $appl_type . ($request->form_name ?? '') . ($request->license_name ?? '')
                                . date('y') . str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT);
                } else {
                    $applicationId = $appl_type . ($request->form_name ?? '') . ($request->license_name ?? '')
                                . date('y') . '1111111';
                }
            }

            // encrypt aadhaar/pan numbers
            $encrypted_aadhaar = $request->aadhaar ? Crypt::encryptString($request->aadhaar) : null;
            $encrypted_pancard = $request->pancard ? Crypt::encryptString($request->pancard) : null;

            // helper to store encrypted private docs (aadhaar/pan)
            $storeEncryptedPrivate = function(\Illuminate\Http\UploadedFile $file = null) {
                if (!$file) return null;
                $contents   = file_get_contents($file->getRealPath());
                $encrypted  = Crypt::encrypt($contents);
                $filename   = time() . '_' . rand(10000, 9999999) . '.bin';
                $dest       = storage_path('app/private_documents');
                if (!is_dir($dest)) mkdir($dest, 0755, true);
                file_put_contents($dest . '/' . $filename, $encrypted);
                return $filename;
            };

            // Aadhaar file: new / removed / keep (fallback to old app if needed)
            if ($request->hasFile('aadhaar_doc')) {
                $aadhaarFilename = $storeEncryptedPrivate($request->file('aadhaar_doc'));
            } elseif ($request->input('aadhaar_doc_removed') == "1") {
                $aadhaarFilename = null;
            } else {
                // keep existing (prefer current renewal draft else fall back to $id)
                $aadhaarFilename = $form?->aadhaar_doc
                    ?? Mst_Form_s_w::where('application_id', $id)->value('aadhaar_doc');
            }

            // PAN file: new / removed / keep (fallback to old app if needed)
            if ($request->hasFile('pancard_doc')) {
                $panFilename = $storeEncryptedPrivate($request->file('pancard_doc'));
            } elseif ($request->input('pan_doc_removed') == "1") {
                $panFilename = null;
            } else {
                $panFilename = $form?->pan_doc
                    ?? Mst_Form_s_w::where('application_id', $id)->value('pan_doc');
            }


            // assemble master application data (APPLICATION ENTRY ✅)
            $data = [
                'login_id'           => $loginId,
                'applicant_name'     => $request->applicant_name ?? $request->Applicant_Name,
                'fathers_name'       => $request->fathers_name ?? $request->Fathers_Name,
                'applicants_address' => $request->applicants_address,
                'd_o_b'              => $request->d_o_b ?? null,
                'age'                => $request->age,
                'status'             => 'P',
                'previously_number'  => $request->previously_number ?? null,
                'previously_date'    => $request->previously_date ?? null,
                'wireman_details'    => $request->wireman_details,
                'form_name'          => $request->form_name,
                'form_id'            => $request->form_id,
                'license_name'       => $request->license_name,
                'aadhaar'            => $encrypted_aadhaar,
                'pancard'            => $encrypted_pancard,
                'appl_type'          => $appl_type,           // ensure 'R'
                'license_number'     => $request->license_number,
                'payment_status'     => 'draft',
                'aadhaar_doc'        => $aadhaarFilename ?? null,
                'pan_doc'            => $panFilename ?? null,
                'certificate_no'     => $request->certificate_no ?? null,
                'certificate_date'   => $request->certificate_date ?? null,
                'application_id'     => $applicationId,
                'cert_verify'        => $request->cert_verify ?? '0',
                'license_verify'     => $request->l_verify ?? '0',
                'old_application'    => $form ? $form->old_application : $id,
            ];

            // insert or update master application
            if ($form) {
                $form->update($data);      // editing same renewal draft
            } else {
                $form = Mst_Form_s_w::create($data); // brand-new renewal application entry ✅
            }


            $type_of_apps = MstLicence::where('form_code', $form->form_name)
            ->select('licence_name')
            ->first();



            // var_dump($type_of_apps->licence_name);die;

            // -------------------------
            // ALWAYS-INSERT Education  ✅
            // -------------------------
            if ($request->has('educational_level')) {
                $lastEdu = Mst_education::whereNotNull('edu_serial')->latest('id')->value('edu_serial');
                $lastNum = $lastEdu ? (int) str_replace('edu_', '', $lastEdu) : 0;

                foreach ($request->educational_level as $key => $level) {
                    $levelName  = $level ?? null;
                    $institute  = $request->institute_name[$key] ?? null;
                    $year       = $request->year_of_passing[$key] ?? null;
                    $percentage = $request->percentage[$key] ?? null;

                    $removed    = isset($request->removed_document[$key]) && $request->removed_document[$key] == '1';
                    $newDoc     = (isset($request->file('education_document')[$key]) && $request->file('education_document')[$key]->isValid())
                                    ? $request->file('education_document')[$key]
                                    : null;
                    $oldDoc     = $request->existing_document[$key] ?? null;

                    // final doc path: removed => null, new => stored, else keep old path (view mode)
                    if ($removed) {
                        $finalDoc = null;
                    } elseif ($newDoc) {
                        $filename = time() . '_' . uniqid() . '.' . $newDoc->getClientOriginalExtension();
                        $newDoc->move(public_path('education_document'), $filename);
                        $finalDoc = 'education_document/' . $filename;
                    } else {
                        $finalDoc = $oldDoc ?: null;
                    }

                    // skip only if EVERYTHING is empty (avoid junk rows)
                    $hasAnyData = !empty($levelName) || !empty($institute) || !empty($year) || !empty($percentage) || !empty($finalDoc);
                    if (!$hasAnyData) continue;

                    $lastNum++;
                    $newSerial = 'edu_' . $lastNum;

         
                    Mst_education::updateOrCreate(
                        [
                            'login_id'          => $loginId,
                            'application_id'    => $applicationId,
                            'educational_level' => $levelName,
                        ],
                        [
                            'institute_name'    => $institute,
                            'year_of_passing'   => $year,
                            'percentage'        => $percentage,
                            'upload_document'   => $finalDoc,
                            'edu_serial'        => $newSerial,
                        ]
                    );
                }
            }

            // -------------------------
            // ALWAYS-INSERT Work  ✅
            // -------------------------
            if ($request->has('work_level')) {
                $lastExp = Mst_experience::whereNotNull('exp_serial')->latest('id')->value('exp_serial');
                $lastNum = $lastExp ? (int) str_replace('exp_', '', $lastExp) : 0;

                foreach ($request->work_level as $key => $company) {
                    $companyName = $company ?? null;
                    $expYears    = $request->experience[$key] ?? null;
                    $designation = $request->designation[$key] ?? null;

                    $removed     = isset($request->removed_document_work[$key]) && $request->removed_document_work[$key] == '1';
                    $newDoc      = (isset($request->file('work_document')[$key]) && $request->file('work_document')[$key]->isValid())
                                    ? $request->file('work_document')[$key]
                                    : null;
                    $oldDoc      = $request->existing_work_document[$key] ?? null;

                    if ($removed) {
                        $finalDoc = null;
                    } elseif ($newDoc) {
                        $filename = time() . '_' . uniqid() . '.' . $newDoc->getClientOriginalExtension();
                        $newDoc->move(public_path('work_experience'), $filename);
                        $finalDoc = 'work_experience/' . $filename;
                    } else {
                        $finalDoc = $oldDoc ?: null;
                    }

                    $hasAnyData = !empty($companyName) || !empty($expYears) || !empty($designation) || !empty($finalDoc);
                    if (!$hasAnyData) continue;

                    $lastNum++;
                    $newSerial = 'exp_' . $lastNum;

                    Mst_experience::updateOrCreate(
                        [
                            'login_id'       => $loginId,
                            'application_id' => $applicationId,
                            'company_name'   => $companyName,
                        ],
                        [
                            'experience'      => $expYears,
                            'designation'     => $designation,
                            'upload_document' => $finalDoc,
                            'exp_serial'      => $newSerial,
                        ]
                    );
                }
            }


            // Photo (insert/update for this renewal app_id)
            if ($request->hasFile('upload_photo') && $request->file('upload_photo')->isValid()) {
                // ✅ New photo uploaded
                $photoName = 'user_' . time() . '.' . $request->file('upload_photo')->getClientOriginalExtension();
                $request->file('upload_photo')->move(public_path('attached_documents'), $photoName);

                TnelbApplicantPhoto::updateOrCreate(
                    ['application_id' => $applicationId], // New application ID
                    [
                        'login_id' => $loginId,
                        'upload_path' => 'attached_documents/' . $photoName,
                    ]
                );
            } else {
                // ✅ No new photo, try to fetch from old application
                $oldPhoto = TnelbApplicantPhoto::where('application_id', $id)->first();

                if ($oldPhoto) {
                    // Insert old photo path into the new application
                    TnelbApplicantPhoto::updateOrCreate(
                        ['application_id' => $applicationId], // New application ID
                        [
                            'login_id' => $loginId,
                            'upload_path' => $oldPhoto->upload_path,
                        ]
                    );
                }
            }

            

            DB::commit();

            return response()->json([
                'status'         => 'success',
                'message'        => $action === 'draft' ? 'Draft saved successfully!' : 'Form submitted successfully!',
                'application_id' => $applicationId,
                'applicantName'  => $form->applicant_name,
                'form_name'      => $form->form_name,
                'licence_name'   => $type_of_apps->licence_name,
                'date_apps'      => $this->dbNow
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong. Please try again!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }





    public function update(Request $request, $id)
    {
        $request->merge([
            'aadhaar' => preg_replace('/\D/', '', $request->aadhaar)
        ]);
        $applicationId = $id;
        $existingForm = Mst_Form_s_w::where('application_id', $applicationId)->first();
        $existingPhoto = TnelbApplicantPhoto::where('application_id', $applicationId)->first();

        if (!$existingForm && $applicationId) {
            return response()->json(['status' => 'error', 'message' => 'Draft not found!'], 404);
        }
        $uploadPhotoRule = (!$existingPhoto || empty($existingPhoto->upload_path))
        ? 'image|mimes:jpg,jpeg,png|max:50'
        : 'nullable|image|mimes:jpg,jpeg,png|max:50';
        $aadhaarDocRule = ($existingForm && !$existingForm->aadhaar_doc)
            ? 'mimes:pdf|max:250'
            : 'nullable|mimes:pdf|max:250';
        $pancardDocRule = ($existingForm && !$existingForm->pan_doc)
            ? 'mimes:pdf|max:250'
            : 'nullable|mimes:pdf|max:250';
            $request->validate([
                'login_id'           => 'nullable|string',
                'applicant_name'     => 'nullable|string|max:255',
                'fathers_name'       => 'nullable|string|max:255',
                'applicants_address' => 'nullable|string|max:500',
                'd_o_b'              => 'nullable|date',
                'age'                => 'integer|min:18|max:100',
                'previously_number'  => 'nullable|string',
                'previously_date'    => 'nullable|date',
                'wireman_details'    => 'nullable|string|max:255',
                'form_name'          => 'nullable|string|max:2',
                'license_name'       => 'nullable|string|max:2',
                'form_id'            => 'nullable|integer',
                // 'amount'             => 'nullable|numeric|min:0',
                'educational_level'    => 'nullable|array|min:1',
                'educational_level.*'  => 'nullable|string|max:50',
                'institute_name'       => 'nullable|array|min:1',
                'institute_name.*'     => 'nullable|string|max:255',
                'year_of_passing'      => 'nullable|array|min:1',
                'year_of_passing.*'    => 'nullable',
                'percentage'           => 'nullable|array|min:1',
                'percentage.*'         => 'nullable|numeric|min:0|max:100',
                'upload_photo'   => $uploadPhotoRule,
                'aadhaar_doc'    => $aadhaarDocRule,
                'pancard_doc'    => $pancardDocRule,
    
                'education_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:200',
    
                'work_document'        => 'nullable|array',
                'work_document.*'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:200',
            ],[

            // education arrays
            'education_document.*'    => 'Educational document size permitted only 5 KB to 200 KB.',
            'work_document.*.max'    => 'Experience document size permitted only 5 KB to 200 KB.',
            'educational_level.*.string'    => 'Educational level must be a valid string.',
            'educational_level.*.max'       => 'Educational level may not be greater than 50 characters.',
            'institute_name.*.string'       => 'Institute name must be a valid string.',
            'institute_name.*.max'          => 'Institute name may not be greater than 255 characters.',
            'percentage.*.numeric'          => 'Percentage/Grade must be a number.',
            'percentage.*.min'              => 'Percentage/Grade must be at least 0.',
            'percentage.*.max'              => 'Percentage/Grade may not exceed 100.',
            // work experience arrays
            'work_level.*.string'           => 'Work level must be a valid string.',
            'work_level.*.max'              => 'Work level may not be greater than 50 characters.',
            'experience.*.integer'          => 'Experience must be an integer.',
            'experience.*.min'              => 'Experience cannot be negative.',
            'experience.*.max'              => 'Experience may not exceed 50 years.',
            'designation.*.string'          => 'Designation must be a valid string.',
            'designation.*.max'             => 'Designation may not be greater than 100 characters.',
            'aadhaar.digits' => 'Aadhaar number should be 12 digits.',
            'pancard_doc.max' => 'The pancard doc size permitted only 5 KB to 250 KB',
        ]);

        $action = $request->form_action;
        $loginId = $request->login_id;

        DB::beginTransaction();

        try {

            
            $appl_type = $request->appl_type ?? '';
            $form = Mst_Form_s_w::where('application_id', $id)
            ->where('appl_type', $appl_type)
            ->first();

            if ($form) {
                $applicationId = $form->application_id;
            } else {

                $lastApplication = Mst_Form_s_w::latest('id')->value('application_id');
                if ($lastApplication) {
                    $lastNumber = (int) substr($lastApplication, -7);
                    $applicationId = $appl_type . $request->form_name . $request->license_name . date('y') . str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT);
                } else {
                    $applicationId = $appl_type . $request->form_name . $request->license_name . date('y') . '1111111';
                }
            }
            $encrypted_aadhaar = Crypt::encryptString($request->aadhaar);
            $encrypted_pancard = Crypt::encryptString($request->pancard);
            if ($request->hasFile('aadhaar_doc')) {
                $file = $request->file('aadhaar_doc');

                $contents = file_get_contents($file->getRealPath());

                $encrypted = Crypt::encrypt($contents);

                $aadhaarFilename = time() . '_' . rand(10000, 9999999) . '.bin';
                $destinationPath = storage_path('app/private_documents');

                if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                }

                file_put_contents($destinationPath . '/' . $aadhaarFilename, $encrypted);
            }elseif ($request->input('aadhaar_doc_removed') == "1") {
                // ✅ Removed but not replaced
                $aadhaarFilename = null;
            }else {
                // ✅ Keep the old one
                $aadhaarFilename = $form?->aadhaar_doc ?? null;

                if ($aadhaarFilename == null) {
                    $aadhaarFilename = Mst_Form_s_w::where('application_id', $id)->value('aadhaar_doc');
                }
            }
                 
            if ($request->hasFile('pancard_doc')) {
                // ✅ New file uploaded
                $file = $request->file('pancard_doc');
                $contents = file_get_contents($file->getRealPath());
                $encrypted = Crypt::encrypt($contents);
                $panFilename = time() . '_' . rand(10000, 9999999) . '.bin';
                $destinationPath = storage_path('app/private_documents');
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                file_put_contents($destinationPath . '/' . $panFilename, $encrypted);

            } elseif ($request->input('pan_doc_removed') == "1") {
                $panFilename = null;
            } else {
                $panFilename = $form?->pan_doc ?? null;
                if ($panFilename == null) {
                    $panFilename = Mst_Form_s_w::where('application_id', $id)->value('pan_doc');
                }
            }

            $renewal_form = Mst_Form_s_w::updateOrCreate(
                [
                    'application_id' => $applicationId
                ],
                [
                    'login_id'           => $loginId,
                    'applicant_name'     => $request->applicant_name ?? $request->Applicant_Name,
                    'fathers_name'       => $request->fathers_name ?? $request->Fathers_Name,
                    'applicants_address' => $request->applicants_address,
                    'd_o_b'              => $request->d_o_b ?? 0,
                    'age'                => $request->age,
                    'status'             => 'P',
                    'previously_number'  => $request->previously_number ?? 0,
                    'previously_date'    => $request->previously_date ?? 0,
                    'wireman_details'    => $request->wireman_details,
                    'form_name'          => $request->form_name,
                    'form_id'            => $request->form_id,
                    'license_name'       => $request->license_name,
                    'aadhaar'            => $encrypted_aadhaar,
                    'pancard'            => $encrypted_pancard,
                    'certificate_no'     => $request->certificate_no ?? null,
                    'certificate_date'   => $request->certificate_date ?? null,
                    'appl_type'          => $appl_type,
                    'license_number'     => $request->license_number,
                    'payment_status'     => 'draft',
                    'aadhaar_doc'        => $aadhaarFilename ?? $form?->aadhaar_doc ?? null,
                    'pan_doc'            => $panFilename ?? $form?->pan_doc ?? null,
                    'cert_verify'        => $request->cert_verify ?? '0',
                    'license_verify'     => $request->l_verify ?? '0',
                    'old_application'    => $id ?? '',
                ]
            );

            $applicationId = $renewal_form->application_id;

            $form_details = MstLicence::where('status', 1)
            ->select('*')
            ->get()
            ->toArray();
            $form_category = LicenceCategory::where('status', 1)
            ->select('*')
            ->get()
            ->toArray();
            // var_dump($renewal_form->license_name);die;

            // var_dump($form_details);
            // var_dump($renewal_form->license_name);die;
            $current_form = collect($form_details)->firstWhere('cert_licence_code', $renewal_form->license_name);
            $category_type = collect($form_category)->firstWhere('id', $current_form['category_id']);

            $licence_details['licence_name'] = $current_form['licence_name'];
            // var_dump($licence_details);die;
            $licence_details['category_name'] = $category_type['category_name'];
            $licence_details['form_type'] = $renewal_form->appl_type;


            // var_dump($licence_details);die;



            // Update Education Records
            if ($request->has('educational_level')) {
                $lastEdu = Mst_education::whereNotNull('edu_serial')->latest('id')->value('edu_serial');
                $lastNum = $lastEdu ? (int) str_replace('edu_', '', $lastEdu) : 0;

                foreach ($request->educational_level as $key => $level) {
                    $levelName  = $level ?? null;
                    $institute  = $request->institute_name[$key] ?? null;
                    $year       = $request->year_of_passing[$key] ?? null;
                    $percentage = $request->percentage[$key] ?? null;

                    $removed    = isset($request->removed_document[$key]) && $request->removed_document[$key] == '1';
                    $newDoc     = (isset($request->file('education_document')[$key]) && $request->file('education_document')[$key]->isValid())
                                    ? $request->file('education_document')[$key]
                                    : null;
                    $oldDoc     = $request->existing_document[$key] ?? null;

                    // final doc path: removed => null, new => stored, else keep old path (view mode)
                    if ($removed) {
                        $finalDoc = null;
                    } elseif ($newDoc) {
                        $filename = time() . '_' . uniqid() . '.' . $newDoc->getClientOriginalExtension();
                        $newDoc->move(public_path('education_document'), $filename);
                        $finalDoc = 'education_document/' . $filename;
                    } else {
                        $finalDoc = $oldDoc ?: null;
                    }

                    // skip only if EVERYTHING is empty (avoid junk rows)
                    $hasAnyData = !empty($levelName) || !empty($institute) || !empty($year) || !empty($percentage) || !empty($finalDoc);
                    if (!$hasAnyData) continue;

                    $lastNum++;
                    $newSerial = 'edu_' . $lastNum;

                    Mst_education::updateOrCreate(
                        [
                            'login_id'          => $loginId,
                            'application_id'    => $applicationId,
                            'educational_level' => $levelName,
                        ],
                        [
                            'institute_name'    => $institute,
                            'year_of_passing'   => $year,
                            'percentage'        => $percentage,
                            'upload_document'   => $finalDoc,
                            'edu_serial'        => $newSerial,
                        ]
                    );
                }
            }
            
            if ($request->has('work_level')) {
                $lastExp = Mst_experience::whereNotNull('exp_serial')->latest('id')->value('exp_serial');
                $lastNum = $lastExp ? (int) str_replace('exp_', '', $lastExp) : 0;

                foreach ($request->work_level as $key => $company) {
                    $companyName = $company ?? null;
                    $expYears    = $request->experience[$key] ?? null;
                    $designation = $request->designation[$key] ?? null;

                    $removed     = isset($request->removed_document_work[$key]) && $request->removed_document_work[$key] == '1';
                    $newDoc      = (isset($request->file('work_document')[$key]) && $request->file('work_document')[$key]->isValid())
                                    ? $request->file('work_document')[$key]
                                    : null;
                    $oldDoc      = $request->existing_work_document[$key] ?? null;

                    if ($removed) {
                        $finalDoc = null;
                    } elseif ($newDoc) {
                        $filename = time() . '_' . uniqid() . '.' . $newDoc->getClientOriginalExtension();
                        $newDoc->move(public_path('work_experience'), $filename);
                        $finalDoc = 'work_experience/' . $filename;
                    } else {
                        $finalDoc = $oldDoc ?: null;
                    }

                    $hasAnyData = !empty($companyName) || !empty($expYears) || !empty($designation) || !empty($finalDoc);
                    if (!$hasAnyData) continue;

                    $lastNum++;
                    $newSerial = 'exp_' . $lastNum;

                    Mst_experience::updateOrCreate(
                        [
                            'login_id'       => $loginId,
                            'application_id' => $applicationId,
                            'company_name'   => $companyName,
                        ],
                        [
                            'experience'      => $expYears,
                            'designation'     => $designation,
                            'upload_document' => $finalDoc,
                            'exp_serial'      => $newSerial,
                        ]
                    );
                }
            }

            // process photo
             if ($request->hasFile('upload_photo')) {
                $photoName = 'user_' . time() . '.' . $request->file('upload_photo')->getClientOriginalExtension();
                $request->file('upload_photo')->move(public_path('attached_documents'), $photoName);

                TnelbApplicantPhoto::updateOrCreate(
                    ['application_id' => $applicationId],
                    [
                        'login_id' => $loginId,
                        'upload_path' => 'attached_documents/' . $photoName,
                    ]
                );
            }

            

            // Process Payment for update
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Form submitted successfully!',
                'application_id' => $applicationId,
                'applicantName' => $renewal_form->applicant_name,
                'form_name' => $renewal_form->form_name,
                'licence_name' => $licence_details['licence_name'],
                'type_of_apps' => $licence_details['category_name'],
                'form_type' => $licence_details['form_type'] == 'N'?'FRESH':'RENEWAL',
                'date_apps'      => $this->dbNow
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong. Please try again!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function storeEducationDocument($file, $loginId, $eduSerial, $applicationId)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('education', $filename, 'public');

        // Use raw SQL to avoid any model issues
        DB::table('tnelb_applicants_doc')->insert([
            'login_id' => $loginId,
            'education_serial' => $eduSerial,
            'experience_serial' => null,
            'education_doc' => $filePath,
            'experience_doc' => null,
            'upload_photo' => null,
            'upload_sign' => null,
            'application_id' => $applicationId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function storeWorkDocument($file, $loginId, $expSerial, $applicationId)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('work_experience', $filename, 'public');

        // Use raw SQL to avoid any model issues
        DB::table('tnelb_applicants_doc')->insert([
            'login_id' => $loginId,
            'education_serial' => null,
            'experience_serial' => $expSerial,
            'education_doc' => null,
            'experience_doc' => $filePath,
            'upload_photo' => null,
            'upload_sign' => null,
            'application_id' => $applicationId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function storePhotoDocument($file, $loginId, $applicationId)
    {
        $filename = 'user' . $applicationId . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('attached_documents', $filename, 'public');

        // Use raw SQL to avoid any model issues
        DB::table('tnelb_applicants_doc')->insert([
            'login_id' => $loginId,
            'education_serial' => null,
            'experience_serial' => null,
            'education_doc' => null,
            'experience_doc' => null,
            'upload_photo' => $filePath,
            'upload_sign' => null,
            'application_id' => $applicationId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function storeSignatureDocument($file, $loginId, $applicationId)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('attached_documents', $filename, 'public');

        // Use raw SQL to avoid any model issues
        DB::table('tnelb_applicants_doc')->insert([
            'login_id' => $loginId,
            'education_serial' => null,
            'experience_serial' => null,
            'education_doc' => null,
            'experience_doc' => null,
            'upload_photo' => null,
            'upload_sign' => $filePath,
            'application_id' => $applicationId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function showEncryptedDocument($type, $filename)
    {
        $allowedTypes = [
            'aadhaar' => ['folder' => 'private_documents', 'default_mime' => 'application/pdf'],
            'pan'     => ['folder' => 'private_documents', 'default_mime' => 'application/pdf'],
        ];

        if (!array_key_exists($type, $allowedTypes)) {
            abort(400, 'Invalid document type.');
        }

        $path = storage_path('app/' . $allowedTypes[$type]['folder'] . '/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        $encrypted = file_get_contents($path);

        try {
            $decrypted = Crypt::decrypt($encrypted);
        } catch (\Exception $e) {
            abort(500, 'Could not decrypt file.');
        }

        // Detect mime type by extension
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'pdf':
                $mime = 'application/pdf';
                break;
            case 'jpg':
            case 'jpeg':
                $mime = 'image/jpeg';
                break;
            case 'png':
                $mime = 'image/png';
                break;
            default:
                $mime = $allowedTypes[$type]['default_mime'];
        }

        return response($decrypted)
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }


      public function getFormCost(Request $request)
    {
        
        $applType = $request->input('appl_type'); // R = Renewal, N = New
        $formName = $request->input('form_name'); // e.g. S, W, WH
        $form = DB::table('tnelb_forms')
            ->where('form_name', 'FORM '.$formName)
            ->where('status', 1)
            ->first();

        if (!$form) {
            return response()->json(['form_cost' => null]);
        }

        $formCost = ($applType === 'R')
            ? $form->renewal_amount
            : $form->fresh_amount;
        
        return response()->json(['form_cost' => $formCost]);
    }
}
