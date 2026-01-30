@include('include.top')
@include('include.header')
@include('include.navbar')

<style>
    table th{
        color: #4361ee!important;
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">

            <!--  BEGIN BREADCRUMBS  -->
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </a>
                        <div class="d-flex breadcrumb-content">
                            <div class="page-header">

                                <div class="page-title">
                                </div>

                                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"></a></li>

                                    </ol>
                                </nav>

                            </div>
                        </div>

                    </header>
                </div>
            </div>
            <!--  END BREADCRUMBS  -->

            <div class="row layout-top-spacing">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <table id="zero-config" class="table dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Application Id</th>
                                    <th>Applicant's Name</th>
                                    <th>Form Name</th>
                                    <th>License of</th>
                                    <th>Applied On</th>
                                    <th class="no-content">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workflows as $key => $workflow)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <a href="{{ route('applicants_detail', ['applicant_id' => $workflow->application_id]) }}">
                                            {{ $workflow->application_id }}
                                        </a>
                                    </td>
                                    <td>{{ $workflow->applicant_name }}</td>
                                    <td>{{ $workflow->formname_appliedfor }}</td>
                                    <td>{{ $workflow->license_name }}</td>
                                    <td>{{$workflow->created_at}}</td>
                                    <td>
                                    <a href="{{ route('applicants_detail', ['applicant_id' => $workflow->application_id]) }}">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                        <button class="btn btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @include('include.footer');