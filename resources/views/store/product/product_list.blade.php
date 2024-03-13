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
<!-- search and sort section start -->
<section class="products_main pt-0">
    <div class="container">
        <form id="product-list-form">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5 col-md-6 col-sm-12 d-flex align-items-center">
                        <div class="search w-100"> 
                            <input type="text" name="search-text" class="form-control" placeholder="Search"> 
                            <button class="btn-hover search"> <i class="fa fa-search"></i></button> 
                        </div>        
                        <a href="{{ URL('/store-dashboard/product-list') }}" class="btn btn-primary bg-blue btn-md mx-2" width="100px">Clear</a>
     
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="right-sorting my-md-0 my-3">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="label-view me-3">
                                <h6 class="text-capitalize">
                                    Sort 
                                </h6>
                            </div>
                            <div class="sort w-100">
                                <select class="form-select" name="sortby">
                                    <option value="">Select Sort by</option>
                                    <option value="mrp" selected>Most Recently Posted</option>
                                    <option value="mru">Most Recently Updated</option>
                                    <option value="featured">Featured</option>
                                    <option value="az">A to Z</option>
                                    <option value="za">Z to A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="page">
            </div>
        </form>
    </div>
</section>
<!-- search and sort section end -->
<!-- view and edit table data section start -->
<section class="products-view-table">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if (count($data['result']) > 0) { ?>
                    <div class="view-table-box table-responsive">
                        <table class="table align-middle mb-0" id="product-list">
                            <tbody>
                                
                            </tbody>
                            <?php
                            /* 
                            foreach ($data['result'] as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <img src="{{ $row['main_image'] }}" alt="pro-1" class="img-fluid product_view_img">
                                    </td>
                                    <td class="title-tab">
                                        <a href="{{ URL('/store-dashboard/product-details').'/'.$row['_id'] }}">
                                            <h6>{{ $row['product_title'] }}</h6>
                                        </a>
                                        <p>Product Code: {{ $row['id']+100000 }} </p>
                                    </td>
                                    <td class="status-live text-center toggle-status" data-status="{{ $row['status']}}" data-product-id="{{$row['id']}}">
                                        <p>Status</p>
                                        <label class="switch_box mt-2 text-center">
                                            <input type="checkbox" class="switch_active" name="active" id="active-toggle" {{ $row['status'] == 1?'Checked':'' }}>
                                        </label>
                                        <small>{{ $row['status'] == 1?'Active':'In-Active' }}</small>
                                    </td>
                                    <td class="last-modified text-center">
                                        <p>Last Modified</p>
                                        <small>{{ date('m/d/Y',strtotime($row['updated_at'])) }}</small>
                                    </td>
                                    <td class="amount">
                                        <?php if ($row['is_paid_or_free'] == "free") { ?>
                                            <p>Free</p>
                                        <?php } else { ?>
                                            <p>${{ $row['single_license'] }} <span>$2.95</span></p>
                                        <?php } 
                                        ?>
                                        @if(isset($row['product_type']) && !empty($row['product_type']))
                                        <small>{{ ucfirst($row['product_type']) }}</small>
                                        @endif
                                    </td>
                                    <td class="sale-box">
                                        <span >SALE</span>
                                    </td>
                                    <td>
                                        <a href="{{ URL('/store-dashboard/update-product/').'/'.$row['id'] }}">
                                            <button type="button" class="edit-tab-btn me-3"><img src="{{asset('images/tab-edit-icon.png')}}" class="img-fluid me-1"> Edit</button>
                                        </a>
                                        <a>
                                            <button type="button" class="delete-tab-btn" data-product-id="{{$row['id']}}"><img src="{{asset('images/tab-delete.png')}}" class="img-fluid me-1">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                            */
                            ?>
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
        var filter_form = $('form#product-list-form');
        getStoreProductsData(filter_form.serializeArray());
        $(document).on('click','.toggle-status',function(e){
            e.preventDefault();
            var t = $(this);
            var cur_status = $(this).attr('data-status');
            var prod_id = $(this).attr('data-product-id');
            var inpuhtml  = '<input type="checkbox" id="activeinactive"/>';
            if(cur_status == 1){
                inpuhtml = '<input type="checkbox" id="activeinactive" checked/>';
            }
            $.ajax({
                    url: "{{route('changeproduct.status')}}",
                    type: 'POST',
                    data: {product_id: prod_id,status:cur_status ,_token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {
                        // Swal.fire({
                        //   title: "Updating...",
                        //   text: "Please wait",
                        //   showConfirmButton: false,
                        //   allowOutsideClick: false
                        // });
                    }
                }).done(function (response, status, xhr) {
                    Swal.fire({
                        title :(response.data == 1)?"Product Activated":"Product Deactivated",
                        timer: 1000,
                    });
                    if (response.success === true) {
                        /*
                        $.ajax({
                            url: "{{route('execute.jobs')}}",
                            type: 'POST',
                            data: {_token: '{{ csrf_token() }}'},
                        })*/
                        t.attr('data-status',response.data);
                        if(response.data == 1){
                            t.find('small').html('Active');
                            t.find('input.switch_active').prop('checked',true);
                        }else if(response.data == 0){
                            t.find('small').html('In-Active');
                            t.find('input.switch_active').prop('checked',false);
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
            /*
                Swal.fire({
                  title:'Make Product Active/Inactive',
                  html: '<p>Make Product Active/Inactive ' + inpuhtml + '<p/>' +
                        '<p>Notify Buyers<input type="checkbox" id="alertbuyer"/></p>',
                  confirmButtonText: 'Submit',
                  showCancelButton: true,
                  preConfirm: () => {
                    var activeinactive = 0;
                    var alertbuyer = 0;
                    if(Swal.getPopup().querySelector('#activeinactive').checked){
                        activeinactive = 1;
                    }

                    if(Swal.getPopup().querySelector('#alertbuyer').checked){
                        alertbuyer = 1;
                    }
                    
                    return {activeinactive: activeinactive, alertbuyer: alertbuyer}
                  }
                }).then((result) => {
                    
                    
                });
            */
        });

        $(document).on('click','.delete-tab-btn',function(e){
            e.preventDefault();
            var prod_id = $(this).attr('data-product-id');
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('deleteproduct')}}",
                    type: 'POST',
                    data: {product_id: prod_id,_token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {

                    }
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        location.reload();
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
            
        });

        $(document).on('click','.search',function(e){
            e.preventDefault();
            getStoreProductsData(filter_form.serializeArray());
        });

        $(document).on('change','select[name="sortby"]',function(e){
            e.preventDefault();
            getStoreProductsData(filter_form.serializeArray());
        });

        $(document).on('click','#goToPageGo',function (e) {
            var go_to_page = $('input[name="go_to_page"]').val();
            $("input[name='page']").val(go_to_page);
            getStoreProductsData(filter_form.serializeArray());
        });

        $('input[name="go_to_page"]').on("keydown", function (e) {
            var go_to_page = $('input[name="go_to_page"]').val();
            if (e.key === 'Enter') {
                $("input[name='page']").val(go_to_page);
                getStoreProductsData(filter_form.serializeArray());
            }
        });
        
        //Pagination data:
        function getStoreProductsData(filterData) {
            $.ajax({
                url: "{{route('product.storeProductPaginate.get')}}",
                type: 'POST',
                data: filterData,
                beforeSend: function (xhr) {
                    
                }
            }).always(function () {

            }).done(function (response, status, xhr) {
                
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
            // if (productData.length == 0) {
            //     $('.pagination-box').css('display', 'none');
            // } else {
            //     $('.pagination-box').css('display', 'block');
            // }
            var tbody_html = productData.length === 0 ? '<td colspan="7" align="center"><p class="btn btn-primary btn-hover py-2 px-4">No Data Found</p></td>' : '';
            if (productData.length > 0) {
                
            }
            $.each(productData, function (index, item) {
                
                var product_url = '{{ URL("/store-dashboard/product-details") }}';
                //product_url = product_url.replace(':id', item._id);
                product_url = product_url + "/" + item._id;
                tbody_html +=`<tr>
                                    <td>
                                        <img src="${item.main_image}" alt="pro-1" class="img-fluid product_view_img">
                                    </td>
                                    <td class="title-tab">
                                        <a href="${item.storeurl}">
                                            <h6>${item.product_title}</h6>
                                        </a>
                                        <p>Product Code: ${item.prod_id+100000} </p>
                                    </td>
                                    <td class="status-live text-center toggle-status" data-status="${item.status}" data-product-id="${item.prod_id}">
                                        <p>Status</p>
                                        <label class="switch_box mt-2 text-center">
                                            <input type="checkbox" class="switch_active" name="active" id="active-toggle" ${item.status == 1? 'Checked':''}>
                                        </label>
                                        <small>${item.status == 1?'Active':'In-Active' }</small>
                                    </td>
                                    <td class="last-modified text-center">
                                        <p>Last Modified</p>
                                        <small>${item.updated_date}</small>
                                    </td>
                                    <td class="amount">`;
                if (item.is_paid_or_free == "free") {
                    tbody_html += `<p>Free</p>`;
                } else {
                    tbody_html += `<p>$${item.single_license}`;
                    if(item.is_sale == 1){
                        tbody_html += `<span>$${item.actual_single_license}</span>`;
                    }
                    tbody_html += `</p>`;
                } 
                if(item.product_type.length === 0){
                    tbody_html += `<small>${item.product_type}</small>`;
                }
                tbody_html += `</td>
                                <td class="sale-box">`;
                if(item.is_sale == 1){
                    tbody_html += `<span>SALE</span>`;
                }
                                
                tbody_html += `</td>
                                <td>
                                    <a href="${item.editurl}">
                                        <button type="button" class="edit-tab-btn me-3"><img src="{{asset('images/tab-edit-icon.png')}}" class="img-fluid me-1"> Edit</button>
                                    </a>
                                    <a>
                                        <button type="button" class="delete-tab-btn" data-product-id="${item.prod_id}"><img src="{{asset('images/tab-delete.png')}}" class="img-fluid me-1">Delete</button>
                                    </a>
                                </td>
                            </tr>`;
                /*
                tbody_html += `<div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="products_list">
                                    <div class="box position-relative"><a href="${product_url}" ><img src="${item.main_image}" class="img-fluid" alt="Book-1"></a>
                                    </div>
                                    <p class="pt-4 fw-bold mb-0 "><a href="${product_url}" >${item.product_title}</a></p>`;
                                    if (item.is_paid_or_free == 'paid') {
                                        tbody_html += `<span class="d-inline-block price py-2 px-0">$ ${item.single_license}</span>`;
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
                                    tbody_html += `</ul>
                                                </div></div>`;
                $('#youMayLikeViewMore').attr('data-_id', item._id);
                */
            });
        
            var from = (response.from == null || response.from == 'null' || response.from == 'NULL' || response.from == '') ? 0 : response.from;
            var to = (response.to == null || response.to == 'null' || response.to == 'NULL' || response.to == '') ? 0 : response.to;
            //    $('.entry_details').html(`Showing ${from} to ${to} of ${response.total} entries`);
            $('table#product-list tbody').html(tbody_html);
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
                    getStoreProductsData(filter_form.serializeArray());
                }
            });
        }
    })
</script>
@endpush