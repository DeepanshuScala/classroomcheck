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
<!--Main Banner Section Starts Here-->
<section class="hero-section about-us  py-5">
    <div class="container">
        <div class="row flex-lg-row-reverse align-items-start g-4">
            <div class="col-12 col-sm-12 col-lg-6 ">
                <?php
                if ($data['result'] != null && $data['result']->about_us_image != '' && $data['result']->about_us_image != null) {
                    $about_us_image = url('storage/uploads/about_us/' . $data['result']->about_us_image);
                } else {
                    $about_us_image = "images/about.jpg";
                }
                if ($data['result'] != null && $data['result']->founding_story_image != '' && $data['result']->founding_story_image != null) {
                    $founding_story_image = url('storage/uploads/about_us/' . $data['result']->founding_story_image);
                } else {
                    $founding_story_image = "images/Kristen.jpg";
                }
                ?>
                <img src="{{ $about_us_image }}" class="d-block mx-lg-auto img-fluid" alt="about-img">
            </div>
            <div class="col-lg-6 col-sm-12 my-0 py-4">
                <h1 class="display-5 fw-bold lh-1 mb-3 text-uppercase d-flex flex-column">Our Story<br><span class="blue display-5 fw-bold">Who We are </span></h1>
                {!! ($data['result'] != null) ? $data['result']->about_us : 'N/A' !!}
            </div>
        </div>
    </div>
</section>
<!--Main Banner Section Ends Here-->

<!--Content Section Starts Here-->
<section class="books-section content-section pb-5">
    <div class="container text-center">
        <div class="row">
            <h2 class="text-uppercase pt-2 pb-5"><span class="border px-5 py-2">OUR MISSION </span></h2>
            {!! ($data['result'] != null) ? $data['result']->our_mission : 'N/A' !!}
        </div>

        <div class="row">
            <h2 class="text-uppercase py-5"><span class="border px-5 py-2">OUR VISION </span></h2>
            {!! ($data['result'] != null) ? $data['result']->our_vision : 'N/A' !!}
        </div>
    </div>
</section>
<!--Content Section Ends Here-->
<section class="testimonial-section aboutus-bg py-5">
    <div class="container">
        <div class="row">
            <h3 class="text-uppercase py-4 pb-5"><span class="heading border px-5 py-2">FOUNDING STORY</span></h3>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 mb-4 kristen-pic">
                <img src="{{ $founding_story_image }}" class="img-fluid w-100" alt="Kristen">

            </div>
            <div class="col-12 col-sm-12 col-md-9 col-lg-9 px-3 px-md-5">
                {!! ($data['result'] != null) ? $data['result']->founding_story_description : 'N/A' !!}
            </div>
        </div>
    </div>
</section>
@endsection
