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
<section class="privacy-policy-section pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 col-sm-12 py-4">
                <h1 class="text-uppercase pt-3"> Blog</h1>
            </div>
        </div>
        <div class="row py-4">
            <?php
            if (count($data['result']) > 0) {
                foreach ($data['result'] as $row) {
                    ?>
                    <div class="col-md-4">
                        <div class="related-box">
                            <a href="{{ URL('/blog-details').'/'.$row->id }}">
                                <?php
                                if ($row->image1 != '' && $row->image1 != null)
                                    $image = $row->image1;
                                else if ($row->image2 != '' && $row->image2 != null)
                                    $image = $row->image2;
                                else if ($row->image3 != '' && $row->image3 != null)
                                    $image = $row->image3;
                                ?>
                                <img src="{{ url('storage/uploads/blogs/' . $image) }}" class="img-fluid" alt="post img">
                            </a>
                            <div class="related-content">
                                <h5>
                                    <a href="{{ URL('/blog-details').'/'.$row->id }}">{{ $row->title }}</a>
                                </h5>
                                <p>{{ $row->short_description }}</p>
                                <div class="d-flex mt-3 time-box justify-content-between">
                                    <span>{{ date('F d, Y',strtotime($row->created_at)) }}</span>
                                    <a href="{{ URL('/blog-details').'/'.$row->id }}">Read Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-md-4">
                    <p class="text-center"><i class="fa fa-blog fa-4x"></i></p>
                    <h4 class="text-center text-muted">No Blogs Added Yet</h4>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!--Privacy Policy Section Ends Here-->
@endsection

@push('script')
@endpush

