<?php
$startDate = date('Y-m-d');
$getpromo = DB::Table('crc_promo_deatails')->whereDate('start_at','<=',$startDate)
        ->whereDate('end_at','>=',$startDate)->where('status',1)->orderby('id','DESC')->first();
$getofferbanner = DB::Table('seller_offer')->first();
$check = 0;
?>
<section class="slider-section">

    <div class="container pb-5">
        <div class="row">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if(!empty($getofferbanner) && !empty($getofferbanner->banner))
                        @php
                            $check = 1;
                        @endphp
                    <div class="carousel-item active">
                        <a href="{{ route('storeDashboard.aboutSelling') }}">
                            <img src="{{url('storage/uploads/selleroffer/'.$getofferbanner->banner)}}" class="d-none1 d-md-block w-100 img-fluid" alt="slide-1">
                        </a>
                        
                        <!-- <div class="carousel-caption d-block d-md-block">
                            <h1 class="blue">BECOME A SELLER</h1>
                            @if((new \App\Http\Helper\Web)->checkofferstatus())
                                <p class="lead">Become a seller to receive 100% on all sales.</p>
                            @endif
                            <h6 class="blue text-uppercase condition-apply">Conditions apply</h6>
                            <a class="" href="{{ route('storeDashboard.aboutSelling') }}" >
                                <button type="button" class="find-out-more btn btn-primary bg-blue btn-lg px-4 my-3 me-md-2 text-uppercase btn-hover">Find
                                    Out More</button>
                            </a>
                        </div> -->
                    </div>
                    @endif
                    @if(!empty($getpromo))
                    <div class="carousel-item @php if(!$check){ echo 'active';} @endphp" data-interval="false">
                        <div class="promotion position-relative">
                            <img src="{{asset('images/education-day-arrangement-table-with-copy-space.png')}}" alt="promotion" class="img-fluid">
                            
                            <div class="promote-content">
                                <!-- <span>LIMITED OFFER</span> -->
                                <!-- <h1>{{$getpromo->title}}</h1> -->
                                <div class="coupon-offer">
                                    <!-- <strong>USE CODE:</strong> {{$getpromo->promo_code}} -->
                                    {{$getpromo->promo_code}}
                                </div>
                                
                                <!-- <p>Online Purchase</p>
                                <a href="#" class="find-out-more btn btn-primary bg-blue btn-lg px-4 my-3 me-md-2 text-uppercase btn-hover shopnow">Shop Now</a> -->
                            </div>
                            <div class="offers-num">
                                @if($getpromo->discount_in == 2)
                                    <!-- <span>{{$getpromo->amount}} </span> -->
                                    <span>{{$getpromo->amount}} <sup>%</sup></span> <div>OFF</div>
                                @else
                                    <!-- <span>{{$getpromo->amount}} </span> -->
                                    <span>{{$getpromo->amount}} <sup>Flat</sup></span> <div>OFF</div>
                                @endif
                            </div>
                            <p class="limited-time">{{$getpromo->description}}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <i class="fal fa-angle-left fa-2x"></i>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <i class="fal fa-angle-right fa-2x"></i>
                </button>
            </div>
        </div>
    </div>

</section>