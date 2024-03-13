@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="inner_page_title">
                    <h1>{{ isset($data['store_result'])?$data['store_result']->store_name:''}}</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$storeBanner = ($data['store_result'] == null) ? 'images/inner-banner.jpg' : Storage::disk('s3')->url('store/' . $data['store_result']->store_banner);
?>
<section class="inner_page_baner container">
    <div class="inner_page_title store-view-img">
        <img src="{{ $storeBanner }}" alt="inner banner" class="img-fluid">
    </div>
</section>

<!-- page title end  -->
<!-- Book Bin products section start -->
<?php
$reviewArr = (new \App\Http\Helper\Web)->getSellerReviews($user_id);
?>
<section class="products_main">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <ul class="nav nav-tabs  nav-fill" id="myTab" role="tablist">
                    <li class="nav-item product" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Products</button>
                    </li>
                    <li class="nav-item rating-reviews" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Ratings & Reviews ({{count($allreview)}})</button>
                    </li>
                    <li class="nav-item profile" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Profile</button>
                    </li>
                </ul>

            </div>
            <div class="col-lg-5 col-md-6 col-sm-12" id="view_sort_div">
                <div class="right-sorting">
                    <div class="row align-items-center">
                        <div class="col-md-4 my-md-0 my-3" id="viewLabel">
                            
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="label-view">
                                    <h6>
                                        Sort by
                                    </h6>
                                </div>
                                <div class="sort" id="product-sort">
                                    <select class="form-select sort-filter">
                                        <option value="" selected="" disabled="">Sort By</option>
                                        <option value="best-seller">Best Sellers</option>
                                        <option value="rating">Rating</option>
                                        <option value="h2l">Price</option>
                                        <option value="recent">Most Recent</option>
                                    </select>
                                </div>
                                <div class="sort" id="rate-review-sorting" style="display:none;">
                                    <select class="form-select rating-sort-filter">
                                        <option value="created_at">Most Recent</option>
                                        <option value="rating">Rating</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="tab-title mb-4 mb-md-5 search-title">Products</h3>
                        <div class="">
                            <div id="filterProductContainerPagination" class="row"></div>
                        </div>
                    
                        <div class="row mt-4">
                            <div class="col">
                                <div class="pagination-box">
                                    <!--Pagination start/.-->
                                    <div class="container-fluid go-to-pagination">
                                        <div class="row d-flex justify-content-center ">
                                            <div class="col-auto entry_details "></div>
                                            <div class="w-auto d-flex flex-row justify-content-center align-items-center pagination-box">
                                                <ul class="col-12 w-auto pagination_link pagination-sm" style="margin:0"></ul>
                                                <div class="col-auto go-to-page pe-3 ">Go to page</div>
                                                <div class="col-auto"><input type="text" class="form-control-sm border page-box" name="go_to_page" id="page-no"><a href="javascript:void(0)" id="goToPageGo" class="blue ps-2"> Go</a></div>
                                            </div>
                                        </div>
                                    </div><!--Pagination end ./-->
                                    <!--div class="d-flex justify-content-center ">
                                        <ul class="pagination align-items-center">
                                            <li class="page-item ">
                                                <a class="page-link " href="# " aria-label="Previous ">
                                                    <i class="fal fa-chevron-left px-1 "></i>
                                                </a>
                                            </li>
                                            <li class="page-item "><a class="page-link " href="# ">1</a></li>
                                            <li class="page-item "><a class="page-link " href="# ">2</a></li>
                                            <li class="page-item "><a class="page-link " href="# ">3</a></li>
                                            <li class="page-item px-1 ">...</li>
                                            <li class="page-item "><a class="page-link " href="# ">11</a></li>
                                            <li class="page-item ">
                                                <a class="page-link " href="# " aria-label="Next ">
                                                    <i class="fal fa-chevron-right px-1 "></i>
                                                </a>
                                            </li>
                                            <li class="page-item py-1 ">Go to page</li>
                                            <li class="page-item px-2 "><input type="text " class="form-control border page-box " id="page-no "> </li>
                                            <li class="page-item py-1 ms-1 "><a class="blue " href="# ">Go</a></li>
                                        </ul>
                                    </div--> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3 class="tab-title mb-4 mb-md-5">Ratings & Reviews </h3>
                        <div class="row">
                            <div class="col review-data">
                                <?php
                                if (count($allreview) > 0) {
                                    foreach ($allreview as $row) {
                                        $img = DB::table('users')->select('image')->where('id',$row['user_id'])->first();
                                        $imglink = url('images/profile.png');
                                        if(!is_null($img)){
                                            
                                            if(!empty($img->image)){
                                                $imglink = Storage::disk('s3')->url('profile_picture/'.$img->image);
                                            }
                                        }
                                        $role = ($row['role_id'] == 1) ? 'Buyer' : 'Seller';
                                        $userfirstname = (new \App\Http\Helper\Web)->userDetail(@$row->user_id,'first_name');
                                        $userlastname = (new \App\Http\Helper\Web)->userDetail(@$row->user_id,'surname');
                                        ?>
                                        <div class="rating-list mb-5">
                                            <div class="profile-title d-md-flex justify-content-between">
                                                <?php  
                                                /*
                                                <div class="title-p">
                                                    <h4>Figerative Language Posters</h4>
                                                </div>
                                                */?>
                                                <div class="date-pro">
                                                    <p><i class="fal fa-calendar me-2"></i> {{ date('F d, Y',strtotime($row['created_at'])) }}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex profile-img align-items-center">
                                                <div class="profile-img me-3">
                                                    <img src="{{$imglink}}" alt="profile" class="img-fluid">
                                                </div>
                                                <div class="text-pro">
                                                    <h6>{{ $userfirstname." ".substr($userlastname,0,1).'.' }} (Buyer)</h6>
                                                    <div class="rating-icon d-flex align-items-center">
                                                        <ul class="rating d-flex flex-row justify-content-start ps-0 me-2 mb-0">
                                                            <?php
                                                            for ($x = 1; $x <= $row['rating']; $x++) {
                                                                echo "<li><i class='fas fa-star text-yellow'></i></li>";
                                                            }
                                                            if (strpos($row['rating'], '.')) {
                                                                echo "<li><i class='fas fa-star-half-alt text-yellow'></i></li>";
                                                                $x++;
                                                            }
                                                            while ($x <= 5) {
                                                                echo "<li><i class='fal fa-star text-muted'></i></li>";
                                                                $x++;
                                                            }
                                                            ?>
                                                        </ul>
                                                        <p>{{ $row['rating'] }} Rating</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content-p mt-3">
                                                <?php if ($row['rating'] == 1) { ?>
                                                    <p class="green-text">Poor</p>
                                                <?php } else if ($row['rating'] == 2) { ?>
                                                    <p class="green-text">Average</p>
                                                <?php } else if ($row['rating'] == 3) { ?>
                                                    <p class="green-text">Good</p>
                                                <?php } else if ($row['rating'] == 4) { ?>
                                                    <p class="green-text">Satisfied</p>
                                                <?php } else if ($row['rating'] == 5) { ?>
                                                    <p class="green-text">Very Satisfied</p>
                                                <?php } else { ?>
                                                    <p class="green-text">Poor</p>
                                                <?php } ?>
                                                <div class="description">
                                                    <p class="add-read-more-cart show-less-content-cart">{{ $row['review'] }}</p>
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
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!--div class="row my-5 text-center">
                            <div class="col">
                                <button type="button" class="btn btn-primary bg-blue btn-lg px-5 py-2 py-md-3 btn-hover text-uppercase">View More</button>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <div class="pagination-box">
                                    <div class="d-flex justify-content-center ">
                                        <ul class="pagination align-items-center">
                                            <li class="page-item ">
                                                <a class="page-link " href="# " aria-label="Previous ">
                                                    <i class="fal fa-chevron-left px-1 "></i>
                                                </a>
                                            </li>
                                            <li class="page-item "><a class="page-link " href="# ">1</a></li>
                                            <li class="page-item "><a class="page-link " href="# ">2</a></li>
                                            <li class="page-item "><a class="page-link " href="# ">3</a></li>
                                            <li class="page-item px-1 ">...</li>
                                            <li class="page-item "><a class="page-link " href="# ">11</a></li>
                                            <li class="page-item ">
                                                <a class="page-link " href="# " aria-label="Next ">
                                                    <i class="fal fa-chevron-right px-1 "></i>
                                                </a>
                                            </li>
                                            <li class="page-item py-1 ">Go to page</li>
                                            <li class="page-item px-2 "><input type="text " class="form-control border page-box " id="page-no "> </li>
                                            <li class="page-item py-1 ms-1 "><a class="blue " href="# ">Go</a></li>
                                        </ul>

                                    </div> 
                                </div>
                            </div>
                        </div-->
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <h3 class="tab-title mb-4 mb-md-5">Profile </h3>
                        <?php
                        $storeLogo = ($data['store_result'] == null) ? 'images/profile-logo.png' : Storage::disk('s3')->url('store/' . $data['store_result']->store_logo);
                        ?>
                        <div class="profile-logo mb-5">
                            <img src="{{ $storeLogo }}" alt="profile logo">
                        </div>
                        @if($user->first_name && $user->surname )
                        <div class="row mb-3 ">
                            <div class="col-md-2 col-12">
                                <div class="labels">
                                    <p>Name:</p>
                                </div>
                            </div>
                            <div class="col-md-10 col-12">
                                <div class="profile-txt">
                                    <p>{{$user->first_name.' '.$user->surname}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- @if($user->email)
                        <div class="row mb-3 ">
                            <div class="col-md-2 col-12">
                                <div class="labels">
                                    <p>Email:</p>
                                </div>
                            </div>
                            <div class="col-md-10 col-12">
                                <div class="profile-txt">
                                    <p>{{$user->email}}</p>
                                </div>
                            </div>
                        </div>
                        @endif -->
                        @if($user->phone)
                        <!--div class="row mb-3 ">
                            <div class="col-md-2 col-12">
                                <div class="labels">
                                    <p>Phone:</p>
                                </div>
                            </div>
                            <div class="col-md-10 col-12">
                                <div class="profile-txt">
                                    <p>{{$user->phone}}</p>
                                </div>
                            </div>
                        </div-->
                        @endif

                        @if($user->tell_us_about_you)
                        <div class="row mb-3 ">
                            <div class="col-md-2 col-12">
                                <div class="labels">
                                    <p>About Me:</p>
                                </div>
                            </div>
                            <div class="col-md-10 col-12">
                                <div class="profile-txt">
                                    <p>{{$user->tell_us_about_you}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($user->detail_additional_information)
                        <div class="row">
                            <div class="col-md-2 col-12">
                                <div class="labels">
                                    <p>Additional Info:</p>
                                </div>
                            </div>
                            <div class="col-md-10 col-12">
                                <div class="profile-txt">
                                    <p>{{$user->detail_additional_information}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                   
                </div>
            </div>
        </div>

    </div>
</section>
<!-- book bin products section end  -->
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
<script src="{{asset('js/jquery.simplePagination.js')}}"></script>
<script>
function AddReadMoreCom() {
  var carLmtcart = 200;
  var readMoreTxtcart = " ...Read more";
  var readLessTxtcart = " Read less";
  $(".add-read-more-cart").each(function () {
     if ($(this).find(".first-section-cart").length)
        return;
     var allstrcart = $(this).text();
     if (allstrcart.length > carLmtcart) {
        var firstSetcart = allstrcart.substring(0, carLmtcart);
        var secdHalfcart = allstrcart.substring(carLmtcart, allstrcart.length);
        var strtoaddcart = firstSetcart + "<span class='second-section-cart'>" + secdHalfcart + "</span><span class='read-more-cart'  title='Click to Show More'>" + readMoreTxtcart + "</span><span class='read-less-cart' title='Click to Show Less'>" + readLessTxtcart + "</span>";
        $(this).html(strtoaddcart);
     }
  });
  $(document).on("click", ".read-more-cart,.read-less-cart", function () {
     $(this).closest(".add-read-more-cart").toggleClass("show-less-content-cart show-more-content-cart");
  });
}
AddReadMoreCom();
$(document).ready(function(){
    if(window.location.href.indexOf("profile-tab") > -1){
        $('.nav-tabs button[id="profile-tab"]').trigger('click');
    } 
});

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
                title: 'Congratulations',
                text: response.message,
                icon: 'success',
                showCancelButton: false,
                //timer: 1000,
                //confirmButtonColor: '#3085d6',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success'
                },
                confirmButtonText: 'OK'
            }).then((result) => {
                //window.location.href = window.location.href+"?tab=Communication-tab";
                if (result.isConfirmed) {

                    window.location.href = window.location.href+"?tab=Communication-tab";
                }
            });
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
                title: 'Congratulations',
                text: response.message,
                icon: 'success',
                //timer: 1000,
                showCancelButton: false,
                //confirmButtonColor: '#3085d6',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success'
                },
                confirmButtonText: 'OK'
            }).then((result) => {
                window.location.href = window.location.href+"?tab=Communication-tab";
                if (result.isConfirmed) {
                    window.location.href = window.location.href+"?tab=Communication-tab";
                }
            });
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

