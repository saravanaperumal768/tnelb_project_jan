<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mst_Form_s_w;
use App\Models\Mst_education;
use App\Models\Mst_experience;
use App\Models\Mst_documents;
use App\Models\MstLicence;
use App\Models\TnelbApplicantPhoto;
use App\Models\TnelbAppsInstitute;
use App\Models\TnelbFormP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

class LicensepdfController extends Controller
{

    public function getLicenceDoc($application_id)
    {
        // Fetch application details
        $application = DB::table('tnelb_application_tbl')
        ->where('application_id', $application_id)
        ->first();

        

        if ($application && $application->appl_type === 'R') {
            // Renewal application → use tnelb_renewal_license
            $applicant = DB::table('tnelb_application_tbl')
                ->join('tnelb_renewal_license', 'tnelb_renewal_license.application_id', '=', 'tnelb_application_tbl.application_id')
                ->where('tnelb_application_tbl.application_id', $application_id)
                ->select(
                    'tnelb_application_tbl.application_id',
                    'tnelb_application_tbl.applicant_name AS name',
                    'tnelb_application_tbl.fathers_name',
                    'tnelb_application_tbl.applicants_address',
                    'tnelb_application_tbl.d_o_b',
                    'tnelb_application_tbl.age',
                    'tnelb_application_tbl.license_name',
                    'tnelb_application_tbl.form_name',
                    'tnelb_renewal_license.license_number',
                    'tnelb_renewal_license.issued_by',
                    'tnelb_renewal_license.issued_at',
                    'tnelb_renewal_license.expires_at'
                )
                ->first();
        } else {
            // New application → use tnelb_license
            $applicant = DB::table('tnelb_application_tbl')
                ->join('tnelb_license', 'tnelb_license.application_id', '=', 'tnelb_application_tbl.application_id')
                ->where('tnelb_application_tbl.application_id', $application_id)
                ->select(
                    'tnelb_application_tbl.application_id',
                    'tnelb_application_tbl.applicant_name AS name',
                    'tnelb_application_tbl.fathers_name',
                    'tnelb_application_tbl.applicants_address',
                    'tnelb_application_tbl.d_o_b',
                    'tnelb_application_tbl.age',
                    'tnelb_application_tbl.license_name',
                    'tnelb_application_tbl.form_name',
                    'tnelb_license.license_number',
                    'tnelb_license.issued_by',
                    'tnelb_license.issued_at',
                    'tnelb_license.expires_at'
                )
                ->first();
        }
    
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }
    
        // Fetch Payment Details
        $payment = DB::table('payments')->where('application_id', $application_id)->first();
    
        // Initialize mPDF
        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        
        $mpdf->WriteHTML('<style>
        body { line-height: 1.5; }
        p, td, th { padding: 5px; }
        .tbl_center { text-align: center; }
        .mt-2 { margin-top: 10px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; }
        .highlight { font-weight: bold; color: black; background-color: #ddbe12; padding: 5px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        // Start building the PDF content
        $html = '
        <h3 style="text-align: center;" class="">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align: center;" class="">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align: center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align: center;" class="">' . $applicant->form_name . ' License "' . $applicant->license_name . '"</h4>
        <p style="text-align: center;">License for Supervisor Competency Certificate</p>
        <h3 style="text-align: center;" class="">' . $applicant->license_number . '</h3>';
 

    
        $html .= '
        <h4 class="mt-2 "> License Summary</h4>
        <table>
            <tr><th class="highlight">Applicant ID</th><td>' . $applicant->application_id . '</td></tr>
            <tr><th class="highlight">Name</th><td>' . $applicant->name . '</td></tr>
            <tr><th class="highlight">License Name</th><td>' . $applicant->license_name . '</td></tr>
            <tr><th class="highlight">Issued By</th><td>' . $applicant->issued_by . '</td></tr>
            <tr><th class="highlight">Issued On</th><td>' . format_date($applicant->issued_at) . '</td></tr>
            <tr><th class="highlight">Expired On</th><td>' . format_date($applicant->expires_at) . '</td></tr>
        </table>';
    
        // Payment Details
        $html .= '<h4 class="mt-2 "> Payment Details</h4>
        <table class="tbl_center">
            <tr>
                <th class="highlight">Bank Name</th>
                <th class="highlight">Mode of Payment</th>
                <th class="highlight">Payment Date</th>
                <th class="highlight">Transaction ID</th>
            </tr>
            <tr>
                <td>State Bank of India</td>
                <td>UPI</td>
                <td>25-02-2025</td>
                <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
            </tr>
        </table>';
    
        // Declaration
        $html .= '
        <br>
        <p><strong>Place:</strong> Chennai</p>
        <p><strong>Date:</strong> ' . date('d-m-Y') . '</p>';
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
    
        // Output PDF
        return response($mpdf->Output('Application_Details.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

    
    public function generatePDF($application_id)
    {
        $application = DB::table('tnelb_application_tbl')
        ->where('application_id', $application_id)
        ->first();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $application_id)->first();
        if ($application && $application->appl_type === 'R') {
            $applicant = DB::table('tnelb_application_tbl')
            ->join('tnelb_renewal_license', 'tnelb_renewal_license.application_id', '=', 'tnelb_application_tbl.application_id')
            ->where('tnelb_application_tbl.application_id', $application_id)
            ->select(
                'tnelb_application_tbl.application_id',
                'tnelb_application_tbl.applicant_name AS name',
                'tnelb_application_tbl.fathers_name',
                'tnelb_application_tbl.applicants_address',
                'tnelb_application_tbl.d_o_b',
                'tnelb_application_tbl.age',
                'tnelb_application_tbl.license_name',
                'tnelb_application_tbl.form_name',
                'tnelb_renewal_license.license_number',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at'
            )
            ->first();
        } else {
            $applicant = DB::table('tnelb_application_tbl')
            ->join('tnelb_license', 'tnelb_license.application_id', '=', 'tnelb_application_tbl.application_id')
            ->where('tnelb_application_tbl.application_id', $application_id)
            ->select(
                'tnelb_application_tbl.application_id',
                'tnelb_application_tbl.applicant_name AS name',
                'tnelb_application_tbl.fathers_name',
                'tnelb_application_tbl.applicants_address',
                'tnelb_application_tbl.d_o_b',
                'tnelb_application_tbl.age',
                'tnelb_application_tbl.license_name',
                'tnelb_application_tbl.form_name',
                'tnelb_license.license_number',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at'
            )
            ->first();
        }
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }

        if($applicant->license_name == 'B'){
            $certificate_name = 'Electrician';
            $content_text = 'The holder of this certificate is authorized to carry out Medium and Low Voltage electrical installation works under a licensed contractor, or to perform operation and maintenance works of Medium and Low Voltage installations in the concerned establishment with due authorization.'; 
        }else if($applicant->license_name == 'H'){
             $certificate_name = 'WIREMAN HELPER';
            $content_text = 'The holder of this certificate may work as an assistant to an electrician under a licensed electrical contractor for carrying out Medium and Low Voltage electrical installation works, or may, with the authorization of the establishment, work as an assistant to an electrician in the operation and maintenance of Medium and Low Voltage installations of the establishment.'; 
        }else{
            $certificate_name = '';
            $content_text = 'This Certificate holder is permitted to supervise <strong>H.V and M.V. Electrical installation works</strong> under licensed contractor or to work as authorised person under rule 3 of Indian Electricity Rule 1956.';
        }


         $certificateRow = '';

        if (!empty($certificate_name)) {
            $certificateRow = '
                <tr>
                    <td class="lbl">Certificate</td>
                    <td class="colon">:</td>
                    <td class="val">'.$certificate_name.'</td>
                </tr>
            ';
        }

        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [80.80, 120.55],
            'orientation' => 'L',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
        ]);

        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);
        $mpdf->WriteHTML('<style>
            @page {
                size: 110.55mm 70.80mm;   /* CR100 landscape */
                margin: 0;
            }
            body {
                margin: 0;
                padding: 0;
                width: 120.55mm;
                height: 80.80mm;
                font-family: helvetica;
                overflow: hidden;
            }
            .card {
                width: 120.55mm;
                height: 80.80mm;
                border: 0.4mm solid #000;
                box-sizing: border-box;
            }
            .header {
                height: 11mm;
                color: #003366;
                text-align: center;
                font-size: 10.5pt;
                font-weight: bold;
                padding: 2mm;
                box-sizing: border-box;
            }
            .content {
                padding: 3mm;
                font-size: 7pt;
                box-sizing: border-box;
            }
            .photo {
                width: 22mm;
                height: 22mm;
                border: 0.3mm solid #000;
                box-sizing: border-box;
                overflow: hidden;
            }
           .info-table {
                font-size: 9pt;
                border-collapse: collapse;
            }

            .info-table td {
                padding: 1mm;
                vertical-align: top;
            }

            .info-table .lbl {
                width: 25mm;
                font-weight: bold;
            }

            .info-table .colon {
                width: 2mm;
                text-align: center;
            }
            .footer {
                margin-top: 5mm;   
                text-align: center;
                font-size: 6pt;
            }
            </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
                
        $photoPath = !empty($applicant_photo->upload_path) ? public_path($applicant_photo->upload_path): null;

        $qrValue = 'TNELB QR TESTING'; 

        $html = '
        <div class="card">

            <!-- HEADER -->
            <div class="header">
                TAMIL NADU ELECTRICAL LICENCING BOARD<br>
                Thiru Vi. Ka. Indl. Estate, Guindy, Chennai - 600 032.
            </div>

            <!-- BODY -->
            <div class="content">

               <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <!-- LEFT : DETAILS -->
                        <td width="70%" valign="top">

                            <table class="info-table">
                                <tr>
                                    <td class="lbl">C.No</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->license_number.'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">D.O.I</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.date('d M Y', strtotime($applicant->issued_at)).'</td>
                                </tr>
                                 <tr>
                                    <td class="lbl">Validity</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.format_date($applicant->issued_at). '<small style="font-weight: bold;"> To </small>'. format_date($applicant->expires_at).'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Name</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->name.'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">F/H Name</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->fathers_name.'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Date of Birth</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.date('d M Y', strtotime($applicant->d_o_b)).'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Address</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->applicants_address.'</td>
                                </tr>'
                                .$certificateRow.'
                            </table>

                        </td>

                        <!-- RIGHT : PHOTO -->
                        <td width="30%" valign="top">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <!-- PHOTO ROW -->
                                <tr>
                                    <td align="center">
                                        <div class="photo">
                                            '.($photoPath
                                                ? '<img src="'.$photoPath.'" style="width:22mm; height:22mm; object-fit:cover;">'
                                                : '').'
                                        </div>
                                    </td>
                                </tr>

                                <!-- SPACE BETWEEN PHOTO & QR -->
                                <tr>
                                    <td height="3mm"></td>
                                </tr>

                                <!-- QR ROW -->
                                <tr>
                                    <td align="center">
                                        <barcode code="'.$qrValue.'" type="QR" size="0.6" error="M" />
                                    </td>
                                </tr>

                                <!-- BOTTOM SAFE SPACE -->
                                <tr>
                                    <td height="4mm"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>

            <!-- FOOTER -->
            <div class="footer">
                Issued by TNELB | Tamil Nadu
            </div>

        </div>
        ';
    
        $mpdf->WriteHTML($html);
        $mpdf->AddPage('L');
        $backHtml = '
            <div class="card">

                <div class="content" style="font-size:9.5pt; line-height:1.4;">

                    <div style="text-align:right; font-size:7pt; margin-bottom:2mm;">
                        Visit us at : www.tnelb.gov.in
                    </div>

                    <div style="margin-top:4mm;text-align: justify;">
                        ' . $content_text . '   
                    </div>

                    <br><br><br><br>

                    <!-- SIGNATURE AREA -->
                    <table width="100%" style="margin-top:15mm;">
                        <tr>
                            <td width="45%" style="text-align:left;">
                                <div style="height:12mm;"></div>
                                <strong>Secretary</strong>
                            </td>

