<?php

namespace App\Http\Controllers;

use App\Models\Tnelb_Temp_Tbl;
use Illuminate\Http\Request;
use Psy\Util\Str;


use Illuminate\Support\Facades\Storage;

use App\Models\TnelbTempUploadedDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
// use Intervention\Image\File;
use Symfony\Component\HttpFoundation\Session\Session;
// use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;


class DocumentUploadController extends Controller
{

    public function uploadownershipdeed(Request $request)
    {

        // dd($request->all());
        // exit;

        $request->validate([
            $request->document_category === 'director_mom'
                ? 'director_mom'
                : 'partnership_deed'
            => 'required|mimes:pdf|max:250',

            'module'           => 'required',
            'document_category' => 'required',
            'license_name'     => 'required',
            'form_name'     => 'required',
        ]);

        try {
            $file = $request->file($request->document_category);


            // -------------------------
            // SESSION APPLICATION ID
            // -------------------------
            if (!session()->has('application_id')) {
                $applicationId = 'APP_' . $request->license_name . date('dmY');
                session(['application_id' => $applicationId]);
            } else {
                $applicationId = session('application_id');
            }

            $loginId = auth()->user()->login_id;

            // -------------------------
            // FILE PATH & NAME
            // -------------------------
            // $folderPath = public_path('upload_documents/EA/New_applications/ownership_doc/');
            // $dbFilePath = 'upload_documents/EA/New_applications/ownership_doc/';

            $dbFilePath = DocPathController::getPath($request);
            $folderPath = public_path($dbFilePath);


            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            // -------------------------
            // CHECK EXISTING RECORD
            // -------------------------
            $existing = DB::table('tnelb_temp_uploaded_documents')
                ->where('login_id', $loginId)
                ->where('application_id', $applicationId)
                ->where('module', $request->module)
                ->where('form_name', $request->form_name)
                ->where('document_category', $request->document_category)
                ->first();



            // -------------------------
            // FILE NAME LOGIC
            // -------------------------
            if ($existing) {
                // KEEP SAME FILE NAME
                $fileName = $existing->file_name;

                // DELETE OLD FILE IF EXISTS
                $oldFile = public_path($existing->file_path . $fileName);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }

                // MOVE NEW FILE (REPLACE)
                $file->move($folderPath, $fileName);

                // UPDATE DB ONLY
                DB::table('tnelb_temp_uploaded_documents')
                    ->where('id', $existing->id)
                    ->update([
                        'ownership_type'        => $request->ownership_type,
                        'document_category'     => $request->document_category,
                        'document_sub_category' =>  $request->document_sub_category,
                        'file_path'   => $dbFilePath,
                        'uploaded_at' => DB::raw('NOW()'),
                        'updated_at'  => DB::raw('NOW()'),
                    ]);
            } else {

                // dd('new record');
                // exit;
                // CREATE NEW FILE NAME
                $date = Carbon::now()->format('Y_m_d');
                $random_num = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
                $fileName = $date  . '_' . $loginId . '_' . $random_num . '_' . strtoupper($request->document_category) . '.pdf';
                // dd($fileName);
                // exit;

                $file->move($folderPath, $fileName);

                // INSERT NEW RECORD
                DB::table('tnelb_temp_uploaded_documents')->insert([
                    'login_id'              => $loginId,
                    'application_id'        => $applicationId,
                    'form_name'             => $request->form_name,
                    'license_name'          => $request->license_name,
                    'module'                => $request->module,
                    'ownership_type'        => $request->ownership_type,
                    'document_category'     => $request->document_category,
                    'document_sub_category' =>  $request->document_sub_category,
                    'file_name'             => $fileName,
                    'file_path'             => $dbFilePath,
                    'uploaded_at'           => DB::raw('NOW()'),
                    'is_final'              => '0',
                    'created_at'            => DB::raw('NOW()'),
                    'updated_at'            => DB::raw('NOW()'),
                ]);
            }

            return response()->json([
                'status'    => 'success',
                'file_url'  => asset($dbFilePath . $fileName),
                'file_name' => $fileName,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Upload failed. Please try again.',
            ], 500);
        }
    }
    public function uploadownershipdeed_bk(Request $request)
    {
        //   dd($request->all());
        // exit;

        $form_name = $request->form_name;
        $license_name = $request->license_name;
        $request->validate([
            'partnership_deed' => 'required|mimes:pdf|max:250', // 250 KB
        ]);



        try {
            $file = $request->file('partnership_deed');

            if (!session()->has('application_id')) {
                $applicationId = 'APP_' . $license_name  . date('dmY');
                session(['application_id' => $applicationId]);
            } else {
                $applicationId = session('application_id');
            }


            $loginId          = auth()->user()->login_id;
            // $applicationId    = session('application_id');

            $documentCategory = 'PARTNERSHIP_DEED';

            $date = Carbon::now()->format('d_m_Y');
            $year = Carbon::now()->format('Y');

            $fileName = $loginId . '_' . $date . '_' . $documentCategory . '.pdf';

            // dd($fileName);exit;
            // $file_path = 'upload_documents/EA/New_applications/ownership_doc/';

            // $folderPath = public_path('upload_documents/EA/New_applications/ownership_doc/');

            $file_path = DocPathController::getPath($request);
            $folderPath = public_path($file_path);


            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $file->move($folderPath, $fileName);
            DB::table('tnelb_temp_uploaded_documents')->insert([
                'login_id'               => $loginId,
                'application_id'         => $applicationId,
                'module'                 => $request->module,
                'ownership_type'         => 'pt',
                'document_category'      => $request->document_category,
                'document_sub_category'  => 'DEED_doc',
                'file_name'              => $fileName,
                'file_path'              => $file_path,

                // DB time (not PHP time)
                'uploaded_at'            => DB::raw('NOW()'),
                'is_final'               => '0',
                'created_at'             => DB::raw('NOW()'),
                'updated_at'             => DB::raw('NOW()'),
            ]);


            // $doc = Tnelb_Temp_Tbl::create([
            //     'login_id'               => auth()->id(),
            //     'application_id'         => $request->application_id ?? null,
            //     'module'                 => 'ownership_doc',
            //     'ownership_type'         => 'pt',
            //     'document_category'      => 'Ownership',
            //     'document_sub_category'  => 'Partnership Deed',
            //     'file_name'              => $fileName,
            //     'file_path'              => $filePath,
            //     'uploaded_at'            => now(),
            //     'is_final'               => 'N',
            //     'moved_as'               => null,
            // ]);

            return response()->json([
                'status' => 'success',
                'file_url' => asset($file_path . $fileName),
                'file_name' => $fileName,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Upload failed. Please try again.',
            ], 500);
        }
    }
}
