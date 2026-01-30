

@include('include.header')

<section class="page-title bg-breadcrumbs" >
    <div class="auto-container">
        <div class="content-box">
            <div class="content-wrapper">
                <div class="title">
                    <h1 class="text-uppercase">About</h1>
                </div>
                <ul class="bread-crumb">
                    <li><a href="/">Home</a></li>
                    <li>About </li>
                    <!-- <li>About </li> -->
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- About section -->
<section class="about-section style-two">
    <div class="auto-container">
      
        <div class="row content-block" style="display: none;">
            <div class="col-lg-6">
                <div class="bottom-content">
                    <ul class="list">
                        <li>The Chief Electrical Inspector to Government functions as nominated member of the Tamilnadu Government in the Central Electricity Board in the legislation of the Indian electricity rules 1956. </li>
                        <li>Chief Electrical Inspector to Government has to offer technical opinion to the Government in matters referred to him in connection with the electricity. </li>
                        <li>Chief Electrical Inspector to Government functions as a member of the technical committees of the Bureau of Indian Standards in the electro technical field. </li>
                        <li>Chief Electrical Inspector to Government is to function as a member of the power and telegraph co-ordinations committee to enforce power and telegraph co-ordinations committee code. </li>
                        <li>Chief Electrical Inspector to Government is the ex- officio president of the Tamilnadu Electrical Licensing Board constituted under rule 45 of Indian Electricity rules 1956. </li>

                    </ul>

                </div>
            </div>

            <div class="col-lg-6">
                <blockquote>
                    <div class="quote"><span class="icon-quote"></span></div>
                    <p>Rule 45 (i) of Indian Electricity Rules 1956 stipulates that Electrical Installation works including addition, alteration etc., excepting petty repairs should be carried out.</p>

                </blockquote>

                <ul class="list">
                    <li>By an Electrical Contractor Licensed by State Government and </li>
                    <li>Under direct supervision of a person holding a certificate of competency issued or recognized by the State Government.</li>


                </ul>
            </div>



        </div>
        <div class="row" style="display: none;">
            <p class="text-dark">
            The Electrical Licensing Board is the statutory body originally constituted by state Government in G.O.Ms.No.4317, PWD Dated 16.11.1955 and subsequently Re-constituted as broad based Board functions on behalf of the Government for the grant of certificate of competency to Wireman Helper, Wireman, Supervisor and Licenses to Electrical Contractors and for implementation of the provisions contained in Sub-Rule 2 A of Rule 3 of Indian Electricity Rules 1956 in regard to the competancy certificates to the Personnel Operating in Power Generating Stations and associated Sub-Stations.
            </p>
            <p class="text-dark">
            Chief Electrical Inspector to Government is the Ex-Officio President and Treasurer of Electrical Licensing Board, One of the Electrical Inspectors of the Electrical Inspectorate is the full time Secretary of the Board. Eleven others representing various Government Departments, Institutions and Contractors Association are acting as members of the Board. It is a service oriented financially autonomous statutory organisation.
            </p>
            
        </div>

    </div>
</section>


<section class="about-section style-two">
    <div class="auto-container">
      
        <div class="row " >
            <div class="col-lg-12">
                <div class="bottom-content">
                {!! $page->menucontent ?? 'No content available' !!}

                </div>
            </div>

           



        </div>
        

    </div>
</section>

<footer class="main-footer">

@include('include.footer')