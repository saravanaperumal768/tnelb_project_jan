<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Admin\FeesValidity;
use App\Models\Admin\LicenceCategory;
use App\Models\Admin\TnelbForms;
use App\Models\Admin\MstFeesDetail;
use App\Models\Admin\TnelbFee;
use App\Models\MstLicence;
use App\Models\TnelbLicense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mews\Purifier\Facades\Purifier;

class LicenceManagementController extends BaseController
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

    public function index(){

        $all_licences = MstLicence::where('status', 1)
        ->orderBy('created_at', 'desc')
        ->get();


        $activeForms = TnelbForms::leftJoin('mst_licences', 'tnelb_forms.licence_id', '=', 'mst_licences.id')
        ->where('tnelb_forms.status', 1)
        ->orderBy('tnelb_forms.created_at', 'desc')
        ->select('mst_licences.licence_name','mst_licences.form_name', 'tnelb_forms.*')
        ->get();


        $validity_periods = FeesValidity::leftJoin('mst_licences', 'mst_fees_validity.licence_id', '=', 'mst_licences.id')
        ->select('mst_licences.licence_name','mst_licences.form_name', 'mst_fees_validity.*',
        DB::raw("CASE WHEN mst_fees_validity.validity_start_date <= '$this->today' THEN 'Active' ELSE 'Inactive' END AS status")
        )
        ->orderByRaw("CASE WHEN mst_fees_validity.validity_start_date <= '$this->today' THEN 1 ELSE 2 END") // Active first
        ->orderBy('mst_fees_validity.created_at', 'desc') 
        ->get();

        $fees_details = TnelbFee::leftJoin('mst_licences', 'tnelb_fees.cert_licence_id', '=', 'mst_licences.id')
        ->select(
            'mst_licences.licence_name',
            'mst_licences.form_name',
            'tnelb_fees.*',
            DB::raw("CASE WHEN tnelb_fees.start_date <= '$this->today' THEN 'Active' ELSE 'Inactive' END AS status")
        )
        ->orderByRaw("CASE WHEN tnelb_fees.start_date <= '$this->today' THEN 1 ELSE 2 END") // Active first
        ->orderBy('tnelb_fees.created_at', 'desc') 
        ->get();

        



        // return view('admincms.forms.forms', compact('activeForms', 'all_licences'));
        return view('admincms.forms.feesvalidity', compact('activeForms', 'all_licences', 'fees_details', 'validity_periods'));
    }

    

    public function view_licences(){

        $categories = LicenceCategory::where('status', 1)
        ->orderBy('created_at', 'desc')
        ->get();

        $all_licences = MstLicence::leftJoin('mst_licence_category', 'mst_licences.category_id', '=', 'mst_licence_category.id')
        ->where('mst_licences.status', 1)
        ->orderBy('mst_licences.category_id', 'ASC')
        ->select('mst_licence_category.category_name', 'mst_licences.*')
        ->get();

        return view('admincms.forms.view_forms', compact('categories','all_licences'));
    }

    public function add_licence(Request $request)
    {
        try {
            
            $isUpdate = !empty($request->cert_id);
            // 🔹 1. Validate input fields
            $validated = $request->validate([
                'form_cate'     => 'required|integer',
                'cert_name'         => 'required|string|regex:/^[A-Za-z\s]+$/|min:3|max:100',
                'cate_licence_code' => ['required','string','max:5',Rule::unique('mst_licences', 'cert_licence_code')->ignore($request->cert_id)],
                'form_name'         => 'required|string|regex:/^[A-Za-z\s]+$/|min:2|max:100',
                'form_code'         => ['required','string','max:5',Rule::unique('mst_licences', 'form_code')->ignore($request->cert_id)],
                'renewal_apply'       => 'nullable|numeric',
                'form_status'       => 'required|in:1,2',
            ], [
                'form_cate.required'         => 'Please choose the category',
                'cert_name.required'         => 'Please fill the Certificate / Licence Name',
                'cert_name.regex'            => 'Certtificate / Licence Name should contain only letters and spaces',
                'form_name.regex'            => 'Form Code should contain only letters and spaces',
                'cate_licence_code.required' => 'Please fill the Certificate / Licence Code',
                'cate_licence_code.unique'   => 'This Certificate / Licence Code already exists',
                'form_name.required'         => 'Please fill the Form Name',
                'form_name.regex'            => 'Form Name should contain only letters and spaces',
                'form_code.required'         => 'Please fill the Form Code',
                'form_code.unique'           => 'This Form Code already exists',
                'form_status.required'       => 'Please choose the Status',
            ]);
            
           
            // 🔹 2. Insert into database (example table: mst_licences)
            $data = [
                'category_id'       => $request->form_cate,
                'licence_name'      => trim($request->cert_name),
                'cert_licence_code' => strtoupper(trim($request->cate_licence_code)),
                'form_name'         => trim($request->form_name),
                'form_code'         => strtoupper(trim($request->form_code)),
                'status'            => $request->form_status,
                'renewal_apply_start'         => $request->renewal_apply,
            ];

            // var_dump($data);die;

            if ($isUpdate) {
                $data['updated_at'] = now();
                MstLicence::where('id', $request->cert_id)
                ->update($data);

                $message = 'Updated successfully!';
            }else{
                $data['created_at'] = now();
                MstLicence::insert($data);
                $message = 'Created successfully!';
            }

            return response()->json([
                'status'  => true,
                'message' => $message,
            ], 200);

     
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function licenceCategory(){

        $categories = LicenceCategory::where('status', 1)
                    ->orderBy('created_at', 'asc')
                    ->get();


        return view('admincms.forms.category', compact('categories'));
    }

    public function add_category(Request $request){

        $isUpdate = $request->filled('cate_id');
        
        if ($isUpdate) {
            $request->validate([
                'edit_cate_name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
                'form_status' => ['nullable', 'in:1,2'],
            ], [
                'edit_cate_name.required' => 'Category name is required.',
                'edit_cate_name.regex' => 'Category name should contain only letters and spaces.',
            ]);
            
            $category = LicenceCategory::findOrFail($request->cate_id);
            $category->update([
                'category_name' => $request->edit_cate_name,
                'status' => $request->status ?? $category->status,
                'updated_by' => $this->userId,
                'updated_at' => now()->toDateString(),
            ]);
            
            $message = 'Category updated successfully';
        } else {

            $request->validate([
                'cate_name' => ['required', 'regex:/^[a-zA-Z\s]+$/', Rule::unique((new LicenceCategory())->getTable(), 'category_name')],
                'form_status' => ['nullable', 'in:1,2'],
                ], [
                    'cate_name.required' => 'Category name is required.',
                    'cate_name.regex' => 'Category name should contain only letters and spaces.',
                    'cate_name.unique' => 'This category already exists.',
                ]);

            $category = LicenceCategory::create([
                'category_name' => $request->cate_name,
                'status' => $request->form_status ?? 1,
                'created_by' => $this->userId,
                'created_at' => now()->toDateString(),
                'updated_at' => now()->toDateString(),
            ]);
    
            $message = 'Category added successfully';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $category
        ]);
    }

    public function formHistory(Request $request){


        $form_id = $request->form_id;


        $formHistory = TnelbForms::where('status', 0)
                    ->where('licence_id', $form_id)
                    ->orderBy('created_at', 'desc')
                    ->get();


        $html = '';
        $sno = 1;

        foreach ($formHistory as $form) {
            $html .= '<tr>';
            $html .= '<td>' . $sno++ . '</td>';
            $html .= '<td>' . $form->form_name . '</td>';
            $html .= '<td>' . $form->license_name . '</td>';
            $html .= '<td>' . $form->fresh_fee_amount . '</td>';
            $html .= '<td>' . $form->fresh_fee_starts . '</td>';
            $html .= '<td>' . $form->fresh_fee_ends . '</td>';
            $html .= '<td>' . $form->renewal_amount . '</td>';
            $html .= '<td>' . $form->renewalamount_starts . '</td>';
            $html .= '<td>' . $form->renewalamount_ends . '</td>';
            $html .= '<td>' . $form->latefee_amount . '</td>';
            $html .= '<td>' . $form->latefee_starts . '</td>';
            $html .= '<td>' . $form->latefee_ends . '</td>';
            $html .= '<td class="text-center">';
            if ($form->status == 1) {
                $html .= '<span class="badge bg-success">Active</span>';
            } else {
                $html .= '<span class="badge bg-danger">Inactive</span>';
            }
            $html .= '</td>';


            $html .= '<td>' . $form->created_at . '</td>';
            $html .= '<td>' . ($form->updated_at ?? '-') . '</td>';
            $html .= '</tr>';
        }

        return response()->json(['html' => $html]);
        
    }

    public function getPaymentDetails(Request $request){
        try {

            
            $licence_code = $request->licence_code;
            $issued_licence = $request->issued_licence;
            $appl_type = $request->appl_type;

            // dd($request->all());
            // exit;
            $licence = MstLicence::where('cert_licence_code',$licence_code)->first();
            // var_dump($licence->id,$appl_type,$issued_licence);die;
            //    dd($request->all());
            // exit;
            // dd($licence);die;
            if ($appl_type === 'R') {

                //   dd($issued_licence);
                // exit;
                $paymentDetails = DB::select("
                SELECT * FROM calc_fees(:appl_type, :licence_id, :issued_licence)
                ", [
                    'appl_type' => $appl_type,
                    'licence_id' => $licence->id,
                    'issued_licence' => $issued_licence,
                ]);
                

            } 
            else {
                // dd($licence->id);
                // exit;
                $paymentDetails = DB::select("
                    SELECT * FROM calc_fees(:appl_type, :licence_id, :issued_licence)
                ", [
                    'appl_type' => $appl_type,
                    'licence_id' => $licence->id,
                    'issued_licence' => null,
                ]);
//                 dd($paymentDetails);
// exit;
            }


            if (!empty($paymentDetails)) {
                $fees_details['total_fees'] = $paymentDetails[0]->total_fee;
                $fees_details['lateFees'] = $paymentDetails[0]->late_fee;
                $fees_details['late_months'] = $paymentDetails[0]->late_months;
                $fees_details['basic_fees'] = $paymentDetails[0]->base_fee;
                $fees_details['certificate_name'] = $paymentDetails[0]->certificate_name;
                $fees_details['fees_start_date'] = date("d-m-Y", strtotime($paymentDetails[0]->fees_start_date));
            }
            

            // $fees_details['certificate_name'] = $fees->licence_name;

            return response()->json([
                'status' => 'success',
                'fees_details' => $fees_details,
            ], 200);
            

        } catch (Exception $e) {
             return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. ' . $e->getMessage(),
            ], 500);
        }    
    }


    public function updateFees(Request $request)
    {
        // var_dump($request->all());die;
        $request->validate([
            'cert_name' => 'required|string',
            'form_name' => 'required|string',
            // 'license_name' => 'required|string',
            'fresh_fees' => 'required|numeric',
            'fresh_fees_on' => 'required|date',
            'fresh_fees_ends_on' => 'nullable|date',
            'renewal_fees' => 'required|numeric',
            'renewal_fees_as_on' => 'required|date',
            'renewal_fees_ends_on' => 'nullable|date',
            'latefee_for_renewal' => 'required|numeric',
            'late_renewal_fees_on' => 'required|date',
            'late_renewal_fees_ends_on' => 'nullable|date',
            'form_status' => 'required',
        ]);

        DB::beginTransaction(); 
        
        try {

            $form = TnelbForms::create([
                'form_name'                 => $request->form_name,
                'licence_id'                => $request->cert_name,
                'fresh_fee_amount'          => $request->fresh_fees,
                'fresh_fee_starts'          => $request->fresh_fees_on,
                'fresh_fee_ends'            => $request->fresh_fees_ends_on,

                'renewal_amount'            => $request->renewal_fees,
                'renewalamount_starts'      => $request->renewal_fees_as_on,
                'renewalamount_ends'        => $request->renewal_fees_ends_on,

                'latefee_amount'            => $request->latefee_for_renewal,
                'latefee_starts'            => $request->late_renewal_fees_on,
                'latefee_ends'              => $request->late_renewal_fees_ends_on,
                'status'                        => $request->form_status,
                'created_by'                    => $this->userId,       
            ]); 

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Form created successfully!',
            ]);

         } catch (Exception $e) {
            DB::rollBack(); 

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateForm(Request $request){

        $request->validate([
            'cert_name' => 'required|string',
            'form_name' => 'required|string',
            'fresh_fees'            => 'required|numeric',
            'fresh_fees_on'         => 'required|date',
            'fresh_fees_ends_on'    => 'nullable|date',
            'renewal_fees'          => 'required|numeric',
            'renewal_fees_on'       => 'required|date',
            'renewal_fees_ends_on'  => 'nullable|date',

            'latefee_for_renewal'       => 'required|numeric',
            'late_renewal_fees_on'      => 'required|date',
            'late_renewal_fees_ends_on' => 'nullable|date',
            'form_status' => 'required',
        ]);

        DB::beginTransaction(); 
        
        try {

            $form_id = $request->form_id;
            $checked_form = TnelbForms::find($form_id);

            if (!$checked_form) {
                return response()->json([
                    'status' => false,
                    'message' => 'Fees Details not found',
                ]);
            }

            
            // Create an array of fields to compare
            $fieldsToCompare = [
                'form_name'                 => $request->form_name,
                'licence_id'                => $request->cert_name,
                'fresh_fee_amount'          => $request->fresh_fees,
                'fresh_fee_starts'          => $request->fresh_fees_on,
                'fresh_fee_ends'          => $request->fresh_fees_ends_on,
                'renewal_amount'            => $request->renewal_fees,
                'renewalamount_starts'      => $request->renewal_fees_on,
                'renewalamount_ends'      => $request->renewal_fees_ends_on,
                'latefee_amount'            => $request->latefee_for_renewal,
                'latefee_starts'            => $request->late_renewal_fees_on,
                'latefee_ends'            => $request->late_renewal_fees_ends_on,
                'status'                    => $request->form_status,
            ];
            
            // Compare current vs old
            $changes = [];
            foreach ($fieldsToCompare as $key => $newValue) {
                $oldValue = $checked_form->$key;
                if ((string)$oldValue !== (string)$newValue) {
                    $changes[$key] = ['old' => $oldValue, 'new' => $newValue];
                }
            }
            
            // If no changes, stop
            if (empty($changes)) {
                return response()->json([
                    'status' => false,
                    'message' => 'No changes detected. Form remains unchanged.',
                ]);
            }

            if ($checked_form) {
                $checked_form->status = 0;
                $checked_form->fresh_fee_ends = now(); 
                $checked_form->renewalamount_ends = now(); 
                $checked_form->latefee_ends = now(); 
                $checked_form->updated_by = $this->userId; 
                $checked_form->updated_at = now(); 
                $checked_form->save();
            }

            $form = TnelbForms::create([
                'form_name'                     => $request->form_name,
                'licence_id'                  => $request->cert_name,

                'fresh_fee_amount'              => $request->fresh_fees,
                'fresh_fee_starts'              => $request->fresh_fees_on,
                'fresh_fee_ends'                => $request->fresh_fees_ends_on,

                'renewal_amount'            => $request->renewal_fees,
                'renewalamount_starts'      => $request->renewal_fees_on,
                'renewalamount_ends'        => $request->renewal_fees_ends_on,

                'latefee_amount'            => $request->latefee_for_renewal,
                'latefee_starts'            => $request->late_renewal_fees_on,
                'latefee_ends'              => $request->late_renewal_fees_ends_on,

                'status'                        => $request->form_status,
                'created_by'                    => $this->userId,       
                'category', 
            ]); 

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Form Updated successfully!',
            ]);

         } catch (Exception $e) {
            DB::rollBack(); 

            // Optional: delete uploaded file if DB failed
            if (!empty($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function management(){

        $all_licences = MstLicence::where('status', 1)
        ->orderBy('created_at', 'desc')
        ->get();
        

        $activeForms = TnelbForms::leftJoin('mst_licences', 'tnelb_forms.licence_id', '=', 'mst_licences.id')
        ->where('tnelb_forms.status', 1)
        ->orderBy('tnelb_forms.created_at', 'desc')
        ->select('mst_licences.licence_name', 'tnelb_forms.*')
        ->get();

        $validity_periods = FeesValidity::leftJoin('mst_licences', 'mst_fees_validity.licence_id', '=', 'mst_licences.id')
        ->where('mst_fees_validity.status', 1)
        ->orderBy('mst_fees_validity.created_at', 'desc')
        ->select('mst_licences.licence_name','mst_licences.form_name', 'mst_fees_validity.*')
        ->get();

        
        // compact('activeForms', 'all_licences')
        return view('admincms.forms.viewLicences', compact('all_licences', 'activeForms','validity_periods'));

    }



    public function updateValidity(Request $request)
    {

        $formType = $request->input('form_type');
        $recordId = $request->input('form_id');

        
        $rules = [
            'cert_id'     => 'required|integer',
            'form_type'   => 'required|in:N,R,L,A',
            'form_status' => 'nullable|in:1,0,true,false,on',
        ];

        $nullable = [
            'fresh_form_duration'          => 'nullable|numeric|min:1',
            'fresh_form_duration_on'       => 'nullable|date',
            'renewal_form_duration'        => 'nullable|numeric|min:1',
            'renewal_duration_on'          => 'nullable|date',
            'renewal_late_fee_duration'    => 'nullable|numeric|min:1',
            'renewal_late_fee_duration_on' => 'nullable|date',
            'enableRenewal'                => 'nullable|numeric|min:1',
            'enableRenewalStarts'          => 'nullable|date',
        ];

        $rules = array_merge($rules, $nullable);

        
        switch ($formType) {
            case 'N':
                $rules = array_merge($rules, [
                    'fresh_form_duration'          => 'required|numeric|min:1',
                    'fresh_form_duration_on'       => 'required|date',
                    'renewal_form_duration'        => 'prohibited',
                    'renewal_duration_on'          => 'prohibited',
                    'renewal_late_fee_duration'    => 'prohibited',
                    'renewal_late_fee_duration_on' => 'prohibited',
                ]);
                break;

            case 'R':
                $rules = array_merge($rules, [
                    'renewal_form_duration'        => 'required|numeric|min:1',
                    'renewal_duration_on'          => 'required|date',
                    'fresh_form_duration'          => 'prohibited',
                    'fresh_form_duration_on'       => 'prohibited',
                ]);
                break;

            case 'L':
                $rules = array_merge($rules, [
                    'renewal_late_fee_duration'    => 'required|numeric|min:1',
                    'renewal_late_fee_duration_on' => 'required|date',
                ]);
                break;

            case 'A':
                $rules = array_merge($rules, [
                    'enableRenewal'    => 'required|numeric|min:1',
                    'enableRenewalStarts' => 'required|date',
                ]);
                break;
        }

        $messages = [
            'cert_id.required'          => 'Please choose the certificate / licence.',
            'form_type.required'        => 'Please choose the form type.',
            'fresh_form_duration.required'          => 'Please enter the fresh form duration.',
            'fresh_form_duration_on.required'       => 'Please select the fresh form start date (As on).',
            'renewal_form_duration.required'        => 'Please enter the renewal form duration.',
            'renewal_duration_on.required'          => 'Please select the renewal start date (As on).',
            'renewal_late_fee_duration.required'    => 'Please enter the late fee duration.',
            'renewal_late_fee_duration_on.required' => 'Please select the late fee start date (As on).',
            'enableRenewal.required' => 'enter the renewal enable period.',
            'enableRenewalStarts.required' => 'Please select the renewal enable start date.',
        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {
            
            $validity = null;
            $validityStartDate = null;


            if ($formType === 'N') {
                $validity = $request->fresh_form_duration;
                $validityStartDate = $request->fresh_form_duration_on;
            } elseif ($formType === 'R') {
                $validity = $request->renewal_form_duration;
                $validityStartDate = $request->renewal_duration_on;
            } elseif ($formType === 'L') {
                $validity = $request->renewal_late_fee_duration;
                $validityStartDate = $request->renewal_late_fee_duration_on;
            } elseif ($formType === 'A'){
                $validity = $request->enableRenewal;
                $validityStartDate = $request->enableRenewalStarts;
            }

            // var_dump($validityStartDate);die;

            $existing = FeesValidity::where('licence_id', $request->cert_id)
                ->where('form_type', $formType)
                ->orderByDesc('id')
                ->first();


            
           if ($existing && 
                $existing->validity == $validity && 
                $existing->validity_start_date == $validityStartDate) {

                DB::rollBack();
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'Validity already exists with same duration and start date.',
                ]);
            }
            else{
                FeesValidity::create([
                    'licence_id'        => $request->cert_id,
                    'form_type'         => $formType,
                    'validity'          => $validity,
                    'validity_start_date' => $validityStartDate,
                    'status'            => $request->form_status ?? 1,
                    'created_by'        => $this->userId,
                    'created_at'        => now(),
                    'ipaddress'       => $request->ip(),
                ]);

                DB::commit();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Validity details added successfully!',
                ]);
            
            }



            

            // 🆕 Case 3: Data changed → insert new record (ignore old)
            // FeesValidity::create([
            //     'licence_id'        => $request->cert_id,
            //     'form_type'         => $formType,
            //     'validity'          => $validity,
            //     'vadity_start_date' => $validityStartDate,
            //     'status'            => $request->form_status ?? 1,
            //     'created_by'        => $this->userId,
            //     'created_at'        => now(),
            //     'ipaddress'       => $request->ip(),
            // ]);

            // DB::commit();

            // return response()->json([
            //     'status'  => 'success',
            //     'message' => strtoupper($formType) . ' validity updated successfully!',
            // ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong. ' . $e->getMessage(),
            ], 500);
        }
    }

    // public function updateValidity(Request $request)
    // {

    //     $formType = $request->input('form_type');
    //     $recordId = $request->input('form_id');

    //     $rules = [
    //         'cert_id' => 'required|integer',
    //         'form_type'  => 'required|in:N,R,L',
    //         'form_status'=> 'nullable|in:1,0,true,false,on',
    //     ];

    //     $nullable = [
    //         'fresh_form_duration'                => 'nullable|numeric|min:1',
    //         'fresh_form_duration_on'             => 'nullable|date',
    //         'renewal_form_duration'              => 'nullable|numeric|min:1',
    //         'renewal_duration_on'                => 'nullable|date',
    //         'renewal_late_fee_duration'          => 'nullable|numeric|min:1',
    //         'renewal_late_fee_duration_on'       => 'nullable|date',
    //     ];

    //     $rules = array_merge($rules, $nullable);

    //     // var_dump($formType);die;

    //     switch ($formType) {
    //         case 'N': // New Form
    //             $rules = array_merge($rules, [
    //                 'fresh_form_duration' => 'required|numeric|min:1',
    //                 'fresh_form_duration_on' => 'required|date',
    //                 'renewal_form_duration'              => 'prohibited',
    //                 'renewal_duration_on'                => 'prohibited',
    //                 'renewal_late_fee_duration'          => 'prohibited',
    //                 'renewal_late_fee_duration_on'       => 'prohibited',
    //             ]);
    //             break;

    //         case 'R': // Renewal
    //             $rules = array_merge($rules, [
    //                 'renewal_form_duration' => 'required|numeric|min:1',
    //                 'renewal_duration_on' => 'required|date',
    //                 'fresh_form_duration'         => 'prohibited',
    //                 'fresh_form_duration_on'      => 'prohibited',
    //             ]);
    //             break;

    //         case 'L': // Renewal
    //             $rules = array_merge($rules, [
    //                 'renewal_late_fee_duration' => 'required|numeric|min:1',
    //                 'renewal_late_fee_duration_on' => 'required|date',
    //             ]);
    //             break;

                
    //     }

                
    //     $messages = [
    //         'cert_id.required'          => 'Please choose the certificate / licence.',
    //         'form_type.required'          => 'Please choose the form type.',
    //         'form_status.required'          => 'Please choose the form status.',

    //         'fresh_form_duration.required'          => 'Please enter the fresh form duration.',
    //         'fresh_form_duration_on.required'       => 'Please select the fresh form start date (As on).',

    //         'renewal_form_duration.required'        => 'Please enter the renewal form duration.',
    //         'renewal_duration_on.required'          => 'Please select the renewal start date (As on).',

    //         'renewal_late_fee_duration.required'    => 'Please enter the late fee duration.',
    //         'renewal_late_fee_duration_on.required' => 'Please select the late fee start date (As on).',

    //         'renewal_*.*.prohibited'                => 'Renewal fields are not allowed for New Form.',
    //         'fresh_*.*.prohibited'                  => 'Fresh fields are not allowed for Renewal Form.',
    //     ];

    //     $request->validate($rules, $messages);

    //     DB::beginTransaction(); 
        
    //     try {

    //         $data = [
    //             'licence_id' => $request->cert_id,
    //             'form_type' => $formType,
    //             'created_by' => $this->userId,
    //             'created_at' => now(),
    //         ];

    //          if ($formType === 'N') {
    //             $data['validity'] = $request->fresh_form_duration;
    //             $data['vadity_start_date'] = $request->fresh_form_duration_on;
    //         } elseif ($formType === 'R') {
    //             $data['validity'] = $request->renewal_form_duration;
    //             $data['vadity_start_date'] = $request->renewal_duration_on;
    //         } elseif ($formType === 'L') {
    //             $data['validity'] = $request->renewal_late_fee_duration;
    //             $data['vadity_start_date'] = $request->renewal_late_fee_duration_on;
    //         }

    //         if ($recordId) {
    //             // Edit mode
    //             $form = FeesValidity::findOrFail($recordId);
    //             $form->update($data);
    //             $message = 'Form updated successfully!';
    //         } else {
    //             // Add mode
    //             $data['created_by'] = $this->userId;
    //             $data['created_at'] = now();
    //             FeesValidity::create($data);
    //             $message = 'Form created successfully!';
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => $message,
    //         ]);

    //      } catch (Exception $e) {
    //         DB::rollBack(); 

    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Something went wrong. ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {

        // dd($request->all());
        // exit;
        try {
            $validator = Validator::make($request->all(), [
                'cert_name' => 'required|integer',
                'fees_type' => 'required|in:N,R,L',
                'fresh_fees'          => 'nullable|numeric|min:0',
                'fresh_fees_on'       => 'nullable|date',
                'renewal_fees'        => 'nullable|numeric|min:0',
                'renewal_fees_as_on'  => 'nullable|date',
                'late_fees'           => 'nullable|numeric|min:0',
                'late_fees_on'        => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ]);
            }

            $type = trim($request->fees_type);
            $feeAmount = null;
            $startDate = null;

            // Determine amount and start date based on fees_type
            switch ($type) {
                case 'N':
                    $feeAmount = $request->fresh_fees;
                    $startDate = $request->fresh_fees_on;
                    break;

                case 'R':
                    $feeAmount = $request->renewal_fees;
                    $startDate = $request->renewal_fees_as_on;
                    break;

                case 'L':
                    $feeAmount = $request->late_fees;
                    $startDate = $request->late_fees_on;
                    break;
            }

            if ($request->cert_name) {
                // Check only within the same fees_type
                $existingFee = TnelbFee::where('cert_licence_id', $request->cert_name)
                    ->where('fees_type', $type)
                    ->orderByDesc('id')
                    ->first();


                // 🟢 Case 1: No record for this type → insert new
                if (!$existingFee) {
                    TnelbFee::create([
                        'cert_licence_id' => $request->cert_name,
                        'fees_type'       => $type,
                        'fees'            => $feeAmount,
                        'start_date'      => $startDate,
                        'end_date'        => null,
                        'fees_status'     => $request->form_status ?? 1,
                        'created_by'      => Auth::id(),
                        'created_at'      => now(),
                        'ipaddress'       => $request->ip(),
                    ]);

                    return response()->json([
                        'status'  => 'success',
                        'message' => "New fees details added successfully!",
                        'code'    => 'new_record'
                    ]);
                }

                // var_dump($existingFee->fees == $feeAmount &&
                // $existingFee->start_date == $startDate);die;

                // ⚠️ Case 2: Same type exists with same fee and start date → skip
                if (
                    $existingFee->fees == $feeAmount &&
                    $existingFee->start_date == $startDate
                ) {
                    return response()->json([
                        'status'  => 'warning',
                        'message' => 'Fees already exists with same amount and date.',
                        'code'    => 'no_change'
                    ]);
                }

                // 🆕 Case 3: Same type but fee or date changed → insert new (ignore old)
                TnelbFee::create([
                    'cert_licence_id' => $request->cert_name,
                    'fees_type'       => $type,
                    'fees'            => $feeAmount,
                    'start_date'      => $startDate,
                    'end_date'        => null,
                    'fees_status'     => $request->form_status ?? 1,
                    'created_by'      => Auth::id(),
                    'created_at'      => now(),
                    'ipaddress'       => $request->ip(),
                ]);

                return response()->json([
                    'status'  => 'success',
                    'message' => "fees details added successfully!",
                    'code'    => 'updated_record'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code'    => 'exception'
            ]);
        }
    }

    // public function store(Request $request)
    // {   
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'cert_name' => 'required|integer',
    //             'fees_type' => 'required|in:N,R,L',

    //             // Type-specific
    //             'fresh_fees'            => 'nullable|numeric|min:0',
    //             'fresh_fees_on'         => 'nullable|date',
    //             'renewal_fees'          => 'nullable|numeric|min:0',
    //             'renewal_fees_as_on'    => 'nullable|date',
    //             'latefee_for_renewal'   => 'nullable|numeric|min:0',
    //             'late_renewal_fees_on'  => 'nullable|date',
    //             'late_fees'             => 'nullable|numeric|min:0',
    //             'late_fees_on'          => 'nullable|date',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => $validator->errors()->first(),
    //             ]);
    //         }

    //         $type = trim($request->fees_type);
    //         $feeAmount = null;

    //         if ($type === 'N') {
    //             $feeAmount = $request->fresh_fees;
    //             $startDate = $request->fresh_fees_on;
    //         } elseif ($type === 'R') {
    //             $feeAmount = $request->renewal_fees;
    //             $startDate = $request->renewal_fees_as_on;
    //         } elseif ($type === 'L') {
    //             $feeAmount = $request->late_fees;
    //             $startDate = $request->late_fees_on;
    //         }

    //         $form_type = trim($type);

    //         if($request->cert_name){
    //             $get_form = TnelbFee::where('cert_licence_id', $request->cert_name)->first();
                
    //             if (!$get_form) {

    //                 $insert = TnelbFee::create([
    //                     'cert_licence_id' => $request->cert_name,
    //                     'fees_type'       => trim($type),
    //                     'fees'            => $feeAmount,
    //                     'start_date'      => $startDate,
    //                     'end_date'        => null, // can add later
    //                     'fees_status'     => $request->form_status ?? 1,
    //                     'created_by'      => Auth::id(),
    //                     // 'updated_by'      => Auth::id(),
    //                     'created_at'      => now(),
    //                     'ipaddress'       => $request->ip(),
    //                 ]);

    //                 if ($insert) {
    //                     return response()->json([
    //                         'status' => 'success',
    //                         'message' => 'Fees details added successfully!',
    //                     ]);
                        
    //                 }else{
    //                     return response()->json([
    //                         'status' => 'error',
    //                         'message' => 'Fees not updated!....',
    //                     ]);
    //                 }

    //             } else {
    //                 $get_form->fees_type = $type;
    //                 $get_form->start_date = $startDate;
    //                 $get_form->fees = $feeAmount;
    //             }

    //         }
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Something went wrong: ' . $e->getMessage(),
    //         ]);
    //     }
    // }

     public function update(Request $request, $id)
    {
        try {
            $fee = TnelbFee::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'cert_name' => 'required|integer',
                'fees_type' => 'required|in:N,R,L',
                'fresh_fees' => 'nullable|numeric|min:0',
                'fresh_fees_on' => 'nullable|date',
                'renewal_fees' => 'nullable|numeric|min:0',
                'renewal_fees_as_on' => 'nullable|date',
                'latefee_for_renewal' => 'nullable|numeric|min:0',
                'late_renewal_fees_on' => 'nullable|date',
                'late_fees' => 'nullable|numeric|min:0',
                'late_fees_on' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ]);
            }

            $type = $request->fees_type;
            $feeAmount = null;
            $startDate = null;

            if ($type === 'N') {
                $feeAmount = $request->fresh_fees;
                $startDate = $request->fresh_fees_on;
            } elseif ($type === 'R') {
                $feeAmount = $request->renewal_fees;
                $startDate = $request->renewal_fees_as_on;
            } elseif ($type === 'L') {
                $feeAmount = $request->late_fees;
                $startDate = $request->late_fees_on;
            }

            // ✅ Update record
            $fee->update([
                'cert_licence_id' => $request->cert_name,
                'fees_type'       => $type,
                'fees'            => $feeAmount,
                'start_date'      => $startDate,
                'end_date'        => null,
                'fees_status'     => $request->form_status ?? 1,
                'updated_by'      => Auth::id(),
                'updated_at'      => now(),
                'ipaddress'       => $request->ip(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Fees details updated successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating: ' . $e->getMessage(),
            ]);
        }
    }

    public function updateInstruct(Request $request){
        
        
        try {
            
            $request->validate([
                'rec_id' => 'required|integer|exists:mst_licences,id',
                'instructionData' => 'required|string',
            ]);
            
            // Validate incoming request
            // Find record
            $licence = MstLicence::findOrFail($request->rec_id);
            
            // Save delta JSON directly into ONE field
            $licence->instructions = $request->instructionData;

            // dd($licence->instructions);
            $licence->save();
            
            
            // 4️⃣ Return success response
            return response()->json([
                'status'  => 200,
                'message' => 'Instruction updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            
            // Return detailed error for debugging
            return response()->json([
                'status'  => 500,
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], 500);
        }
        
    }

    public function getInstruction(Request $request)
    {
        try {


            $request->validate([
                'licence_id' => 'required|integer|exists:mst_licences,id',
            ]);

            // FIXED: Use licence_id, not rec_id
            $licence = MstLicence::where('id',$request->licence_id)->first();


            return response()->json([
                'status' => 200,
                'data'   => $licence->instructions ?? null
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => 500,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    public function getFormInstruction(Request $request)
    {
        try {

            
            $request->validate([
                'appl_type' => 'required|string|in:N,R',
                'licence_code' => 'required|string',
            ]);

            // FIXED: Use licence_id, not rec_id

            // var_dump($request->licence_code);die;
            
            $licence = MstLicence::where('cert_licence_code', $request->licence_code)
            ->select('instructions')
            ->first();

            // dd($licence);
            // exit;

            return response()->json([
                'status' => 200,
                'data'   => $licence->instructions ?? null
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => 500,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

        




    

}
