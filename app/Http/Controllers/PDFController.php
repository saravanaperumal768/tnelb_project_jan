<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mst_Form_s_w;
use App\Models\Mst_education;
use App\Models\Mst_experience;
use App\Models\Mst_documents;
use App\Models\TnelbApplicantPhoto;
use App\Models\TnelbFormP;
use App\Models\TnelbAppsInstitute;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use TCPDF;
use Mpdf\Mpdf;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PDFController extends Controller
{

    public function formatAddressToThreeLines($address, $maxCharsPerLine = 45) {
       $address = preg_replace("/\r\n|\r|\n/", ' ', $address);
        $address = preg_replace('/\s+/', ' ', $address);
        $address = trim($address);

        $words = explode(' ', $address);

        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            if (strlen($currentLine . ' ' . $word) <= $maxCharsPerLine) {
                $currentLine .= ($currentLine ? ' ' : '') . $word;
            } else {
                $lines[] = $currentLine;
                $currentLine = $word;
            }
        }

        if ($currentLine) {
            $lines[] = $currentLine;
        }

        // Ensure max 3 lines
        $lines = array_slice($lines, 0, 3);

        return nl2br(e($lines[0] ?? '') . "\n" . e($lines[1] ?? '') . "\n" . e($lines[2] ?? ''));
    }

    public function generateFormPPDF($newApplicationId)
    {

        $form = TnelbFormP::where('application_id', $newApplicationId)->first();

        // var_dump(format_date($form->previously_number));die;
        $education = Mst_education::where('application_id', $newApplicationId)->get();
        $experience = Mst_experience::where('application_id', $newApplicationId)->get();
        $institutes = TnelbAppsInstitute::where('application_id', $newApplicationId)->get();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $newApplicationId)->first();


        $decryptedaadhar = Crypt::decryptString($form->aadhaar);
        $decryptedpan = Crypt::decryptString($form->pancard);
        $masked = strlen($decryptedaadhar) === 12 ? str_repeat('X', 8) . substr($decryptedaadhar, -4) : 'Invalid Aadhaar';
        $maskedPan = strlen($decryptedpan) === 10 ? str_repeat('X', 6) . substr($decryptedpan, -4) : 'Invalid PAN';

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
            .label { 
                width: 35%; font-weight: bold;  vertical-align: top;
            }
            .value { width: 40%; text-align: left; }
            .tbl-bordered td, .tbl-bordered th { border: 1px solid #000; text-align: center; }
            .tbl-no-border td { border: none; padding-bottom: 12px; } /* ⬅ spacing between rows */
            .photo-cell { 
                width: 20%;
                text-align: center; 
            }
            .employer { display:flex }
            .value {
                 width: 45%;
                vertical-align: top;
            }
            
        </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        $certificateText = match ($form->form_name) {
            'S' => 'Application for Competency Certificate for Supervisor',
            'W' => 'Application for Competency Certificate for Wireman',
            'WH' => 'Application for Competency Certificate for Wireman Helper',
            default => 'Application for Competency Certificate',
        };
    
        $html = '
        <h3 style="text-align:center;">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align:center;">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align:center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align:center;">Form "' . $form->form_name . ($form->appl_type == 'R' ? '" - Renewal' : '"') . '</h4>
        <p style="text-align:center;">' . $certificateText . '</p>
        <h4 style="text-align:center;">Application Number: <strong>' . $form->application_id . '</strong></h4>';
    
        $html .= '<table class="tbl-no-border">
        <tr>
            <td class="label">1. Name of the Applicant</td>
            <td class="value">: ' . $form->applicant_name . '</td>
            <td rowspan="5" class="photo-cell">';
    
        if ($applicant_photo && file_exists(public_path($applicant_photo->upload_path))) {
            $html .= '<img src="' . public_path($applicant_photo->upload_path) . '" style="width:120px; height:150px; border:1px solid;">';
        } else {
            $html .= '<p>No Photo</p>';
        }
     
        $html .= '</td></tr>
        <tr>
            <td class="label">2. Father\'s Name</td>
            <td class="value">: ' . $form->fathers_name . '</td>
        </tr>
        <tr>
            <td class="label">3. Address of the Applicant (in block letters)</td>
            <td class="value">:
                <br>' .
                $this->formatAddressToThreeLines($form->applicants_address)
                . '</td>
        </tr>
        <tr>
            <td class="label">4. Date of birth and age</td>
            <td class="value">: ' . $form->d_o_b . ' (' . $form->age . ' years)</td>
        </tr>
        </table>';
    
        // Education
        $html .= '<h4>5. (i).Details of Technical Qualification passed by the applicant</h4>
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
        $html .= '<h4>(ii). Institute in which the applicant has undergone the training and the period</h4>
        <table class="tbl-bordered">
        <tr>
        <th>S.No</th><th>Institute Name & address</th><th>Duration (Years)</th><th>Form Date</th><th>To Date</th>
        </tr>';
        foreach ($institutes as $i => $inst) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $inst->institute_name_address . '</td>
                <td>' . $inst->duration . ' Years </td>
                <td>' . format_date($inst->from_date) . '</td>
                <td>' . format_date($inst->to_date) . '</td>
            </tr>';
        }
        $html .= '</table>';


        $html .= '<h4>(iii). Power Station to which he is aattached at present</h4>
        <table class="tbl-bordered">
        <tr>
        <th>S.No</th><th>Power Station Name</th><th>Experience(Years)</th><th>Designation</th>
        </tr>';
        foreach ($experience as $i => $exp) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $exp->company_name . '</td>
                <td>' . $exp->experience . ' Years </td>
                <td>' . $exp->designation . '</td>
            </tr>';
        }
        $html .= '</table>';

        $html .= '<div class="employer"><span class="label">(iv). Name of the employer :</span> ' . $form->employer_detail . '</div>';


        $html .='<h4>6. Have you made any previous application? If so, State reference No. and date</h4>'; 

        $html .= '<p class="mt-2">I hereby declare that the particulars stated above are correct and true to the best of
            my knowledge</p>
        <br>
        <p>I request that I may be granted a Power Generating Station Operation and
            maintenance Competency Certificate.</p>
        <br><br>
        <p><strong>Place:</strong> Chennai</p>
        <p><strong>Date:</strong> ' . date('d-m-Y') . '</p>
        <p style="text-align:right;"><strong>Signature of the Candidate</strong></p>';
    
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('Application_Details.pdf', 'I'))->header('Content-Type', 'application/pdf');
    }


    public function generateFormPPDFTA($newApplicationId)
    {

        $form = TnelbFormP::where('application_id', $newApplicationId)->first();

        // var_dump(format_date($form->previously_number));die;
        $education = Mst_education::where('application_id', $newApplicationId)->get();
        $experience = Mst_experience::where('application_id', $newApplicationId)->get();
        $institutes = TnelbAppsInstitute::where('application_id', $newApplicationId)->get();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $newApplicationId)->first();


        $decryptedaadhar = Crypt::decryptString($form->aadhaar);
        $decryptedpan = Crypt::decryptString($form->pancard);
        $masked = strlen($decryptedaadhar) === 12 ? str_repeat('X', 8) . substr($decryptedaadhar, -4) : 'Invalid Aadhaar';
        $maskedPan = strlen($decryptedpan) === 10 ? str_repeat('X', 6) . substr($decryptedpan, -4) : 'Invalid PAN';

        if (!$form) {
            return redirect()->back()->with('error', 'No records found!');
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'default_font' => 'marutham',
            'fontDir' => array_merge(
                (new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'],
                [public_path('fonts')]
            ),
            'fontdata' => array_merge(
                (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'],
                [
                    'marutham' => [
                        'R' => 'Marutham.ttf',
                        'useOTL' => 0xFF, // ✅ REQUIRED FOR TAMIL
                        'useKashida' => 75,
                    ],
                ]
            ),
            'default_font' => 'helvetica'
        ]);

        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
    
        $mpdf->WriteHTML('
        <style>
            body { 
                font-family: helvetica;
                font-size: 10pt;
                line-height: 1.6;
            }
            .ta {
                font-family: marutham;
            }
            h3, h4, p { margin: 4px 0; }
            table { border-collapse: collapse; width: 100%; margin-top: 6px; }
            td, th { padding: 4px; vertical-align: top; }
            .label { width: 35%; text-align: left; font-weight: bold; }
            .value { width: 40%; text-align: left; }
            .tbl-bordered td, .tbl-bordered th { border: 1px solid #000; text-align: center; }
            .tbl-no-border td { border: none; padding-bottom: 12px; } /* ⬅ spacing between rows */
            .photo-cell { text-align:center; }
            .employer { display:flex }
            .value {
                line-height: 1.6;
            }
            
        </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        $certificateText = match ($form->form_name) {
            'S' => 'Application for Competency Certificate for Supervisor',
            'W' => 'Application for Competency Certificate for Wireman',
            'WH' => 'Application for Competency Certificate for Wireman Helper',
            default => 'மின் உற்பத்தி நிலைய செயல்பாடு மற்றும் பராமரிப்பு திறன் சான்றிதழுக்கான விண்ணப்பம்',
        };
    
        $html = '
        <h3 class="ta" style="text-align:center;">தமிழ்நாடு அரசு</h3>
        <h4 class="ta" style="text-align:center;">மின்சார உரிம வாரியம்</h4>
        <p class="ta" style="text-align:center;">திரு.வி.கா. தொழிற்சாலை, கிண்டி, சென்னை – 600032.</p>
        <h4 class="ta" style="text-align:center;">படிவம் - "' . $form->form_name . ($form->appl_type == 'R' ? '" - Renewal' : '"') . '</h4>
        <p style="text-align:center;">' . $certificateText . '</p>
        <h4 class="ta" style="text-align:center;">விண்ணப்ப எண்: <strong>' . $form->application_id . '</strong></h4>';
    
        $html .= '<table class="tbl-no-border" style="table-layout:fixed; width:100%;">
        <tr>
            <td class="ta label">1. விண்ணப்பதாரரின் பெயர்</td>
            <td class="value">: ' . $form->applicant_name . '</td>
            <td rowspan="4" class="photo-cell">';
    
        if ($applicant_photo && file_exists(public_path($applicant_photo->upload_path))) {
            $html .= '<img src="' . public_path($applicant_photo->upload_path) . '" style="width:120px; height:150px; border:1px solid;">';
        } else {
            $html .= '<p>No Photo</p>';
        }
     
        $html .= '</td></tr>
        <tr>
            <td class="ta label">2. தகப்பனார் பெயர்</td>
            <td class="value">: ' . $form->fathers_name . '</td>
        </tr>
        <tr>
            <td class="ta label">3. விண்ணப்பதாரர் முகவரி (தெளிவாக இருக்க வேண்டும்)</td>
            <td class="value text-wrap" >:
                ' .
                $this->formatAddressToThreeLines($form->applicants_address)
                . '</td>
        </tr>
        <tr>
            <td class="ta label">4. பிறந்த நாள், மாதம், வருடம் மற்றும் வயது</td>
            <td class="value">: ' . $form->d_o_b . ' (' . $form->age . ' years)</td>
        </tr>
        </table>';
    
        // Education
        $html .= '<h4 class="ta">5 . (i). விண்ணப்பதாரியின் தொழில்நுட்ப தகுதி மற்றும் தேர்ச்சி பற்றிய விவரங்கள்
        (அசல் சான்றிதழ்களை புகைப்பட நகல்களுடன் இணைத்திடுக. அசல் பார்க்கப்பட்ட பின்பு திருப்பி அளிக்கப்படும்)</h4>
        <table class="tbl-bordered">
        <tr>
        <th class="ta">வரிைச எண</th><th class="ta">கல்வி நிலை</th><th class="ta">கல்வி நிறுவனம்</th><th class="ta">தேர்ச்சி பெற்ற ஆண்டு</th>
        <th class="ta">சதவீதம்</th>
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
        $html .= '<h4 class="ta">(ii). விண்ணப்பதாரர் பயிற்சி பெற்ற நிறுவனம் மற்றும் காலம்</h4>
        <table class="tbl-bordered">
        <tr>
        <th class="ta">வரிைச எண</th><th class="ta">நிறுவனத்தின் பெயர் & முகவரி</th><th class="ta">பயிற்சி பெற்ற காலம்</th><th class="ta">தேதி முதல்</th><th class="ta">தேதி வரை</th>
        </tr>';
        foreach ($institutes as $i => $inst) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $inst->institute_name_address . '</td>
                <td>' . $inst->duration . ' Years </td>
                <td>' . format_date($inst->from_date) . '</td>
                <td>' . format_date($inst->to_date) . '</td>
            </tr>';
        }
        $html .= '</table>';


        $html .= '<h4 class="ta">(iii). தற்போது பணியாற்றி வரும் மின் நிலையம்</h4>
        <table class="tbl-bordered">
        <tr>
        <th class="ta">வரிைச எண</th><th class="ta">மின் நிலையத்தின் பெயர்</th><th class="ta">அனுபவம் (ஆண்டுகள்)</th><th class="ta">பதவி</th>
        </tr>';
        foreach ($experience as $i => $exp) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $exp->company_name . '</td>
                <td>' . $exp->experience . ' Years </td>
                <td>' . $exp->designation . '</td>
            </tr>';
        }
        $html .= '</table>';

        $html .= '<div class="ta employer"><span class="label">(iv). நிறுவனத்தின் பெயர் :</span> ' . $form->employer_detail . '</div>';


        $html .='<h4 class="ta">6. முன்பு நீங்கள் ஏதேனும் விண்ணப்பம் சமர்ப்பித்துள்ளீர்களா? இருப்பின், அதன் குறிப்பு எண் மற்றும் தேதியை குறிப்பிடவும்.</h4>'; 

        $html .= '<p class="ta">மேலே குறிப்பிடப்பட்டுள்ள விவரங்கள் அனைத்தும் என் அறிவிற்குத் தெரிந்த வரையில் சரியானதும் உண்மையானதும் ஆகும் என்று இதன்மூலம் உறுதிபட அறிவிக்கிறேன்.</p>
        <br>
        <p class="ta">மின்சக்தி உற்பத்தி நிலையத்தின் செயல்பாடு மற்றும் பராமரிப்பு திறன்சான்றிதழ் எனக்கு வழங்கப்பட வேண்டுமென இதன்மூலம் பணிவுடன் கேட்டுக்கொள்கிறேன்.</p>
        <br><br>
        <p><strong class="ta">இடம்:</strong> Chennai</p>
        <p><strong class="ta">தேதி:</strong> ' . date('d-m-Y') . '</p>
        <p style="text-align:right;"><strong class="ta">விண்ணப்பதாரரின் கையொப்பம்</strong></p>';
    
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('Application_Details.pdf', 'I'))->header('Content-Type', 'application/pdf');
    }

    
    public function generatePDF($newApplicationId)
    {

        $form = Mst_Form_s_w::where('application_id', $newApplicationId)->first();

        // var_dump(format_date($form->previously_number));die;
        $education = Mst_education::where('application_id', $newApplicationId)->get();
        $experience = Mst_experience::where('application_id', $newApplicationId)->get();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $newApplicationId)->first();


        $decryptedaadhar = Crypt::decryptString($form->aadhaar);
        $decryptedpan = Crypt::decryptString($form->pancard);
        $masked = strlen($decryptedaadhar) === 12 ? str_repeat('X', 8) . substr($decryptedaadhar, -4) : 'Invalid Aadhaar';
        $maskedPan = strlen($decryptedpan) === 10 ? str_repeat('X', 6) . substr($decryptedpan, -4) : 'Invalid PAN';

        if (!$form) {
            return redirect()->back()->with('error', 'No records found!');
        }

        // $wrap = function ($text, $length = 20) {
        //     return wordwrap($text, $length, '<br>', true);
        // };

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
            'S' => 'Application for Competency Certificate for Supervisor',
            'W' => 'Application for Competency Certificate for Wireman',
            'WH' => 'Application for Competency Certificate for Wireman Helper',
            default => 'Application for Competency Certificate',
        };
    
        $html = '
        <h3 style="text-align:center;">GOVERNMENT OF TAMILNADU</h3>
        <h4 style="text-align:center;">THE ELECTRICAL LICENSING BOARD</h4>
        <p style="text-align:center;">Thiru.Vi.Ka.Indl.Estate, Guindy, Chennai – 600032.</p>
        <h4 style="text-align:center;">Form "' . $form->form_name . ($form->appl_type == 'R' ? '" - Renewal' : '"') . '</h4>
        <p style="text-align:center;">' . $certificateText . '</p>
        <h4 style="text-align:center;">Application Number: <strong>' . $form->application_id . '</strong></h4>';
    
        $html .= '<table class="tbl-no-border">
        <tr>
            <td class="label">1. Name of the Applicant</td>
            <td class="value">: ' . $form->applicant_name . '</td>
            <td rowspan="5" class="photo-cell">';
    
        if ($applicant_photo && file_exists(public_path($applicant_photo->upload_path))) {
            $html .= '<img src="' . public_path($applicant_photo->upload_path) . '" style="width:120px; height:150px; border:1px solid;">';
        } else {
            $html .= '<p>No Photo</p>';
        }
     $address = $form->applicants_address ?? '';

        $words = preg_split('/\s+/', trim($address));
        $formattedAddress = '';

        foreach (array_chunk($words, 3) as $chunk) {
            $formattedAddress .= implode(' ', $chunk) . "<br>";
        }
        $html .= '</td></tr>
        <tr>
            <td class="label">2. Father\'s Name</td>
            <td class="value">: ' . $form->fathers_name . '</td>
        </tr>
        <tr>
            <td class="label">3. Address of the Applicant (in block letters)</td>
                <td class="value" colspan="2">
                <table style="border: none; width: 100%;">
                    <tr>
                        <td style="width: 10px;">:</td>
                        <td style="text-align: left;">
                            ' . $formattedAddress . '
                        </td>
                    </tr>
                </table>
             </td>
        </tr>
        <tr>
            <td class="label">4. Date of birth and age along with evidence</td>
            <td class="value">: ' . $form->d_o_b . ' (' . $form->age . ' years)</td>
        </tr>
        </table>';
    
        // Education
        $html .= '<h4>5. Details of technical qualification and examination, if any passed by the applicant (certificate in original along with xerox copy to be enclosed for reference and return)</h4>
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
        $html .= '<h4>6. Details of past and present employer name and experience along with evidence</h4>
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
        $previously = ($form->previously_number && $form->previously_date) ? $form->previously_number . ', ' . $form->previously_date : 'No';
        $wireman_details = $form->wireman_details ?: 'No';

        if (empty($form->previously_number) || empty($form->previously_date)) {
            $value = 'No';
        } else {
            $value = 'Yes, '.($form->previously_number ?: '') . ' , ' . (!empty($form->previously_date) ? format_date($form->previously_date) : '');
        }

        if (empty($form->certificate_no) || empty($form->certificate_date)) {
            $certno = 'No';
        } else {
            $certno = 'Yes, '.($form->certificate_no ?: '') . ', ' . (!empty($form->certificate_date) ? format_date($form->certificate_date) : '');
        }



        
        // $html .= '<tr>
        // <td width="70%"><strong>7. Have you made any previous application? If so, state Reference Number and Date</strong></td>
        // <td>: ' . $value . '</td>
        // </tr>';
    
        $html .= '<table width="100%" cellpadding="5" cellspacing="0" style="margin-top:10px;">';

        if ($form->form_name == 'S') {
            $html .= '<tr><td width="70%"><strong>7. Have previously applied for Electrical Assistant Qualification Certificate and if yes then mention its number and date</strong></td><td>: ' . $value . '</td></tr>';
        }



        if ($form->form_name == 'S') {
            $no = '8';
            $html .= '<tr><td><strong>'.$no.'. Do you possess Wireman Competency Certificate / Supervisor Competency Certificate issued by this Board? If so furnish the details and surrender the same.</strong></td><td>: ' . ($form->form_name == 'S' ? $certno : $value) . '</td></tr>';

            $html .= '<tr><td><strong>9. Aadhaar Number</strong></td><td>: ' . $masked . '</td></tr>';

            $html .= '<tr><td><strong>10. PAN Number</strong></td><td>: ' . $maskedPan . '</td></tr>';
        }else{
            $no = '7';
            if($form->form_name == 'WH'){
                $html .= '<tr><td><strong>'.$no.'. Do you possess Wireman Helper Competency Certificate issued by this Board? If so furnish the details and surrender the same.</strong></td><td>: ' . ($form->form_name == 'WH' ? $certno : $value) . '</td></tr>';
            }else{
                $html .= '<tr><td><strong>'.$no.'. Do you possess Wireman Competency Certificate / Wireman Helper Competency Certificate issued by this Board? If so furnish the details and surrender the same.</strong></td><td>: ' . $certno . '</td></tr>';
            }
            $html .= '<tr><td><strong>8. Aadhaar Number</strong></td><td>: ' . $masked . '</td></tr>';

            $html .= '<tr><td><strong>9. PAN Number</strong></td><td>: ' . $maskedPan . '</td></tr>';
        }


       
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
        if (!empty($applicant_photo->upload_path)) {
            $photoPath = public_path($applicant_photo->upload_photo);

            if (file_exists($photoPath)) {
                $pdf->Image($photoPath, 150, 35, 40, 40);
            }
        }

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


    public function generateTamilPDF($newApplicationId)
    {


        $form = Mst_Form_s_w::where('application_id', $newApplicationId)->first();
        $education = Mst_education::where('application_id', $newApplicationId)->get();
        $experience = Mst_experience::where('application_id', $newApplicationId)->get();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $newApplicationId)->first();
        $payment = DB::table('payments')->where('application_id', $newApplicationId)->first();

        if (!$form) {
            return redirect()->back()->with('error', 'பதிவுகள் கிடைக்கவில்லை!');
        }
 $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'fontDir' => array_merge($fontDirs, [
            public_path('fonts'),
        ]),
        'fontdata' => $fontData + [
            'marutham' => [ // custom font key name
                'R' => 'Marutham.ttf',  // Regular style
                // 'B' => 'TAU-Marutham Bold.ttf',  // Optional
                // 'I' => 'Marutham-Italic.ttf',
                // 'BI' => 'Marutham-BoldItalic.ttf',
            ]
        ],
        'default_font' => 'marutham' // set default font
    ]);
