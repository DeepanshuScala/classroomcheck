@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>my Classroom Contributions</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                     <a href="{{route('accountDashboard.contributions')}}"><img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Classroom Contributions</a>
                </div>
            </div>
        </div>                    
        <div class="row justify-content-end">
            <div class="col-md-5 text-end">
                <ul class="navbar list-edit mb-0 mt-4 ps-0" id="view-menu-list">
                    <li>
                        <a href="{{route('accountDashboard.classroomContributions')}}">Add a listing</a>
                    </li>
                    <li>
                        <a href="{{route('accountDashboard.contributionsEditView')}}">Edit Listings</a>
                    </li>
                    <li>
                        <a href="{{route('accountDashboard.contributionsView')}}">View Listings</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="inner_page_baner">
    <div class="inner_page_title">
        <img src="{{asset('images/inner-banner.jpg')}}" alt="inner banner" class="img-fluid">
    </div>
</section>

<!-- page title end  -->
<!-- Book Bin products section start -->
<section class="contribution-main new-contribution">
    <?php
    if ($data['result'] && count($data['result'])>0) {
        foreach ($data['result'] as $row) {
            $fundCompleted = round(($row->funded_amount * 100) / $row->target_amount);
            ?>
            <div class="container contribution-box">
                <div class="row mb-4 mb-md-4">
                    <div class="col-12">
                        <h4>{{ $row->fundraising_title }}
                            <a title="Update" href="{{URL('/account-dashboard/contributions-edit').'/'.$row->id}}"><i class="fa fa-pencil"></i></a>
                        </h4>
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
                            <p>{{ $row->first_name." ".$row->surname }}</p>

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
                            <p>{{ $row->fundraising_slogan }}</p>

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
                            <p>${{ number_format($row->target_amount,2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    else{
    ?>
    <p class="text-center" style="font-weight: 500;">No Contribution Created Yet</p>
    <?php
    }
    ?>
</section>
<!-- book bin products section end  -->
@endsection
@push('script')
<script>
    $(function(){
    var current = location.pathname;
    $('#view-menu-list li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.addClass('active-nav');
        }
    })
})
</script>
@endpush