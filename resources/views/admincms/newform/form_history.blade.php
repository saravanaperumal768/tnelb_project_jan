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
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.addnewform')}}">Portal Form/License Management Console </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Portal Form/License History Management Console</li>
                    </ol>
                </nav>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                                    <h4 class="text-dark card-title">Portal Form/License History Management Console </h4>
                                </div>

                                <div class="col-xl-3 col-md-3 col-sm-3 col-3 text-end">
                                   <a  href="{{route('admin.addnewform')}}">
                                    <button class="btn btn-info">
                                        Back
                                    </button>

                                   </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="card">



                    <div class="card-body">
                        <select id="customColumnFilter" class="form-select form-select-sm" style="display: none;">
                            <option value="">All</option>
                        </select>
                        <div class="table-responsive">
                            <table id="style-3" class="table style-3 dt-table-hover portaladmin">
                                <thead>
                                    <tr>
                                        <!-- <th class="text-center">S.No</th> -->
                                        <!-- <th class="text-center">Date of Posted</th> -->
                                        <th class="text-center">Form <br> Name</th>
                                        <th class="text-center">License <br> Name</th>
                                        <th class="text-center">Fresh License <br> Fee</th>
                                        <th>Fresh License <br>Start From</th>
                                        <th class="text-center">Renewal License<br> Fee</th>
                                        <th>Renewal License <br>Start From</th>

                                        <th class="text-center">Late Fee </th>
                                        <th> Start From</th>
                                        <th class="text-center">Duration For <br>Fresh Fees</th>
                                        <th class="text-center">Duration For <br>Renewal Fees </th>
                                        <th class="text-center">Duration For <br>Late Fee </th>

                                        <!-- <th class="text-center">Instructions</th> -->
                                        <th class="text-center">Status</th>

                                    </tr>
                                </thead>
                                <!-- id="sortable-menu" -->
                                <tbody id="formtable">
                                    @foreach ($formhistory as $form)
                                    <tr @if($form->id == $currentFormId)  @endif>
                                        <!-- <td class="text-center">{{ $loop->iteration }}</td> -->

                                        <td>

                                            {{ $form->form_name }}

                                        </td>

                                        <td>
                                            {{$form->license_name}} <br>


                                        </td>






                                        <td>{{ $form->fresh_amount }}</td>

                                        <td>
                                            {{ $form->freshamount_starts }}

                                        </td>

                                        <td>{{ $form->renewal_amount }}</td>

                                        <td>

                                            {{ $form->renewalamount_starts }}

                                        </td>
                                        <td>{{ $form->latefee_amount }}</td>


                                        <td>
                                            {{ $form->latefee_starts }}

                                        </td>

                                        <td>
                                            @if($form->duration_freshfee)
                                            {{ $form->duration_freshfee }}
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td>

                                            @if($form->duration_renewalfee)
                                            {{ $form->duration_renewalfee }}
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td>


                                            @if($form->duration_latefee)
                                            {{ $form->duration_latefee }}
                                            @else
                                            --
                                            @endif

                                        </td>

                                        <!-- <td class="table_tdcontrol">{{ $form->instructions }}</td> -->

                                        <!-- <td class="table_tdcontrol">
                                        
                                    </td> -->

                                        <td>
                                            <span class="badge 
                                        {{ $form->status == '1' ? 'badge-success' : 
                                        ($form->status == '0' ? 'badge-dark' : 
                                        ($form->status == '2' ? 'badge-danger' : '')) }}">
                                                @if ($form->status == '1')
                                                Active
                                                @elseif ($form->status == '0')
                                                Inactive

                                                @endif
                                            </span>
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

@include('admincms.include.footer');