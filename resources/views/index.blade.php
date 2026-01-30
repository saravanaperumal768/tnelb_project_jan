@include('include.header')

<style>
.news-flip-container {
    height: 30px;
    line-height: 30px;
    overflow: hidden;
    position: relative;
}

.news-item {
    position: absolute;
    width: 100%;
    opacity: 0;
    transform: translateY(100%);
    transition: all 0.8s ease;
    white-space: nowrap;
    font-size: 18px;
}

.news-item.active {
    opacity: 1;
    transform: translateY(0);
}

</style>


<section class="banner-section mt-0">
    <div class="swiper-container banner-slider" id="homeBannerSlider">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
              @if($slider->media)
            <div class="swiper-slide" style="background-image: url('{{ asset($slider->media->filepath_img_pdf) }}');">
                  
                                                @endif
                <div class="content-outer">
                    <div class="content-box">
                        <div class="inner">
                            <h1>
                                <!-- Welcome to <br> -->
                                {{ $slider->slider_caption ?? '' }}
                            </h1>

                            <!-- <div class="link-box">
                                <a href="#" class="theme-btn btn-style-one"><span>Know More</span></a>

                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- Slide Item -->

        </div>
    </div>
    <div class="banner-slider-nav">
        <div class="banner-slider-control banner-slider-button-prev"><span><i class="icon-arrow"></i></span>
        </div>
        <div class="banner-slider-control banner-slider-button-next"><span><i class="icon-arrow"></i></span>
        </div>
    </div>

    <!-- Stop Button -->
    <div class="stop-slider-container">
        <button class="stop-slider theme-btn btn-style-two"><i class="fa fa-pause"></i></button>
    </div>

</section>




<!-- End Bnner Section -->

