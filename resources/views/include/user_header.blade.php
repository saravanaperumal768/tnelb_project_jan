<!DOCTYPE html>
<html lang="en">

@php
use Illuminate\Support\Facades\Auth;
@endphp

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'TNELB - Home')</title>

    <!-- Stylesheets -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/color-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/page_top.css') }}" rel="stylesheet">

    <style>
        .cust-background{
            background-color: #004185;
            border-bottom: 1px solid #fff;
        }

        .cust-background > a{
            color: #fff !important;
        }

        .main-footer {
            padding: 20px 30px;
            /* margin-top: 40px; */
            color: #98a6ad;
            border-top: 1px solid #e3eaef;
            display: inline-block;
            background: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            width: 100%;
        }

        .main-footer .footer-left {
            float: left;
        }

        .main-footer .footer-right {
            float: right;
        }
        
    </style>

</head>

<body>
    <div id="main-wrapper">
        <nav class="navbar navbar-light cust-background">
            <a class="navbar-brand" href="#">
                <img src="{{url('assets/admin/images/logo/logo.png') }}" width="40" height="40" alt="">
                Tamilnadu Electrical Licencing Board 
            </a>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown dropdown-list-toggle">
                    <a href="#" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{url('assets/images/secretary.jpg') }}" class="user-img-radious-style" style="width: 30px;">
                        <span class="d-sm-none d-lg-inline-block"></span>
                    </a>
                </li>
            </ul>
        </nav>
        <section class="dashboard-panel">
            <div class="layout-login">
                {{-- <div class="container"> --}}
                    <div class="row">
        @include('include.sidebar')
