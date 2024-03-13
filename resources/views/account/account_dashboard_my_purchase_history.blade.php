@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
@include('modal.reportproduct_modal')
<?php if (Session::has('error')) {?>
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
<!--My Purchase History Section Starts Here-->
<section class="my_purchase_history_section1 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 col-sm-12 py-4">
                <h1 class="text-uppercase pt-3"> My Purchase History</h1>
            </div>

            <div class="col-12 col-sm-12 col-lg-6 pt-5">
                <div class="text-end pb-5 my_purchase_history-right">
                    <a href="{{route('account.dashboard')}}" class="blue acc-dashboard"><img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1" alt="">Account Dashboard</a>
                </div>
            </div>
        </div>
        <?php
            if (Session::has('paysuccess')) {
        ?>
            <div class="row">
                <h4 class="text-uppercase pb-2">Purchase Confirmation: {{Session::get("paysuccess")}}</h4>
                <p>
                    Thank you for your purchase!<br>
                    A confirmation email will be sent to your nominated email address which will include your receipt.<br> You can now access your resources by using the links below OR through your Account Dashboard.
                </p>
            </div>
        <?php
            }
        ?>
        <div class="row pb-5">
            <div class="col-12 col-sm-12 col-lg-4">
                <form action="" method="post" name="purchaseHistoryForm" id="purchaseHistoryForm">
                    @csrf
                    <input type="hidden" name="page" value="1" >
                    <div class="search my-purchase-history"> 
                        <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Search My Purchase"> 
                        <button class="btn-hover" id="purchaseHistorySubmit"> <i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-sm-12 col-lg-8 sort-section d-md-flex align-items-center justify-content-lg-end mt-4 mt-lg-0">
                <div class=" d-flex flex-row align-items-center me-3 sort-section-box">
                    <p class="mb-0 px-2 text-muted">Type</p>
                    <select class="form-select bg-light w-auto fw-boldQ " name="sort_by_type" id="sort_by_type">
                        <option value="" selected disabled="">Type</option>
                        <?php
                        $productFileTypeArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductType();
                        ?>
                        @foreach($productFileTypeArr as $productFileType)
                        <option value="{{$productFileType}}">{{$productFileType}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex flex-row align-items-center me-3 sort-section-box">
                    <p class="mb-0 px-2 text-muted">Price</p>
                    <select class="form-select bg-light fw-boldQ px-2" name="sort_by_price" id="sort_by_price" aria-label="Default select example" style="width:125px;">
                        <option value="" selected disabled="">Price</option>
                        <option value="free">Free</option>
                        <option value="under5">Under $5</option>
                        <option value="5-10">$5 - $10</option>
                        <option value="over10">Over $10</option>
                    </select>
                </div>
                <div class="d-flex flex-row align-items-center sort-section-box">
                    <p class="mb-0 px-2 text-muted">Sort</p>
                    <select class="form-select bg-light px-2 fw-boldQ" name="sort_by_sort" id="sort_by_sort" aria-label="Default select example" style="width:170px;">
                        <option value="" selected disabled="">Sort By</option>
                        <option value="ascending">Price low to high</option>
                        <option value="descending">Price high to low</option>
                        <option value="rating">Rating</option>
                    </select>
                    <a href="{{ route('accountDashboard.myPurchaseHistory') }}" class="btn btn-primary bg-blue btn-md mx-2">Clear</a>
                </div>
            </div>
        </div>

        <div class="" id="purchaseHistoryItemsContainer"></div>

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
        </div>
        <!--Pagination end ./-->

    </div>
</section>
<!--My Purchase History Section Ends Here-->
@endsection

@push('script')
<script src="{{asset('js/jquery.simplePagination.js')}}"></script>
<script>
        $(".select2").select2({
            theme: "bootstrap-5",
        });

        $(document).ready(function () {
            var purchaseHistoryForm = $('form[name="purchaseHistoryForm"]');
            getPurchaseHistoryItemsData(purchaseHistoryForm.serializeArray());
            $(document).on('change', '#sort_by_type', function () {
                var sort_by_type = this.value;
                $("input[name='page']").val(1);
                $('form[name="purchaseHistoryForm"]').find('#sort_by_type').remove();
                if (sort_by_type !== '') {
                    $('form[name="purchaseHistoryForm"]').append("<input type='hidden' name='sort_by_type' id='sort_by_type' value='" + this.value + "'/>");
                }
                getPurchaseHistoryItemsData($('form[name="purchaseHistoryForm"]').serializeArray());
            });
            $(document).on('change', '#sort_by_sort', function () {
                var sort_by_sort = this.value;
                $("input[name='page']").val(1);
                $('form[name="purchaseHistoryForm"]').find('#sort_by_sort').remove();
                if (sort_by_sort !== '') {
                    $('form[name="purchaseHistoryForm"]').append("<input type='hidden' name='sort_by_sort' id='sort_by_sort' value='" + this.value + "'/>");
                }
                getPurchaseHistoryItemsData($('form[name="purchaseHistoryForm"]').serializeArray());
            });
            $(document).on('change', '#sort_by_price', function () {
                var sort_by_price = this.value;
                $("input[name='page']").val(1);
                $('form[name="purchaseHistoryForm"]').find('#sort_by_price').remove();
                if (sort_by_price !== '') {
                    $('form[name="purchaseHistoryForm"]').append("<input type='hidden' name='sort_by_price' id='sort_by_price' value='" + this.value + "'/>");
                }
                getPurchaseHistoryItemsData($('form[name="purchaseHistoryForm"]').serializeArray());
            });
            $('input[name="go_to_page"]').on("keydown", function (e) {
                var go_to_page = $('input[name="go_to_page"]').val();
                if (e.key === 'Enter') {
                    $("input[name='page']").val(go_to_page);
                    getPurchaseHistoryItemsData(purchaseHistoryForm.serializeArray());
                }
            });
            $('#goToPageGo').click(function (e) {
                var go_to_page = $('input[name="go_to_page"]').val();
                $("input[name='page']").val(go_to_page);
                getPurchaseHistoryItemsData(purchaseHistoryForm.serializeArray());
            });

            //But license
            $(document).on('click','.buy-license-share',function(e){
                e.preventDefault();
                var p = Number($(this).attr("data-single-license")).toFixed(2);
                var rarp = Number($(this).attr("data-multiple-license")).toFixed(2);
                $('#buyLicenseModal tbody').html('<tr><td>Original License</td><td class="single-license-price" data-single-license="'+p+'">$'+p+'</td></tr><tr><td>Additional licenses </td><td class="multiple-license-price">2 x $'+rarp+'</td></tr><tr><td>Total: </td><td class="total-price" data-price="'+rarp+'">$'+Number(rarp*2).toFixed(2)+'</td></tr>');
                $('#buyLicenseModal form input[name="quantity"]').val(1);
                $('#buyLicenseModal form input[name="product_id"]').val($(this).attr('data-product-id'));
                $("#buyLicenseModal strong.single-buy-license-to-share").html('$'+p);
                $("#buyLicenseModal strong.mutiple-buy-license-to-share").html('$'+rarp)
                ///$('#buyLicenseModal form input[type="submit"]').val('');
                $('#buyLicenseModal').modal('show');
            });

            //Purchase History Item search:
            /*$('input[name="product_name"]').on("keydown", function (e) {
             var product_name = $('input[name="product_name"]').val();
             if (e.key === 'Enter') {
             e.preventDefault();
             $("input[name='page']").val(1);
             getPurchaseHistoryItemsData(purchaseHistoryForm.serializeArray());
             }
             });*/
            $('#purchaseHistorySubmit').click(function (e) {
                e.preventDefault();
                var product_name = $('input[name="product_name"]').val();
                $("input[name='page']").val(1);
                getPurchaseHistoryItemsData(purchaseHistoryForm.serializeArray());
            });

            //Pagination data:
            function getPurchaseHistoryItemsData(filterData) {
                $.ajax({
                    url: "{{route('purchaseHistoryPaginate.get')}}",
                    type: 'POST',
                    data: filterData,
                    beforeSend: function (xhr) {
                        //$("#filterSearchSubmitBtn").prop('disabled', true);
                    }
                }).always(function () {
                    //filter_form.find("#filterSearchSubmitBtn").prop('disabled', false);
                    $('#purchaseHistoryViewMore').html('View More');
                }).done(function (response, status, xhr) {
                    if (response.data.length === 0) {
                        $('#purchaseHistoryViewMore').html('No Data Found');
                        $('#purchaseHistoryItemsContainer').append('<div style="text-align: center;"><p class="no-data btn btn-primary btn-hover px-4 py-2">No Data Found</p></div>')
                    }else{
                        $('.no-data').remove()
                    }
                    create_purchase_history_items_data(response);
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

            function create_purchase_history_items_data(response) {
                var purchaseHistoryData = response.data;
                var sr_no = response.from - 1;
                var tbody_html = purchaseHistoryData.length === 0 ? '' : '';
                if (purchaseHistoryData.length > 0) {

                }
                $.each(purchaseHistoryData, function (index, item) {
                    var ratingImg = "{{asset('images/Kath.jpg')}}";
                    var order_id = item.order_id;
                    var imgExt = ['jpg', 'jpeg', 'png', 'gif'];
                    var downloadbtn = `<a href="${item.product_file}" class="btn btn-primary bg-blue btn-lg px-4 me-md-2 text-uppercase btn-hover view-more " download="${item.product_title}">Download </a>`;
                    if(item.type == 'bundle'){
                        downloadbtn = `<a href="{{route('download.file')}}/${item._product_id}" class="btn btn-primary bg-blue btn-lg px-4 me-md-2 text-uppercase btn-hover view-more ">Download </a>`;
                    }
                    tbody_html += `<div class="row mb-5 position-relative">
                                <div class="col-12 col-sm-12 col-md-5 col-lg-3">`;
                    if ($.inArray(item.file_type, imgExt) == -1) {
                        var classes = 'image-lst';
                        if(item.recipient_email !== ""){
                            classes = '';
                        }
                        tbody_html += `<img src="${item.main_image}" class="img-fluid mb-4 mb-md-0 w-100 `+classes+`" alt="${item.product_title}">`;
                    } else {
                        tbody_html += `<i class="fa fa-file fa-4x"></i>`;
                    }
                    tbody_html += `</div>
                                <div class="col-12 col-sm-12 col-md-7 col-lg-9">
                                    <h4 class="text-uppercase pb-2">${item.product_title} </h4>

                                          <div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted "> Purchase Price : </label>
                                        <label class="form-label text-muted ps-2"> $${item.purchase_price} AUD</label>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start"> Purchase Date : </label>
                                        <label class="form-label text-muted ps-2"> ${item.purchase_date}</label>
                                    </div>`;
                    if(item.updated_date !== ""){
                        tbody_html  +=  `<div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start"> Updated Date : </label>
                                        <label class="form-label text-muted ps-2"> ${item.updated_date}</label>
                                    </div>`;
                    }
                    if(item.recipient_email !== ""){
                        tbody_html  +=  `<div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start"> Recipient Email : </label>
                                        <label class="form-label text-muted ps-2"> ${item.recipient_email}</label>
                                    </div>`;
                    }
                    if(item.from_name !== ""){
                        tbody_html  +=  `<div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start"> From : </label>
                                        <label class="form-label text-muted ps-2"> ${item.from_name}</label>
                                    </div>`;
                    }
                    if(item.seller_name !== "NA"){
                        tbody_html  +=   `<div class="d-flex flex-row align-items-center">
                                            <label class="form-label text-muted float-start w-110"> Seller :</label>
                                            <label class="form-label text-muted ps-2"><a href="${item.seller_link}">${item.seller_name}</a></label>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <label class="form-label text-muted float-start w-110">File Type : </label>
                                            <label class="form-label text-muted ps-2">  ${item.file_type}</label>
                                        </div>`;
                    tbody_html  +=  `<div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start w-110">Actions : </label>
                                        <label class="form-label text-muted float-start"><a class="text-success rate_review" data-order-id="` + item.order_id + `" data-product-id="` + item._product_id + `"><img src="{{asset('images/review.png')}}" alt="review" class="img-fluid me-2">Review</a> </label>
                                        <label class="form-label text-muted float-start"><a href="#" class="text-danger report-product" data-order-id="` + item.order_id + `" data-product-id="` + item._product_id + `" ><img src="{{asset('images/report.png')}}" alt="review" class="img-fluid mx-2">Report</a> </label>
                                    </div>

                                    <div class="row download-end">
                                    <div class="col-auto pt-3">
                                    ${downloadbtn}`;
                    if(item.invoice !== ''){
                        tbody_html += `<a href="${item.invoice}" class="btn btn-primary bg-blue btn-lg px-4 me-2 text-uppercase btn-hover generate-invoice" target="_blank">View invoice</small></a>`;
                    }
                    if(item.freeproduct !== 1){
                        tbody_html  += `<a href="#" class="btn btn-primary bg-blue btn-lg px-4 me-md-2 text-uppercase btn-hover buy-license-share" data-single-license="` + item.single_license + `" data-product-id="` + item._product_id + `" data-multiple-license="` + item.multiple_license + `">Buy More Licenses</small></a>`;    
                    }
                    /*                
                    if(item.freeproduct == 1){
                        
                    }   
                    else if(item.downloads_left == 0){
                        tbody_html  +=  `<a href="#" class="btn btn-primary bg-blue btn-lg px-4 me-md-2 text-uppercase btn-hover download-btn">Download<br></a>`;
                    }
                    else{
                        tbody_html  +=  `<a href="${item.product_file}" class="btn btn-primary bg-blue btn-lg px-4 me-md-2 text-uppercase btn-hover download-btn" data-order-id="${item._order_item_id}"" download>Download</a>`;
                    }
                    */
                    tbody_html  +=  `</div>
                                    </div>
                                        
                                </div>`;
                    }
                    tbody_html  += `</div></div>`;
                    $('#purchaseHistoryViewMore').attr('data-_id', item._order_item_id);
                });
                var from = (response.from == null || response.from == 'null' || response.from == 'NULL' || response.from == '') ? 0 : response.from;
                var to = (response.to == null || response.to == 'null' || response.to == 'NULL' || response.to == '') ? 0 : response.to;
                //    $('.entry_details').html(`Showing ${from} to ${to} of ${response.total} entries`);
                $('#purchaseHistoryItemsContainer').html(tbody_html);
                if (response.data.length === 0) {
                    $('#purchaseHistoryItemsContainer').append(`<div style="text-align: center;" ><p class="no-data btn btn-primary btn-hover px-4 py-2">No Data Found</p></div>`)
                }else{
                    $('.no-data').remove()
                }
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
                        getPurchaseHistoryItemsData(purchaseHistoryForm.serializeArray());
                    }
                });
            }

            $("#purchaseHistoryViewMore").click(function () {
                var element = document.getElementById('purchaseHistoryViewMore');
                var last_id = element.getAttribute('data-_id');
                var product_name = $('input[name="product_name"]').val();
                var sort_by_type = $('input[name="sort_by_type"]').val();
                var sort_by_sort = $('input[name="sort_by_sort"]').val();
                var sort_by_price = $('input[name="sort_by_price"]').val();
                //        $('#youMayLikeViewMore').html('Loading...');
                getPurchaseHistoryViewMoreData(last_id, product_name, sort_by_type, sort_by_sort, sort_by_price);
            });


            function getPurchaseHistoryViewMoreData(last_id = '', product_name = '', sort_by_type = '', sort_by_sort = '', sort_by_price = '') {
                $.ajax({
                    url: "{{route('showMore.purchaseHistory.get')}}",
                    type: "POST",
                    data: {_id: last_id, product_name: product_name, sort_by_type: sort_by_type, sort_by_sort: sort_by_sort, sort_by_price: sort_by_price},
                    beforeSend: function (xhr) {
                        $('#purchaseHistoryViewMore').html('Loading...');
                    }
                }).always(function () {
                    //$("#filterSearchSubmitBtn").prop('disabled', false);
                    $('#purchaseHistoryViewMore').html('View More');
                }).done(function (response, status, xhr) {
                    console.log(response);
                    if (response.data.length === 0) {
                        $('#purchaseHistoryViewMore').html('No Data Found');
                    } else {
                        create_purchase_history_item_view_more_data(response);
                        $('#purchaseHistoryViewMore').attr('data-_id', response.last_id);
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
            function create_purchase_history_item_view_more_data(response) {
                var purchaseHistoryData = response.data;

                var tbody_html = '';

                $.each(purchaseHistoryData, function (index, item) {
                    var ratingImg = "{{asset('images/Kath.jpg')}}";
                    var order_id = item.order_id;
                    var imgExt = ['jpg', 'jpeg', 'png', 'gif'];

                    tbody_html += `<div class="row mb-5 position-relative">
                                <div class="col-12 col-sm-12 col-md-5 col-lg-3">`;
                    if ($.inArray(item.file_type, imgExt) == -1) {
                        tbody_html += `<img src="${item.main_image}" class="img-fluid mb-4 mb-md-0 w-100 image-lst" alt="${item.product_title}">`;
                    } else {
                        tbody_html += `<i class="fa fa-file fa-4x"></i>`;
                    }
                    var downloadbtn = `<a href="${item.product_file}" class="btn btn-primary bg-blue btn-lg px-4 me-md-2 text-uppercase btn-hover view-more " download="${item.product_title}">Download </a>`;
                    if(item.type == 'bundle'){
                        downloadbtn = `<a href="{{route('download.file')}}/${item._product_id}" class="btn btn-primary bg-blue btn-lg px-4 me-md-2 text-uppercase btn-hover view-more ">Download </a>`;
                    }

                    tbody_html += `</div>
                                <div class="col-12 col-sm-12 col-md-7 col-lg-9">
                                    <h4 class="text-uppercase pb-2">${item.product_title} </h4>

                                          <div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted "> Purchase Price : </label>
                                        <label class="form-label text-muted ps-2"> $${item.purchase_price} AUD</label>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start"> Purchase Date : </label>
                                        <label class="form-label text-muted ps-2"> ${item.purchase_date}</label>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start w-110"> Sellers :</label>
                                        <label class="form-label text-muted ps-2"> ${item.seller_name} </label>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start w-110">File Type : </label>
                                        <label class="form-label text-muted ps-2">  ${item.file_type}</label>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <label class="form-label text-muted float-start w-110">Actions : </label>
                                        <label class="form-label text-muted float-start"><a class="text-success rate_review" data-order-id="` + item.order_id + `" data-product-id="` + item._product_id + `"><img src="{{asset('images/review.png')}}" alt="review" class="img-fluid me-2">Review</a> </label>
                                        <label class="form-label text-muted float-start"><a class="text-danger report-product" data-order-id="` + item.order_id + `" data-product-id="` + item._product_id + `"><img src="{{asset('images/report.png')}}" alt="review" class="img-fluid mx-2">Report</a> </label>
                                    </div>

                                    <div class="row download-end">

                                        <div class="col-auto pt-3">
                                            ${downloadbtn}
                                        </div>
                                    </div>

                                </div>
                            </div>`;
                    $('#purchaseHistoryItemsContainer').append(tbody_html);
                });
            }

            //rate & review modal
            $(document).on('click', '.rate_review', function () {
                var productId = $(this).data('product-id');
                var orderId = $(this).data('order-id');
                $('#product_id').val(productId);
                $('#order_id').val(orderId);
                $('#type').val(1);
                $("#review").val('');
                $("#review").css('border-color', '#ced4da');
                $.ajax({
                    url: "{{URL('/buyer/get-rate-review')}}",
                    type: 'POST',
                    data: {type: 1, order_id: orderId, product_id: productId, '_token': "{{ csrf_token() }}"},
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
                            swal.fire(xhr.responseJSON.message, "Please try again", "error");
                        } else {
                            swal.fire('Unable to process your request', "Please try again", "error");
                        }
                    }
                });
                $('#rateReviewModal').modal('show');
            });

            $(document).on('click','.report-product',function(e){
                e.preventDefault();
                var productId = $(this).data('product-id');
                var orderId = $(this).data('order-id');
                $('form#reportissue #product_id').val(productId);
                $('form#reportissue #order_id').val(orderId);
                $('#reportModal').modal('show');
            });

            $(document).on('submit','form#reportissue',function(e){
                e.preventDefault();
                var fd = $(this).serialize();
                $.ajax({
                    url: "{{URL('/buyer/issue-report')}}",
                    type: 'POST',
                    data: fd,
                    dataType: 'json',
                }).done(function (response, status, xhr) {
                    Swal.fire({
                            title: 'Done',
                            text: "{{ Session::get('success') }}",
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000,
                            //closeOnClickOutside: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });
                    setTimeout(function(){
                        location.reload();
                    },2000);
                   $("#reportModal").modal('hide'); 
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $("#rateReviewFormSubBtn").prop('disabled', false);
                    $("#rateReviewFormSubBtn").val('Submit');
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

            //Downloads
            /*
            $(document).on('click','.download-btn',function(e){
                
                var t = $(this);
                t.addClass('disabled');
                if($(this).data('download-left') > 0){
                    var ct = $(this).attr('data-download-left') - 1;
                    var itemid = $(this).attr('data-order-id');
                    var downloadlink = $(this).attr('href');
                    
                    $.ajax({
                        url: "{{route('change.orderitem.download')}}",
                        type: 'POST',
                        data: {orderitemid: itemid,quantity:ct,_token: '{{ csrf_token() }}'},
                    }).done(function (response, status, xhr) {
                        t.removeClass('disabled');
                        if (response.success == true) {
                            t.attr('data-download-left',ct);
                            t.html("Download <br><small>" + ct + " downloads left</small>")
                            t.removeClass('disabled');
                            if(ct == 0){
                                t.addClass('disabled');
                            }
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
                else{
                    e.preventDefault();
                }
            });
            */
        });
</script>
@endpush