$('.rating-reviews').click(function () {
    $('#view_sort_div').show();
    $('#viewLabel').hide();
    $('#rate-review-sorting').show();
    $('#product-sort').hide();

});
$('.product').click(function () {
    $('#view_sort_div').show();
    $('#viewLabel').show();
    $('#rate-review-sorting').hide();
    $('#product-sort').show();
});

$('.profile').click(function () {
    $('#view_sort_div').hide();
    $('#rate-review-sorting').hide();
    $('#product-sort').hide();
});


$('.communication').click(function () {
    $('#view_sort_div').hide();
    $('#rate-review-sorting').hide();
    $('#product-sort').hide();
});


</script>
<script>
    $(document).ready(function () {
        //Filter onChange:
        $("#fs_type").on('change', function () {
            var fs_type = this.value;
//        var fs_type_filter  =   `<div class="search-wrap col-12 col-sm-12 col-md-2 mb-3">
//                                    <input required class="search-field search-field-fourth bg-light" value="${fs_type}">
//                                    <span class="search-clear-4 search-clear text-end">x</span>
//                                </div>`;
//        $("filterDisplayDivAfter").after(fs_type_filter).append();
        });


        $('.search-clear-fs-type').click(function (e) {
            $('.search-field-fs-type').val('');
//        $('#my-Select').val('').trigger('change');
//        $("#productFilterSearchForm").find("#fs_type").val('').trigger('change');
        });
        $('.search-clear-2').click(function (e) {
            $('.search-field-second').val('');
        });
        $('.search-clear-3').click(function (e) {
            $('.search-field-third').val('');
        });
        $('.search-clear-4').click(function (e) {
            $('.search-field-fourth').val('');
        });

        $('.clear-all').click(function (e) {
            $('.search-field-first').val('');
            $('.search-field-second').val('');
            $('.search-field-third').val('');
            $('.search-field-fourth').val('');
        });
    });
