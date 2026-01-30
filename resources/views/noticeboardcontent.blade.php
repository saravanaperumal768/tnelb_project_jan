@include('include.header')

<section class="page-title bg-breadcrumbs">
    <div class="auto-container">
        <div class="content-box">
            <div class="content-wrapper">
                <div class="title">
                    <h1 class="text-uppercase">Notice Board</h1>
                </div>
                <ul class="bread-crumb">
                    <li><a href="/">Home</a></li>
                    <li>Notice Board </li>
                    <!-- <li>About </li> -->
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- About section -->
<section class="about-section style-two">
    <div class="auto-container">

        <div class="row content-block">
            <div class="col-lg-12">
                <div class="">
                    <h3>{{ $news->subject_en }}</h3>
                    <div>{!! $news->newsboardcontent_en !!}</div>
                </div>
            </div>





        </div>

        <div class="separator50"></div>
    </div>
</section>

<footer class="main-footer">
    @include('include.footer')