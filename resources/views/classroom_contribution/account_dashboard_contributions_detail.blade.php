@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')

<!--<style>-->
<!--    .inner_page_baner img{max-height: 260px;}-->
<!--</style>-->
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
    <div class=" inner_page_title text-center store-view-img">
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
                <h4>{{ $data['result']->fundraising_title }}
                    <a class="fbShare cursor-pointer border-0 bg-transparent" href="http://www.facebook.com/sharer.php?u={{URL('contribution/'.$data['result']->id)}}" target="_blank">
                        <img src="{{asset('images/facebook.png')}}" class="img-fluid me-2" alt="facebook">
                    </a>
                    <a class="whatsAppShare cursor-pointer border-0 bg-transparent" href="http://twitter.com/share?text=giftcard&url={{URL('contribution/'.$data['result']->id)}}" target="_blank">
                      <img src="{{asset('images/twitter.png')}}" class="img-fluid me-2" alt="twitter">
                    </a>
                    <a class="gmailShare cursor-pointer border-0 bg-transparent" href="http://pinterest.com/pin/create/button/?url={{URL('contribution/'.$data['result']->id)}}" target="_blank">
                       <img src="{{asset('images/pinterest.png')}}" class="img-fluid me-2" alt="pinterest">
                    </a>
                    <a style="cursor: pointer;" title="Copy" class="shareBtn cursor-pointer ms-4"  data-id="{{ $data['result']->id }}">
                        <!-- <i class="fa fa-share-alt"></i> -->
                        <img src="{{asset('images/copy-icon.png')}}" class="copy-icon img-fluid " alt="copy">
                    </a>
                </h4>
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
                                    <h4>${{ number_format($data['result']->funded_amount,2) }}</h4>
                                    <span>Of ${{ number_format($data['result']->target_amount,2) }} Target</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <!--  <div class="row text-center my-4 mt-5">
            <div class="col-12">
                <button type="button" class="btn btn-primary bg-blue btn-lg px-5 py-3  btn-hover text-uppercase">support now</button>
            </div>
        </div> -->
    </div>

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
<script>
    $(document).ready(function () {
        //share button click
        $('.shareBtn').click(function () {
            var id = $(this).data('id');
            var post_url = "{{ URL('contribution') }}" + "/" + id;
            var inp = document.createElement('input');
            document.body.appendChild(inp);
            inp.value = post_url;
            inp.select();
            document.execCommand('copy', false);
            inp.remove();
            $('.shareBtn').tooltip({
                title: 'Link Copied',
                trigger: 'manual'
            }).tooltip('show');
            setTimeout(function () {
                $('.shareBtn').tooltip('hide');
            }, 1000);
        });
        /*
        //facebook share on button click
        $('.fbShare').click(function () {
            var id = $(this).data('id');
            var post_url = "{{ URL('contribution') }}" + "/" + id;
            var url = "https://www.facebook.com/sharer/sharer.php?u=" + post_url;
            window.open(url, "_blank");
        });
        //gmail share on button click
        $('.gmailShare').click(function () {
            var id = $(this).data('id');
            var post_url = "{{ URL('contribution') }}" + "/" + id;
            var url = "https://mail.google.com/mail/u/0/?fs=1&tf=cm&su=Post Share&body=" + encodeURI(post_url);
            window.open(url, "_blank");
        });
        //whatsapp share on button click
        $('.whatsAppShare').click(function () {
            var id = $(this).data('id');
            var post_url = "{{ URL('contribution') }}" + "/" + id;
            var url = "https://api.whatsapp.com/send?text=" + encodeURI(post_url);
            window.open(url, "_blank");
        });
        //linkedin share on button click
        $('.linkedinShare').click(function () {
            var id = $(this).data('id');
            var post_url = "{{ URL('contribution') }}" + "/" + id;
            var url = "https://www.linkedin.com/sharing/share-offsite/?url=" + encodeURI(post_url);
            window.open(url, "_blank");
        });
        */
    });
</script>
@endpush