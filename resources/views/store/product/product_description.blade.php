@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>Product Details</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <!--<a href="{{route('storeDashboard.productDashboard')}}">-->
                    <a href="{{ url()->previous() }}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Product Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Main Product Section Starts Here-->
<section class="hero-section product-page-section py-5">
    <div class="container py-5">
        <div class="row flex-lg-row-reverse align-items-top g-4">
            <div class="col-12 col-sm-12 col-lg-5 pt-2 text-uppercase">
                <h1>{{$product->product_title}}</h1>
                <?php if ($product->is_paid_or_free == 'free') { ?>
                    <div class="price"><span class="badge bg-success text-white">Free</span></div>
                <?php } else {
                    ?>
                    <div class="price">
                        {{!empty($product->single_license)?'$'.number_format((float)$product->single_license, 2, '.', ''):''}} <span class="text-muted dollar">AUD</span>
                        /
                        {{!empty($product->multiple_license)?'$'.number_format((float)$product->multiple_license, 2, '.', ''):''}} <span class="text-muted dollar">AUD</span>
                    </div>
                <?php } ?>
                <div class="product-description">
                    <div class="product-title fw-bold pb-2">Grades Levels:
                        <p class="fw-bold text-muted mb-0">{{ $product->gradeLevelStr }}</p>
                    </div>
                    <div class="product-title fw-bold pb-1">Subjects:
                        <p class="fw-bold text-muted mb-1">{{ $product->productSubjectArea['name'] }}</p>
                    </div>
                    <div class="product-title fw-bold pb-1">Custom Category:
                        <p class="fw-bold text-muted mb-1">{{ ($product->custom_category != NULL && $product->custom_category != '') ? $product->custom_category : 'N/A' }}</p>
                    </div>
                    @if( isset($product->productOutcomeCountry) && !empty($product->productOutcomeCountry))
                    <div class="product-title fw-bold pb-1">Standards / Outcomes Country:
                        <p class="fw-bold text-muted mb-1">{{ $product->productOutcomeCountry['name'] }}</p>
                    </div>
                    @endif
                    <div class="product-title fw-bold pb-1">Standards / Outcomes:
                        <p class="fw-bold text-muted mb-1">{{ $product->standard_outcome }}</p>
                    </div>
                    @if( isset($product->product_type) && !empty($product->product_type))
                    <div class="product-title fw-bold">Formats Include:
                        <p class="fw-bold text-muted mb-1"><i class='fal fa-check'></i> {{$product->product_type?strtoupper($product->product_type):''}}</p>
                    </div>
                    @endif
                    <div class="product-title fw-bold  pb-1">Pages:
                        <p class="fw-bold text-muted mb-2">{{$product->no_of_pages_slides}} </p>
                    </div>
                    <div class="product-title fw-bold  pb-1">Teaching Duration:
                        <p class="fw-bold text-muted mb-2">{{$product->teaching_duration}} </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-sm-12 py-2 text-center">
                <div class="row outer">
                    <div class="col-12 col-md-12">
                       <div id="thumbs" class="owl-carousel thumbs">
                            <?php $key=1;?>
                            @if($product->main_image)
                                <div class="thumbs-img" >
                                    <div class="image-box">
                                       <a href="#" data-full="{{Storage::disk('s3')->url('products/'.$product->main_image)}}" class="full"><img src="{{Storage::disk('s3')->url('products/'.$product->main_image)}}" class="img-fluid  rounded " alt="Thumb-{{$key}}"></a>
                                   </div>
                                </div>
                            @endif
                            @if($productImages->isNotEmpty())
                                @foreach($productImages as $key => $productImage)
                                    <div class="thumbs-img" >
                                        <div class="image-box">
                                           <a href="#" data-full="{{Storage::disk('s3')->url('products/'.$productImage->image)}}" class="full"><img src="{{Storage::disk('s3')->url('products/'.$productImage->image)}}" class="img-fluid  rounded " alt="Thumb-{{$key+1}}"></a>
                                       </div>
                                    </div>
                                    <?php $key++;?>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                </div>
                <?php
                /*
                <!-- <div class="product-thumb-box d-flex float-start flex-column w-25 align-items-start ">
                    <div id="slider">
                        <ul class="thumbs position-relative">
                            <div class="up-arrow">  
                                <div class="position-absolute  up-arrow"><a href="#"><img src="{{asset('images/arrow-up.png')}}" alt="arrow-up"></a></div>
                            </div>
                            @if($productImages->isNotEmpty())
                            @foreach($productImages as $key => $productImage)
                            <li class="preview mb-3">
                                <a href="#" data-full="{{url('storage/uploads/products/'.$productImage->image)}}"><img src="{{url('storage/uploads/products/'.$productImage->image)}}" class="img-fluid  rounded " alt="Thumb-{{$key+1}}"></a>
                            </li>
                            @endforeach
                            @endif
                            <div class="down-arrow">  
                                <div class="position-absolute  up-down"><img src="{{asset('images/arrow-down.png')}}" alt="arrow-down"></a></div>
                            </div>
                        </ul>
                    </div>
                    <div class="image-box  d-flex w-75 float-start flex-row">
                        <a href="{{url('storage/uploads/products/'.$product->main_image)}}" class="full">
                        <?php
                            // $imgExtensions = ['gif', 'jpg', 'jpeg', 'png'];
                            // if (in_array($product->product_type, $imgExtensions)) {
                                ?>
                                <img src="{{Storage::disk('s3')->url('products/'.$product->main_image)}}" class="img-fluid"> 
                            <?php //} else { ?>
                                <i class="fa fa-file-alt fa-4x"></i>
                            <?php// } ?>
                        </a>
                    </div>
                </div> -->
                */
                ?>

            </div>

        </div>
    </div>
    <div class="container mt-3">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12 col-sm-12">
                <ul class="nav nav-tabs  nav-fill" id="myTab" role="tablist">
                    <li class="nav-item rating-reviews only-rating" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Ratings & Reviews ({{count($allreview)}})</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3 class="tab-title mb-4 mb-md-5">Ratings & Reviews </h3>
                        <div class="row">
                            <div class="col">
                                 @foreach($allreview as $review)
                                <div class="rating-list mb-5">
                                    <div class="profile-title d-md-flex justify-content-between">
                                        <!-- <div class="title-p">
                                            <h4>LOOKING FOR A RESOURCE</h4>
                                        </div> -->
                                        <?php
                                        $product_title = (new \App\Http\Helper\Web)->getProductDetail(@$review->product_id,'product_title');
                                        ?>
                                        <div class="date-pro">
                                            <p>{{$product_title}}</p>
                                             <p><i class="fal fa-calendar me-2"></i>{{date('F d, Y',strtotime($review->created_at))}} {{$product_title}}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex profile-img align-items-md-top align-items-start">
                                        <div class="profile-img me-3">
                                            <img src="{{$review->reviewer_user_image}}" alt="profile" class="img-fluid">
                                        </div>

                                        <div class="text-pro com-text">
                                            <h6><b>{{$review->reviewer_user_name}}</b></h6>
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
                                            <div class="description d-none d-md-block ">
                                                <p class="add-read-more-cart show-less-content-cart">{{$review->review}}</p>
                                            </div>
                                            <!-- <div class="description d-none d-md-block ">
                                                <p>{{$review->reply_text}}</p>
                                            </div> -->
                                        </div>
                                    </div>
                                    @if($review->reply === true)
                                        <?php
                                        $replay_detail = (new \App\Http\Helper\Web)->getReplayDetail(@$review->id);
                                        $store_name = (new \App\Http\Helper\Web)->storeDetail(@$replay_detail->user_id,'store_name');
                                        $store_logo = (new \App\Http\Helper\Web)->storeDetail(@$replay_detail->user_id,'store_logo');
                                        $product_title = (new \App\Http\Helper\Web)->getProductDetail(@$review->product_id,'product_title');
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
                                                <div class="text-pro com-text">
                                                    <h6><b>{{ @$store_name }} (Classroom Copy Seller)</b></h6>
                                                    <!-- <p>{{date('F d, Y',strtotime($replay_detail->created_at))}}</p> -->
                                                </div>
                                            </div>
                                            <div class="content-p mt-3">
                                                <div class="description">
                                                    <p class="add-read-more-cart show-less-content-cart">{{@$replay_detail->reply}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="content-p mt-3">
                                        <div class="description d-md-none d-block mb-5">
                                            <p>I purchase a resource from you last year and have since lost the document. Could you advise as to how I go about <br>
                                                getting another copy? <br>
                                                Thank you for your help</p>
                                        </div>
                                        <div class="d-flex replay-box align-items-center justify-content-center justify-content-md-end">
                                            <!-- <div class="grade">
                                                <p class="m-0"><span class="me-2">Student Used With</span> <b>4th Grade</b></p>
                                            </div> -->
                                            @if($review->reply === true)
                                            <div class="view-replay v-replay me-3 replay-{{$review->id}}" data-replytext="{{$review->reply_text}}" data-reviewid="{{$review->id}}">
                                                <a href="javascript:void(0)" >View Reply</a>
                                            </div>
                                            @endif
                                            @if($review->reply === false)
                                            <div class="view-replay replay replay-{{$review->id}}" data-reviewid="{{$review->id}}">
                                                <a href="javascript:void(0)"><i class="fas fa-reply me-1 "></i> Reply</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<!--Main Product Section Ends Here-->
<!-- Reply model box -->
<div class="modal fade" id="replay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title text-black" id="staticBackdropLabel">Rate & Review</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="rateReviewForm" id="rateReviewForm">
                        @csrf
                        <div class="my-2">
                            <textarea class="form-control" name="review" id="review" cols="20" rows="5" required="" placeholder="Write review"></textarea>
                        </div>
                        </br>
                        <div class="my-2 text-center">
                            <input type="hidden" name="review_id" id="review_id">
                            <input type="button" class="btn btn-primary bg-blue btn-lg btn-hover btn-round" id="rateReviewFormSubBtn" value="Reply" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reply model box -->

<!-- Reply model box -->
<div class="modal fade" id="view-replay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title text-black" id="staticBackdropLabel">Rate & Review</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="rateReviewForm" id="rateReviewForm">
                       
                        <div class="my-2">
                            <textarea class="form-control" name="review1" id="review1" cols="20" rows="5" required="" placeholder="Write review"></textarea>
                        </div>
                        </br>
                        <div class="my-2 text-center">
                            <input type="hidden" name="review_id" id="review_id">
                            <input type="button" class="btn btn-primary bg-blue btn-lg btn-hover btn-round" id="edit" value="Update" />
                            <input type="button" class="btn btn-danger bg-danger btn-lg btn-hover btn-round" id="delete" value="Delete" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reply model box -->
@endsection

@push('script')

<script>
$(document).ready(function(){

    $("#thumbs").owlCarousel({    
        items: 1,
        // itemsDesktop: [1000, 1],
        // itemsDesktopSmall: [979, 1],
        // itemsTablet: [768, 1],

        dots: true,
        margin:0,
        animateIn: 'fadeIn',
        nav: true,
        touchDrag: false,
        mouseDrag: false,

        navText: ['<img src="{{asset('images/arrow-up.png')}}" alt="arrow-up">', '<img src="{{asset('images/arrow-down.png')}}" alt="arrow-up">'],
        slideSpeed: 1000,
        autoplay: false,
        loop:true
    });

    dotcount = 1;

    jQuery('#thumbs .owl-dot').each(function() {
        jQuery( this ).addClass( 'dotnumber' + dotcount);
        jQuery( this ).attr('data-info', dotcount);
        dotcount=dotcount+1;
    });

    slidecount = 1;

    jQuery('#thumbs .owl-item').not('.cloned').each(function() {
        jQuery( this ).addClass( 'slidenumber' + slidecount);
        slidecount=slidecount+1;
    });

    jQuery('#thumbs .owl-dot').each(function() {    
        grab = jQuery(this).data('info');       
        slidegrab = jQuery('.slidenumber'+ grab +' img').attr('src');
        jQuery(this).css("background-image", "url("+slidegrab+")");     
    });

    amount = $('#thumbs .owl-dot').length;
    gotowidth = 100/amount;         
    jQuery('#thumbs .owl-dot').css("height", gotowidth+"%");
    
    $('.replay').click(function(e){
        e.preventDefault();
        let revie_id = $(this).data('reviewid');
        $('#review_id').val(revie_id);
        $('#replay').modal('show');
    });
    $("#rateReviewFormSubBtn").click(function (event) {
        let revie_id = $('#review_id').val();

        if ($('#review').val() == '' || $.trim($('#review').val()).length == 0) {
            if ($.trim($('#review').val()).length == 0)
                $('#review').val('')
            $('#review').focus().select();
            $("#review").css('border-color', 'red');
            return false;
        }
        let review = $('#review').val();

        $.ajax({
            url: "{{route('storeDashboard.reviewReply')}}",
            type: 'POST',
            data: {review_id: revie_id,review:review,'_token': "{{ csrf_token() }}"},
            dataType: 'json',
        }).done(function (response, status, xhr) {
            $('#replay').modal('hide');
            if (response.success === false) {
                swal.fire("Oops!", response.message, "error");
            }
            if (response.success === true) {
                $('.replay-'+revie_id).removeClass('replay');
                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    title: 'Done',
                    text: response.message,
                    icon: 'success',
                    showCancelButton: false,
                    timer: 3000,
                    //confirmButtonColor: '#3085d6',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    },
                    confirmButtonText: 'OK'
                }).then((result) => {
                    //window.location.href = window.location.href+"?tab=Communication-tab";
                    // if (result.isConfirmed) {

                    //     window.location.href = window.location.href+"?tab=Communication-tab";
                    // }
                });
                setTimeout(function(){
                    window.location.href+"?tab=Communication-tab";
                },3000);
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            $('#replay').modal('hide');
            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    swal.fire(xhr.responseJSON.message, "Please try again", "error");
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                }
            }
        });
    });

    $('.v-replay').click(function(e){
        e.preventDefault();
        let revie_id = $(this).data('reviewid');
        let replytext = $(this).data('replytext');
        $('#review_id').val(revie_id);
        $('#review1').val(replytext);
        $('#view-replay').modal('show');
    });
    $("#edit, #delete").click(function (event) {

        let revie_id = $('#review_id').val();
        let action = $(this).val()
        if ($('#review1').val() == '' || $.trim($('#review1').val()).length == 0) {
            if ($.trim($('#review1').val()).length == 0)
                $('#review').val('')
            $('#review1').focus().select();
            $("#review1").css('border-color', 'red');
            return false;
        }
        let review = $('#review1').val();
        
        $.ajax({
            url: "{{route('storeDashboard.reviewReply')}}",
            type: 'POST',
            data: {review_id: revie_id,review:review,type:action,"_token": "{{ csrf_token() }}"},
            dataType: 'json',
        }).done(function (response, status, xhr) {
            $('#view-replay').modal('hide');
            if (response.success === false) {
                swal.fire("Oops!", response.message, "error");
            }
            if (response.success === true) {
                $('.replay-'+revie_id).removeClass('replay');
                // $('.nav-tabs a[href="#Communication"]').tab('show');
                
                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    title: 'Done',
                    text: response.message,
                    icon: 'success',
                    timer: 3000,
                    showCancelButton: false,
                    //confirmButtonColor: '#3085d6',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    },
                    confirmButtonText: 'OK'
                }).then((result) => {
                    // window.location.href = window.location.href+"?tab=Communication-tab";
                    // if (result.isConfirmed) {
                    //     window.location.href = window.location.href+"?tab=Communication-tab";
                    // }
                });
                setTimeout(function(){
                    window.location.reload();
                },3000);
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            $('#view-replay').modal('hide');
            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    swal.fire(xhr.responseJSON.message, "Please try again", "error");
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                }
            }
        });
    });

});
</script>
@endpush