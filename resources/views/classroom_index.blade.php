<?php  
use Illuminate\Support\Facades\{
    Auth,
    Hash,
    DB,
    Mail,
    Storage,
    Redirect,
    Crypt,
    Validator
};
    if(isset($_GET['test'])){
        // $input = [];
        // $input['data'] = ['name'=>'denjdn','email'=>'dedfe@ded.com','grade'=>'ded','subject'=>'de','resourcetype'=>'ee','description'=>'ded'];
        // Mail::send('emails/sendnotificationbuyer', $input['data'], function ($message)use ($input) {
        //     $message->to('DeepanshS@scalacoders.com');
        //     $message->subject('def fef');
        // });
        $STRIPE_API_KEY = env('STRIPE_SECRET_KEY');

        $stripe = new \Stripe\StripeClient($STRIPE_API_KEY);
        
        // $stripeTransfer =   $stripe->charges->create(array(
        //                     'currency' => env('CURRENCY'),
        //                     'amount'   => 10000,
        //                     'source' => 'tok_bypassPending',
        //                     'description' => 'For test purpose adding balance and then sending money',
        //                 ));
        $stripeTransfer =   $stripe->transfers->create([
                            'amount'        => 0.66 * 100,
                            'currency'      => env('CURRENCY'),
                            'destination'   => 'acct_1NrVL7PLvXwniZsT',
                        ]);
    }
?> 
@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@push('specific_page_css')
<style type="text/css">
    .container {
        padding: 2rem 0rem;
    }

    @media (min-width: 576px){
        .modal-dialog {
            max-width: 400px;

            .modal-content {
                padding: 1rem;
            }
        }
    }

        .modal-header {
            .close {
                margin-top: -1.5rem;
            }
        }

        .form-title {
        margin: -2rem 0rem 2rem;
    }

        .btn-round {
            border-radius: 3rem;
        }

        .delimiter {
            padding: 1rem;  
        }

        .social-buttons {
            .btn {
                margin: 0 0.5rem 1rem;
            }
        }

        .signup-section {
            padding: 0.3rem 0rem;
        }
</style>
@endpush
@section('main_banner_section')
@include('layouts.partials.main_banner_section')
@endsection
@section('slider_section')
@include('layouts.partials.slider_section')
@endsection
@section('content')
<!--  -->
<section class="books-section pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-uppercase py-5"><span class="border px-5 py-2">Resources you may like</span></h2>
                <div id="resourcesYouMayLikeContainer" class="row"></div>
    
                <div class="text-center col-12"><button type="button" data-_id="0" id="youMayLikeViewMore" class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover">View More</button> </div>
            </div>
        </div>
        <div class="row">
            <h2 class="text-uppercase py-5"><span class="border px-5 py-2">Top Sellers</span></h2>
            <div id="top-sellers" class="row"></div>
            <input type="hidden" name="lastids[]">
            <!-- <div class="text-center col-12"><button type="button" id="topSellersviewmore" class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover">View More</button> </div> -->
        </div>
    </div>
</section>
@endsection
@section('testimonial_section')
@include('layouts.partials.testimonial_section')
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/owl.carousel2.thumbs@0.1.8/dist/owl.carousel2.thumbs.min.js"></script>
<script>
    $(document).ready(function () {
        if(window.location.hash == '#login')
        {
            $(".memberLogin").trigger('click');
        }
        $("#testimonial-slider").owlCarousel({
            items: 1,
             // itemsDesktop: [1000, 1],
            // itemsDesktopSmall: [979, 1],
            // itemsTablet: [768, 1],
           // dotsClass: 'owl-dots test',
            thumbsPrerendered: true,
            dots: false,
            thumbs: true,
            nav: false,
            navText: ["", ""],
            slideSpeed: 1000,
            autoplay: true,
            loop:true
        });

        // Back to Top Button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 20) {
                $('#toTopBtn').fadeIn();
            } else {
                $('#toTopBtn').fadeOut();
            }
        });

        $('#toTopBtn').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 1000);
            return false;
        });

        $(".shopnow").on('click',function(e){
            e.preventDefault();
            $("#filterSearchSubmitBtn").trigger('click');
        });
    });
