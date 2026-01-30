<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mst_Form_s_w;
use App\Models\Mst_education;
use App\Models\Mst_experience;
use App\Models\Mst_documents;
use App\Models\TnelbApplicantPhoto;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use TCPDF;
use Mpdf\Mpdf;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PDFRenewalController extends Controller
{
    public function generaterenewalPDF($newApplicationId)
    {
        $form = Mst_Form_s_w::where('application_id', $newApplicationId)->firstOrFail();


        $education = Mst_education::where('application_id', $newApplicationId)->get();

        if ($education->isEmpty()) {
            $education = Mst_education::where('application_id', $form->old_application)->get();
        }


        $experience = Mst_experience::where('application_id', $newApplicationId)->get();

        if ($experience->isEmpty()) {
            $experience = Mst_experience::where('application_id', $form->old_application)->get();
        }
        
        
        $documents = Mst_documents::where('application_id', $newApplicationId)->get();

        $applicant_photo = TnelbApplicantPhoto::where('application_id', $newApplicationId)->get();

        if ($applicant_photo->isEmpty()) {
            $applicant_photo = TnelbApplicantPhoto::where('application_id', $form->old_application)->get();
        }

        
        if ($applicant_photo->isNotEmpty()) {
            $applicant_photo = $applicant_photo->first()->upload_path;
        }

        // var_dump($applicant_photo);die;



        $decryptedaadhar = Crypt::decryptString($form->aadhaar);
        $decryptedpan = Crypt::decryptString($form->pancard);
        if (strlen($decryptedaadhar) === 12) {
            $masked = str_repeat('X', 8) . substr($decryptedaadhar, -4);
        } else {
            $masked = 'Invalid Aadhaar';
        }
        if (strlen($decryptedpan) === 10) {
            $maskedPan = str_repeat('X', 6) . substr($decryptedpan, -4);
        } else {
            $maskedPan = 'Invalid PAN';
        }


        $payment = DB::table('payments')->where('application_id', $form->old_application)->first();


        if (!$form) {
            return redirect()->back()->with('error', 'No records found!');
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 10,
            'default_font' => 'helvetica',
        ]);
    
        $mpdf->WriteHTML('
        <style>
            body { font-family: helvetica, sans-serif; font-size: 10pt; line-height: 1.4; }
            h3, h4, p { margin: 4px 0; }
            table { border-collapse: collapse; width: 100%; margin-top: 6px; }
            td, th { padding: 4px; vertical-align: top; }
            .label { width: 35%; text-align: left; font-weight: bold; }
            .value { width: 40%; text-align: left; }
            .tbl-bordered td, .tbl-bordered th { border: 1px solid #000; text-align: center; }
            .tbl-no-border td { border: none; padding-bottom: 12px; } /* ⬅ spacing between rows */
            .photo-cell { text-align:center; }
        </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        $certificateText = match ($form->form_name) {
            'S' => 'Application for Supervisor Competency Certificate',
            'W' => 'Application for Wireman Competency Certificate',
            'WH' => 'Application for Wireman Helper Competency Certificate',
            default => 'Application for Competency Certificate',
        };
    
        $html = '
        <h3 style="text-align:center;">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align:center;">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align:center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align:center;">Form "' . $form->license_name . '"</h4>
        <p style="text-align:center;">' . $certificateText . '</p>
        <h4 style="text-align:center;">Application Number: <strong>' . $form->application_id . '</strong></h4>';
    
        $html .= '<table class="tbl-no-border">
        <tr>
            <td class="label">1. Name of the applicant</td>
            <td class="value">: ' . $form->applicant_name . '</td>
            <td rowspan="5" class="photo-cell">';
    
        if ($applicant_photo && file_exists(public_path($applicant_photo))) {
            $html .= '<img src="' . public_path($applicant_photo) . '" style="width:120px; height:150px; border:1px solid;">';
        } else {
            $html .= '<p>No Photo</p>';
        }
    
        $html .= '</td></tr>
        <tr>
            <td class="label">2. Father\'s Name</td>
            <td class="value">: ' . $form->fathers_name . '</td>
        </tr>
        <tr>
            <td class="label">3. Address</td>
                <td class="value" colspan="2">
                <table style="border: none; width: 100%;">
                    <tr>
                        <td style="width: 10px;">:</td>
                        <td style="text-align: left;">
                            ' . nl2br(htmlentities($form->applicants_address)) . '
                        </td>
                    </tr>
                </table>
             </td>
        </tr>
        <tr>
            <td class="label">4. Date of Birth & Age</td>
            <td class="value">: ' . $form->d_o_b . ' (' . $form->age . ' years)</td>
        </tr>
        </table>';
    
        // Education
        $html .= '<h4>5. Educational Details</h4>
        <table class="tbl-bordered">
        <tr>
        <th>S.No</th><th>Education Level</th><th>Institution</th><th>Year of Passing</th><th>Percentage</th>
        </tr>';
        foreach ($education as $i => $edu) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $edu->educational_level . '</td>
                <td>' . $edu->institute_name . '</td>
                <td>' . $edu->year_of_passing . '</td>
                <td>' . $edu->percentage . '%</td>
            </tr>';
        }
        $html .= '</table>';
    
        // Experience
        $html .= '<h4>6. Work Experience</h4>
        <table class="tbl-bordered">
        <tr>
        <th>S.No</th><th>Company Name</th><th>Experience (Years)</th><th>Designation</th>
        </tr>';
        foreach ($experience as $i => $exp) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $exp->company_name . '</td>
                <td>' . $exp->experience . '</td>
                <td>' . $exp->designation . '</td>
            </tr>';
        }
        $html .= '</table>';
    
        // Aadhaar, PAN and others
        $previously = ($form->previously_number && $form->previously_date) ? $form->previously_number . ', ' . $form->previously_date : 'NO';
        $wireman_details = $form->wireman_details ?: 'NO';
    
        $html .= '<table width="100%" cellpadding="5" cellspacing="0" style="margin-top:10px;">';
        $html .= '<tr><td width="70%"><strong>7. Have you made any previous application? If so, state Reference Number and Date</strong></td><td>: ' . $form->previously_number.' , '. format_date($form->previously_date) . '</td></tr>';
        $html .= '<tr><td><strong>8. Do you possess Wireman C.C / Helper C.C? If yes, furnish details</strong></td><td>: ' . $wireman_details . '</td></tr>';
        $html .= '<tr><td><strong>9. Aadhaar Number</strong></td><td>: ' . $masked . '</td></tr>';
        $html .= '<tr><td><strong>10. PAN Number</strong></td><td>: ' . $maskedPan . '</td></tr>';
        $html .= '</table>';
    
        $html .= '<p class="mt-2">I hereby declare that all details mentioned above are correct and true to the best of my knowledge. I request that I may be granted a Supervisor Competency Certificate.</p>
        <br><br><br>
        <p><strong>Place:</strong> Chennai</p>
        <p><strong>Date:</strong> ' . date('d-m-Y') . '</p>
        <p style="text-align:right;"><strong>Signature of the Candidate</strong></p>';
    
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('Application_Details.pdf', 'I'))->header('Content-Type', 'application/pdf');
    }

    public function generatetcp($newApplicationId)
    {
        // Fetch form details
        $form = Mst_Form_s_w::where('application_id', $newApplicationId)->first();
        $education = Mst_education::where('application_id', $newApplicationId)->get();
        $experience = Mst_experience::where('application_id', $newApplicationId)->get();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $newApplicationId)->first();
        // $documents = Mst_documents::where('application_id', $newApplicationId)->first();
        $payment = DB::table('payments')->where('application_id', $newApplicationId)->first();

        if (!$form) {
            return redirect()->back()->with('error', 'No records found!');
        }

        // Create a new TCPDF instance
        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetCreator('TNELB');
        $pdf->SetAuthor('Your App');
        $pdf->SetTitle('TamilNadu Government');
        $pdf->SetMargins(10, 5, 10);
        $pdf->AddPage();

        // Application Title
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 5, 'GOVERNMENT OF TAMILNADU', 0, 1, 'C');

        $pdf->Cell(0, 5, 'THE ELECTRICAL LICENSING BOARD', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Thiru.Vi.Ka.Indl.Estate, Guindy. Chennai – 600032.', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 5, 'Form "S"', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Application for Supervisor Competency Certificate', 0, 1, 'C');
        $pdf->Ln(2);

        // Load and display applicant photo (Right side)
        // if (!empty($documents->upload_photo)) {
        //     $photoPath = public_path($documents->upload_photo);

        //     if (file_exists($photoPath)) {
        //         $pdf->Image($photoPath, 150, 35, 40, 40);
        //     }
        // }

        // Set font for content
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(0);

        // Application Details (Left side)

        // $pdf->Cell(50, 10, 'Name of the applicant ', 0, 0);
        // $pdf->Cell(100, 10, ': ' . $form->application_id, 0, 1);
        // Name of the applicant
        $pdf->Cell(50, 9, '1. Name of the applicant', 0, 0);
        $pdf->Cell(5, 9, ':', 0, 0, 'C'); // Centered colon
        $pdf->Cell(85, 9, $form->applicant_name, 0, 1, 'L'); // Left-aligned value

        // Father's Name
        $pdf->Cell(50, 9, '2. Father\'s Name', 0, 0);
        $pdf->Cell(5, 9, ':', 0, 0, 'C');
        $pdf->Cell(85, 9, $form->fathers_name, 0, 1, 'L');

        // Address of the applicant (Use MultiCell to wrap text properly)
        $pdf->Cell(50, 9, '3. Address of the applicant', 0, 0);
        $pdf->Cell(5, 9, ':', 0, 0, 'C');
        $pdf->MultiCell(85, 9, $form->applicants_address, 0, 'L'); // Address wraps properly

        // Date of Birth and Age
        $pdf->Cell(50, 9, '4. Date of Birth and Age', 0, 0);
        $pdf->Cell(5, 9, ':', 0, 0, 'C');
        $pdf->Cell(85, 9, $form->d_o_b . ', ' . $form->age, 0, 1, 'L');

        // $pdf->Cell(50, 9, 'License Applied For', 0, 0);
        // $pdf->Cell(100, 9, ': ' . ($payment->license_name ?? 'N/A'), 0, 1);
        // $pdf->Cell(50, 9, 'Form Name', 0, 0);
        // $pdf->Cell(100, 9, ': ' . ($payment->form_name ?? 'N/A'), 0, 1);
        // $pdf->Ln(1);

        // Educational Details Section
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, '5. Details of Technical Qualification passed by the applicant', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(1);
        // Table Header
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(40, 7, 'Education Level', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Institution/School Name', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Year of Passing', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Percentage / Grade', 1, 1, 'C');  // End the row with a line break

        // Reset font for content
        $pdf->SetFont('helvetica', '', 10);

        $eduCount = count($education);
        $expCount = count($experience);

        foreach ($education as $edu) {
            $pdf->Cell(40, 7, $edu->educational_level, 1, 0, 'C');
            $pdf->Cell(50, 7, $edu->institute_name, 1, 0, 'C');
            $pdf->Cell(40, 7, $edu->year_of_passing, 1, 0, 'C');
            $pdf->Cell(50, 7, $edu->percentage . '%', 1, 1, 'C');
        }

        // Add some space below the table
        $pdf->Ln(1);


        // Work Experience Section
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, '6. Details of Past and Present Experience', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(60, 7, 'Company Name / Contractor', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Years of Experience', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Designation', 1, 1, 'C'); // End the row with a line break

        // Reset font for content
        $pdf->SetFont('helvetica', '', 10);

        // Loop through work experience data and populate the table
        foreach ($experience as $exp) {
            $pdf->Cell(60, 7, $exp->company_name, 1, 0, 'C');
            $pdf->Cell(50, 7, $exp->experience . ' years', 1, 0, 'C');
            $pdf->Cell(50, 7, $exp->designation, 1, 1, 'C');
        }
        $pdf->Ln(2); // Add space before the question
        $pdf->SetFont('helvetica', '', 10);
        // $pdf->writeHTML('<p style="margin-bottom:5px;">7.Have you made any previous application?</p>', true, false, true, false, '');
        // $pdf->writeHTML('<p>If so, state reference No and date:</p>', true, false, true, false, '');
        $pdf->Ln(2);


        $pdf->Cell(100, 5, '7. Have you made any previous application?', 0, 1, 'L');
        $pdf->Cell(135, 5, 'If so, state reference Number and date', 0, 0, 'L');

        if ($form->previously_number != 0 && $form->previously_date != 0) {
            $pdf->Cell(90, 5, ': ' . $form->previously_number . ', ' . $form->previously_date, 0, 1, 'L');
        } else {
            $pdf->Cell(90, 5, ': NO', 0, 1, 'L');
        }
        $pdf->Ln(1);

        $pdf->Cell(100, 5, '8. Do you possess Wireman C.C / Wireman Helper C.C issued by this Board?', 0, 1, 'L');
        $pdf->Cell(135, 5, 'If so, furnish the details and surrender the same.', 0, 0, 'L');

        if ($form->wireman_details) {
            $pdf->Cell(20, 9, '', 0, 0);
            $pdf->Cell(130, 9, ': ' . $form->wireman_details, 0, 1, 'L');
        } else {

            $pdf->Cell(130, 5, ': NO', 0, 1, 'L');
        }
        // Wireman Certificate

        // $pdf->Cell(100, 9, '8. Do you possess Wireman C.C / Wireman Helper C.C issued by this Board?', 0, 1, 'L');

        // $pdf->Cell(135, 9, 'If so, furnish the details and surrender the same.', 0, 1, 'L');

        // if ($form->wireman_details) {
        //     $pdf->Cell(20, 9, '', 0, 0);
        //     $pdf->Cell(130, 9, ': ' . $form->wireman_details, 0, 1, 'L');
        // } else {
        //     $pdf->Cell(20, 9, '', 0, 0);
        //     $pdf->Cell(130, 9, ': NO', 0, 1, 'L');
        // }

        $pdf->Ln(1);

        // Demand Draft Details
        $pdf->Cell(10, 9, '9.', 0, 0, 'L');
        $pdf->Cell(150, 9, 'Demand Draft Details', 0, 1, 'L');

        // Table Header
        $pdf->Cell(40, 10, 'Bank Name', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Mode Of Payment', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Payment Date', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Transaction ID', 1, 1, 'C');

        // Payment details row
        $pdf->Cell(40, 10, 'State Bank of India', 1, 0, 'C');
        $pdf->Cell(50, 10, 'UPI', 1, 0, 'C');
        $pdf->Cell(40, 10, '25-02-2025', 1, 0, 'C');
        $pdf->Cell(50, 10, $payment->transaction_id ?? 'N/A', 1, 1, 'C');

        $pdf->Ln(3);

        $pdf->SetFont('helvetica', '', 10);

        // First line (auto-wrap)
        $pdf->MultiCell(0, 10, 'I hereby declare that all the details mentioned above are correct and true to the best of my knowledge.', 0, 'L');


        $pdf->Ln(1);

        // Second line (auto-wrap)
        $pdf->MultiCell(0, 10, 'I request that I may be granted a Supervisor Competency Certificate.', 0, 'L');

        $pdf->Ln(12);

        $pdf->Cell(20, 10, 'Place:', 0, 0);
        $pdf->Cell(60, 10, ': Chennai', 0, 0, 'L');
        $pdf->SetX(110);
        $pdf->Cell(60, 10, '', 0, 1, 'C');

        $pdf->Cell(20, 10, 'Date:', 0, 0);
        $pdf->Cell(60, 10, ': ' . date('d-m-Y'), 0, 0, 'L');


        // if (!empty($documents->upload_sign)) {
        //     $signPath = public_path($documents->upload_sign);

        //     if (file_exists($signPath)) {
        //         $pdf->Image($signPath, 132, 25, 30, 30);
        //     }
        // }
        $pdf->Cell(80, 10, 'Signature of the Candidate', 0, 1, 'R');

        $pdf->Output('Application_Details.pdf', 'I');
    }


    public function generaterenewalTamilPDF($newApplicationId)
    {

        $form = Mst_Form_s_w::where('application_id', $newApplicationId)->firstOrFail();


        $education = Mst_education::where('application_id', $newApplicationId)->get();

        if ($education->isEmpty()) {
            $education = Mst_education::where('application_id', $form->old_application)->get();
        }


        $experience = Mst_experience::where('application_id', $newApplicationId)->get();

        if ($experience->isEmpty()) {
            $experience = Mst_experience::where('application_id', $form->old_application)->get();
        }
        
        
        $documents = Mst_documents::where('application_id', $newApplicationId)->get();

        $applicant_photo = TnelbApplicantPhoto::where('application_id', $newApplicationId)->get();

        if ($applicant_photo->isEmpty()) {
            $applicant_photo = TnelbApplicantPhoto::where('application_id', $form->old_application)->get();
        }

        
        if ($applicant_photo->isNotEmpty()) {
            $applicant_photo = $applicant_photo->first()->upload_path;
        }



        $decryptedaadhar = Crypt::decryptString($form->aadhaar);
        $decryptedpan = Crypt::decryptString($form->pancard);
        if (strlen($decryptedaadhar) === 12) {
            $masked = str_repeat('X', 8) . substr($decryptedaadhar, -4);
        } else {
            $masked = 'Invalid Aadhaar';
        }
        if (strlen($decryptedpan) === 10) {
            $maskedPan = str_repeat('X', 6) . substr($decryptedpan, -4);
        } else {
            $maskedPan = 'Invalid PAN';
        }


        $payment = DB::table('payments')->where('application_id', $newApplicationId)->first();

        if (!$form) {
            return redirect()->back()->with('error', 'பதிவுகள் கிடைக்கவில்லை!');
        }

        // Initialize mPDF with Marutham font
        $mpdf = new Mpdf([
            'mode' => 'utf-8'
        ]);


        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $mpdf->SetDefaultFont('marutham');
        $mpdf->SetFont('marutham', '', 8);
        $mpdf->SetTitle('தமிழ்நாடு அரசு மின்சார உரிமையாளர்கள் வாரியம் படிவம் ' . $form->license_name);

        $html = '
        <style>
            .tam { font-family: marutham !important; font-size: 20px !important; }
            body { font-family: "marutham", sans-serif; line-height: 1.5; font-size: 14px !important; font-weight:600!important; }
            h3, h4 { margin: 5px 0; font-weight: 600; }
            .text-center { text-align: center; }
            p { margin: 5px 0; }
            table { width: 100%; border-collapse: collapse; }
            table tr th { font-weight: 600; }
            p strong { font-weight: 600; }
            th, td { border: 1px solid #000; padding: 5px;  }
            .mt-10 { margin-top: 5px; }
            .applicant_details tr td { text-align: left; border: none; }
            .license_tbl tr td { text-align: left; border: none; line-height: 25px; }
            .tbl-no-border td { border: none; }
        </style>
    
        <div class="mb-2 text-center">
            <h3><span class="tam">தமிழ்நாடு அரசு</span></h3>
            <h4>மின்சார உரிமையாளர்கள் வாரியம்</h4>
            <p>திரு.வி.கா. தொழிற்சாலை, கிண்டி, சென்னை – 600032.</p>
            <h4>படிவம் - "' . $form->form_name . '"</h4>
            <p>மேற்பார்வையாளர் தகுதிச் சான்றிதழுக்கான விண்ணப்பம்</p>
        </div>
        <h4 style="text-align:center;">விண்ணப்ப எண்: ' . $form->application_id . '</h4>
        ';

        $wrap = function ($text, $length = 20) {
            return wordwrap($text, $length, '<br>', true);
        };


        $html .= '<table class="tbl-no-border" style="text-align:left;">
            <tr>
                <td class="">1. விண்ணப்பதாரரின் பெயர்</td>
                <td class="">: ' . $wrap($form->applicant_name) . '</td>
                <td rowspan="5" class="photo-cell">';

        if ($applicant_photo && file_exists(public_path($applicant_photo))) {
            $html .= '<img src="' . public_path($applicant_photo) . '" style="width:120px; height:150px; border:1px solid;">';
        } else {
            $html .= '<p>No Photo</p>';
        }

        $html .= '</td></tr>
            <tr>
                <td class="">2. தந்தையின் பெயர்</td>
                <td class="">: ' . $wrap($form->fathers_name) . '</td>
            </tr>
            <tr>
                <td class="label">3. முகவரி</td>
                <td class="value">: ' . $wrap(nl2br($form->applicants_address)) . '</td>
            </tr>
            <tr>
                <td class="label">4. பிறந்த தேதி & வயது</td>
                <td class="value">: ' . $form->d_o_b . ' (' . $form->age . ' years)</td>
            </tr>
            </table>';


        $html .= '
        <h4 class="mt-10 ">5. கல்வித் தகுதி</h4>
        <table class="text-center">
            <tr>
                <th>வரிசை எண்</th>
                <th>கல்வி நிலை</th>
                <th>கல்லூரி / பள்ளி</th>
                <th>தேர்ச்சி பெற்ற ஆண்டு</th>
                <th>சதவீதம்</th>
            </tr>';

        foreach ($education as $i => $edu) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $edu->educational_level . '</td>
                <td>' . $edu->institute_name . '</td>
                <td>' . $edu->year_of_passing . '</td>
                <td>' . $edu->percentage . '%</td>
            </tr>';
        }
        $html .= '</table>';

        $html .= '
        <h4 class="mt-10">6. பணிப் பரிசோதனை</h4>
        <table  class="text-center">
            <tr>
                <th>வரிசை எண்</th>
                <th>நிறுவனம்</th>
                <th>அனுபவம் (ஆண்டுகள்)</th>
                <th>பதவி</th>
            </tr>';

        foreach ($experience as $i => $exp) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $exp->company_name . '</td>
                <td>' . $exp->experience . '</td>
                <td>' . $exp->designation . '</td>
            </tr>';
        }
        $html .= '</table>';

        $previously = ($form->previously_number && $form->previously_date) ? $form->previously_number . ', ' . $form->previously_date : 'NO';
        $wireman_details = $form->wireman_details ?: 'NO';
        $aadhaar = $form->aadhaar ?: '-';
        $pancard = $form->pancard ?: '-';

        function renderRow($label, $value, $limit = 20)
        {
            if (strlen(strip_tags($value)) > $limit) {
                return '
            <tr>
                <td colspan="2"><strong>' . $label . '</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left:20px;">' . nl2br(htmlentities($value)) . '</td>
            </tr>';
            } else {
                return '
            <tr>
                <td width="70%"><strong>' . $label . '</strong></td>
                <td width="30%">: ' . htmlentities($value) . '</td>
            </tr>';
            }
        }

        $previously = ($form->previously_number && $form->previously_date)
            ? $form->previously_number . ', ' . $form->previously_date
            : 'இல்லை';

        $wireman_details = $form->wireman_details ?: 'இல்லை';

        

        $decryptedaadhar = Crypt::decryptString($form->aadhaar);
        $decryptedpan = Crypt::decryptString($form->pancard);
        if (strlen($decryptedaadhar) === 12) {
            $masked = str_repeat('X', 8) . substr($decryptedaadhar, -4);
        } else {
            $masked = 'Invalid Aadhaar';
        }
        if (strlen($decryptedpan) === 10) {
            $maskedPan = str_repeat('X', 6) . substr($decryptedpan, -4);
        } else {
            $maskedPan = 'Invalid PAN';
        }
        
        $aadhaar = $masked ?: 'NO';
        $pancard = $maskedPan ?: 'NO';

        $l_date = format_date($form->previously_date);
        // Start HTML
        $html .= '
    <table width="100%" cellpadding="5" cellspacing="0" class="tbl-no-border" style="border-collapse: collapse; margin-top:10px;">';

        $html .= renderRow(
            '<h4>7. இதற்கு முன் விண்ணப்பித்தீர்களா? முந்தைய விண்ணப்ப எண் </h4>',
            $form->previously_number .' , '.$l_date
        );

        $html .= renderRow(
            '<h4>8. இந்த வாரியத்தால் வழங்கப்பட்ட வயர்மேன் C.C / Wireman Helper C.C உங்களிடம் உள்ளதா? விவரங்கள் </h4>',
            $wireman_details
        );

        $html .= renderRow(
            '<h4>9. ஆதார் எண்</h4>',
            $aadhaar
        );

        $html .= renderRow(
            '<h4>10. நிரந்தர கணக்கு எண்</h4>',
            $pancard
        );

        $html .= '</table>';



        

        // Spacer before declaration
        $html .= '<div style="min-height: 150px;"></div>';

        // Declaration
        $html .= '
        <p class="mt-10">மேற்கூறிய தகவல்கள் அனைத்தும் உண்மை என்பதை உறுதிப்படுத்துகிறேன்.</p>
        <p>தயவுசெய்து எனக்கு மேற்பார்வையாளர் தகுதிச் சான்றிதழ் வழங்கவும்.</p><br><br>
        <p><strong>இடம் :</strong> சென்னை</p>
        <p><strong>தேதி :</strong> ' . date('d-m-Y') . '</p>
        <p style="text-align: right; margin-top: 50px ;"><strong>விண்ணப்பதாரரின் கையொப்பம்</strong></p>';

        $html = mb_convert_encoding($html, 'UTF-8', 'auto');
        $mpdf->WriteHTML($html);

        return response($mpdf->Output('Application_Tamil.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }





    public function downloadPaymentReceipt($newApplicationId)
    {
        $form = Mst_Form_s_w::where('application_id', $newApplicationId)->first();
        $education = Mst_education::where('application_id', $newApplicationId)->get();
        $experience = Mst_experience::where('application_id', $newApplicationId)->get();
        $documents = Mst_documents::where('application_id', $newApplicationId)->first();
        $payment = DB::table('payments')->where('application_id', $newApplicationId)->first();


        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found!');
        }

        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetFont('helvetica', '', 10);

        $mpdf->SetTitle('TNELB Payment Receipt ' . $newApplicationId);



        $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; font-size: 14px; }
            h2 { text-align: center; margin-bottom: 20px; }
            table { border-collapse: collapse; width: 100%; margin-top: 20px; }
            th, td { border: 1px solid #000; padding: 8px; text-align: center; }
            .section-title { margin-top: 30px; font-size: 16px; font-weight: bold; }
        </style>
    </head>
    <body>
        <h2>Payment Receipt</h2>

        <p><strong>Application Reference Number:</strong> ' . $newApplicationId . '</p>

        <p class="section-title">Payment Details</p>

        <table>
            <thead>
                <tr>
                    <th>Bank Name</th>
                    <th>Mode of Payment</th>
                    <th>Payment Date</th>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>State Bank of India</td>
                    <td>UPI</td>
                    <td>25-02-2025</td>
                    <td>' . ($payment->transaction_id ?? 'N/A') . '</td>
                    <td>₹' . ($payment->amount ?? 'N/A') . '</td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>
    ';

        $mpdf->WriteHTML($html);
        return response($mpdf->Output('', 'S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="payment_receipt.pdf"');
    }
}
