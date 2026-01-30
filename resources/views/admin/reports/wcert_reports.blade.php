@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')

<style>
     thead th {
        background-color: #004185 !important;
        color: #ffffff !important;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
   

</style>

<?php 
// var_dump($get_all_cert);die;

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="middle-content p-0">
            <div class="secondary-nav">
                <div class="breadcrumbs-container">
                    <header class="header navbar navbar-expand-sm">
                        <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                        </a>
                    </header>
                </div>
            </div>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-12">
                <div class="card report-section">
                    <div class="card-header bg-primary">
                        <h4 class="text-center text-white fw-bold">Reports</h4>
                    </div>
                    <div class="card-body">
                        <div class="filter-button">
                            <button class="btn btn-danger"><i class="fa fa-filter"></i><span> Filter</span></button>
                        </div>
                        <div class="filter-fields layout-top-spacing" style="display: none;">
                            <div class="statbox widget box box-shadow">
                                <div class="row">
                                    <div class="col-lg-6 col-12 ">
                                        <form method="post">
                                            <div class="form-group">
                                                <input id="t-text" type="text" name="txt" placeholder="Some Text..." class="form-control" required>
                                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                                            </div>
                                        </form>
                                    </div>                                        
                                </div>
                            </div>
                        </div>
                        </div>
                        <table id="applicationTable" class="table dt-table-hover">
                            <thead class="text-center">
                                <th>S.No</th>
                                <th>Application ID</th>
                                <th>Application Type</th>
                                <th>Date of Appl</th>
                                <th>Certificate No</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.include.footer');

<script>
    $(document).ready(function () {
        $('#applicationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.reports") }}',
            columns: [
                { data: 'sno', name: 'sno' },
                { data: 'appsno', name: 'appsno' },
                { data: 'certcode', name: 'certcode' },
                { data: 'recdate', name: 'recdate' },
                { data: 'certno', name: 'certno' }
            ],
            dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>"+
            "<'table-responsive'tr>"+
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                "oPaginate": { 
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            stripeClasses: [],
            lengthMenu: [20, 100, 200, 500],
            responsive: true
        });
    });
</script>