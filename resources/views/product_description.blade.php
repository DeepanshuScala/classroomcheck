<?php
use \App\Http\Helper\Web;
use Illuminate\Support\Facades\{
    Auth,
    Crypt
};
?>
@extends('layouts.master')
@section('title', $title = $product->product_title ?? 'Classroom Copy')
@section('description', $description = $product->description?? 'Classroom Copy')
<?php
$ogimage = Storage::disk('s3')->url('products/'.$product->main_image);
?>
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
<style type="text/css">
    .green-text{
        color: #01C301 !important;
    }
    .fa-star:hover {
        color: #EFA413 !important;
    }
    .date-pro p{
        color: #306EBA !important;
    }
    .top-right-image {
        position: absolute;
        width: 12%;
        top: 0;
        right: 0;
        object-fit: contain;
    }
</style>
<!--Main Product Section Starts Here-->
<section class="hero-section product-page-section py-5">
    <div class="container py-5">
        <div class="row flex-lg-row-reverse align-items-top g-4">
            <div class="col-12 d-flex justify-content-end mt-0">
               <a href="{{url()->previous()}}" class="blue acc-dashboard align-left ">
                    <img src="{{asset('/images/icon-1.png')}}" class="img-fluid me-2 my-1 " alt=" ">Back
                </a>
            </div>

            <div class="col-12 col-sm-12 col-lg-5 pt-2 text-uppercase">
                
                <h1>{{$product->product_title}}</h1>
                
                <div class="d-flex flex-row align-items-center">
                    <ul class="product-rating d-flex flex-row justify-content-start py-1 ps-0 pe-3 mb-0">
                        <?php
                        for ($x = 1; $x <= $productRating; $x++) {
                            echo "<li><i class='fas fa-star text-yellow'></i></li>";
                        }
                        if (strpos($productRating, '.')) {
                            echo "<li><i class='fas fa-star-half-alt text-yellow'></i></li>";
                            $x++;
                        }
                        while ($x <= 5) {
                            echo "<li><i class='fal fa-star text-muted'></i></li>";
                            $x++;
                        }
                        ?>
                    </ul>
                    <ul class="navbar-nav rating-dropdown">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted scrolltoreview" href="#tab-2" id="navbarDarkDropdownMenuLink"     aria-expanded="false">
                                {{ $productRatingcount }} rating
                            </a>
                           
                        </li>
                    </ul>
                </div>
                
                <div class="d-lg-none d-block">
                <?php                        
                        //check if sale is going for product
                        $responsearray = Web::getsingleprice($product->id,$product->user_id,$product->single_license,0);
                       //$price = $responsearray['price'];
                        $is_sale = $responsearray['is_sale'];

                        $rarr =  Web::getsingleprice($product->id,$product->user_id,(!empty($product->multiple_license))?$product->multiple_license:$product->single_license,0);
                    
                    ?>
                     
                <div class="row outer my-5">
                    <div class="col-12 col-md-12 position-relative">
                    <?php if(isset($is_sale) && $is_sale == 1){ echo '<span class="sale-product position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>';}?>
                       <div id="thumbs-main-mob" class="owl-carousel thumbs">
                            <?php $key=1;?>
                            @if($product->main_image)
                                <div class="thumbs-img" >
                                    <div class="image-box">
                                       <a href="#" data-full="{{Storage::disk('s3')->url('products/'.$product->main_image)}}" class="full"><img src="{{Storage::disk('s3')->url('products/'.$product->main_image)}}" class="img-fluid  rounded " alt="Thumb-{{$key}}"></a>
                                   </div>
                                </div>
                            @endif
                            @if($productImages->isNotEmpty())
                                @foreach($productImages as $key =>  $productImage)
                                    <div class="thumbs-img" >
                                        <div class="image-box">
                                           <a href="#" data-full="{{Storage::disk('s3')->url('products/'.$productImage->image)}}" class="full"><img src="{{Storage::disk('s3')->url('products/'.$productImage->image)}}" class="img-fluid  rounded " alt="Thumb-{{$key}}"></a>
                                       </div>
                                    </div>
                                    <?php $key++;?>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
                </div>
                <?php 
                    if ($product->is_paid_or_free == 'free') { 
                ?>
                    <div class="price"><span class="badge bg-success text-white">Free</span></div>
                <?php } else {
                        //check if sale is going for product
                        $responsearray = Web::getsingleprice($product->id,$product->user_id,$product->single_license,0);
                        $price = $responsearray['price'];
                        $is_sale = $responsearray['is_sale'];
                        echo $product->type;
                        $rarr =  Web::getsingleprice($product->id,$product->user_id,(!empty($product->multiple_license))?$product->multiple_license:$product->single_license,0);
                        if($product->type == 'single' || empty($product->type)){
                    ?>
                     <div class="price">${{$price}} <?php if(isset($is_sale) && $is_sale == 1){ echo '<span class="price-line-through p-0">$'.$product->single_license.'</span>';}?> <span class="text-muted dollar">AUD</span></div>
                <?php 
                        }
                    }
                ?>
                <div class="product-description">
                    <div class="product-title fw-bold pb-3 pt-2">Grades Levels:
                        <!--<p class="fw-bold mb-0">3<sup>rd</sup>- 5<sup>th</sup></p>-->
                        <p class="fw-bold text-muted mb-0">{{$product->gradeLevelStr}}</p>
                    </div>
                    <div class="product-title fw-bold pb-2">Subjects:
                        <p class="fw-bold text-muted mb-1">{{$product->subjectAreaStr}}</p>
                    </div>
                    <div class="product-title fw-bold pb-2">Resource Type:
                        <p class="fw-bold text-muted mb-1">{{ $product->resourceTypeStr }}</p>
                    </div>
                    @if( isset($product->product_type) && !empty($product->product_type))
                    <div class="product-title fw-bold pb-2">Formats Include:
                        <p class="fw-bold text-muted mb-1"><i class='fal fa-check'></i> {{$product->product_type?strtoupper($product->product_type):''}}</p>
                    </div>
                    @endif
                    <div class="product-title fw-bold  pb-2">Pages:
                        <!--<p class="fw-bold text-muted mb-2">(310 PDF & PPT) + 19 </p>-->
                        <p class="fw-bold text-muted mb-2">{{$product->no_of_pages_slides}} </p>
                    </div>
                    @if(!empty($product->type) && $product->type == 'bundle')
                        @php
                            $bundleprods = json_decode($product->bundleproducts);
                            $fullprice = 0.0;
                            foreach($bundleprods as $bundpro){
                                $getproductinfo = DB::Table('crc_products')->where('id',$bundpro)->first();
                                $fullprice += $getproductinfo->single_license;
                            }
                        @endphp
                        <div class="bundleprice">
                            <span>${{$price}}</span>
                            <p>List Price: ${{$fullprice}}</p>
                            <p>Offer Price: ${{$price}}</p>
                            <span>Bundle</span>
                        </div>
                    @endif
                </div>
                <?php
                /*
                 if ($product->is_paid_or_free == 'free') { 
                    <div class="pb-2 ">
                        <a href="{{ $product->product_file }}" class="{{($product->auth_user === false ? 'memberLogin' :'downloadfreeproduct')}} text-decoration-none blue text-capitalize btn bg-blue text-white bg-blue btn-hover px-4" data-prod-id="{{$_id}}" download>
                             Download 
                        </a>
                    </div>
                <?php } else { 
                    */
                ?>
                    <div class="add-to-cart mb-3 ">
                        <a href="javascript:void(0)" class="btn bg-blue text-white bg-blue btn-hover blue text-capitalize {{($product->auth_user === false ? ' memberLogin ' : '')}} {{auth()->user()?($is_cart === true?'':'main-add-cart'):''}} {{$is_cart === true?' disabled ':''}}" data-prod_id="{{$_id}}">
                            <i class='fal fa-shopping-cart me-2'></i>{{$is_cart === true?'Added To Cart':'Add To Cart'}} 
                        </a>
                    </div>
                <?php // } ?>
                @if($product->is_paid_or_free == 'paid')
                    <button type="button" class="btn btn-light border btn-size me-3 mb-3 {{($product->auth_user === false ? 'memberLogin' : 'buy-license-share')}}">Buy License To Share </button>
                @endif
                <button type="button" class="btn-size btn btn-light border mb-3 {{auth()->user()?' add-favourite ':''}} {{($product->auth_user === false ? ' memberLogin ' : '')}}  {{$is_favourite === true?' disabled ':''}}" data-prod_id="{{$_id}}">@if($is_favourite === true)<i class="fa fa-check text-success" aria-hidden="true"></i> Added To Wishlist @else + Add To Wishlist  @endif  </button>
                <div class="text-muted py-2 text-capitalize text-size">Share This Resource
                    <ul class="social-icons d-flex flex-lg-row ps-0 mt-2">
                        <li>
                            <a href="http://www.facebook.com/sharer.php?u={{urlencode(Request::url())}}" target="_blank"><img src="{{asset('images/emailer-facebook.png')}}" class="img-fluid me-2" alt="facebook"></a>
                        </li>
                        <li>
                            <a href="http://pinterest.com/pin/create/button/?description={{$product->product_title}}&url={{Request::url()}}" target="_blank"><img src="{{asset('images/emailer-pinterest.png')}}" class="img-fluid me-2" alt="pinterest"></a>
                        </li>
                        
                        <li>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{urlencode(Request::url())}}" target="_blank"><img src="{{asset('images/emailer-linkedin.png')}}" class="img-fluid me-2" alt="pinterest"></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-7 col-sm-12 py-2 text-center ">
                <div class="d-lg-block d-none">
                <div class="row outer">
                    <div class="col-12 col-md-12 position-relative" >
                    @if(!empty($product->type) && $product->type == 'bundle')
                        <img src="{{url('/images/bundle.png')}}" class="top-right-image">
                    @endif
                    <?php if(isset($is_sale) && $is_sale == 1){ echo '<span class="sale-product position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>';}?>
                       <div id="thumbs-main" class="owl-carousel thumbs">
                            <?php $key=1;?>
                            @if($product->main_image)
                                <div class="thumbs-img ">
                                    <div class="image-box ">
                                       <a href="{{Storage::disk('s3')->url('products/'.$product->main_image)}}" data-full="{{Storage::disk('s3')->url('products/'.$product->main_image)}}" class="full"><img src="{{Storage::disk('s3')->url('products/'.$product->main_image)}}" class="img-fluid  rounded zoom" alt="Thumb-{{$key}}"></a>
                                   </div>
                                </div>
                            @endif
                            @if($productImages->isNotEmpty())
                                @foreach($productImages as  $productImage)
                                    <div class="thumbs-img" >
                                        <div class="image-box">
                                           <a href="{{Storage::disk('s3')->url('products/'.$productImage->image)}}" data-full="{{Storage::disk('s3')->url('products/'.$productImage->image)}}" class="full"><img src="{{Storage::disk('s3')->url('products/'.$productImage->image)}}" class="img-fluid zoom rounded " alt="Thumb-{{$key}}"></a>
                                       </div>
                                    </div>
                                    <?php $key++;?>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                </div>
                </div>
                
               <!-- <div class="row">
                  <div class="col-md-2 col-3">
                    <div class="product-thumb-box d-flex float-start flex-column align-items-start ">
                      <div id="slider">
                          <ul class="thumbs position-relative">
                              <div class="up-arrow">  
                                  <div class="position-absolute  up-arrow"><a href="#"><img src="{{asset('images/arrow-up.png')}}" alt="arrow-up"></a></div>
                              </div>
                              @if($productImages->isNotEmpty())
                              @foreach($productImages as $key => $productImage)
                              <li class="preview mb-3">
                                  <a href="#" data-full="{{url('storage/uploads/products/'.$productImage->image)}}">
                                      <img src="{{url('storage/uploads/products/'.$productImage->image)}}" class="img-fluid rounded " alt="Thumb-{{$key+1}}">
                                  </a>
                              </li>
                              @endforeach
                              @endif
                              
                              <div class="down-arrow">  
                                  <div class="position-absolute  up-down"><img src="{{asset('images/arrow-down.png')}}" alt="arrow-down"></a></div>
                              </div>
                          </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-10 col-9">
                    <div class="image-box  d-flex float-start flex-row">
                      <a href="{{asset('images/Product-img.jpg')}}" target="_blank" class="full">
                          <img src="{{url('storage/uploads/products/'.$product->main_image)}}" class="img-fluid"> </a>
                    </div>
                  </div>
                </div> -->
            </div>
        </div>
    </div>
