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
<!--Privacy Policy Section Starts Here-->
<section class="privacy-policy-section py-5">
    <div class="container">
        <div class="row py-4 justify-content-center">
            <div class="col-md-10">
                <div class="related-box-details">
                    <div id="carouselExampleCaptionsblog" class="carousel slide mb-5" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($data['result']->imageArr as $key => $row) { ?>
                                <div class="carousel-item <?php if ($key == 0) { ?> active <?php } ?>">
                                    <img src="{{ url('storage/uploads/blogs/' . $row) }}" class="d-block w-100 img-fluid" alt="slide-1">
                                </div>
                            <?php } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptionsblog" data-bs-slide="prev">
                            <i class="fal fa-angle-left fa-2x"></i>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptionsblog" data-bs-slide="next">
                            <i class="fal fa-angle-right fa-2x"></i>
                        </button>
                    </div>
                    <div class="related-content-details">
                        <h1>{{ $data['result']->title }}</h1>
                        <div class="my-2 d-flex">
                            <span class=" time">{{ date('F d, Y',strtotime($data['result']->created_at)) }}</span> 
                            <span class="mx-2">/</span>  
                            <span class=" time">By Admin</span>
                        </div>
                        {!! $data['result']->long_description !!}
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
<!--Privacy Policy Section Ends Here-->
@endsection

@push('script')
@endpush

