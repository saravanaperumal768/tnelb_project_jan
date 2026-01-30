<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index()
    {


        // $staffmembers = DB::table('mst__staffs__tbls')->where('status', '1')->get();
        // $forms = DB::table('tnelb_forms')->all();
        $staffmembers = DB::table('mst__staffs__tbls')
            ->leftJoin('tnelb_forms', DB::raw('mst__staffs__tbls.form_id'), '=', DB::raw('tnelb_forms.id::text'))
            ->where('mst__staffs__tbls.status', 1)
            ->select('mst__staffs__tbls.*', 'tnelb_forms.form_name')
            ->get();

        $forms = DB::table('tnelb_forms')->get();

        return view('admincms.roles.index', compact('staffmembers', 'forms'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'staff_name' => 'required|string',
            'name' => 'required|string|unique:mst__staffs__tbls,name',
            'email' => 'required|email|unique:mst__staffs__tbls,email',
            'password' => 'required|string',
            'form_id' => 'required',
            'updated_by' => 'required',
        ]);

        $maxRoleId = DB::table('mst__staffs__tbls')->max('roles_id');
        $nextRoleId = $maxRoleId ? $maxRoleId + 1 : 1;

        $staffId = DB::table('mst__staffs__tbls')->insertGetId([
            'staff_name' => $request->staff_name,
            'name' => $request->name,
            'email' => $request->email,
            'roles_id' => $nextRoleId,
            'password' => bcrypt($request->password),
            'form_id' => $request->form_id,
            'status' => 1,
            'updated_by' => $request->updated_by,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // $form = Form::find($request->form_id);

        return response()->json([
            'success' => true,
            'staff' => [
                'id' => $staffId,
                'staff_name' => $request->staff_name,
                'name' => $request->name,
                'email' => $request->email,
                // 'form_name' => $form ? $form->form_name : '',
            ]
        ]);
    }

    public function edit($id)
    {
        $staff = DB::table('mst__staffs__tbls')->where('id', $id)->first();

        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }

        return response()->json(['staff' => $staff]);
    }
}