</section>
<!--Main Product Section Ends Here-->

<!--Tab Section Starts Here-->
<section class="tab-section-seller">
    <div class="container  border-top">
        <div class="d-flex flex-row py-5">
            @if(!empty($product->type) && $product->type == 'bundle')
            <div class="bundleprod" style="position:relative;">
                <p>Products in this Bundle({{count(json_decode($product->bundleproducts))}})</p>
                @foreach($bundleprods as $bundpro)
                    @php
                        $getproductinfo = DB::Table('crc_products')->where('id',$bundpro)->first();
                    @endphp
                    <img src="{{Storage::disk('s3')->url('products/'.$getproductinfo->main_image)}}" class="img-responsive img-thumbnail" width="140px" height="140px"/>
                    <span class="fw-bold">{{$getproductinfo->product_title}}</span>
                    <a href="{{url('/product-description/'.\Crypt::encrypt($getproductinfo->id))}}" class="btn bg-blue text-white bg-blue btn-hover" target="_blank">Preview</a>
                    <p>{{$getproductinfo->description}}</p>
                @endforeach
            </div>
            @endif
            <!-- <img width="56px" height="56px" src="{{$productSeller->default_image == 0 ? url('storage/uploads/profile_picture/'.$productSeller->image) : asset('images/book-img.png')}}" class="rounded-circle" alt="lusion"> -->
            <div class="sellerinfo" style="position:relative;>
                <div class="text-center">
                    <a href="{{url('/seller-profile/'.str_replace(' ','-',$productSeller->store_name))}}">
                        <img width="140px" height="140px" src="{{$productSeller->store_image}}" class="rounded-circle mb-4" alt="lusion">
                    </a>
                </div>
                <div class="d-flex flex-column align-items-left ps-4 ">
                    <h5>{{$productSeller->store_name }}</h5>
                    <p id="followerCount" class="mb-1">{{ $followerCount }} Followers</p>
                    <a href="{{url('/seller-profile/'.str_replace(' ','-',$productSeller->store_name))}}">
                        <p style="color :#306eba;font-weight:600;">See all {{@$productSeller->total_product_count}} resources</p>  
                    </a>
                    <div class="d-flex">
                        <button type="button" class=" me-3 btn bg-blue text-white bg-blue btn-hover" data-followed-to="{{ $product->user_id }}" id="followUnfollow">
                            {{ ($followed == true) ? 'Unfollow' : 'Follow' }}
                        </button>
                        <button type="button" class="btn bg-blue text-white bg-blue btn-hover" data-seller-id="{{ $product->user_id }}" id="rateReview">
                            Rating & Review
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Description</li>
            <li class="tab-link" data-tab="tab-2">Reviews ({{ count($reviews) }})</li>
            <li class="tab-link" data-tab="tab-3">Q&A (<span id="qa-counter">{{$total_ques}}</span>)</li>
            <li class="tab-link" data-tab="tab-4">More From This Seller</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <p>{{ $product->description }}</p>
        </div>
        <div id="tab-2" class="tab-content">
            <?php
            if (count($reviews) > 0) {
                foreach ($reviews as $review) {
                    ?>
                    <!-- <p>{{ $review['review'] }} - {{ $review['first_name']." ".$review['surname'] }}</p> -->
                    <div class="rating-list mb-5">
                       <div class="profile-title d-md-flex justify-content-between">
                          <div class="date-pro">
                             <p><i class="fal fa-calendar me-2"></i> {{date('F d, Y',strtotime($review->created_at))}}</p>
                          </div>
                       </div>
                       <div class="d-flex profile-img align-items-center">
                          <div class="profile-img me-3">
                            <?php
                            $imglink = 'images/profile.png';
                            $role = ($review->role_id == 1) ? 'Buyer' : 'Seller';
                            if(!empty($review->image)){
                                $imglink = Storage::disk('s3')->url('profile_picture/'.$review->image);
                            }
                            ?>
                             <img src="{{$imglink}}" alt="profile" class="img-fluid">
                          </div>
                          <div class="text-pro">
                             <h6>{{ $review['first_name']." ".substr($review['surname'],0,1).'.' }} ({{$role}})</h6>
                             <div class="rating-icon d-flex align-items-center">
                                <ul class="rating d-flex flex-row justify-content-start ps-0 me-2 mb-0">
                                    <?php
                                        for ($x = 1; $x <= $review->rating; $x++) {
                                            echo "<li><i class='fas fa-star text-yellow'></i></li>";
                                        }
                                        if (strpos($review->rating, '.')) {
                                            echo "<li><i class='fas fa-star-half-alt text-yellow'></i></li>";
                                            $x++;
                                        }
                                        while ($x <= 5) {
                                            echo "<li><i class='fal fa-star text-muted'></i></li>";
                                            $x++;
                                        }
                                    ?>
                                </ul>
                                <p>{{$review->rating}} Rating</p>
                             </div>
                          </div>
                       </div>
                       <div class="content-p mt-3">
                        @if ($review->rating === 1)
                          <p class="green-text">Poor</p>
                        @elseif($review->rating === 2)
                            <p class="green-text">Average</p>
                        @elseif($review->rating === 3)
                            <p class="green-text">Good</p>
                        @elseif($review->rating === 4)
                            <p class="green-text">Satisfied</p>
                        @elseif($review->rating === 5)
                            <p class="green-text">Very Satisfied</p>
                        @endif
                          <div class="description">
                              <p class="add-read-more show-less-content">{{$review->review}}</p>
                          </div>
                          <!--div class="d-md-flex replay-box align-items-center justify-content-between">
                             <div class="grade">
                                 <p class="m-0"><span class="me-2">Student Used With</span> <b>4th Grade</b></p>
                             </div>
                             <div class="replay my-2 my-md-0">
                                 <a href="#">View Reply</a>
                             </div>
                             </div-->
                       </div>
                       @if($review->replay === true)
                           <?php
                           $replay_detail = (new \App\Http\Helper\Web)->getReplayDetail(@$review->id);
                           $store_name = (new \App\Http\Helper\Web)->storeDetail(@$replay_detail->user_id,'store_name');
                           $store_logo = (new \App\Http\Helper\Web)->storeDetail(@$replay_detail->user_id,'store_logo');
                           ?>
                            <div class="rating-list ">
                                <div class="profile-title d-md-flex justify-content-between">
                                    <div class="date-pro">
                                        <p><i class="fal fa-calendar me-2"></i> {{date('F d, Y',strtotime($replay_detail->created_at))}}</p>
                                    </div>
                                </div>
                                <div class="d-flex profile-img align-items-center">
                                    <div class="profile-img me-3">
                                         <img src="{{@$store_logo}}" alt="profile" class="img-fluid">
                                    </div>
                                    <div class="text-pro">
                                        <h6>{{ @$store_name }} (Classroom Copy Seller)</h6>
                                        <!-- <p>{{date('F d, Y',strtotime($replay_detail->created_at))}}</p> -->
                                    </div>
                                </div>
                                <div class="content-p mt-3">
                                    <div class="description">
                                        <p>{{@$replay_detail->reply}}</p>
                                    </div>
                                </div>
                            </div>
                       @endif
                    </div>
                    <?php
                }
            } else {
                ?>
                <p>No Reviews Yet</p>
            <?php } ?>
        </div>
        <div id="tab-3" class="tab-content">
           @if(Auth::check())
            <div class="d-flex post-question-btn">
                 <button onclick="showQuestionBox(this)" type="button" class="btn-size btn btn-light border mb-3 float-start">Ask a Question</button>
            </div>
            @endif
            <div class="row g-3 border col-12 question-box p-3 bg-light d-none mb-4" >
                <form name="fff">
                    <div class="mb-3">
                        <textarea class="form-control" id="question-text" rows="3"></textarea>
                    </div>
                    <div class="col-auto d-flex justify-content-between">
                        <div class="form-check">
                          <input class="form-check-input" type="hidden" value="1" name="notify" id="notify" >
                        </div>
                        <div class="col-auto d-flex justify-content-end">
                            <button onclick="hideQuestionBox(this)" type="button" class="btn btn-light cancel border border-dark border-1">Cancel</button>
                            <button type="button" data-productid="{{$_id}}" data-selletid="{{$productSeller->id}}"  class="btn btn-primary ms-3 post-question">Post Question</button>
                        </div>
                    </div>
                </form>
            </div>
            @foreach($questions as $question)
            <?php
            $user_image = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'image');
            $first_name = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'first_name');
            $surname = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'surname'); 
            ?>
            <div class="rating-list mb-5">
                <div class="d-flex profile-img align-items-center">
                    <div class="profile-img me-3">
                        <img src="{{$user_image}}" alt="profile" class="img-fluid">
                    </div>
                    <div class="text-pro">
                        <h6><b>Question</b> | {{date('F d, Y',strtotime($question->created_at))}} from {{$first_name}} {{$surname}}</h6>
                    </div>
                </div>
                <div class="content-p mt-3">
                    <div class="description">
                        <p class="des-question{{$question->id}} add-read-more show-less-content">{{$question->question}}</p>
                    </div>
                </div>
                @if (Auth::check())
                    @if(auth()->user()->id == $question->sender_id)
                        @if($question->answered === false)
                            <div class="content-p mt-4 mb-4 button-box-{{$question->id}}" >
                              <div class="d-flex replay-box align-items-center justify-content-center justify-content-md-end">
                                  <div onclick="questionBox('{{$question->id}}','{{$question->question}}')" class="view-replay answer answer-{{$question->id}}" data-id="{{$question->id}}">
                                      <a href="javascript:void(0)"><i class="fas fa-pencil me-1 "></i> Update Question</a>
                                  </div>
                                  
                              </div>
                            </div>
                        @endif
                    @endif
                @endif
                @foreach($question->answers as $answer)
                <?php
                    $store_name1 = (new \App\Http\Helper\Web)->storeDetail(@$answer->sender_id,'store_name');
                    $store_logo1 = (new \App\Http\Helper\Web)->storeDetail(@$answer->sender_id,'store_logo'); 
                ?>
                <div class="rating-list">
                    <div class="d-flex profile-img align-items-center">
                        <div class="profile-img me-3">
                            <img src="{{$store_logo1}}" alt="profile" class="img-fluid">
                        </div>
                        <div class="text-pro">
                            <h6><b>Answer</b> | {{date('F d, Y',strtotime($answer->created_at))}} from {{$store_name1}} (Classroom Copy Seller)</h6>
                        </div>
                    </div>
                    <div class="content-p mt-3">
                        <div class="description">
                            <p class="add-read-more show-less-content">{{$answer->question}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
            @if($total_ques > 10)
            <div class="my-2 mt-4 text-center load-more">
                <input type="submit" class="btn btn-primary btn-hover px-4 py-2" data-skip="10" data-productid="{{$_id}}" id="load-more" value="View More">
            </div>
            @endif
        </div>
        <div id="tab-4" class="tab-content">
           @if(!empty($productSeller->tell_us_about_you))
            <div class="about-me" style="text-align: left;">
                <h6 class="text-uppercase "> About Me</h6>
                <p>{{$productSeller->tell_us_about_you}}</p>
            </div>
            @endif
            @if(!empty($productSeller->detail_additional_information))
            <div class="additional-info" style="text-align: left;">
                <h6 class="text-uppercase"> Additional Info</h6>
                <p>{{$productSeller->detail_additional_information}}</p>
            </div>
            @endif
        </div>


    </div>
</section>
<!-Tab Section Ends Here-->

<?php
?>
<!--Content Section Starts Here-->
@if(!empty($reldata))
<section class="books-section pb-5">
    <div class="container">
        <div class="row">
            <h2 class="text-uppercase py-5"><span class="border px-5 py-2">Related Product</span></h2>
            @foreach($reldata as $rel)
            <?php
                $product_url = url('/product-description/'.$rel['_id']);
                $is_favourite = 'fal bg-white ';
                $add_favourite = 'add-favourite';
                $remove_favourite = '';
                if($rel['is_favourite'] == true){
                    $is_favourite = 'fas text-danger bg-white ';
                    $add_favourite = '';
                    $remove_favourite = ' remove-favourite ';
                }
                //Add to cart:
                $is_cart = 'fal bg-white ';
                $add_cart = 'add-cart';
                $remove_cart = '';
                if ($rel['is_cart'] == true) {
                    $is_cart = 'fas text-danger bg-white ';
                    $add_cart = '';
                    $remove_cart = ' remove-cart ';
                }
            ?>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="box position-relative ">
                    @if($rel['is_sale']==1)
                        <span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>
                    @endif
                    
                        <a href="{{$product_url}}">
                            <img src="{{$rel['main_image']}}" class="img-fluid " alt="Book-10 ">
                        </a>
                    
                    
                
                    <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute ">
                        <li class="mx-2 add-remove-fav-action <?php echo $rel['auth_user'] === false ? ' memberLogin ' : ''; ?> {{$add_favourite}} {{$remove_favourite}}" data-prod_id="{{$rel['_id']}}">
                            <a href="javascript:void(0)" class="">
                                <i class="{{$is_favourite}} fa-heart rounded-circle p-2 "></i>
                            </a>
                        </li>
                        @if($rel['is_paid_or_free'] != 'free')
                            <li class="mx-2 add-remove-cart-action {{$rel['auth_user'] === false ? ' memberLogin ' : ''}} {{$add_cart}} {{$remove_cart}}" data-prod_id="{{$rel['_id']}}">
                                <a href="javascript:void(0)">
                                    <i class="{{$is_cart}} fa-shopping-cart rounded-circle p-2 "></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <p class="pt-4 fw-bold mb-0 "><a href="{{$product_url}}" >{{$rel['product_title']}}</a></p>
                    @if($rel['is_paid_or_free'] == 'free')
                        <span class="badge bg-success">Free</span>
                    @else
                        <span class="d-inline-block price py-2 px-0 ">${{$rel['single_license']}}</span>
                        @if($rel['is_sale']==1)
                        <span class="price-line-through p-0 ">${{$rel['actual_single_license']}}</span>
                        @endif
                    @endif
                <ul class="rating d-flex flex-row justify-content-start ps-0 ">
                <?php 
                    for($x = 1; $x <= $rel['rating']; $x++){
                ?>
                    <li><i class='fas fa-star text-yellow'></i></li>
                <?php
                    }
                ?>
                @while($x<=5)
                    <li><i class='fal fa-star text-muted'></i></li>
                    <?php
                        $x++;
                    ?>
                @endwhile 
                <li><a href="{{$product_url}}#reviews">&nbsp;({{$rel['productRatingcount']}})</a></li>          
                </ul>
                <div class="d-flex align-items-center list-profile-bx mb-4">
                    <a href="{{url('/seller-profile/'.str_replace(' ','-',$rel['sellername']))}}">
                        <img src="<?php echo $rel['sellerimage'];?>" alt="<?php echo $rel['sellername'];?>" class="me-2">
                        <?php echo $rel['sellername'];?>
                    </a>
                </div>
            </div>
            <?php
            /*
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="box position-relative"><img src="{{asset('images/Book-6.jpg')}}" class="img-fluid" alt="Book-6">
                        <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute">
                            <li class="mx-2"><a href="#"><i class="fal fa-heart bg-white rounded-circle p-2"></i></a></li>
                            <li class="mx-2"><a href="#"><i class="fal fa-shopping-cart bg-white rounded-circle p-2"></i></a></li>
                            <li class="mx-2"><a href="#"><i class="fal fa-search bg-white rounded-circle p-2"></i></a></li>
                            </li>
                        </ul>
                    </div>
                    <p class="pt-4 fw-bold mb-0">Sample Distance Learning Education Goals</p>
                    <span class="d-inline-block price py-2 px-0">$ 8.50</span>
                    <span class="price-line-through p-0">$ 11.90</span>
                    <ul class="rating d-flex flex-row justify-content-start ps-0 ">
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fal fa-star text-muted'></i></a></li>
                    </ul>

                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="box position-relative"><span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>
                        <img src="{{asset('images/Book-7.jpg')}}" class="img-fluid" alt="Book-7">
                        <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute">
                            <li class="mx-2"><a href="#"><i class="fal fa-heart bg-white rounded-circle p-2"></i></a></li>
                            <li class="mx-2"><a href="#"><i class="fal fa-shopping-cart bg-white rounded-circle p-2"></i></a></li>
                            <li class="mx-2"><a href="#"><i class="fal fa-search bg-white rounded-circle p-2"></i></a></li>
                        </ul>


                    </div>
                    <p class="pt-4 fw-bold mb-0">Sample Distance Learning Education Goals</p>
                    <span class="d-inline-block price py-2 px-0">$ 8.50</span>
                    <span class="price-line-through p-0">$ 11.90</span>
                    <ul class="rating d-flex flex-row justify-content-start ps-0 ">
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fal fa-star text-muted'></i></a></li>
                    </ul>

                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="box position-relative"><img src="{{asset('images/Book-8.jpg')}}" class="img-fluid" alt="Book-8">
                        <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute">
                            <li class="mx-2"><a href="#"><i class="fal fa-heart bg-white rounded-circle p-2"></i></a></li>
                            <li class="mx-2"><a href="#"><i class="fal fa-shopping-cart bg-white rounded-circle p-2"></i></a></li>
                            <li class="mx-2"><a href="#"><i class="fal fa-search bg-white rounded-circle p-2"></i></a></li>
                            </li>
                        </ul>


                    </div>
                    <p class="pt-4 fw-bold mb-0">Sample Distance Learning Education Goals</p>
                    <span class="d-inline-block price py-2 px-0">$ 8.50</span>
                    <span class="price-line-through p-0">$ 11.90</span>
                    <ul class="rating d-flex flex-row justify-content-start ps-0 ">
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fas fa-star'></i></a></li>
                        <li><a href="#"><i class='fal fa-star text-muted'></i></a></li>
                    </ul>

                </div>
            */
            ?>
            @endforeach
        </div>
    </div>
</section>
@endif
@push('script')
    <script type="text/javascript">
        $(document).ready(function(e){
            var role_id = "{{ (auth()->user() != null) ? auth()->user()->role_id  : 0 }}";

             //Add to favourite:
            $(document).on('click', '.add-favourite', function (e) {
                if (role_id == 1) {
                    e.preventDefault();
                    var t = $(this);
                    var product_id = $(this).data("prod_id");
                    var is_reload = $(this).data("is-reload");
                    $.ajax({
                        url: "{{route('addToFavourite')}}",
                        type: 'POST',
                        data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                        beforeSend: function (xhr) {
                            //$(".is-favourite").prop('disabled', true);
                            $(".add-remove-fav-action").css("pointer-events", 'none');
                        }
                    }).always(function () {
                        //$(".is-favourite").prop('disabled', false);
                        $(".add-remove-fav-action").css("pointer-events", 'auto');
                    }).done(function (response, status, xhr) {
                        if (response.success === true) {
                            t.removeClass('add-favourite').addClass('remove-favourite');
                            t.html('<a href="javascript:void(0)" class=""><i class="fas text-danger bg-white  fa-heart rounded-circle p-2 "></i></a>');
                            //getProductsResourcesYouMayLike('','cartfav');
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: ' Added to your Wishlist',
                                animation: true,
                                position: 'bottom',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: false,
                                customClass: {
                                    container: 'add-wishlist-container',
                                    popup: 'add-wishlist-popup',
                                },
                                //didOpen: (toast) => {
                                //  toast.addEventListener('mouseenter', Swal.stopTimer)
                                //  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                //}
                            });
                            if (is_reload != undefined && is_reload == true) {
                                window.location.reload();
                            }
                        }
                        if (response.success === false) {

                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        if (xhr.status == 419 && xhr.statusText == "unknown status") {
                            swal.fire("Unauthorized! Session expired", "Please login again", "error");
                        } else {
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                Swal.fire({
                                    title: 'Oops...',
                                    text: xhr.responseJSON.message,
                                    icon: 'error',
                                    showConfirmButton: true,
                                    //closeOnClickOutside: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    //        timer: 3000
                                });
                            } else {
                                swal.fire('Unable to process your request', "Please try again", "error");
                            }
                        }
                    });
                }
            });
            //Remove favourite:
            $(document).on('click', '.remove-favourite', function (e) {
                if (role_id == 1) {
                    e.preventDefault();
                    var  t = $(this);
                    var product_id = $(this).data("prod_id");
                    var is_reload = $(this).data("is-reload");
                    $.ajax({
                        url: "{{route('removeFavourite')}}",
                        type: 'POST',
                        data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                        beforeSend: function (xhr) {
                            //$(".remove-favourite").prop('disabled', true);
                            $(".add-remove-fav-action").css("pointer-events", 'none');
                        }
                    }).always(function () {
                        //$(".remove-favourite").prop('disabled', false);
                        $(".add-remove-fav-action").css("pointer-events", 'auto');
                    }).done(function (response, status, xhr) {
                        if (response.success === true) {
                            t.removeClass('remove-favourite').addClass('add-favourite');
                            t.html('<a href="javascript:void(0)" class=""><i class="fal bg-white  fa-heart rounded-circle p-2 "></i></a>');
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: 'Removed from your Wishlist',
                                animation: true,
                                position: 'bottom',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: false,
                                customClass: {
                                    container: 'add-wishlist-container',
                                    popup: 'add-wishlist-popup',
                                },
                                //didOpen: (toast) => {
                                //  toast.addEventListener('mouseenter', Swal.stopTimer)
                                //  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                //}
                            });
                            if (is_reload != undefined && is_reload == true) {
                                window.location.reload();
                            }
                        }
                        if (response.success === false) {

                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        if (xhr.status == 419 && xhr.statusText == "unknown status") {
                            swal.fire("Unauthorized! Session expired", "Please login again", "error");
                        } else {
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                Swal.fire({
                                    title: 'Oops...',
                                    text: xhr.responseJSON.message,
                                    icon: 'error',
                                    showConfirmButton: true,
                                    //closeOnClickOutside: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    //        timer: 3000
                                });
                            } else {
                                swal.fire('Unable to process your request', "Please try again", "error");
                            }
                        }
                    });
                }
            });
            //Add to cart:
            $(document).on('click', '.add-cart', function (e) {
                if (role_id == 1) {
                    e.preventDefault();
                    var t = $(this);
                    var product_id = $(this).data("prod_id");
                    var act_product_id = $(this).data("act-prodid");
                    var is_reload = $(this).data("is-reload");
                    $.ajax({
                        url: "{{route('check.if.alreadypurached')}}",
                        type: 'POST',
                        data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                        beforeSend: function (xhr) {
                            //$(".is-favourite").prop('disabled', true);
                            $(".add-remove-cart-action").css("pointer-events", 'none');
                        } 
                    }).done(function (response, status, xhr) {
                        $(".add-remove-cart-action").css("pointer-events", 'auto');
                        if(response.status == 1){
                            Swal.fire({
                                title: 'Product Already Purchased',
                                showDenyButton: true,
                                confirmButtonText: 'Buy Again',
                                denyButtonText: 'No',
                            }).then((result) => {
                                if(result.isConfirmed){
                                    $.ajax({
                                        url: "{{route('addToCart')}}",
                                        type: 'POST',
                                        data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                                        beforeSend: function (xhr) {
                                            //$(".is-favourite").prop('disabled', true);
                                            $(".add-remove-cart-action").css("pointer-events", 'none');
                                        }
                                    }).always(function () {
                                        //$(".is-favourite").prop('disabled', false);
                                        $(".add-remove-cart-action").css("pointer-events", 'auto');
                                    }).done(function (response, status, xhr) {
                                        if (response.success === true) {
                                            totalCartItemCount();
                                            jQuery("ul li.add-cart[data-act-prodid='"+act_product_id+"']").html('<a href="javascript:void(0)" class=""><i class="fas text-danger bg-white  fa-shopping-cart rounded-circle p-2 "></i></a>');
                                            jQuery("ul li.add-cart[data-act-prodid='"+act_product_id+"']").removeClass('add-cart').addClass('remove-cart');
                                            Swal.fire({
                                                toast: true,
                                                icon: 'success',
                                                title: 'Added to your Cart',
                                                animation: true,
                                                position: 'bottom',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: false,
                                                customClass: {
                                                    container: 'add-wishlist-container',
                                                    popup: 'add-wishlist-popup',
                                                },
                                                //didOpen: (toast) => {
                                                //  toast.addEventListener('mouseenter', Swal.stopTimer)
                                                //  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                //}
                                            });
                                            if (is_reload != undefined && is_reload == true) {
                                                window.location.reload();
                                            }
                                        }
                                        if (response.success === false) {

                                        }
                                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                                            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                                                swal.fire("Unauthorized! Session expired", "Please login again", "error");
                                            } else {
                                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                                    Swal.fire({
                                                        title: 'Oops...',
                                                        text: xhr.responseJSON.message,
                                                        icon: 'error',
                                                        showConfirmButton: true,
                                                        //closeOnClickOutside: false,
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        //        timer: 3000
                                                    });
                                                } else {
                                                    swal.fire('Unable to process your request', "Please try again", "error");
                                                }
                                            }
                                        });
                                }
                                else if (result.isDenied) {
                                    Swal.close();
                                    return false;
                                }
                            })
                        }    
                        if(response.status == 2){
                            $.ajax({
                                url: "{{route('addToCart')}}",
                                type: 'POST',
                                data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                                beforeSend: function (xhr) {
                                    //$(".is-favourite").prop('disabled', true);
                                    $(".add-remove-cart-action").css("pointer-events", 'none');
                                }
                            }).always(function () {
                                //$(".is-favourite").prop('disabled', false);
                                $(".add-remove-cart-action").css("pointer-events", 'auto');
                            }).done(function (response, status, xhr) {
                                if (response.success === true) {
                                    totalCartItemCount();
                                    jQuery("ul li.add-cart[data-act-prodid='"+act_product_id+"']").html('<a href="javascript:void(0)" class=""><i class="fas text-danger bg-white  fa-shopping-cart rounded-circle p-2 "></i></a>');
                                    jQuery("ul li.add-cart[data-act-prodid='"+act_product_id+"']").removeClass('add-cart').addClass('remove-cart');
                                    Swal.fire({
                                        toast: true,
                                        icon: 'success',
                                        title: 'Added to your Cart',
                                        animation: true,
                                        position: 'bottom',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: false,
                                        customClass: {
                                            container: 'add-wishlist-container',
                                            popup: 'add-wishlist-popup',
                                        },
                                        //didOpen: (toast) => {
                                        //  toast.addEventListener('mouseenter', Swal.stopTimer)
                                        //  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        //}
                                    });
                                    if (is_reload != undefined && is_reload == true) {
                                        window.location.reload();
                                    }
                                }
                                if (response.success === false) {

                                }
                            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                                    if (xhr.status == 419 && xhr.statusText == "unknown status") {
                                        swal.fire("Unauthorized! Session expired", "Please login again", "error");
                                    } else {
                                        if (xhr.responseJSON && xhr.responseJSON.message) {
                                            Swal.fire({
                                                title: 'Oops...',
                                                text: xhr.responseJSON.message,
                                                icon: 'error',
                                                showConfirmButton: true,
                                                //closeOnClickOutside: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                //        timer: 3000
                                            });
                                        } else {
                                            swal.fire('Unable to process your request', "Please try again", "error");
                                        }
                                    }
                                });
                        } 
                        if(response.status == 0){
                            swal.fire(response.message,"", "warning");
                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        if (xhr.status == 419 && xhr.statusText == "unknown status") {
                            swal.fire("Unauthorized! Session expired", "Please login again", "error");
                        } else {
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                Swal.fire({
                                    title: 'Oops...',
                                    text: xhr.responseJSON.message,
                                    icon: 'error',
                                    showConfirmButton: true,
                                    //closeOnClickOutside: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    //        timer: 3000
                                });
                            } else {
                                swal.fire('Unable to process your request', "Please try again", "error");
                            }
                        }
                    });
                }
            });
            // $(document).on('click', '.add-cart', function (e) {
            //     if (role_id == 1) {
            //         e.preventDefault();
            //         var t = $(this);
            //         var product_id = $(this).data("prod_id");
            //         var is_reload = $(this).data("is-reload");
            //         $.ajax({
            //             url: "{{route('addToCart')}}",
            //             type: 'POST',
            //             data: {product_id: product_id, _token: '{{ csrf_token() }}'},
            //             beforeSend: function (xhr) {
            //                 //$(".is-favourite").prop('disabled', true);
            //                 $(".add-remove-cart-action").css("pointer-events", 'none');
            //             }
            //         }).always(function () {
            //             //$(".is-favourite").prop('disabled', false);
            //             $(".add-remove-cart-action").css("pointer-events", 'auto');
            //         }).done(function (response, status, xhr) {
            //             if (response.success === true) {
            //                 totalCartItemCount();
            //                 t.removeClass('add-cart').addClass('remove-cart');
            //                 t.html('<a href="javascript:void(0)" class=""><i class="fas text-danger bg-white  fa-shopping-cart rounded-circle p-2 "></i></a>');
            //                 Swal.fire({
            //                     toast: true,
            //                     icon: 'success',
            //                     title: 'Added to your Cart',
            //                     animation: true,
            //                     position: 'bottom',
            //                     showConfirmButton: false,
            //                     timer: 3000,
            //                     timerProgressBar: false,
            //                     customClass: {
            //                         container: 'add-wishlist-container',
            //                         popup: 'add-wishlist-popup',
            //                     },
            //                     //didOpen: (toast) => {
            //                     //  toast.addEventListener('mouseenter', Swal.stopTimer)
            //                     //  toast.addEventListener('mouseleave', Swal.resumeTimer)
            //                     //}
            //                 });
            //                 if (is_reload != undefined && is_reload == true) {
            //                     window.location.reload();
            //                 }
            //             }
            //             if (response.success === false) {

            //             }
            //         }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            //             if (xhr.status == 419 && xhr.statusText == "unknown status") {
            //                 swal.fire("Unauthorized! Session expired", "Please login again", "error");
            //             } else {
            //                 if (xhr.responseJSON && xhr.responseJSON.message) {
            //                     Swal.fire({
            //                         title: 'Oops...',
            //                         text: xhr.responseJSON.message,
            //                         icon: 'error',
            //                         showConfirmButton: true,
            //                         //closeOnClickOutside: false,
            //                         allowOutsideClick: false,
            //                         allowEscapeKey: false,
            //                         //        timer: 3000
            //                     });
            //                 } else {
            //                     swal.fire('Unable to process your request', "Please try again", "error");
            //                 }
            //             }
            //         });
            //     }
            // });
            //Remove cart:
            $(document).on('click', '.remove-cart', function (e) {
                if (role_id == 1) {
                    e.preventDefault();
                    var t = $(this);
                    var product_id = $(this).data("prod_id");
                    var is_reload = $(this).data("is-reload");
                    $.ajax({
                        url: "{{route('removeCartItem')}}",
                        type: 'POST',
                        data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                        beforeSend: function (xhr) {
                            //$(".remove-favourite").prop('disabled', true);
                            $(".add-remove-cart-action").css("pointer-events", 'none');
                        }
                    }).always(function () {
                        //$(".remove-favourite").prop('disabled', false);
                        $(".add-remove-cart-action").css("pointer-events", 'auto');
                    }).done(function (response, status, xhr) {
                        if (response.success === true) {
                            totalCartItemCount();
                            t.removeClass('remove-cart').addClass('add-cart');
                            t.html('<a href="javascript:void(0)" class=""><i class="fal bg-white  fa-shopping-cart rounded-circle p-2 "></i></a>');
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: 'Removed from your Cart',
                                animation: true,
                                position: 'bottom',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: false,
                                customClass: {
                                    container: 'add-wishlist-container',
                                    popup: 'add-wishlist-popup',
                                },
                                //didOpen: (toast) => {
                                //  toast.addEventListener('mouseenter', Swal.stopTimer)
                                //  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                //}
                            });
                            if (is_reload != undefined && is_reload == true) {
                                window.location.reload();
                            }
                        }
                        if (response.success === false) {

                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        if (xhr.status == 419 && xhr.statusText == "unknown status") {
                            swal.fire("Unauthorized! Session expired", "Please login again", "error");
                        } else {
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                Swal.fire({
                                    title: 'Oops...',
                                    text: xhr.responseJSON.message,
                                    icon: 'error',
                                    showConfirmButton: true,
                                    //closeOnClickOutside: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    //        timer: 3000
                                });
                            } else {
                                swal.fire('Unable to process your request', "Please try again", "error");
                            }
                        }
                    });
                }
            });

            //Create order for free order 
            $(document).on('click','.downloadfreeproduct',function(e){
                var proid = $(this).data('prod-id');
                $.ajax({
                    url: "{{route('create.order.freeproduct')}}",
                    type: 'POST',
                    data: {product_id: proid, _token: '{{ csrf_token() }}'},
                   
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        if(response.download === true){

                        }
                    }
                    if (response.success === false) {
                        e.preventDefault();
                        swal.fire("Something Wrong happens", "Please Refresh the page", "error");
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    if (xhr.status == 419 && xhr.statusText == "unknown status") {
                        swal.fire("Unauthorized! Session expired", "Please login again", "error");
                    } else {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            Swal.fire({
                                title: 'Oops...',
                                text: xhr.responseJSON.message,
                                icon: 'error',
                                showConfirmButton: true,
                                //closeOnClickOutside: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                //        timer: 3000
                            });
                        } else {
                            swal.fire('Unable to process your request', "Please try again", "error");
                        }
                    }
                });
            });

            //buy license to share
            @if($product->is_paid_or_free == 'paid')
            $(document).on('click','.buy-license-share',function(e){
                e.preventDefault();
                var p = Number({{number_format((float)$price, 2, '.', '')}}).toFixed(2);
                var rarp = Number({{number_format((float)$rarr["price"], 2, '.', '')}}).toFixed(2);
                $('#buyLicenseModal tbody').html('<tr><td>Original License</td><td class="single-license-price" data-single-license="'+p+'">$'+rarp+'</td></tr><tr><td>Additional licenses </td><td class="multiple-license-price">1 x $'+rarp+'</td></tr><tr><td>Total: </td><td class="total-price" data-price="'+rarp+'">$'+Number(rarp*2).toFixed(2)+'</td></tr>');
                $('#buyLicenseModal form input[name="quantity"]').val(1);
                $('#buyLicenseModal form input[name="product_id"]').val('{{Crypt::encrypt($product->id)}}');
                $("#buyLicenseModal strong.single-buy-license-to-share").html('$'+p);
                $("#buyLicenseModal strong.mutiple-buy-license-to-share").html('$'+rarp);
                $('#buyLicenseModal').modal('show');
            });
            @endif
        });
    </script>
