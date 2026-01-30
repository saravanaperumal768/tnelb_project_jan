


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!-- CSRF Token for AJAX Security -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TNELB - Dashboard')</title>

    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">  -->

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/images/logo/favicon.png') }}">

    <!-- Google Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet"> -->
    <link href="{{ asset('assets/portaladmin/nunitofont.css') }}">

    <!-- Bootstrap & Core Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/src/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/layouts/vertical-light-menu/css/light/plugins.css') }}">

    <!-- Page-Level Plugins/Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/apex/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/components/list-group.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/dashboard/dash_1.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/dashboard/dash_2.css') }}">

    <!-- File Upload Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/filepond/filepond.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/filepond/FilePondPluginImagePreview.min.css') }}">

    <!-- Notifications & Alerts -->
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/notification/snackbar/snackbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/sweetalerts2/sweetalerts2.css') }}">

    <!-- Light Theme Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/scrollspyNav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/components/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/components/tabs.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/css/light/filepond/custom-filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/elements/alert.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/css/light/notification/snackbar/custom-snackbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/forms/switches.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/users/account-setting.css') }}">


     {{-- <link href="{{ ../src/assets/css/light/scrollspyNav.css }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/admin//src/assets/css/light/components/accordions.css') }}" rel="stylesheet" type="text/css" />


    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    

    <!-- Main Styles -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/main.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/portaladmin/main.css') }}">
    

    <link rel="stylesheet" href="{{ asset('assets/portaladmin/summernote-bs4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/portaladmin/rte_theme_default.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">


    <!-- Light Theme Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/scrollspyNav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/assets/css/light/components/timeline.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/animate/animate.css') }}">

    <!-- Multi select -->
    <link rel="stylesheet" href="{{ asset('assets/admin/select2/dist/css/select2.min.css') }}">

    <!-- FontAwesome -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/font-icons/fontawesome/css/regular.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/src/plugins/src/font-icons/fontawesome/css/fontawesome.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{ asset('assets/admin/src/assets/css/light/elements/infobox.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/src/assets/css/dark/elements/infobox.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/src/plugins/src/glightbox/glightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/src/assets/css/light/apps/contacts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/src/assets/css/light/apps/invoice-list.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/src/plugins/css/light/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/src/plugins/css/light/editors/quill/atom-one-dark.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/src/plugins/css/light/editors/quill/katex.min.css') }}">
    
   <!-- --portaladmin---------------- -->
    
</head>
<script>
    const BASE_URL = "{{ UrlHelper::baseFileUrl() }}";
</script>
<style>
#sidebar ul.menu-categories li.menu ul.submenu > li.active a {
    background: #000;
    color: #fff;
    border-radius: 15px;
}
#sidebar ul.menu-categories li.menu ul.submenu > li.active a {
    color: #fff;
}

.table:not(.dataTable) tbody tr td i {
    width: 28px;
    height: 34px;
    margin-top: 7px;
    font-size: 17px;
    vertical-align: text-top;
    color: #4361ee;
    stroke-width: 1.5;

}
</style>


<body class="layout-boxed">