@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>Payment Systems</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{ URL('dashboard/account') }}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Account Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page title end  -->

<?php
if (Session::has('error')) {
    ?>
    <script>
        Swal.fire({
            title: 'Oops!',
            text: "{{ Session::get('error') }}",
            icon: 'error',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    </script>
<?php }if (Session::has('success')) { ?>
    <script>
        Swal.fire({
            title: 'Congratulations!',
            text: "{{ Session::get('success') }}",
            icon: 'success',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    </script>
<?php } ?>

<!-- Book Bin products section start -->
<section class="help-faq-section products_dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <a href="{{ URL('/buyer/add-card') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_1 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/add-products-icon.png')}}" class="img-fluid " alt="store-dash-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">Add Card</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-4">
                <a href="{{ URL('/buyer/card-list') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/view-edit-icon.png')}}" class="img-fluid " alt="store-dash-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">View / Edit Card</h4>
                        </div>
                    </div>
                </a>
            </div>

            

        </div>
    </div>
</section>
<!-- book bin products section end  -->
@endsection
