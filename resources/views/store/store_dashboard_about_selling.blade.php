@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>FEES, PAYOUTS AND CURRENT OFFERS</h1>
                </div>
            </div>
            <?php if (Auth::check()) { ?>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{ route('store.dashboard') }}"><img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1"> Store Dashboard</a>
                </div>
            </div>
            <?php } ?>
        </div>                    
      
    </div>
</section>


<!-- page title end  -->
<!-- about selling html start  -->
@if((new \App\Http\Helper\Web)->checkofferstatus())
<div class="about-main">
    <div class="container">
        <a href="{{route('account.dashboard.join.now',['coupon' => 'apply'])}}">
            <img src="{{asset('images/about-banner.png')}}" alt="About Selling" class="img-fluid">
        </a>
    </div>
</div>
@endif
<!-- sellling information html start -->
<section class="selling-information pb-2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h6>Seller membership:</h6>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="selling-main d-sm-flex">
                    <div class="icon-box mb-3 mb-sm-0">
                        <img src="{{asset('images/a-icon-1.png')}}" alt="icon 1" class="img-fluid">
                    </div>
                    <div class="selling-box p-4 d-flex align-items-center">
                        <p>Classroom Copy believe that ALL teachers should benefit from their hard work and time. Therefore, we only have one membership for all sellers offering the best payout rates for everyone. </p>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="row my-5 justify-content-center">
            <div class="col-md-12 col-lg-7 justify-content-center">
                <div class="row">
                    <div class="col-md-3 col-6 mb-md-0 mb-3">
                        <div class="process-time">
                            <img src="{{asset('images/your-time-icon.png')}}"  class="img-fluid">
                            <p>Your Time</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-md-0 mb-3">
                        <div class="process-time">
                            <img src="{{asset('images/yours-resources-icon.png')}}"  class="img-fluid">
                            <p>Your Resources</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="process-time">
                            <img src="{{asset('images/your-money-icon.png')}}"  class="img-fluid">
                            <p>Your Money</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 ">
                        <div class="process-time">
                            <img src="{{asset('images/your-pocket-icon.png')}}"  class="img-fluid">
                            <p>Your Pocket</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- sellling information html end -->
<section class="plan-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h6>Seller Fees And Payout Rates:</h6>
            </div>
        </div>
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
                            <li>Free</li>
                            <li>55% On all sales
                            </li>
                            <li>30 Cents per resource
                            </li>
                            <li>Unlimited
                            </li>
                            <li>200 MB
                            </li>
                            <li>NO</li>
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
                            <li>$59.95 Per year
                            </li>
                            <li>80% On all sales
                            </li>
                            <li>15 Cents per resource
                            </li>
                            <li>Unlimited
                            </li>
                            <li>1GB
                            </li>
                            <li>Yes</li>
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
                            <li class="fw-bold">Free</li>
                            <li class="fw-bold">85% On all sales
                            </li>
                            <li class="fw-bold">15 Cents per Transaction
                            </li>
                            <li class="fw-bold">Unlimited
                            </li>
                            <li class="fw-bold">1GB
                            </li>
                            <li class="fw-bold">Yes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="selling-information">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h6>Setting Up Your Store:
                </h6>
            </div>
        </div>
        <div class="row mt-3 mb-5">
            <div class="col-md-12">
                <div class="selling-main d-sm-flex">
                    <div class="icon-box mb-3 mb-sm-0">
                        <img src="{{asset('images/a-icon-2.png')}}" alt="icon 1" class="img-fluid">
                    </div>
                    <div class="selling-box p-3 d-flex align-items-center">
                        <p>Your product range will exist at a unique store URL that's created when you sign up as a Seller. You’ll be able to personalise your store page by uploading a profile image or logo, telling your visitors about yourself and your experience, adding a store banner and so on. Start uploading resources and choose up to four resources to feature at the top of your store page. At any time, you can edit your listings, alter the titles and descriptions, change your prices, and swap in revised versions of your products.
                        </p>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6>How you will be paid:
                </h6>
            </div>
        </div>
        <div class="row mt-3 mb-5">
            <div class="col-md-12">
                <div class="selling-main d-sm-flex">
                    <div class="icon-box mb-3 mb-sm-0">
                        <img src="{{asset('images/a-icon-3.png')}}" alt="icon 1" class="img-fluid">
                    </div>
                    <div class="selling-box p-3 d-flex align-items-center">
                        <p>We work with third party payment processor STRIPE to issue your payments to you. You'll need to set up an account with STRIPE and be sure that your account is eligible and ready to receive payments. Finally, make sure that your address is correct on  your Classroom Copy account. </p>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6>When will you get paid:</h6>
            </div>
        </div>
        <div class="row mt-3 mb-5">
            <div class="col-md-12">
                <div class="selling-main d-sm-flex">
                    <div class="icon-box mb-3 mb-sm-0">
                        <img src="{{asset('images/a-icon-4.png')}}" alt="icon 1" class="img-fluid">
                    </div>
                    <div class="selling-box p-3 d-flex align-items-center">
                        <p>We pay out Seller earnings on a monthly basis. Earnings for each month are sent via STRIPE and are expected to arrive around or before the 21st of the month. Depending on the payout method you choose and your bank’s processing times, it may take 2-3 business days to see your payment. You can keep track of your sales and earnings in real time from your Seller Dashboard and your Sales Details Report. </p>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6>Tax: </h6>
            </div>
        </div>
        <div class="row mt-3 mb-5">
            <div class="col-md-12">
                <div class="selling-main d-sm-flex">
                    <div class="icon-box mb-3 mb-sm-0">
                        <img src="{{asset('images/a-icon-5.png')}}" alt="icon 1" class="img-fluid">
                    </div>
                    <div class="selling-box p-3 d-flex align-items-center">
                        <p>Classroom Copy does not apply taxation charges to any sales. Regardless of what you make as a seller on Classroom Copy, you should consult your tax advisor on how to report your sales relevant to the taxation legislation in your location.
                        </p>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</section>
@endsection