@endpush

<!--Content Section Ends Here-->
@endsection

@push('script')
<script>
    function hideQuestionBox(e){
        $('.question-box').addClass('d-none');
    }
    function showQuestionBox(e){
        $('.question-box-update').remove();
        $('.question-box').removeClass('d-none');
    }
    function questionBox(e,id,answer="") {
        
        if(typeof e === 'object'){
            answer = e.dataset.que
        }
        else{
            answer = undefined;
            id = e;
        }
        
        $('.question-box').addClass('d-none');
        $('.question-box-update').remove();
        $('.questions-box-'+id).remove();
        edit = "Post Answer";
        action = "add";

        if(answer !=""){
          edit = "Update Question";
          action = "edit";
        }
        let ans = $(".des-question"+id).text();
        let html = '';
        html += '<div class="row g-3 border col-12 question-box-update question-box questions-box-'+id+' p-3 bg-light mt-3 mb-4" >';
        html += '    <form name="fff">';
        html += '        <div class="mb-3">';
        html += '            <textarea class="form-control answer-text'+id+'" id="answer-text" rows="3">'+ans+'</textarea>';
        html += '        </div>';
        html += '        <div class="col-auto d-flex justify-content-end">';
        html += '            <div class="col-auto d-flex justify-content-end">';
        html += '                <button onclick="hideQuestionBox('+id+')" type="button" data-question="'+id+'"  class="btn btn-light cancel border border-dark border-1">Cancel</button>';
        html += '                <button type="button" data-question="'+id+'" data-action="'+action+'" class="btn btn-primary ms-3 post-answer">'+edit+'</button>';
        html += '            </div>';
        html += '        </div>';
        html += '    </form>';
        html += '</div>';
        console.log(id);
        $('.button-box-'+id).append(html);
    }

    //For edit posted Question
    $('body').on('click', '.post-answer', function() {
      let question_id = $(this).data('question');
      let action = $(this).data('action');

      if ($('#answer-text').val() == '' || $.trim($('#answer-text').val()).length == 0) {
          if ($.trim($('#answer-text').val()).length == 0)
              $('#question-text').val('')
          $('#answer-text').focus().select();
          $("#answer-text").css('border-color', 'red');
          return false;
      }
      let answer = $('#answer-text').val();

      $.ajax({
          url: "{{route('add-question')}}",
          type: 'POST',
          data: {'_token': "{{ csrf_token() }}",answer:answer,question_id:question_id,type:'seller',action:action},
          dataType: 'json',
        }).done(function (response, status, xhr) {
            if (response.success === false) {
              swal.fire("Oops!", response.message, "error");
            }
            $('.question-box').addClass('d-none');
            if (response.success === true) {
                $(".answer-text"+question_id).html(answer);
                $(".des-question"+question_id).text(answer);
            }
      }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
          //$('#replay').modal('hide');
          if (xhr.status == 419 && xhr.statusText == "unknown status") {
              swal.fire("Unauthorized! Session expired", "Please login again", "error");
          } else {
              if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({
                        title: 'Oops...',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        showConfirmButton: true,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        //        timer: 3000
                    });
              } else {
                  swal.fire('Unable to process your request', "Please try again", "error");
              }
          }
      });
    });

    //for post Qustion 
    $(".post-question").click(function (event) {

        let productid = $(this).data('productid');
        let selletid = $(this).data('selletid');
        let notify = 1;//$('#notify').val();(updated after rajat saying on 28-09-2023)
        let action = $(this).data('action');
        // if($('#notify').is(':checked')){
        //     notify = 1;
        // }


        if ($('#question-text').val() == '' || $.trim($('#question-text').val()).length == 0) {
            if ($.trim($('#question-text').val()).length == 0)
                $('#question-text').val('')
            $('#question-text').focus().select();
            $("#question-text").css('border-color', 'red');
            return false;
        }
        let question = $('#question-text').val();
        question = question.trim();
        question = question.replace(/([\r\n]){2,}/g, '\n\n')


         let ans1 = `'${question}'`;
         console.log(question);

        $.ajax({
            url: "{{route('add-question')}}",
            type: 'POST',
            data: {'_token': "{{ csrf_token() }}",selletid:selletid,productid: productid,question:question,type:'buyer',notify:notify},
            dataType: 'json',
        }).done(function (response, status, xhr) {
            if (response.success === false) {
                swal.fire("Oops!", response.message, "error");
            }
            $('.question-box').addClass('d-none');
            if (response.success === true) {

                let que = '';
                que += '<div class="rating-list mb-5">';
                que += '    <div class="d-flex profile-img align-items-center">';
                que += '        <div class="profile-img me-3">';
                que += '            <img src="'+response.data.user_image+'" alt="profile" class="img-fluid">';
                que += '        </div>';
                que += '        <div class="text-pro">';
                que += '            <h6>Question | '+response.data.date+' from '+response.data.username+' </h6>';
                que += '        </div>';
                que += '    </div>';
                que += '    <div class="content-p mt-3">';
                que += '        <div class="description">';
                que += '            <p class="des-question'+response.data.id+'">'+question+'</p>';
                que += '        </div>';
                que += '    </div>';
                que += '    <div class="content-p mt-3 mb-4 button-box-'+response.data.id+'">';
                que += '        <div class="d-flex replay-box align-items-center justify-content-center justify-content-md-end">';
                que += '            <div onclick="questionBox(this,'+response.data.id+',\'text\')" data-que="'+question+'" class="view-replay answer answer-'+response.data.id+'" data-id="17">';
                que += '                <a href="javascript:void(0)"><i class="fas fa-pencil me-1 "></i> Update Question</a>';
                que += '            </div>';
                que += '        </div>';
                que += '    </div>';
                que += '</div>';
                $('.question-box').after(que);
                let counter = $('#qa-counter').text();
                counter = parseInt(counter) + 1;
                $('#qa-counter').text(counter);
                 $('#question-text').val('')
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            //$('#replay').modal('hide');
            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({
                        title: 'Oops...',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        showConfirmButton: true,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        //        timer: 3000
                    });
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                }
            }
        });
    });

    //for load more data 
    let take = 10;
    let skip = 10;
    $('body').on('click', '#load-more', function() {
        let productid = $(this).data('productid');

        $.ajax({
            url: "{{route('loadmore')}}",
            type: 'POST',
            data: {'_token': "{{ csrf_token() }}",take:take,skip:skip,productid:productid},
            dataType: 'json',
            beforeSend: function() {
                $("#load-more").val('Loading......');
                $('#load-more').prop('disabled', true);
            },

        }).done(function (response, status, xhr) {
            $("#load-more").val('View More');
            $('#load-more').prop('disabled', false);
            if (response.success === false) {
              swal.fire("Oops!", response.message, "error");
            }
            $('.question-box').addClass('d-none');
            if (response.success === true) {
                skip = skip +take;
                if(response.data.length === 0){
                    $("#load-more").val('View More');
                    $('#load-more').prop('disabled', true);
                }else{
                    $('.load-more').before(response.html)
                }
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            $("#load-more").val('View More');
            $('#load-more').prop('disabled', false);
            //$('#replay').modal('hide');
            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({
                        title: 'Oops...',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        showConfirmButton: true,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        //        timer: 3000
                    });
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                }
            }
      });
    });
    $(document).ready(function () {
        $('ul.tabs li').click(function () {
            var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#" + tab_id).addClass('current');
        });
        $(".scrolltoreview").on("click",function(){
            $("ul.tabs li[data-tab='tab-2']").trigger('click');
        });

        if(window.location.hash == '#reviews')
        {
            $("ul.tabs li[data-tab='tab-2']").trigger('click');
            $('html, body').animate({
                scrollTop: $("#tab-2").offset().top
            }, 2000); 
        }
    });
