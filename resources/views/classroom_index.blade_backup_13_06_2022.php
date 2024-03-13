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
<section class="books-section pb-5">
    <div class="container">
        <div class="row">
            <h2 class="text-uppercase py-5"><span class="border px-5 py-2">Resources you may like</span></h2>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="box position-relative"><img src="images/Book-1.jpg" class="img-fluid" alt="Book-1">
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
                    <li><a href="#"><i class='fal fa-star'></i></a></li>
                </ul>

            </div>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="box  position-relative">
                    <span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>
                    <img src="images/Book-2.jpg" class="img-fluid" alt="Book-2">
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
                    <li><a href="#"><i class='fal fa-star'></i></a></li>
                </ul>
            </div>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="box position-relative"><img src="images/Book-3.jpg" class="img-fluid" alt="Book-3">
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
                    <li><a href="#"><i class='fal fa-star'></i></a></li>
                </ul>
            </div>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="box  position-relative">
                    <span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>
                    <img src="images/Book-4.jpg" class="img-fluid" alt="Book-4">
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
                    <li><a href="#"><i class='fal fa-star'></i></a></li>
                </ul>
            </div>
            <div class="text-center col-12"><button type="button" class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover">View More</button> </div>
        </div>

        <div class="row">
            <h2 class="text-uppercase py-5"><span class="border px-5 py-2">Top Sellers</span></h2>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="box  position-relative"><span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>
                    <img src="images/Book-5.jpg" class="img-fluid" alt="Book-5">
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
                    <li><a href="#"><i class='fal fa-star'></i></a></li>
                </ul>

            </div>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="box position-relative"><img src="images/Book-6.jpg" class="img-fluid" alt="Book-6">
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
                    <li><a href="#"><i class='fal fa-star'></i></a></li>
                </ul>
            </div>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="box position-relative"><span class="sale position-absolute top-0 left-100 translate-middle badge btn btn-danger bg-danger">SALE</span>
                    <img src="images/Book-7.jpg" class="img-fluid" alt="Book-7">
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
                    <li><a href="#"><i class='fal fa-star'></i></a></li>
                </ul>
            </div>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="box position-relative"><img src="images/Book-8.jpg" class="img-fluid" alt="Book-8">
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
                    <li><a href="#"><i class='fal fa-star'></i></a></li>
                </ul>
            </div>
            <div class="text-center col-12"><button type="button" class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover">View More</button> </div>
        </div>
    </div>
</section>


@endsection

@push('script')
<script>
$(document).ready(function() {
    $("#testimonial-slider").owlCarousel({
        items: 1,
        itemsDesktop: [1000, 1],
        itemsDesktopSmall: [979, 1],
        itemsTablet: [768, 1],
        pagination: true,
        navigation: false,
        navigationText: ["", ""],
        slideSpeed: 1000,
        autoPlay: true
    });

    // Back to Top Button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 20) {
            $('#toTopBtn').fadeIn();
        } else {
            $('#toTopBtn').fadeOut();
        }
    });

    $('#toTopBtn').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
        return false;
    });
});
</script>
@endpush
