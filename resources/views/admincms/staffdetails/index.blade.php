@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')


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
                                    <li class="breadcrumb-item"><a href="#">Content Management System for TNELB</a></li>

                                    </ol>
                                </nav>

                            </div>
                        </div>

                    </header>
                </div>
            </div>
            <!--  END BREADCRUMBS  -->

            <div class="row layout-top-spacing dashboard">

                <nav class="breadcrumb-style-five breadcrumbs_top  mb-2" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg><span class="inner-text">Dashboard </span></a></li>
                        <li class="breadcrumb-item"><a href="#">Homepage</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Portal Staff Management Console</li>
                    </ol>
                </nav>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="text-dark card-title">Portal Staff Management Console </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade inputForm-modal reset-on-open" id="inputFormModaladdstaffs" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">

                            <div class="modal-header" id="inputFormModalLabel">
                                <h5 class="modal-title">Add New Staff</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form class="mt-0" id="newstaffmaster">
                                    <!-- Page Type Selection -->



                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inputEmail4" class="form-label">Staff Name<span>*</span></label>
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="updated_by" value="{{Auth::user()->name}}">

                                                    <!-- <input type="hidden" name="created_by" value="{{Auth::user()->name}}"> -->

                                                    <input type="text" class="form-control" name="staff_name" id="name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Designation Name <span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="name" id="name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inputEmail4" class="form-label">Email<span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="email" class="form-control" name="email" id="email">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Assigned     Forms of <span>*</span></label>
                                                <div class="">
                                                    <div class="row">
                                                        @foreach ($formlist as $form)
                                                            <div class="col-md-6">
                                                                <input type="checkbox" 
                                                                    id="handle_forms_{{ $form->id }}" 
                                                                    name="handle_forms[]" 
                                                                    value="{{ $form->id }}">
                                                                <label for="handle_forms_{{ $form->id }}">
                                                                    Form {{ $form->form_name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status <span>*</span></label>
                                                <select name="status" class="form-select">
                                                    <option value="1">Active</option>
                                                    <option value="0">Draft</option>
                                                    <option value="2">Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-12 pt-2">
                                            <div class="form-group">
                                                <label>Instructions <span>*</span></label>
                                                <div class="">

                                                    <textarea class="form-control rich-editor" name="instructions" rows="6"></textarea>


                                                </div>
                                            </div>
                                        </div> -->
                                    </div>


                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Add</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- --------------- -->

                <div class="modal fade inputForm-modal" id="inputFormModaleditstaffs" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" id="inputFormModalLabel">
                                <h5 class="modal-title">Edit Staff Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="editstaffstbls" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="form_id">
                                    <input type="hidden" name="updated_by" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="original_order_id" id="original_order_id">
                                    <div class="row">
                                        <div class="form-group pb-2 col-md-6">
                                            <label>Staff Name </label>
                                            <input type="hidden"  name="id" id="staff_id" >
                                            <input type="text" class="form-control" name="staff_name">
                                        </div>
                                        <div class="form-group pb-2 col-md-6">
                                            <label>Designation Name</label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group pb-2 col-md-6">
                                            <label>Email </label>
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                        <div class="form-group pb-2 col-md-6">
                                        <div class="form-group">
                                                <label>Handling Forms of </label>
                                                <div class="">
                                                    <div class="row">
                                                        @foreach ($forms as $form)
                                                            <div class="col-md-6">
                                                                <input type="checkbox" 
                                                                    id="handle_forms_{{ $form->id }}" 
                                                                    name="handle_forms[]" 
                                                                    value="{{ $form->id }}">
                                                                <label for="handle_forms_{{ $form->id }}">
                                                                    Form {{ $form->form_name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                               
                                    <div class="row pt-1">
                                        
                                        <div class="form-group pb-2 col-md-6">
                                            <label>Status <span>*</span></label>
                                            <select name="status" class="form-select" id="statusSelectEdit">
                                                <option value="1">Active</option>
                                                <option value="0">Draft</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                        <!-- <div class="col-md-12 pt-2">
                                            <div class="form-group">
                                                <label>Instructions <span>*</span></label>
                                                <div class="">

                                                    <textarea class="form-control rich-editor" name="instructions" rows="6"></textarea>


                                                </div>
                                            </div>
                                        </div> -->
                                    </div>



                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-danger mt-2 mb-2" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary mt-2 mb-2">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">

                        <div class="float-right">
                            <button type="button" class="btn btn-info mb-2 me-4 float-end" data-bs-toggle="modal" data-bs-target="#inputFormModaladdstaffs">
                                <i class="fa fa-plus"></i>&nbsp; Add New Staff
                            </button>
                        </div>
                    </div>


                    <div class="card-body">
                        <select id="customColumnFilter" class="form-select form-select-sm" style="display: none;">
                            <option value="">All</option>
                        </select>
                        <table id="style-3" class="table style-3 dt-table-hover portaladmin">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <!-- <th class="text-center">Date of Posted</th> -->
                                    <th class="text-center">Designation Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Staff Name</th>
                                    <th class="text-center">Handling Forms</th>

                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <!-- id="sortable-menu" -->
                            <tbody id="formtable">
                                @foreach ($staffs as $staff)
                                <tr data-id="{{ $staff->id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td>

                                        {{ $staff->name }}

                                    </td>

                                    <td>
                                        {{$staff->email}}

                                    </td>

                                    <td>
                                        {{$staff->staff_name}}

                                    </td>



                                    <td>
                                        @php
                                            $handledFormIds = json_decode($staff->handle_forms, true) ?? [];
                                            $matchedFormNames = $forms->whereIn('id', $handledFormIds)->pluck('form_name')->toArray();
                                        @endphp
                                        {{ implode(', ', $matchedFormNames) }}
                                    </td>
                                 

                                    <td>
                                        <span class="badge 
                                        {{ $staff->status == '1' ? 'badge-success' : 
                                        ($staff->status == '0' ? 'badge-dark' : 
                                        ($staff->status == '2' ? 'badge-danger' : '')) }}">
                                            @if ($staff->status == '1')
                                            Active
                                            @elseif ($staff->status == '0')
                                            Draft
                                            @elseif ($staff->status == '2')
                                            Inactive
                                            @endif
                                        </span>
                                    </td>

                                    <td>
                                        <ul class="table-controls">
                                            <li>

                                            <a href="javascript:void(0);" class="editstaffdata"
                                                    data-id="{{ $staff->id }}"
                                                    data-name="{{ $staff->name }}"
                                                    data-email="{{ $staff->email }}"
                                                    data-staff_name="{{ $staff->staff_name }}"
                                                    data-handle_forms='@json(json_decode($staff->handle_forms))'
                                                    data-status="{{ $staff->status }}"
                                                    data-bs-toggle="modal" data-bs-target="#inputFormModaleditstaffs">
                                                    <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                                </a>


                                            </li>


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
<script>
        const chBoxes =
            document.querySelectorAll('.dropdown-menu input[type="checkbox"]');
        const dpBtn = 
            document.getElementById('multiSelectDropdown');
        let mySelectedListItems = [];

        function handleCB() {
            mySelectedListItems = [];
            let mySelectedListItemsText = '';

            chBoxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    mySelectedListItems.push(checkbox.value);
                    mySelectedListItemsText += checkbox.value + ', ';
                }
            });

            dpBtn.innerText =
                mySelectedListItems.length > 0
                    ? mySelectedListItemsText.slice(0, -2) : 'Select';
        }

        chBoxes.forEach((checkbox) => {
            checkbox.addEventListener('change', handleCB);
        });
    </script>
@include('admincms.include.footer');

