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
                    <h1 class="text-uppercase">Services & Standards</h1>
                </div>
                <ul class="bread-crumb">
                    <li><a href="/">Home</a></li>
                    <li>Services & Standards </li>
                    <!-- <li>About </li> -->
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- About section -->
<section class="about-section style-two">
    <div class="auto-container">

        <div class="row  mb-20">
           
 <div class="col-lg-12 mt-2">
            {!! $page->menucontent ?? 'No content available' !!}
            </div>

        </div>

   
       


    </div>
</section>

<footer class="main-footer">
@include('include.footer')