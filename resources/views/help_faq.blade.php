@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@if(!auth()->user())
    @section('breadcrub_section')
        <section class="breadcrumb-section bg-light-blue pt-2">
            <div class="container py-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @if(isset($data['home']) && $data['home'])
                            <li class="breadcrumb-item active"><a href="{{route('classroom.index')}}"><i class='fal fa-home-alt'></i> {{$data['home']}}</a></li>
                        @endif
                        @if(isset($data['breadcrumb1']) && $data['breadcrumb1'])
                            <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb1']}}</li>
                        @endif
                        @if(isset($data['breadcrumb2']) && $data['breadcrumb2'])
                            <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb2']}}</li>
                        @endif
                        @if(isset($data['breadcrumb3']) && $data['breadcrumb3'])
                            <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb3']}}</li>
                        @endif
                        @if(isset($data['breadcrumb4']) && $data['breadcrumb4'])
                            <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb4']}}</li>
                        @endif

                    </ol>
                </nav>
            </div>
        </section>
    @endsection('breadcrub_section')
@endif

@section('content')
<!--Help & FAQ Section Starts Here-->
    <section class="help-faq-section py-5">
        <div class="container">
            <h1 class="text-uppercase pt-2 pb-4">Help and faq: </h1>
            <div class="row gx-3 gx-sm-4">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{ URL('faq') }}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_1 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-1.png " class="img-fluid " alt="help-icon-1 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">FAQ</h4>
                                <p class="px-2 px-lg-5 mb-0 ">Answers to some of our most<br> frequently asked questions</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{ URL('web/buying_started') }}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_2 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-2.png " class="img-fluid " alt="help-icon-2 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Getting Started – Buying </h4>
                                <p class="px-2 px-lg-5 mb-0 ">Step by Step guide to buying <br> resources on Classroom Copy
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{ URL('/become-a-seller') }}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_3 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-3.png " class="img-fluid " alt="help-icon-3 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Getting Started – Selling
                                </h4>
                                <p class="px-2 px-lg-5 mb-0 ">Step by Step guide to selling <br>resources on Classroom Copy
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{ URL('web/account_mgnt') }}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_4 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-4.png " class="img-fluid " alt="help-icon-4 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Account Management
                                </h4>
                                <p class="px-2 px-lg-5 mb-0 ">How to set up or make <br>changes to your account
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{ URL('document-and-policies') }}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_3 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-5.png " class="img-fluid " alt="help-icon-5 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Policies and Documents</h4>
                                <p class="px-2 px-lg-5 mb-0 ">View all policies and <br> documents
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{ URL('web/copyright_intellectual_property') }}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_6 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-6.png " class="img-fluid " alt="help-icon-6 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Copyright /Intellectual Property</h4>
                                <p class="px-2 px-lg-5 mb-0 ">Find out what you can and <br>cannot use and when
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{ URL('web/payment_system') }}">
                        <div class="card card-box border-0 text-center h-100 py-5 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_7 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-7.png " class="img-fluid " alt="help-icon-7 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Payment System
                                </h4>
                                <p class="px-2 px-lg-5 mb-0 ">How to set up your<br> payment system</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{ URL('web/classroom_contributions') }}">
                        <div class="card card-box border-0 text-center h-100 py-5">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_2 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-8.png " class="img-fluid " alt="help-icon-8 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Classroom Contributions</h4>
                                <p class="px-2 px-lg-5 mb-0">What is a Classroom <br>Contribution?</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                    <a href="{{url('/contact-us')}}">
                        <div class="card card-box border-0 text-center h-100 py-5">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_3 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/help-icon-9.png " class="img-fluid " alt="help-icon-9 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Support
                                </h4>
                                <p class="px-2 px-lg-5 mb-0 ">Contact us for additional<br> support
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                
            </div>
        </div>
    </section>

    <!--Help & FAQ Section Ends Here-->
@endsection
