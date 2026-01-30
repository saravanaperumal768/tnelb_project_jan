<!DOCTYPE html>
<html lang="en">

@php
use Illuminate\Support\Facades\Auth;
@endphp

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'TNELB - Home')</title>

    <!-- Stylesheets -->
  <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/color-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/page_top.css') }}" rel="stylesheet">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
   
    <link href="{{ asset('assets/admin/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&family=Merriweather:ital@0;1&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <style>
        .instruct li {
            list-style: unset;
        }

        #verify_btn {
            min-width: 80px;  /* or whatever suits */
            height: 38px;     /* match your .form-control height */
            line-height: 1.5;
            white-space: nowrap;
            overflow: hidden;
        }

        #verify_result{
            color: red;
        }

        .swal2-icon-content {
            font-size: 1.75em;
        }

        .swal2-icon.swal2-info.swal2-icon-show {
            width: 0px;
            height: 21px;
            margin-top: 10px;
        }

        h2#swal2-title {
            padding: 0.3em 1em 0;
        }

       button.btn-close.btn-close-white {
            background: red;
            padding: 6px;
            color: #fff;
        }

        


        .show-list-numbers ol {
            list-style-type: decimal !important;
            list-style-position: outside !important;
            margin-left: 20px !important;
            padding-left: 20px !important;
        }

        .show-list-numbers ul {
            list-style-type: disc !important;
            list-style-position: outside !important;
            margin-left: 20px !important;
            padding-left: 20px !important;
        }

        /* This is the magic fix */
        .show-list-numbers ol li {
            list-style-type: decimal !important;
            display: list-item !important;
        }

        .show-list-numbers ul li {
            list-style-type: disc !important;
            display: list-item !important;
        }

        .info-grid {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 8px 20px;
            font-size: 14px;
        }

        .info-grid .label {
            font-weight: bold;
        }

        .stylish-divider {
            position: relative;
            padding-right: 20px;
        }

        .stylish-divider::after {
            content: "";
            position: absolute;
            top: 20px;
            bottom: 20px;
            right: 0;
            width: 3px;
            background-color: #0d6efd;
            box-shadow: 0 0 6px rgba(13,110,253,0.5);
            border-radius: 10px;
        }

        .swal2-timer-progress-bar {
            background-color: #035ab3 !important; /* Red */
        }

    </style>
</head>
<script>
    const BASE_URL = "{{ UrlHelper::baseFileUrl() }}";
    
</script>

<body class="theme-color-two">

    <!-- Modal -->
