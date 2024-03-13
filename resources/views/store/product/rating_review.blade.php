@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>My Products</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{route('storeDashboard.productDashboard')}}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Product Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page title end  -->

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

<!-- products section start -->
<section class="help-faq-section products_dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <a href="{{route('storeDashboard.addProduct')}}" class="productaddcls">
                    <div class="card card-box border-0 text-center h-100 py-4">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_1 rounded-circle text-center mx-auto py-5">
                                <img src="{{asset('images/add-products-icon.png')}}" class="img-fluid" alt="store-dash-1">
                            </div>
                            <h4 class="pt-3 mb-2">Add Products</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="{{ URL('/store-dashboard/product-list') }}">
                    <div class="card card-box border-0 text-center h-100 py-4">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5">
                                <img src="{{asset('images/view-edit-icon.png')}}" class="img-fluid" alt="store-dash-1">
                            </div>
                            <h4 class="pt-3 mb-2">View / Edit Products</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="{{route('rating.review.list')}}">
                    <div class="card card-box border-0 text-center h-100 py-4">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5">
                                <img src="{{asset('images/rating-review-icon.png')}}" class="img-fluid" alt="store-dash-1">
                            </div>
                            <h4 class="pt-3 mb-2">Ratings / Reviews</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!--products section end  -->

<!-- view and edit table data section start -->
<section class="products-view-table">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h5 class="bg-blue text-uppercase text-center text-white p-3 mb-0"> Ratings / Reviews </h5>
                <?php if (count($data['result']) > 0) { ?>
                    <div class="view-table-box table-responsive rating-review-tb">
                        <table class="table align-middle mb-0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align: center;width:270px">User</th>
                                    <th style="text-align: center;width:160px;">Product Title</th>
                                    <th style="text-align: center;">Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                <?php } else {
                    ?>
                    <div class="text-center col-12 ">
                        <button type="button" class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover view-more">
                            No Data Found
                        </button>
                    </div>
                <?php } ?>
                <div class="row mt-4">
                    <div class="col">
                        <div class="pagination-box">
                            
                            <div class="container-fluid go-to-pagination">
                                <div class="row d-flex justify-content-center ">
                                    <div class="col-auto entry_details "></div>
                                    <div class="w-auto d-flex flex-row justify-content-center align-items-center pagination-box">
                                        <ul class="col-12 w-auto pagination_link pagination-sm" style="margin:0"></ul>
                                        <div class="col-auto go-to-page pe-3 ">Go to page</div>
                                        <div class="col-auto"><input type="text" class="form-control-sm border page-box" name="go_to_page" id="page-no"><a href="javascript:void(0)" id="goToPageGo" class="blue ps-2"> Go</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- view and edit table data section end -->
@endsection
@push('script')
<script src="{{asset('js/jquery.simplePagination.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        getStoreReviewData(1);
        $(document).on('click','#goToPageGo',function (e) {
            var go_to_page = $('input[name="go_to_page"]').val();
            getStoreReviewData(go_to_page);
        });
        $('input[name="go_to_page"]').on("keydown", function (e) {
            var go_to_page = $('input[name="go_to_page"]').val();
            if (e.key === 'Enter') {
                var go_to_page = $('input[name="go_to_page"]').val();
                getStoreReviewData(go_to_page);
            }
        });
        //Pagination data:
        function getStoreReviewData(page) {
            $.ajax({
                url: "{{route('review.storePaginate.get')}}",
                type: 'POST',
                data: {page:page, _token: '{{ csrf_token() }}'},
                beforeSend: function (xhr) {
                    
                }
            }).always(function () {

            }).done(function (response, status, xhr) {
                
                create_review_data(response);
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

        function create_review_data(response) {
            var productData = response.data;
            sr_no = response.from - 1;
            // if (productData.length == 0) {
            //     $('.pagination-box').css('display', 'none');
            // } else {
            //     $('.pagination-box').css('display', 'block');
            // }
            var tbody_html = productData.length === 0 ? '<td colspan="7" align="center"><p class="btn btn-hover btn-lg px-4 my-5 text-uppercase">No Data Found</p></td>' : '';
            if (productData.length > 0) {
                
            }
            $.each(productData, function (index, item) {
                
                var product_url = '{{ URL("/store-dashboard/product-details") }}';
                //product_url = product_url.replace(':id', item._id);
                product_url = product_url + "/" + item._id;
                tbody_html +=`<tr>
                                    <td>
                                        <div class="profile-title d-md-flex justify-content-between">
                                        <div class="date-pro">
                                            <p>
                                                <i class="fal fa-calendar me-2"></i> 
                                                ${item.ratingdate}
                                            </p>
                                        </div>
                                        </div>
                                        <div class="d-flex profile-img align-items-center">
                                            <div class="profile-img me-3">
                                                <img src="${item.userimg}" alt="profile" class="img-fluid">
                                            </div>
                                            <div class="text-start text-pro">
                                                <h6>${item.username}</h6>
                                                <div class="rating-icon d-flex align-items-center">
                                                    <ul class="rating d-flex flex-row justify-content-start ps-0 me-2 mb-0">`;
                    for (let i = 0; i < item.rating; i++) {
                            tbody_html += '<li><i class="fas fa-star text-yellow"></i></li>';
                    } 
                    for (let i = 0; i < item.ratingleft; i++) {
                            tbody_html += '<li><i class="fal fa-star text-muted"></i></li>';
                    }                                        
                    tbody_html  +=  `                   </ul>
                                                    <p>${item.rating} Rating</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="${item.product_link}">${item.product_title}</a>
                                    </td>
                                    <td>
                                       <p class="add-read-more-cart show-less-content-cart" style="text-align:left;">${ (item.review == null) ? '': item.review}</p>
                                    </td>
                                <tr>`;
            });
        
            var from = (response.from == null || response.from == 'null' || response.from == 'NULL' || response.from == '') ? 0 : response.from;
            var to = (response.to == null || response.to == 'null' || response.to == 'NULL' || response.to == '') ? 0 : response.to;
            //    $('.entry_details').html(`Showing ${from} to ${to} of ${response.total} entries`);
            $('table tbody').html(tbody_html);
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
                    getStoreReviewData(next_page);
                }
            });
            AddReadMoreRating();
        }
    });
    function AddReadMoreRating() {
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
</script>
@endpush