// dd(public_path('fonts/Marutham.ttf'));
// exit;
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->SetDefaultFont('marutham');
$mpdf->SetFont('marutham', '', 12);


$mpdf->SetFont('marutham', '', 12);
$mpdf->SetTitle('தமிழ்நாடு அரசு மின்சார உரிமையாளர்கள் வாரியம் படிவம் ' . $form->license_name);

$certificateText = match ($form->form_name) {
    'S' => 'மேற்பார்வையாளர் தகுதிச் சான்றிதழுக்கான விண்ணப்பம்',
    'W' => 'கம்பியாளர் தகுதிச் சான்றிதழ் பெறுவதற்கான விண்ணப்பம்',
    'WH' => 'மின் கம்பி உதவியாளர் தகுதிச் சான்றிதழ் பெறுவதற்கான விண்ணப்பம்',
    default => 'Application for Competency Certificate',
};

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
            <h4>படிவம் - "' . $form->form_name . ($form->appl_type == 'R' ? '" - புதுப்பிப்பு' : '"').'</h4>
            <p>'.$certificateText.'</p>
        </div>
        <h4 style="text-align:center;">விண்ணப்ப எண்: ' . $form->application_id . '</h4>
        ';

        $wrap = function ($text, $length = 20) {
            return wordwrap($text, $length, '<br>', true);
        };


        $html .= '
            <table class="tbl-no-border" style="width:100%; border-collapse:collapse; text-align:left;">
                <tr>
                    <td style="width:35%;">1. விண்ணப்பதாரரின் பெயர்</td>
                    <td style="width:45%;">: ' . $wrap($form->applicant_name) . '</td>
                    <td rowspan="5" style="width:20%; text-align:center; vertical-align:top;">
            ';

            if ($applicant_photo && file_exists(public_path($applicant_photo->upload_path))) {
                $html .= '<img src="' . public_path($applicant_photo->upload_path) . '" style="width:120px; height:150px; border:1px solid #000;">';
            } else {
                $html .= '<p>No Photo</p>';
            }

            $html .= '
                    </td>
                </tr>
                <tr>
                    <td>2. தகப்பனார் பெயர்</td>
                    <td>: ' . $wrap($form->fathers_name) . '</td>
                </tr>
                <tr>
                    <td>3. விண்ணப்பதாரர் முகவரி (தெளிவாக இருக்க வேண்டும்)</td>
                    <td>: ' . $this->formatAddressToThreeLines($form->applicants_address) . '</td>
                </tr>
                <tr>
                    <td>4. பிறந்த நாள், மாதம், வருடம் மற்றும் வயது</td>
                    <td>: ' . $form->d_o_b . ' (' . $form->age . ' years)</td>
                </tr>
            </table>';



        $html .= '
        <h4 class="mt-10 ">5. விண்ணப்பதாரியின் தொழில்நுட்ப தகுதி மற்றும் தேர்ச்சி பற்றிய விவரங்கள்
        (அசல் சான்றிதழ்களை புகைப்பட நகல்களுடன் இணைத்திடுக. அசல் பார்க்கப்பட்ட பின்பு திருப்பி அளிக்கப்படும்)</h4>
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
        <h4 class="mt-10">6. பெற்றுள்ள முந்தைய மற்றும் தற்போதைய அனுபவங்களைப் பற்றிய விவரங்கள்</h4>
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

        // $previously = ($form->previously_number || $form->previously_date) ? $form->previously_number . ', ' . $form->previously_date : 'NO';
        // $wireman_details = $form->wireman_details ?: 'NO';
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

        // $previously = ($form->previously_number && $form->previously_date)
        //     ? $form->previously_number . ', ' . $form->previously_date
        //     : 'இல்லை';

        // $wireman_details = $form->wireman_details ?: 'இல்லை';

        $previously = ($form->previously_number && $form->previously_date) ? $form->previously_number . ', ' . $form->previously_date : 'இல்லை';
        $wireman_details = $form->wireman_details ?: 'இல்லை';

        if (empty($form->previously_number) || empty($form->previously_date)) {
            $value = 'இல்லை';
        } else {
            $value = 'ஆம், '.($form->previously_number ?: '') . ' , ' . (!empty($form->previously_date) ? format_date($form->previously_date) : '');
        }

        if (empty($form->certificate_no) || empty($form->certificate_date)) {
            $certno = 'இல்லை';
        } else {
            $certno = 'ஆம், '.($form->certificate_no ?: '') . ', ' . (!empty($form->certificate_date) ? format_date($form->certificate_date) : '');
        }

        

        $decryptedaadhar = Crypt::decryptString($form->aadhaar);
        $decryptedaadhar = str_replace(' ', '', $decryptedaadhar);
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

        $aadhaar = $masked ?: 'இல்லை';
        $pancard = $maskedPan ?: 'இல்லை';

        $l_date = format_date($form->previously_date);
        // Start HTML
        $html .= '
    <table width="100%" cellpadding="5" cellspacing="0" class="tbl-no-border" style="border-collapse: collapse; margin-top:10px;">';

       if ($form->form_name == 'S') {
          
            $html .= '
                <tr >
                    <td colspan="2">
                        <table width="100%" cellpadding="5" cellspacing="0" class="tbl-no-border">
                            <tr>
                                <td width="70%" >7.
                                    இதற்கு முன்பு மின் உதவியாளர் தகுதிச்சான்றிதழுக்கு விண்ணப்பித்துள்ளீர்களா? 
                                    ஆம் என்றால் அதன் எண் மற்றும் தேதியை குறிப்பிடவும்.
                                </td>
                                <td width="30%" >
                                    ' . e($value) . '
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>';
        }


        if ($form->form_name == 'S') {
            $no = '8';
            $html .= renderRow(
                '<h4>'.$no.'. இந்த வாரியம் வழங்கிய கம்பி இணைப்பாளர் திறன் சான்றிதழ் / மேற்பார்வையாளர் திறன் சான்றிதழ் உங்களிடம் உள்ளதா? இருந்தால், அதன் விவரங்களை வழங்கி, அதனை ஒப்படைக்கவும்.</h4>',
                $form->form_name == 'S' ? $certno : $value
            );

            $html .= renderRow(
                '<h4>9. ஆதார் எண்</h4>',
                $aadhaar
            );
    
            $html .= renderRow(
                '<h4>10. நிரந்தர கணக்கு எண்</h4>',
                $pancard
            );

        }else{
            $no = '7';
            if ($form->form_name == 'WH') {
                $html .= renderRow(
                    '<h4>'.$no.'. இந்த வாரியம் வழங்கிய மின் கம்பி உதவியாளர் திறன் சான்றிதழ் உங்களிடம் உள்ளதா? இருந்தால், அதன் விவரங்களை வழங்கி, அதனை ஒப்படைக்கவும்.</h4>',
                    $form->form_name == 'WH' ? $certno : $value
                );
            }else{
                $html .= renderRow(
                    '<h4>'.$no.'. இந்த வாரியம் வழங்கிய கம்பி இணைப்பாளர் திறன் சான்றிதழ் / மின் கம்பி உதவியாளர் திறன் சான்றிதழ் உங்களிடம் உள்ளதா? இருந்தால், அதன் விவரங்களை வழங்கி, அதனை ஒப்படைக்கவும்.</h4>',
                    $certno
                );

            }

            $html .= renderRow(
                '<h4>8. ஆதார் எண்</h4>',
                $aadhaar
            );
    
            $html .= renderRow(
                '<h4>9. நிரந்தர கணக்கு எண்</h4>',
                $pancard
            );
        }



        

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
      // dd($newApplicationId);
      // exit;
        $form= DB::table('tnelb_ea_applications')->where('application_id', $newApplicationId)->first()
                ?? DB::table('tnelb_esa_applications')->where('application_id', $newApplicationId)->first()
                ?? DB::table('tnelb_esb_applications')->where('application_id', $newApplicationId)->first()
                ?? DB::table('tnelb_eb_applications')->where('application_id', $newApplicationId)->first()
                ?? Mst_Form_s_w::where('application_id', $newApplicationId)->first()
                ??TnelbFormP::where('application_id', $newApplicationId)->first();

        $license_name= DB::table('mst_licences')->where('form_code', $form->form_name)->first();
        // $form = Mst_Form_s_w::where('application_id', $newApplicationId)->first();
