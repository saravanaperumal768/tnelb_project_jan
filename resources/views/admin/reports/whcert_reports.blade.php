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
                        <h4 class="text-center text-white fw-bold"> <i class="fa fa-file-archive"></i> Archived Reports</h4>
                    </div>
                        <div class="card-body">
                            <div class="filter-fields layout-top-spacing">
                                <form id="filter_report" class="row g-3 needs-validation" novalidate>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Certificate Code</label>
                                        <select class="form-select" id="cert_code" name="cert_code">
                                            <option selected disabled value="">Choose...</option>
                                            <option value="C">C</option>
                                            <option value="EA">EA</option>
                                            <option value="B">B</option>
                                            <option value="WH">WH</option>
                                            <option value="H">H</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom02" class="form-label">Application No</label>
                                        <input id="application_no" name="application_no" type="text" class="form-control" placeholder="Application code .....">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom02" class="form-label">Certificate No</label>
                                        <input id="cert_no" name="cert_no" type="text" class="form-control" placeholder="Cert No.....">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom02" class="form-label">Renewal ID</label>
                                        <input id="ren_id" name="ren_id" type="text" class="form-control" placeholder="Renewal No.....">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom02" class="form-label">Issue Date</label>
                                        <input id="issue_date" name="issue_date" type="text" class="form-control" placeholder="Issue Date....." readonly>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button class="btn btn-danger text-center" id="filterBtn">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 layout-top-spacing">
                <div class="card">
                    <div class="card-body">
                        <table id="applicationTable" class="table dt-table-hover">
                            <thead class="text-center">
                                <th>S.No</th>
                                <th>Application ID</th>
                                <th>Certificate No</th>
                                <th>Name Applicant</th>
                                <th>Application Type</th>
                                <th>Date of Appl</th>
                            </thead>
                            <tbody id="certTableBody">
    
                            </tbody>
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


        var table = $('#applicationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.get_filter_data") }}',
                type: 'POST',
                data: function(d) {
                    d._token        = '{{ csrf_token() }}';
                    d.certcode      = $('#cert_code').val();
                    d.appsno        = $('#application_no').val();
                    d.certno        = $('#cert_no').val();
                    d.ren_id        = $('#ren_id').val();
                }
            },
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
            columns: [
                {
                    data: null,
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'appsno' },
                { data: 'certno' },
                { data: 'appname' },
                { data: 'certcode' },
                { data: 'recdate' },
            ],
            stripeClasses: [],
            // lengthMenu: [20, 100, 200, 500],
            responsive: true
        });

        $('#filterBtn').on('click', function(e) {
            e.preventDefault();
            table.ajax.reload();
        });

        var f1 = flatpickr(document.getElementById('issue_date'));
    });

</script>