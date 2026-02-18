<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocPathController extends Controller
{
    public static function getPath(Request $request)
    {

        // dd($request->all());
        //    dd($request->module);

        //    exit;

        $filepath = DB::table('mst_filepath_cl_tbl')
            ->where('appl_type', $request->appl_type)
            ->where('form_module', $request->module)
            ->where('status', '1')

            ->first();

            // dd($filepath);
            // exit;

        if (!$filepath) {
            $filepath = '0';
        }

        // dd($filepath);
        // exit;
        return $filepath;
        // $paths = [
        //     'A' => [
        //         'ownership_type_doc' => 'upload_documents/EA/New_applications/ownership_doc/',
        //         'ownership_edu' => 'upload_documents/EA/New_applications/education_doc/',
        //         'banksolvency_doc'    => 'upload_documents/EA/New_applications/banksolvency_doc/',
        //         '8_11_attachments_doc'  => 'upload_documents/EA/New_applications/8_11_attachments_doc/',
        //         'gst_rental_doc' => 'upload_documents/EA/New_applications/gst_rental_doc/',
        //         'equip_doc' => 'upload_documents/EA/New_applications/equip_doc/',
        //     ],

        //     'B' => [
        //         'partnership_deed' => 'upload_documents/EA/Renewal/ownership_doc/',
        //     ]
        // ];

        // return $paths[$request->form_name][$request->module]
        //     ?? 'upload_documents/EA/New_applications/others/';
    }
}