//  dd($license_name);
//       exit;

        $education = Mst_education::where('application_id', $newApplicationId)->get();
        $experience = Mst_experience::where('application_id', $newApplicationId)->get();
        $documents = Mst_documents::where('application_id', $newApplicationId)->first();
        $payment = DB::table('payments')->where('application_id', $newApplicationId)->first();


        if (!$payment) {
            // dd('111');
            // exit;
            return redirect()->back()->with('error', 'Payment not found!');
        }

        $mpdf = new Mpdf(['default_font_size' => 10]);
        $mpdf->SetFont('arial', '', 10);

        $mpdf->SetTitle('TNELB Payment Receipt ' . $newApplicationId);

           $applType = strtoupper(trim($form->appl_type));
$typeOfForm = ($applType === 'N') ? 'New Application' : 'Renewal Application';
        // $mpdf->SetTitle('TNELB Application License '. $form->license_name .' Form ' . $form->form_name);
       $html = '
            <style>
                .no_space {
                    margin: 3px;
                    line-height: 1.3;
                }
                .table-border td, 
                .table-border th {
                    
                    padding: 6px;
                    font-size: 14px;
                    text-align:left;
                }
            </style>

            <div style="text-align:center;">
                <h3 class="no_space" style="font-size:18px;">GOVERNMENT OF TAMIL NADU</h3>
                <h4 class="no_space" style="font-size:16px;">THE ELECTRICAL LICENSING BOARD</h4>
                <p class="no_space" style="font-size:14px;">Thiru.Vi.Ka. Industrial Estate, Guindy, Chennai – 600 032.</p>
                <h4 class="no_space" style="font-weight:500;">
                    FORM <span style="font-weight:bold;">"'. $form->form_name .'"</span>
                </h4>
                <p class="no_space" style="font-size:16px; font-weight:500;"> Application For "'. $license_name->licence_name .'"</p>
            </div>

            <hr style="margin:10px 0; border:0; border-top:1px solid #000;">
            <p class="section-title" style="font-size:15px; font-weight:bold; margin-top:5px; text-align:center;">Payment Details</p>
            <table class="table-border" style="border-collapse: collapse; width:100%; margin-top:10px;">

                <tr>
                    <th>Application ID</th>
                    <td>: '. $newApplicationId .'</td>
                </tr>

                <tr>
                    <th>Applicant Name </th>
                    <td>: '. $form->applicant_name .'</td>
                </tr>

                  <tr>
                    <th>Type of Form</th>
                    <td>: '. $typeOfForm .'</td>
                </tr>

                <tr>
                    <th>Bank Name</th>
                    <td>: State Bank of India</td>
                </tr>
                <tr>
                    <th>Mode of Payment</th>
                    <td>: UPI</td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                  <td> : ' . \Carbon\Carbon::parse($payment->created_at)->format('d-m-Y') . '</td>

                </tr>
                <tr>
                    <th>Transaction ID</th>
                    <td> : ' . ($payment->transaction_id ?? "N/A") . '</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>: ₹ ' . ($payment->amount ?? "N/A") . '</td>
                </tr>
            </table>';

        $mpdf->WriteHTML($html);
        return response($mpdf->Output('', 'S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="payment_receipt.pdf"');
    }

