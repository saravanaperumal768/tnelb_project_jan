@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

<style>
    .widget.box .widget-header {
        background: rgb(255, 255, 255);
        padding: 0px 8px 0px;

    }

    .box-shadow .widget-header h4 {

        color: #000 !important;
    }

    .info-box-4 {
        background: #ffffff;
        padding: 50px 40px;
        text-align: center;
        position: relative;
        border-radius: 25px;
        margin-bottom: 30px;
        margin-top: 10px;
        transition: 0.3s;
        max-width: 100%;
    }

    .table:not(.dataTable) tbody tr td svg {
        width: 30px;
        height: 31px;
        vertical-align: text-top;
        color: #4361ee;
        stroke-width: 1.5;
    }

    table th {
        text-align: center;
    }

    table>tbody>tr>td {
        border: 1px solid #00000021 !important;
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
                                        <li class="breadcrumb-item"><a href="#">Content Management System for TNELB</a></li>
                                    </ol>
                                </nav>

                            </div>
                        </div>

                    </header>
                </div>
            </div>
            <!--  END BREADCRUMBS  -->
            <div class="modal fade inputForm-modal reset-on-open" id="inputFormModaladd" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-header" id="inputFormModalLabel">
                            <h5 class="modal-title">Add New Notice Message</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form class="mt-0" id="newsboardform">
                                <!-- Page Type Selection -->

                                <input type="hidden" name="updated_by" value="{{Auth::user()->name}}">
                                <!-- ✅ Common Fields (Menu Names) -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subject (English) <span>*</span></label>
                                            <div class="">
                                                <textarea class="form-control " name="subject_en"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 pt-2">
                                        <div class="form-group">
                                            <label>Subject (Tamil) <span>*</span></label>
                                            <div class="">
                                                <textarea class="form-control " name="subject_ta"></textarea>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <div class="form-group pt-2">
                                            <label>Start Date <span>*</span></label>
                                            <input type="date" class="form-control" name="startdate" id="startdate" >
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group pt-2">
                                            <label>End Date <span>*</span></label>
                                            <input type="date" class="form-control" name="enddate" >
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group pt-2">
                                            <label>Content Type <span>*</span></label>
                                            <select name="content_type" id="content_type_board" class="form-select">
                                                <option value="">--- Please select page type ---</option>
                                                <option value="Static Page">Content Page</option>
                                                <option value="url">URL</option>
                                                <option value="pdf">PDF</option>
                                                <option value="text">None</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div id="pdfFields" class="row" style="display: none;">
                                        <div class="col-md-6 pt-2">
                                            <div class="form-group">
                                                <label>Upload PDF (English) <span>*</span></label>
                                                <input type="file" class="form-control" name="pdf_en" accept=".pdf">
                                            </div>
                                        </div>
                                        <div class="col-md-6 pt-2">
                                            <div class="form-group">
                                                <label>Upload PDF (Tamil) <span>*</span></label>
                                                <input type="file" class="form-control" name="pdf_ta" accept=".pdf">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="urlFields" class="row" style="display: none;">
                                        <div class="col-md-12 pt-2">
                                            <div class="form-group">
                                                <label>External Link/URL <span>*</span></label>
                                                <input type="text" class="form-control" name="external_url">
                                            </div>
                                        </div>

                                    </div>


                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Add</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal fade inputForm-modal" id="inputFormModaleditboard" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" id="inputFormModalLabel">
                            <h5 class="modal-title">Edit Notice Board Content</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="mt-0" id="noticeboardedit">
                                <input type="hidden" name="id" id="board_id">
                                <input type="hidden" name="updated_by" value="{{Auth::user()->name}}">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subject (English)</label>
                                            <div class="">
                                                <textarea class="form-control " name="subject_en"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 pt-2">
                                        <div class="form-group">
                                            <label>Subject (Tamil)</label>
                                            <div class="">
                                                <textarea class="form-control " name="subject_ta"></textarea>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <div class="form-group pt-2">
                                            <label>Start Date</label>
                                            <input type="date" class="form-control" name="startdate" id="startdate" >
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group pt-2">
                                            <label>End Date</label>
                                            <input type="date" class="form-control" name="enddate" >
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group pt-2">
                                            <label>Content Type</label>
                                            <select name="content_type" id="contenttype_editboard" class="form-select">
                                                <option value="">--- Please select page type ---</option>
                                                <option value="Static Page">Content Page</option>
                                                <option value="url">URL</option>
                                                <option value="pdf">PDF</option>
                                                  <option value="text">None</option>

                                            </select>
                                        </div>
                                    </div>

                                    <!-- PDF Preview -->
                                    <div id="pdfFields_noticeboard" class="row" style="display: none;">
                                        <div class="col-md-6 pt-2">
                                            <div class="form-group">
                                                <label>Upload PDF (English) <span>*</span></label>
                                                <input type="file" class="form-control" name="pdf_en" accept=".pdf">
                                                <a href="#" id="existing_pdf_en" target="_blank" class="d-block mt-1 text-primary d-none">
                                                    <i class="fa fa-file-pdf-o"></i> View Existing English PDF
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pt-2">
                                            <div class="form-group">
                                                <label>Upload PDF (Tamil) <span>*</span></label>
                                                <input type="file" class="form-control" name="pdf_ta" accept=".pdf">
                                                <a href="#" id="existing_pdf_ta" target="_blank" class="d-block mt-1 text-primary d-none">
                                                    <i class="fa fa-file-pdf-o"></i> View Existing Tamil PDF
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- URL Preview -->
                                    <div id="urlFields_noticeboard" class="row" style="display: none;">
                                        <div class="col-md-12 pt-2">
                                            <div class="form-group">
                                                <label>External Link/URL <span>*</span></label>
                                                <input type="text" class="form-control" name="external_url" id="external_url_input">

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


            <div class="row layout-top-spacing dashboard">

                <nav class="breadcrumb-style-five breadcrumbs_top  mb-2" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg><span class="inner-text">Dashboard </span></a></li>
                        <li class="breadcrumb-item"><a href="#">Homepage</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Portal Notice Board Management Console</li>
                    </ol>
                </nav>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="text-dark card-title">Portal Notice Board Management Console </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row layout-spacing">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="card-header">

                                    <div class="float-right">
                                        <button type="button" class="btn btn-info mb-2 me-4 float-end" data-bs-toggle="modal" data-bs-target="#inputFormModaladd">
                                            <i class="fa fa-plus"></i>&nbsp; Add New Notice Message
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content ">
                                <table id="style-3" class="table style-3 dt-table-hover portaladmin">
                                    <thead>
                                        <tr>
                                            <th class="checkbox-column text-center"> S.No </th>

                                            <th>Subject [English]</th>
                                            <th>Subject [Tamil]</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Content Type</th>

                                            <th class="text-center">Status</th>
                                            <th class="text-center dt-no-sorting">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($newsboard as $news)
                                        <tr data-id="{{ $news->id }}">
                                            <td class="checkbox-column text-center">{{ $loop->iteration }}</td>
                                            <td class="table_tdcontrol">{{ $news->subject_en }}</td>
                                            <td class="table_tdcontrol">{{ $news->subject_ta }}</td>
                                            <td>{{ \Carbon\Carbon::parse($news->startdate)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($news->enddate)->format('d-m-Y') }}</td>

                                            <!-- <td>{{ $news->enddate }}</td> -->
                                            <td class="table_tdcontrol">{!! $news->page_type !!}</td>

                                            <td>
                                                <span class="badge 
                                                {{ $news->status == '1' ? 'badge-success' : 
                                                ($news->status == '0' ? 'badge-dark' : 
                                                ($news->status == '2' ? 'badge-danger' : '') ) }}">
                                                    @if ($news->status == '1') Published
                                                    @elseif ($news->status == '0') Draft
                                                    @elseif ($news->status == '2') Disabled
                                                    @endif
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <ul class="table-controls">
                                                    <li>
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#inputFormModaleditboard"
                                                            data-id="{{ $news->id }}"
                                                            data-subject_en="{{ e($news->subject_en) }}"
                                                            data-subject_ta="{{ e($news->subject_ta) }}"
                                                            data-startdate="{{ $news->startdate }}"
                                                            data-enddate="{{ $news->enddate }}"
                                                            data-page_type="{{ $news->page_type }}"
                                                            data-pdf_en="{{ $news->pdf_en ? asset($news->pdf_en) : '' }}"
                                                            data-pdf_ta="{{ $news->pdf_ta ? asset($news->pdf_ta) : '' }}"
                                                            data-external_url="{{ $news->external_url ? : ''  }}"

                                                            class="bs-tooltip editboardMenucontent" title="Edit">
                                                            <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                                        </a>
                                                    </li>

                                                    @if ($news->page_type == 'Static Page')
                                                    <li>
                                                        <a href="{{ route('admin.noticeboardcontent', ['id' => $news->id]) }}" target="_blank" title="Edit">
                                                            <i class="fa fa-file-text-o"></i>
                                                        </a>


                                                    </li>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-danger fw-bold">No records found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>






        @include('admincms.include.footer')