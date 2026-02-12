<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mst_filepath_module;
use App\Models\admin\TnelbForms;
use App\Models\mst_file_loc_cl_tbl;
use App\Models\MstLicence;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Illuminate\Validation\Validator as ValidationValidator;
use Validator;

class FilelocationController extends Controller
{

    protected $userId;
    protected $today;
    public function __construct()
    {

        
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                // Not logged in
                return redirect()->route('login');
            }

            // If logged in, store the user ID
            $this->userId = Auth::id();

            return $next($request);
        });

        $this->today = now()->toDateString();
    }
    public function index()
    {

        // return '111';
        // exit;

        $all_licences = MstLicence::where('status', 1)
            ->where('category_id', '1')
            ->orderBy('created_at', 'desc')
            ->get();

        $fileloc = DB::table('mst_filepath_cl_tbl as e')
            ->leftJoin('mst_licences as ml', 'ml.id', '=', 'e.cert_license_id')
            // ->where('e.status', 1)
            ->orderByDesc('e.created_at')
            ->select(
                'e.*',
                'ml.licence_name'
            )
            ->get();


              $all_formmodule = Mst_filepath_module::where('status', 1)
               ->get();



        $activeForms = TnelbForms::leftJoin('mst_licences', 'tnelb_forms.licence_id', '=', 'mst_licences.id')
            ->where('tnelb_forms.status', 1)
            ->orderBy('tnelb_forms.created_at', 'desc')
            ->select('mst_licences.licence_name', 'mst_licences.form_name', 'tnelb_forms.*')
            ->get();



        // return view('admincms.Fileloc.index', compact('all_licences'));
        return view('admincms.Fileloc.index', compact('activeForms', 'all_licences', 'fileloc', 'all_formmodule'));
    }


    // ---------------storemodule-----------------------

    public function storemodule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'cert_license_id' => 'required|integer',
            'module_name'         => 'required|string|min:2|max:255',
            
        ], [
            'cert_license_id.required' => 'Choose the Licence Name',
            'module_name.required'         => 'Fill the Module Name',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $equipment = Mst_filepath_module::create([
            'cert_license_id' => $request->cert_license_id,
            'module_name'         => $request->module_name,
            
            'created_by'        => $this->userId,
            'updated_by'        => $this->userId,
            'status'            => 1,
            'ipaddress'       => $request->ip(),
        ]);

        // get licence name
        $licence = DB::table('mst_licences')
            ->where('id', $equipment->equip_licence_name)
            ->first();

        return response()->json([
            'message' => 'Form Module added successfully You Can add Filepath After this',
            // 'data' => [
            //     'id' => $equipment->id,
            //     'equipment_type' => $equipment->equipment_type,
            //     'equip_name' => $equipment->equip_name,
            //     'licence_name' => $licence->licence_name ?? 'N/A',
            //     'created_at' => $equipment->created_at->format('d-m-Y'),
            //     'status' => $equipment->status,
            // ]
        ]);
    }


    // -------------------storefilepath----------------------------
     public function storepath(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cert_license_id' => 'required|integer',
            'form_module'         => 'required|string|min:2|max:50',
            'appl_type'         => 'required|string|min:1|max:20',

            'filepath_temp'         => 'required|string|min:2|max:255',
            'filepath_pro'         => 'required|string|min:2|max:255',
            
            
        ], [
            'cert_license_id.required' => 'Choose the Licence Name',
            'form_module.required'         => 'Choose the Module Name',
            'appl_type.required'         => 'Choose the Module Name',
            'filepath_temp.required'         => 'Fill the Module Name',
            'filepath_pro.required'         => 'Fill the Module Name',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $filepath = mst_file_loc_cl_tbl::create([
            'cert_license_id' => $request->cert_license_id,
            'form_module'         => $request->form_module,
            'appl_type'    => $request->appl_type,
            'filepath_temp'    => $request->filepath_temp,
            'filepath_pro'    => $request->filepath_pro,
            'created_by'        => $this->userId,
            'updated_by'        => $this->userId,
            'status'            => 1,
            'ipaddress'       => $request->ip(),
        ]);

        // get licence name
        $licence = DB::table('mst_licences')
            ->where('id', $filepath->cert_license_id)
            ->first();

        return response()->json([
            'message' => 'Filepath added Successfully',
            'data' => [
                'id' => $filepath->id,
                'form_module' => $filepath->form_module,
                'appl_type' => $filepath->appl_type,
                'filepath_temp' => $filepath->filepath_temp,
                'filepath_pro' => $filepath->filepath_pro,
            
                'licence_name' => $licence->licence_name ?? 'N/A',
                'created_at' => $filepath->created_at->format('d-m-Y'),
                'status' => $filepath->status,
            ]
        ]);
    }

    // -----------------------------------update status--------------------

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'status' => 'required|in:0,1'
        ]);

        mst_file_loc_cl_tbl::where('id', $request->id)->update([
            'status' => $request->status,
            'updated_by' => $this->userId,
            'updated_at' => now(),
            'ipaddress' => $request->ip(),
        ]);

        return response()->json([
            'message' => $request->status == 1 ? 'Filepath Activated' : 'Filepath Deactivated'
        ]);
    }
}
