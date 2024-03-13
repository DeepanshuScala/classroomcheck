@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Store Dashboard Section Starts Here-->
    <section class="help-faq-section store-dashboard-report py-5">
        <div class="container">
            <div class="row align-items-center pb-4">
                <div class="col-12 col-sm-12 col-lg-8">
                    <h1 class="text-uppercase"> Reports</h1>
                </div>
                <div class="col-12 col-sm-12 col-lg-4 pt-5">
                    <div class="text-end pb-5 store-dashboard-right">
                        <a href="{{route('store.dashboard')}}" class="blue acc-dashboard"><img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2" alt="">Store Dashboard</a>
                    </div>
                </div>
            </div>


            <div class="row row-cols-5 col-12 row-cols-sm-12 row-cols-md-3 row-cols-lg-3 row-cols-xl-5 gx-3 gx-sm-4">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.salesReport')}}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon_bg_1 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-1.png')}}" class="img-fluid " alt="report-icon-1 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Sales </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.SalesByCountry')}}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card ">
                                <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-2.png')}}" class="img-fluid " alt="report-icon-2 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Sales by Country </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.salesTax')}}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-3.png')}}" class="img-fluid " alt="report-icon-3 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Sales Tax</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.products')}}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon_bg_4 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-4.png')}}" class="img-fluid " alt="report-icon-4 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Products </h4>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.marketing')}}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon_bg_5 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-5.png')}}" class="img-fluid " alt="report-icon-5 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Marketing</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--Store Dashboard Section Ends Here-->
@endsection