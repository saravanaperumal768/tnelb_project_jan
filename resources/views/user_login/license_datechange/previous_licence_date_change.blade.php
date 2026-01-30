@include('include.header')

<!-- <section class="page-title" style="background-image: url(assets/images/slider/slider3.jpg);">
    <div class="auto-container">
        <div class="content-box">
            <div class="content-wrapper">
                <div class="title">
                    <h1 class="text-uppercase">Register</h1>
                </div>
                <ul class="bread-crumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Register </li>

                </ul>
            </div>
        </div>
    </div>
</section> -->

<!-- About section -->

<style>
    hr {
        margin-top: 2px;
        margin-bottom: 5px;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, .1);
    }

    .form-group {
        margin-bottom: 0px;
    }

    #success {
        background: green;
    }

    #error {
        background: red;
    }

    #warning {
        background: coral;
    }

    #info {
        background: cornflowerblue;
    }

    #question {
        background: grey;
    }

    /* .swal2-popup.swal2-modal.swal2-show {
        width: 100%;
    } */

    .swal2-popup li {
        font-size: 15px;
        margin-bottom: 8px;
    }


    .swal2-popup li {
        font-size: 15px;
        margin-bottom: 8px;
    }

    .swal2-popup li ul {
        margin-left: 15px;
    }
</style>

<section class="">
    <div class="container">
        <ul id="breadcrumb">
            <li><a href="{{ route('dashboard')}}"><span class="fa fa-home"> </span> Dashboard</a></li>
            <li><a href="#"><span class=" fa fa-info-circle"> </span> License Date Change</a></li>

        </ul>
    </div>
</section>
<section class="apply-form">
    <div class="auto-container">
        <div class="wrapper-box">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="apply-card apply-card-info" data-select2-id="14">
                        <div class="apply-card-header" style="background-color: #70c6ef  !important;">
                            <div class="row">
                                <div class="col-6 col-lg-8">
                                    <h5 class="card-title_apply text-black text-left"> License Date Change </h5>
                                </div>



                            </div>

                        </div>
                        <div class="apply-card-body">

                            <form id="license_date_change">
                                @csrf
                                <div class="row align-items-center">

                                    {{-- Certificate Type --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Certificate Type</label>
                                        <select class="form-control" id="cert_type" name="cert_type">
                                            <option value="">Select Type</option>
                                            <option value="S">C/S Certificate</option>
                                            <option value="W">W/B Certificate</option>
                                        </select>
                                    </div>

                                    {{-- Certificate Number --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Certificate Number</label>

                                        <select class="form-control d-none" id="s_certificate">
                                            <option value="">Select Certificate</option>
                                            @foreach($s_cert as $l)
                                            <option value="{{ $l->certno }}">{{ $l->certno }}</option>
                                            @endforeach
                                        </select>

                                        <select class="form-control d-none" id="w_certificate">
                                            <option value="">Select Certificate</option>
                                            @foreach($w_cert as $l)
                                            <option value="{{ $l->certno }}">{{ $l->certno }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Expiry Date --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Expiry Date</label>
                                        <input type="date" class="form-control" id="expiry" name="vdate">
                                    </div>

                                    <div class="col-md-12 text-center mt-3">
                                        <button class="btn btn-success">Save Expiry Date</button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="draftModal" class="overlay-bg" style="display: none;">
    <div class="otp-modal">
        <h5>Your Application Details Saved Successfully</h5>
        <br>
        <button onclick="closeDraftModal()">OK</button>
    </div>
</div>

</div>

<footer class="main-footer">

    @include('include.footer')

    <script>
        $('#cert_type').on('change', function() {
            let type = $(this).val();

            $('#s_certificate, #w_certificate').addClass('d-none').val('');
            $('#expiry').val('');

            if (type === 'S') $('#s_certificate').removeClass('d-none');
            if (type === 'W') $('#w_certificate').removeClass('d-none');
        });

        // Load expiry date
        $('#s_certificate, #w_certificate').on('change', function() {
            let certno = $(this).val();
            let type = $('#cert_type').val();

            if (!certno) return;

            $.post("{{ route('get.expiry') }}", {
                _token: '{{ csrf_token() }}',
                certno: certno,
                type: type
            }, function(res) {
                $('#expiry').val(res.vdate);
            });
        });

        // Save expiry date
        $('#license_date_change').on('submit', function(e) {
            e.preventDefault();

            let type = $('#cert_type').val();
            let certno = type === 'S' ?
                $('#s_certificate').val() :
                $('#w_certificate').val();

            $.post("{{ route('update.expiry') }}", {
                _token: '{{ csrf_token() }}',
                certno: certno,
                type: type,
                vdate: $('#expiry').val()
            }, function() {
                alert('Expiry date updated successfully');
            });
        });
    </script>