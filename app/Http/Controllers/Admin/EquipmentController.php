<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mst_equipment_tbl;
use App\Models\Admin\TnelbForms;
use App\Models\MstLicence;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator as ValidationValidator;
use Validator;

class EquipmentController extends Controller
{
    protected $userId;
    protected $today;
    public function __construct()
    {

        // ✅ Ensure user must be logged in
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                // Not logged in
                return redirect()->route('login');
            }

            // ✅ If logged in, store the user ID
            $this->userId = Auth::id();

            return $next($request);
        });

        $this->today = now()->toDateString();
    }

    public function index()
    {

        $all_licences = MstLicence::where('status', 1)
        ->where('category_id', '1')
            ->orderBy('created_at', 'desc')
            ->get();

        $equiplist = DB::table('mst_equipment_tbls as e')
            ->leftJoin('mst_licences as ml', 'ml.id', '=', 'e.equip_licence_name')
            // ->where('e.status', 1)
            ->orderByDesc('e.created_at')
            ->select(
                'e.*',
                'ml.licence_name'
            )
            ->get();



        $activeForms = TnelbForms::leftJoin('mst_licences', 'tnelb_forms.licence_id', '=', 'mst_licences.id')
            ->where('tnelb_forms.status', 1)
            ->orderBy('tnelb_forms.created_at', 'desc')
            ->select('mst_licences.licence_name', 'mst_licences.form_name', 'tnelb_forms.*')
            ->get();




        return view('admincms.equipmentlist.index', compact('activeForms', 'all_licences', 'equiplist'));
    }


    public function operations(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'equip_licence_name' => 'required|integer',
            'equip_name'         => 'required|string|min:2|max:255',
            'equipment_type'         => 'required|string|max:255',
        ], [
            'equip_licence_name.required' => 'Choose the Licence Name',
            'equip_name.required'         => 'Fill the Equipment Name',
            'equipment_type.required'         => 'Choose the Equipment Type'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $equipment = Mst_equipment_tbl::create([
            'equip_licence_name' => $request->equip_licence_name,
            'equip_name'         => $request->equip_name,
             'equipment_type'    => $request->equipment_type,
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
            'message' => 'Equipment added successfully',
            'data' => [
                'id' => $equipment->id,
                'equipment_type' => $equipment->equipment_type,
                'equip_name' => $equipment->equip_name,
                'licence_name' => $licence->licence_name ?? 'N/A',
                'created_at' => $equipment->created_at->format('d-m-Y'),
                'status' => $equipment->status,
            ]
        ]);
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'status' => 'required|in:0,1'
        ]);

        Mst_equipment_tbl::where('id', $request->id)->update([
            'status' => $request->status,
            'updated_by' => $this->userId,
            'updated_at' => now(),
            'ipaddress' => $request->ip(),
        ]);

        return response()->json([
            'message' => $request->status == 1 ? 'Equipment Activated' : 'Equipment Deactivated'
        ]);
    }


    // FeesValidity::create([
    //             'licence_id'        => $request->cert_id,
    //             'form_type'         => $formType,
    //             'validity'          => $validity,
    //             'validity_start_date' => $validityStartDate,
    //             'status'            => $request->form_status ?? 1,
    //             'created_by'        => $this->userId,
    //             'created_at'        => now(),
    //             'ipaddress'       => $request->ip(),
    //         ]);
}
