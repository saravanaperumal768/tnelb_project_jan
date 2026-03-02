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

    public function uploadownershipdeed_ch(Request $request)
    {

        // -------------------------
        // DYNAMIC FILE FIELD
        // -------------------------
        $fileField = $request->document_category;



        // For array input like qual_proof[]
        if (str_ends_with($fileField, '[]')) {
            $fileField = rtrim($fileField, '[]');
        }
        //  dd($fileField);
        //         exit;
        // -------------------------
        // VALIDATION
        // -------------------------
        $request->validate([
            // $fileField          => 'required|file|mimes:pdf|max:250',
            'module'            => 'required',
            'document_category' => 'required',
            'document_sub_category' => 'required',
            'license_name'      => 'required',
            'form_name'         => 'required',
            'ownership_type'    => 'required',
        ]);

        try {
            $file = $request->file($fileField);

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
            // PATH HANDLING
            // -------------------------
            $dbFilePath = DocPathController::getPath($request);
            $folderPath = public_path($dbFilePath);

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            // -------------------------
            // FILE NAME
            // -------------------------
            $date = Carbon::now()->format('Y_m_d');
            $random = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

            $fileName = $date . '_' . $loginId . '_' . $random . '_' .
                strtoupper($request->document_category) . '.pdf';

            // dd( $folderPath);
            // exit;

            $file->move($folderPath, $fileName);

            // -------------------------
            // INSERT TEMP RECORD
            // -------------------------
            DB::table('tnelb_temp_uploaded_documents')->insert([
                'login_id'              => $loginId,
                'application_id'        => $applicationId,
                'form_name'             => $request->form_name,
                'license_name'          => $request->license_name,
                'module'                => $request->module,
                'ownership_type'        => $request->ownership_type,
                'document_category'     => $request->document_category,
                'document_sub_category' => $request->document_sub_category,
                'file_name'             => $fileName,
                'file_path'             => $dbFilePath,
                'uploaded_at'           => DB::raw('NOW()'),
                'is_final'              => '0',
                'created_at'            => DB::raw('NOW()'),
                'updated_at'            => DB::raw('NOW()'),
            ]);

            return response()->json([
                'status'    => 'success',
                'file_url'  => asset($dbFilePath . $fileName),
                'file_name' => $fileName,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Upload failed. Please try again.'
            ], 500);
        }
    }


    public function uploadownershipdeed(Request $request)
    {

    // dd($request->all());
    // exit;
        try {


        

            // --------------------------------------------------
            // 1. CHECK FILE EXISTENCE
            // --------------------------------------------------
            if (count($request->files->all()) === 0) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'No file received'
                ], 422);
            }

            $fileInputs = $request->files->all();
            $fileField  = array_key_first($fileInputs);
            $fileValue  = $fileInputs[$fileField];

            // --------------------------------------------------
            // 2. VALIDATION
            // --------------------------------------------------
            $rules = [
                'module'            => 'required',
                'document_category' => 'required',
                'license_name'      => 'required',
                'form_name'         => 'required',
            ];

            if (is_array($fileValue)) {
                $rules[$fileField] = 'required|array';
                $rules[$fileField . '.*'] = 'required|file|mimes:pdf|max:250';
            } else {
                $rules[$fileField] = 'required|file|mimes:pdf|max:250';
            }

            $request->validate($rules);

            // --------------------------------------------------
            // 3. NORMALIZE FILES
            // --------------------------------------------------
            $files = is_array($fileValue) ? $fileValue : [$fileValue];

            // --------------------------------------------------
            // 4. SESSION APPLICATION ID
            // --------------------------------------------------
            if (!session()->has('application_id')) {
                $applicationId = 'APP_' . $request->license_name . date('dmY');
                session(['application_id' => $applicationId]);
            } else {
                $applicationId = session('application_id');
            }

            $loginId = auth()->user()->login_id;

            // --------------------------------------------------
            // 5. FILE PATH
            // --------------------------------------------------
            $dbFilePath_all = DocPathController::getPath($request);

            $dbFilePath = $dbFilePath_all->filepath_temp;

            $dbFilePath_modulecode = $dbFilePath_all->module_code;

            // dd($dbFilePath_modulecode);
            // exit;

            // dd($dbFilePath);exit;
            $folderPath = public_path($dbFilePath);

            if (!\File::exists($folderPath)) {
                \File::makeDirectory($folderPath, 0755, true);
            }

            $uploadedFiles = [];

            // --------------------------------------------------
            // 6. LOOP FILES
            // --------------------------------------------------
            $counter = 1;
            foreach ($files as $file) {

             $originalName = $file->getClientOriginalName();


                // ----------------------------------------------
                // CHECK EXISTING RECORD
                // ----------------------------------------------
                // $existing = DB::table('tnelb_temp_uploaded_documents')
                //     ->where('login_id', $loginId)
                //     ->where('application_id', $applicationId)
                //     ->where('module', $request->module)
                //     ->where('form_name', $request->form_name)
                //     ->where('document_category', $request->document_category)
                //     ->first();

                // dd($request->document_category);
                // exit;
                $existingQuery = DB::table('tnelb_temp_uploaded_documents')
                    ->where('login_id', $loginId)
                    ->where('application_id', $applicationId)
                    ->where('module', $request->module)
                    ->where('form_name', $request->form_name)
                    ->where('document_category', $request->document_category);

                 if ($request->document_sub_category === 'OED') {
                    $existingQuery->where('document_sub_category', 'OED')
                                ->where('ownership_type', $request->ownership_type)
                                ->where('row_index', $request->row_index);
                }

                if ($request->document_sub_category === 'ED') {
                    $existingQuery->where('document_sub_category', 'ED')
                                ->where('file_name', 'like', '%' . $request->equip_code . '.pdf');
                }

                 if ($request->document_sub_category === 'OHD') {
                    $existingQuery->where('ownership_type', $request->ownership_type);
                                
                }

                $existing = $existingQuery->first();


                // dd($existing);
                // exit;



                if ($existing) {

                    // ------------------------------------------
                    // UPDATE FLOW
                    // ------------------------------------------
                    $fileName = $existing->file_name;

                    // DELETE OLD FILE
                    $oldFile = public_path($existing->file_path . $fileName);
                    if (\File::exists($oldFile)) {
                        \File::delete($oldFile);
                    }

                    // MOVE NEW FILE (SAME NAME)
                    $file->move($folderPath, $fileName);

                    DB::table('tnelb_temp_uploaded_documents')
                        ->where('id', $existing->id)
                        ->update([
                            'ownership_type'        => $request->ownership_type,
                            'document_sub_category' => $request->document_sub_category,
                            'original_pdfname'      => $originalName,
                            'file_path'             => $dbFilePath,
                            
                            'uploaded_at'           => now(),
                            'updated_at'            => now(),
                        ]);
                } else {

                    // ------------------------------------------
                    // INSERT FLOW
                    // ------------------------------------------


                    $date   = now()->format('Ymd');
                    $time = now()->timezone('Asia/Kolkata')->format('Hi');

                    $form_code = $request->form_code;

                    $equip_code = $request->equip_code;

                    // dd($equip_code);
                    // exit;

                    // dd($time);
                    // exit;
                     $moduleCode = strtoupper($dbFilePath_modulecode);

                    
                    $random = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
                    // ---------------------------------
                    // Filename Format
                    // yyyymmdd_time(11.30)login_id_L(license)_1_document_sub_category(OT).pdf
                    // Array()
                    // yyyymmdd_time(11.30)login_id_L(license)_1_document_sub_category(PT)1 .pdf
                    // ---------------------------------
                    // $fileName = $date . '_' .$time .'_' . $loginId . '_' . 'L' . $form_code .'_' .
                    //     strtoupper($dbFilePath_modulecode) . '.pdf';
//  dd($request->ownership_type);
//                                         exit;
                    if ($request->document_sub_category === 'OED') {

                            // $fileName = $date . '_' . $time . '_' . $loginId . '_' .
                            //             'L' . $form_code . '_' .$request->ownership_type.
                            //             $moduleCode . $counter . '.pdf';

                             $fileName = $date . '_' . $time . '_' . $loginId . '_' .
                                'L' . $form_code . '_' .
                                strtoupper($request->ownership_type).
                                $moduleCode.$request->row_index . '.pdf';

                           

                            // dd($fileName);exit;

                        } elseif($request->document_sub_category === 'OHD') {

                                       
                           // yyyymmdd_time(11.30)login_id_L(license)1_ownership_type_document_sub_category(OT).pdf
                            $fileName = $date . '_' . $time . '_' . $loginId . '_' .
                                        'L' . $form_code . '_' . $request->ownership_type . '_'.
                                        $moduleCode . '.pdf';

                            // dd($fileName);
                            // exit;

                        }
                        elseif($request->document_sub_category === 'ED') {

                            $fileName = $date . '_' . $time . '_' . $loginId . '_' .
                                        'L' . $form_code . '_' . $request->ownership_type . '_'.
                                        $moduleCode . $equip_code . '.pdf';
                        }                    
                        
                        else {

                            
                            $fileName = $date . '_' . $time . '_' . $loginId . '_' .
                                        'L' . $form_code . '_' .
                                        $moduleCode . '.pdf';
                        }

                    // dd($fileName);
                    // exit;
                    $equip_code = is_numeric($request->equip_code) ? $request->equip_code : null;

                    $file->move($folderPath, $fileName);

                    

                    DB::table('tnelb_temp_uploaded_documents')->insert([
                        'login_id'              => $loginId,
                        'application_id'        => $applicationId,
                        'form_name'             => $request->form_name,
                        'license_name'          => $request->license_name,
                        'module'                => $request->module,
                        'ownership_type'        => $request->ownership_type,
                        'document_category'     => $request->document_category,
                        'document_sub_category' => $request->document_sub_category,
                        'original_pdfname'      => $originalName,
                        'file_name'             => $fileName,
                        'file_path'             => $dbFilePath,
                        'ownership_count'       => $counter,

                       'row_index' =>            is_numeric($request->row_index) ? (int)$request->row_index : null,
                        
                        'equip_code'             => $equip_code,
                        'uploaded_at'           => now(),
                        'is_final'              => '0',
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);
                }

                $counter++;

                $uploadedFiles[] = [
                    'file_name' => $fileName,
                    'file_url'  => asset($dbFilePath .'/'. $fileName),
                ];
            }
             

            // --------------------------------------------------
            // 7. RESPONSE
            // --------------------------------------------------
            return response()->json([
                'status' => 'success',
                'files'  => $uploadedFiles
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {

           return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
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
            'file' => 'required|mimes:pdf|max:250'
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