</script>
<script>
    // Add to favourite:
    $(document).on('click', '.add-favourite', function (e) {
        e.preventDefault();
        var product_id = $(this).data("prod_id");
        $.ajax({
            url: "{{route('addToFavourite')}}",
            type: 'POST',
            data: {product_id: product_id, _token: '{{ csrf_token() }}'},
            beforeSend: function (xhr) {
                $(".add-favourite").prop('disabled', true);
            }
        }).always(function () {
            $(".add-favourite").prop('disabled', false);
        }).done(function (response, status, xhr) {
            if (response.success === true) {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: ' Added to your Wishlist',
                    animation: true,
                    position: 'bottom',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: false,
                    customClass: {
                        container: 'add-wishlist-container',
                        popup: 'add-wishlist-popup',
                    },
                    //didOpen: (toast) => {
                    //  toast.addEventListener('mouseenter', Swal.stopTimer)
                    //  toast.addEventListener('mouseleave', Swal.resumeTimer)
                    //}
                });
                location.reload();
            }
            if (response.success === false) {
                location.reload();
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({
                        title: 'Oops...',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        showConfirmButton: true,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        //        timer: 3000
                    });
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                }
            }
        });

    });

    //Add to cart:
    $(document).on('click', '.main-add-cart', function (e) {
        e.preventDefault();
        var product_id = $(this).data("prod_id");

         $.ajax({
            url: "{{route('check.if.alreadypurached')}}",
            type: 'POST',
            data: {product_id: product_id, _token: '{{ csrf_token() }}'},
            beforeSend: function (xhr) {
                //$(".is-favourite").prop('disabled', true);
                $(".add-remove-cart-action").css("pointer-events", 'none');
            } 
        }).done(function (response, status, xhr) {
            $(".add-remove-cart-action").css("pointer-events", 'auto');
            if(response.status == 1){
                Swal.fire({
                    title: 'Product Already Purchased',
                    showDenyButton: true,
                    confirmButtonText: 'Buy Again',
                    denyButtonText: 'No',
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajax({
                            url: "{{route('addToCart')}}",
                            type: 'POST',
                            data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                            beforeSend: function (xhr) {
                                $(".add-cart").prop('disabled', true);
                            }
                        }).always(function () {
                            $(".add-cart").prop('disabled', false);
                        }).done(function (response, status, xhr) {
                            if (response.success === true) {
                                Swal.fire({
                                    toast: true,
                                    icon: 'success',
                                    title: ' Added to your Cart',
                                    animation: true,
                                    position: 'bottom',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: false,
                                    customClass: {
                                        container: 'add-wishlist-container',
                                        popup: 'add-wishlist-popup',
                                    },
                                    //didOpen: (toast) => {
                                    //  toast.addEventListener('mouseenter', Swal.stopTimer)
                                    //  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    //}
                                });
                                location.reload();
                            }
                            if (response.success === false) {
                                location.reload();
                            }
                        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                                swal.fire("Unauthorized! Session expired", "Please login again", "error");
                            } else {
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    Swal.fire({
                                        title: 'Oops...',
                                        text: xhr.responseJSON.message,
                                        icon: 'error',
                                        showConfirmButton: true,
                                        //closeOnClickOutside: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        //        timer: 3000
                                    });
                                } else {
                                    swal.fire('Unable to process your request', "Please try again", "error");
                                }
                            }
                        });
                    }
                    else if (result.isDenied) {
                        Swal.close();
                        return false;
                    }
                })
            }    
            if(response.status == 2){
                $.ajax({
                    url: "{{route('addToCart')}}",
                    type: 'POST',
                    data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {
                        $(".add-cart").prop('disabled', true);
                    }
                }).always(function () {
                    $(".add-cart").prop('disabled', false);
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: ' Added to your Cart',
                            animation: true,
                            position: 'bottom',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: false,
                            customClass: {
                                container: 'add-wishlist-container',
                                popup: 'add-wishlist-popup',
                            },
                            //didOpen: (toast) => {
                            //  toast.addEventListener('mouseenter', Swal.stopTimer)
                            //  toast.addEventListener('mouseleave', Swal.resumeTimer)
                            //}
                        });
                        location.reload();
                    }
                    if (response.success === false) {
                        location.reload();
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    if (xhr.status == 419 && xhr.statusText == "unknown status") {
                        swal.fire("Unauthorized! Session expired", "Please login again", "error");
                    } else {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            Swal.fire({
                                title: 'Oops...',
                                text: xhr.responseJSON.message,
                                icon: 'error',
                                showConfirmButton: true,
                                //closeOnClickOutside: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                //        timer: 3000
                            });
                        } else {
                            swal.fire('Unable to process your request', "Please try again", "error");
                        }
                    }
                });
            } 
            if(response.status == 0){
                swal.fire(response.message,"", "warning");
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({
                        title: 'Oops...',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        showConfirmButton: true,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        //        timer: 3000
                    });
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                }
            }
        });
    });

    //follow or unfollow seller
    $(document).on('click', '#followUnfollow', function (e) {
        e.preventDefault();
        var followed_by = "{{ auth()->user() }}";
        if (followed_by == '' || followed_by == undefined) {
            swal.fire("Unauthorized! Session expired", "Please login again", "error");
        } else {
            var followed_to = $(this).data("followed-to");
            var $this = $(this);
            $.ajax({
                url: "{{URL('/buyer/follow-unfollow')}}",
                type: 'POST',
                data: {followed_to: followed_to, _token: '{{ csrf_token() }}'},
                beforeSend: function (xhr) {
                    $this.prop('disabled', true);
                }
            }).always(function () {
                $this.prop('disabled', false);
            }).done(function (response, status, xhr) {
                $this.prop('disabled', false);
                $this.html(response.btnText);
                $('#followerCount').html(response.followerCount + ' Followers');
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $this.prop('disabled', false);
                if (xhr.status == 419 && xhr.statusText == "unknown status") {
                    swal.fire("Unauthorized! Session expired", "Please login again", "error");
                } else {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        Swal.fire({
                            title: 'Oops...',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            showConfirmButton: true,
                            //closeOnClickOutside: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            //        timer: 3000
                        });
                    } else {
                        swal.fire('Unable to process your request', "Please try again", "error");
                    }
                }
            });
        }
    });
    //rate & review modal
    $(document).on('click', '#rateReview', function () {
        var followed_by = "{{ auth()->user() }}";
        if (followed_by == '' || followed_by == undefined) {
            swal.fire("Unauthorized! Session expired", "Please login again", "error");
        } else {
            var sellerId = $(this).data('seller-id');
            $('#seller_id').val(sellerId);
            $('#type').val(2);
            $("#review").val('');
            $("#review").css('border-color', '#ced4da');
            $.ajax({
                url: "{{URL('/buyer/get-rate-review')}}",
                type: 'POST',
                data: {type: 2, seller_id: sellerId, '_token': "{{ csrf_token() }}"},
                dataType: 'json',
            }).done(function (response, status, xhr) {
                if (response.success === false) {
                    swal.fire("Oops!", response.message, "error");
                }
                if (response.success === true) {
                    if (response.result != null && response.result != undefined) {
                        var rate = response.result.rating;
                        $('.rating_star').each(function (i, e) {
                            if ($(this).hasClass('selected')) {
                                $(this).removeClass('selected');
                            }
                            if (rate > 0 && rate > i) {
                                $(this).addClass('selected');
                            }
                        });
                        $('#rating_id').val(response.result.id);
                        $('#review').val(response.result.review);
                    } else {
                        $('.rating_star').each(function (i, e) {
                            if ($(this).hasClass('selected')) {
                                $(this).removeClass('selected');
                            }
                        });
                    }
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $("#rateReviewFormSubBtn").prop('disabled', false);
                $("#rateReviewFormSubBtn").val('Submit');
                if (xhr.status == 419 && xhr.statusText == "unknown status") {
                    swal.fire("Unauthorized! Session expired", "Please login again", "error");
                } else {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        Swal.fire({
                                title: 'Oops...',
                                text: xhr.responseJSON.message,
                                icon: 'error',
                                showConfirmButton: true,
                                //closeOnClickOutside: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                //        timer: 3000
                            });
                    } else {
                        swal.fire('Unable to process your request', "Please try again", "error");
                    }
                }
            });
            $('#rateReviewModal').modal('show');
        }
    });
