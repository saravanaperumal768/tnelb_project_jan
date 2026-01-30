<?php

namespace App\Http\Controllers;

use App\Models\Admin\TnelbFee;
use App\Models\admin\TnelbForms;
use App\Models\EA_Application_model;
use App\Models\Mst_Form_s_w;
use App\Models\MstLicence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Register;

use App\Models\Admin\Mst_equipment_tbl;

use App\Models\TnelbApplicantPhoto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isNull;

class RegisterController extends BaseController
{
    protected $today;
    public function __construct()
    {
        parent::__construct();   
        $this->middleware('web');
        $this->today = Carbon::today()->toDateString();
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('register');
    }



   public function store(Request $request)
    {
        // var_dump($request->Address);die;
        // Validate Input
        $validator = Validator::make($request->all(), [
            'salutation' => 'required|in:Mr,Mrs,Ms,Dr',
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'gender'     => 'required|string',
            'mobile'     => [
                'required',
                'digits:10',
                Rule::unique('tnelb_registers', 'mobile'),
            ],
            'email'      => [
                'nullable',
                'email',
                Rule::unique('tnelb_registers', 'email'),
            ],
            'Address'    => 'required|string',
            'state'      => 'required|string|max:255',
            'district' => 'nullable|required_if:state,Tamil Nadu|string|max:255',

            'pincode'    => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate Login ID
        $latestRecord = Register::latest('id')->first();
        if ($latestRecord && preg_match('/tnelb_(\d+)/', $latestRecord->login_id, $matches)) {
            $newRecord = (int) $matches[1] + 1;
        } else {
            $newRecord = 1120;
        }
        $newLoginId = 'tnelb_' . $newRecord;

        // Store Data in Database
        $register = Register::create([
            'salutation' => $request->input('salutation'),
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'gender'     => $request->input('gender'),
            'mobile'     => $request->input('mobile'),
            'email'      => $request->input('email'),
            'address'    => $request->input('Address'),
            'state'      => $request->input('state'),
            // 'district'   => $request->input('district'),
            'district'   => $request->filled('district') ? $request->district : 0,
            'pincode'    => $request->input('pincode'),
            'login_id'   => $newLoginId,
            'created_at' => now()
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Registration successful!',
            'login_id' => $newLoginId,
        ], 200);
    }


    public function store_bkUP(Request $request)
    {
        // Validate Input
        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Transgender',
            'PhoneNo' => 'required|digits:10|unique:tnelb_registers,mobile',
            'EmailAddress' => 'nullable|email|unique:tnelb_registers,email',
            'Address' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'pincode' => 'required|digits:6',
            'aadhaar' => 'required|digits:12',
            'pancard' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate Login ID
        $latestRecord = Register::latest('id')->first();

        if ($latestRecord && preg_match('/tnelb_(\d+)/', $latestRecord->login_id, $matches)) {
            $newRecord = (int) $matches[1] + 1;
        } else {
            $newRecord = 1120; // Start from 1120 if no previous records exist
        }

        $newLoginId = 'tnelb_' . $newRecord;

        // Store Data in Database
        $register = Register::create([
            'name' => $request->input('Name'),
            'gender' => $request->input('gender'),
            'mobile' => $request->input('PhoneNo'),
            'email' => $request->input('EmailAddress'),
            'address' => $request->input('Address'),
            'state' => $request->input('state'),
            'district' => $request->input('district'),
            'pincode' => $request->input('pincode'),
            'aadhaar' => $request->input('aadhaar'),
            'pancard' => $request->input('pancard'),
            'login_id' => $newLoginId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'login_id' => $newLoginId,
        ], 200);
    }

    public function user_login()
    {
        return view('user_login.index');
    }


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


        $form_details = MstLicence::where('status', 1)
            ->select('*')
            ->get()
            ->toArray();
        
        $current_form = collect($form_details)->firstWhere('form_code', $application_details->form_name);


        if (!$current_form) {
            abort(504, 'Form Not Found..');
        }
        
        $fees_details = TnelbFee::where('cert_licence_id', $current_form['id'])
        ->whereDate('start_date', '<=', $this->today)
        ->select('fees', 'start_date')
        ->orderBy('start_date', 'desc')
        ->first();

        


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

        if ($application_details->appl_type == 'R') {
            $license_details = DB::table('tnelb_license')
            ->where('license_number', $application_details->license_number)
            ->select('*')
            ->first();
        }else{
            $license_details = DB::table('tnelb_license')
            ->where('application_id', $appl_id)
            ->select('*')
            ->first();
        }

        $applicant_photo = TnelbApplicantPhoto::where('application_id', $appl_id)
        ->latest('id')
        ->first();

        $applicationid = $appl_id;
        return view('user_login.renew-form', compact( 'applicationid','application_details','edu_details','exp_details','apps_doc','license_details','applicant_photo',
    'fees_details'));
    }


    public function apply_form_s()
    {
        if (!Auth::check()) {
            return redirect()->route('logout');
        }
        $authUser = Auth::user();

        $user = [
            'user_id' => $authUser->login_id,
            'salutation' => $authUser->salutation,
            'applicant_name' => $authUser->first_name.' '.$authUser->last_name,
        ];
        // var_dump($user);die;
        
        // $check_applications = Mst_Form_s_w::where('login_id', $user_id)
        //         ->where('form_name', 'S')
        //         ->exists();

        // if ($check_applications) {
        //     return redirect()->route('dashboard')->with('already_applied', true);
        // }

        return view('user_login.apply-form-s', compact('user'));
    }



    public function apply_form_w()
    {

        if (!Auth::check()) {
            return redirect()->route('logout');
        }
        $authUser = Auth::user();

        $user = [
            'user_id' => $authUser->login_id,
            'salutation' => $authUser->salutation,
            'applicant_name' => $authUser->first_name.' '.$authUser->last_name,
        ];

        // $user_id = Auth::user()->login_id;
        // $check_applications = Mst_Form_s_w::where('login_id', $user_id)
        //         ->where('form_name', 'W')
        //         ->exists();

        // if ($check_applications) {
        //     return redirect()->route('dashboard')->with('already_applied', true);
        // }


        return view('user_login.apply-form-w', compact('user'));
    }


    public function apply_form_wh()
    {

        if (!Auth::check()) {
            return redirect()->route('logout');
        }
        $authUser = Auth::user();

        $user = [
            'user_id' => $authUser->login_id,
            'salutation' => $authUser->salutation,
            'applicant_name' => $authUser->first_name.' '.$authUser->last_name,
        ];

        // $user_id = Auth::user()->login_id;
        // $check_applications = Mst_Form_s_w::where('login_id', $user_id)
        //         ->where('form_name', 'WH')
        //         ->exists();

        // if ($check_applications) {
        //     return redirect()->route('dashboard')->with('already_applied', true);
        // }


        return view('user_login.apply-form-wh', compact('user'));
    }

    public function apply_form_a()
    {

        if (!Auth::check()) {
            return redirect()->route('logout');
        }

          $equiplist = Mst_equipment_tbl::where('equip_licence_name', 8)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        // $equipmentlist = DB::table('equipmentforma_tbls')
        //     ->where('login_id', Auth::user()->login_id)
        //     // ->where('application_id', $applicationId) // IMPORTANT
        //     ->get();

        // $user_id = Auth::user()->login_id;
        // $check_applications = EA_Application_model::where('login_id', $user_id)
        //         ->where('form_name', 'A')
        //         ->exists();

        // if ($check_applications) {
        //     return redirect()->route('dashboard')->with('already_applied', true);
        // }


         return view('user_login.apply-form-a', compact('equiplist'));
    }

    public function loginpage()
    {
        return view('loginpage');
    }

    public function apply_form($form_name, $application_id)
    {
        if (!Auth::check()) {
            return redirect()->route('logout');
        }

        
        $application = Mst_Form_s_w::where('application_id', $application_id)->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found.');
        }

        // Return the view with the fetched data
        $viewName = ($form_name === 's') ? 'user_login.apply-form-s' : 'user_login.apply-form-w';

        // Return the dynamic view
        return view($viewName, compact('application', 'form_name'));
    }



    
}