<!-- Events section two -->
<section class="events-section-two">
    <div class="">
        <div class="event-wrapper scrollmsg">
            <div class="event-block-two">
                <div class="inner-box">
                    <div class="row align-items-center">

                        <div class="col-lg-1 col-md-1ss col-12 text-center mb-2">
                            <div class="image">
                                <!-- <img src="assets/images/whatsnew.png" alt="" class="img-fluid"> -->
                                <!-- <i class="fa fa-exclamation-circle"></i> -->
                            </div>
                        </div>
                        <!-- Date Column -->
                        <div class="col-lg-2 col-md-4 col-12  mb-2">
                            <div class="date  border_right">What's New</div>
                        </div>
                        <!-- Marquee Column -->
                        <div class="col-lg-8 col-md-5 col-12">
                            <div class="text-left">

                                  <marquee id="newsMarquee" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                                    <h4 class="marquee-text">

                                        @forelse ($whatsnew ?? [] as $news)
                                        
                                        @if ($news->page_type == 'url')

                                        <a href="{{ $news->external_url }}" target="_blank">
                                            {!! $news->subject_en ?? 'No News Available' !!} <span> <i class="fa fa-external-link"></i> </span> &nbsp; &nbsp;
                                        </a>
                                        @elseif ($news->page_type == 'pdf')
                                        <a href="{{ asset($news->pdf_ta) }}" target="_blank">
                                            {!! $news->subject_en ?? 'No News Available' !!} <span> <i class="fa fa-file-pdf-o"></i></span>
                                            &nbsp;
                                        </a>
                                        || &nbsp;
                                        @else
                                        {!! $news->subject_en ?? 'No News Available' !!} <i class="fa fa-folder-open-o"></i>
                                        &nbsp;
                                        @endif
                                        <!-- <i class='fas fa-caret-square-right'></i> -->
                                        @empty
                                        No News Available
                                        &nbsp; &nbsp;

                                        @endforelse
                                    </h4>
                                </marquee>


                               <!-- <div id="newsFlipper" class="news-flip-container">
                                    @forelse ($whatsnew ?? [] as $news)
                                        <div class="news-item">
                                            @if ($news->page_type == 'url')
                                                <a href="{{ $news->external_url }}" target="_blank">
                                                    {!! $news->subject_en ?? 'No News Available' !!}
                                                    <i class="fa fa-external-link"></i>
                                                </a>
                                            @elseif ($news->page_type == 'pdf')
                                                <a href="{{ asset($news->pdf_ta) }}" target="_blank">
                                                    {!! $news->subject_en ?? 'No News Available' !!}
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                            @else
                                                {!! $news->subject_en ?? 'No News Available' !!}
                                                <i class="fa fa-folder-open-o"></i>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="news-item">No News Available</div>
                                    @endforelse
                                </div> -->

                            </div>
                        </div>
                        <div class="col-lg-1 col-md-5 col-12">
                            <div class="text-left">

                                <button id="toggleMarquee" class="btn btn-danger  mb-2"><i class="fa fa-pause"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="about-section events-section">
    <div class="auto-container">

        <div class="row">
            <div class="col-lg-8">
                <div class="sec-title ">


                    <h2>About</h2>
                </div>
                    @php
                use Illuminate\Support\Str;
                @endphp

               <div class="text text-dark" style="color:#000!important;font-size:15px;">
                {!! Str::words($aboutus->menucontent ?? 'No content available', 145, '') !!}
                @if(strlen(strip_tags($aboutus->menucontent ?? '')) > 0)
                    ... 
                    <a href="{{ route('about') }}" class="btn btn-sm btn-primary" style="padding:2px 8px;margin-left:6px;">
                        View More
                    </a>
                @endif
            </div>

            </div>
            <!-- <div class="col-lg-3 team-block"> -->
            <!-- <div class="inner-box">
                    <div class="image"><img src="../CMS_MGMT_portal/uploads/about/about_image_1737541294.jpg" alt=""></div>
                    <div class="content">
                        <h4>Secretary</h4>
                        <div class="designation">Electrical LICENSE Board,
                            Thiru.Vi.Ka.Indl.Estate,
                            Guindy. Chennai – 600 032</div>
                    </div>
                    <div class="overlay">
                                <div class="content-two">
                                    <h4>Paul Wilson</h4>
                                    <div class="designation">mayor / Chairman</div>
                                    <ul class="contact-info">
                                        <li><a href="tel:+1(852)6105599"><i class="fas fa-phone"></i>+ 1 (852) 610
                                                5599</a></li>
                                        <li><a href="tel:+1(852)6105599"><i class="fas fa-envelope-open"></i>+ 1 (852)
                                                610 5599</a></li>
                                    </ul>
                                    <ul class="social-links">
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linked-in"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                </div> -->

             <div class="col-lg-4 event-block mt-5 news">
                <div class="inner-box wow fadeInUp animated" data-wow-delay="0ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">

                    <div class="lower-content ">

                        <!-- <div class="date">
                            
                            <img class="blinking-text" src="assets/images/new.png">

                        </div> -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                                               <h5 class="pt-10 mt-2 mb-2 notice-board" style="    font-size: 30px;
    text-transform: uppercase;">Notice Board</h5>

                            </div>

                        </div>


                        <!-- <div class="location"><i class="fas fa-map-marker-alt"></i>The fees structure for new issue and renewal of contractor licenses and competency certificates are revised w.e.f. 01-01-2024</div> -->

                        <marquee id="scrollMarquee" behavior="scroll" onmouseover="this.stop();" onmouseout="this.start();" direction="up" scrollamount="2" height="200">
                            @forelse ($newsboards ?? [] as $news)
                            @if ($news->page_type === 'url')
                            <p><a href="{{ $news->external_url }}" target="_blank">{{ $news->subject_en }} <i class="fa fa-external-link"></i> </a> </p>
                            @elseif ($news->page_type === 'pdf')
                            <p><a href="{{ asset($news->pdf_en) }}" target="_blank">{{ $news->subject_en }} <i class="fa fa-file-pdf-o"></i></a></p>
                            @elseif ($news->page_type === 'Static Page')
                            <p>
                                <a href="{{ route('noticeboardcontent', ['news_id' => $news->id]) }}">{{ $news->subject_en }} <i class="fa fa-folder-open-o"></i></a>

                            </p>
                            @else
                            <p>{{ $news->subject_en }}</p>
                            @endif
                            @empty
                            <p>No Newsboard Available</p>
                            @endforelse
                        </marquee>
                        <div class="row">

                            <div class="col-lg-12 col-md-12 text-right">

                                <button id="toggleScrollMarquee" class="btn btn-danger  mb-2"><i class="fa fa-pause"></i></button>
                            </div>

                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<hr>