<!-- Declaration Modal -->
<div class="modal fade" id="declarationModal" tabindex="-1" aria-labelledby="declarationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" style="font-family: Georgia, 'Times New Roman', serif; font-size: 16px; line-height: 1.6;">
        <div class="modal-header text-white">
          <h4 class="modal-title" id="declarationModalLabel">📋 Instructions & Declaration</h4>
          <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">X</button>
        </div>
  
        <div class="modal-body" style="padding: 30px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.8; color: #333;">
            <p style="font-size: 17px; font-weight: 600; margin-bottom: 20px;">
              📋 Please read and confirm the following carefully:
            </p>
          
            <ol class="instruct" style="margin-left: 20px; padding-left: 10px;">
              <li>
                Fees for the issue of <span style=" font-weight: 600;">‘EA’ Contractor licence</span> from 
                <span>01.01.2024</span> onwards is 
                <span id="ea_fees" style="color: #dc3545; font-weight: 600;">Rs.30,000/-</span>.
                <br>
                <ol type="i" style="margin-left: 20px; margin-top: 5px;">
                  <li>
                    <span style=" font-weight: 600;">Mode of Payment:</span> Fees should be sent in favour of the <strong>Secretary, Electrical Licensing Board, Chennai</strong> by Bank Demand Draft obtained from any <span style="">Scheduled Bank</span> or <span style="">Co-operative Bank</span> payable at Chennai. 
                    <em style="color: #6c757d;">Remittance of fees by any other method will not be accepted.</em>
                  </li>
                </ol>
              </li>
          
              <li>
                The <span style=" font-weight: 600;">Proprietor</span> or the <span style=" font-weight: 600;">Managing Partner/Director</span> must be at least 
                <span style="color: #198754; font-weight: 600;">25 years old</span> and should have passed a minimum educational qualification of 
                <span style="color: #198754; font-weight: 600;">VIII Standard</span>.
              </li>
          
              <li>
                <span style=" font-weight: 600;">Establishment:</span> The applicant shall employ the following minimum staff on a full-time basis solely for the purpose of contract works:
                <div style="margin-left: 20px;">
                  One <span style=" font-weight: 600;">Supervisor</span> holding <span style="">Supervisor Competency Certificate</span> granted by the Board with a minimum Technical Educational qualification of a <span style="color: #198754; font-weight: 600;">Diploma in Electrical Engineering</span>…
                </div>
              </li>
          
              <li>
                <span style=" font-weight: 600;">Instruments:</span> The applicant must possess the following instruments:
                <ul style="margin-left: 20px; list-style-type: disc;">
                  <li>Earth Resistance Tester</li>
                  <li>500 Volts Insulation Tester</li>
                  <li>1000 Volts Insulation Tester</li>
                  <li>Phase Sequence Indicator</li>
                  <li>Tong Type Ammeter</li>
                  <li>Live Line Tester</li>
                  <li>Portable Voltmeter (Hand Operated)</li>
                </ul>
              </li>
          
              <li>
                <span style=" font-weight: 600;">Financial Status:</span> The applicant shall produce a <span style=" font-weight: 600;">Bank Solvency Certificate</span> for 
                <span style="color: #dc3545; font-weight: 600;">Rs.50,000/-</span> in <strong>Form ‘G’</strong>…
              </li>
            </ol>
          
            <div class="form-check mt-4">
              <input type="checkbox" class="form-check-input" id="declaration-agree">
              <label for="declaration-agree" class="form-check-label" style="font-weight: 600;">
                I have read and agree to the above terms.
              </label>
              <div class="text-danger mt-2 d-none" id="declaration-error">
                You must agree to proceed.
              </div>
            </div>
          </div>
  
        <div class="modal-footer text-center" style="padding: 20px;justify-content: center;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="ea_declarationProceedBtn">Proceed</button>
        </div>
      </div>
    </div>
  </div>

<!-- Declaration Modal for competency certificate-->


  <div class="modal fade" id="competencyInstructionsModal" tabindex="-1" aria-labelledby="competencyInstructionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background-color: white;">
          <h5 class="modal-title" id="competencyInstructionsModalLabel">📋 Instructions & Declaration</h5>
          <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body" style="padding: 30px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.8; color: #333;">
          <div class="show-list-numbers">
            1) (i) Fees Issue for <span id="certificate_name"></span> from <span id="fees_starts_from"></span> onwards is <span id="form_fees" style="color:#1f6920; font-weight:600;"></span>
            
          </div>
          <div id="instructionContent" class="show-list-numbers"></div>
          {{-- <ol class="instruct" style="margin-left: 20px; padding-left: 10px;">
            <li>
              <span style="font-weight: 600;">Fees:</span> 
              <ol type="i" style="margin-left: 20px; margin-top: 5px;">
                <li>Fees Issue for Supervisor Competency Certificate from <span>01.01.2024</span> onwards is <span id="form_fees" style="color:#1f6920; font-weight:600;"></span>.</li>
                <li>The fee must be paid by Demand Draft from any <span>Scheduled Bank</span> or <span">Co-operative Bank</span>, in favour of Secretary, Electrical Licensing Board, Chennai – 600 032, payable at Chennai. Other methods of payment will not be accepted.</li>
              </ol>
            </li>
  
            <li>
              The <span style="font-weight:600;">applicant’s signature</span> and <span style="font-weight:600;">photo</span> affixed in the application must be attested by a <span>Gazetted Officer</span>. Out of three photos, one should be affixed in the application and attested.
            </li>
  
            <li>
              <span style="font-weight:600;">With Experience:</span>
              <ul style="margin-left: 20px; list-style-type: disc;">
                <li>Two years experience in erection or operation and maintenance in High Voltage installation.</li>
                    <span class="font-size: 10px;">(OR)</span>
                <li>The applicant should hold a Supervisor Competency Certificate from the Department of Technical Education, Chennai.</li>
              </ul>
            </li>
  
            <li>
              The applicant should possess a <span>Diploma</span> or <span style="font-weight:600;">Degree</span> in Electrical Engineering or an <span style="font-weight:600;">A.M.I.E.</span> Certificate (Part A & B).
            </li>
  
            <li>
              <span style="font-weight:600;">Photographs:</span> Three passport-size photographs (6cm x 4cm), taken within the last three months, must be provided.
            </li>
  
            <li>
              <span style="font-weight:600;">Signature:</span> Applicant’s signature in triplicate on a separate sheet of paper must be provided.
            </li>
  
            <li>
              <span style="font-weight:600;">Proof of Age:</span> Original and photocopy of age proof document must be submitted.
            </li>
  
            <li>
              <span style="font-weight:600;">Application Form:</span> All columns must be filled clearly in words and figures. No column should be left blank.
            </li>
  
            <li>
              Application should be in the prescribed form only.
            </li>
          </ol> --}}
  
          <div class="form-check mt-4">
            <input type="checkbox" class="form-check-input" id="declaration-agree-renew">
            <label for="declaration-agree-renew" class="form-check-label" style="font-weight: 600;">
              I have read and agree to the above instructions.
            </label>
            <div class="text-danger mt-2 d-none" id="declaration-error-renew">
              Please agree the above instructions.
            </div>
          </div>
        </div>
  
        <div class="modal-footer" style="justify-content: center;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="proceedPayment">Proceed</button>
        </div>
      </div>
    </div>
  </div>


