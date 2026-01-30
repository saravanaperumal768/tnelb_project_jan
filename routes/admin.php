<?php
/*
    |--------------------------------------------------------------------------
    | Admin Routes for (Supervisor, Accountant, Secretary, and President)
    |--------------------------------------------------------------------------
    | 
*/

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Admin\ApplicationController;
    use App\Http\Controllers\Admin\AuditorController;
    use App\Http\Controllers\Admin\CaptchaController;
    use App\Http\Controllers\Admin\IndexController;
    use App\Http\Controllers\Admin\LicensepdfController;
    use App\Http\Controllers\Admin\LoginController;
    use App\Http\Controllers\Admin\PresidentController;
    use App\Http\Controllers\Admin\ReportController;
    use App\Http\Controllers\Admin\SecretaryController;
    use App\Http\Controllers\Admin\SupervisorController;
    use App\Http\Controllers\Admin\CompletedApplsController;
    use App\Http\Controllers\FormController;
    use App\Http\Controllers\Admin\LicenseController;
    use App\Http\Controllers\LicenseController as adminlicensecontroller;
    use Illuminate\Http\Request;

// CMS
    use App\Http\Controllers\Admin\AddFormController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\FormBprocessController;
use App\Http\Controllers\Admin\FormsaprocessController;
use App\Http\Controllers\Admin\FormSBprocessController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LicenceManagementController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
    use App\Http\Controllers\Admin\MenuController;
    use App\Http\Controllers\Admin\NewsController;
    use App\Http\Controllers\Admin\PageController;
    use App\Http\Controllers\Admin\RolesController as AdminRolesController;
    use App\Http\Controllers\Admin\RulesController;

    use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\FormBController;
use App\Http\Controllers\MediaController;
    use App\Http\Controllers\RolesController;
    use App\Http\Controllers\PDFController;
