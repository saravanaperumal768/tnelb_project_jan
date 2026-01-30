@include('include.header')

<section class="page-title bg-breadcrumbs" >
    <div class="auto-container">
        <div class="content-box">
            <div class="content-wrapper">
                <div class="title">
                    <h1 class="text-uppercase">Mission</h1>
                </div>
                <ul class="bread-crumb">
                    <li><a href="/">Home</a></li>
                    <li>Mission </li>
                    <!-- <li>About </li> -->
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- About section -->
<section class="about-section style-two">
    <div class="auto-container">
      
        <div class="row content-block" >
            <div class="col-lg-12">
                <div class="bottom-content">
                {!! $page->menucontent ?? 'No content available' !!}

                </div>
            </div>

            



        </div>
       
        <div class="separator50"></div>
    </div>
</section>

<footer class="main-footer">
@include('include.footer')