<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">
        <nav id="sidebar">
            <div class="navbar-nav theme-brand flex-row  text-center">
                <div class="nav-item sidebar-toggle">
                    <div class="btn-toggle sidebarCollapse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
                            <polyline points="11 17 6 12 11 7"></polyline>
                            <polyline points="18 17 13 12 18 7"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
                <ul class="list-unstyled menu-categories ps ps--active-y" id="accordionExample">
                <li class="menu active">
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>
                </li>
               <li class="menu {{ request()->routeIs('admin.homeslider', 'admin.menus', 'admin.submenus', 'admin.newsboard', 'admin.whatsnew', 'admin.galleryimages') ? 'active' : '' }}">
                    <a href="#components" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.homeslider', 'admin.menus', 'admin.submenus', 'admin.newsboard', 'admin.whatsnew', 'admin.galleryimages') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <div class="">
                            <!-- Home Page Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>Home Page</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ request()->routeIs('admin.homeslider', 'admin.menus', 'admin.submenus', 'admin.newsboard', 'admin.whatsnew', 'admin.galleryimages') ? 'show' : '' }}" id="components" data-bs-parent="#accordionExample">

                        <li class="{{ request()->routeIs('admin.homeslider') ? 'active' : '' }}">
                            <a href="{{ route('admin.homeslider') }}">Home Page Slider</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.menus') ? 'active' : '' }}">
                            <a href="{{ route('admin.menus') }}">Main Menus</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.submenus') ? 'active' : '' }}">
                            <a href="{{ route('admin.submenus') }}">Sub Menus</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.newsboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.newsboard') }}">Notice Board</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.whatsnew') ? 'active' : '' }}">
                            <a href="{{ route('admin.whatsnew') }}">Scroll Message</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.galleryimages') ? 'active' : '' }}">
                            <a href="{{ route('admin.galleryimages') }}">Gallery</a>
                        </li>
                    </ul>
                </li>


               <li class="menu {{ request()->is('admin/pagecontent*') ? 'active' : '' }}">
                    <a href="#components_pages" data-bs-toggle="collapse" aria-expanded="{{ request()->is('admin/pagecontent*') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <div class="">
                            <!-- Home Page Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu">
                                <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                                <rect x="9" y="9" width="6" height="6"></rect>
                                <line x1="9" y1="1" x2="9" y2="4"></line>
                                <line x1="15" y1="1" x2="15" y2="4"></line>
                                <line x1="9" y1="20" x2="9" y2="23"></line>
                                <line x1="15" y1="20" x2="15" y2="23"></line>
                                <line x1="20" y1="9" x2="23" y2="9"></line>
                                <line x1="20" y1="14" x2="23" y2="14"></line>
                                <line x1="1" y1="9" x2="4" y2="9"></line>
                                <line x1="1" y1="14" x2="4" y2="14"></line>
                            </svg>
                            <span> Pages </span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>

                     <ul class="collapse submenu list-unstyled {{ request()->is('admin/pagecontent*') ? 'show' : '' }}" id="components_pages" data-bs-parent="#accordionExample">

                        @foreach($menus as $menu)
                        <li class="{{ request()->route('slug_id') == $menu->id ? 'active' : '' }}">
                            <a href="{{ route('admin.pagecontent', ['slug_id' => $menu->id]) }}">
                                {{ $menu->menu_name_en }}
                            </a>
                        </li>
                        @endforeach

                        @foreach($submenus as $menu)
                        <li class="{{ request()->route('slug_id') == $menu->id ? 'active' : '' }}">
                            <a href="{{ route('admin.subpagecontent', ['slug_id' => $menu->id]) }}">
                                {{ $menu->menu_name_en }}
                            </a>
                        </li>
                        @endforeach

                    </ul>
                </li>


                 @php
                $footerRoutes = ['admin.contactdetails', 'admin.quicklinks', 'admin.usefullinks', 'admin.footerbottom'];    
                $currentRoute = Route::currentRouteName();
                @endphp

                <li class="menu {{ in_array($currentRoute, $footerRoutes) ? 'active' : '' }}">
                    <a href="#components_footer"
                        data-bs-toggle="collapse"
                        aria-expanded="{{ in_array($currentRoute, $footerRoutes) ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-layout">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                            <span> Footer Links </span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>

                    <ul class="collapse submenu list-unstyled {{ in_array($currentRoute, $footerRoutes) ? 'show' : '' }}" id="components_footer" data-bs-parent="#accordionExample">
                        <li class="{{ $currentRoute == 'admin.contactdetails' ? 'active' : '' }}">
                            <a href="{{ route('admin.contactdetails') }}">
                                Contact Details
                            </a>
                        </li>

                        <li class="{{ $currentRoute == 'admin.quicklinks' ? 'active' : '' }}">
                            <a href="{{ route('admin.quicklinks') }}">
                                Quick Links
                            </a>
                        </li>

                        <li class="{{ $currentRoute == 'admin.usefullinks' ? 'active' : '' }}">
                            <a href="{{ route('admin.usefullinks') }}">
                                Useful Links
                            </a>
                        </li>

                        <li class="{{ $currentRoute == 'admin.footerbottom' ? 'active' : '' }}">
                            <a href="{{route('admin.footerbottom')}}">Footer Bottom</a>
                        </li>
                    </ul>
                </li>



                <li class="menu  {{ request()->routeIs('admin.media') ? 'active' : '' }}">
                    <a href="{{ route('admin.media') }}" class="dropdown-toggle">
                        <div class="">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            <span>Media</span>
                        </div>
                    </a>
                </li>

                   @if(Auth::user()->id =='5')
                <li class="menu {{ request()->routeIs('admin.membermaster') ? 'active' : '' }}" style="display:none;">
                    <a href="{{ route('admin.membermaster') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                            <span>Add New Member</span>
                        </div>
                    </a>
                </li>


                <!-- <li class="menu {{ request()->routeIs('admin.addnewform') ? 'active' : '' }}">
                    <a href="{{ route('admin.addnewform') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                            <span>License Management</span>
                        </div>
                    </a>
                </li> -->


                @php
                    $licence_routes = ['admin.fees_validity', 'admin.licenceCategory', 'admin.view_licences','admin.management'];
                @endphp


                <li class="menu {{ in_array($currentRoute, $licence_routes) ? 'active' : '' }}">
                    <a href="#licences" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.licences') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                            <span>Licence Management</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ in_array($currentRoute, $licence_routes) ? 'show' : '' }}" id="licences" data-bs-parent="#accordionExample">

                        {{-- <li class="{{ $currentRoute == 'admin.licenceCategory' ? 'active' : '' }}">
                            <a href="{{route('admin.licenceCategory')}}">Category</a>
                        </li> --}}
                        <li class="{{ $currentRoute == 'admin.view_licences' ? 'active' : '' }}">
                           <a href="{{route('admin.view_licences')}}">Certificates / Licences</a>
                       </li>
                        <li class="{{ $currentRoute == 'admin.fees_validity' ? 'active' : '' }}">
                            <a href="{{ route('admin.fees_validity') }}">
                                Fees & Validity Details
                            </a>
                        </li>

                          <!-- <li class="{{ $currentRoute == 'admin.equiplist' ? 'active' : '' }}">
                            <a href="{{ route('admin.equiplist') }}">
                                Master Equipment List
                            </a>
                        </li> -->
                        {{-- <li class="{{ $currentRoute == 'admin.management' ? 'active' : '' }}">
                            <a href="{{route('admin.management')}}">New Link</a>
                        </li> --}}
                    </ul>
                </li>

                     <li class="menu {{ request()->routeIs('admin.equiplist') ? 'active' : '' }}">
                    <a href="{{ route('admin.equiplist') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Master Equipment List</span>
                        </div>
                    </a>
                </li>


                <li class="menu {{ request()->routeIs('admin.stafflist') ? 'active' : '' }}">
                    <a href="{{ route('admin.stafflist') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Staff Management</span>
                        </div>
                    </a>
                </li>


                @endif



            </ul>

        </nav>
    </div>