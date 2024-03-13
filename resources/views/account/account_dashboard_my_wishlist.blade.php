@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--My Wishlist Section Starts Here-->
<section class="my_wishlist_section pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12  col-sm-12 col-lg-6 py-4">
                <h1 class="text-uppercase py-3"> My Wishlist</h1>
            </div>
            <div class="col-12  col-sm-12 col-lg-6 py-4">
                <div class="text-end pt-3">
                    <a href="{{route('account.dashboard')}}" class="blue acc-dashboard"><img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1" alt="">Account Dashboard</a>
                </div>
            </div>
        </div>

        <div class="row pb-5" id="noDataFound">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex flex-row align-items-center  mb-4">
                <span class="sort-relevancy fw-bold py-1 me-5">SORT BY</span>
                <select class="form-select bg-transparent w-auto sort-wishlist py-2" aria-label="Default select example">
                    <option value="1" selected>Recently Added</option>
                    <option value="2">Free</option>
                    <option value="3">Rating</option>
                    <option value="4">Price</option>
                </select>
            </div>


            <div class="col-12 col-sm-12 col-md-6 col-lg-6 pe-0">
                <div class="d-flex align-items-center">
                <div class="form-se w-100">
                <form class="" action="javascript:void(0)" method="POST" name="favouriteItemsForm" id="favouriteItemsForm">
                    @csrf
                    <input type="hidden" name="page" value="1" >
                    <input type="hidden" name="sort_by_filter" value="1">
                    <div class="search wishlist"> 
                        <input type="text" name="product_name" class="form-control" placeholder="Search Wish List"> <button id="favouriteItemSearch" class="btn-hover"> <i class="fa fa-search"></i></button> 
                    </div>

                </form>
                </div>
                <div class="clr" style="width:120px;text-align:right">
                <a href="{{route('accountDashboard.myWishlist')}}" class="btn btn-primary bg-blue btn-md mx-2">Clear</a>
                </div>
                </div>
            </div>
        </div>

        <!--            <form class="row g-3 align-items-center" action="javascript:void(0)" method="POST" name="favouriteItemsForm" id="favouriteItemsForm">-->

<!--                <input type="hidden" name="page" value="1" >
</form>-->
        <div id="favouriteItemsContainerPagination" class="text-center my-4"></div>




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

    </div> 
</section>
<!--My Wishlist Section Ends Here-->
@endsection

