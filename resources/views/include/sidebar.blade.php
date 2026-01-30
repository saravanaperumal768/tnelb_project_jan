<style>
    span em {
        font-style: normal;
        font-weight: 600;
    }

    .eight {
        padding: 5px 5px;
    }

    .eight span {
        color: #e4ff00;
        /* text-align: center; */
        text-transform: uppercase;
        font-size: 15px;
        letter-spacing: 1px;
        /* margin-top: 7px; */
        padding: 1px 1px 1px 1px;
        font-weight: 700;
    }


    /* .eight span:after,
    .eight span:before {
        content: " ";
        display: block;
         border-bottom: 2px solid #e4ff00; 
        background-color: #f8f8f8;
        margin-top: 13px;
    } */


    .nav-item .nav-link i {
        margin-right: 10px;
    }

    .sidebar-login hr {
        color: aliceblue;
        border: 1px solid;
        margin: unset;

    }
</style>


<div class="sidebar sidebar-login">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="#"><i class="fa fa-home"></i>Dashboard</a>
        </li>
        <hr>
        <!-- <div class="eight">
            <span><i class="fa fa-wpforms me-2"></i> Competency Certificates</span>
        </div> -->

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-toggle="collapse" href="#competencyMenu"
                role="button" aria-expanded="true" aria-controls="competencyMenu">
                <span>
                    <i class="fa fa-wpforms me-2"></i>
                    Competency Certificates
                </span>
                <span>
                    <i class="fas fa-chevron-down caret-icon"></i>
                </span>
            </a>
            <div class="collapse collapse-menu show" id="competencyMenu">
                <ul class="nav flex-column certificate-menu">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('apply-form-s') }}">
                            <i class="fa fa-arrow-circle-o-right"></i> Supervisor Competency Certificate [Form S]
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('apply-form-wh') }}">
                            <i class="fa fa-arrow-circle-o-right"></i> Wireman Helper Competency Certificate [Form H]
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('apply-form-w') }}">
                            <i class="fa fa-arrow-circle-o-right"></i> Wireman Competency Certificate [Form W]
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('apply_form_p') }}">
                            <i class="fa fa-arrow-circle-o-right"></i> Power Generating Station Operation & Maintenance Competency Certificate <br>[Form P]
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <hr>
        <!-- <div class="eight">
            <span><i class="fa fa-file-text-o me-2"></i> Contractor Licenses</span>
        </div> -->

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center collapsed" data-toggle="collapse" href="#contractorMenu"
                role="button" aria-expanded="true" aria-controls="contractorMenu">
                <span>
                    <i class="fa fa-file-text-o me-2"></i> Contractor Licences
                </span>
                <span>
                    <i class="fas fa-chevron-down caret-icon d-flex"></i>
                </span>
            </a>
            <div class="collapse collapse-menu show" id="contractorMenu">
                <ul class="nav flex-column contractor-menu">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('apply-form-a') }}"><i class="fa fa-arrow-circle-o-right"></i>Electrical Contractor's Licence-Grade 'A' [Form A]</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('apply-form-sa') }}"><i class="fa fa-arrow-circle-o-right"></i>Electrical Contractors Licence Grade Super 'A' [Form SA]</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('apply-form-sb') }}"><i class="fa fa-arrow-circle-o-right"></i>Electrical Contractor's Licence-Grade `SB' [Form SB]</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('apply-form-b') }}"><i class="fa fa-arrow-circle-o-right"></i>Electrical Contractor License 'EB' [Form B]</a>
                    </li>


                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('expiry_date_change') }}"><i class="fa fa-arrow-circle-o-right"></i>
                License Expiry Date Change
            </a>

        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('previous_licence_date_change') }}"><i class="fa fa-arrow-circle-o-right"></i>
                C & W Licence Change
            </a>

        </li>


        {{-- <hr> --}}
        {{-- <li class="nav-item">
            <a href="" class="nav-link">
                <i class="fa fa-clipboard"></i> Previous (or) Old License Details
            </a>
        </li> --}}
    </ul>
</div>