//     public function downloadPaymentReceipt($newApplicationId)
//     {
//       // dd($newApplicationId);
//       // exit;
//         $form= DB::table('tnelb_ea_applications')->where('application_id', $newApplicationId)->first()
//                 ?? DB::table('tnelb_esa_applications')->where('application_id', $newApplicationId)->first()
//                 ?? DB::table('tnelb_esb_applications')->where('application_id', $newApplicationId)->first()
//                 ?? DB::table('tnelb_eb_applications')->where('application_id', $newApplicationId)->first()
//                 ?? Mst_Form_s_w::where('application_id', $newApplicationId)->first();

//         $license_name= DB::table('mst_licences')->where('form_code', $form->form_name)->first();
//         // $form = Mst_Form_s_w::where('application_id', $newApplicationId)->first();
// //  dd($license_name);
// //       exit;

//         $education = Mst_education::where('application_id', $newApplicationId)->get();
//         $experience = Mst_experience::where('application_id', $newApplicationId)->get();
//         $documents = Mst_documents::where('application_id', $newApplicationId)->first();
//         $payment = DB::table('payments')->where('application_id', $newApplicationId)->first();


//         if (!$payment) {
//             // dd('111');
//             // exit;
//             return redirect()->back()->with('error', 'Payment not found!');
//         }

