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
                    <li class="breadcrumb-item" aria-current="page">
                        @if(isset($data['breadcrumb1_link']) && $data['breadcrumb1_link'])
                            <a href="{{$data['breadcrumb1_link']}}">{{$data['breadcrumb1']}}</a>
                        @else
                            {{$data['breadcrumb1']}}
                        @endif
                    </li>
                @endif
                @if(isset($data['breadcrumb2']) && $data['breadcrumb2'])
                    <li class="breadcrumb-item" aria-current="page">
                        @if(isset($data['breadcrumb2_link']) && $data['breadcrumb2_link'])
                            <a href="{{$data['breadcrumb2_link']}}">{{$data['breadcrumb2']}}</a>
                        @else
                            {{$data['breadcrumb2']}}
                        @endif
                    </li>
                @endif
                @if(isset($data['breadcrumb3']) && $data['breadcrumb3'])
                    <li class="breadcrumb-item" aria-current="page">
                        @if(isset($data['breadcrumb3_link']) && $data['breadcrumb3_link'])
                            <a href="{{$data['breadcrumb3_link']}}">{{$data['breadcrumb3']}}</a>
                        @else
                            {{$data['breadcrumb3']}}
                        @endif
                    </li>
                @endif
                @if(isset($data['breadcrumb4']) && $data['breadcrumb4'])
                    <li class="breadcrumb-item" aria-current="page">
                        @if(isset($data['breadcrumb4_link']) && $data['breadcrumb4_link'])
                            <a href="{{$data['breadcrumb4_link']}}">{{$data['breadcrumb4']}}</a>
                        @else
                            {{$data['breadcrumb4']}}
                        @endif
                    </li>
                @endif

            </ol>
        </nav>
    </div>
</section>
@endsection('breadcrub_section')
@endif

@section('content')
<!--Document and Policies Section Starts Here-->
<section class="help-faq-section doc-policies py-5">
    <div class="container">
        <h1 class="text-uppercase pt-2 pb-4">Documents And Policies </h1>
        <div class="row gx-3 gx-sm-4">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{ URL('web/privacy_policy') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon-box_1 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/doc-policy-1.png')}}" class="img-fluid " alt="doc-policy-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">Privacy policy </h4>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{ URL('web/terms_policy') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon-box_2 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/doc-policy-2.png')}}" class="img-fluid " alt="doc-policy-2 ">
                            </div>
                            <h4 class="pt-3 mb-2">Terms & Conditions </h4>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{ URL('web/taxation_policy') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon-box_3 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/doc-policy-3.png')}}" class="img-fluid " alt="doc-policy-3 ">
                            </div>
                            <h4 class="pt-3 mb-2">Taxation Policy</h4>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{ URL('web/seller_agreement') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon-box_4 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/doc-policy-4.png')}}" class="img-fluid " alt="doc-policy-4 ">
                            </div>
                            <h4 class="pt-3 mb-2">Seller Agreement</h4>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{ URL('web/intellectual_property') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon-box_3 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/doc-policy-5.png')}}" class="img-fluid " alt="doc-policy-5 ">
                            </div>
                            <h4 class="pt-3 mb-2">Intellectual Property </h4>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{ URL('web/refund_policy') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon-box_6 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/doc-policy-6.png')}}" class="img-fluid " alt="doc-policy-6 ">
                            </div>
                            <h4 class="pt-3 mb-2">Refund Policy</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!--Document and Policies Section Ends Here-->
@endsection