// use App\Models\Admin;


    Route::get('/document/{type}/{filename}', [FormController::class, 'showEncryptedDocument'])->name('document.show');
    Route::prefix('admin')->name('admin.')->middleware('web')->group(function () {

           // ----------licensepdf-----------------
        Route::get('/generateForma-pdf/{application_id}', [LicensepdfController::class, 'generateFormaPDF'])->name('generateForma.pdf');

        Route::get('/generateForma_download-pdf/{application_id}', [LicensepdfController::class, 'generateForma_downloadPDF'])->name('generateForma_download.pdf');
        // ----------------------------------------------------------

         // -------------------full license---------------------------------------
            Route::get('/generateFormcontractor_download-pdf/{application_id}', [LicensepdfController::class, 'generateFormcontractor_download'])->name('generateFormcontractor_download.pdf');

        Route::get('/generateFormcontractor_download_tamil-pdf/{application_id}', [LicensepdfController::class, 'generateFormcontractor_download_tamil'])->name('generateFormcontractor_download_tamil.pdf');

        Route::get('/generateFormsa-pdf/{application_id}', [LicensepdfController::class, 'generateFormsaPDF'])->name('generateFormsa.pdf');


        Route::get('/generate-pdf/{application_id}', [LicensepdfController::class, 'generatePDF'])->name('generate.pdf');
        Route::get('/generate-licence-tamil/{application_id}', [LicensepdfController::class, 'generateLicenceTamil'])->name('competency-certificate-tamil.pdf');
        Route::get('/generateLicensePDF/{application_id}', [LicensepdfController::class, 'generateLicensePDF'])->name('generateLicensePDF');

        //New Licence card
        Route::get('/getLicenceDoc/{application_id}', [LicensepdfController::class, 'getLicenceDoc'])->name('getLicenceDoc.pdf');

        // Public Admin Routes
        Route::get('/', [LoginController::class, 'index'])->name('index');

        Route::get('/custom-captcha', [CaptchaController::class, 'generateCaptcha'])->name('custom.captcha');

        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // Authenticated Admin Routes
        Route::middleware(['auth:admin'])->group(function () {


            Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

        // Applicant Details
            Route::get('/get-applicant-details', [LoginController::class, 'getApplicantDetails'])->name('get.applicant.details');
            Route::post('/profile', [LoginController::class, 'profile'])->name('profile');
            Route::get('/applicants_detail/{applicant_id}', [LoginController::class, 'showApplicantDetails'])->name('applicants_detail');

        // Secretary
            Route::get('/secretary_table', [LoginController::class, 'secretary_table'])->name('secretary_table');

        // Supervisor Routes
            Route::get('/view_applications', [SupervisorController::class, 'view_applications'])->name('view_applications');
            Route::get('/view_auditor', [SupervisorController::class, 'view_auditor'])->name('view_auditor');
            Route::get('/get_completed', [SupervisorController::class, 'get_completed'])->name('get_completed');
            Route::get('/get_completed_wh', [SupervisorController::class, 'get_completed_wh'])->name('get_completed_wh');
            Route::post('/forwardApplication/{role}', [SupervisorController::class, 'forwardApplication'])->name('forwardApplication');
            Route::post('/approveApplication', [SupervisorController::class, 'approveApplication'])->name('approveApplication');

        // Secretary Views
            Route::get('/view_secratary', [SecretaryController::class, 'view_secratary'])->name('view_secratary');
            Route::get('/completed_secratary', [SecretaryController::class, 'completed_secratary'])->name('completed_secratary');

        // Application Controller
            Route::get('/get_applications', [ApplicationController::class, 'get_applications'])->name('get_applications');
            Route::get('/get_wh_apps', [ApplicationController::class, 'get_wh_apps'])->name('get_wh_apps');
            Route::get('/view', [AuditorController::class, 'view'])->name('view');
            Route::get('/view_completed', [AuditorController::class, 'view_completed'])->name('view_completed');
            Route::get('/secratary_completed', [SecretaryController::class, 'secratary_completed'])->name('secratary_completed');
            Route::get('/fetch-auditor-data', [AuditorController::class, 'fetchAuditorData'])->name('fetch_auditor_data');


        // President Routes
            Route::get('/view_president', [SecretaryController::class, 'view_president'])->name('view_president');
            Route::get('/completed_pres', [SecretaryController::class, 'completed_pres'])->name('completed_pres');

        // FORM-A Specific
            // Route::get('/view_forma', [SupervisorController::class, 'view_forma'])->name('view_forma');
            Route::get('/view_form/{type}', [SupervisorController::class, 'view_forma'])->name('view_form');


            Route::get('/completed_forma', [SupervisorController::class, 'completed_forma'])->name('completed_forma');

            Route::get('/view_forma_pending/{type}', [AuditorController::class, 'view_forma_pending'])->name('view_forma_pending');

            Route::get('/view_forma_completed', [AuditorController::class, 'view_forma_completed'])->name('view_forma_completed');

            Route::get('/view_sec_forma_pending/{type}', [SecretaryController::class, 'view_sec_forma_pending'])->name('view_sec_forma_pending');


            Route::get('/view_sec_forma_completed', [SecretaryController::class, 'view_sec_forma_completed'])->name('view_sec_forma_completed');
            Route::get('/president_pending_forma/{type}', [PresidentController::class, 'president_pending_forma'])->name('president_pending_forma');

            Route::get('/president_completed_forma/{type}', [PresidentController::class, 'president_completed_forma'])->name('president_completed_forma');

            Route::get('/applicants_detail_forma/{applicant_id}', [LoginController::class, 'applicants_detail_forma'])->name('applicants_detail_forma');

     //form A Completed
            Route::get('/applicants_detail_forma_completed/{applicant_id}', [LoginController::class, 'applicants_detail_forma_completed'])->name('applicants_detail_forma_completed');

//         Route::post('/forwardApplicationforma/{role}', function ($role) {
//     dd('11');   // test right here
// })->name('forwardApplicationforma');

            Route::post('/forwardApplicationforma/{role}', [SupervisorController::class, 'forwardApplicationforma'])->name('forwardApplicationforma');
            Route::post('/approveApplicationForma', [SupervisorController::class, 'approveApplicationForma'])
            ->name('approveApplicationForma');

        // return forma-------------------

            Route::post('/returntoSupervisorforma', [ApplicationController::class, 'returntoSupervisorforma'])->name('returntoSupervisorforma');
        // Route::get('/generateForma-pdf/{application_id}', [LicensepdfController::class, 'generateFormaPDF'])->name('generateForma.pdf');

        // Misc
            Route::post('/returntoSupervisor', [ApplicationController::class, 'returntoSupervisor'])->name('returntoSupervisor');



            /* REPORTS */
            Route::get('/reports', [ReportController::class, 'index'])->name('reports');
            Route::get('/get_whcert', [ReportController::class, 'get_whcert'])->name('get_whcert');
            Route::get('/mic_report', [ReportController::class, 'mic_report'])->name('mic_report');
            Route::post('/get_mic_report', [ReportController::class, 'get_mic_report'])->name('get_mic_report');
            Route::post('/get_filter_data', [ReportController::class, 'get_filter_data'])->name('get_filter_data');

        // Renewal Apps
            Route::get('/renewal_apps', [ApplicationController::class, 'renewal_apps'])->name('renewal_apps');


        // -------------completed applications --------------------


        Route::get('/completed_application/{applicant_id}', [CompletedApplsController::class, 'index'])->name('completed_application');


        // ---------------------------------------------Form S------------------------------------
        Route::get('/completed_formsa', [FormsaprocessController::class, 'completed_formsa'])->name('completed_formsa');
        
        Route::get('/viewformsa', [FormsaprocessController::class, 'view_formsa'])->name('view_formsa');

        Route::get('/applicants_detail_formsa/{applicant_id}', [FormsaprocessController::class, 'applicants_detail_formsa'])->name('applicants_detail_formsa');

     //form A Completed
        Route::get('/applicants_detail_formsa_completed/{applicant_id}', [FormsaprocessController::class, 'applicants_detail_formsa_completed'])->name('applicants_detail_formsa_completed');

        Route::post('/forwardApplicationformsa/{role}', [FormsaprocessController::class, 'forwardApplicationformsa'])->name('forwardApplicationformsa');

        Route::post('/approveApplicationFormsa', [FormsaprocessController::class, 'approveApplicationFormsa'])
            ->name('approveApplicationFormsa');

        Route::get('/view_formsa_pending', [FormsaprocessController::class, 'view_formsa_pending'])->name('view_formsa_pending');

        Route::get('/view_sec_formsa_pending', [FormsaprocessController::class, 'view_sec_formsa_pending'])->name('view_sec_formsa_pending');

        Route::post('/returntoSupervisorformsa', [FormsaprocessController::class, 'returntoSupervisorformsa'])->name('returntoSupervisorformsa');

         Route::get('/president_pending_formsa', [FormsaprocessController::class, 'president_pending_formsa'])->name('president_pending_formsa');

         Route::get('/applicants_detail_formsa_completed/{applicant_id}', [FormsaprocessController::class, 'applicants_detail_formsa_completed'])->name('applicants_detail_formsa_completed');

        Route::get('/view_formsa_completed', [FormsaprocessController::class, 'view_formsa_completed'])->name('view_formsa_completed');

          Route::get('/view_sec_formsa_completed', [FormsaprocessController::class, 'view_sec_formsa_completed'])->name('view_sec_formsa_completed');


           Route::get('/president_completed_formsa', [FormsaprocessController::class, 'president_completed_formsa'])->name('president_completed_formsa');


        // ------------------Form SB--------------------------------

          Route::get('/completed_formsb', [FormSBprocessController::class, 'completed_formsb'])->name('completed_formsb');

          Route::get('/view_formsb_pending', [FormSBprocessController::class, 'view_formsb_pending'])->name('view_formsb_pending');
        
          Route::get('/viewformsb', [FormSBprocessController::class, 'view_formsb'])->name('view_formsb');

          Route::get('/applicants_detail_formsb/{applicant_id}', [FormSBprocessController::class, 'applicants_detail_formsb'])->name('applicants_detail_formsb');

          
        Route::post('/forwardApplicationformsb/{role}', [FormSBprocessController::class, 'forwardApplicationformsb'])->name('forwardApplicationformsb');

        Route::post('/approveApplicationFormsb', [FormSBprocessController::class, 'approveApplicationFormsb'])
            ->name('approveApplicationFormsb');

         Route::post('/returntoSupervisorformsb', [FormSBprocessController::class, 'returntoSupervisorformsb'])->name('returntoSupervisorformsb');


        Route::get('/view_formsb_completed', [FormSBprocessController::class, 'view_formsb_completed'])->name('view_formsb_completed');

                //   ----------Secretary-----------------------
        Route::get('/view_sec_formsb_completed', [FormSBprocessController::class, 'view_sec_formsb_completed'])->name('view_sec_formsb_completed'); 

         Route::get('/view_sec_formsb_pending', [FormSBprocessController::class, 'view_sec_formsb_pending'])->name('view_sec_formsb_pending');

         

        //  -----president------------

         Route::get('/president_completed_formsb', [FormSBprocessController::class, 'president_completed_formsb'])->name('president_completed_formsb');

        Route::get('/president_pending_formsb', [FormSBprocessController::class, 'president_pending_formsb'])->name('president_pending_formsb');


         Route::get('/applicants_detail_formsb_completed/{applicant_id}', [FormSBprocessController::class, 'applicants_detail_formsb_completed'])->name('applicants_detail_formsb_completed');

            //    ---------PDF generate-------------
        Route::get('/generateFormsb-pdf/{application_id}', [LicensepdfController::class, 'generateFormsbPDF'])->name('generateFormsb.pdf');


         // ------------------Form EB--------------------------------

          Route::get('/completed_formb', [FormBprocessController::class, 'completed_formb'])->name('completed_formb');
        
          Route::get('/viewformb', [FormBprocessController::class, 'view_formb'])->name('view_formb');

          Route::get('/applicants_detail_formb/{applicant_id}', [FormBprocessController::class, 'applicants_detail_formb'])->name('applicants_detail_formb');

          
        Route::post('/forwardApplicationformb/{role}', [FormBprocessController::class, 'forwardApplicationformb'])->name('forwardApplicationformb');

        Route::post('/approveApplicationFormb', [FormBprocessController::class, 'approveApplicationFormb'])
            ->name('approveApplicationFormb');

         Route::post('/returntoSupervisorformb', [FormBprocessController::class, 'returntoSupervisorformb'])->name('returntoSupervisorformb');

        //  ---------------Auditor-----------
        Route::get('/view_formb_completed', [FormBprocessController::class, 'view_formb_completed'])->name('view_formb_completed');

        Route::get('/view_formb_pending', [FormBprocessController::class, 'view_formb_pending'])->name('view_formb_pending');

        //   ----------Secretary-----------------------
        Route::get('/view_sec_formb_completed', [FormBprocessController::class, 'view_sec_formb_completed'])->name('view_sec_formb_completed'); 

         Route::get('/view_sec_formb_pending', [FormBprocessController::class, 'view_sec_formb_pending'])->name('view_sec_formb_pending');

        //  -----president------------
        Route::get('/president_completed_formb', [FormBprocessController::class, 'president_completed_formb'])->name('president_completed_formb');

        Route::get('/president_pending_formb', [FormBprocessController::class, 'president_pending_formb'])->name('president_pending_formb');

        //    ---------PDF generate-------------
        Route::get('/generateFormb-pdf/{application_id}', [LicensepdfController::class, 'generateFormbPDF'])->name('generateFormb.pdf');


             //form A Completed
        Route::get('/applicants_detail_formb_completed/{applicant_id}', [FormBprocessController::class, 'applicants_detail_formb_completed'])->name('applicants_detail_formb_completed');



        // // CMS
            Route::get('/homeslider', [LoginController::class, 'homeslider'])->name('homeslider');
            Route::post('/homeslider/insertdata', [LoginController::class, 'insertdata'])->name('homeslider.insertdata');
            Route::put('/homesliderupdate/{id}', [LoginController::class, 'update'])->name('homesliderupdate.update');

            Route::delete('/homesliderdelete/{id}', [LoginController::class, 'delete'])->name('homeslider.delete');
            Route::post('/submenu', [LoginController::class, 'insertsubmenu'])->name('submenu.insertsubmenu');
        // -----------aboutpage------------------
            Route::get('/aboutpage', [LoginController::class, 'aboutpage'])->name('aboutpage');

        // ------------Portaladmin Menu--------------
            Route::get('/menus', [MenuController::class, 'menus'])->name('menus');

        // Insert menu
            Route::post('/menus/insertmenu', [MenuController::class, 'insertmenu'])->name('menus.insertmenu');

        // Update items – use a different path
            Route::post('/menus/updateitems', [MenuController::class, 'updateitems'])->name('menus.updateitems');


            Route::post('/update-menu-positions', [MenuController::class, 'updateMenuPositions'])->name('updateMenuPositions');

            Route::post('/menu', [MenuController::class, 'reorder'])->name('menu.reorder');

            Route::get('/menuscontent/{id}', [MenuController::class, 'showContent'])->name('menuscontent');

            Route::post('/menus/updatemenucontent', [MenuController::class, 'updateMenuContent'])->name('menus.updatecontent');

            Route::post('/menus/{id}/deactivate', [MenuController::class, 'deactivate']);

            Route::post('/menus/{id}/toggle-status', [MenuController::class, 'toggleStatus']);

        // -------------portaladmin submenus---------------

            Route::get('/submenus', [MenuController::class, 'submenus'])->name('submenus');

            Route::post('/submenus/insertsubmenu', [MenuController::class, 'insertsubmenu'])->name('submenus.insertsubmenu');

            Route::post('/submenus/updatesubitems', [MenuController::class, 'updatesubitems'])->name('submenus.updatesubitems');

            Route::post('/submenus/{id}/deactivatesubmenu', [MenuController::class, 'deactivatesubmenu']);

            Route::post('/submenus/{id}/toggle-statussubmenu', [MenuController::class, 'toggleStatussubmenu']);

            Route::post('/submenus', [MenuController::class, 'reorders'])->name('submenu.reorders');

            Route::post('/update-submenu-content', [MenuController::class, 'updateSubmenuContent']);

            Route::get('/submenuscontent/{id}', [MenuController::class, 'showsubContent'])->name('submenuscontent');

            Route::post('/menus/updatesubmenucontent', [MenuController::class, 'updatesubMenuContent'])->name('menus.updatesubcontent');

        // -----------------------newsboard ----------------------------
            Route::get('/newsboard', [NewsController::class, 'index'])->name('newsboard');

            Route::post('/newsboard/insert', [NewsController::class, 'insert'])->name('newsboard.insert');

            Route::post('/newsboard/updateboard', [NewsController::class, 'updateboard'])->name('newsboard.updateboard');

        // Route::post('newsboard/update', [NewsController::class, 'update']);


            Route::post('/newsboard/updatetamil', [NewsController::class, 'updatetamil'])->name('newsboard.updatetamil');

            Route::post('/newsboard/updatenews', [NewsController::class, 'updatenews'])->name('newsboard.updatenews');

            Route::get('/noticeboardcontent/{id}', [NewsController::class, 'showboardContent'])->name('noticeboardcontent');

            Route::post('/newsboard/updatecontent', [NewsController::class, 'updateContent'])->name('newsboard.updatecontent');

            Route::post('/newsboard/updateNewsBoardContent', [NewsController::class, 'updateNewsBoardContent'])->name('newsboard.updateNewsBoardContent');


        // -----------------whatsnew-----------------------
            Route::get('/whatsnew', [NewsController::class, 'whatsnew'])->name('whatsnew');

            Route::post('update-whatsnew', [NewsController::class, 'updateWhatsNew']);

            Route::post('whatsnew/insert', [NewsController::class, 'insertscrolling'])->name('whatsnew.insert');

        // url: "/admin/whatsnew/updatescrollboard", // adjust route accordingly
            Route::post('/whatsnew/updatescrollboard', [NewsController::class, 'updatescrollboard'])->name('whatsnew.updatescrollboard');

        // ------------------------
            Route::get('/galleryimages', [GalleryController::class, 'index'])->name('galleryimages');

            Route::post('/upload-image', [GalleryController::class, 'imageupload'])->name('gallery.imageupload');

            Route::post('/gallery/{id}', [GalleryController::class, 'update']);

            Route::post('gallery/delete/{id}', [GalleryController::class, 'softDelete']);


        Route::post('/galleryinsertimage', [GalleryController::class, 'insertimage'])->name('galleryinsertimage');

        Route::post('/galleryupdateimage', [GalleryController::class, 'galleryupdateimage'])->name('galleryupdateimage');

        // -------------------Rules------------------------------

            Route::get('/rules', [RulesController::class, 'index'])->name('rules');

            Route::get('/roles', [AdminRolesController::class, 'index'])->name('roles');

            Route::post('/staff/insert', [AdminRolesController::class, 'insert'])->name('staff.insert');

            Route::get('/admin/staff/{id}/edit', [AdminRolesController::class, 'edit']);

        // -----------------addnewform------------------------

            Route::get('/addnewform', [AddFormController::class, 'addnewform'])->name('addnewform');

            Route::post('forms/newforminsert', [AddFormController::class, 'newforminsert']);

            Route::get('/form_instructions/{id}', [AddFormController::class, 'form_instructions'])->name('form_instructions');

        // form_instructions
            Route::post('/formcontent/updateforminstructions', [AddFormController::class, 'updateforminstructions'])->name('formcontent.updateforminstructions');

            Route::post('/forms/updateform', [AddFormController::class, 'updateform'])->name('forms.updateform');

            Route::get('/form_history/{formid}', [AddFormController::class, 'form_history'])->name('form_history');


        // -----------------staffs--------------

            Route::get('/stafflist', [StaffController::class, 'index'])->name('stafflist');

            Route::post('/staff/insertstaff', [StaffController::class, 'insertStaff'])->name('insertstaff');

            Route::post('/staff/updatestaff', [StaffController::class, 'updateStaff'])->name('updatestaff');

        // ---------------Main pages Content--------------------------

            Route::get('/pagecontent/{slug_id}', [PageController::class, 'index'])->name('pagecontent');

        // ---------------Sub pages Content--------------------------

            Route::get('/subpagecontent/{slug_id}', [PageController::class, 'subpageshow'])->name('subpagecontent');

        // -------------------------------------------------
            Route::get('/membermaster', [PageController::class, 'membershow'])->name('membermaster');

        // -----------------------
            Route::get('/contactdetails', [PageController::class, 'contactdetails'])->name('contactdetails');

            Route::post('contact/updatecontact', [PageController::class, 'updatecontact'])->name('contact.updatecontact');

            Route::get('/quicklinks', [PageController::class, 'quicklinksshow'])->name('quicklinks');

            Route::post('/quicklinks/insertquicklinks', [MenuController::class, 'insertquicklinks'])->name('quicklinks.insertquicklinks');

            Route::post('/quicklinks/quicklinksedit', [MenuController::class, 'editquicklinks'])->name('quicklinks.editquicklinks');

            Route::get('/quicklinkscontent/{id}', [PageController::class, 'showquicklinksContent'])->name('quicklinkscontent');

            Route::post('/quicklinkscontent/updatequicklinkcontent', [PageController::class, 'updatequicklinkcontent'])->name('quicklinkscontent.updatequicklinkcontent');

        // --------------------------------usefullinks-------------------

            Route::get('/usefullinks', [PageController::class, 'usefullinks'])->name('usefullinks');


            Route::post('/usefullinks/insertusefullinks', [PageController::class, 'insertusefullinks'])->name('usefullinks.insertusefullinks');


            Route::post('/usefullinks/updatelinks', [PageController::class, 'updatelinks'])->name('usefullinks.updatelinks');

            Route::get('/usefullinkscontent/{id}', [PageController::class, 'usefullinkscontent'])->name('usefullinkscontent');

            Route::post('/usefullinkscontent/updateusefullinkscontent', [PageController::class, 'updateusefullinkscontent'])->name('usefullinkscontent.updateusefullinkscontent');

      //   -----------------------footer bottom---------------------
            Route::get('/footerbottom', [PageController::class, 'footerbottom'])->name('footerbottom');

            Route::post('/footerbottomlinks/insertfooterbottomlinks', [PageController::class, 'insertfooterbottomlinks'])->name('footerbottomlinks.insertfooterbottomlinks');

            Route::post('/editfooterbottomlinks/updatebottomlinks', [PageController::class, 'updatebottomlinks'])->name('editfooterbottomlinks.updatebottomlinks');

            Route::get('/footerbottomlinkscontent/{id}', [PageController::class, 'footerbottomcontent'])->name('footerbottomlinkscontent');

            Route::post('/footerbottomlinkscontent/updatefootercontent', [PageController::class, 'updatefootercontent'])->name('footerbottomlinkscontent.updatefootercontent');

            Route::post('/footerbottom/updatecopyrights', [PageController::class, 'updatecopyrights'])->name('footerbottom.updatecopyrights');

    //  --------------------Media----------------------
            Route::get('/media', [AdminMediaController::class, 'home'])->name('media');

            Route::post('/media/insertmedia', [AdminMediaController::class, 'insertmedia'])->name('media.insertmedia');

            Route::post('media/delete/{id}', [AdminMediaController::class, 'softDelete']);

            Route::post('/media/updatemedia', [AdminMediaController::class, 'updatemedia'])->name('media.updatemedia');

            Route::post('/verifylicense', [LicenseController::class, 'verifylicense'])->name('verifylicense');


         //  ---------------------------------------Form A admin Dashboard----------------------

            Route::post('/verify-license', [adminlicensecontroller::class, 'verifyLicenseFormAccc_admin'])->name('verify.license.formAccc_admin');


            Route::post('/verify-license_EA', [adminlicensecontroller::class, 'verifylicenseformAea_admin'])
            ->name('verifylicenseformAea_admin');


            Route::post('/verify-license_staff', [adminlicensecontroller::class, 'verifyLicenseFormAccc_adminstaff'])
            ->name('verifyLicenseFormAccc_adminstaff');

            // -----------------------------------------------------history-----------------------------

             Route::post('/history-result_staff', [adminlicensecontroller::class, 'history_resultstaff'])
            ->name('history_resultstaff');



        Route::post('/rejectApplication', [ApplicationController::class, 'rejectApplication'])->name('rejectApplication');


        Route::get('/get_rejected', [ApplicationController::class, 'get_rejected'])->name('get_rejected');
        Route::get('/view_rejected', [AuditorController::class, 'view_rejected'])->name('view_rejected');
        Route::get('/view_application_details/{applicant_id}', [LoginController::class, 'view_application_details'])->name('view_application_details');


        // Fees  Details---------------------

            // -------------------Equipment add----------------------
            Route::get('/equiplist', [EquipmentController::class, 'index'])->name('equiplist');
            
            Route::post('/equipment/updateStatus',[EquipmentController::class, 'updateStatus'])->name('equipment.updateStatus');

            Route::post('/equipment/operations', [EquipmentController::class, 'operations'])->name('equipment.operations');

            // ------------------------------------------

            Route::get('/fees_validity', [LicenceManagementController::class, 'index'])->name('fees_validity');
            Route::post('/licences/updateFees', [LicenceManagementController::class, 'updateFees'])->name('updateFees');
            Route::post('/licences/updateForm', [LicenceManagementController::class, 'updateForm'])->name('updateForm');
            Route::post('/licences/formHistory', [LicenceManagementController::class, 'formHistory'])->name('formHistory');
            Route::get('/licences/licenceCategory', [LicenceManagementController::class, 'licenceCategory'])->name('licenceCategory');
            
            Route::post('/licences/add_category', [LicenceManagementController::class, 'add_category'])->name('add_category');
            Route::get('/licences/view_licences', [LicenceManagementController::class, 'view_licences'])->name('view_licences');
            Route::post('/licences/add_licence', [LicenceManagementController::class, 'add_licence'])->name('add_licence');
            Route::post('/licences/updateValidity', [LicenceManagementController::class, 'updateValidity'])->name('updateValidity');

            Route::get('/management', [LicenceManagementController::class, 'management'])->name('management');

            Route::post('/licence/store', [LicenceManagementController::class, 'store'])->name('licence.store');
            Route::post('/licence/update/{id}', [LicenceManagementController::class, 'update'])->name('licence.update');
            Route::post('/licence/updateInstruct', [LicenceManagementController::class, 'updateInstruct'])->name('licence.updateInstruct');
            Route::post('/licence/getInstruction', [LicenceManagementController::class, 'getInstruction'])->name('licence.getInstruction');


            // -------checkallvalidity--------------
          Route::post('/checkallvalidity', [adminlicensecontroller::class, 'check_ealicence_validity'])
           ->name('checkallvalidity');


        });


});
