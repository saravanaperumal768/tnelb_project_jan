<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocPathController extends Controller
{
        public static function getPath(Request $request)
    {

    // dd($request->all());
    // exit;
        $paths = [
            'A' => [
                'ownership_type_doc' => 'upload_documents/EA/New_applications/ownership_doc/',

                'bank_solvency'    => 'upload_documents/EA/New_applications/bank_solvency/',
                'lease_agreement'  => 'upload_documents/EA/New_applications/lease_agreement/',
                'rental_agreement' => 'upload_documents/EA/New_applications/rental_agreement/',
            ],

            'B' => [
                'partnership_deed' => 'upload_documents/EA/Renewal/ownership_doc/',
            ]
        ];

        return $paths[$request->form_name][$request->module]
            ?? 'upload_documents/EA/New_applications/others/';
    }

}