</script>
<script>
    $(document).ready(function () {

    });
//function addToFavourite(){
////    var page        =   $("input[name='page']").val();
//    getFilterProductsData($('form[name="productFilterSearchForm"]').serializeArray());
//}
</script>
<script>

    $(document).ready(function () {
        
        <?php
        if(isset($data['store_result'])){
        ?>
        $('form[name="productFilterSearchForm"]').append('<input type="hidden" name="store_id" id="store_id" value="{{ $data['store_result']->id }}">');
        <?php
        }
        ?>
        var filter_form = $('form[name="productFilterSearchForm"]');
        //Add to favourite:
        $(document).on('click', '.add-favourite', function (e) {
            e.preventDefault();
            var product_id = $(this).data("prod_id");
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
                    getFilterProductsData(filter_form.serializeArray());
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
                }
                if (response.success === false) {

                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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
        //Remove favourite:
        $(document).on('click', '.remove-favourite', function (e) {
            e.preventDefault();
            var product_id = $(this).data("prod_id");
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
                    getFilterProductsData(filter_form.serializeArray());
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
                }
                if (response.success === false) {

                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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
        //Add to cart:
        $(document).on('click', '.add-cart', function (e) {
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
                                    //$(".is-favourite").prop('disabled', true);
                                    $(".add-remove-cart-action").css("pointer-events", 'none');
                                }
                            }).always(function () {
                                //$(".is-favourite").prop('disabled', false);
                                $(".add-remove-cart-action").css("pointer-events", 'auto');
                            }).done(function (response, status, xhr) {
                                if (response.success === true) {
                                    totalCartItemCount();
                                    getFilterProductsData(filter_form.serializeArray());
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
                                }
                                if (response.success === false) {

                                }
                            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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
                            getFilterProductsData(filter_form.serializeArray());
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
                        }
                        if (response.success === false) {

                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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
        //Remove cart:
        $(document).on('click', '.remove-cart', function (e) {
            e.preventDefault();
            var product_id = $(this).data("prod_id");
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
                    getFilterProductsData(filter_form.serializeArray());
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
                }
                if (response.success === false) {

                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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

        $(document).on('change','.sort-filter',function(e){
            e.preventDefault();
            $("#productFilterSearchForm input[name='sort-by']").val($(this).val());
            $("#productFilterSearchForm input[name='page']").val(1);
            getFilterProductsData(filter_form.serializeArray());
        });

        $(document).on('change','.rating-sort-filter',function(e){
            e.preventDefault();
            var srtby = $(this).val();
            $.ajax({
                url: "{{route('get.reviews.sorted')}}",
                type: 'POST',
                data: {orderby: srtby ,userid:'{{$user_id}}', _token: '{{ csrf_token() }}'},
            }).done(function (response, status, xhr) {
                $(".review-data").html(response.data)
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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

        $('input[name="go_to_page"]').on("keydown", function (e) {
            var go_to_page = $('input[name="go_to_page"]').val();
            if (e.key === 'Enter') {
                $("input[name='page']").val(go_to_page);
                getFilterProductsData($("#productFilterSearchForm").serializeArray());
            }
        });
        $('#goToPageGo').click(function (e) {
            var go_to_page = $('input[name="go_to_page"]').val();
            $("input[name='page']").val(go_to_page);
            getFilterProductsData($("#productFilterSearchForm").serializeArray());
        });

        getFilterProductsData(filter_form.serializeArray());

        //Pagination data:
        function getFilterProductsData(filterData) {
            $.ajax({
                url: "{{route('product.filterSearchPaginate.get')}}",
                type: 'POST',
                data: filterData,
                beforeSend: function (xhr) {
                    $("#filterSearchSubmitBtn").prop('disabled', true);
                }
            }).always(function () {
                filter_form.find("#filterSearchSubmitBtn").prop('disabled', false);
                $('#youMayLikeViewMore').html('View More');
            }).done(function (response, status, xhr) {
                if (response.data.length === 0) {
                    $('#youMayLikeViewMore').html('No Data Found');
                }
                create_filter_data(response);
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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
        }

        function create_filter_data(response) {
            var productData = response.data;
            sr_no = response.from - 1;
            if (productData.length == 0) {
                $('.pagination-box').css('display', 'block');
                $('.search-title').html('<span class="text-center btn btn-primary bg-blue btn-lg px-4 text-uppercase btn-hover">No Items</span>');
                $('.search-title').addClass('text-center');
            } else {
                $('.pagination-box').css('display', 'block');
                $('.search-title').html('PRODUCTS')
            }
            var tbody_html = productData.length === 0 ? '' : '';
            if (productData.length > 0) {

            }
            $.each(productData, function (index, item) {
                //Add to favourite:
                var is_favourite = 'fal bg-white ';
                var add_favourite = 'add-favourite';
                var remove_favourite = '';
                if (item.is_favourite === true) {
                    is_favourite = 'fas text-danger bg-white ';
                    add_favourite = '';
                    remove_favourite = ' remove-favourite ';
                }
                //Add to cart:
                var is_cart = 'fal bg-white ';
                var add_cart = 'add-cart';
                var remove_cart = '';
                if (item.is_cart === true) {
                    is_cart = 'fas text-danger bg-white ';
                    add_cart = '';
                    remove_cart = ' remove-cart ';
                }
                var product_url = '{{ route("product.description", ":id") }}';
                product_url = product_url.replace(':id', item._id);

                tbody_html += `<div class="col-6 col-sm-6 col-lg-3 ">
                            <div class="box position-relative ">`;
                if(item.is_sale == 1){
                    tbody_html += `<span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>`;
                }
                tbody_html +=`<a href="${product_url}" ><img src="${item.main_image}" class="img-fluid " alt="Book-10 "></a>
                                <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute ">
                                    <li class="mx-2 add-remove-fav-action ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_favourite} ${remove_favourite}" data-prod_id="${item._id}" data-act-prodid="${item.prod_id}"><a href="javascript:void(0)" class=""><i class="${is_favourite} fa-heart rounded-circle p-2 "></i></a></li>`;
                if (item.is_paid_or_free != 'free') {
                    tbody_html += `<li class="mx-2 add-remove-cart-action ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_cart} ${remove_cart}" data-prod_id="${item._id}" data-act-prodid="${item.prod_id}"><a href="javascript:void(0)"><i class="${is_cart} fa-shopping-cart rounded-circle p-2 "></i></a></li>`;
                }
                tbody_html += `</li>
                                </ul>
                            </div>
                            <p class="pt-4 fw-bold mb-0 "><a href="${product_url}" >${item.product_title}</a></p>`;
                if (item.is_paid_or_free == 'free') {
                    tbody_html += `<span class="badge bg-success">Free</span>`;
                } else {
                    tbody_html += `<span class="d-inline-block price py-2 px-0 ">$${item.single_license}</span>`;
                    
                    if(item.is_sale == 1){
                        tbody_html += `<span class="price-line-through p-0 ">$${item.actual_single_license}</span>`;
                    }
                }
                var productRating = item.rating;
                tbody_html += `<ul class="rating d-flex flex-row justify-content-start ps-0 ">`;
                for (var x = 1; x <= productRating; x++) {
                    tbody_html += `<li><i class='fas fa-star text-yellow'></i></li>`;
                }
                if (productRating.toString().indexOf('.') == 1) {
                    tbody_html += `<li><i class='fas fa-star-half-alt text-yellow'></i></li>`;
                    x++;
                }
                while (x <= 5) {
                    tbody_html += `<li><i class='fal fa-star text-muted'></i></li>`;
                    x++;
                }
                tbody_html += `<li><a href="${product_url}#reviews">&nbsp;(${item.productRatingcount})</a></li></ul>
                            <div class="d-flex align-items-center list-profile-bx mb-4">
                                <a href="${item.sellerurl}">
                                    <img src="${item.sellerimage}" alt="${item.sellername}" class="me-2">
                                    ${item.sellername}
                                </a>
                            </div>
                        </div>`;
                $('#youMayLikeViewMore').attr('data-_id', item._id);
            });
            if (response.total > 2)
                $("#totalSearchResultDisplay").html(response.total + "+");
            else
                $("#totalSearchResultDisplay").html(response.total);
            var from = (response.from == null || response.from == 'null' || response.from == 'NULL' || response.from == '') ? 0 : response.from;
            var to = (response.to == null || response.to == 'null' || response.to == 'NULL' || response.to == '') ? 0 : response.to;
            //    $('.entry_details').html(`Showing ${from} to ${to} of ${response.total} entries`);
            $('#filterProductContainerPagination').html(tbody_html);
            $('.pagination_link').pagination({
                items: response.total,
                itemsOnPage: response.per_page,
                cssStyle: 'pagination',
                currentPage: response.current_page,
                hrefTextSuffix: '',
                hrefTextPrefix: 'javascript:void(0);',
                onPageClick: function (next_page) {
                    $("input[name='page']").val(next_page);
                    $('ul.simple-pagination > li').addClass('disabled');
                    var productFilterSearchForm = $("#productFilterSearchForm");
                    //            var fs_type     =   productFilterSearchForm.find("#fs_type").val();
                    getFilterProductsData(filter_form.serializeArray());
                }
            });
            if (response.data.length === 0) {
                $("#totalSearchResultDisplay").html('No');
            }
        }




        $("#clearFilterAll").css('display', 'none');

        /*
        $("#productFilterSearchForm").on('submit', function (e) {
            e.preventDefault();
            $("#clearFilterAll").css('display', 'none');
            var select_fs_language = $("#fs_language").val();
            var select_fs_grade = $("#fs_grade").val();
            var select_fs_subject = $("#fs_subject").val();
            var select_fs_price = $("#fs_price").val();
            var select_fs_type = $("#fs_type").val();
            var select_fs_format = $("#fs_format").val();
            if (select_fs_type !== '') {
                var fs_type_filter = `<div class="search-wrap col-12 col-sm-12 col-md-2 mb-3">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${select_fs_type}">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type">x</span>
                                    </div>`;
                $("#filterDisplayDivAfter").after(fs_type_filter).append();
            }

            if (select_fs_language == '' && select_fs_grade == '' && select_fs_subject == '' && select_fs_price == '' && select_fs_type == '' && select_fs_format) {
                $("#clearFilterAll").css('display', 'none');
            }
            if (select_fs_language !== '' || select_fs_grade !== '' || select_fs_subject !== '' || select_fs_price !== '' || select_fs_type !== '' || select_fs_format) {
                $("#clearFilterAll").css('display', 'block');
            }



            //Search submit disabled:
            //        $("#filterSearchSubmitBtn").prop('disabled', true);
            var productFilterSearchForm = $("#productFilterSearchForm");
            //        var fs_type     =   productFilterSearchForm.find("#fs_type").val();
            //        $("#resourcesYouMayLikeContainer").empty();
            //        getFilterProductsViewMoreData(last_id='',fs_type);
            //Pagination function:
            $("#productFilterSearchForm").find("input[name='page']").val(1);//important
            getFilterProductsData($('#productFilterSearchForm').serializeArray());
        });
        */
        
        $("#youMayLikeViewMore").click(function () {
            var element = document.getElementById('youMayLikeViewMore');
            var last_id = element.getAttribute('data-_id');
            var fs_type = $("#productFilterSearchForm").find("#fs_type").val();
            var store_id = $("#productFilterSearchForm").find("#store_id").val();

//        $('#youMayLikeViewMore').html('Loading...');
            getFilterProductsViewMoreData(last_id, fs_type, store_id);
        });


        function getFilterProductsViewMoreData(last_id = '', fs_type = '', store_id = '') {
            $.ajax({
                url: "{{route('product.filterSearch.get')}}",
                type: "POST",
                data: {_id: last_id, fs_type: fs_type, store_id: store_id},
                beforeSend: function (xhr) {
                    $('#youMayLikeViewMore').html('Loading...');
                }
            }).always(function () {
                $("#filterSearchSubmitBtn").prop('disabled', false);
                $('#youMayLikeViewMore').html('View More');
            }).done(function (response, status, xhr) {
                if (response.data.length === 0) {
                    $('#youMayLikeViewMore').html('No Data Found');
                } else {
                    create_filter_products_view_more_data(response);
                    $('#youMayLikeViewMore').attr('data-_id', response.last_id);
                }

            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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
        }
    });
    //Create Products Resources You May Like:
    function create_filter_products_view_more_data(response) {
        var productData = response.data;
        if (productData.length == 0) {
            $('.pagination-box').css('display', 'none');
        } else {
            $('.pagination-box').css('display', 'block');
        }

        var tbody_html = '';
        //    var tbody_html  =   productData.length === 0 ? 'empty' : '';
        //    if(productData.length > 0){
        //
        //    }

        $.each(productData, function (index, item) {
            //Add to favourite:
            var is_favourite = 'fal bg-white ';
            var add_favourite = 'add-favourite';
            var remove_favourite = '';
            if (item.is_favourite === true) {
                is_favourite = 'fas text-danger bg-white ';
                add_favourite = '';
                remove_favourite = ' remove-favourite ';
            }
            //Add to cart:
            var is_cart = 'fal bg-white ';
            var add_cart = 'add-cart';
            var remove_cart = '';
            if (item.is_cart === true) {
                is_cart = 'fas text-danger bg-white ';
                add_cart = '';
                remove_cart = ' remove-cart ';
            }
            var product_url = '{{ route("product.description", ":id") }}';
            product_url = product_url.replace(':id', item._id);

            tbody_html = `<div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="box position-relative "><a href="${product_url}" ><img src="${item.main_image}" class="img-fluid " alt="Book-10 "></a>
                                <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute ">
                                    <li class="mx-2 ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_favourite} ${remove_favourite}" data-prod_id="${item._id}"><a href="#" class=""><i class="${is_favourite} fa-heart rounded-circle p-2 "></i></a></li>
                                    <li class="mx-2 ${(item.auth_user === false ? ' memberLogin ' : '')} add-remove-cart-action ${add_cart} ${remove_cart}" data-prod_id="${item._id}"><a href="javascript:void(0)"><i class="${is_cart} fa-shopping-cart rounded-circle p-2 "></i></a></li>
                                    <li class="mx-2 "><a href="javascript:void(0)"><i class="fal fa-search bg-white rounded-circle p-2 "></i></a></li>
                                    </li>
                                </ul>


                            </div>
                            <p class="pt-4 fw-bold mb-0 "><a href="${product_url}" >${item.product_title}</a></p>`;
                            if (item.is_paid_or_free == 'paid') {
                                tbody_html += `<span class="d-inline-block price py-2 px-0">$ ${item.single_license}</span>`;
                                if(item.is_sale == 1){
                                    tbody_html += `<span class="price-line-through p-0 ">$${item.actual_single_license}</span>`;
                                }
                            } else {
                                tbody_html += `<span class="badge bg-success">Free</span>`;
                            }
                            var productRating = item.rating;
                            tbody_html += `<ul class="rating d-flex flex-row justify-content-start ps-0 ">`;
                            for (var x = 1; x <= productRating; x++) {
                                tbody_html += `<li><i class='fas fa-star text-yellow'></i></li>`;
                            }
                            if (productRating.toString().indexOf('.') == 1) {
                                tbody_html += `<li><i class='fas fa-star-half-alt text-yellow'></i></li>`;
                                x++;
                            }
                            while (x <= 5) {
                                tbody_html += `<li><i class='fal fa-star text-muted'></i></li>`;
                                x++;
                            }
                            tbody_html += `<li><a href="${product_url}#reviews">&nbsp;(${item.productRatingcount})</a></li></ul>
                                        </div></div>`;
            //    $('#resourcesYouMayLikeContainer').append(tbody_html);
            $('#filterProductContainerPagination').append(tbody_html);
        });
    }
</script>

@endpush