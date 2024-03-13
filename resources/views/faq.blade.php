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
            <h1>FREQUENTLY ASKED QUESTIONS</h1>
            <?php if (count($data['result']) > 0) { ?>
                <div class="accordion1" id="accordionExample">
                    <?php
                    foreach ($data['result'] as $key => $row) {
                        $headingId = "heading_" . $key;
                        $collapseId = "collapse_" . $key;
                        ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="{{ $headingId }}">
                                {{ $row->question }}
                                
                            </h2>
                                <div class="accordion-body p-0 bg-transparent">
                                    {!! $row->answer !!}
                                </div>
                                <?php
                                if($row->has_table == 1){
                                    $tabledt = DB::table('featuretable')->where('id',$row->tableid)->first();
                                ?>
                                    <div class="row mt-4">
                                        <div class="col-md-6 col-lg-3 mb-4">
                                            <div class="plan-box">
                                                <div class="color-plan blue-bg">
                                                </div>
                                                <div class="color-body-first">
                                                    <ul>
                                                        <li>Membership Fee</li>
                                                        <li>Payout Rate</li>
                                                        <li>Transaction Fees
                                                        </li>
                                                        <li>Max Uploads
                                                        </li>
                                                        <li>File Size Upload
                                                        </li>
                                                        <li>Video Uploads
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-4">
                                            <div class="plan-box">
                                                <div class="color-plan red-bg">
                                                    <h5>OTHER SITE<br>
                                                        BASIC SELLER</h5>
                                                </div>
                                                <div class="color-body">
                                                    <ul>
                                                        <li>{{$tabledt->basic_membership}}</li>
                                                        <li>{{$tabledt->basic_payout}}</li>
                                                        <li>{{$tabledt->basic_transaction}}</li>
                                                        <li>{{$tabledt->basic_max}}</li>
                                                        <li>{{$tabledt->basic_file}}</li>
                                                        <li>{{$tabledt->basic_video}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-4">
                                            <div class="plan-box">
                                                <div class="color-plan yellow-bg">
                                                    <h5>OTHER SITE<br>
                                                        PREMIUM SELLER</h5>
                                                </div>
                                                <div class="color-body">
                                                    <ul>
                                                        <li>{{$tabledt->premium_membership}}</li>
                                                        <li>{{$tabledt->premium_payout}}</li>
                                                        <li>{{$tabledt->premium_transaction}}</li>
                                                        <li>{{$tabledt->premium_max}}</li>
                                                        <li>{{$tabledt->premium_file}}</li>
                                                        <li>{{$tabledt->premium_video}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-4">
                                            <div class="plan-box">
                                                <div class="color-plan green-bg">
                                                    <h5>CLASSROOM COPY<br>
                                                        BASIC SELLER</h5>
                                                </div>
                                                <div class="color-body">
                                                    <ul>
                                                        <li>{{$tabledt->all_seller_membership}}</li>
                                                        <li>{{$tabledt->allseller_payout}}</li>
                                                        <li>{{$tabledt->allseller_transaction}}</li>
                                                        <li>{{$tabledt->allseller_max}}</li>
                                                        <li>{{$tabledt->allseller_file}}</li>
                                                        <li>{{$tabledt->allseller_video}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="text-center"><i class="fa fa-question-circle fa-4x"></i></p>
                    <h4 class="text-center text-muted">No FAQ Added Yet</h4>
                <?php } ?>
            </div>
        </div>
</section>
<!--Privacy Policy Section Ends Here-->
@endsection

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