@push('script')
<script src="{{asset('js/jquery.simplePagination.js')}}"></script>
<script>
$(document).ready(function () {
    var favouriteItemsForm = $('form[name="favouriteItemsForm"]');
    var role_id = "{{ (auth()->user() != null) ? auth()->user()->role_id  : 0 }}";
    //Sort filter
    $("select.sort-wishlist").on('change',function(e){
        e.preventDefault();
        $('form#favouriteItemsForm input[name="sort_by_filter"]').val($(this).val());
        getFavouriteItemsData(favouriteItemsForm.serializeArray());
    });

    $('input[name="go_to_page"]').on("keydown", function (e) {
        var go_to_page = $('input[name="go_to_page"]').val();
        if (e.key === 'Enter') {
            $("input[name='page']").val(go_to_page);
            let data = favouriteItemsForm.serializeArray()
            data = formDataAppend(data,go_to_page);
            getFavouriteItemsData(data);
        }
    });
    $('#goToPageGo').click(function (e) {
        var go_to_page = $('input[name="go_to_page"]').val();
        $("input[name='page']").val(go_to_page);
        let data = favouriteItemsForm.serializeArray()
        data = formDataAppend(data,go_to_page);
        getFavouriteItemsData(data);
    });


    //Favourite Item search:
    $('input[name="product_name"]').on("keydown", function (e) {
        var product_name = $('input[name="product_name"]').val();
        if (e.key === 'Enter') {
            $("input[name='page']").val(1);
            getFavouriteItemsData(favouriteItemsForm.serializeArray());
        }
    });
    $('#favouriteItemSearch').click(function (e) {
        var product_name = $('input[name="product_name"]').val();
        $("input[name='page']").val(1);
        getFavouriteItemsData(favouriteItemsForm.serializeArray());
    });

    $(document).on('click', '.vafourite-item-remove', function (e) {
        e.preventDefault();

        var product_id = $(this).data("prod_id");

        //        return false;
        $.ajax({
            url: "{{route('removeFavourite')}}",
            type: 'POST',
            data: {product_id: product_id, _token: '{{ csrf_token() }}'},
            beforeSend: function (xhr) {
                //$(".is-favourite").prop('disabled', true);
                //                $(".add-remove-fav-action").css("pointer-events", 'none' );
            }
        }).always(function () {
            //$(".is-favourite").prop('disabled', false);
            //            $(".add-remove-fav-action").css("pointer-events", 'auto' );
        }).done(function (response, status, xhr) {
            if (response.success === true) {
                if(response.count === 0){
                    getFavouriteItemsData(favouriteItemsForm.serializeArray(), "first-page");
                }else{
                    getFavouriteItemsData(favouriteItemsForm.serializeArray());
                }
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
        if (role_id == 1) {
            e.preventDefault();
            var t = $(this);
            var product_id = $(this).data("prod_id");
            var act_product_id = $(this).data("act_prodid");
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
                                }
                            }).always(function () {
                                //$(".is-favourite").prop('disabled', false);
                                $(".add-remove-cart-action").css("pointer-events", 'auto');
                            }).done(function (response, status, xhr) {
                                if (response.success === true) {
                                    totalCartItemCount();
                                    jQuery("label.add-remove-cart-action[data-act_prodid='"+act_product_id+"']").html('<a href="javascript:void(0)" class="vafourite-item-remove"><i class="fas fa-shopping-cart pe-2"></i> Added To Cart</a>');
                                    jQuery("label.add-remove-cart-action[data-act_prodid='"+act_product_id+"']").removeClass('add-cart');
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
            var act_product_id = $(this).data("act_prodid");
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
                    jQuery("label.add-remove-cart-action[data-act_prodid='"+act_product_id+"']").html('<a href="javascript:void(0)" class="text-cart"><i class="fal fa-shopping-cart rounded-circle pe-2"> </i>Add to Cart</a>');
                    jQuery("label.add-remove-cart-action[data-act_prodid='"+act_product_id+"']").removeClass('remove-cart').addClass('add-cart');
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

    getFavouriteItemsData(favouriteItemsForm.serializeArray(), "first-page");

    //Pagination data:
    function getFavouriteItemsData(filterData,first="") {
        $.ajax({
            url: "{{route('favouriteItemPaginate.get')}}",
            type: 'POST',
            data: filterData,
            beforeSend: function (xhr) {
                //$("#filterSearchSubmitBtn").prop('disabled', true);
            }
        }).always(function () {
            //filter_form.find("#filterSearchSubmitBtn").prop('disabled', false);
            $('#favouriteItemsViewMore').html('View More');
        }).done(function (response, status, xhr) {
            if (response.data.length === 0) {
                $('#favouriteItemsViewMore').html('No Data Found');
                $(".orderSummaryCheckoutContainer").html('');
                $("#favouriteItemsContainerPagination").html('');
                if(first != ''){
                    $("#noDataFound").html('<p class="text-center">Your Wishlist is currently empty <br><a href="{{route('product.search.view')}}" class="btn btn-primary bg-blue btn-lg px-4 mt-3 text-uppercase btn-hover">Keep shopping</a></p>');
                }else{

                    $("#favouriteItemsContainerPagination").html('<p class="text-center btn btn-primary bg-blue btn-lg px-4 text-uppercase btn-hover  w-auto m-auto">No Items</p>');
                }
            }
            else{
                create_favourite_items_data(response);
                //$("#favouriteItemsContainerPagination").html('');
            }
            //create_favourite_items_data(response);
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

    function create_favourite_items_data(response) {
        var favouriteData = response.data;
        sr_no = response.from - 1;
        var tbody_html = favouriteData.length === 0 ? '' : '';
        if (favouriteData.length <= 0) {
           // tbody_html = '<p class="text-center btn btn-primary bg-blue btn-lg px-4 text-uppercase btn-hover  w-auto m-auto">No Items</p>';
        }
        $.each(favouriteData, function (index, item) {
            //Add to cart:
            var is_cart = 'fal bg-white ';
            var add_cart = 'add-cart';
            var content = '<a href="javascript:void(0)"><i class="fal fa-shopping-cart pe-2"> </i>Add to Cart</a>'
            var remove_cart = '';
            if (item.is_cart === true) {
                is_cart = 'fas text-danger bg-white ';
                add_cart = '';
                remove_cart = ' ';
                content = '<a href="javascript:void(0)" class="vafourite-item-remove"><i class="fas fa-shopping-cart pe-2"> </i>Added To Cart</a>'
            }

            var ratingImg = item.store_logo;
            tbody_html += `<div class="row py-4 px-4 my-wishlist-box">
                                <div class="col-12 col-sm-12  col-md-5  col-lg-3 position-relative">`;
                                if(item.is_sale == 1){
                                    tbody_html += `<span class="sale-cart position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>`;
                                }
                                tbody_html+= `<a href="${item.product_url}" ><img src="${item.main_image}" class="img-fluid mb-4 mb-md-0 w-100 image-lst" alt="charlie"></a></div>
                                <div class="col-12 col-sm-12  col-md-7  col-lg-9 text-start">
                                    <a href="${item.product_url}" class="text-uppercase pb-3 fw-bold text-black"><h4 class="text-uppercase pb-3 fw-bold">${item.product_title}</h4></a>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                                        <div class="me-3">
                                            <img src="${ratingImg}" alt="Kath" class="img-fluid wishlist-profile">
                                        </div>
                                        <div>
                                            <label class="form-label text-muted mb-0"><a href="${item.store_url}"><b>${item.store_name}</b></a></label>`;

            var productRating = item.rating;
            tbody_html += `<ul class="rating d-flex flex-row justify-content-start ps-0 pe-3 mb-0">`;
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
            tbody_html += `<li><p class="text-muted ps-2">` + productRating + ` rating</p></li>
            </ul></div>
                                        </div>
                                    </div>

                                    <p class="pt-3 mb-2 add-read-more-cart show-less-content-cart">${item.description}.</p>`;
            if (item.is_paid_or_free == 'free') {
                tbody_html += `<span class="badge bg-success mb-3 ">Free</span>`;
            } else {
                tbody_html += `<div class="price py-2">`;
                tbody_html += `$ ${item.single_license}`;
                if(item.is_sale == 1){
                    tbody_html += `<span class="price-line-through p-0 ">$${item.actual_single_license}</span>`;
                }
                tbody_html += ` <span class="text-muted dollar">USD</span></div>`;
            }
            tbody_html += `
            <div class="d-flex align-items-center mt-2"><label class="me-3 form-label text-muted d-block add-remove-cart-action pb-2 mb-0 ${add_cart} ${remove_cart}" data-prod_id="`+item.product_id+`" data-act_prodid="`+item.act_product_id+`">${content}</label>
            <label class="form-label text-muted d-block"><a href="javascript:void(0)" data-prod_id="${item.product_id}" class="text-danger vafourite-item-remove text-remove"><i class='fal fa-minus-circle pe-2'></i> Remove</a></label></div>
                                </div>
                            </div>`;
            $('#favouriteItemsViewMore').attr('data-_id', item._id);
        });
        var from = (response.from == null || response.from == 'null' || response.from == 'NULL' || response.from == '') ? 0 : response.from;
        var to = (response.to == null || response.to == 'null' || response.to == 'NULL' || response.to == '') ? 0 : response.to;
        //    $('.entry_details').html(`Showing ${from} to ${to} of ${response.total} entries`);
        $('#favouriteItemsContainerPagination').html(tbody_html);
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

                let data = formDataAppend(favouriteItemsForm.serializeArray(),next_page);
                getFavouriteItemsData(data);
            }
        });
        AddReadMoreWishlist();
    }

    $("#favouriteItemsViewMore").click(function () {
        var element = document.getElementById('favouriteItemsViewMore');
        var last_id = element.getAttribute('data-_id');
        var product_name = $('input[name="product_name"]').val();
//        $('#youMayLikeViewMore').html('Loading...');
        getFavouriteItemsViewMoreData(last_id, product_name);
    });


    function getFavouriteItemsViewMoreData(last_id = '', product_name = '') {
        $.ajax({
            url: "{{route('showMore.favouriteItem.get')}}",
            type: "POST",
            data: {_id: last_id, product_name: product_name},
            beforeSend: function (xhr) {
                $('#favouriteItemsViewMore').html('Loading...');
            }
        }).always(function () {
            //$("#filterSearchSubmitBtn").prop('disabled', false);
            $('#favouriteItemsViewMore').html('View More');
        }).done(function (response, status, xhr) {
            if (response.data.length === 0) {
                $('#favouriteItemsViewMore').html('No Data Found');
            } else {
                create_favourite_item_view_more_data(response);
                $('#favouriteItemsViewMore').attr('data-_id', response.last_id);
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

    //Create Favourite items View more data:
    function create_favourite_item_view_more_data(response) {
        var favouriteData = response.data;

        var tbody_html = '';

        $.each(favouriteData, function (index, item) {
            var ratingImg = "{{asset('images/Kath.jpg')}}";

            tbody_html = `<div class="row py-5 px-4 my-wishlist-box">
                                <div class="col-12 col-sm-12  col-md-5 col-lg-3"><a href="${item.product_url}" ><img src="${item.main_image}" class="img-fluid mb-4 w-100 image-lst" alt="charlie"></a></div>
                                <div class="col-12 col-sm-12  col-md-7 col-lg-9">
                                    <a href="${item.product_url}" class="text-uppercase pb-3 fw-bold text-black"><h4 class="text-uppercase pb-3 fw-bold">${item.product_title}</h4></a>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex text-start">
                                        <div class="me-3"><img src="${ratingImg}" alt="Kath" class="img-fluid wishlist-profile"></div>
                                        <div>
                                            <label class="form-label text-muted mb-0"> By the <b>Moffett Girl</b></label>`;
            var productRating = item.rating;
            tbody_html += `<ul class="rating d-flex flex-row justify-content-start ps-0 pe-3 mb-0">`;
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
            tbody_html += `<li><p class="text-muted ps-2">` + productRating + ` rating</p></li>
            </ul>    </div>
                                        </div>
                                    </div>

                                    <p class="pt-3 mb-2 add-read-more-cart show-less-content-cart">${item.description}.</p>`;
            if (item.is_paid_or_free == 'free') {
                tbody_html += `<span class="badge bg-success mb-3">Free</span>`;
            } else {
                tbody_html += `<div class="price py-2">$ ${item.single_license} <span class="text-muted dollar">USD</span></div>`;
            }
            tbody_html += `<label class="form-label text-muted d-block"><a href="#" class="text-danger text-remove"><i class='fal fa-minus-circle pe-2'></i> Remove</a></label>
                                </div>
                            </div>`;
            $('#favouriteItemsContainerPagination').append(tbody_html);
        });
    }
    function formDataAppend(data,value,key='page'){
        for (var item in data){
          if (data[item].name == key) {
            data[item].value = value;
          }
        }
        return data;
    }
});
function AddReadMoreWishlist() {
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
  $(document).on("click", ".read-more-cart", function () {
        if($(this).closest(".add-read-more-cart").hasClass('show-less-content-cart')){
            $(this).closest(".add-read-more-cart").removeClass('show-less-content-cart');
            $(this).closest(".add-read-more-cart").addClass('show-more-content-cart');
        }
        
     //$(this).closest(".add-read-more-cart").toggleClass("show-less-content-cart show-more-content-cart");
  }); 
  $(document).on("click", ".read-less-cart", function () {
        if($(this).closest(".add-read-more-cart").hasClass('show-more-content-cart')){
            $(this).closest(".add-read-more-cart").removeClass('show-more-content-cart');
            $(this).closest(".add-read-more-cart").addClass('show-less-content-cart');
        }
     //$(this).closest(".add-read-more-cart").toggleClass("show-less-content-cart show-more-content-cart");
  });
}
</script>
@endpush