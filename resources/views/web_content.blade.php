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
<!--Privacy Policy Section Starts Here-->
<section class="privacy-policy-section py-5">
    <div class="container">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            {!! $data['result']->description !!}
        </div>
    </div>
</section>
@push('script')
<script>
    jQuery(document).ready(function(){
        $('.privacy-policy-section a').each(function(){
            var urlsplit = this.href.split( '/' );
            if(urlsplit[2] == "classroomcopy.com"){
                if(urlsplit.length>=4 && urlsplit[3] !==''){
                    var t = ''; 
                    for (let i = 3; i < urlsplit.length; i++) {
                        if(urlsplit[i] !== ''){
                            t += '/'+urlsplit[i];
                        }
                    }
                    this.href = '{{url("/")}}' + t;
                }
                else{
                    this.href = '{{url("/")}}/';
                }
            }
        })
    });
</script>
@endpush
<!--Privacy Policy Section Ends Here-->
@endsection