</script>
<script>

    $(document).ready(function(){

        $("#thumbs-main").owlCarousel({    
        items: 1,
        dots: true,
        margin:0,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        nav: true,
        navText: ['<img src="{{asset('images/arrow-up.png')}}" alt="arrow-up">', '<img src="{{asset('images/arrow-down.png')}}" alt="arrow-up">'],
        slideSpeed: 500,
        autoplay: false,
        loop:true,
        touchDrag: false,
        mouseDrag: false,
        afterMove: function() {
            setTimeout(function() {
                // Update Magnify when slide changes
                $zoom.destroy().magnify();
            }, 800); // This number should match paginationSpeed option
        }
    });
    var $zoom = $('.zoom').magnify();

    dotcount = 1;

    jQuery('#thumbs-main .owl-dot').each(function() {
        jQuery( this ).addClass( 'dotnumber' + dotcount);
        jQuery( this ).attr('data-info', dotcount);
        dotcount=dotcount+1;
    });

    slidecount = 1;

    jQuery('#thumbs-main .owl-item').not('.cloned').each(function() {
        jQuery( this ).addClass( 'slidenumber' + slidecount);
        slidecount=slidecount+1;
    });

    jQuery('#thumbs-main .owl-dot').each(function() {   
        grab = jQuery(this).data('info');       
        slidegrab = jQuery('.slidenumber'+ grab +' img').attr('src');
        jQuery(this).css("background-image", "url("+slidegrab+")");     
    });

    amount = $('#thumbs-main .owl-dot').length;
    gotowidth = amount;         
    jQuery('#thumbs-main .owl-dot').css("height", gotowidth+"%");

    

    $("#thumbs-main-mob").owlCarousel({    
        items: 1,
        dots: true,
        margin:0,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        nav: true,
        navText: ['<img src="{{asset('images/arrow-up.png')}}" alt="arrow-up">', '<img src="{{asset('images/arrow-down.png')}}" alt="arrow-up">'],
        slideSpeed: 1000,
        autoplay: true,
        loop:true,
        touchDrag: false,
        mouseDrag: false,
        afterMove: function() {
            setTimeout(function() {
                // Update Magnify when slide changes
                $zoom.destroy().magnify();
            }, 800); // This number should match paginationSpeed option
        }
    });
    var $zoom = $('.zoom').magnify();

    dotcount = 1;

    jQuery('#thumbs-main-mob .owl-dot').each(function() {
        jQuery( this ).addClass( 'dotnumber' + dotcount);
        jQuery( this ).attr('data-info', dotcount);
        dotcount=dotcount+1;
    });

    slidecount = 1;

    jQuery('#thumbs-main-mob .owl-item').not('.cloned').each(function() {
        jQuery( this ).addClass( 'slidenumber' + slidecount);
        slidecount=slidecount+1;
    });

    jQuery('#thumbs-main-mob .owl-dot').each(function() {   
        grab = jQuery(this).data('info');       
        slidegrab = jQuery('.slidenumber'+ grab +' img').attr('src');
        jQuery(this).css("background-image", "url("+slidegrab+")");     
    });

    amount = $('#thumbs-main-mob .owl-dot').length;
    gotowidth = 100/amount;         
    jQuery('#thumbs-main-mob .owl-dot').css("height", gotowidth+"%");

});

    jQuery(function ($) {
       function AddReadMore() {
          var carLmt = 250;
          var readMoreTxt = " ...Read more";
          var readLessTxt = " Read less";
          $(".add-read-more").each(function () {
             if ($(this).find(".first-section").length)
                return;
             var allstr = $(this).text();
             if (allstr.length > carLmt) {
                var firstSet = allstr.substring(0, carLmt);
                var secdHalf = allstr.substring(carLmt, allstr.length);
                var strtoadd = firstSet + "<span class='second-section'>" + secdHalf + "</span><span class='read-more'  title='Click to Show More'>" + readMoreTxt + "</span><span class='read-less' title='Click to Show Less'>" + readLessTxt + "</span>";
                $(this).html(strtoadd);
             }
          });
          $(document).on("click", ".read-more,.read-less", function () {
             $(this).closest(".add-read-more").toggleClass("show-less-content show-more-content");
          });
       }
       AddReadMore();
    });
</script>

@endpush