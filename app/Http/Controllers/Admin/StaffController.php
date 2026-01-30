<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mst_Staffs_Tbl;
use App\Models\Admin\TnelbForms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{

     protected $updatedBy;

    public function __construct()
    {
        // Ensure user is authenticated before accessing
        $this->middleware(function ($request, $next) {
            $this->updatedBy = Auth::user()->name ?? 'System';
            return $next($request);
        });
    }
    public function index(){

        $staffs = Mst_Staffs_Tbl::orderby('updated_at')->get();

        $forms = TnelbForms::all();
        

        $formlist = TnelbForms::where(function ($query) {
            $query->whereNull('Assigned')
                    ->WhereNull('old_id');
                //   ->orWhere('Assigned', '');
        })->get();
        

        return view('admincms.staffdetails.index', compact( 'staffs', 'forms', 'formlist'));
    }

    public function insertStaff(Request $request)
    {
        $request->validate([
            'staff_name'    => 'required|string',
            'name'          => 'required|string',
            'name'         => 'required|string|unique:mst__staffs__tbls,name', 
            'email'        => 'required|email|unique:mst__staffs__tbls,email',
            'handle_forms'  => 'required|array',
            'status'        => 'required|in:0,1,2',
            // 'created_by'    => 'required|string',
            // 'updated_by'    => 'required|string',
        ]);
    
        // Step 1: Create staff record
        $staff = Mst_Staffs_Tbl::create([
            'staff_name'    => $request->staff_name,
            'name'   => $request->name,
            'email'         => $request->email,
            'handle_forms'  => json_encode($request->handle_forms),
            'status'        => $request->status,
            // 'created_by'    => $request->created_by,
            'updated_by'    => $this->updatedBy,
        ]);
    
        // Step 2: Update forms with this staff_id
        TnelbForms::whereIn('id', $request->handle_forms)->update([
            'staff_id' => $staff->id,
            'Assigned' => 'A'
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Staff Added Successfully.',
            'staff' => $staff,
            'form_names' => TnelbForms::whereIn('id', $request->handle_forms)->pluck('form_name')->toArray()
        ]);
    }


    // ------------------------update staff details-----------------------

    public function updateStaff(Request $request)
{
    // dd($request->all());
    // exit;
    $request->validate([
        'id'            => 'required|exists:mst__staffs__tbls,id',
        'staff_name'    => 'required|string',
        'name'          => 'required|string',
        'email'         => 'required|email|unique:mst__staffs__tbls,email,' . $request->id,
        'handle_forms'  => 'required|array',
        'status'        => 'required|in:0,1,2',
        
    ]);

    $staff = Mst_Staffs_Tbl::findOrFail($request->id);

    // Update staff
    $staff->update([
        'staff_name'    => $request->staff_name,
        'name'          => $request->name,
        'email'         => $request->email,
        'handle_forms'  => json_encode($request->handle_forms),
        'status'        => $request->status,
        'updated_by'    => $this->updatedBy,
    ]);
    
    // Reset old forms (optional logic to clear old assignments)
    TnelbForms::where('staff_id', $staff->id)->update([
        'staff_id' => null,
        'Assigned' => null
    ]);
    
    // Assign selected forms
    TnelbForms::whereIn('id', $request->handle_forms)->update([
        'staff_id' => $staff->id,
        'Assigned' => 'A'
    ]);
    
    // ✅ Get form names to return
    $formNames = TnelbForms::whereIn('id', $request->handle_forms)->pluck('form_name')->toArray();
    
    return response()->json([
        'status' => 'success',
        'message' => 'Staff updated successfully.',
        'staff' => $staff,
        'form_names' => $formNames,
        'handle_forms' => $request->handle_forms
    ]);
    
    
}

    

}