<!-- -----contractor license ------------------- -->
  <div class="modal fade" id="contractorInstructionsModal" tabindex="-1" aria-labelledby="contractorInstructionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background-color: white;">
          <h5 class="modal-title" id="contractorInstructionsModalLabel">📋 Instructions & Declaration</h5>
          <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body" style="padding: 30px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.8; color: #333;">
          
         <ol class="instruct" style="color:#000!important;"></ol>

  
          <div class="form-check mt-4">
            <input type="checkbox" class="form-check-input" id="declaration-agree-renew-contractor">
            <label for="declaration-agree-renew-contractor" class="form-check-label" style="font-weight: 600;">
              I have read and agree to the above instructions.
            </label>
            <div class="text-danger mt-2 d-none" id="declaration-error-renew-contractor">
              Please agree the above instructions.
            </div>
          </div>
        </div>
  
        <div class="modal-footer" style="justify-content: center;">
         
          <button type="button" class="btn btn-primary" id="proceedPayment">Proceed</button>
           <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- --------------------------------------------- -->

  <div class="modal fade" id="competencyInstructionsModalP" tabindex="-1" aria-labelledby="competencyInstructionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background- color: white;">
          <h5 class="modal-title" id="competencyInstructionsModalLabel">📋 Instructions & Declaration</h5>
          <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body" style="padding: 30px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.8; color: #333;">
          <div class="show-list-numbers">
            <ul>
              <li>Fees Issue for <span id="p_certificate_name"></span> from <span id="p_fees_starts_from"></span> onwards is <span id="p_form_fees" style="color:#1f6920; font-weight:600;"></span>.</li>
            </ul>
          </div>
          <div id="instructionContent" class="show-list-numbers"></div>
  
          <div class="form-check mt-4">
            <input type="checkbox" class="form-check-input" id="declaration-agree-renew">
            <label for="declaration-agree-renew" class="form-check-label" style="font-weight: 600;">
              I have read and agree to the above instructions.
            </label>
            <div class="text-danger mt-2 d-none" id="declaration-error-renew">
              Please agree the above instructions.
            </div>
          </div>
        </div>
        <div class="modal-footer" style="justify-content: center;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="proceedtoPayment">Proceed</button>
        </div>
      </div>
    </div>
  </div>

  <!-- --------------------------------------------- -->
