@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
@include('modal.apply_gift_coupon_popup_modal')
@include('modal.apply_promotional_code_modal')

<?php if (Session::has('error')) {
    ?>
    <script>
        Swal.fire({
            title: 'Oops!',
            text: "{{ Session::get('error') }}",
            icon: 'error',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    </script>
<?php } if (Session::has('success')) { ?>
    <script>
        Swal.fire({
            title: 'Congratulations!',
            text: "{{ Session::get('success') }}",
            icon: 'success',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    </script>
<?php } ?>
<style type="text/css">
    ul.product-incr-decr.d-flex.flex-row.justify-content-start.ps-0.mb-0.disabled,ul.disabled {
        pointer-events: none;
    }
</style>
<!--My Cart Section Starts Here-->
<section class="my_cart_section pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12  col-sm-12 col-lg-12 py-4">
                <h1 class="text-uppercase pt-3"> My Cart</h1>
            </div>
        </div>

        <form class="" action="javascript:void(0)" method="POST" name="cartItemsForm" id="cartItemsForm">
            @csrf
            <input type="hidden" name="page" value="1" >
        </form>


        <div class="row pb-5 ">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="noDataFound"></div>
            <div class="col-12 col-sm-12 col-md-8 col-lg-8" id="cartItemsContainerPagination"></div>

            <!-- Cart Summary Section Starts-->
            <div id="sticky-sidebar" class="col-12 col-sm-12 col-md-4 col-lg-4 pb-5 order-summary-bg orderSummaryCheckoutContainer"></div>
            <!-- Cart Summary Section Ends-->
        </div>
    </div> <!-- Container ends-->



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
    <form action="{{ route('checkout.payment', ['id' => $enc_user_id]) }}" method="post" name="checkoutPaymentForm" id="checkoutPaymentForm">
        @csrf
        <input type="hidden" name="subscribed_plan_id" value="80">
        <input type="hidden" name="total_price" value="" id="price">
        <input type="hidden" name="quantity" value="" id="quantity">
        <input type="hidden" name="gift_code" value="" id="gift_code">
        <!-- <input type="hidden" name="gift_amount" value="" id="gift_amount"> -->
        <input type="hidden" name="promotional_code" value="" id="promotional_code">
        <!-- <input type="hidden" name="promotional_amount" value="" id="promotional_amount"> -->
        <!--<input type="hidden" name="checkout_price" value="60" id="checkout_price" />-->
        <!--<input type="submit" value="SUBSCRIBE" class="button subscribe-btn">-->
    </form>
</section>

<!--My Cart Section Ends Here-->
@endsection

@push('script')
<script src="{{asset('js/jquery.simplePagination.js')}}"></script>
<script>
        $(document).ready(function () {
            $(document).on('click', '#checkoutPayment', function (e) {
                e.preventDefault();
                var check = '';
                check = "<?php if(count($data["cards"])==0){ echo "no-card"; }?>";
                if(check == 'no-card'){
                    //No Card validation on cart
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please Add a card first',
                        animation: true,
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Add Card',
                        cancelButtonText: "CANCEL",
                        closeOnCancel: true,
                    }).then((result) => {
                        if (result['isConfirmed']) {
                            window.location.replace("{{url('/buyer/add-card')}}");
                        }
                    }); 
                }
                else{    
                    $("form[name='checkoutPaymentForm']").submit();
                }
            });

            var cartItemsForm = $('form[name="cartItemsForm"]');
            $('input[name="go_to_page"]').on("keydown", function (e) {
                var go_to_page = $('input[name="go_to_page"]').val();
                if (e.key === 'Enter') {
                    $("input[name='page']").val(go_to_page);
                    getCartItemsData(cartItemsForm.serializeArray());
                }
            });
            $('#goToPageGo').click(function (e) {
                var go_to_page = $('input[name="go_to_page"]').val();
                $("input[name='page']").val(go_to_page);
                getCartItemsData(cartItemsForm.serializeArray());
            });

            $(document).on('click', '.cart-item-remove', function (e) {
                e.preventDefault();

                var product_id = $(this).data("prod_id");

                $.ajax({
                    url: "{{route('removeCartItem')}}",
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
                        totalCartItemCount();
                        if(response.count === 0){
                            getCartItemsData(cartItemsForm.serializeArray(), "first-page");
                        }else{
                            cartItemsCheckoutGetData();
                            let page_no = Math.ceil(response.count/4);
                            let data = cartItemsForm.serializeArray();
                            for (var item in data){
                              if (data[item].name == "page") {
                                data[item].value = page_no;
                              }
                            }
                            getCartItemsData(data);
                        }

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
            //Cart items Checkout get data:
            function cartItemsCheckoutGetData() {
                var type = '';
                var typeval = '';
                if($('#gift_code').val()){
                    type = 'gift'
                    typeval = $('#gift_code').val();
                }
                else if($('#promotional_code').val()){
                    type = 'promotional';
                    typeval = $('#promotional_code').val();
                }
                $.ajax({
                    url: "{{route('checkout.cartItems.details')}}",
                    type: 'GET',
                    data: {_token: '{{ csrf_token() }}',type:type,val:typeval},
                    beforeSend: function (xhr) {
                        //$(".is-favourite").prop('disabled', true);
                    }
                }).always(function () {
                    //$(".is-favourite").prop('disabled', false);
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        $("#noDataFound").html('');
                        //var cForm    =   document.getElementById("checkoutPaymentForm");
                        if($('.checkout_price').val()){
                            $(".checkout_price").val(response.data.totalAmount);
                        }
                        else{
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'checkout_price',
                                class: 'checkout_price',
                                value: response.data.totalAmount
                            }).appendTo("form[name='checkoutPaymentForm']");
                        }
                        
                        //$("form[name='checkoutPaymentForm']").find("#price").val(response.data.totalAmount);
                        var htmlOrderSummary = `<div class="me-0 me-sm-0 me-md-0 my-cart-box pb-4">
                                                <ul class="order-summary-details px-3 border-bottom">
                                                    <h4 class="text-uppercase pb-3 fw-bold">Order Summary </h4>
                                                    <li>Items <span class="float-end">${response.data.totalCartItem} items</span></li>
                                                    <li>Price <span class="float-end" id="cartTotalAmt">$${response.data.totalAmount}</span></li>
                                                    `;
                        if(response.data.buyertax >0){
                            htmlOrderSummary +=`<li>Tax <span class="float-end" id="buyertax">$${response.data.buyertax}</span></li>`;
                        }
                        htmlOrderSummary    += `   <li>
                                                        <span class="blue">Total</span> <span class="float-end total-price blue" id="totalAmt">AUD &nbsp; $${response.data.totalAmountshow}</span>
                                                   </li>
                                                </ul>

                                                <div class="text-center col-12 "><button type="button" class="btn btn-primary bg-blue btn-lg px-3 my-3 me-md-2 text-uppercase btn-hover view-more" id="checkoutPayment">SECURE CHECK OUT</button></div>`;
                            
                            if(response.data.disabled == 1){
                               htmlOrderSummary += `<ul class="order-summary-list">`; 
                            }
                            else{
                               htmlOrderSummary += `<ul class="order-summary-list disabled">`; 
                            }
                                                    
                            if($('#gift_code').val().length > 0){
                                htmlOrderSummary += `<li><a id="useGiftCouponBtn" href="#" style="display:none;"><span><i class="fal fa-chevron-double-right pe-2 text-info"></i></span>Use a Gift Card</a><a id="remove-coupon" ><span><i class="fal fa-chevron-double-right pe-2 text-info"></i></span>Remove Coupon</a></li>`;
                            }else{
                                htmlOrderSummary += `<li><a id="useGiftCouponBtn" href="#"><span><i class="fal fa-chevron-double-right pe-2 text-info"></i></span>Use a Gift Card</a><a id="remove-coupon" style="display:none;"><span><i class="fal fa-chevron-double-right pe-2 text-info"></i></span>Remove Coupon</a></li>`;
                            }
                            if($('#promotional_code').val().length > 0){
                                htmlOrderSummary += `<li><a id="usePromotionalCouponBtn" href="#" style="display:none;"><span><i class="fal fa-chevron-double-right pe-2 text-info"></i></span>Use a Promotional Code</a><a id="remove-promotion"><span><i class="fal fa-chevron-double-right pe-2 text-info"></i></span>Remove Promotional Code</a></li>`;
                            }
                            else{
                                htmlOrderSummary += `<li><a id="usePromotionalCouponBtn" href="#"><span><i class="fal fa-chevron-double-right pe-2 text-info"></i></span>Use a Promotional Code</a><a id="remove-promotion" style="display:none;"><span><i class="fal fa-chevron-double-right pe-2 text-info"></i></span>Remove Promotional Code</a></li>`;
                            }
                            
                            htmlOrderSummary += `</ul>
                                                    <p class="order-summary-txt blue px-4 ps-sm-2 ps-md-4">Purchased resources can be instantly downloaded from your account.</p> 
                                                </div>
                                                <div class="dotted-bg"><img src="{{asset('images/order-summary-dot-bg.png')}}" alt="">
                                            </div>`;
                        $(".orderSummaryCheckoutContainer").html(htmlOrderSummary);
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

            $(document).on('click', '.add-favourite-on-cart', function (e) {
                e.preventDefault();

                var product_id = $(this).data("prod_id");

                $.ajax({
                    url: "{{route('addToFavourite')}}",
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
                        getCartItemsData(cartItemsForm.serializeArray());
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'Added to your Wishlist',
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
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: response.message,
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

            getCartItemsData(cartItemsForm.serializeArray(), "first-page");

            //Pagination data:
            function getCartItemsData(filterData,first="") {
                $.ajax({
                    url: "{{route('cartItemPaginate.get')}}",
                    type: 'POST',
                    data: filterData,
                    beforeSend: function (xhr) {
                        //$("#filterSearchSubmitBtn").prop('disabled', true);
                    }
                }).always(function () {
                    //filter_form.find("#filterSearchSubmitBtn").prop('disabled', false);
                    //            $('#favouriteItemsViewMore').html('View More');
                }).done(function (response, status, xhr) {
                    if (response.data.length === 0) {
                        //$('#favouriteItemsViewMore').html('No Data Found');
                        $(".orderSummaryCheckoutContainer").html('');
                        if(first != ''){
                            $("#noDataFound").html('<p class="text-center">Your cart is currently empty<br> <a href="{{route('classroom.index')}}" class="btn btn-primary bg-blue btn-lg px-4 mt-3 text-uppercase btn-hover">Keep shopping</a></p>');
                        }else{

                            $("#noDataFound").html('<p class="text-center btn btn-primary bg-blue btn-lg px-4 text-uppercase btn-hover">No Items</p>');
                        }
                    }
                    if (response.data.length > 0) {
                        cartItemsCheckoutGetData();
                        //                $("#bvbvb").html(response.data.length);

                    }else{
                        //$("a.prev").trigger('click');
                    }

                    create_favourite_items_data(response);
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
                if (favouriteData.length > 0) {

                }

                $.each(favouriteData, function (index, item) {
                    //Add to favourite:
                    var is_favourite = 'fal bg-white ';
                    var add_favourite = 'add-favourite';
                    var remove_favourite = '';
                    if (item.is_favourite === true) {
                        is_favourite = 'fas text-danger bg-white ';
                        add_favourite = '';
                        remove_favourite = ' remove-favourite ';
                    }

                    var ratingImg = item.store_logo;

                    if(item.type == 'product'){
                        tbody_html += `<div class="row  px-4 py-4 my-wishlist-box mb-5">

                                        <div class="col-12 col-sm-12 col-lg-4 position-relative">`;
                                        if(item.is_sale == 1){
                                            tbody_html += `<span class="sale-cart position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>`;
                                        }
                                       tbody_html += `<a href="${item.product_url}" ><img src="${item.main_image}" class="img-fluid mb-lg-0 mb-4 image-lst" alt="Santa"></a></div>
                                        <div class="col-12 col-sm-12 col-lg-8">
                                            <h4 class="text-uppercase pb-3 fw-bold">${item.product_title}</h4>

                                            <div class="d-flex flex-row align-items-center pe-4 float-start ">
                                                <img src="${ratingImg}" alt="Kath" class="img-fluid float-start wishlist-profile">
                                            </div>
                                            <div class="d-flex flex-column align-items-start ">
                                                <label class="form-label text-muted mb-0"> By the <b>${item.store_name}</b></label>`;
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
                                        </ul>
                                                </div>

                                                <p class="pt-3 mb-2 add-read-more-cart show-less-content-cart">${item.description}.</p>
                                                
                                                <div class="product-price-box w-100 d-flex align-items-center">`;
                        if (item.is_paid_or_free == 'free' && item.type == 'product') {
                            tbody_html += `<span class="badge bg-success">Free</span>`;
                        } else {
                            tbody_html += `<div class="price py-2 pe-4 itemPrice">`;
                            



                            tbody_html += item.quantity > 1 ? `$${(item.multiple_license * item.quantity).toFixed(2)}` : `$${(item.single_license * item.quantity).toFixed(2)}`;
                            if(item.is_sale == 1){
                                tbody_html += item.quantity > 1 ? `<span class="price-line-through p-0 ">$${(item.actual_multiple_license * item.quantity).toFixed(2) }</span>`:`<span class="price-line-through p-0 ">$${(item.actual_single_license * item.quantity).toFixed(2) }</span>`;
                            }
                            tbody_html += `<span class="text-muted dollar">AUD</span></div>`;
                        }
                        if(item.is_paid_or_free == 'paid'){
                             tbody_html += `<ul class="product-incr-decr d-inline-flex justify-content-start  ps-0 mb-0">
                                        <li style="cursor:pointer;" class=" w-auto increaseQty" data-actual-multiple-license="` + item.actual_multiple_license+ `" data-actual-single-license="` + item.actual_single_license+ `" data-single-license="` + item.single_license + `" data-multiple-license="` + item.multiple_license + `" data-prod_id="`+item.product_id+`" data-is-sale="` +item.is_sale+ `">+</li>
                                        <li class="fw-bold itemQty w-auto">` + item.quantity + `</li>
                                        <li style="cursor:pointer;" class=" w-auto decreaseQty" data-actual-multiple-license="` + item.actual_multiple_license+ `" data-actual-single-license="` + item.actual_single_license+ `" data-single-license="` + item.single_license + `" data-multiple-license="` + item.multiple_license + `" data-prod_id="`+item.product_id+`" data-is-sale="` +item.is_sale+ `">-</li>
                                    </ul>`;
                        }
                       
                        tbody_html +=   `</div>
                                            <div class="d-flex align-items-center mt-2">
                                                <label class="form-label text-muted"><a href="javascript:void(0)" data-prod_id="${item.product_id}" class="wishlist-heart-icon fw-bold pe-3 add-favourite-on-cart move-wish"><img src="{{asset('images/heart-wishlist.png')}}" alt="heart-wishlist" class="img-fluid  pe-2 "> ${(item.is_favourite === true ? 'Added to Wishlist' : 'Move to Wishlist')}</a></label>
                                                <label class="form-label text-muted "><a href="javascript:void(0)" data-prod_id="${item.product_id}" class="text-danger cart-item-remove text-remove"><i class='fal fa-minus-circle pe-1'></i>Remove</a></label> 
                                            </div>

                                            </div>
                                        </div>`;
                    }
                    else{
                         tbody_html += `<div class="row  px-4 py-4 my-wishlist-box mb-5">
                                   
                                        <div class="col-12 col-sm-12 col-lg-4"><a href="${item.product_url}" ><img src="${item.main_image}" class="img-fluid mb-lg-0 mb-4" alt="Santa"></a></div>
                                        <div class="col-12 col-sm-12 col-lg-8">
                                            <h4 class="text-uppercase pb-3 fw-bold">Classroom Copy Gift Card</h4>
                                            <div class="d-flex flex-column align-items-start ">`;
                        tbody_html += `</div>
                                                <div class="product-price-box w-100">`;
                        if (item.is_paid_or_free == 'free' && item.type == 'product') {
                            tbody_html += `<span class="badge bg-success">Free</span>`;
                        } else {
                            tbody_html += `<div class="price py-2 pe-4 itemPrice">$${item.single_license} <span class="text-muted dollar">AUD</span></div>`;
                        }
                        tbody_html += `</div>
                                        <p class="text-muted mb-3"><span><b>Recipients :</b> ${item.recipient_email}</span></p>
                                        <div class="d-flex align-items-center mt-2">
                                        <label class="form-label text-muted pe-3"><a href="${item.gift_card_id}" data-prod_id="${item.product_id}" class="wishlist-heart-icon move-wish"><i class="fa fa-pencil pe-2" aria-hidden="true"></i>Edit</a></label>
                                        <label class="form-label text-muted "><a href="javascript:void(0)" data-prod_id="${item.product_id}" class="text-danger cart-item-remove text-remove"><i class='fal fa-minus-circle pe-2'></i>Remove</a></label> 
                                        </div>
                                            </div>
                                        </div>`;
                    }
                    
                                    //        $('#favouriteItemsViewMore').html();                 
                });
                var from = (response.from == null || response.from == 'null' || response.from == 'NULL' || response.from == '') ? 0 : response.from;
                var to = (response.to == null || response.to == 'null' || response.to == 'NULL' || response.to == '') ? 0 : response.to;
                //    $('.entry_details').html(`Showing ${from} to ${to} of ${response.total} entries`);
                $('#cartItemsContainerPagination').html(tbody_html);
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
                        getCartItemsData(cartItemsForm.serializeArray());
                    }
                });
                AddReadMoreCart();
            }

            $(document).ready(function () {
                $(document).on('click', '#useGiftCouponBtn', function () {
                    $('#applyGiftCouponModal form#applyGiftCouponForm input[name="gift_coupon"]').val('');
                    $("#applyGiftCouponFormSubBtn").prop('disabled', false);
                    $("#applyGiftCouponFormSubBtn").val('Apply');
                    $('#applyGiftCouponModal').modal('show');
                });

                $(document).on('click', '#usePromotionalCouponBtn', function () {
                    $('#applyPromotionalCouponModal form#applyPromotionalCouponForm input[name="promotional_coupon"]').val('');
                    $("#applyPromotionalCouponFormSubBtn").prop('disabled', false);
                    $("#applyPromotionalCouponFormSubBtn").val('Apply');
                    $('#applyPromotionalCouponModal').modal('show');
                });
                //increase quantity
                $(document).on('click', '.increaseQty', function () {
                    var t = $(this);
                    var itemPrice = $(this).parent().siblings('.itemPrice');
                    var qtyEle = $(this).siblings('.itemQty');
                    var singlePrice = $(this).data('single-license');
                    var actualsinglePrice = $(this).data('actual-single-license');
                    var actualmultiplePrice = $(this).data('actual-multiple-license');
                    var multiplePrice = $(this).data('multiple-license');
                    var total = $.trim($('#cartTotalAmt').html().replace('$', ''));
                    var qty = parseInt(qtyEle.html());
                    var product_id = $(this).data('prod_id');
                    var qty = qty + 1;
                    if (qty == 1) {
                        total = parseFloat(total) + parseFloat(singlePrice);
                    } else {
                        $(".product-incr-decr").addClass('disabled');
                        total = (Math.round((parseFloat(total) + parseFloat(multiplePrice)) * 100) / 100).toFixed(2);
                        $.ajax({
                            url: "{{route('change.quantity.cart')}}",
                            type: 'POST',
                            data: {product_id: product_id,quantity:qty,type:'add' ,_token: '{{ csrf_token() }}'},
                        }).done(function (response, status, xhr) {
                            $(".product-incr-decr").removeClass('disabled');
                            if (response.success == true) {
                                qtyEle.html(qty);
                                $('#cartTotalAmt').html('$' + total);
                                $('#totalAmt').html('$' + total + ' AUD');
                                $('input[name=checkout_price]').val(total);
                                $('input[name=quantity]').val(qty);
                                if(t.data('is-sale') == 1){
                                    t.parent().prev('.itemPrice').html('$'+ (qty*parseFloat(multiplePrice)).toFixed(2)+'<span class="price-line-through p-0 ">$'+(qty*actualmultiplePrice).toFixed(2)+'</span><span class="text-muted dollar">AUD</span>') 
                                }
                                else{
                                    t.parent().prev('.itemPrice').html('$'+ (qty*parseFloat(multiplePrice)).toFixed(2)+'<span class="text-muted dollar">AUD</span>') 
                                }
                                
                                cartItemsCheckoutGetData();
                            }else{
                                swal.fire("Oops", "Something Wrong happens", "error");
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
                //decrease quantity
                $(document).on('click', '.decreaseQty', function () {
                    var t  = $(this);
                    var itemPrice = $(this).parent().siblings('.itemPrice');
                    var qtyEle = $(this).siblings('.itemQty');
                    var singlePrice = $(this).data('single-license');
                    var actualsinglePrice = $(this).data('actual-single-license');
                    var actualmultiplePrice = $(this).data('actual-multiple-license');
                    var multiplePrice = $(this).data('multiple-license');
                    var total = $.trim($('#cartTotalAmt').html().replace('$', ''));
                    var qty = parseInt(qtyEle.html());
                    var product_id = $(this).data('prod_id');
                    if (qty == 1) {
                        //itemPrice.html('$ ' + singlePrice + ' <span class="text-muted dollar">AUD</span>');
                        total = parseFloat(singlePrice);
                    } else {
                        var qty = qty - 1;
                        total = (Math.round((parseFloat(total) - parseFloat(multiplePrice)) * 100) / 100).toFixed(2);
                        $(".product-incr-decr").addClass('disabled');
                        $.ajax({
                            url: "{{route('change.quantity.cart')}}",
                            type: 'POST',
                            data: {product_id: product_id,quantity:qty,type:'remove' ,_token: '{{ csrf_token() }}'},
                        }).done(function (response, status, xhr) {
                            $(".product-incr-decr").removeClass('disabled');
                            if (response.success == true) {
                                qtyEle.html(qty);
                                $('#cartTotalAmt').html('$' + total);
                                $('#totalAmt').html('$' + total + ' AUD');
                                $('input[name=checkout_price]').val(total);
                                $('input[name=quantity]').val(qty);
                                if(t.data('is-sale') == 1){
                                    if(qty >1 ){
                                        t.parent().prev('.itemPrice').html('$'+ (qty*parseFloat(multiplePrice)).toFixed(2)+'<span class="price-line-through p-0 ">$'+(qty*actualmultiplePrice).toFixed(2)+'</span><span class="text-muted dollar">AUD</span>')
                                    }else{
                                        t.parent().prev('.itemPrice').html('$'+ (qty*parseFloat(singlePrice)).toFixed(2)+'<span class="price-line-through p-0 ">$'+(qty*actualsinglePrice).toFixed(2)+'</span><span class="text-muted dollar">AUD</span>');    
                                    }
                                     
                                }
                                else{
                                    if(qty >1 ){
                                        t.parent().prev('.itemPrice').html('$'+ (qty*parseFloat(multiplePrice)).toFixed(2)+'<span class="text-muted dollar">AUD</span>') 
                                    }else{
                                        t.parent().prev('.itemPrice').html('$'+ (qty*parseFloat(singlePrice)).toFixed(2)+'<span class="text-muted dollar">AUD</span>')   
                                    }
                                    
                                }    
                                cartItemsCheckoutGetData(); 
                            }else{
                                swal.fire("Oops", "Something Wrong happens", "error");
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
            });
        });
</script>
<script>
   function AddReadMoreCart() {
      var carLmtcart = 100;
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