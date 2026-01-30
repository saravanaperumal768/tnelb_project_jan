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
                        <li class="breadcrumb-item"><a href="#">Footer Links</a></li>
                     
                        <li class="breadcrumb-item active" aria-current="page">Portal Contact Details Content Management Console</li>
                    </ol>
                </nav>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="text-dark card-title">Portal Contact Details Content Management Console </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>


                <div class="row pad-10">

                    <div id="flLoginForm" class="col-lg-12 layout-spacing">
                        <div class="statbox widget ">
                          
                            <div class="widget-content widget-content-area">
                                <form class="row g-3 pd-20" id="contactdetailsupdate">
                                    <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Email</label>
                                        
                                        <input type="hidden" name="updated_by" value="{{ Auth::user()->name }}">

                                        <input type="email" class="form-control" name="email"  value="{{$contact->email ?? ''}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Phone No / Mobile Number</label>
                                        <input type="text" name="mobilenumber" class="form-control" value="{{$contact->mobilenumber ?? ''}}">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Address</label>
                                        
                                        <textarea class="form-control" name="address" rows="5"> {{$contact->address ?? ''}}</textarea>
                                    </div>
                                 
                                    
                                    <div class="col-12">
                                        <button type="button" class="btn btn-light">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>

                </div>









            </div>

        </div>

    </div>
</div>

@include('admincms.include.footer');