@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Store Dashboard Section Starts Here-->
<section class="help-faq-section store-dashboard-section  py-5">
    <div class="container">
        <h1 class="text-uppercase pt-2 pb-4">Store Dashboard </h1>
        @php
            $getofferbanner = DB::Table('seller_offer')->first();
        @endphp
        @if(!empty($getofferbanner) && !empty($getofferbanner->banner))
        <div class="row  become-banner1 mb-5 text-center">
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
                <a href="{{route('storeDashboard.aboutSelling')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_1 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/store-dash-1.png')}}" class="img-fluid " alt="store-dash-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">About Selling</h4>
                            <p class="px-lg-5 px-2 mb-0 ">Fees, Payout Rates and Current Offers</p>

                        </div>

                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('become.a.seller')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/store-dash-2.png')}}" class="img-fluid " alt="store-dash-2 ">
                            </div>
                            <h4 class="pt-3 mb-2">Become a Seller
                            </h4>
                            <p class="px-2 px-lg-5 mb-0 ">Step by step guide
                            </p>

                        </div>

                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('storeDashboard.storeSetup')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/store-dash-3.png')}}" class="img-fluid " alt="store-dash-3 ">
                            </div>
                            <h4 class="pt-3 mb-2">My Store Profile
                            </h4>
                            <p class="px-2 px-lg-5 mb-0 ">Edit, update your store details

                            </p>

                        </div>

                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <?php
                if (auth()->check() && auth()->user()->process_completion == 3)
                    $prodUrl = route('storeDashboard.productDashboard');
                else
                    $prodUrl = route('become.a.seller');
                ?>
                <a href="{{ $prodUrl }}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_4 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/store-dash-4.png')}}" class="img-fluid " alt="store-dash-4 ">
                            </div>
                            <h4 class="pt-3 mb-2">My Products

                            </h4>
                            <p class="px-2 px-lg-5 mb-0 ">Add, remove or edit your products
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{route('storeDashboard.reports')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_5 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/store-dash-5.png')}}" class="img-fluid " alt="store-dash-5 ">
                            </div>
                            <h4 class="pt-3 mb-2">Reports
                            </h4>
                            <p class="px-2 px-lg-5 mb-0 ">Sales, Tax, Country and Products</p>

                        </div>

                    </div>
                </a>
            </div>
            <?php
            if ($data['is_store_added'] == 0) {
                $storeUrl = route('storeDashboard.storeSetup');
            } else {
                $storeUrl = route('store.products');
            }
            ?>
            <div class = "col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href = "{{$storeUrl}}">
                    <div class = "card card-box border-0 text-center h-100 py-4 ">
                        <div class = "card-body das-card">
                            <div class = "icon-box icon_bg_6 rounded-circle text-center mx-auto py-5 ">
                                <img src = "{{asset('images/store-dash-6.png')}}" class = "img-fluid " alt = "store-dash-6">
                            </div>
                            <h4 class="pt-3 mb-2">View My Store
                            </h4>
                            <p class="px-2 px-lg-5 mb-0 ">See what your store looks like to others
                            </p>

                        </div>

                    </div>
                </a>
            </div>
            <div class = "col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href="{{ URL('/seller/payment-system') }}">
                    <div class = "card card-box border-0 text-center h-100 py-4 ">
                        <div class = "card-body das-card">
                            <div class = "icon-box icon_bg_7 rounded-circle text-center mx-auto py-5 ">
                                <img src = "{{asset('images/help-icon-7.png')}}" class = "img-fluid " alt = "help-icon-7">
                            </div>
                            <h4 class="pt-3 mb-2">Payment System

                            </h4>
                            <p class="px-2 px-lg-5 mb-0 ">Third party payment agent - STRIPE
                            </p>

                        </div>

                    </div>
                </a>
            </div>

            <div class = "col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href = "{{route('storeDashboard.marketingDashboard')}}">
                    <div class = "card card-box border-0 text-center h-100 py-4 ">
                        <div class = "card-body das-card">
                            <div class = "icon-box icon_bg_8 rounded-circle text-center mx-auto py-5 ">
                                <img src = "{{asset('images/store-dash-8.png')}}" class = "img-fluid " alt = "store-dash-8 ">
                            </div>
                            <h4 class="pt-3 mb-2">Marketing

                            </h4>
                            <p class="px-2 px-lg-5 mb-0 ">Options for promoting your products
                            </p>

                        </div>

                    </div>
                </a>
            </div>

            <div class = "col-12 col-sm-12 col-md-6 col-lg-4 mb-4 ">
                <a href = "{{route('storeDashboard.myInbox')}}">
                    <div class = "card card-box border-0 text-center h-100 py-4 ">
                        <div class = "card-body das-card">
                            <div class = "icon-box icon_bg_9 rounded-circle text-center mx-auto py-5 ">
                                <img src = "{{asset('images/store-dash-9.png')}}" class = "img-fluid " alt = "store-dash-9 ">
                            </div>
                            <h4 class="pt-3 mb-2">My Inbox
                            </h4>
                            <p class="px-2 px-lg-5 mb-0 ">View and compose messages
                            </p>

                        </div>

                    </div>
                </a>
            </div>


        </div>


    </div>



</section>

<!--Store Dashboard Section Ends Here-->
@endsection