<?php

namespace App\Http\Controllers;

use App\Models\Login_Logs;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function login()
    {
        return view('login');
    }
    public function check(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            // 'captcha' => ['required'],
        ], [
            'phone.required' => 'Enter Mobile Number.',
            'phone.digits' => 'Enter a valid 10-digit mobile number.',
        ]);



        // Check if the phone number exists
        $user = Register::where('mobile', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a valid user. Please register now.'
            ], 422);
        }


        // Store login ID in session temporarily
        Session::put('login_user', $user->login_id);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully'
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);
    
        if ($request->otp !== '123456') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.'
            ], 422);
        }
    
        $loginUser = Session::get('login_user');
        if (!$loginUser) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please log in again.'
            ], 401);
        }
    
        $user = Register::where('login_id', $loginUser)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    
        // Store session and login
        Session::put('login_id', $user->login_id);
        Session::put('user_name', $user->name);
        Auth::login($user);
    
        Login_Logs::create([
            'login_id' => $user->login_id,
            'ipaddress' => request()->ip(),
            'Idate' => now(),
            'attempt' => 1,
            'duration' => 0.00,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
             'redirect_url' => route('finalize.login'),

            'user_name' => $user->name,
        ], 200);
    }
    
    


    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->route('login');
    }

    public function dashboard()
    {
        $loginId = session('login_id'); // Get login_id from session
    
        if (!$loginId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }
    
        // Retrieve user details
        $user = DB::table('tnelb_registers')->where('login_id', $loginId)->first(); 
    
        // Store user name in session
        if ($user) {
            session(['name' => $user->name]);
        }

    
    
        // Fetch workflows
        $workflows_cl = DB::table('tnelb_applicant_formA as af')
            ->leftJoin('tnelb_license as l', 'af.application_id', '=', 'l.application_id')
            ->where('af.login_id', $loginId)
            ->select('af.*', 'l.license_number','l.expires_at')
            ->get();
        // var_dump($workflows_cl);die;
    
        $workflows_present = DB::table('tnelb_application_tbl as ta')
            ->leftJoin('tnelb_license as l', 'ta.application_id', '=', 'l.application_id')
            ->where('ta.login_id', $loginId)
            ->select('ta.*', 'l.license_number','l.expires_at')
            ->get();


            

        //  $workflows_present = DB::table('tnelb_application_tbl as ta') 
        //     ->where('ta.login_id', $loginId)
        //     ->select('ta.*')
        //     ->get();
        
        // $workflows_cl = DB::table('tnelb_applicant_formA');

        $table_applied = DB::table('tnelb_application_tbl')->all();
        
    
        return view('user_login.index', compact('loginId', 'workflows_cl', 'workflows_present', 'table_applied'));
    }
    
}