<section class="services-section" style="background: #fbfbfb;">
    <div class="auto-container">


        <div class="row">
            <div class="col-lg-6">
                <div class="sec-title text-center">
                    <h2 style="color: #035ab3;">Competency Certificate</h2>
                </div>
                <div class="row">
                    <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form S</h4>
                                <div class="text">LICENSE  `C'</div>
                                <div class="link-btn">
                                     @auth
                                        
                                        <a href="{{ route('dashboard') }}">
                                            <button class="btn btn-primary">Go to Dashboard</button>
                                        </a>
                                    @else
                                        
                                        <a href="{{ route('login') }}">
                                            <button class="btn btn-primary">Apply Now</button>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form WH</h4>
                                <div class="text">LICENSE `H'</div>
                                <div class="link-btn">
                                      @auth
                                        
                                        <a href="{{ route('dashboard') }}">
                                            <button class="btn btn-primary">Go to Dashboard</button>
                                        </a>
                                    @else
                                        
                                        <a href="{{ route('login') }}">
                                            <button class="btn btn-primary">Apply Now</button>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form W</h4>
                                <div class="text">LICENSE  `B'</div>
                                <div class="link-btn">
                                      @auth
                                        
                                        <a href="{{ route('dashboard') }}">
                                            <button class="btn btn-primary">Go to Dashboard</button>
                                        </a>
                                    @else
                                        
                                        <a href="{{ route('login') }}">
                                            <button class="btn btn-primary">Apply Now</button>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form P</h4>
                                <div class="text">LICENSE  `P'</div>
                                <div class="link-btn">
                                     @auth
                                        
                                        <a href="{{ route('dashboard') }}">
                                            <button class="btn btn-primary">Go to Dashboard</button>
                                        </a>
                                    @else
                                        
                                        <a href="{{ route('login') }}">
                                            <button class="btn btn-primary">Apply Now</button>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form H TO B</h4>
                                <div class="text">LICENSE  `H TO B'</div>
                                <div class="link-btn"><a href="{{ route('login') }}"><button class="btn btn-primary">Apply Now</button></a></div>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
            <div class="col-lg-6">
            <div class="sec-title text-center">
                    <h2 style="color: #035ab3;">Contractor Licences</h2>
                </div>
                <div class="row">

                 <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon1"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form EA</h4>
                                <div class="text">LICENSE  `A'</div>
                                <div class="link-btn">
                                    @auth
                                        
                                        <a href="{{ route('dashboard') }}">
                                            <button class="btn btn-success">Go to Dashboard</button>
                                        </a>
                                    @else
                                        
                                        <a href="{{ route('login') }}">
                                            <button class="btn btn-success">Apply Now</button>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon1"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form ESA</h4>
                                <div class="text">LICENSE  `SA'</div>
                                <div class="link-btn">
                                    @auth
                                        
                                        <a href="{{ route('dashboard') }}">
                                            <button class="btn btn-success">Go to Dashboard</button>
                                        </a>
                                    @else
                                        
                                        <a href="{{ route('login') }}">
                                            <button class="btn btn-success">Apply Now</button>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon1"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form EB</h4>
                                <div class="text">LICENSE  `EB'</div>
                                <div class="link-btn">
                                    @auth
                                        
                                        <a href="{{ route('dashboard') }}">
                                            <button class="btn btn-success">Go to Dashboard</button>
                                        </a>
                                    @else
                                        
                                        <a href="{{ route('login') }}">
                                            <button class="btn btn-success">Apply Now</button>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 service-block">
                        <div class="inner-box">
                            <div class="icon1"><i class="icon-election"></i></div>
                            <div class="content">
                                <h4>Form ESB</h4>
                                <div class="text">LICENSE  `SB'</div>
                                <div class="link-btn">
                                    @auth
                                        
                                        <a href="{{ route('dashboard') }}">
                                            <button class="btn btn-success">Go to Dashboard</button>
                                        </a>
                                    @else
                                        
                                        <a href="{{ route('login') }}">
                                            <button class="btn btn-success">Apply Now</button>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                   

                </div>
            </div>
        </div>
    </div>
</section>
<section class="services-section-three">
    <div class="auto-container">

    </div>
</section>


<!-- Services section three -->
<section class="services-section-three" style="background-image: url(assets/images/bg/project-counter.jpg);">
    <div class="auto-container">
        <div class="row align-items-center">

            <div class="col-xl-6">
                <div class="content-block">
                    <div class="sec-title style-two mb-20 text-center">
                        <h2 class="text-white">Services & Standards</h2>
                    </div>
                    <div class="text text-white">We render the highest standards of service to public. This charter set out the standards for various functions of Electrical LICENSE Board so as to improve our service to public. These service levels are our maximum response period and we strive to beat these standards every time we can.</div>
                    <div class="row">
                        <!-- <div class="col-md-2 col-lg-2"></div> -->
                        <div class="col-md-12 col-lg-12">
                            <table class="services">
                                <tbody>
                                    <tr>
                                        <td>Issue of Certificates</td>
                                        <td><i class="fa fa-long-arrow-right"></i></td>
                                        <td>30 days</td>
                                    </tr>
                                    <tr>

                                        <td>Renewal of Certificates</td>
                                        <td><i class="fa fa-long-arrow-right"></i></td>
                                        <td>20 days</td>

                                    </tr>
                                    <tr>

                                        <td>Issue of Contractor License</td>
                                        <td><i class="fa fa-long-arrow-right"></i></td>
                                        <td>One month</td>

                                    </tr>
                                    <tr>

                                        <td>Renewal of License</td>
                                        <td><i class="fa fa-long-arrow-right"></i></td>
                                        <td>20 days</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="col-md-6  col-lg-6">
                                    <ul class="list2">
                                        <li>
                                            Issue of Certificates</li>
                                        <li>Renewal of Certificates</li>
                                        <li>Issue of Contractor License</li>
                                        <li>Renewal of License</li>
                       
                                    </ul>
                                </div>
                                <div class="col-md-6  col-lg-6">
                                    <ul class="list">
                                        <li>30 days</li>
                                        <li>20 days</li>
                                        <li>One month</li>
                                        <li>20 days</li>
                                    </ul>
                                </div> -->
                    </div>
                    <!-- <div class="icon"><img src="assets/images/bg/service-icon.png" alt=""></div> -->
                </div>
            </div>

            <div class="col-xl-6">
                <div class="row align-items-center">

                    <div class="col-xl-6">
                        <div class="sec-title style-two mb-20 text-center">
                            <h2 class="text-white">Contractor Licenses</h2>
                        </div>

                        <div class="ourfacts">
                            <!--Column-->
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="icon-outer">
                                        <div class="icon"><span class="icon-area"></span></div>
                                    </div>
                                    <div class="content">
                                        <div class="text">ESA</div>
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000"
                                                data-stop="412">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Column-->
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="icon-outer">
                                        <div class="icon"><span class="icon-people"></span></div>
                                    </div>
                                    <div class="content">
                                        <div class="text">EA</div>
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000"
                                                data-stop="2292">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Column-->
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="icon-outer">
                                        <div class="icon"><span class="icon-language"></span></div>
                                    </div>
                                    <div class="content">
                                        <div class="text">ESB</div>
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000"
                                                data-stop="2200">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- -------------------- -->
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="icon-outer">
                                        <div class="icon"><span class="icon-language"></span></div>
                                    </div>
                                    <div class="content">
                                        <div class="text">EB</div>
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000"
                                                data-stop="29">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ------------------------------ -->
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="sec-title style-two mb-20 text-center">
                            <h2 class="text-white">Competency Certificate</h2>
                        </div>
                        <div class="ourfacts">
                            <!--Column-->
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="icon-outer">
                                        <div class="icon"><span class="icon-area"></span></div>
                                    </div>
                                    <div class="content">
                                        <div class="text">Supervisory</div>
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000"
                                                data-stop="53902">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Column-->
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="icon-outer">
                                        <div class="icon"><span class="icon-people"></span></div>
                                    </div>
                                    <div class="content">
                                        <div class="text">Wireman</div>
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000"
                                                data-stop="138043">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Column-->
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="icon-outer">
                                        <div class="icon"><span class="icon-language"></span></div>
                                    </div>
                                    <div class="content">
                                        <div class="text">Wireman Helper</div>
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000"
                                                data-stop="23532">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Column-->
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="icon-outer">
                                        <div class="icon"><span class="icon-language"></span></div>
                                    </div>
                                    <div class="content">
                                        <div class="text">Power Generating</div>
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000"
                                                data-stop="243">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>


<section class="portfolio-section" id="portfolio">
    <div class="container-fluid">
        <div class="sec-title style-two mb-20 text-center">
            <h2 class="text-dark">Gallery</h2>
        </div>
        <!-- <div class="portfolio-menu mt-2 mb-2">
            <nav class="controls">
                <button type="button" class="btn btn-primary" data-filter="all">All</button>
                <button type="button" class="btn btn-primary" data-filter=".web">Photos</button>
                <button type="button" class="btn btn-primary" data-filter=".dev">Videos</button>
                <button type="button" class="btn btn-primary" data-filter=".wp">Others</button>
            </nav>
        </div> -->
         <ul class="row portfolio-item justify-content-center">
            @foreach ($Gallery as $item)
            <li class="mix {{ $item->category_class ?? 'web' }} col-xl-3 col-md-3 col-12 col-sm-6 pd">
                <img src="{{ asset('portaladmin/gallery/' . $item->image) }}" itemprop="thumbnail" alt="{{ $item->imagetitle }}" />
                <div class="portfolio-overlay">
                    <div class="overlay-content">
                        <p class="category">{{ $item->imagetitle }}</p>

                        <a data-fancybox="item" title="click to zoom-in" href="{{ asset('portaladmin/gallery/' . $item->image) }}">
                            <div class="magnify-icon">
                                <p><span><i class="fa fa-search" aria-hidden="true"></i></span></p>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>



<!-- Main  Footer -->
<footer class="main-footer">

    <div class="auto-container">
        <!--Widgets Section-->
        <div class="widgets-section">
            <div class="row clearfix">

                <div class="column col-lg-3 col-md-6">
                    <div class="widget contact-widget">
                        <h3 class="widget-title">Contact Details</h3>
                        <div class="widget-content">
                            <ul class="contact-info">
    @foreach($contactdetails as $contact)
        <li>
            <div class="icon">
                <img src="{{ asset('assets/images/icons/icon-1.png') }}" alt="">
            </div>
            <div class="text text-white">
                {{ $contact->address }}
            </div>
        </li>

        <li>
            <div class="icon">
                <img src="{{ asset('assets/images/icons/icon-2.png') }}" alt="">
            </div>
            <div class="text text-white">
                <strong>Phone No.</strong>
                <a href="tel:{{ $contact->mobilenumber }}" class="text-white">
                    {{ $contact->mobilenumber }}
                </a>
            </div>
        </li>

        <li>
            <div class="icon">
                <img src="{{ asset('assets/images/icons/icon-3.png') }}" alt="">
            </div>
            <div class="text text-white">
                <strong>Email</strong>
                <a href="mailto:{{ $contact->email }}" class="text-white">
                    {{ $contact->email }}
                </a>
            </div>
        </li>
    @endforeach
</ul>
                        </div>
                    </div>
                </div>


                <!--Column-->
                <div class="column col-lg-4 col-md-6">
                    <div class="widget links-widget">
                        <h3 class="widget-title">Quick Links</h3>
                        <div class="widget-content">
                            <!-- <ul>
                                <li><a href="/about">About</a></li>
                                <li><a href="/members">Members</a></li>
                                <li><a href="/rules">Rules</a></li>
                                <li><a href="/services-and-standards">Services & Standards</a></li>
                                <li><a href="/complaints">Complaints</a></li>
                                <li><a href="/contact">Contact</a></li>
                            </ul> -->

                            <ul>
                                @foreach($quicklinks as $quicklink)
                                <li class="text-capitalize">
                                    @php
                                    $link = '#';
                                    $target = '';
                                    $label = $quicklink->footer_menu_en;

                                    if ($quicklink->page_type === 'Static Page') {
                                    $link = '/tnelb_web' . $quicklink->menuPage?->page_url ?? '#';
                                    } elseif ($quicklink->page_type === 'url') {
                                    $link = $quicklink->menuPage?->external_url ?? '#';
                                    $target = '_blank';
                                    }
                                    @endphp

                                    @if($quicklink->page_type === 'pdf')
                                    @if($quicklink->menuPage?->pdf_en)
                                    <a href="{{ asset($quicklink->menuPage->pdf_en) }}" target="_blank" title="English PDF">
                                        <i class="fa fa-file-pdf-o text-danger"></i> {{ $label }} (EN)
                                    </a>
                                    @endif
                                    @if($quicklink->menuPage?->pdf_ta)
                                    <a href="{{ asset($quicklink->menuPage->pdf_ta) }}" target="_blank" title="Tamil PDF">
                                        <i class="fa fa-file-pdf-o text-success"></i> {{ $label }} (TA)
                                    </a>
                                    @endif
                                    @elseif($quicklink->page_type === 'submenu')
                                    — {{ $label }}
                                    @else
                                    <a href="{{ $link }}" target="{{ $target }}">{{ $label }}</a>
                                    @endif
                                </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>

                <!--Column-->
                <div class="column col-lg-3 col-md-6">
                    <div class="widget links-widget">
                        <h3 class="widget-title">Useful Links</h3>
                        <div class="widget-content">
                            <ul>
                                   @foreach($usefullinks as $usefullink)
                                <li class="text-capitalize">
                                    @php
                                    $link = '#';
                                    $target = '';
                                    $label = $usefullink->menu_name_en;

                                    if ($usefullink->page_type === 'Static Page') {
                                    $link = '/tnelb_web' .  $usefullink->menuPage?->page_url ?? '#';
                                    } elseif ($usefullink->page_type === 'url') {
                                    $link = $usefullink->menuPage?->external_url ?? '#';
                                    $target = '_blank';
                                    }
                                    @endphp

                                    @if($usefullink->page_type === 'pdf')
                                    @if($usefullink->menuPage?->pdf_en)
                                    <a href="{{ asset($usefullink->menuPage->pdf_en) }}" target="_blank" title="English PDF">
                                        <i class="fa fa-file-pdf-o text-danger"></i> {{ $label }} (EN)
                                    </a>
                                    @endif
                                    @if($usefullink->menuPage?->pdf_ta)
                                    <a href="{{ asset($usefullink->menuPage->pdf_ta) }}" target="_blank" title="Tamil PDF">
                                        <i class="fa fa-file-pdf-o text-success"></i> {{ $label }} (TA)
                                    </a>
                                    @endif
                                    @elseif($usefullink->page_type === 'submenu')
                                    — {{ $label }}
                                    @else
                                    <a href="{{ $link }}" target="{{ $target }}">{{ $label }}</a>
                                    @endif
                                </li>
                                @endforeach
                                <!-- <li><a href="#">Terms of use</a></li>
                                <li><a href="#">Website Policies</a></li>
                                <li><a href="#">Site Map</a></li>
                                <li><a href="#">Help</a></li> -->

                            </ul>
                        </div>
                    </div>
                </div>

                <!--Column-->


            </div>
        </div>
    </div>

    @include('include.footer')
    <script>
         /*Downloaded from https://www.codeseek.co/ezra_siton/mixitup-fancybox3-JydYqm */
        // 1. querySelector
        var containerEl = document.querySelector(".portfolio-item");
        // 2. Passing the configuration object inline
        //https://www.kunkalabs.com/mixitup/docs/configuration-object/
        var mixer = mixitup(containerEl, {
            animation: {
                effects: "fade translateZ(-100px)",
                effectsIn: "fade translateY(-100%)",
                easing: "cubic-bezier(0.645, 0.045, 0.355, 1)"
            }
        });


        let items = document.querySelectorAll("#newsFlipper .news-item");
let current = 0;

function flipNews() {
    items[current].classList.remove("active");
    current = (current + 1) % items.length;
    items[current].classList.add("active");
}

if (items.length > 0) {
    items[0].classList.add("active"); // show first item
    setInterval(flipNews, 5000); // 5 seconds
}

    </script>