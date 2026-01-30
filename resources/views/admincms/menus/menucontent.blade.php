@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

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

    #sortable-menu i {
        /* color: red; */
        /* font-size: 26px; */
    }

    #sortable i {
        /* color: red; */

    }

    .layout-spacing {
        padding-bottom: 6px;
    }

    .ck-editor__editable {
        min-height: 300px;
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



            <div class="row layout-top-spacing dashboard">
                <nav class="breadcrumb-style-five breadcrumbs_top  mb-2" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg><span class="inner-text">Dashboard </span></a></li>
                        <li class="breadcrumb-item"><a href="#">Homepage</a></li>
                       <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.menus')}}"> Portal Main Menu Management Console </a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Portal Main Menu Content Management Console</li>
                    </ol>
                </nav>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="text-dark card-title">Portal Main Menu Content Management Console </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>



        <div class="row scrumboard " id="cancel-row">
            <div class="col-lg-12 widget layout-spacing">
                <div class="row">
                    <div class="col-lg-12">
                        <div data-section="s-new" class="task-list-container" data-connect="sorting">
                            <div class="connect-sorting">
                                <div class="task-container-header">

                                    <div>
                                        <button style="display: none;" type="button" class="btn btn-info float-right mb-2 me-4 _effect--ripple waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#languageSelectModal">
                                            <i class="fa fa-plus"></i>&nbsp; Add New Content For {{ $menu->menu_name_en }} Menu
                                        </button>

                                        <!-- Language Selection Modal -->

                                        <div class="modal fade" id="languageSelectModal" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5>Select Language</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <button type="button" class="btn btn-success" id="openEnglishForm">English</button>
                                                        <button type="button" class="btn btn-danger" id="openTamilForm">Tamil</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- English Content Modal -->

                                        <div class="modal fade" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" id="inputFormModalLabel">
                                                        <h5 class="modal-title">Add English Content</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">X</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="backend/about/update_aboutcontent.php" method="POST">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="task-badge d-flex">
                                                                        <textarea id="add-tasks" placeholder="Task Text" class="form-control richcontent" name="menucontent"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <button type="submit" class="btn btn-success float-right">Add</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tamil Content Modal -->

                                    </div>
                                </div>
                            </div>

                            <div class="connect-sorting-content" data-sortable="true">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#english-tab">English</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tamil-tab">Tamil</button>
                                    </li>
                                </ul>

                                <div class="tab-content mt-3">
                                    <!-- English Tab -->
                                    <div class="tab-pane fade show active" id="english-tab">
                                        <div data-draggable="true" class="card img-task">
                                            <div class="card-body">
                                                <form class="mt-0" id="menucontentedit_en">
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label> Menu Content For {{ $menu->menu_name_en }} [English]</label>
                                                                <div class="">

                                                                    <textarea class="form-control rich-editor" id="menucontent" name="menucontent" rows="10">
                                                                    {{ $menu->menupage?->menucontent ?? '' }}</textarea>


                                                                </div>
                                                            </div>

                                                        </div>
                                                        <input type="hidden" name="id" value="{{ $menu->id }}">

                                                        <input type="hidden" name="updated_by" value="{{ Auth::user()->name }}">


                                                    </div>


                                                    <div class="">
                                                        <button type="button" class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tamil Tab -->
                                    <div class="tab-pane fade" id="tamil-tab">
                                        <div data-draggable="true" class="card img-task">
                                            <div class="card-body">
                                                <form class="mt-0" id="menucontentedit_ta">
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label> Menu Content For {{ $menu->menu_name_ta }} [Tamil]</label>
                                                                <div class="">

                                                                    <textarea class="form-control rich-editor" id="menucontent_ta" name="menucontent_ta" rows="10">
                                                                    {{ $menu->menupage?->menucontent_ta ?? '' }}</textarea>


                                                                </div>
                                                            </div>

                                                        </div>
                                                        <input type="hidden" name="id" value="{{ $menu->id }}">
                                                        <input type="hidden" name="updated_by" value="{{ Auth::user()->name }}">

                                                    </div>


                                                    <div class="">
                                                        <button type="button" class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div data-draggable="true" class="card task-text-progress"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>




        @include('admincms.include.footer');