</script>
<script>

    $(document).ready(function () {
        var role_id = "{{ (auth()->user() != null) ? auth()->user()->role_id  : 0 }}";
        getProductsTopSellers();
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
                            //swal.fire(xhr.responseJSON.message, "Please try again", "error");
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
                        totalCartItemCount();
                        jQuery("ul li.remove-cart[data-act-prodid='"+act_product_id+"']").html('<a href="javascript:void(0)" class=""><i class="fal bg-white  fa-shopping-cart rounded-circle p-2 "></i></a>');
                        jQuery("ul li.remove-cart[data-act-prodid='"+act_product_id+"']").removeClass('remove-cart').addClass('add-cart');
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
        getProductsResourcesYouMayLike('');

        $("#youMayLikeViewMore").click(function () {
            //        var last_id     = $(this).data('id');
            var element = document.getElementById('youMayLikeViewMore');
            var last_id = element.getAttribute('data-_id');

            $('#youMayLikeViewMore').html('Loading...');
            getProductsResourcesYouMayLike(last_id);
        });

        $("#topSellersviewmore").click(function () {
            var element = document.getElementById('topSellersviewmore');
            var last_id = element.getAttribute('data-_id');
            $('#topSellersviewmore').html('Loading...','viewmore');
            getProductsTopSellers(last_id);
        });
        function getProductsResourcesYouMayLike(last_id = '',event = 'resourcesimple') {
            //    $('#message_data').after('<div class="loading"></div>');
            $.ajax({
                url: "{{route('home.resourcesYouMayLike.get')}}",
                type: "POST",
                data: {_id: last_id},
                beforeSend: function (xhr) { }
            }).always(function () {

            }).done(function (response, status, xhr) {
                $('#youMayLikeViewMore').html('View More');
                if (response.data.length === 0) {
                    $('#youMayLikeViewMore').prop('disabled',true);
                    $('#youMayLikeViewMore').html('View More');
                } else {
                    if(event == 'resourcesimple'){
                        create_resourcesYouMayLike(response);
                    }else{
                        create_resourcesYouMayLikefavcart(response);
                    }
                    $('#youMayLikeViewMore').attr('data-_id', response.last_id);
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
    function getProductsTopSellers(last_id = '') {
        //    $('#message_data').after('<div class="loading"></div>');
        $.ajax({
            url: "{{route('home.getTopsellerproducts.get')}}",
            type: "POST",
            data: {_id: last_id},
            beforeSend: function (xhr) { }
        }).always(function () {

        }).done(function (response, status, xhr) {
            $('#topSellersviewmore').html('View More');
            if (response.data.length === 0) {
                $('#topSellersviewmore').prop('disabled',true);
                $('#topSellersviewmore').html('View More');
            } else{
                $('#topSellersviewmore').attr('data-_id', response.last_id);
                create_topsellers(response);
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
    //Create Products Resources You May Like:
    function create_resourcesYouMayLike(response) {
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
            tbody_html = '';
            tbody_html += `<div class="col-12 col-sm-6 col-lg-3 ">
                            <div class="box position-relative ">`;
            if(item.is_sale == 1){
                tbody_html += `<span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>`;
            }
            tbody_html += `<a href="${product_url}" ><img src="${item.main_image}" class="img-fluid " alt="Book-10 "></a>
                                <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute ">
                                    <li class="mx-2 add-remove-fav-action ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_favourite} ${remove_favourite}" data-prod_id="${item._id}" data-act-prodid="${item.prodid}"><a href="javascript:void(0)" class=""><i class="${is_favourite} fa-heart rounded-circle p-2 "></i></a></li>`;
                //if (item.is_paid_or_free != 'free') {
                    tbody_html += `<li class="mx-2 add-remove-cart-action ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_cart} ${remove_cart}" data-prod_id="${item._id}" data-act-prodid="${item.prodid}"><a href="javascript:void(0)"><i class="${is_cart} fa-shopping-cart rounded-circle p-2 "></i></a></li>`;
                //}
                tbody_html += `</li>
                                </ul>
                            </div>
                            <p class="resource-prod-title pt-4 fw-bold mb-0 "><a href="${product_url}" >${item.product_title}</a></p>`;
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
                    $('#resourcesYouMayLikeContainer').append(tbody_html); 
        });
    }
    function create_topsellers(response) {
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
            tbody_html = '';
            tbody_html += `<div class="col-12 col-sm-6 col-lg-3 ">
                            <div class="box position-relative ">`;
            if(item.is_sale == 1){
                tbody_html += `<span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>`;
            }
            tbody_html += `<a href="${product_url}" ><img src="${item.main_image}" class="img-fluid " alt="Book-10 "></a>
                                <ul class="icon-list d-flex flex-row list-unstyled align-items-center justify-content-center bottom-0 start-50 end-50 position-absolute ">
                                    <li class="mx-2 add-remove-fav-action ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_favourite} ${remove_favourite}" data-prod_id="${item._id}" data-act-prodid="${item.prodid}"><a href="javascript:void(0)" class=""><i class="${is_favourite} fa-heart rounded-circle p-2 "></i></a></li>`;
                // if (item.is_paid_or_free != 'free') {
                    tbody_html += `<li class="mx-2 add-remove-cart-action ${(item.auth_user === false ? ' memberLogin ' : '')} ${add_cart} ${remove_cart}" data-prod_id="${item._id}" data-act-prodid="${item.prodid}"><a href="javascript:void(0)"><i class="${is_cart} fa-shopping-cart rounded-circle p-2 "></i></a></li>`;
                // }
                tbody_html += `</li>
                                </ul>
                            </div>
                            <p class="resource-prod-title pt-4 fw-bold mb-0 "><a href="${product_url}" >${item.product_title}</a></p>`;
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
                    $('#top-sellers').append(tbody_html); 
        });
    }
</script>
@endpush