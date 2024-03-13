@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>Product Dashboard</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{route('store.dashboard')}}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Store Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- page title end  -->
<!-- Book Bin products section start -->
<section class="help-faq-section products_dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">

                <a href="{{route('storeDashboard.addProduct')}}" class="productaddcls">
                    <div class="card card-box border-0 text-center h-100 py-4">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_1 rounded-circle text-center mx-auto py-5">
                                <img src="{{asset('images/add-products-icon.png')}}" class="img-fluid" alt="store-dash-1">
                            </div>
                            <h4 class="pt-3 mb-2">Add Products</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="{{ URL('/store-dashboard/product-list') }}">
                    <div class="card card-box border-0 text-center h-100 py-4">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5">
                                <img src="{{asset('images/view-edit-icon.png')}}" class="img-fluid" alt="store-dash-1">
                            </div>
                            <h4 class="pt-3 mb-2">View / Edit Products</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="{{route('rating.review.list')}}">
                    <div class="card card-box border-0 text-center h-100 py-4">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5">
                                <img src="{{asset('images/rating-review-icon.png')}}" class="img-fluid" alt="store-dash-1">
                            </div>
                            <h4 class="pt-3 mb-2">Ratings / Reviews</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- book bin products section end  -->
@endsection