//         $mpdf = new Mpdf(['default_font_size' => 10]);
//         $mpdf->SetFont('arial', '', 10);

//         $mpdf->SetTitle('TNELB Payment Receipt ' . $newApplicationId);

//            $applType = strtoupper(trim($form->appl_type));
// $typeOfForm = ($applType === 'N') ? 'New Application' : 'Renewal Application';
//         // $mpdf->SetTitle('TNELB Application License '. $form->license_name .' Form ' . $form->form_name);
//        $html = '
//             <style>
//                 .no_space {
//                     margin: 3px;
//                     line-height: 1.3;
//                 }
//                 .table-border td, 
//                 .table-border th {
                    
//                     padding: 6px;
//                     font-size: 14px;
//                     text-align:left;
//                 }
//             </style>

//             <div style="text-align:center;">
//                 <h3 class="no_space" style="font-size:18px;">GOVERNMENT OF TAMIL NADU</h3>
//                 <h4 class="no_space" style="font-size:16px;">THE ELECTRICAL LICENSING BOARD</h4>
//                 <p class="no_space" style="font-size:14px;">Thiru.Vi.Ka. Industrial Estate, Guindy, Chennai – 600 032.</p>
//                 <h4 class="no_space" style="font-weight:500;">
//                     FORM <span style="font-weight:bold;">"'. $form->form_name .'"</span>
//                 </h4>
//                 <p class="no_space" style="font-size:16px; font-weight:500;"> Application For "'. $license_name->licence_name .'"</p>
//             </div>

