@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Account Dashboard Section Starts Here-->
<section class="help-faq-section acc-dashboard-section py-5">
    <div class="container">
        <h1 class="text-uppercase pt-2 pb-4">Account Dashboard </h1>
        @php
            $getofferbanner = DB::Table('seller_offer')->first();
        @endphp
        @if(!empty($getofferbanner) && !empty($getofferbanner->banner))
        <div class="row  become-banner1 mb-5 text-center ">
            <a href="{{ route('storeDashboard.aboutSelling') }}">
                <img src="{{url('storage/uploads/selleroffer/'.$getofferbanner->banner)}}" class="d-none1 d-md-block w-100 img-fluid" alt="slide-1">
            </a>
            <!-- <div class="become-bnr-txt">
                <h1 class="blue">BECOME A SELLER</h1>
                <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4">Start selling today to receive 100% on all sales.</p>
                    <h6 class="blue text-uppercase condition-apply">Conditions apply</h6>
                    <div class="gap-2 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('storeDashboard.aboutSelling') }}">
                            <button type="button" class="find-out-more btn bg-blue  btn-lg px-4 me-sm-3 my-3 me-md-2 text-uppercase btn-hover">Find Out More</button>
                        </a>
                    </div>
                </div>
            </div> -->
        </div>
        @endif
        <div class="row gx-3 gx-sm-4">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('accountDashboard.myProfile')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_1 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/acc-dashboard-1.png')}}" class="img-fluid " alt="acc-dashboard-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">My Account Details
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">View, edit or update your account details</p>

                        </div>

                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('accountDashboard.myPurchaseHistory')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/acc-dashboard-2.png')}}" class="img-fluid " alt="acc-dashboard-2 ">
                            </div>
                            <h4 class="pt-3 mb-2">My Purchase History
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">Download products and view history</p>

                        </div>

                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('accountDashboard.myInbox')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/acc-dashboard-3.png')}}" class="img-fluid " alt="acc-dashboard-3 ">
                            </div>
                            <h4 class="pt-3 mb-2">My Inbox
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">View and compose messages
                            </p>

                        </div>

                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('accountDashboard.myWishlist')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_4 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/acc-dashboard-4.png')}}" class="img-fluid " alt="acc-dashboard-4 ">
                            </div>
                            <h4 class="pt-3 mb-2">My Wishlist
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">View saved products</p>

                        </div>

                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('accountDashboard.preferredSeller')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_5 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/acc-dashboard-5.png')}}" class="img-fluid " alt="acc-dashboard-5 ">
                            </div>
                            <h4 class="pt-3 mb-2">My Preferred Sellers
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">Your favourite sellers</p>

                        </div>

                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('accountDashboard.contributions')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_6 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/help-icon-8.png')}}" class="img-fluid " alt="help-icon-8">
                            </div>
                            <h4 class="pt-3 mb-2">Classroom Contributions
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">Set up and run your fundraising campaign</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{ URL('/buyer/payment-system') }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_7 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/help-icon-7.png')}}" class="img-fluid " alt="help-icon-7">
                            </div>
                            <h4 class="pt-3 mb-2">Payment Systems
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">Third party payment agent
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('accountDashboard.suggestAresource')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/acc-dashboard-8.png')}}" class="img-fluid " alt="acc-dashboard-8 ">
                            </div>
                            <h4 class="pt-3 mb-2">Suggest a Resource
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">What resources would you like to see? </p>

                        </div>

                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 "> 
                <a href="{{route('become.a.seller')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/acc-dashboard-9.png')}}" class="img-fluid " alt="acc-dashboard-9 ">
                            </div>
                            <h4 class="pt-3 mb-2">Become a Seller
                            </h4>
                            <p class="px-md-5 px-2 mb-0 ">Step by step guide</p>

                        </div>

                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 "> 
                <a href="{{route('gift.in.account')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/giftcardsmall.png')}}" class="img-fluid " alt="acc-dashboard-9 ">
                            </div>
                            <h4 class="pt-3 mb-2">Gift Cards
                            </h4>
                        </div>

                    </div>
                </a>
            </div>













































        </div>


    </div>



</section>

<!--Account Dashboard Section Ends Here-->
@endsection

