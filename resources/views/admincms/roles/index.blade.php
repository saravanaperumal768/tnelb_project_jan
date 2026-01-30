@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet"> -->

<style>
    .table:not(.dataTable) tbody tr td svg {
        width: 28px;
        height: 31px;
        vertical-align: text-top;
        color: #4361ee;
        stroke-width: 1.5;
    }

    table>tbody>tr>td {
        border: 1px solid #00000021 !important;

    }

    table th {
        text-align: center;
    }

    .inputForm-modal .modal-content .modal-body .form-group input {
        border-left: 1px solid #d4d3d3;
        background: transparent;
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">
            <!--  BEGIN BREADCRUMBS  -->
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="#" class="btn-toggle sidebarCollapse" data-placement="bottom">
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

            <div class="row layout-top-spacing dashboard">


                <div class="row layout-spacing">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <!-- <h5>111</h5> -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Staff & Roles Assigning</h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button type="button" class="btn btn-info mb-2 me-4" data-bs-toggle="modal" data-bs-target="#inputFormModal">
                                        <i class="fa fa-plus"></i>&nbsp; Add New Staff
                                    </button>
                                </div>
                                <!-- -------------- Add New staff modal----------------- -->
                                <div class="modal fade inputForm-modal" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header" id="inputFormModalLabel">
                                                <h5 class="modal-title">Add New Staff</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg></button>
                                            </div>

                                            <div class="modal-body">
                                                <form class="mt-0" id="addnewstaff" enctype="multipart/form-data">
                                                    <input type="hidden" name="updated_by" value="{{ Auth::user()->name }}">

                                                    <div class="form-group">
                                                        <label>Name of Staff</label>
                                                        <div class="input-group mb-1">
                                                            <input type="text" class="form-control" name="staff_name" placeholder="Name of Staff">
                                                        </div>
                                                        <span class="text-danger error-text staff_name_error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Role of the Staff</label>
                                                        <div class="input-group mb-1">
                                                            <input type="text" class="form-control" name="name" placeholder="Role of the Staff">
                                                        </div>
                                                        <span class="text-danger error-text name_error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <div class="input-group mb-1">
                                                            <input type="email" class="form-control" name="email" placeholder="Email">
                                                        </div>
                                                        <span class="text-danger error-text email_error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <div class="input-group mb-1">
                                                            <input type="text" class="form-control" name="password" value="password123" readonly>
                                                        </div>
                                                        <span class="text-danger error-text password_error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Handling Form of</label>
                                                        <div class="input-group mb-1">
                                                            <select class="form-select" name="form_id">
                                                                @foreach($forms as $form)
                                                                <option value="{{ $form->id }}">{{ $form->form_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <span class="text-danger error-text form_id_error"></span>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-light-danger mt-2 mb-2" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary mt-2 mb-2">Submit</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- -------------------Edit staff details modal-------------------------- -->
                                <div class="modal fade inputForm-modal" id="inputFormModaledit" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header" id="inputFormModalLabel">
                                                <h5 class="modal-title">Edit Sub Menu </b></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="mt-0" id="editstaffdetails" enctype="multipart/form-data">
                                                    <input type="hidden" name="updated_by" value="{{ Auth::user()->name }}">

                                                    <div class="form-group">
                                                        <label>Name of Staff</label>
                                                        <div class="input-group mb-1">
                                                            <input type="text" class="form-control" name="staff_name" placeholder="Name of Staff">
                                                        </div>
                                                        <span class="text-danger error-text staff_name_error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Role of the Staff</label>
                                                        <div class="input-group mb-1">
                                                            <input type="text" class="form-control" name="name" placeholder="Role of the Staff">
                                                        </div>
                                                        <span class="text-danger error-text name_error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <div class="input-group mb-1">
                                                            <input type="email" class="form-control" name="email" placeholder="Email">
                                                        </div>
                                                        <span class="text-danger error-text email_error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <div class="input-group mb-1">
                                                            <input type="text" class="form-control" name="password" value="password123" readonly>
                                                        </div>
                                                        <span class="text-danger error-text password_error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Handling Form of</label>
                                                        <div class="input-group mb-1">
                                                            <select class="form-select" name="form_id">
                                                                @foreach($forms as $form)
                                                                <option value="{{ $form->id }}">{{ $form->form_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <span class="text-danger error-text form_id_error"></span>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-light-danger mt-2 mb-2" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary mt-2 mb-2">Submit</button>
                                                    </div>
                                                </form>


                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="widget-content widget-content-area pt-2">

                                    <table id="style-3" class="table style-3 dt-table-hover">
                                        <thead>
                                            <tr>

                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Handling Form of</th>
                                                <!-- <th class="text-center">Status</th> -->
                                                <th class="text-center dt-no-sorting">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staffmembers as $staff)
                                            <tr>


                                                <td>{{$staff->staff_name}}</td>
                                                <td>{{$staff->name}}</td>
                                                <td>{{$staff->email}}</td>

                                                <td class="text-center">
                                                    <span class="shadow-none badge badge-primary">
                                                        {{ $staff->form_name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <ul class="table-controls">
                                                        <li> <a href="javascript:void(0);" class="editsubMenu"
                                                                data-id="{{ $staff->id }}"
                                                                data-name="{{ $staff->name }}"
                                                                data-email="{{ $staff->email }}"
                                                                data-form_id="{{ $staff->form_id }}"
                                                                data-staff_name="{{ $staff->staff_name }}"
                                                      
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#inputFormModaleditstaff"
                                                                title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1" data-bs-toggle="modal" data-bs-target="#inputFormModaledit">
                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                </svg>
                                                            </a>
                                                        </li>

                                                        <li><a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                </svg></a></li>
                                                    </ul>
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

            </div>

        </div>
    </div>

    @include('admincms.include.footer');