<!-- payment success modal for contractor License -->
<div class="modal fade" id="paymentSuccessModalcontractor" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-3">

            <div class="modal-header border-0">
                <h4 class="text-success w-100 text-center m-0">
                    Payment Successful !
                </h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <!-- LEFT INFO PANEL -->
                    <div class="col-md-6 stylish-divider">
                        <div class="info-grid">
                            <div class="label">Application ID:</div>
                            <div class="value" id="ps_applicationId"></div>

                            <div class="label">Applicant Name <br>[Contractor Licence]:</div>
                            <div class="value" id="ps_applicantName"></div>

                            <div class="label">Type of Application:</div>
                            <div class="value" id="ps_licenceName"></div>

                            <div class="label">Transaction ID:</div>
                            <div class="value" id="ps_transactionId"></div>

                            <div class="label">Transaction Date:</div>
                            <div class="value" id="ps_transactionDate"></div>

                            <div class="label">Amount Paid:</div>
                            <div><span>Rs.</span><span class="value" id="ps_amount"></span></div>
                        </div>
                    </div>

                    <!-- RIGHT DOWNLOAD PANEL -->
                    <div class="col-md-6 text-center">
                        <p class="fw-bold">Download Your Payment Receipt:</p>
                        <button class="btn btn-info btn-sm mb-2" onclick="paymentreceiptformA()">
                            <i class="fa fa-file-pdf-o text-danger"></i>
                            Download Receipt
                        </button>

                        <p class="fw-bold mt-3">Download Your Application PDF:</p>

                        <button class="btn btn-primary btn-sm me-2" onclick="downloadPDFformApdf()">
                            <i class="fa fa-file-pdf-o text-danger"></i> English
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 justify-content-center">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            </div>

        </div>
    </div>
</div>

  <!-- --------------------------------------------- -->





<!-- Payment Success Modal -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content p-3">

          <div class="modal-header border-0">
              <h4 class="text-success w-100 text-center m-0">
                  Payment Successful!
              </h4>
          </div>

          <div class="modal-body">
              <div class="row">

                  <!-- LEFT INFO PANEL -->
                  <div class="col-md-6 stylish-divider">
                      <div class="info-grid">
                          <div class="label">Application ID:</div>
                          <div class="value" id="ps_applicationId_competency">11</div>

                          <div class="label">Applicant Name:</div>
                          <div class="value" id="ps_applicantName_competency"></div>

                          <div class="label">Type of Application:</div>
                          <div class="value" id="ps_licenceName_competency"></div>

                          <div class="label">Transaction ID:</div>
                          <div class="value" id="ps_transactionId_competency"></div>

                          <div class="label">Transaction Date:</div>
                          <div class="value" id="ps_transactionDate_competency"></div>

                          <div class="label">Amount Paid:</div>
                          <div><span>Rs.</span>
                              <span class="value" id="ps_amount_competency"></span>
                          </div>
                      </div>
                  </div>

                  <!-- RIGHT DOWNLOAD PANEL -->
                  <div class="col-md-6 text-center">

                      <p class="fw-bold">Download Your Payment Receipt:</p>
                      <button class="btn btn-info btn-sm mb-2" onclick="paymentreceipt()">
                          <i class="fa fa-file-pdf-o text-danger"></i>
                          Download Receipt
                      </button>

                      <p class="fw-bold mt-3">Download Your Application PDF:</p>

                      <button class="btn btn-primary btn-sm me-2" onclick="downloadPDF('english')">
                          <i class="fa fa-file-pdf-o text-danger"></i> English
                      </button>

                      <button class="btn btn-success btn-sm" onclick="downloadPDF('tamil')">
                          <i class="fa fa-file-pdf-o text-danger"></i> Tamil
                      </button>

                  </div>
              </div>
          </div>

          <div class="modal-footer border-0 justify-content-center">
               <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
          </div>

      </div>
  </div>