                            <td width="55%" style="text-align:right;">
                                <div style="height:12mm;"></div>
                                <strong>President</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>';
        $mpdf->WriteHTML($backHtml);
        return response($mpdf->Output('Application_Details.pdf', 'I'))->header('Content-Type', 'application/pdf');
    }

    public function generateLicenceTamil($application_id)
    {
        $application = DB::table('tnelb_application_tbl')
        ->where('application_id', $application_id)
        ->first();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $application_id)->first();
        if ($application && $application->appl_type === 'R') {
            $applicant = DB::table('tnelb_application_tbl')
            ->join('tnelb_renewal_license', 'tnelb_renewal_license.application_id', '=', 'tnelb_application_tbl.application_id')
            ->where('tnelb_application_tbl.application_id', $application_id)
            ->select(
                'tnelb_application_tbl.application_id',
                'tnelb_application_tbl.applicant_name AS name',
                'tnelb_application_tbl.fathers_name',
                'tnelb_application_tbl.applicants_address',
                'tnelb_application_tbl.d_o_b',
                'tnelb_application_tbl.age',
                'tnelb_application_tbl.license_name',
                'tnelb_application_tbl.form_name',
                'tnelb_renewal_license.license_number',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at'
            )
            ->first();
        } else {
            $applicant = DB::table('tnelb_application_tbl')
            ->join('tnelb_license', 'tnelb_license.application_id', '=', 'tnelb_application_tbl.application_id')
            ->where('tnelb_application_tbl.application_id', $application_id)
            ->select(
                'tnelb_application_tbl.application_id',
                'tnelb_application_tbl.applicant_name AS name',
                'tnelb_application_tbl.fathers_name',
                'tnelb_application_tbl.applicants_address',
                'tnelb_application_tbl.d_o_b',
                'tnelb_application_tbl.age',
                'tnelb_application_tbl.license_name',
                'tnelb_application_tbl.form_name',
                'tnelb_license.license_number',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at'
            )
            ->first();
        }
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }

        if($applicant->license_name == 'B'){
            $certificate_name = 'Electrician';
            $content_text = 'இச்சான்று பெற்றவர் நடுத்தர மற்றும் குறைந்த மின்னழுத்த மின்னமைப்பு பணிகளை உரிமம் பெற்றுரியின் ஒப்பந்தக்காரரின் கீழ் மேற்கொள்ளலாம் அல்லது நடுத்தர மற்றும் குறைந்த அழுத்த நிறுவனத்தின் இயக்குதல் மற்றும் பராமரிப்பு பணிகளை அந்நிறுவனத்தில் அங்கீகாரத்துடன் மேற்கொள்ளலாம்.'; 
        }else if($applicant->license_name == 'H'){
             $certificate_name = 'WIREMAN HELPER';
            $content_text = 'இச்சான்று பெற்றவர் நடுத்தர மற்றும் குறைந்த மின்னழுத்த அமைப்பு பணிகளை மேற்கோள்வதில் உரிமம் பெற்ற மின் ஒப்பந்தக்காரரிடம் மின் கம்பியாளருக்கு உதவியாளராக பணிபுரியலாம். அல்லது நடுத்தர மற்றும் குறைந்த அழுத்த நிறுவனத்தின் இயக்குதல் மற்றும் பராமரிப்பு பணியில் மின்கம்பியாளருக்கு உதவியாளராக நிறுவனத்தின் அங்கீகாரத்துடன் மேற்கொள்ளலாம்.'; 
        }else{
            $certificate_name = '';
            $content_text = 'இச்சான்றிதழ் பெற்றவர், உரிமம் பெற்ற மின் ஒப்பந்தக்காரரின் கீழ் உயர் மின்னழுத்த (H.V) மற்றும் நடுத்தர மின்னழுத்த (M.V) மின் நிறுவல் பணிகளை மேற்பார்வை செய்ய அனுமதிக்கப்படுகிறார்; அல்லது இந்திய மின்சார விதிகள், 1956 இன் விதி 3 இன் கீழ் அங்கீகரிக்கப்பட்ட நபராக பணியாற்ற அனுமதிக்கப்படுகிறார்.';
        }

        $certificateRow = '';

        if (!empty($certificate_name)) {
            $certificateRow = '
                <tr>
                    <td class="lbl">தே.சான்று எண்</td>
                    <td class="colon">:</td>
                    <td class="val">'.$certificate_name.'</td>
                </tr>
            ';
        }

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'),
            ]),
            'fontdata' => array_merge($fontData, [
                'notosanstamil' => [
                    'R' => 'NotoSansTamil-Regular.ttf',
                ]
            ]),
            'default_font' => 'notosanstamil',
            'format' => [80.80, 120.55],
            'orientation' => 'L',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
        ]);


        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;


        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);
        $mpdf->WriteHTML('<style>
            @page {
                size: 120.55mm 80.80mm;   /* CR100 landscape */
                margin: 0;
            }
            body {
                margin: 0;
                padding: 0;
                width: 120.55mm;
                height: 80.80mm;
                font-family: notosanstamil;
                overflow: hidden;
            }
            .card {
                width: 120.55mm;
                height: 80.80mm;
                border: 0.4mm solid #000;
                box-sizing: border-box;
            }
            .header {
                height: 11mm;
                color: #003366;
                text-align: center;
                font-size: 12.5pt;
                font-weight: bold;
                padding: 1mm;
                box-sizing: border-box;
            }
            .content {
                padding: 3mm;
                font-size: 7pt;
                box-sizing: border-box;
            }
            .photo {
                width: 22mm;
                height: 22mm;
                border: 0.3mm solid #000;
                box-sizing: border-box;
                overflow: hidden;
            }
           .info-table {
                font-size: 9pt;
                border-collapse: collapse;
            }

            .info-table td {
                padding: 1mm;
                vertical-align: top;
            }

            .info-table .lbl {
                width: 25mm;
                font-weight: bold;
            }

            .info-table .colon {
                width: 2mm;
                text-align: center;
            }
            .footer {
                margin-top: 2mm;   /* ✅ SAFE */
                text-align: center;
                font-size: 6pt;
            }
            </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
                
        $photoPath = !empty($applicant_photo->upload_path) ? public_path($applicant_photo->upload_path): null;

        $qrValue = 'sdfdgsdg'; 

        $html = '
        <div class="card">

            <!-- HEADER -->
            <div class="header">
                தமிழ்நாடு மின் உரிமம் வழங்கும் வாரியம்<br>
                திரு.வி.க. தொழிற்பேட்டை, கிண்டி, சென்னை – 32.
            </div>

            <!-- BODY -->
            <div class="content">

               <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <!-- LEFT : DETAILS -->
                        <td width="70%" valign="top">

                            <table class="info-table">
                                <tr>
                                    <td class="lbl">த. சா. எண்</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->license_number.'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">வ.நாள்</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.date('d M Y', strtotime($applicant->issued_at)).'</td>
                                </tr>
                                 <tr>
                                    <td class="lbl">செ.கா</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.format_date($applicant->issued_at). '<small style="font-weight: bold;"> To </small>'. format_date($applicant->expires_at).'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">பெயர்</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->name.'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">த / க பெயர்</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->fathers_name.'</td>
                                </tr>
                                 <tr>
                                    <td class="lbl">பிறந்த நாள்</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.date('d M Y', strtotime($applicant->d_o_b)).'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">விலாசம்</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->applicants_address.'</td>
                                </tr>'
                                .$certificateRow.'
                            </table>

                        </td>

                        <!-- RIGHT : PHOTO -->
                        <td width="30%" valign="top">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <!-- PHOTO ROW -->
                                <tr>
                                    <td align="center">
                                        <div class="photo">
                                            '.($photoPath
                                                ? '<img src="'.$photoPath.'" style="width:22mm; height:22mm; object-fit:cover;">'
                                                : '').'
                                        </div>
                                    </td>
                                </tr>

                                <!-- SPACE BETWEEN PHOTO & QR -->
                                <tr>
                                    <td height="3mm"></td>
                                </tr>

                                <!-- QR ROW -->
                                <tr>
                                    <td align="center">
                                        <barcode code="'.$qrValue.'" type="QR" size="0.6" error="M" />
                                    </td>
                                </tr>

                                <!-- BOTTOM SAFE SPACE -->
                                <tr>
                                    <td height="3mm"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>

            <!-- FOOTER -->
            <div class="footer">
                Issued by TNELB | தமிழ்நாடு
            </div>

        </div>
        ';
    
        $mpdf->WriteHTML($html);
        $mpdf->AddPage('L');
        $backHtml = '
            <div class="card">

                <div class="content" style="font-size:9.5pt; line-height:1.4;">

                    <div style="text-align:right; font-size:7pt; margin-bottom:2mm;">
                        Visit us at : www.tnelb.gov.in
                    </div>

                    <div style="margin-top:4mm; text-align: justify;">
                        ' . $content_text . '   
                    </div>

                    <br><br><br><br>

                    <!-- SIGNATURE AREA -->
                    <table width="100%" style="margin-top:6mm;">
                        <tr>
                            <td width="45%" style="text-align:left;">
                                <div style="height:12mm;"></div>
                                <strong>செயலாளர்</strong>
                            </td>

                            <td width="55%" style="text-align:right;">
                                <div style="height:12mm;"></div>
                                <strong>தலைவர்</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>';
        $mpdf->WriteHTML($backHtml);
        return response($mpdf->Output('Application_Details.pdf', 'I'))->header('Content-Type', 'application/pdf');
    }

    public function generateLicensePDF($application_id)
    {
        $application = DB::table('tnelb_application_tbl')
        ->where('application_id', $application_id)
        ->first();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $application_id)->first();
        if ($application && $application->appl_type === 'R') {
            $applicant = DB::table('tnelb_application_tbl')
            ->join('tnelb_renewal_license', 'tnelb_renewal_license.application_id', '=', 'tnelb_application_tbl.application_id')
            ->where('tnelb_application_tbl.application_id', $application_id)
            ->select(
                'tnelb_application_tbl.application_id',
                'tnelb_application_tbl.applicant_name AS name',
                'tnelb_application_tbl.fathers_name',
                'tnelb_application_tbl.applicants_address',
                'tnelb_application_tbl.d_o_b',
                'tnelb_application_tbl.age',
                'tnelb_application_tbl.license_name',
                'tnelb_application_tbl.form_name',
                'tnelb_renewal_license.license_number',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at'
            )
            ->first();
        } else {
            $applicant = DB::table('tnelb_application_tbl')
            ->join('tnelb_license', 'tnelb_license.application_id', '=', 'tnelb_application_tbl.application_id')
            ->where('tnelb_application_tbl.application_id', $application_id)
            ->select(
                'tnelb_application_tbl.application_id',
                'tnelb_application_tbl.applicant_name AS name',
                'tnelb_application_tbl.fathers_name',
                'tnelb_application_tbl.applicants_address',
                'tnelb_application_tbl.d_o_b',
                'tnelb_application_tbl.age',
                'tnelb_application_tbl.license_name',
                'tnelb_application_tbl.form_name',
                'tnelb_license.license_number',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at'
            )
            ->first();
        }
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }
        $payment = DB::table('payments')->where('application_id', $application_id)->first();
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [70.80, 110.55],
            'orientation' => 'L',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
        ]);

        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);
        $mpdf->WriteHTML('<style>
            @page {
                size: 110.55mm 70.80mm;   /* CR100 landscape */
                margin: 0;
            }
            body {
                margin: 0;
                padding: 0;
                width: 110.55mm;
                height: 70.80mm;
                font-family: helvetica;
                overflow: hidden;
            }
            .card {
                width: 110.55mm;
                height: 70.80mm;
                border: 0.4mm solid #000;
                box-sizing: border-box;
            }
            .header {
                height: 11mm;
                color: #003366;
                text-align: center;
                font-size: 10.5pt;
                font-weight: bold;
                padding: 2mm;
                box-sizing: border-box;
            }
            .content {
                padding: 3mm;
                font-size: 7pt;
                box-sizing: border-box;
            }
            .photo {
                width: 22mm;
                height: 22mm;
                border: 0.3mm solid #000;
                box-sizing: border-box;
                overflow: hidden;
            }
           .info-table {
                font-size: 9pt;
                border-collapse: collapse;
            }

            .info-table td {
                padding: 1mm;
                vertical-align: top;
            }

            .info-table .lbl {
                width: 25mm;
                font-weight: bold;
            }

            .info-table .colon {
                width: 2mm;
                text-align: center;
            }
            .footer {
                margin-top: 2mm;   /* ✅ SAFE */
                text-align: center;
                font-size: 6pt;
            }
            </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
                
        $photoPath = !empty($applicant_photo->upload_path) ? public_path($applicant_photo->upload_path): null;

        $qrValue = 'sdfdgsdg'; 

        $html = '
        <div class="card">

            <!-- HEADER -->
            <div class="header">
                TAMIL NADU ELECTRICAL LICENCING BOARD<br>
                Thiru Vi. Ka. Indl. Estate, Guindy, Chennai - 600 032.
            </div>

            <!-- BODY -->
            <div class="content">

               <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <!-- LEFT : DETAILS -->
                        <td width="70%" valign="top">

                            <table class="info-table">
                                <tr>
                                    <td class="lbl">C.No</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->license_number.'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">D.O.I</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.date('d M Y', strtotime($applicant->issued_at)).'</td>
                                </tr>
                                 <tr>
                                    <td class="lbl">Validity</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.format_date($applicant->issued_at). '<small style="font-weight: bold;"> To </small>'. format_date($applicant->expires_at).'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Name</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->name.'</td>
                                </tr>
                                <tr>
                                    <td class="lbl">F/H Name</td>
                                    <td class="colon">:</td>
                                    <td class="val">'.$applicant->fathers_name.'</td>
                                </tr>
                            </table>

                        </td>

                        <!-- RIGHT : PHOTO -->
                        <td width="30%" valign="top">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <!-- PHOTO ROW -->
                                <tr>
                                    <td align="center">
                                        <div class="photo">
                                            '.($photoPath
                                                ? '<img src="'.$photoPath.'" style="width:22mm; height:22mm; object-fit:cover;">'
                                                : '').'
                                        </div>
                                    </td>
                                </tr>

                                <!-- SPACE BETWEEN PHOTO & QR -->
                                <tr>
                                    <td height="3mm"></td>
                                </tr>

                                <!-- QR ROW -->
                                <tr>
                                    <td align="center">
                                        <barcode code="'.$qrValue.'" type="QR" size="0.6" error="M" />
                                    </td>
                                </tr>

                                <!-- BOTTOM SAFE SPACE -->
                                <tr>
                                    <td height="4mm"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>

            <!-- FOOTER -->
            <div class="footer">
                Issued by TNELB | Tamil Nadu
            </div>

        </div>
        ';
    
        $mpdf->WriteHTML($html);
        $mpdf->AddPage('L');
        $backHtml = '
            <div class="card">

                <div class="content" style="font-size:8.5pt; line-height:1.4;">

                    <div style="text-align:right; font-size:7pt; margin-bottom:2mm;">
                        Visit us at : www.tnelb.gov.in
                    </div>

                    <div style="margin-top:4mm;">
                        This Certificate holder is permitted to supervise
                        <strong>H.V and M.V. Electrical installation works</strong>
                        under licensed contractor or to work as authorised person
                        under rule 3 of Indian Electricity Rule 1956.
                    </div>

                    <br><br><br><br>

                    <!-- SIGNATURE AREA -->
                    <table width="100%" style="margin-top:6mm;">
                        <tr>
                            <td width="45%" style="text-align:left;">
                                <div style="height:12mm;"></div>
                                <strong>Secretary</strong>
                            </td>

                            <td width="55%" style="text-align:right;">
                                <div style="height:12mm;"></div>
                                <strong>President</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>';
        $mpdf->WriteHTML($backHtml);
        return response($mpdf->Output('Application_Details.pdf', 'I'))->header('Content-Type', 'application/pdf');

    }


    public function generateFormaPDF($application_id)
    {
        // Fetch application details

        // dd($application_id);
        // exit;
        $application = DB::table('tnelb_ea_applications')->where('application_id', $application_id)->first();

        $appltype = trim($application->appl_type);
       
        if($appltype === 'N'){
                $applicant = DB::table('tnelb_license')
            ->join('tnelb_ea_applications', 'tnelb_license.application_id', '=', 'tnelb_ea_applications.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',
                'tnelb_ea_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_ea_applications.license_name',
                'tnelb_ea_applications.form_name',
                'tnelb_license.license_number'
            )
            ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderby('id')
            // ->where('staff_flag', 1)
            ->get();

        }else{
    $applicant = DB::table('tnelb_renewal_license')
            ->join('tnelb_ea_applications', 'tnelb_renewal_license.application_id', '=', 'tnelb_ea_applications.application_id')
            ->where('tnelb_renewal_license.application_id', $application_id)
            ->select(
                'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',
                'tnelb_ea_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_ea_applications.license_name',
                'tnelb_ea_applications.form_name',
                'tnelb_renewal_license.license_number'
            )
            ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderby('id')
            // ->where('staff_flag', 1)
            ->get();

        }
    

    
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }
    
        
        $payment = DB::table('payments')->where('application_id', $application_id)->first();
    
        // Initialize mPDF
        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        
        $mpdf->WriteHTML('<style>
        body {  }
        p, td, th { padding: 0px; }
        p 
        .tbl_center { text-align: center; }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: green; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:green;}
        .staff_tbl td{text-align:center;}
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        // Start building the PDF content
        $html = '
        <h3 style="text-align: center;" class="">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align: center;" class="">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align: center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align: center;" class="highlight_text"> Form ' . $applicant->form_name . ' License "' . $applicant->license_name . '"</h4>
        <h3  style="text-align: center;"><strong>License for Contractor Certificate</strong></h3>
        <h3 style="text-align: center;" class=""> License Number : <span class = "highlight_text">' . $applicant->license_number . '</span></h3>';
    
     if($appltype === 'N') 
     {
        $apply_type= "Fresh Application";
     }else{
        $apply_type= "Renewal Application";
     }

    
        $html .= '
        <h4 class="mt-2 highlight"> License Summary</h4>
        <table>
            <tr><th class="">Applicantion ID</th><td>' . $applicant->application_id . '</td></tr>
            <tr><th class="">Name of Electrical Contractor/s <br> licence  applied for </th><td>' . $applicant->name . '</td></tr>
            <tr><th class="">License Name</th><td>' . $applicant->license_name . '</td></tr>
            <tr><th class="">License Type</th><td>' . $apply_type . '</td></tr>
            <tr><th class="">Issued By</th><td>' . $applicant->issued_by . '</td></tr>
            <tr><th class="">Issued At</th><td>' . date('d-m-Y', strtotime($applicant->issued_at)) . '</td></tr>
            <tr><th class="">Expired At</th><td>' . date('d-m-Y', strtotime($applicant->expires_at)) . '</td></tr>
        </table>';

       $html .= '
