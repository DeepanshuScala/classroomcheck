@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- Search Section Starts Here-->
<section class="books-section search-result pb-5">
    <div class="container py-4">
        <h1 class="text-uppercase py-4">Search Result</h1>

        <div class="row justify-content-between pb-5 align-items-center">
            <div class="col-12 col-sm-12 col-lg-9">
                <div class="align-items-center ">
                    <div class="total-result float-start col-12 col-sm-12 col-md-2 mb-3" id="filterDisplayDivAfter">
                        <span style="font-size:16px!important;" id="totalSearchResultDisplay"></span> 
                        <span class="items blue">Items</span>
                    </div>
                    <!--// Filter display here //-->
                    <!--                        <div class="search-wrap col-12 col-sm-12 col-md-2 mb-3">
                                                <input required class="search-field search-field-first bg-light" value="">
                                                <span class="search-clear-1 search-clear text-end">x</span>
                                            </div>
                                            <div class="search-wrap col-12 col-sm-12 col-md-2 mb-3">
                                                <input required class="search-field search-field-second bg-light" value="">
                                                <span class="search-clear-2 search-clear text-end">x</span>
                                            </div>
                                            <div class="search-wrap col-12 col-sm-12 col-md-2 mb-3">
                                                <input required class="search-field search-field-third bg-light" value="">
                                                <span class="search-clear-3 search-clear text-end">x</span>
                                            </div>
                                            <div class="search-wrap col-12 col-sm-12 col-md-2 mb-3">
                                                <input required class="search-field search-field-fourth bg-light" value="">
                                                <span class="search-clear-4 search-clear text-end">x</span>
                                            </div>-->
                    <a href="javascript:void(0)" class="blue text-decoration-underline ms-3 clear-all" id="clearFilterAll">Clear All</a>

                </div>
            </div>

            <div class="col-12 col-sm-12 col-lg-3 sortby-section d-flex align-items-center p-0 justify-content-end">
                <span class="sort float-start py-1">SORT BY</span>
                <select class="form-select sort-filter border-0 text-dark px-2 fw-boldQ bg-light ms-2" name="sort_by_sort" id="sort_by_sort" aria-label="Default select example" style="width:175px;">
                    <option value="" selected="" disabled="">Sort By</option>
                    <option value="rating">Rating</option>
                    <option value="h2l">Price(high to low)</option>
                    <option value="l2h">Price(low to high)</option>
                </select>
                <!--ul class="navbar-nav download-report w-50 float-end">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle bg-light  px-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Relevancy <i class='fal fa-chevron-down fa-1x py-1 fw-bold float-end'></i>
                        </a>
                        
                        <ul class="dropdown-menu bg-light">
                            <li><a class="dropdown-item" href="rating">Rating</a></li>
                            <li><a class="dropdown-item" href="h2l">Price(high to low)</a></li>
                            <li><a class="dropdown-item" href="l2h">Price(low to high)</a></li>
                            <li><a class="dropdown-item" href="free">Free Product</a></li>
                        </ul>
                    </li>
                </ul-->
            </div>
        </div>

        <?php if (count($data['featureProdRes']) > 0) { ?>
            <div class="row bg-light-blue p-3 mb-5">
                <h4 class="text-uppercase pb-2 ">Sponsored</h4>
                <?php
                foreach ($data['featureProdRes'] as $row) {
                    $productRating = $row['rating'];
                    //Add to favourite:
                    $is_favourite = 'fal bg-white ';
                    $add_favourite = 'add-favourite';
                    $remove_favourite = '';
                    if ($row['is_favourite'] === true) {
                        $is_favourite = 'fas text-danger bg-white ';
                        $add_favourite = '';
                        $remove_favourite = ' remove-favourite ';
                    }
                    //Add to cart:
                    $is_cart = 'fal bg-white ';
                    $add_cart = 'add-cart';
                    $remove_cart = '';
                    if ($row['is_cart'] === true) {
                        $is_cart = 'fas text-danger bg-white ';
                        $add_cart = '';
                        $remove_cart = ' remove-cart ';
                    }
                    ?>
                    <div class="col-6 col-sm-6 col-lg-3 ">
                        <div class="box position-relative ">
                            @if($row['is_sale']==1)
                                <span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>
                            @endif
                            <a href="{{ URL("/product-description").'/'.$row['_id'] }}">
                                <img src="{{ $row['main_image'] }}" class="img-fluid " alt="Book-spons-1 ">
                            </a>
                            <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute ">
                                <li class="mx-2 add-remove-fav-action   {{($row['auth_user'] === false ? ' memberLogin ' : '')}} {{$add_favourite}} {{$remove_favourite}}" data-prod_id="{{ $row['_id'] }}" data-act-prodid="{{$row['prod_id']}}" data-is-reload=false>
                                    <a href="#" class=""><i class="{{ $is_favourite }} fa-heart rounded-circle p-2 "></i></a>
                                </li>
                                <?php if ($row['is_paid_or_free'] != 'free') { ?>
                                    <li class="mx-2 {{($row['auth_user'] === false ? ' memberLogin ' : '')}} add-remove-cart-action {{ $add_cart }} {{ $remove_cart }}" data-prod_id="{{ $row['_id'] }}" data-act-prodid="{{$row['prod_id']}}"  data-is-reload=false>
                                        <a href="javascript:void(0)"><i class="{{ $is_cart }} fa-shopping-cart rounded-circle p-2 "></i></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <p class="pt-4 fw-bold mb-0 ">
                            <a href="{{ URL("/product-description").'/'.$row['_id'] }}">
                                {{ $row->product_title }}

                            </a>
                        </p>
                        <?php if ($row['is_paid_or_free'] == 'free') { ?>
                            <span class="badge bg-success">Free</span>
                        <?php } else { ?>
                            <span class="d-inline-block price py-2 px-0 ">${{$row['single_license']}}</span>
                            <?php  
                            if($row['is_sale'] == 1){
                            ?>
                                <span class="price-line-through p-0 ">${{$row['actual_single_license']}}</span>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        <ul class="rating d-flex flex-row justify-content-start ps-0 ">
                            <?php for ($x = 1; $x <= $productRating; $x++) { ?>
                                <li><i class='fas fa-star text-yellow'></i></li>
                                <?php
                            }
                            if (strpos($productRating, '.') == 1) {
                                ?>
                                <li><i class='fas fa-star-half-alt text-yellow'></i></li>
                                <?php
                                $x++;
                            }
                            while ($x <= 5) {
                                ?>
                                <li><i class='fal fa-star text-muted'></i></li>
                                <?php
                                $x++;
                            }
                            ?>
                            <li><a href="{{ URL("/product-description").'/'.$row['_id'] }}#reviews">&nbsp;({{$row['productRatingcount']}})</a></li>
                        </ul>
                        <div class="d-flex align-items-center list-profile-bx">
                            <a href="{{$row['sellerurl']}}">
                                <img src="<?php echo $row['sellerimage'];?>" alt="<?php echo $row['sellername'];?>" class="me-2">
                                <?php echo $row['sellername'];?>   
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div class="container">
        <div class="row">
            <div id="filterProductContainerPagination" class="row"></div>

            <div id="resourcesYouMayLikeContainer" class="row"></div>


            

            <!--                <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4 entry_details pl30"></div>
                                    <div class="col-md-8 text-right pr30"><ul class="pagination_link pagination-sm" style="margin:0px!important;"></ul></div>
                                </div>
                                        <div class="row download_div m20 mb20" style="display: none;">
                                    <div class="col-md-12 pr30 text-right">
                                        <a href="javascript:void(0);" class="btn btn-info download_report" file-format="excel">
                                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>Download Detailed Report
                                    </a>
                                    </div>
                                </div>
                            </div></br></br>-->

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

            <!--Pagination start/.-->
            <!--                <div class="d-flex justify-content-center">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                                            <i class="fal fa-chevron-left px-2"></i>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link " href="javascript:void(0)">1</a></li>
                                    <li class="page-item"><a class="page-link " href="javascript:void(0)">2</a></li>
                                    <li class="page-item"><a class="page-link " href="javascript:void(0)">3</a></li>
                                    <li class="page-item px-1">...</li>
                                    <li class="page-item"><a class="page-link " href="javascript:void(0)">11</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Next">
                                          <i class="fal fa-chevron-right px-2 "></i>
                                        </a>
                                    </li>
                                    <li class="page-item py-1 go-to-page">Go to page</li>
                                    <li class="page-item px-2"><input type="text" class="form-control-sm border page-box" id="page-no"> </li>
                                    <li class="page-item py-1 ms-1"><a class="blue" href="javascript:void(0)">Go</a></li>
                                </ul>
            
                            </div> -->
            <!--Pagination end ./-->

        </div>
    </div>
</section>
<!-- Search Section Ends Here-->

@endsection
@push('script')
<script src="{{asset('js/jquery.simplePagination.js')}}"></script>
<script>
//$(document).ready(function() {
//only for product search result page:
$("#breadcrumb-section-auth-page").css("display", "none");
$("#breadcrumb-section-search-page").css("display", "block");
//});
</script>
<script>
    $(document).ready(function () {
        //Filter onChange:
        $("#fs_type").on('change', function () {
            //            var fs_type = this.value;
            //            var fs_type_filter = `<div class="search-wrap col-12 col-sm-12 col-md-2 mb-3">
            //                                    <input required class="search-field search-field-fourth bg-light" value="${fs_type}">
            //                                    <span class="search-clear-4 search-clear text-end">x</span>
            //                                </div>`;
            //            $("filterDisplayDivAfter").after(fs_type_filter).append();
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

        $(document).on('click','.clear-all',function (e) {
            $(document).find('#fs_language').val('');
            $(document).find('#fs_grade').val('');
            $(document).find('#fs_subject').val('');
            $(document).find('#fs_price').val('');
            $(document).find('#fs_type').val('');
            $(document).find('#fs_format').val('');
            $(document).find('input[name="search_keyword"]').val('');
            $(document).find('body #fs_format_filter_div').html('');
            $(document).find('body #fs_type_filter_div').html('');
            $(document).find('body #fs_price_filter_div').html('');
            $(document).find('body #fs_subject_filter_div').html('');
            $(document).find('body #fs_language_filter_div').html('');
            $(document).find('body #fs_grade_filter_div').html('');
            $(document).find('body #fs_searchkeyword_filter').html('');
            $('form#productFilterSearchForm').trigger('submit');

        });


    });
</script>
<script>

    $(document).ready(function () {
        //var filter_form = $('form[name="productFilterSearchForm"]');
        //var search_form = $('form[name="productSearchForm"]').serializeArray();
        var filter_form = $('#productFilterSearchForm, #productSearchForm');
        var role_id = "{{ (auth()->user() != null) ? auth()->user()->role_id  : 0 }}";
        //show filters
        var select_fs_language = $("#fs_language").val();
        var langVal = $('#fs_language').children('option:selected').data('lang');
        var select_fs_grade = $("#fs_grade").val();
        var gradeVal = $('#fs_grade').children('option:selected').data('grade');
        var select_fs_subject = $("#fs_subject").val();
        var subjectVal = $('#fs_subject').children('option:selected').data('subject');
        var select_fs_price = $("#fs_price").val();
        var priceVal = $('#fs_price').children('option:selected').data('price');
        var select_fs_type = $("#fs_type").val();
        var typeVal = $('#fs_type').children('option:selected').data('resource');
        var select_fs_format = $("#fs_format").val();
        var search_keyword = $("form#productFilterSearchForm input[name='search_keyword']").val();

        if(search_keyword !== '' ){
            $('#fs_searchkeyword_filter').remove();
            var fs_searchkeyword_filter = `<div class="search-wrap mb-3" id="fs_searchkeyword_filter">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${search_keyword}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_searchkeyword">x</span>
                                    </div>`;
            $("#filterDisplayDivAfter").after(fs_searchkeyword_filter).append();
        }

        if (select_fs_language !== '') {
            $('#fs_language_filter_div').remove();
            var fs_language_filter = `<div class="search-wrap  mb-3" id="fs_language_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${langVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_language">x</span>
                                    </div>`;
            $("#filterDisplayDivAfter").after(fs_language_filter).append();
        }
        if (select_fs_grade !== '') {
            $('#fs_grade_filter_div').remove();
            var fs_grade_filter = `<div class="search-wrap mb-3" id="fs_grade_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${gradeVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_grade">x</span>
                                    </div>`;
            $("#filterDisplayDivAfter").after(fs_grade_filter).append();
        }
        if (select_fs_subject !== '') {
            $('#fs_subject_filter_div').remove();
            var fs_subject_filter = `<div class="search-wrap  mb-3" id="fs_subject_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${subjectVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_subject">x</span>
                                    </div>`;
            $("#filterDisplayDivAfter").after(fs_subject_filter).append();
        }
        if (select_fs_price !== '') {
            $('#fs_price_filter_div').remove();
            var fs_price_filter = `<div class="search-wrap mb-3" id="fs_price_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${priceVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_price">x</span>
                                    </div>`;
            $("#filterDisplayDivAfter").after(fs_price_filter).append();
        }
        if (select_fs_type !== '') {
            $('#fs_type_filter_div').remove();
            var fs_type_filter = `<div class="search-wrap  mb-3" id="fs_type_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${typeVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_type">x</span>
                                    </div>`;
            $("#filterDisplayDivAfter").after(fs_type_filter).append();
        }
        if (select_fs_format !== '') {
            $('#fs_format_filter_div').remove();
            var fs_format_filter = `<div class="search-wrap  mb-3" id="fs_format_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${select_fs_format}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_format">x</span>
                                    </div>`;
            $("#filterDisplayDivAfter").after(fs_format_filter).append();
        }

        //Sort By Filter
        $(document).on('change','.sort-filter',function(e){
            e.preventDefault();
            $("#productFilterSearchForm input[name='sort-by']").val($(this).val());
            $("#productFilterSearchForm input[name='page']").val(1);
            getFilterProductsData(filter_form.serializeArray());
        });

        //Add to favourite:
        $(document).on('click', '.add-favourite', function (e) {
            if (role_id == 1) {
                e.preventDefault();
                var t = $(this);
                var product_id = $(this).data("prod_id");
                var act_product_id = $(this).data("act-prodid");
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
                        jQuery("ul li.add-favourite[data-act-prodid='"+act_product_id+"']").html('<a href="javascript:void(0)" class=""><i class="fas text-danger bg-white  fa-heart rounded-circle p-2 "></i></a>');
                        jQuery("ul li.add-favourite[data-act-prodid='"+act_product_id+"']").removeClass('add-favourite').addClass('remove-favourite');
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
                            swal.fire(xhr.responseJSON.message, "Please try again", "error");
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
                var t = $(this);
                var product_id = $(this).data("prod_id");
                var act_product_id = $(this).data("act-prodid");
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
                        jQuery("ul li.remove-favourite[data-act-prodid='"+act_product_id+"']").html('<a href="javascript:void(0)" class=""><i class="fal bg-white  fa-heart rounded-circle p-2 "></i></a>');
                        jQuery("ul li.remove-favourite[data-act-prodid='"+act_product_id+"']").removeClass('remove-favourite').addClass('add-favourite');
                        
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
                            swal.fire(xhr.responseJSON.message, "Please try again", "error");
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
        //Remove cart:
        $(document).on('click', '.remove-cart', function (e) {
            if (role_id == 1) {
                e.preventDefault();
                var t = $(this);
                var product_id = $(this).data("prod_id");
                var act_product_id = $(this).data("act-prodid");
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
                        jQuery("ul li.remove-cart[data-act-prodid='"+act_product_id+"']").html('<a href="javascript:void(0)" class=""><i class="fal bg-white  fa-shopping-cart rounded-circle p-2 "></i></a>');
                        jQuery("ul li.remove-cart[data-act-prodid='"+act_product_id+"']").removeClass('remove-cart').addClass('add-cart');
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
                            swal.fire(xhr.responseJSON.message, "Please try again", "error");
                        } else {
                            swal.fire('Unable to process your request', "Please try again", "error");
                        }
                    }
                });
            }
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
        function getFilterProductsData(filterData, search_form) {
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
                //if (item.is_paid_or_free != 'free') {
                    tbody_html += `<li class="mx-2 add-remove-cart-action ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_cart} ${remove_cart}" data-prod_id="${item._id}" data-act-prodid="${item.prod_id}"><a href="javascript:void(0)"><i class="${is_cart} fa-shopping-cart rounded-circle p-2 "></i></a></li>`;
                //}
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


        if (select_fs_language == '' && select_fs_grade == '' && select_fs_subject == '' && select_fs_price == '' && select_fs_type == '' && select_fs_format == '' && search_keyword == '') {
            $("#clearFilterAll").css('display', 'none');
        }
        if (select_fs_language !== '' || select_fs_grade !== '' || select_fs_subject !== '' || select_fs_price !== '' || select_fs_type !== '' || select_fs_format !== '' || search_keyword !== '') {
            $("#clearFilterAll").css('display', 'inline-block');
        }
        
        $("#productSearchForm").on('submit', function (e) {
            e.preventDefault();
            $("#clearFilterAll").css('display', 'none');
            var select_fs_language = $("#fs_language").val();
            var select_fs_grade = $("#fs_grade").val();
            var select_fs_subject = $("#fs_subject").val();
            var select_fs_price = $("#fs_price").val();
            var select_fs_type = $("#fs_type").val();
            var select_fs_format = $("#fs_format").val();
            var search_keyword = $("#search_keyword").val();


            if (search_keyword == '') {
                $("#clearFilterAll").css('display', 'none');
            }
            if (search_keyword !== '') {
                $("#clearFilterAll").css('display', 'inline-block');
            }
            var productSearchForm = $("#productSearchForm");
            //Pagination function:
            $("#productSearchForm").find("input[name='page']").val(1);//important
            getFilterProductsData(productSearchForm.serializeArray());
        });
        $("#productFilterSearchForm").on('submit', function (e) {
            e.preventDefault();
            $("#clearFilterAll").css('display', 'none');
            var select_fs_language = $("#fs_language").val();
            var langVal = $('#fs_language').children('option:selected').data('lang');
            var select_fs_grade = $("#fs_grade").val();
            var gradeVal = $('#fs_grade').children('option:selected').data('grade');
            var select_fs_subject = $("#fs_subject").val();
            var subjectVal = $('#fs_subject').children('option:selected').data('subject');
            var select_fs_price = $("#fs_price").val();
            var priceVal = $('#fs_price').children('option:selected').data('price');
            var select_fs_type = $("#fs_type").val();
            var typeVal = $('#fs_type').children('option:selected').data('resource');
            var select_fs_format = $("#fs_format").val();
            var search_keyword = $("form#productSearchForm1 input[name='search_keyword']").val();
            if (select_fs_language !== '') {
                $('#fs_language_filter_div').remove();
                var fs_language_filter = `<div class="search-wrap mb-3" id="fs_language_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${langVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_language">x</span>
                                    </div>`;
                $("#filterDisplayDivAfter").after(fs_language_filter).append();
            }
            if (select_fs_grade !== '') {
                $('#fs_grade_filter_div').remove();
                var fs_grade_filter = `<div class="search-wrap  mb-3" id="fs_grade_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${gradeVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_grade">x</span>
                                    </div>`;
                $("#filterDisplayDivAfter").after(fs_grade_filter).append();
            }
            if (select_fs_subject !== '') {
                $('#fs_subject_filter_div').remove();
                var fs_subject_filter = `<div class="search-wrap mb-3" id="fs_subject_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${subjectVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_subject">x</span>
                                    </div>`;
                $("#filterDisplayDivAfter").after(fs_subject_filter).append();
            }
            if (select_fs_price !== '') {
                $('#fs_price_filter_div').remove();
                var fs_price_filter = `<div class="search-wrap  mb-3" id="fs_price_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${priceVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_price">x</span>
                                    </div>`;
                $("#filterDisplayDivAfter").after(fs_price_filter).append();
            }
            if (select_fs_type !== '') {
                $('#fs_type_filter_div').remove();
                var fs_type_filter = `<div class="search-wrap  mb-3" id="fs_type_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${typeVal}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_type">x</span>
                                    </div>`;
                $("#filterDisplayDivAfter").after(fs_type_filter).append();
            }
            if (select_fs_format !== '') {
                $('#fs_format_filter_div').remove();
                var fs_format_filter = `<div class="search-wrap  mb-3" id="fs_format_filter_div">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${select_fs_format}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_format">x</span>
                                    </div>`;
                $("#filterDisplayDivAfter").after(fs_format_filter).append();
            }
            if(search_keyword !== ''){
                $('#fs_searchkeyword_filter').remove();
                var search_keyword_filter = `<div class="search-wrap  mb-3" id="fs_searchkeyword_filter">
                                        <input required class="search-field search-field-fourthh bg-light search-field-fs-type" value="${search_keyword}" readonly="">
                                        <span class="search-clear-44 search-clear text-end search-clear-fs-type removeFilterDiv" data-id="fs_searchkeyword">x</span>
                                    </div>`;
                $("#filterDisplayDivAfter").after(search_keyword_filter).append();
                $('form#productFilterSearchForm input[name="search_keyword"]').val(search_keyword);
            }

            if (select_fs_language == '' && select_fs_grade == '' && select_fs_subject == '' && select_fs_price == '' && select_fs_type == '' && select_fs_format == '' && search_keyword == '') {
                $("#clearFilterAll").css('display', 'none');
            }
            if (select_fs_language !== '' || select_fs_grade !== '' || select_fs_subject !== '' || select_fs_price !== '' || select_fs_type !== '' || select_fs_format !== '' || search_keyword !== '') {
                $("#clearFilterAll").css('display', 'inline-block');
            }


            //Search submit disabled:
            //        $("#filterSearchSubmitBtn").prop('disabled', true);
            var productFilterSearchForm = $("#productFilterSearchForm");

            //        var fs_type     =   productFilterSearchForm.find("#fs_type").val();
            //        $("#resourcesYouMayLikeContainer").empty();
            //        getFilterProductsViewMoreData(last_id='',fs_type);
            //Pagination function:
            $("#productFilterSearchForm").find("input[name='page']").val(1);//important
            getFilterProductsData(productFilterSearchForm.serializeArray());
        });

        $("#youMayLikeViewMore").click(function () {
            var element = document.getElementById('youMayLikeViewMore');
            var last_id = element.getAttribute('data-_id');
            var fs_type = $("#productFilterSearchForm").find("#fs_type").val();
            var fs_language = $("#productFilterSearchForm").find("#fs_language").val();
            var fs_grade = $("#productFilterSearchForm").find("#fs_grade").val();
            var fs_subject = $("#productFilterSearchForm").find("#fs_subject").val();
            var fs_price = $("#productFilterSearchForm").find("#fs_price").val();
            var fs_format = $("#productFilterSearchForm").find("#fs_format").val();
            var search_keyword = $("#productSearchForm").find("#search_keyword").val();

            //        $('#youMayLikeViewMore').html('Loading...');
            getFilterProductsViewMoreData(last_id, fs_type, fs_language, fs_grade, fs_subject, fs_price, fs_format, search_keyword);
        });


        function getFilterProductsViewMoreData(last_id = '', fs_type = '', fs_language = '', fs_grade = '', fs_subject = '', fs_price = '', fs_format = '', search_keyword = '', sortby = '') {
            $.ajax({
                url: "{{route('product.filterSearch.get')}}",
                type: "POST",
                data: {_id: last_id, fs_type: fs_type, fs_language: fs_language, fs_grade: fs_grade, fs_subject: fs_subject, fs_price: fs_price, fs_format: fs_format, search_keyword: search_keyword},
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

            tbody_html = `<div class="col-6 col-sm-6 col-lg-3 ">
                            <div class="box position-relative ">`;
            if(item.is_sale == 1){
                tbody_html += `<span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>`;
            }
            tbody_html +=`<a href="${product_url}" ><img src="${item.main_image}" class="img-fluid " alt="Book-10 "></a>
                                <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute ">
                                    <li class="mx-2 ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_favourite} ${remove_favourite}" data-prod_id="${item._id}" data-act-prodid="${item.prod_id}"><a href="#" class=""><i class="${is_favourite} fa-heart rounded-circle p-2 "></i></a></li>`;
            // if (item.is_paid_or_free != 'free') {
                tbody_html += `<li class="mx-2 ${(item.auth_user === false ? ' memberLogin ' : '')} add-remove-cart-action ${add_cart} ${remove_cart}" data-prod_id="${item._id}" data-act-prodid="${item.prod_id}"><a href="javascript:void(0)"><i class="${is_cart} fa-shopping-cart rounded-circle p-2 "></i></a></li>`;
            // }
            tbody_html += `</li>
                                </ul>
                            </div>
                            <p class="pt-4 fw-bold mb-0 "><a href="${product_url}" >${item.product_title}</a></p>`;
            if (item.is_paid_or_free == 'free') {
                tbody_html += `<span class="badge bg-success">Free</span>`;
            } else {
                tbody_html += `<span class="d-inline-block price py-2 px-0 ">$${item.single_license}</span>
                                    <span class="price-line-through p-0 ">${item.multiple_license}</span>`;
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
            //    $('#resourcesYouMayLikeContainer').append(tbody_html);
            $('#filterProductContainerPagination').append(tbody_html);
        });
    }
   

    $(document).on('click', '.removeFilterDiv', function () {
        var selectedDiv = $(this).data('id');
        switch (selectedDiv) {
            case 'fs_language':
                $('#fs_language').val('');
                break;
            case 'fs_grade':
                $('#fs_grade').val('');
                break;
            case 'fs_subject':
                $('#fs_subject').val('');
                break;
            case 'fs_price':
                $('#fs_price').val('');
                break;
            case 'fs_type':
                $('#fs_type').val('');
                break;
            case 'fs_format':
                $('#fs_format').val('');
                break;
            case 'fs_searchkeyword':
                $('input[name="search_keyword"]').val('');
                break;
        }
        $(this).parent().remove();
        $('#filterSearchSubmitBtn').trigger('click');
    });
</script>

@endpush