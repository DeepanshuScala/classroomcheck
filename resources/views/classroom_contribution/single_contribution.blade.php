@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@include('modal.contribution_pay_modal')
@if(!auth()->user())
@section('breadcrub_section')

<section class="breadcrumb-section bg-light-blue pt-2">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a><i class='fal fa-home-alt'></i> Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Classromm Contribution</li>
            </ol>
        </nav>
    </div>
</section>
@endsection('breadcrub_section')
@endif
@section('content')
<?php if ($data['result'] == null) { ?>
    <div class="alert alert-danger">
        <p>Contribution Not Found</p>
    </div>
<?php } else {
    ?>
    <section class="inner_page_baner">
        <div class="inner_page_title store-view-img">
            <?php if ($data['result']->fundraising_banner != '') { ?>
                <img src="{{ url('storage/uploads/contributions/' . $data['result']->fundraising_banner) }}" alt="inner banner" class="img-fluid">
            <?php } else { ?>
                <img src="{{asset('images/inner-banner.jpg')}}" alt="inner banner" class="img-fluid">
            <?php } ?>
        </div>
    </section>

    <!-- page title end  -->
    <!-- Book Bin products section start -->
    <section class="contribution-main new-contribution">
        <?php $fundCompleted = round(($data['result']->funded_amount * 100) / $data['result']->target_amount);
        ?>
        <div class="container">
            <div class="row mb-4 mb-md-4">
                <div class="col-12">
                    <h4>{{ $data['result']->fundraising_title }}</h4>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>User Name:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ $data['result']->user_name }}</p>

                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Name:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ $data['result']->first_name." ".$data['result']->surname }}</p>

                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Slogan:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ $data['result']->fundraising_slogan }}</p>

                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>About:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ $data['result']->about_fundraiser }}</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Target:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>${{ number_format($data['result']->target_amount,2) }}</p>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 col-12">
                    <div class="pie-gragh">
                        <div class="graph-box">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="single-chart">
                                        <svg viewBox="0 0 36 36" class="circular-chart orange">
                                        <path class="circle-bg"
                                              d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                              />
                                        <path class="circle"
                                              stroke-dasharray="{{ $fundCompleted }}, 100"
                                              d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                              />
                                        <text x="18" y="17.80" class="percentage">{{ $fundCompleted }}%</text>
                                        <text x="10" y="24.35" class="text-percent">Of Target</text>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pie-content">
                                        <p>Total Raised So Far</p>
                                        <h4>$ {{ number_format($data['result']->funded_amount,2) }}</h4>
                                        <span>Of $ {{ number_format($data['result']->target_amount,2) }} Target</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center my-4 mt-5">
                <div class="col-12">
                    <button type="button" class="btn btn-primary bg-blue btn-lg px-5 py-3  btn-hover text-uppercase support-now">support now</button>
                </div>
            </div>
        </div>
    </section>
    <!-- book bin products section end  -->
<?php } ?>
@endsection
@push('script')
<script type="text/javascript">
    $(document).ready(function(){
        $(".support-now").on('click',function(){
            $("#contirbutionSupport input[name='contribution_id']").val("{{$data['result']->id}}");
            $("#contirbutionSupport").modal('show');
        });
    });
</script>
@endpush