@include('include.header')

<section class="page-title bg-breadcrumbs" >
    <div class="auto-container">
        <div class="content-box">
            <div class="content-wrapper">
                <div class="title">
                    <h1 class="text-uppercase">Vision</h1>
                </div>
                <ul class="bread-crumb">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>Vision </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- About section -->
<section class="about-section style-two pb-150">
    <div class="auto-container">
        <div class="row">
            <p class="text-dark">
            {!! $page->menucontent ?? 'No content available' !!}
            </p>
        </div>
        <div class="separator50"></div>
    </div>
</section>

<footer class="main-footer">
    @include('include.footer')