//             <hr style="margin:10px 0; border:0; border-top:1px solid #000;">
//             <p class="section-title" style="font-size:15px; font-weight:bold; margin-top:5px; text-align:center;">Payment Details</p>
//             <table class="table-border" style="border-collapse: collapse; width:100%; margin-top:10px;">

//                 <tr>
//                     <th>Application ID</th>
//                     <td>: '. $newApplicationId .'</td>
//                 </tr>

//                 <tr>
//                     <th>Applicant Name </th>
//                     <td>: '. $form->applicant_name .'</td>
//                 </tr>

//                   <tr>
//                     <th>Type of Form</th>
//                     <td>: '. $typeOfForm .'</td>
//                 </tr>

//                 <tr>
//                     <th>Bank Name</th>
//                     <td>: State Bank of India</td>
//                 </tr>
//                 <tr>
//                     <th>Mode of Payment</th>
//                     <td>: UPI</td>
//                 </tr>
//                 <tr>
//                     <th>Payment Date</th>
//                   <td> : ' . \Carbon\Carbon::parse($payment->created_at)->format('d-m-Y') . '</td>

//                 </tr>
//                 <tr>
//                     <th>Transaction ID</th>
//                     <td> : ' . ($payment->transaction_id ?? "N/A") . '</td>
//                 </tr>
//                 <tr>
//                     <th>Total Amount</th>
//                     <td>: ₹ ' . ($payment->amount ?? "N/A") . '</td>
//                 </tr>
//             </table>';