<h4 class="mt-2 highlight">Details of Staff appointed under this Contractor License</h4>
<table class="staff_tbl" border="1">
    <tr>
        <th>S.No</th>
        <th>Staff Name</th>
        <th>Qualification </th>
        <th>Category </th>
        <th>Competency Certificate Number & Validity </th>
    </tr>';

if ($staffDetails->count() > 0) {
    $i = 1;
    foreach ($staffDetails as $staff) {
        $html .= '
        <tr>
            <td>' . $i++ . '</td>
            <td>' . strtoupper($staff->staff_name) . '</td>
            <td>' . strtoupper($staff->staff_qualification) . '</td>
            <td>' . strtoupper($staff->staff_category) . '</td>
            <td>' . $staff->cc_number . ', ' . (!empty($staff->cc_validity) ? date('d-m-Y', strtotime($staff->cc_validity)) : 'N/A') . '</td>

        </tr>';
    }
} else {
    $html .= '<tr><td colspan="5" style="text-align:center;">No staff found</td></tr>';
}

$html .= '</table>';

    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
        $html .= '
        <br>
       
        <p><strong>Date:</strong> ' . date('d-m-Y', strtotime($applicant->issued_at)) . '</p>';
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
    
        // Output PDF
        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

   // -----------for all contractor license generateFormcontractor_download-------------------

   public function generateFormcontractor_download($application_id)
{
    // ---------------------------------------
    // 1. DETECT WHICH TABLE HAS THE APPLICATION
    // ---------------------------------------
    $application = null;
    $table_name = null;

    $tables = [
        'tnelb_esa_applications',
        'tnelb_esb_applications',
        'tnelb_eb_applications',
        'tnelb_ea_applications'
    ];

    foreach ($tables as $t) {
        $record = DB::table($t)
            ->where('application_id', $application_id)
            ->first();

        if ($record) {
            $application = $record;
            $table_name = $t;
            break;
        }
    }

    if (!$application) {
        return back()->with('error', 'Application ID not found.');
    }

    $licence_id = DB::table('mst_licences')
            ->where('cert_licence_code', $application->license_name)
            ->first();

    // Clean appl_type
    $appltype = strtoupper(trim($application->appl_type));


    // ---------------------------------------
    // 2. FRESH APPLICATION (appl_type = N)
    // ---------------------------------------
    if ($appltype === 'N') {

        $applicant = DB::table('tnelb_license')
            ->join($table_name, 'tnelb_license.application_id', '=', $table_name . '.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',

                $table_name . '.applicant_name AS name',
                $table_name . '.license_name',
                $table_name . '.form_name',

                'tnelb_license.license_number'
            )
            ->first();

        $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderBy('id')
            ->get();

    }

    // ---------------------------------------
    // 3. RENEWAL APPLICATION
    // ---------------------------------------
    else {

        $applicant = DB::table('tnelb_renewal_license')
            ->join($table_name, 'tnelb_renewal_license.application_id', '=', $table_name . '.application_id')
            ->where('tnelb_renewal_license.application_id', $application_id)
            ->select(
                'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',

                $table_name . '.applicant_name AS name',
                $table_name . '.license_name',
                $table_name . '.form_name',

                'tnelb_renewal_license.license_number'
            )
            ->first();

        $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderBy('id')
            ->get();
    }


    // ---------------------------------------
    // 4. RETURN OR LOAD PDF VIEW
    // ---------------------------------------

      $mpdf = new Mpdf([
        'format' => [210, 175], 
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'default_font_size' => 11,
        'default_font' => 'Abyssinica_SIL'
        
    ]);

        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        $formname = $applicant->form_name;

        // dd($formname);
        // exit;

        $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();


        // dd($license_name);
        // exit;
        
        $mpdf->WriteHTML('<style>
        body { }
        p, td, th { padding: 0px; }
        p {font-size:15px;}
        .tbl_center { text-align: center;!important }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: green; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:green;}
        .staff_tbl td{text-align:center;}
        .license_name{ font-size:15px;text-align:center;font-weight:bold; text-decoration:underline;}
        .font-weight{font-weight:bold;}
        .blue{color:#074282;}
        .orange{color:#ec4b05;}
        .txt_uppercase{text-transform:uppercase;}
        .line-height-30{line-height:20px;}
        .text-indent-40 {text-indent: 40px;}
        .text-indent-60 {text-indent: 50px;}
        .text-justify {text-align: justify;}
        .font-size-14{ font-size:15px;}
        .mb-5{margin-bottom:5px;}
        .mb-1{margin-bottom:1px;}
        .mb-10{margin-bottom:10px;}
        .pb-10{padding: bottom 10px!important;}
        .mt-5{margin-top:5px;}
        .mt-1{margin-top:1px;}
        .text-black{color:black;}
        
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    $grade_name = $applicant->license_name;
    // dd($grade_name);
    // exit;

        if($grade_name == 'EA') {
            $grade_name_txt= 'EA Grade Contractor Licence';
        } elseif($grade_name == 'ESA'){
             $grade_name_txt= 'ESA Grade Contractor Licence';
        }elseif($grade_name == 'ESB'){
             $grade_name_txt= 'ESB Grade Contractor Licence';
        }elseif($grade_name == 'EB'){
            $grade_name_txt= 'EB Grade Contractor Licence ';
        }
        $qrData = url('/verify-certificate/' . $applicant->application_id);

    
        
        // Start building the PDF content
     $html = '
<table width="100%" class="mt-1 mb-1">
    <tr>
        <!-- LEFT CONTENT -->
        <td  style="text-align:center; padding-top:10px;">

            <div class="header-block">
                <h3 class="blue mb-10 pb-10 ">GOVERNMENT OF TAMILNADU</h3>
                <br>

                <h3 class="blue mb-10 pb-10">ELECTRICAL LICENSING BOARD</h3>
                <br>

                <p class="blue mb-10 pb-10">
                    Thiru.Vi.Ka. Indl. Estate, Guindy, Chennai - 600 032.
                </p>
                <br>

                <p class="license_name orange mt-10">
                    ' . $grade_name_txt . '
                </p>
            </div>

        </td>

         <!-- RIGHT QR -->
        <td width="10%" style="text-align:right; vertical-align:top; padding-top:10px;">
            <barcode 
                code="' . htmlspecialchars($qrData) . '" 
                type="QR" 
                size="1"
                error="H"
            />
        </td>

  
    </tr>
</table>';

    
   
        
  
         $html .= '
        <table style="width:100%; border:0; mt-1 mb-1">
            <tr>
                <td class="label " style="text-align:left;"><h4 class="orange  font-size-14">Licence No : '. $applicant->license_number . '</h4></td>
                <td class="label" style="text-align:right;"><h4 class="orange  font-size-14">Date of Issue : ' . format_date($applicant->issued_at) .'</h4></td>
            </tr>
        </table>';

         if($grade_name == 'ESB' || $grade_name == 'EB' ) {
            $grade_name_txt= 'EA Grade Contractor Licence';
       
        $html .='<p class="mt-1 mb-1 line-height-30 font-size-14 blue font-weight text-indent-40 text-justify"> Thiru/Thiruvalargal <span class="text-black"> '.$applicant->name .' (Application ID. '.$applicant->application_id.') </span> are licensed to undertake electrical system works for low and medium voltage consumers in Tamil Nadu, limited to a maximum of 50 kW (63 kVA generator). This license is granted according to the regulations of the Electrical Licensing Board, approved by the Government of Tamil Nadu in the following Government Orders, under Rule 45(1) of the Indian Electricity Rules, 1956. </p>';
         }

         else{

                $html .='<p class="mt-1 mb-1 line-height-30 font-size-14 blue font-weight text-indent-40 text-justify"> Thiru/Thiruvalargal <span class="text-black"> '.$applicant->name .' (Application ID. '.$applicant->application_id.') </span> is/are hereby authorised to carryout High Voltage, Medium Voltage and Low Voltage electrical works in the state of Tamil Nadu. This licence is issued under the regulations issued by the Government of Tamil Nadu in the following G.Os. under Rule 45(1) of the Indian Electricity Rules 1956. </p>';

         }
     
        $html .= '
        <p class="mt-5 mb-5 blue font-size-14 font-weight  text-indent-60">1) GO.M.S.No. 1246 Public works Dated 31.03.1955 </p>
        <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">2) GO.MS.No.1983 Public works Dated 7.10.1987 </p>
         <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">3) GO.MS.No.2744 Public works (vi) Department Dated 24.12.1990 </p>
         <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">4) GO.MS.No.27 Energy (B,) Department Dated 8.3.2000 </p>';

            $html .= '<p class=" mb-5 orange font-size-14 font-weight  text-indent-60 ">This license is valid for the following period : <span class="text-black"> '.   format_date($applicant->expires_at) .' </span></p>';



        $proprietors = DB::table('proprietordetailsform_A')
            ->where('application_id', $application_id)
            ->where('proprietor_flag', '1')
            ->orderBy('id')
            ->get();

        $html .= '
        <table style="width:100%; border:0;" class="mt-1 mb-1">
            <tr>
                <td class="label blue txt_uppercase" style="text-align:left;">
                    <h4>Proprietor / Partner / Director Name </h4>
                </td>
                <td> : </td>
                <td>
            ';

        if ($proprietors->count() > 0) {
            foreach ($proprietors as $proprietor) {
                $html .= '
                
                        ' . strtoupper($proprietor->proprietor_name) . ',
                ';
            }
        } else {
            $html .= '
            —';
        }

        $html .= '
        </td>
        </tr>
        <tr>
        <td class="label blue txt_uppercase" style="text-align:left;">
                    <h4>Name of the authorized person
        and specimen signature </h4>  </td>
        <td> : </td>
        <td> Authorized Person Name </td>
        
        </tr>
        </table>';


           $html .= '
           <br><br>
         
            <table style="width:100%; border:0;" class="mt-1 mb-1">
                <tr>
                    <td class="label font-size-14 blue font-weight" style="text-align:left;">Secretary </td>
                    <td class="label font-size-14 blue font-weight" style="text-align:right;">President</td>
                </tr>
            </table>';



      

    

        $html .= "<pagebreak />";


        $html .= '
        <h4 class="mt-2 orange font-size-14 font-weight">Staff Details</h4>
        <table class=" width = 50%" >';

        if ($staffDetails->count() > 0) {
            $i = 1;
            foreach ($staffDetails as $staff) {

                $dates = \App\Http\Controllers\Admin\LicensepdfController::getStaffExpiryDate(
                    $staff->cc_number
                );

                $html .= '
                    <tr>
                        <td>' . $i++ . ') ' . strtoupper($staff->staff_name) . ' - ' . $staff->cc_number .  '  Valid From : <b>' . $dates['valid_from'] . '</b> Valid Upto : <b>' . $dates['valid_upto'] . '</b></td>
                      
                    </tr>';
            }
        }
        $html .= '</table>';
   $equiplist = DB::table('mst_equipment_tbls')
            ->where('equip_licence_name', $licence_id->id)
            ->orderBy('id')
            ->get();

        $equipmentlist = DB::table('equipmentforma_tbls')
            ->where('application_id', $application_id)
            ->get();

        // dd($equipmentlist->first()->licence_id);
        // exit;

        /* Map equip_id => equipment_value */
        $equipmentMap = $equipmentlist->pluck('equipment_value', 'equip_id')
            ->toArray();

        $html .= '
<h4 class="mt-2 orange font-size-14 font-weight">
    Equipments / Instruments Details
</h4>
<table class="width=50%">';
        $licenceId = optional($equipmentlist->first())->licence_id;
        if ($equiplist->count() > 0) {

            $i = 1;

            foreach ($equiplist as $index => $equip) {


                if ($equip->equip_licence_name == $licenceId) {

                    $equipmentValue = $equipmentMap[$equip->id] ?? 'N/A';

                    $html .= '
        <tr>
            <td>' . $i++ . ') ' . strtoupper($equip->equip_name) . '</td>
            <td>' . strtoupper($equipmentValue) . '</td>
        </tr>';
                }
            }
        } else {

            $html .= '
    <tr>
        <td colspan="2" style="text-align:center;">No equipment found</td>
    </tr>';
        }

        $html .= '</table>';
    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
       
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);

        

        // Footer section
        $mpdf->SetFooter('
        <table style="width:100%; font-size:12px;">
            <tr>
                <td style="text-align:left;">TNELB</td>
                <td class="label" style="text-align:right;">Date : ' . date('d-m-Y') . '</td>
                
            </tr>
        </table>
        ');

        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
}




 public function generateFormcontractor_download_final_bk($application_id)
{
    // ---------------------------------------
    // 1. DETECT WHICH TABLE HAS THE APPLICATION
    // ---------------------------------------
    $application = null;
    $table_name = null;

    $tables = [
        'tnelb_esa_applications',
        'tnelb_esb_applications',
        'tnelb_eb_applications',
        'tnelb_ea_applications'
    ];

    foreach ($tables as $t) {
        $record = DB::table($t)
            ->where('application_id', $application_id)
            ->first();

        if ($record) {
            $application = $record;
            $table_name = $t;
            break;
        }
    }

    if (!$application) {
        return back()->with('error', 'Application ID not found.');
    }

    // Clean appl_type
    $appltype = strtoupper(trim($application->appl_type));


    // ---------------------------------------
    // 2. FRESH APPLICATION (appl_type = N)
    // ---------------------------------------
    if ($appltype === 'N') {

        $applicant = DB::table('tnelb_license')
            ->join($table_name, 'tnelb_license.application_id', '=', $table_name . '.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',

                $table_name . '.applicant_name AS name',
                $table_name . '.license_name',
                $table_name . '.form_name',

                'tnelb_license.license_number'
            )
            ->first();

        $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderBy('id')
            ->get();

    }

    // ---------------------------------------
    // 3. RENEWAL APPLICATION
    // ---------------------------------------
    else {

        $applicant = DB::table('tnelb_renewal_license')
            ->join($table_name, 'tnelb_renewal_license.application_id', '=', $table_name . '.application_id')
            ->where('tnelb_renewal_license.application_id', $application_id)
            ->select(
                'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',

                $table_name . '.applicant_name AS name',
                $table_name . '.license_name',
                $table_name . '.form_name',

                'tnelb_renewal_license.license_number'
            )
            ->first();

        $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderBy('id')
            ->get();
    }


    // ---------------------------------------
    // 4. RETURN OR LOAD PDF VIEW
    // ---------------------------------------

      $mpdf = new Mpdf([
        'format' => [210, 175], 
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'default_font_size' => 9
    ]);

        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        $formname = $applicant->form_name;

        // dd($formname);
        // exit;

        $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();


        // dd($license_name);
        // exit;
        
        $mpdf->WriteHTML('<style>
        body { }
        p, td, th { padding: 0px; }
        p {font-size:15px;}
        .tbl_center { text-align: center;!important }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: green; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:green;}
        .staff_tbl td{text-align:center;}
        .license_name{ font-size:15px;text-align:center;font-weight:bold; text-decoration:underline;}
        .font-weight{font-weight:bold;}
        .blue{color:#074282;}
        .orange{color:#ec4b05;}
        .txt_uppercase{text-transform:uppercase;}
        .line-height-30{line-height:25px;}
        .text-indent-40 {text-indent: 40px;}
        .text-indent-60 {text-indent: 50px;}
        .text-justify {text-align: justify;}
        .font-size-14{ font-size:13px;}
        .mb-5{margin-bottom:5px;}
        .mb-1{margin-bottom:1px;}
        .mb-10{margin-bottom:10px;}
        .pb-10{padding: bottom 10px!important;}
        .mt-5{margin-top:5px;}
        .mt-1{margin-top:1px;}
        
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    $grade_name = $applicant->license_name;
    // dd($grade_name);
    // exit;

        if($grade_name == 'EA') {
            $grade_name_txt= 'EA Grade Contractor Licence';
        } elseif($grade_name == 'ESA'){
             $grade_name_txt= 'ESA Grade Contractor Licence';
        }elseif($grade_name == 'ESB'){
             $grade_name_txt= 'ESB Grade Contractor Licence';
        }elseif($grade_name == 'EB'){
            $grade_name_txt= 'EB Grade Contractor Licence ';
        }
        $qrData = url('/verify-certificate/' . $applicant->application_id);

    
        
        // Start building the PDF content
      $html = '
<table width="100%" class="mt-1 mb-1">
    <tr>
        <!-- LEFT CONTENT -->
        <td width="90%" style="text-align:center; padding-top:10px;">

            <div class="header-block">
                <h3 class="blue mb-10 pb-10 ">GOVERNMENT OF TAMILNADU</h3>
                <br>

                <h3 class="blue mb-10 pb-10">ELECTRICAL LICENSING BOARD</h3>
                <br>

                <p class="blue mb-10 pb-10">
                    Thiru.Vi.Ka. Indl. Estate, Guindy, Chennai - 600 032.
                </p>
                <br>

                <p class="license_name orange mt-10">
                    ' . $grade_name_txt . '
                </p>
            </div>

        </td>

        <!-- RIGHT QR -->
        <td width="10%" style="text-align:right; vertical-align:top; padding-top:10px;">
            <barcode 
                code="' . htmlspecialchars($qrData) . '" 
                type="QR" 
                size="1"
                error="H"
            />
        </td>
    </tr>
</table>';

    
   
        
  
         $html .= '
        <table style="width:100%; border:0; mt-1 mb-1">
            <tr>
                <td class="label " style="text-align:left;"><h4 class="orange  font-size-14">Licence No : '. $applicant->license_number . '</h4></td>
                <td class="label" style="text-align:right;"><h4 class="orange  font-size-14"> Issued Date : ' . format_date($applicant->issued_at) .'</h4></td>
            </tr>
        </table>';

         
        $html .='<p class="mt-1 mb-1 line-height-30 font-size-14 blue font-weight text-indent-40 text-justify"> Mr./Ms./Messrs. '.$applicant->name .' (Application ID. '.$applicant->application_id.') are licensed to undertake electrical system works for low and medium voltage consumers in Tamil Nadu, limited to a maximum of 50 kW (63 kVA generator). This license is granted according to the regulations of the Electrical Licensing Board, approved by the Government of Tamil Nadu in the following Government Orders, under Rule 45(1) of the Indian Electricity Rules, 1956. </p>';

     
        $html .= '
        <p class="mt-5 mb-5 blue font-size-14 font-weight  text-indent-60">1.Government Order No. M.S.No. 1246 Public Works Department, dated 31.3.1955 </p>
        <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">2.Government Order No. M.S.No.1983 Public Works Department, dated 07.10.1987 </p>
         <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">3.Government Order No. M.S.No.2744 Public Works Department, dated 24.12.1990 </p>
         <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">4.Government Order No. M.S.No.27 Energy (B.) Department, dated 08.03.2000 </p>';

            $html .= '<p class=" mb-5 orange font-size-14 font-weight  text-indent-60 txt_uppercase">This license is valid for the following period :</p>';



        $proprietors = DB::table('proprietordetailsform_A')
            ->where('application_id', $application_id)
            ->where('proprietor_flag', '1')
            ->orderBy('id')
            ->get();

        $html .= '
        <table style="width:100%; border:0;" class="mt-1 mb-1">
            <tr>
                <td class="label blue txt_uppercase" style="text-align:left;">
                    <h4>Proprietor / Partner / Director Name </h4>
                </td>
                <td> : </td>
                <td>
            ';

        if ($proprietors->count() > 0) {
            foreach ($proprietors as $proprietor) {
                $html .= '
                
                        ' . strtoupper($proprietor->proprietor_name) . ',
                ';
            }
        } else {
            $html .= '
            —';
        }

        $html .= '
        </td>
        </tr>
        <tr>
        <td class="label blue txt_uppercase" style="text-align:left;">
                    <h4>Name of the authorized person
        and specimen signature </h4>  </td>
        <td> : </td>

        <td> Authorized Person Name </td>

        
        </tr>
        </table>';


           $html .= '
         
            <table style="width:100%; border:0;" class="mt-1 mb-1">
                <tr>
                    <td class="label font-size-14 blue font-weight" style="text-align:left;">Secretary </td>
                    <td class="label font-size-14 blue font-weight" style="text-align:right;">President</td>
                </tr>
            </table>';



      

    

    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
       
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);

        

        // Footer section
        // $mpdf->SetFooter('
        // <table style="width:100%; font-size:12px;">
        //     <tr>
        //         <td style="text-align:left;">TNELB</td>
        //         <td class="label" style="text-align:right;">Date : ' . date('d-m-Y') . '</td>
                
        //     </tr>
        // </table>
        // ');

        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
}



// -----------for all contractor license generateFormcontractor_download-------------------

   public function generateFormcontractor_download_bk($application_id)
{
    // ---------------------------------------
    // 1. DETECT WHICH TABLE HAS THE APPLICATION
    // ---------------------------------------
    $application = null;
    $table_name = null;

    $tables = [
        'tnelb_esa_applications',
        'tnelb_esb_applications',
        'tnelb_eb_applications',
        'tnelb_ea_applications'
    ];

    foreach ($tables as $t) {
        $record = DB::table($t)
            ->where('application_id', $application_id)
            ->first();

        if ($record) {
            $application = $record;
            $table_name = $t;
            break;
        }
    }

    if (!$application) {
        return back()->with('error', 'Application ID not found.');
    }

    // Clean appl_type
    $appltype = strtoupper(trim($application->appl_type));


    // ---------------------------------------
    // 2. FRESH APPLICATION (appl_type = N)
    // ---------------------------------------
    if ($appltype === 'N') {

        $applicant = DB::table('tnelb_license')
            ->join($table_name, 'tnelb_license.application_id', '=', $table_name . '.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',

                $table_name . '.applicant_name AS name',
                $table_name . '.license_name',
                $table_name . '.form_name',

                'tnelb_license.license_number'
            )
            ->first();

        $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderBy('id')
            ->get();

    }

    // ---------------------------------------
    // 3. RENEWAL APPLICATION
    // ---------------------------------------
    else {

        $applicant = DB::table('tnelb_renewal_license')
            ->join($table_name, 'tnelb_renewal_license.application_id', '=', $table_name . '.application_id')
            ->where('tnelb_renewal_license.application_id', $application_id)
            ->select(
                'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',

                $table_name . '.applicant_name AS name',
                $table_name . '.license_name',
                $table_name . '.form_name',

                'tnelb_renewal_license.license_number'
            )
            ->first();

        $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderBy('id')
            ->get();
    }


    // ---------------------------------------
    // 4. RETURN OR LOAD PDF VIEW
    // ---------------------------------------

        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        $formname = $applicant->form_name;

        // dd($formname);
        // exit;

        $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();


        // dd($license_name);
        // exit;
        
        $mpdf->WriteHTML('<style>
        body {  }
        p, td, th { padding: 0px; }
        p 
        .tbl_center { text-align: center;!important }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: green; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:green;}
        .staff_tbl td{text-align:center;}
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        // Start building the PDF content
        $html = '
        <h3 style="text-align: center;" class="">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align: center;" class="">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align: center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align: center;" class=""> Form  "' . $license_name->form_code . '" License "' . $license_name->licence_name . '"</h4>
        
        <h3 style="text-align: center;" class=""> License Number : <span class = "">' . $applicant->license_number . '</span></h3>';
    
     if($appltype === 'N') 
     {
        $apply_type= "Fresh Application";
     }else{
        $apply_type= "Renewal Application";
     }
        
  
       

        $html .= '<table class="tbl-no-border" style="margin: 0 auto; width: 70%;">';
        

       
        $html .= '  <tr><td class="label">Applicantion ID :</td><td class="value">'. $applicant->application_id .'</td></tr>';
        $html .= '  <tr><td class="label">Applicant Name :</td><td class="value">'. $applicant->name .'</td></tr>';

        $html .= '  <tr><td class="label">Application Type :</td><td class="value">'. $apply_type .'</td></tr>';
        
       
        $html .= '</table>';
  

       $html .= '
<h4 class="mt-2 tbl_center">Details of Staff appointed under this Contractor License</h4>
<table class="staff_tbl" border="1">
    <tr>
        <th>S.No</th>
        <th>Staff Name</th>
        <th>Qualification </th>
        <th>Category </th>
        <th>Competency Certificate Number & Validity </th>
    </tr>';

    if ($staffDetails->count() > 0) {
        $i = 1;
        foreach ($staffDetails as $staff) {
            $html .= '
            <tr>
                <td>' . $i++ . '</td>
                <td>' . strtoupper($staff->staff_name) . '</td>
                <td>' . strtoupper($staff->staff_qualification) . '</td>
                <td>' . strtoupper($staff->staff_category) . '</td>
                <td>' . $staff->cc_number . ', ' . (!empty($staff->cc_validity) ? date('d-m-Y', strtotime($staff->cc_validity)) : 'N/A') . '</td>

            </tr>';
        }
    } else {
        $html .= '<tr><td colspan="5" style="text-align:center;">No staff found</td></tr>';
    }

    $html .= '</table>';

      $html .= '
        <table style="width:100%; border:0;">
            <tr>
                <td class="label " style="text-align:left;"><h4>Issued At : '. format_date($applicant->issued_at) . '</h4></td>
                <td class="label" style="text-align:right;"><h4>Expires At : ' . format_date($applicant->expires_at) .'</h4></td>
            </tr>
        </table>';


         $html .= '
            <br><br>
            <br><br>
            <br><br>
            <table style="width:100%; border:0;">
                <tr>
                    <td class="label" style="text-align:left;">Date : ' . date('d-m-Y') . '</td>
                    <td class="label" style="text-align:right;">Issued By : ' . $applicant->issued_by . '</td>
                </tr>
            </table>';


    

    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
       
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);

        

        // Footer section
        $mpdf->SetFooter('
        <table style="width:100%; font-size:12px;">
            <tr>
                <td style="text-align:right;">TNELB</td>
                
            </tr>
        </table>
        ');

        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
}
  // ---------------------------- admin side final pdf forma download---------------------------

   public function generateForma_downloadPDF($application_id)
{
    // ---------------------------------------
    // 1. DETECT WHICH TABLE HAS THE APPLICATION
    // ---------------------------------------
    $application = null;
    $table_name = null;

    $tables = [
        'tnelb_esa_applications',
        'tnelb_esb_applications',
        'tnelb_eb_applications',
        'tnelb_ea_applications'
    ];

    foreach ($tables as $t) {
        $record = DB::table($t)
            ->where('application_id', $application_id)
            ->first();

        if ($record) {
            $application = $record;
            $table_name = $t;
            break;
        }
    }

    if (!$application) {
        return back()->with('error', 'Application ID not found.');
    }

    // Clean appl_type
    $appltype = strtoupper(trim($application->appl_type));


    // ---------------------------------------
    // 2. FRESH APPLICATION (appl_type = N)
    // ---------------------------------------
    if ($appltype === 'N') {

        $applicant = DB::table('tnelb_license')
            ->join($table_name, 'tnelb_license.application_id', '=', $table_name . '.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',

                $table_name . '.applicant_name AS name',
                $table_name . '.license_name',
                $table_name . '.form_name',

                'tnelb_license.license_number'
            )
            ->first();

        $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderBy('id')
            ->get();

    }

    // ---------------------------------------
    // 3. RENEWAL APPLICATION
    // ---------------------------------------
    else {

        $applicant = DB::table('tnelb_renewal_license')
            ->join($table_name, 'tnelb_renewal_license.application_id', '=', $table_name . '.application_id')
            ->where('tnelb_renewal_license.application_id', $application_id)
            ->select(
                'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',

                $table_name . '.applicant_name AS name',
                $table_name . '.license_name',
                $table_name . '.form_name',

                'tnelb_renewal_license.license_number'
            )
            ->first();

        $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderBy('id')
            ->get();
    }


    // ---------------------------------------
    // 4. RETURN OR LOAD PDF VIEW
    // ---------------------------------------

      $mpdf = new Mpdf([
        'format' => [210, 175], 
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'default_font_size' => 9,
        'default_font' => 'Abyssinica_SIL'
    ]);

        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        $formname = $applicant->form_name;

        // dd($formname);
        // exit;

        $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();


        // dd($license_name);
        // exit;
        
        $mpdf->WriteHTML('<style>
        body { }
        p, td, th { padding: 0px; }
        p {font-size:15px;}
        .tbl_center { text-align: center;!important }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: green; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:green;}
        .staff_tbl td{text-align:center;}
        .license_name{ font-size:15px;text-align:center;font-weight:bold; text-decoration:underline;}
        .font-weight{font-weight:bold;}
        .blue{color:#074282;}
        .orange{color:#ec4b05;}
        .txt_uppercase{text-transform:uppercase;}
        .line-height-30{line-height:20px;}
        .text-indent-40 {text-indent: 40px;}
        .text-indent-60 {text-indent: 50px;}
        .text-justify {text-align: justify;}
        .font-size-14{ font-size:13px;}
        .mb-5{margin-bottom:5px;}
        .mb-1{margin-bottom:1px;}
        .mb-10{margin-bottom:10px;}
        .pb-10{padding: bottom 10px!important;}
        .mt-5{margin-top:5px;}
        .mt-1{margin-top:1px;}
        .text-black{color:black;}
        
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    $grade_name = $applicant->license_name;
    // dd($grade_name);
    // exit;

        if($grade_name == 'EA') {
            $grade_name_txt= 'EA Grade Contractor Licence';
        } elseif($grade_name == 'ESA'){
             $grade_name_txt= 'ESA Grade Contractor Licence';
        }elseif($grade_name == 'ESB'){
             $grade_name_txt= 'ESB Grade Contractor Licence';
        }elseif($grade_name == 'EB'){
            $grade_name_txt= 'EB Grade Contractor Licence ';
        }
        // $qrData = url('/verify-certificate/' . $applicant->application_id);

    
        
        // Start building the PDF content
      $html = '
<table width="100%" class="mt-1 mb-1">
    <tr>
        <!-- LEFT CONTENT -->
        <td  style="text-align:center; padding-top:10px;">

            <div class="header-block">
                <h3 class="blue mb-10 pb-10 ">GOVERNMENT OF TAMILNADU</h3>
                <br>

                <h3 class="blue mb-10 pb-10">ELECTRICAL LICENSING BOARD</h3>
                <br>

                <p class="blue mb-10 pb-10">
                    Thiru.Vi.Ka. Indl. Estate, Guindy, Chennai - 600 032.
                </p>
                <br>

                <p class="license_name orange mt-10">
                    ' . $grade_name_txt . '
                </p>
            </div>

        </td>

  
    </tr>
</table>';

    
   
        
  
         $html .= '
        <table style="width:100%; border:0; mt-1 mb-1">
            <tr>
                <td class="label " style="text-align:left;"><h4 class="orange  font-size-14">Licence No : '. $applicant->license_number . '</h4></td>
                <td class="label" style="text-align:right;"><h4 class="orange  font-size-14">Date of Issue : ' . format_date($applicant->issued_at) .'</h4></td>
            </tr>
        </table>';

         if($grade_name == 'ESB' || $grade_name == 'EB' ) {
            $grade_name_txt= 'EA Grade Contractor Licence';
       
        $html .='<p class="mt-1 mb-1 line-height-30 font-size-14 blue font-weight text-indent-40 text-justify"> Thiru/Thiruvalargal <span class="text-black"> '.$applicant->name .' (Application ID. '.$applicant->application_id.') </span> are licensed to undertake electrical system works for low and medium voltage consumers in Tamil Nadu, limited to a maximum of 50 kW (63 kVA generator). This license is granted according to the regulations of the Electrical Licensing Board, approved by the Government of Tamil Nadu in the following Government Orders, under Rule 45(1) of the Indian Electricity Rules, 1956. </p>';
         }

         else{

                $html .='<p class="mt-1 mb-1 line-height-30 font-size-14 blue font-weight text-indent-40 text-justify"> Thiru/Thiruvalargal <span class="text-black"> '.$applicant->name .' (Application ID. '.$applicant->application_id.') </span> is/are hereby authorised to carryout High Voltage, Medium Voltage and Low Voltage electrical works in the state of Tamil Nadu. This licence is issued under the regulations issued by the Government of Tamil Nadu in the following G.Os. under Rule 45(1) of the Indian Electricity Rules 1956. </p>';

         }
     
        $html .= '
        <p class="mt-5 mb-5 blue font-size-14 font-weight  text-indent-60">1) GO.M.S.No. 1246 Public works Dated 31.03.1955 </p>
        <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">2) GO.MS.No.1983 Public works Dated 7.10.1987 </p>
         <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">3) GO.MS.No.2744 Public works (vi) Department Dated 24.12.1990 </p>
         <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60">4) GO.MS.No.27 Energy (B,) Department Dated 8.3.2000 </p>';

            $html .= '<p class=" mb-5 orange font-size-14 font-weight  text-indent-60 ">This license is valid for the following period :</p>';



        $proprietors = DB::table('proprietordetailsform_A')
            ->where('application_id', $application_id)
            ->where('proprietor_flag', '1')
            ->orderBy('id')
            ->get();

        $html .= '
        <table style="width:100%; border:0;" class="mt-1 mb-1">
            <tr>
                <td class="label blue txt_uppercase" style="text-align:left;">
                    <h4>Proprietor / Partner / Director Name </h4>
                </td>
                <td> : </td>
                <td>
            ';

        if ($proprietors->count() > 0) {
            foreach ($proprietors as $proprietor) {
                $html .= '
                
                        ' . strtoupper($proprietor->proprietor_name) . ',
                ';
            }
        } else {
            $html .= '
            —';
        }

        $html .= '
        </td>
        </tr>
        <tr>
        <td class="label blue txt_uppercase" style="text-align:left;">
                    <h4>Name of the authorized person
        and specimen signature </h4>  </td>
        <td> : </td>
        <td> Authorized Person Name </td>
        
        </tr>
        </table>';


           $html .= '
           <br><br>
         
            <table style="width:100%; border:0;" class="mt-1 mb-1">
                <tr>
                    <td class="label font-size-14 blue font-weight" style="text-align:left;">Secretary </td>
                    <td class="label font-size-14 blue font-weight" style="text-align:right;">President</td>
                </tr>
            </table>';



      

    

    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
       
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);

        

        // Footer section
        $mpdf->SetFooter('
        <table style="width:100%; font-size:12px;">
            <tr>
                <td style="text-align:left;">TNELB</td>
                <td class="label" style="text-align:right;">Date : ' . date('d-m-Y') . '</td>
                
            </tr>
        </table>
        ');

        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
}

//   ----------------------------------------------------

      public function generateForma_downloadPDF_bk($application_id)
    {
        // Fetch application details

        // dd($application_id);
       // Detect application from 4 form tables
    $application = DB::table('tnelb_esa_applications')->where('application_id', $application_id)->first()
        ?? DB::table('tnelb_esb_applications')->where('application_id', $application_id)->first()
        ?? DB::table('tnelb_eb_applications')->where('application_id', $application_id)->first()
        ?? DB::table('tnelb_ea_applications')->where('application_id', $application_id)->first();

    if (!$application) {
        return back()->with('error', 'Application not found.');
    }

    $formname = trim($application->form_name);
    $appltype = trim($application->appl_type); // N or R

    // Dynamic form table mapping
    $formTables = [
        'SA' => 'tnelb_esa_applications',
        'SB' => 'tnelb_esb_applications',
        'A'  => 'tnelb_ea_applications',
        'B'  => 'tnelb_eb_applications',
    ];

    // Pick correct application table
    $formTable = $formTables[$formname];

    // License table based on fresh/renew
    $licenseTable = ($appltype === 'N') ? 'tnelb_license' : 'tnelb_renewal_license';

    // Applicant details (License + Form Table Join)
    $applicant = DB::table($licenseTable)
        ->join($formTable, "$licenseTable.application_id", '=', "$formTable.application_id")
        ->where("$licenseTable.application_id", $application_id)
        ->select(
            "$licenseTable.application_id",
            "$licenseTable.issued_by",
            "$licenseTable.issued_at",
            "$licenseTable.expires_at",
            "$licenseTable.license_number",
            "$formTable.applicant_name AS name",
            "$formTable.license_name",
            "$formTable.form_name"
        )
        ->first();

    if (!$applicant) {
        return back()->with('error', 'Application details missing.');
    }
    

    
       $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
        ->where('application_id', $application_id)
        ->orderBy('id')
        ->get();
        
       $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();
        $payment = DB::table('payments')->where('application_id', $application_id)->first();    
    
        // Initialize mPDF
        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        $formname = $applicant->form_name;

        // dd($formname);
        // exit;

        $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();


        // dd($license_name);
        // exit;
        
        $mpdf->WriteHTML('<style>
        body {  }
        p, td, th { padding: 0px; }
        p 
        .tbl_center { text-align: center;!important }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: green; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:green;}
        .staff_tbl td{text-align:center;}
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        // Start building the PDF content
        $html = '
        <h3 style="text-align: center;" class="">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align: center;" class="">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align: center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align: center;" class="highlight_text"> Form  "' . $license_name->form_code . '" License "' . $license_name->licence_name . '"</h4>
        
        <h3 style="text-align: center;" class=""> License Number : <span class = "highlight_text">' . $applicant->license_number . '</span></h3>';
    
     if($appltype === 'N') 
     {
        $apply_type= "Fresh Application";
     }else{
        $apply_type= "Renewal Application";
     }
        
  
       

        $html .= '<table class="tbl-no-border" style="margin: 0 auto; width: 70%;">';
        

       
        $html .= '  <tr><td class="label">Applicantion ID :</td><td class="value">'. $applicant->application_id .'</td></tr>';
        $html .= '  <tr><td class="label">Applicant Name :</td><td class="value">'. $applicant->name .'</td></tr>';

        $html .= '  <tr><td class="label">Application Type :</td><td class="value">'. $apply_type .'</td></tr>';
        
       
        $html .= '</table>';
  

       $html .= '
<h4 class="mt-2 tbl_center">Details of Staff appointed under this Contractor License</h4>
<table class="staff_tbl" border="1">
    <tr>
        <th>S.No</th>
        <th>Staff Name</th>
        <th>Qualification </th>
        <th>Category </th>
        <th>Competency Certificate Number & Validity </th>
    </tr>';

    if ($staffDetails->count() > 0) {
        $i = 1;
        foreach ($staffDetails as $staff) {
            $html .= '
            <tr>
                <td>' . $i++ . '</td>
                <td>' . strtoupper($staff->staff_name) . '</td>
                <td>' . strtoupper($staff->staff_qualification) . '</td>
                <td>' . strtoupper($staff->staff_category) . '</td>
                <td>' . $staff->cc_number . ', ' . (!empty($staff->cc_validity) ? date('d-m-Y', strtotime($staff->cc_validity)) : 'N/A') . '</td>

            </tr>';
        }
    } else {
        $html .= '<tr><td colspan="5" style="text-align:center;">No staff found</td></tr>';
    }

    $html .= '</table>';

      $html .= '
        <table style="width:100%; border:0;">
            <tr>
                <td class="label " style="text-align:left;"><h4>Issued At : '. format_date($applicant->issued_at) . '</h4></td>
                <td class="label" style="text-align:right;"><h4>Expires At : ' . format_date($applicant->expires_at) .'</h4></td>
            </tr>
        </table>';


         $html .= '
            <br><br>
            <br><br>
            <br><br>
            <table style="width:100%; border:0;">
                <tr>
                    <td class="label" style="text-align:left;">Date : ' . date('d-m-Y') . '</td>
                    <td class="label" style="text-align:right;">Issued By : ' . $applicant->issued_by . '</td>
                </tr>
            </table>';


    

    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
       
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);

        

        // Footer section
        $mpdf->SetFooter('
        <table style="width:100%; font-size:12px;">
            <tr>
                <td style="text-align:right;">TNELB</td>
                
            </tr>
        </table>
        ');

        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');

    
        
    }
    


    // -------------formsa print--------------------------------------------

    public function generateFormsaPDF($application_id)
    {
        // Fetch application details

       
        $application = DB::table('tnelb_esa_applications')->where('application_id', $application_id)->first();

        $appltype = trim($application->appl_type);
       
        if($appltype === 'N'){
                $applicant = DB::table('tnelb_license')
            ->join('tnelb_esa_applications', 'tnelb_license.application_id', '=', 'tnelb_esa_applications.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',
                'tnelb_esa_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_esa_applications.license_name',
                'tnelb_esa_applications.form_name',
                'tnelb_license.license_number'
            )
            ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderby('id')
            // ->where('staff_flag', 1)
            ->get();

        }else{
    $applicant = DB::table('tnelb_renewal_license')
            ->join('tnelb_esa_applications', 'tnelb_renewal_license.application_id', '=', 'tnelb_esa_applications.application_id')
            ->where('tnelb_renewal_license.application_id', $application_id)
            ->select(
                'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',
                'tnelb_esa_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_esa_applications.license_name',
                'tnelb_esa_applications.form_name',
                'tnelb_renewal_license.license_number'
            )
            ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderby('id')
            // ->where('staff_flag', 1)
            ->get();

        }
    

    
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }
    
        
        $payment = DB::table('payments')->where('application_id', $application_id)->first();
    
        // Initialize mPDF
        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        
        $mpdf->WriteHTML('<style>
        body {  }
        p, td, th { padding: 0px; }
        p 
        .tbl_center { text-align: center; }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: #332ec7; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:#423a3a;}
        .staff_tbl td{text-align:center;}
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        // Start building the PDF content
        $html = '
        <h3 style="text-align: center;" class="">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align: center;" class="">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align: center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align: center;" class="highlight_text"> Form ' . $applicant->form_name . ' License "' . $applicant->license_name . '"</h4>
        <h3  style="text-align: center;"><strong>License for Contractor Certificate</strong></h3>
        <h3 style="text-align: center;" class=""> License Number : <span class = "highlight_text">' . $applicant->license_number . '</span></h3>';
    
     if($appltype === 'N') 
     {
        $apply_type= "Fresh Application";
     }else{
        $apply_type= "Renewal Application";
     }

    
        $html .= '
        <h4 class="mt-2 highlight"> License Summary</h4>
        <table>
            <tr><th class="">Applicantion ID</th><td>' . $applicant->application_id . '</td></tr>
            <tr><th class="">Name of Electrical Contractor/s <br> licence  applied for </th><td>' . $applicant->name . '</td></tr>
            <tr><th class="">License Name</th><td>' . $applicant->license_name . '</td></tr>
            <tr><th class="">License Type</th><td>' . $apply_type . '</td></tr>
            <tr><th class="">Issued By</th><td>' . $applicant->issued_by . '</td></tr>
            <tr><th class="">Issued At</th><td>' . date('d-m-Y', strtotime($applicant->issued_at)) . '</td></tr>
            <tr><th class="">Expired At</th><td>' . date('d-m-Y', strtotime($applicant->expires_at)) . '</td></tr>
        </table>';

       $html .= '
<h4 class="mt-2 highlight">Details of Staff appointed under this Contractor License</h4>
<table class="staff_tbl" border="1">
    <tr>
        <th>S.No</th>
        <th>Staff Name</th>
        <th>Qualification </th>
        <th>Category </th>
        <th>Competency Certificate Number & Validity </th>
    </tr>';

    

    if ($staffDetails->count() > 0) {
        $i = 1;
        foreach ($staffDetails as $staff) {
            $html .= '
            <tr>
                <td>' . $i++ . '</td>
                <td>' . strtoupper($staff->staff_name) . '</td>
                <td>' . strtoupper($staff->staff_qualification) . '</td>
                <td>' . strtoupper($staff->staff_category) . '</td>
                <td>' . $staff->cc_number . ', ' . (!empty($staff->cc_validity) ? date('d-m-Y', strtotime($staff->cc_validity)) : 'N/A') . '</td>

            </tr>';
        }
    } else {
        $html .= '<tr><td colspan="5" style="text-align:center;">No staff found</td></tr>';
    }

    $html .= '</table>';

    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
        $html .= '
        <br>
       
        <p><strong>Date:</strong> ' . date('d-m-Y', strtotime($applicant->issued_at)) . '</p>';
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
    
        // Output PDF
        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
    // ------------------------



     // -------------formsa print--------------------------------------------

    public function generateFormsbPDF($application_id)
    {
        // Fetch application details

       
        $application = DB::table('tnelb_esb_applications')->where('application_id', $application_id)->first();

        $appltype = trim($application->appl_type);
       
        if($appltype === 'N'){
                $applicant = DB::table('tnelb_license')
            ->join('tnelb_esb_applications', 'tnelb_license.application_id', '=', 'tnelb_esb_applications.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',
                'tnelb_esb_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_esb_applications.license_name',
                'tnelb_esb_applications.form_name',
                'tnelb_license.license_number'
            )
            ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderby('id')
            // ->where('staff_flag', 1)
            ->get();

        }else{
    $applicant = DB::table('tnelb_renewal_license')
            ->join('tnelb_esb_applications', 'tnelb_renewal_license.application_id', '=', 'tnelb_esb_applications.application_id')
            ->where('tnelb_renewal_license.application_id', $application_id)
            ->select(
                'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',
                'tnelb_esb_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_esb_applications.license_name',
                'tnelb_esb_applications.form_name',
                'tnelb_renewal_license.license_number'
            )
            ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderby('id')
            // ->where('staff_flag', 1)
            ->get();

        }
    

    
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }
    
        
        $payment = DB::table('payments')->where('application_id', $application_id)->first();
    
        // Initialize mPDF
        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        
        $mpdf->WriteHTML('<style>
        body {  }
        p, td, th { padding: 0px; }
        p 
        .tbl_center { text-align: center; }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: #423a3a; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:#423a3a;}
        .staff_tbl td{text-align:center;}
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        // Start building the PDF content
        $html = '
        <h3 style="text-align: center;" class="">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align: center;" class="">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align: center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align: center;" class="highlight_text"> Form ' . $applicant->form_name . ' License "' . $applicant->license_name . '"</h4>
        <h3  style="text-align: center;"><strong>License for Contractor Certificate</strong></h3>
        <h3 style="text-align: center;" class=""> License Number : <span class = "highlight_text">' . $applicant->license_number . '</span></h3>';
    
     if($appltype === 'N') 
     {
        $apply_type= "Fresh Application";
     }else{
        $apply_type= "Renewal Application";
     }

    
        $html .= '
        <h4 class="mt-2 highlight"> License Summary</h4>
        <table>
            <tr><th class="">Applicantion ID</th><td>' . $applicant->application_id . '</td></tr>
            <tr><th class="">Name of Electrical Contractor/s <br> licence  applied for </th><td>' . $applicant->name . '</td></tr>
            <tr><th class="">License Name</th><td>' . $applicant->license_name . '</td></tr>
            <tr><th class="">License Type</th><td>' . $apply_type . '</td></tr>
            <tr><th class="">Issued By</th><td>' . $applicant->issued_by . '</td></tr>
            <tr><th class="">Issued At</th><td>' . date('d-m-Y', strtotime($applicant->issued_at)) . '</td></tr>
            <tr><th class="">Expired At</th><td>' . date('d-m-Y', strtotime($applicant->expires_at)) . '</td></tr>
        </table>';

       $html .= '
<h4 class="mt-2 highlight">Details of Staff appointed under this Contractor License</h4>
<table class="staff_tbl" border="1">
    <tr>
        <th>S.No</th>
        <th>Staff Name</th>
        <th>Qualification </th>
        <th>Category </th>
        <th>Competency Certificate Number & Validity </th>
    </tr>';

if ($staffDetails->count() > 0) {
    $i = 1;
    foreach ($staffDetails as $staff) {
        $html .= '
        <tr>
            <td>' . $i++ . '</td>
            <td>' . strtoupper($staff->staff_name) . '</td>
            <td>' . strtoupper($staff->staff_qualification) . '</td>
            <td>' . strtoupper($staff->staff_category) . '</td>
            <td>' . $staff->cc_number . ', ' . (!empty($staff->cc_validity) ? date('d-m-Y', strtotime($staff->cc_validity)) : 'N/A') . '</td>

        </tr>';
    }
} else {
    $html .= '<tr><td colspan="5" style="text-align:center;">No staff found</td></tr>';
}

$html .= '</table>';

    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
        $html .= '
        <br>
       
        <p><strong>Date:</strong> ' . date('d-m-Y', strtotime($applicant->issued_at)) . '</p>';
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
    
        // Output PDF
        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
    // ------------------------



     public function generateFormbPDF($application_id)
    {
        // Fetch application details

       
        $application = DB::table('tnelb_eb_applications')->where('application_id', $application_id)->first();

     

        $appltype = trim($application->appl_type);
      
        if($appltype === 'N'){
                $applicant = DB::table('tnelb_license')
            ->join('tnelb_eb_applications', 'tnelb_license.application_id', '=', 'tnelb_eb_applications.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',
                'tnelb_eb_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_eb_applications.license_name',
                'tnelb_eb_applications.form_name',
                'tnelb_license.license_number'
            )
            ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderby('id')
            // ->where('staff_flag', 1)
            ->get();

        }else{
    $applicant = DB::table('tnelb_renewal_license')
            ->join('tnelb_eb_applications', 'tnelb_renewal_license.application_id', '=', 'tnelb_esb_applications.application_id')
            ->where('tnelb_renewal_license.application_id', $application_id)
            ->select(
                'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',
                'tnelb_esb_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_eb_applications.license_name',
                'tnelb_eb_applications.form_name',
                'tnelb_renewal_license.license_number'
            )
            ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
            ->where('application_id', $application_id)
            ->orderby('id')
            // ->where('staff_flag', 1)
            ->get();

        }
    

    
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }
    
        
        $payment = DB::table('payments')->where('application_id', $application_id)->first();
    
        // Initialize mPDF
        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        
        $mpdf->WriteHTML('<style>
        body {  }
        p, td, th { padding: 0px; }
        p 
        .tbl_center { text-align: center; }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: #423a3a; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:#423a3a;}
        .staff_tbl td{text-align:center;}
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        // Start building the PDF content
        $html = '
        <h3 style="text-align: center;" class="">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align: center;" class="">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align: center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align: center;" class="highlight_text"> Form ' . $applicant->form_name . ' License "' . $applicant->license_name . '"</h4>
        <h3  style="text-align: center;"><strong>License for Contractor Certificate</strong></h3>
        <h3 style="text-align: center;" class=""> License Number : <span class = "highlight_text">' . $applicant->license_number . '</span></h3>';
    
     if($appltype === 'N') 
     {
        $apply_type= "Fresh Application";
     }else{
        $apply_type= "Renewal Application";
     }

    
        $html .= '
        <h4 class="mt-2 highlight"> License Summary</h4>
        <table>
            <tr><th class="">Applicantion ID</th><td>' . $applicant->application_id . '</td></tr>
            <tr><th class="">Name of Electrical Contractor/s <br> licence  applied for </th><td>' . $applicant->name . '</td></tr>
            <tr><th class="">License Name</th><td>' . $applicant->license_name . '</td></tr>
            <tr><th class="">License Type</th><td>' . $apply_type . '</td></tr>
            <tr><th class="">Issued By</th><td>' . $applicant->issued_by . '</td></tr>
            <tr><th class="">Issued At</th><td>' . date('d-m-Y', strtotime($applicant->issued_at)) . '</td></tr>
            <tr><th class="">Expired At</th><td>' . date('d-m-Y', strtotime($applicant->expires_at)) . '</td></tr>
        </table>';

       $html .= '
<h4 class="mt-2 highlight">Details of Staff appointed under this Contractor License</h4>
<table class="staff_tbl" border="1">
    <tr>
        <th>S.No</th>
        <th>Staff Name</th>
        <th>Qualification </th>
        <th>Category </th>
        <th>Competency Certificate Number & Validity </th>
    </tr>';

if ($staffDetails->count() > 0) {
    $i = 1;
    foreach ($staffDetails as $staff) {
        $html .= '
        <tr>
            <td>' . $i++ . '</td>
            <td>' . strtoupper($staff->staff_name) . '</td>
            <td>' . strtoupper($staff->staff_qualification) . '</td>
            <td>' . strtoupper($staff->staff_category) . '</td>
            <td>' . $staff->cc_number . ', ' . (!empty($staff->cc_validity) ? date('d-m-Y', strtotime($staff->cc_validity)) : 'N/A') . '</td>

        </tr>';
    }
} else {
    $html .= '<tr><td colspan="5" style="text-align:center;">No staff found</td></tr>';
}

$html .= '</table>';

    
        
        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';
    
        // Declaration
        $html .= '
        <br>
       
        <p><strong>Date:</strong> ' . date('d-m-Y', strtotime($applicant->issued_at)) . '</p>';
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
    
        // Output PDF
        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }


    public function generateFormaPDF1($application_id)
    {
         $application = DB::table('tnelb_ea_applications')
        ->where('application_id', $application_id)
        ->first();
      
       $appl_type = preg_replace('/\s+/', '', $application->appl_type);

        if ($application && $appl_type === 'R') {
            // Renewal application → use tnelb_renewal_license
            $applicant = DB::table('tnelb_ea_applications')
                ->join('tnelb_renewal_license', 'tnelb_renewal_license.application_id', '=', 'tnelb_ea_applications.application_id')
                ->where('tnelb_ea_applications.application_id', $application_id)
                ->select(
                   'tnelb_renewal_license.application_id',
                'tnelb_renewal_license.issued_by',
                'tnelb_renewal_license.issued_at',
                'tnelb_renewal_license.expires_at',
                'tnelb_ea_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_ea_applications.license_name',
                'tnelb_ea_applications.form_name',
                'tnelb_renewal_license.license_number'
                )
                ->first();
        } else {
        // Fetch application details
        $applicant = DB::table('tnelb_license')
            ->join('tnelb_ea_applications', 'tnelb_license.application_id', '=', 'tnelb_ea_applications.application_id')
            ->where('tnelb_license.application_id', $application_id)
            ->select(
                'tnelb_license.application_id',
                'tnelb_license.issued_by',
                'tnelb_license.issued_at',
                'tnelb_license.expires_at',
                'tnelb_ea_applications.applicant_name AS name',
                // 'tnelb_applicant_formA.fathers_name',
                // 'tnelb_applicant_formA.applicants_address',
                // 'tnelb_applicant_formA.d_o_b',
                // 'tnelb_applicant_formA.age',
                'tnelb_ea_applications.license_name',
                'tnelb_ea_applications.form_name',
                'tnelb_license.license_number'
            )
            ->first();
        }
    
        if (!$applicant) {
            return back()->with('error', 'Application not found.');
        }
    
        
        $payment = DB::table('payments')->where('application_id', $application_id)->first();
    
        // Initialize mPDF
        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetTitle('TNELB Application License ' . $applicant->license_name);

        
        $mpdf->WriteHTML('<style>
        body { line-height: 1.5; }
        p, td, th { padding: 5px; }
        .tbl_center { text-align: center; }
        .mt-2 { margin-top: 10px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; }
        .highlight { font-weight: bold; color: white; background-color: green; padding: 5px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        // Start building the PDF content
        $html = '
        <h3 style="text-align: center;" class="">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align: center;" class="">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align: center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align: center;" class=""> Form ' . $applicant->form_name . ' License "' . $applicant->license_name . '"</h4>
        <p style="text-align: center;">License for Contractor Certificate</p>
        <h3 style="text-align: center;" class="">' . $applicant->license_number . '</h3>';
    
    

    
        $html .= '
        <h4 class="mt-2 "> License Summary</h4>
        <table>
            <tr><th class="highlight">Applicant ID</th><td>' . $applicant->application_id . '</td></tr>
            <tr><th class="highlight">Name</th><td>' . $applicant->name . '</td></tr>
            <tr><th class="highlight">License Name</th><td>' . $applicant->license_name . '</td></tr>
            <tr><th class="highlight">Issued By</th><td>' . $applicant->issued_by . '</td></tr>
            <tr><th class="highlight">Issued At</th><td>' . $applicant->issued_at . '</td></tr>
            <tr><th class="highlight">Expired At</th><td>' . $applicant->expires_at . '</td></tr>
        </table>';
    
        
        $html .= '<h4 class="mt-2 "> Payment Details</h4>
        <table class="tbl_center">
            <tr>
                <th class="highlight">Bank Name</th>
                <th class="highlight">Mode of Payment</th>
                <th class="highlight">Amount</th>
                <th class="highlight">Payment Date</th>
                <th class="highlight">Transaction ID</th>
            </tr>
            <tr>
                <td>State Bank of India</td>
                <td>UPI</td>
                <td>' . ($payment->amount ?? 'N/A') . '</td>
                <td>25-02-2025</td>
                <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
            </tr>
        </table>';
    
        // Declaration
        $html .= '
        <br>
        <p><strong>Place:</strong> Chennai</p>
        <p><strong>Date:</strong> ' . date('d-m-Y') . '</p>';
    
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
    
        // Output PDF
        return response($mpdf->Output('Application_Details.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
    

    // -------------License tamil pdf------------------------

    // -----------for all contractor license generateFormcontractor_download-------------------

    public function generateFormcontractor_download_tamil($application_id)
    {

        // dd('Tamil');
        // exit;
        // ---------------------------------------
        // 1. DETECT WHICH TABLE HAS THE APPLICATION
        // ---------------------------------------
        $application = null;
        $table_name = null;

        $tables = [
            'tnelb_esa_applications',
            'tnelb_esb_applications',
            'tnelb_eb_applications',
            'tnelb_ea_applications'
        ];

        foreach ($tables as $t) {
            $record = DB::table($t)
                ->where('application_id', $application_id)
                ->first();

            if ($record) {
                $application = $record;
                $table_name = $t;
                break;
            }
        }

        // dd($application->license_name);
        // exit;

        $licence_id = DB::table('mst_licences')
            ->where('cert_licence_code', $application->license_name)
            ->first();

        // dd($licence_id->id);
        // exit;


        // dd($equipment_list->first()->equip_name);
        // exit;


        if (!$application) {
            return back()->with('error', 'Application ID not found.');
        }

        // Clean appl_type
        $appltype = strtoupper(trim($application->appl_type));


        // ---------------------------------------
        // 2. FRESH APPLICATION (appl_type = N)
        // ---------------------------------------
        if ($appltype === 'N') {

            $applicant = DB::table('tnelb_license')
                ->join($table_name, 'tnelb_license.application_id', '=', $table_name . '.application_id')
                ->where('tnelb_license.application_id', $application_id)
                ->select(
                    'tnelb_license.application_id',
                    'tnelb_license.issued_by',
                    'tnelb_license.issued_at',
                    'tnelb_license.expires_at',

                    $table_name . '.applicant_name AS name',
                    $table_name . '.license_name',
                    $table_name . '.form_name',

                    'tnelb_license.license_number'
                )
                ->first();

            $staffDetails = DB::table('tnelb_applicant_cl_staffdetails')
                ->where('application_id', $application_id)
                ->orderBy('id')
                ->get();
        }

        // ---------------------------------------
        // 3. RENEWAL APPLICATION
        // ---------------------------------------
        else {

            $applicant = DB::table('tnelb_renewal_license')
                ->join($table_name, 'tnelb_renewal_license.application_id', '=', $table_name . '.application_id')
                ->where('tnelb_renewal_license.application_id', $application_id)
                ->select(
                    'tnelb_renewal_license.application_id',
                    'tnelb_renewal_license.issued_by',
                    'tnelb_renewal_license.issued_at',
                    'tnelb_renewal_license.expires_at',

                    $table_name . '.applicant_name AS name',
                    $table_name . '.license_name',
                    $table_name . '.form_name',

                    'tnelb_renewal_license.license_number'
                )
                ->first();

            $staffDetails = DB::table('tnelb_applicant_formA_staffdetails')
                ->where('application_id', $application_id)
                ->orderBy('id')
                ->get();
        }




        // ---------------------------------------
        // 4. RETURN OR LOAD PDF VIEW
        // ---------------------------------------

        // $mpdf = new Mpdf([
        //     'format' => [210, 175],
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        //     'default_font_size' => 10,
        //     'default_font' => 'marutham'

        // ]);
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
              'format' => [210, 175],
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            
            'mode' => 'utf-8',

            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'),
            ]),

            'fontdata' => $fontData + [
                'marutham' => [
                    'R' => 'Marutham.ttf',
                ],
            ],

            'default_font' => 'marutham',

            'autoScriptToLang' => true,
            'autoLangToFont'   => true,
        ]);





        $mpdf->SetTitle('TNELB Application License ' . $applicant->form_name);

        $formname = $applicant->form_name;

        // dd($formname);
        // exit;

        $license_name = DB::table('mst_licences')->where('form_code', $formname)->first();


        // dd($license_name);
        // exit;

        $mpdf->WriteHTML('<style>

            .english_font{ font-family:helvetica!important;}
        body { font-weight:bold;}
        .ta_font{font-size:15px;}
        p, td, th { padding: 0px;  }
        h3 { padding: 0px; font-weight:bold; }
        .fw-bold{}
        p {}
        .tbl_center { text-align: center;!important }
        .mt-2 { margin-top: 5; }
        table { border-collapse: collapse; width: 100%; }
        th, td {  padding: 8px; text-align:left; }
        .highlight { font-weight: bold; color: white; background-color: green; padding: 5px; text-align:center; font-size:16px; }
        .photo-container { text-align: right; padding-right: 10px; }
        .photo-container img { width: 132px; height: 170px; border: 1px solid #000; object-fit: cover; display: block; }
        .highlight_text{color:green;}
        .staff_tbl td{text-align:center;}
        .license_name{ font-size:15px;text-align:center;font-weight:bold; text-decoration:underline;}
        .font-weight{font-weight:bold;}
        .blue{color:#074282;}
        .orange{color:#ec4b05;}
        .txt_uppercase{text-transform:uppercase;}
        .line-height-30{line-height:20px;}
        .text-indent-40 {text-indent: 40px;}
        .text-indent-60 {text-indent: 50px;}
        .text-justify {text-align: justify;}
        .font-size-14{ font-size:13px;}
        .mb-5{margin-bottom:5px;}
        .mb-1{margin-bottom:1px;}
        .mb-10{margin-bottom:10px;}
        .pb-10{padding: bottom 10px!important;}
        .pb-5{padding: bottom 5px!important;}
        .mt-5{margin-top:5px;}
        .mt-1{margin-top:1px;}
        .text-black{color:black;}
        
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
        $grade_name = $applicant->license_name;
        // dd($grade_name);
        // exit;

        if ($grade_name == 'EA') {
            $grade_name_txt = '"இஏ" கிரேடு மின் ஒப்பந்தக்காரர் உரிமம்';
        } elseif ($grade_name == 'ESA') {
            $grade_name_txt = '"இஎஸ்ஏ" கிரேடு மின் ஒப்பந்தக்காரர் உரிமம்';
        } elseif ($grade_name == 'ESB') {
            $grade_name_txt = '"இஎஸ்பி" கிரேடு மின் ஒப்பந்தக்காரர் உரிமம்';
        } elseif ($grade_name == 'EB') {
            $grade_name_txt = '"இபி" கிரேடு மின் ஒப்பந்தக்காரர் உரிமம்';
        }
        $qrData = url('/verify-certificate/' . $applicant->application_id);



        // Start building the PDF content
        $html = '
        <table width="100%" class="mt-1 mb-1">
            <tr>
                <!-- LEFT CONTENT -->
                <td  style="text-align:center; padding-top:10px;">

                    <div class="header-block">
                        <h3 class="blue mb-5 pb-5 ta_font  fw-bold " style="font-weight:bold">தமிழ்நாடு அரசு</h3>
                        <br>

                        <h3 class="blue mb-5 pb-5 ta_font  fw-bold">மின் உரிமம் வழங்கும் வாரியம்</h3>
                        <br>

                        <p class="blue mb-5 pb-5 ta_font  fw-bold">
                        திரு.வி.க. தொழிற்பேட்டை, கிண்டி, சென்னை -600 032.
                        </p>
                        <br>

                        <p class="license_name orange mt-10">
                            ' . $grade_name_txt . '
                        </p>
                    </div>

                </td>

                <!-- RIGHT QR -->
                <td width="10%" style="text-align:right; vertical-align:top; padding-top:10px;">
                    <barcode 
                        code="' . htmlspecialchars($qrData) . '" 
                        type="QR" 
                        size="1"
                        error="H"
                    />
                </td>

        
            </tr>
        </table>';





        $html .= '
        <table style="width:100%; border:0; mt-1 mb-1">
            <tr>
                <td class="label " style="text-align:left;"><h4 class="orange ta_font  ">உரிமம் எண்: <span class="font-size-14">' . $applicant->license_number . '</span></h4></td>
                <td class="label" style="text-align:right;"><h4 class="orange  ">வழங்கிய நாள் : ' . format_date($applicant->issued_at) . '</h4></td>
            </tr>
        </table>';

        if ($grade_name == 'ESB' || $grade_name == 'EB') {
            $grade_name_txt = 'EA Grade Contractor Licence';

            $html .= '<p class="mt-1 mb-1 line-height-30 ta_font blue font-weight text-indent-40 text-justify"> திரு /திருவாளர்கள் <span class="text-black font-size-14"> ' . $applicant->name . ' (Application ID. ' . $applicant->application_id . ') </span> தமிழ்நாட்டில் உள்ள குறைந்த மற்றும் நடுத்தர மின்னழுத்த பயனீட்டாளர்களின் மின் அமைப்பு வேலைகளை 50 கி.வா (63 கே.வி.ஏ மின்னாக்கி) க்கு மிகாமல் மட்டும் மேற்கொள்ள உரிமம் வழங்கப்படுகிறது. 1956-ம் வருடத்திய இந்திய மின்விதிகளில் விதி 45(1)ன் கீழ் தமிழக அரசால் கீழ்கண்ட அரசாணைகளில் ஒப்புதலளிக்கப்பட்ட மின் உரிமம் வழங்கும் வாரியத்தின் ஒழுங்குமுறை விதிகளின்படி இந்த உரிமம் வழங்கப்படுகிறது. </p>';
        } else {

            $html .= '<p class="mt-1 mb-1 line-height-30 ta_font blue font-weight text-indent-40 text-justify"> திரு/திருவாளர்கள் <span class="text-black font-size-14"> ' . $applicant->name . ' (Application ID. ' . $applicant->application_id . ') </span> அவர்கள், தமிழ்நாட்டில் உயர் மின்னழுத்தம்,
            மத்திய மின்னழுத்தம் மற்றும் குறைந்த மின்னழுத்த மின் வேலைகளைச் செய்வதற்கு இதன்மூலம் அங்கீகரிக்கப்படுகிறார்கள். இந்த உரிமம், இந்திய மின்சார விதிகள் 1956-இன் விதி 45(1)-இன் கீழ், பின்வரும் அரசாணைகளில் தமிழ்நாடு அரசால் வெளியிடப்பட்ட விதிமுறைகளின்படி வழங்கப்படுகிறது.</p>';
        }

        $html .= '
        <p class="mt-5 mb-5 blue font-size-14 font-weight  text-indent-60 ta_font">1. அ.ஆணை எண். <span class="font-size-14">M.S.No. 1246 </span>  பொது பணித்துறை நாள் 31.3.1955 </p>
        <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60 ta_font">2. அ.ஆணை எண். <span class="font-size-14">M.S.No. 1983</span> பொது பணித்துறை நாள் 7.10.1987 </p>
         <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60 ta_font">3. அ.ஆணை எண். <span class="font-size-14">M.S.No. 2744 </span>பொது பணித்துறை நாள் 24.12.1990 </p>
         <p class="mt-5 mb-5 blue font-weight font-size-14 text-indent-60 ta_font">4. அ.ஆணை எண். <span class="font-size-14"> M.S.No.27 </span>எரிசக்தி <span class="font-size-14">(B.)</span> துறை நாள் 08.03.2000 </p>';

        $html .= '<p class=" mb-1 orange  font-weight  text-indent-60 ta_font ">இந்த உரிமம் செல்லுபடியாகும் காலம் :</p>';



        $proprietors = DB::table('proprietordetailsform_A')
            ->where('application_id', $application_id)
            ->where('proprietor_flag', '1')
            ->orderBy('id')
            ->get();

        $html .= '
        <table style="width:100%; border:0;" class="mt-1 mb-1">
            <tr>
                <td class="label blue txt_uppercase" style="text-align:left;">
                    <h4 class="ta_font">உரிமதாரர் / பங்குதாரர் பெயர் </h4>
                </td>
                <td> : </td>
                <td><span class="font-size-14">
            ';

        if ($proprietors->count() > 0) {
            foreach ($proprietors as $proprietor) {
                $html .= '
                
                        ' . strtoupper($proprietor->proprietor_name) . ',
                ';
            }
        } else {
            $html .= '
            —';
        }

        $html .= '</span>
        </td>
        </tr>
        <tr>
        <td class="label blue txt_uppercase" style="text-align:left;">
                    <h4 class="ta_font">அங்கீகாரம் பெற்றவர் பெயர்
மற்றும் மாதிரி ஒப்பம் </h4>  </td>
        <td> : </td>
        <td> Authorized Person Name </td>
        
        </tr>
        </table>';


        $html .= '
           <br><br>
         
            <table style="width:100%; border:0;" class="mt-1 mb-1">
                <tr>
                    <td class="label ta_font blue font-weight" style="text-align:left;">செயலாளர் </td>
                    <td class="label ta_font blue font-weight" style="text-align:right;">தலைவர்</td>
                </tr>
            </table>';



        $html .= "<pagebreak />";


        $html .= '
        <h4 class="mt-2 orange ta_font font-weight english_font">பணியாளர் விவரங்கள்</h4>
        <table style="width = 50%" class="english_font" >';

        if ($staffDetails->count() > 0) {
            $i = 1;
            foreach ($staffDetails as $staff) {

                $dates = \App\Http\Controllers\Admin\LicensepdfController::getStaffExpiryDate(
                    $staff->cc_number
                );

                $html .= '
                    <tr>
                        <td>' . $i++ . ') ' . strtoupper($staff->staff_name) . ' - ' . $staff->cc_number .  '  Valid From : ' . $dates['valid_from'] . ' Valid Upto : ' . $dates['valid_upto'] . '</td>
                      
                    </tr>';
            }
        }
        $html .= '</table>';

        $equiplist = DB::table('mst_equipment_tbls')
            ->where('equip_licence_name', $licence_id->id)
            ->orderBy('id')
            ->get();

        $equipmentlist = DB::table('equipmentforma_tbls')
            ->where('application_id', $application_id)
            ->get();

        // dd($equipmentlist->first()->licence_id);
        // exit;

        /* Map equip_id => equipment_value */
        $equipmentMap = $equipmentlist->pluck('equipment_value', 'equip_id')
            ->toArray();

        $html .= '
<h4 class="mt-2 orange font-size-14 font-weight">
    உபகரணங்கள் / கருவிகளின் விவரங்கள்
</h4>
<table class="english_font" style="width=50%">';
        $licenceId = optional($equipmentlist->first())->licence_id;
        if ($equiplist->count() > 0) {

            $i = 1;

            foreach ($equiplist as $index => $equip) {


                if ($equip->equip_licence_name == $licenceId) {

                    $equipmentValue = $equipmentMap[$equip->id] ?? 'N/A';

                    $html .= '
        <tr>
            <td>' . $i++ . ') ' . strtoupper($equip->equip_name) . '</td>
            <td>' . strtoupper($equipmentValue) . '</td>
        </tr>';
                }
            }
        } else {

            $html .= '
    <tr>
        <td colspan="2" style="text-align:center;">No equipment found</td>
    </tr>';
        }

        $html .= '</table>';




        // $html .= '
        // <h4 class="mt-2  orange font-size-14 font-weight">Equipment / Instrument</h4>
        // <table class="" >
        // ';

        //     if ($equipment_list->count() > 0) {
        //         $i = 1;
        //         foreach ($equipment_list as $equipment) {
        //             $html .= '
        //             <tr>
        //                 <td>' . $i++  .') '. strtoupper($equipment->staff_name) . '-  '   .  $staff->cc_number  .'</td>


        //             </tr>';
        //         }
        //     } else {
        //         $html .= '<tr><td colspan="5" style="text-align:center;">No staff found</td></tr>';
        //     }

        //     $html .= '</table>';


        // $html .= '<h4 class="mt-2 highlight"> Payment Details</h4>
        // <table class="tbl_center bank">
        //     <tr>
        //         <th class="">Bank Name</th>
        //         <th class="">Mode of Payment</th>
        //         <th class="">Amount</th>
        //         <th class="">Payment Date</th>
        //         <th class="">Transaction ID</th>
        //     </tr>
        //     <tr>
        //         <td>State Bank of India</td>
        //         <td>UPI</td>
        //         <td>' . ($payment->amount ?? 'N/A') . '</td>
        //         <td>25-02-2025</td>
        //         <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
        //     </tr>
        // </table>';

        // Declaration


        // Write HTML to PDF
        $mpdf->WriteHTML($html);



        // Footer section
        $mpdf->SetFooter('
        <table style="width:100%; font-size:12px;">
            <tr>
                <td style="text-align:left;">TNELB</td>
                <td class="label" style="text-align:right;">Date : ' . date('d-m-Y') . '</td>
                
            </tr>
        </table>
        ');

        return response($mpdf->Output('License_A_approval.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }



    
    
  public static function getStaffExpiryDate($ccNumber)
{
    // Default response (NIL)
    $default = [
        'valid_from' => 'NIL',
        'valid_upto' => 'NIL'
    ];

    if (empty($ccNumber)) {
        return $default;
    }

    // Get first character (B / H / C)
    $type = strtoupper(substr(trim($ccNumber), 0, 1));

    $tableMap = [
        'B' => 'wcert',
        'H' => 'whcert',
        'C' => 'scert'
    ];

    // Invalid certificate type
    if (!isset($tableMap[$type])) {
        return $default;
    }

    // Extract numeric part (B123 → 123)
    $certNo = preg_replace('/\D/', '', $ccNumber);

    if (empty($certNo)) {
        return $default;
    }

    /* -------------------------------------------------
     * 1️⃣ Renewal license (highest priority)
     * ------------------------------------------------- */
    $renewal = DB::table('tnelb_renewal_license')
        ->select('issued_at', 'expires_at')
        ->where('license_number', $certNo)
        ->orderBy('expires_at', 'desc')
        ->first();

    if ($renewal) {
        return [
            'valid_from' => date('d-m-Y', strtotime($renewal->issued_at)),
            'valid_upto' => date('d-m-Y', strtotime($renewal->expires_at)),
        ];
    }

    /* -------------------------------------------------
     * 2️⃣ New license
     * ------------------------------------------------- */
    $license = DB::table('tnelb_license')
        ->select('issued_at', 'expires_at')
        ->where('license_number', $certNo)
        ->orderBy('expires_at', 'desc')
        ->first();

    if ($license) {
        return [
            'valid_from' => date('d-m-Y', strtotime($license->issued_at)),
            'valid_upto' => date('d-m-Y', strtotime($license->expires_at)),
        ];
    }

    /* -------------------------------------------------
     * 3️⃣ Certificate table fallback
     * ------------------------------------------------- */
    $cert = DB::table($tableMap[$type])
        ->select('frdate1', 'vdate')
        ->where('certno', $certNo)
        ->orderBy('vdate', 'desc')
        ->first();

    if ($cert) {
        return [
            'valid_from' => date('d-m-Y', strtotime($cert->frdate1)),
            'valid_upto' => date('d-m-Y', strtotime($cert->vdate)),
        ];
    }

    // ❗ Not found anywhere → NIL
    return $default;
}


}