</div>

  <!-- --------------------------------------------- -->
    <div class="page-wrapper">
       <div class="loader-wrap">
            <div class="preloader"></div>
            <div class="layer layer-one"><span class="overlay"></span></div>
            <div class="layer layer-two"><span class="overlay"></span></div>
            <div class="layer layer-three"><span class="overlay"></span></div>
        </div>
        <div class="content ">

            <!-- Main Header -->
            <header class="main-header header-style-two ">

                <!-- Header Top two -->
                <div class="header-top-two bg-gray">
                    <div class="auto-container">
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <ul class="top-info text-center text-md-left">
                                    <li>
                                        <!-- <i class="fas fa-map-marker-alt"></i> -->
                                        <p class="info-text color-dark">Government of TamilNadu | TamilNadu Electricity
                                            Licencing Board</p>
                                    </li>
                                </ul>
                            </div>
                            <!--/ Top info end -->

                            <div class="col-lg-4 col-md-4 top-social text-center text-md-right">
                                <ul class="list-unstyled">
                                    <li><a rel="noopener" href="#mainsection" title="Skip to main content"> <i
                                                class="fa fa-share-square"></i></a></li>
                                    <li><span class="toolbarline"></span></li>
                                    <li><a href="#" class="searchBox">
                                            <input class="searchInput" type="text" name="" placeholder="Search"
                                                id="txt_search" required="">
                                            <button class="searchButton" onclick="google_search();" href="#">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </a>
                                    </li>
                                    <li><span class="toolbarline"></span></li>
                                    <li><a rel="noopener" href="sitemap.php"><i class="fa fa-sitemap"></i></a></li>
                                    <li><span class="toolbarline"></span></li>
                                    <li class="dropdown-submenu">
                                        <a href="#" class="subhover" tabindex="-1"> <i class=" fa fa-wheelchair"></i></a>

                                    </li>
                                    <li><span class="toolbarline"></span></li>
                                    <li><a rel="noopener" href="screenreader.php" title="Screen Reader Access"> <i
                                                class="fa fa-volume-up"></i></a></li>

                                    <li><span class="toolbarline"></span></li>
                                    <li class="dropdown-submenu">
                                        <a href="#" class="subhover" tabindex="-1"> <i class="fa fa-globe"></i></a>

                                    </li>
                                    <li><span class="toolbarline"></span></li>
                                    <li><a rel="noopener" href="#" title="Google translator"><i
                                                class="fa fa-language"></i></a></li>
                                </ul>
                            </div>
                            <!--/ Top social end -->
                        </div>


                    </div>
                </div>
                <!-- <pre>{{ print_r(session()->all(), true) }}</pre> -->

                <div class="logo-fun">
                    <div class="container">
                        <div class="row">
                            @if(Auth::check())
                            <div class="col-lg-8 col-md-12">
                                <div class="flex-shrink-0 mr-3 mr-xl-8 mr-xlwd-16 d-none d-md-block">
                                    <a href="/logout">
                                        <img src="{{ asset('assets/images/logo/logo.png') }}" class="img-fluid" alt="tnelb" />
                                    </a>
                                </div>

                                <div class="flex-shrink-0 mr-3 mr-xl-8 mr-xlwd-16 d-block d-lg-none">
                                    <a href="/logout">
                                        <img src="{{ asset('assets/images/logo/logo_mobile.png') }}" class="img-fluid" alt="tnelb" />
                                    </a>
                                </div>
                            </div>
                            @else
                            <div class="col-lg-8 col-md-12">
                                <div class="flex-shrink-0 mr-3 mr-xl-8 mr-xlwd-16 d-none d-md-block">
                                    <a href="/">
                                        <img src="{{ asset('assets/images/logo/logo.png') }}" class="img-fluid" alt="tnelb" />
                                    </a>
                                </div>

                                <div class="flex-shrink-0 mr-3 mr-xl-8 mr-xlwd-16 d-block d-lg-none">
                                    <a href="/">
                                        <img src="{{ asset('assets/images/logo/logo_mobile.png') }}" class="img-fluid" alt="tnelb" />
                                    </a>
                                </div>
                            </div>
                            @endif

                            <div class="col-lg-4 col-md-12 text-center">
                                <ul class="top-info-box">
                                    @if(Auth::check())
                                    <li class="header-get-a-quote">
                                        <div class="profile">
                                            <div class="user">
                                               <a class="btn btn-success text-white text-capitalize">
                                                    <i class="fa fa-user-circle-o"></i>&nbsp; {{ Auth::user()->salutation.'.'.Auth::user()->first_name.' '.Auth::user()->last_name }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="menu">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('dashboard') }}">
                                                        <i class="fa fa-dashboard"></i>&nbsp;Dashboard
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('logout') }}">
                                                        <i class="fa fa-sign-out"></i>&nbsp;Log Out
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    @else
                                    <li class="header-get-a-quote">
                                        <a class="btn btn-primary" href="{{ route('login') }}">Applicant Sign In/ Sign Up</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>



                <!-- Header Upper -->
                <div class="header-upper">
                    <div class="auto-container">
                        <div class="inner-container">

                            <!--Nav Box-->
                            <div class="nav-outer">
                                <!--Mobile Navigation Toggler-->
                                <div class="mobile-nav-toggler"><img src="{{ asset('assets/images/icons/icon-bar-2.png') }}" alt=""></div>
                                <div class="search-form-two text-md-right display_desk">
                                    <form>
                                        <input type="search" placeholder="Search ...">
                                        <button type="submit"><i class="icon-search"></i></button>
                                    </form>
                                </div>
                                <!-- Main Menu -->
                                <nav class="main-menu navbar-expand-md navbar-light">
                                    <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                        <ul class="navigation">


                                            <!-- Hidden Logout Form -->
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            @foreach($menu as $main)
                                            @php
                                            $page = $main->menuPage;
                                            $link = '#';
                                            $target = '';

                                            if ($page) {
                                            if ($page->page_type == 'url') {
                                            $link = $page->external_url ?? '#';
                                            $target = ' target="_blank"';
                                            } elseif ($page->page_type == 'pdf') {
                                            $link = asset($page->pdf_en ?? '');
                                            $target = ' target="_blank"';
                                            } else {
                                            $link = $page->page_url ?? '#';
                                            $target = ''; // open in same tab
                                            }
                                            }

                                            $childMenus = $submenu->where('parent_code', $main->id);
                                            @endphp

                                            <li class="dropdown">
                                                   <a href="{{ $page && $page->page_type == 'url' ? $link : url($link) }}" {!! $target !!}>
														{{ $main->menu_name_en }}
													</a>

                                                @if($childMenus->isNotEmpty())
                                                <ul>
                                                   @foreach($childMenus as $child)
														@php
															$childPage   = $child->submenuPage;
															$childLink   = '#';
															$childTarget = '';

															if ($childPage) {
																if ($childPage->page_type == 'url') {
																	// External URL
																	$childLink   = $childPage->external_url ?? '#';
																	$childTarget = ' target="_blank"';

																} elseif ($childPage->page_type == 'pdf') {
																	// PDF file stored locally
																	$childLink   = url($childPage->pdf_en ?? '#'); 
																	$childTarget = ' target="_blank"';

																} else {
																	// Internal page → prepend APP_URL automatically
																	$childLink   = url($childPage->page_url ?? '#'); 
																	$childTarget = '';
																}
															}
														@endphp

														<li>
															<a href="{{ $childLink }}" {!! $childTarget !!}>{{ $child->menu_name_en }}</a>
														</li>
													@endforeach

                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach



                                            <!-- <li class="dropdown">
                                                <a href="#">About</a>
                                                <ul>
                                                    <li><a href="about">About</a></li>
                                                    <li><a href="vision">Vision</a></li>
                                                    <li><a href="mission">Mission</a></li>
                                                    <li><a href="future-scenario">Future Scenario</a></li>
                                                </ul>
                                            </li>

                                            <li><a href="members">Members</a></li>
                                            <li><a href="rules">Rules</a></li>
                                            <li><a href="services-and-standards">Services & Standards</a></li>
                                            <li><a href="complaints">Complaints</a></li>
                                           


                                            <li><a href="contact">Contact</a></li> -->

                                            @if(Auth::check())
                                            <li class="dropdown">
                                                <a href="#">Forms</a>
                                                <ul>
                                                    <li><a href="{{ route('apply-form-wh')}}">Form WH</a></li>
                                                    <li><a href="{{ route('apply-form-w')}}">Form W</a></li>
                                                    <li><a href="{{ route('apply-form-s')}}">Form S</a></li>
                                                    <li><a href="{{ route('apply-form-s')}}">Form P</a></li>
                                                    <!-- <li><a href="#">Form H TO B</a></li> -->
                                                     <li><a href="{{ route('apply-form-a')}}">Form A</a></li>
                                                    <li><a href="{{ route('apply-form-b')}}">Form EB</a></li>
                                                    <li><a href="{{ route('apply-form-sb')}}">Form SB</a></li>
                                                    <li><a href="{{ route('apply-form-sa')}}">Form SA</a></li>
                                                    <!-- <li><a href="#">Form SA</a></li> -->
                                                    <li><a href="#">Fees Structure</a></li>
                                                    <li><a href="#">Renewal Particulars (English)</a></li>
                                                    <li><a href="#">Renewal Particulars (Tamil)</a></li>
                                                </ul>
                                            </li>
                                            @else
                                            <li class="dropdown">
                                                <a href="#">Forms</a>
                                                <ul>

                                                    <li><a href="login">Form WH</a></li>
                                                    <li><a href="login">Form W</a></li>
                                                    <li><a href="login">Form S</a></li>
                                                    <li><a href="login">Form P</a></li>
                                                    <li><a href="login">Form H TO B</a></li>
                                                    <li><a href="login">Form EB</a></li>
                                                    <li><a href="login">Form SB</a></li>
                                                    <li><a href="login">Form A</a></li>
                                                    <li><a href="login">Form SA</a></li>
                                                    <li><a href="login">Fees Structure</a></li>
                                                    <li><a href="login">Renewal Particulars (English)</a></li>
                                                    <li><a href="login">Renewal Particulars (Tamil)</a></li>
                                                </ul>
                                            </li>
                                            @endif

                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <div class="navbar-right">
                                <div class="search-form-two">
                                    <form>
                                        <input type="search" placeholder="Search ...">
                                        <button type="submit"><i class="icon-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Header Upper-->


                <!-- Sticky Header  -->
                <div class="sticky-header">
                    <div class="header-upper">
                        <div class="auto-container">
                            <div class="inner-container">

                                <div class="nav-outer">
                                    <!--Mobile Navigation Toggler-->
                                    <div class="mobile-nav-toggler">
                                        <img src="{{ asset('assets/images/icons/icon-bar-2.png') }}" alt="">
                                    </div>
                                    <!-- Main Menu -->
                                    <nav class="main-menu navbar-expand-md navbar-light">
                                    </nav>
                                </div>
                                <div class="navbar-right">
                                    <div class="search-form-two">
                                        <form>
                                            <input type="search" placeholder="Search ...">
                                            <button type="submit"><i class="icon-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Sticky Menu -->

                <!-- Mobile Menu  -->
                <div class="mobile-menu">
                    <div class="menu-backdrop"></div>
                    <div class="close-btn"><span class="icon far fa-times-circle"></span></div>

                    <nav class="menu-box">

                        <div class="menu-outer">
                            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                        </div>
                        <!--Social Links-->
                        <!-- <div class="social-links">
                        <ul class="clearfix">
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                            <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                        </ul>
                    </div> -->
                    </nav>
                </div><!-- End Mobile Menu -->

                <div class="nav-overlay">
                    <div class="cursor"></div>
                    <div class="cursor-follower"></div>
                </div>
            </header>
            <!-- End Main Header -->

            <!--Search Popup-->
            <div id="search-popup" class="search-popup">
                <div class="close-search theme-btn"><span class="far fa-times-circle"></span></div>
                <div class="popup-inner">
                    <div class="overlay-layer"></div>
                    <div class="search-form">
                        <form method="post" action="#">
                            <div class="form-group">
                                <fieldset>
                                    <input type="search" class="form-control" name="search-input" value=""
                                        placeholder="Search Here" required>
                                    <input type="submit" value="Search Now!" class="theme-btn">
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>