//         $mpdf->WriteHTML($html);
//         return response($mpdf->Output('', 'S'), 200)
//             ->header('Content-Type', 'application/pdf')
//             ->header('Content-Disposition', 'inline; filename="payment_receipt.pdf"');
//     }
    public function generateLicensePDF($newApplicationId)
    {
        $form = Mst_Form_s_w::where('application_id', $newApplicationId)->first();
        // var_dump($form->appl_type);die;


        // var_dump($form);die;
        $education = Mst_education::where('application_id', $newApplicationId)->get();
        $experience = Mst_experience::where('application_id', $newApplicationId)->get();
        $applicant_photo = TnelbApplicantPhoto::where('application_id', $newApplicationId)->first();

        if ($form->appl_type == 'R') {
            $license_details = DB::table('tnelb_renewal_license')->where('application_id', $newApplicationId)->first();
        }else{
            $license_details = DB::table('tnelb_license')->where('application_id', $newApplicationId)->first();
        }



        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 10,
            'default_font' => 'helvetica',
            'margin_bottom' => 30
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
            .tbl-no-border td { border: none; padding-bottom: 12px; }
            .photo-cell { text-align:center; }
        </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
        $certificateText = match ($form->form_name) {
            'S' => 'Application for Competency Certificate for Supervisor',
            'W' => 'Application for Competency Certificate for Wireman',
            'WH' => 'Application for Competency Certificate for Wireman Helper',
            default => 'Application for Competency Certificate',
        };
        

                  
        $html  = '<div class="photo-cell">
        <img src="' . public_path($applicant_photo->upload_path) . '" width="120" height="150" style="border:1px solid #000;">
      </div>';

        $html .= '<h3 style="text-align:center;">Supervisor Competency Certificate</h3>';
        $html .= '<h4 style="text-align:center;">License No: <strong>' . $license_details->license_number . '</strong></h4>';

        $html .= '<table class="tbl-no-border" style="margin: 0 auto; width: 70%;">';
        $html .= '  <tr><td class="label">Date of Issue :</td><td class="value">'. format_date($license_details->issued_at) .'</td></tr>';
        $html .= '  <tr><td class="label">Name :</td><td class="value">'. $form->applicant_name .'</td></tr>';
        $html .= '  <tr><td class="label">Father\'s Name :</td><td class="value">'. $form->fathers_name .'</td></tr>';
        $html .= '  <tr><td class="label">Address :</td><td class="value">'. $form->applicants_address .'</td></tr>';
        $html .= '  <tr><td class="label">Date of Birth :</td><td class="value">'. $form->d_o_b .'</td></tr>';
        $html .= '  <tr><td class="label">Qualification :</td><td class="value"></td></tr>';
        $html .= '</table>';


        $html .= '<h4 style="text-align:center;">Renewal:</h4>';

        $html .= '
        <table style="width:100%; border:0;">
            <tr>
                <td class="label" style="text-align:left;">Form:'. format_date($license_details->issued_at) . '</td>
                <td class="label" style="text-align:right;">To:' . format_date($license_details->expires_at) .'</td>
            </tr>
        </table>
        <div style="margin-top: 50px;"><span>Employment Details: </span></div>';
        

        $mpdf->WriteHTML($html);

        $mpdf->SetHTMLFooter('
            <table width="100%" style="font-size: 12px;">
                <tr>
                    <td style="text-align:left;">Secretary, Electrical Licensing Board</td>
                    <td style="text-align:right;">President, Electrical Licensing Board</td>
                </tr>
            </table>
        ');
        return response($mpdf->Output('', 'S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="license.pdf"');

    }
}
