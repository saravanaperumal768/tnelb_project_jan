@include('include.header')
<style> 
table{
    background-color: #035ab3;
    color: #fff;
}

table td{
   border: 1px solid #fff;
}
</style>
<section class="page-title bg-breadcrumbs" >
    <div class="auto-container">
        <div class="content-box">
            <div class="content-wrapper">
                <div class="title">
                    <h1 class="text-uppercase">Rules</h1>
                </div>
                <ul class="bread-crumb">
                    <li><a href="/">Home</a></li>
                    <li>Rules </li>
                    <!-- <li>About </li> -->
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- About section -->
<section class="about-section style-two rule">
    <div class="auto-container">

        <div class="row ">
            <div class="col-lg-12 mt-2">
            {!! $page->menucontent ?? 'No content available' !!}
            </div>
              
        </div>


    </div>
</section>

<footer class="main-footer">
@include('include.footer')