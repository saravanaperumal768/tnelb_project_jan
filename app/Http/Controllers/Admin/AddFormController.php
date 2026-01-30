<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\TnelbForms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class AddFormController extends Controller
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
    public function addnewform()
    {
        $forms = TnelbForms::where('status', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admincms.newform.index', compact('forms'));
    }

    public function newforminsert(Request $request)
    {

        $request->validate([
            'form_name' => 'required|string',
            'license_name' => 'required|string',
            'fresh_amount' => 'required|numeric',
            'freshamount_starts' => 'required|date',
            'freshamount_ends' => 'nullable|date',
            'renewal_amount' => 'required|numeric',
            'renewalamount_starts' => 'required|date',
            'renewalamount_ends' => 'nullable|date',
            'latefee_amount' => 'required|numeric',
            'latefee_starts' => 'required|date',
            'latefee_ends' => 'nullable|date',
            'duration_freshfee' => 'required|string',
            'duration_renewalfee' => 'required|string',
            'duration_latefee' => 'required|string',
            'status' => 'required',
        ]);

   

        $form = TnelbForms::create([
            'form_name' => $request->form_name,
            'license_name' => $request->license_name,
            'fresh_amount' => $request->fresh_amount,
            'freshamount_starts' => $request->freshamount_starts,
            'freshamount_ends' => $request->freshamount_ends,
            'renewal_amount' => $request->renewal_amount,
            'renewalamount_starts' => $request->renewalamount_starts,
            'renewalamount_ends' => $request->renewalamount_ends,
            'latefee_amount' => $request->latefee_amount,
            'latefee_starts' => $request->latefee_starts,
            'latefee_ends' => $request->latefee_ends,
            'duration_freshfee' => $request->duration_freshfee,
            'duration_renewalfee' => $request->duration_renewalfee,
            'duration_latefee' => $request->duration_latefee,
            'status' => $request->status,
            'created_by' => $this->updatedBy,
            'updated_by' => $this->updatedBy,
        ]);

        return response()->json(['status' => 'success', 'form' => $form]);
    }


    public function form_instructions($id)
    {
        $forms = TnelbForms::findOrFail($id);


        return view('admincms.newform.formboardcontent', compact('forms'));
    }

    // -----------------------------------
    public function updateforminstructions(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tnelb_forms,id',
            'instructions' => 'nullable|string',

        ]);

        $forms = TnelbForms::findOrFail($request->id);

        if ($request->has('instructions')) {
            $forms->instructions = $request->instructions;
        }


        $forms->updated_by = $this->updatedBy;
        $forms->save();

        return response()->json([
            'success' => true,
            'message' => 'Form Instruction updated successfully!',
            'data' => $forms
        ]);
    }

    // ------------------------Edit form Details-----------------

       // ------------------------Edit form Details-----------------

    public function updateform(Request $request)
{
    // Step 1: Validate inputs
    $request->validate([
        'id' => 'required|integer|exists:tnelb_forms,id',
        'form_name' => 'required|string',
        'license_name' => 'required|string',
        // 'fresh_amount' => 'required|numeric',
        // 'renewal_amount' => 'required|numeric',
        // 'latefee_amount' => 'required|numeric',
        // 'status' => 'required|in:0,1,2',
        // 'freshamount_starts' => 'required|date',
        // 'renewalamount_starts' => 'required|date',
        // 'latefee_starts' => 'required|date',
        // 'duration_freshfee' => 'required',
        // 'duration_renewalfee' => 'required',
        // 'duration_latefee' => 'required',
        // 'fresh_period' => 'required',
        // 'renewal_period' => 'required',
    ]);

    
    $oldForm = TnelbForms::findOrFail($request->id);

    
    $onlyAmountChanged =
        ($request->fresh_amount != $oldForm->fresh_amount ||
         $request->renewal_amount != $oldForm->renewal_amount) &&
        (
            $request->freshamount_starts == $oldForm->freshamount_starts &&
            $request->renewalamount_starts == $oldForm->renewalamount_starts &&
            $request->latefee_starts == $oldForm->latefee_starts &&
            $request->duration_freshfee == $oldForm->duration_freshfee &&
            $request->duration_renewalfee == $oldForm->duration_renewalfee &&
            $request->duration_latefee == $oldForm->duration_latefee &&
            $request->fresh_period == $oldForm->fresh_period &&
            $request->renewal_period == $oldForm->renewal_period
        );

    // ------------------------------
    // Case 1: Only update amounts
    // ------------------------------
    if ($onlyAmountChanged) {
        $oldForm->update([
            'fresh_amount'   => $request->fresh_amount,
            'renewal_amount' => $request->renewal_amount,
            'latefee_amount' => $request->latefee_amount,
            'status'         => $request->status,
            'updated_by'     => auth()->user()->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Form updated with new amounts',
            'form' => $oldForm
        ]);
    }

    // ------------------------------
    // Case 2: Dates/period changed → Create new form
    // ------------------------------
    else {
        // Inactivate old form
        $today = now()->format('Y-m-d');
        $oldForm->update([
            'status'             => 0,
            'updated_by'         => auth()->user()->name,
            'freshamount_ends'   => $today,
            'renewalamount_ends' => $today,
            'latefee_ends'       => $today,
        ]);

        // Create new form with old_id reference
        $newForm = TnelbForms::create([
            'form_name'           => $request->form_name,
            'license_name'        => $request->license_name,
            'fresh_amount'        => $request->fresh_amount,
            'renewal_amount'      => $request->renewal_amount,
            'latefee_amount'      => $request->latefee_amount,
            'freshamount_starts'  => $request->freshamount_starts,
            'freshamount_ends'    => $request->freshamount_ends ?? null,
            'renewalamount_starts'=> $request->renewalamount_starts,
            'renewalamount_ends'  => $request->renewalamount_ends ?? null,
            'latefee_starts'      => $request->latefee_starts,
            'latefee_ends'        => $request->latefee_ends ?? null,
            'duration_freshfee'   => $request->duration_freshfee,
            'duration_renewalfee' => $request->duration_renewalfee,
            'duration_latefee'    => $request->duration_latefee,
            'status'              => $request->status,
            'created_by'          => auth()->user()->name,
            'updated_by'          => auth()->user()->name,
            'old_id'              => $oldForm->id,
            'Assigned'            => $oldForm->Assigned ?? null,
            'fresh_period'        => $request->fresh_period,
            'renewal_period'      => $request->renewal_period,
            'instructions'        => $oldForm->instructions,
            'instruction_renewal' => $oldForm->instruction_renewal,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'New form created due to date/period change',
            'form' => $newForm
        ]);
    }
}

    // -----------------------------

    public function form_history($formid)
    {

        if(!$formid){
              abort(403, 'No form ID provided');
        }
        $currentForm = TnelbForms::findOrFail($formid);
        $formhistory = TnelbForms::where('old_id', $formid)
            ->orWhere('id', $formid)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admincms.newform.form_history', [
            'formhistory' => $formhistory,
            'currentFormId' => $currentForm->id
        ]);
    }
}
