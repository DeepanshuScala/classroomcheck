@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<?php 
    $curdate = date('Y-m-d');
?>
<section class="inner_page pb-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                <h1>{{ !empty($data['editsale'])? 'HOST A SALE': 'HOST A SALE'}}</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{route('storeDashboard.marketingDashboard')}}"><img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1">Marketing Dashboard</a>
                </div>
            </div>
        </div>                    
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="host-a-sale-txt">
                    <p>When discounts are properly marketed, they create an incentive for consumers to start buying. The discounts can be on one or more products, seasonal discounts or discounts on all products in a store-wide. Sale cannot extend for more than 14 days.</p>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <img src="{{asset('images/host-a-sale.png')}}" alt="Host a sale"  class="img-fluid">
            </div>
        </div>
    </div>
</section>


<!-- page title end  -->
<!-- Book Bin products section start -->
<section class="inner_page pt-3 position-relative">
    <div class="container">
        <div class="row mb-4 mb-md-5">
            <div class="col-12">
                <div class="inner_page_title">
                    <h1>{{ !empty($data['editsale'])? 'UPDATE A SALE': 'SET UP A SALE'}}</h1>
                </div>
            </div>
        </div> 
        <div class="loading-product" style="display: none;">
            <img src="{{url('/images/loading.gif')}}" class="img-fluid" alt="icon">
        </div>
        <form class="custom-form" id="host-a-sale-form">
            @csrf
            <div class="row">
               <div class="col-md-11">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-4 col-12">
                                <div class="labels">
                                    <p>Sale Start Date:</p>
                                </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="profile-txt ">
                                        <input name="start_date" type="date" class="form-custom-input"  min="<?php echo date('Y-m-d');?>" value="<?php if(!empty($data['editsale'])){ echo $data['editsale']['start_date'];}?>"  required <?php if(!empty($data['editsale'])){if(strtotime($curdate) >= strtotime($data['editsale']['start_date']) && strtotime($curdate) <= strtotime($data['editsale']['end_date'])){ echo "disabled";}}?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-4 col-12">
                                <div class="labels">
                                    <p>Sale End Date:</p>
                                </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="profile-txt ">
                                        <input name="end_date" type="date" class="form-custom-input"  min="<?php echo date('Y-m-d');?>" value="<?php if(!empty($data['editsale'])){ echo $data['editsale']['end_date'];}?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-4 col-12">
                                <div class="labels">
                                    <p>Sale Discount </p>
                                </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="profile-txt ">
                                        <?php
                                            $discount_arr = array(5,10,15,20,25);
                                        ?>
                                        <select name="discount" class=" form-custom-input position-relative">
                                            <?php
                                                foreach($discount_arr as $k){
                                            ?>
                                                <option value="{{$k}}" <?php if(!empty($data['editsale']) && $data['editsale']['discount'] == $k ){ echo 'Selected';}?>>{{$k}}%</option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php
                            /*
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-4 col-12">
                                <div class="labels">
                                    <p>Sale Items</p>
                                </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="profile-txt ">
                                        <div class="form-check form-check-inline custom-check">
                                            <input class="form-check-input" type="radio" name="appliesto" id="inlineRadio1" value="entire-store" <?php if(!empty($data['editsale']) && $data['editsale']['products'] == 'Entire Store'){ echo 'checked';}?> required>
                                            <label class="form-check-label" for="inlineRadio1">Entire Store
                                            </label>
                                          </div>
                                          <div class="form-check form-check-inline custom-check">
                                            <input class="form-check-input" type="radio" name="appliesto" id="inlineRadio2" <?php if(!empty($data['editsale']) && $data['editsale']['products'] == 'select-product'){ echo 'checked';}?> value="select-product">
                                            <label class="form-check-label" for="inlineRadio2">Selected Products</label>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            */
                            ?>
                        </div>
                       
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-2 col-12">
                        <div class="labels">
                            <p>Market Sale:</p>
                        </div>
                        </div>
                        <div class="col-md-10 col-12">
                            <div class="form-check">
                                <input name="sendalert" class="form-check-input" type="checkbox" id="flexCheckDefault" value="1">
                                <label class="form-check-label pt-1" for="flexCheckDefault">
                                    Send a message to preferred purchasers to promote your sale
                                </label>
                              </div>
                        </div>
                        
                    </div>
                    
        
                    <div class="row  mt-5">
                        <div class="col-12">
                            <input type="hidden" name="editsaleid" value="<?php if(!empty($data['editsale'])){ echo $data['editsale']['id'];}?>">
                            <input type="submit" class="btn btn-primary bg-blue btn-lg px-4 py-2  btn-hover text-uppercase" value="Next">
                            <?php
                                if(!empty($data['editsale'])){
                            ?>
                                <a class="btn btn-primary bg-blue btn-lg px-4 py-2  btn-hover text-uppercase" href="{{route('storeDashboard.HostAsale')}}">Cancel</a>
                            <?php
                                }
                            ?>
                            
                        </div>
                    </div>
               </div>
           </div>
           
        </form>
        <div id="seller-product-list" style="display: none;">
        </div>
        <div id="final-check-sale-data" style="display: none;">
        </div>
    </div>
</section>
<!-- book bin products section end  -->
<!-- no sales section start html -->
    <section class="no_sales ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="no_title">
                        <h4>CURRENT SALES</h4>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div class="my-sales-list">
                        <h5>My Sale Listings</h5>
                    </div>
                    <div class="view-table-box table-responsive">
                        <table class="table align-middle mb-0 table-bordered" >
                           <tr class="text-center">
                               <th>#</th>
                               <th>Discount %</th>
                               <th>No. Of Product</th>
                               <th>Start Date</th>
                               <th>End Date</th>
                               <th>Edit</th>
                               <th>Delete</th>
                               <th>View</th>
                           </tr>
                            <?php
                            if(count($data['sales']) == 0 ){
                            ?>
                            <tr>
                                <td colspan="8" align="center">
                                   <img src="{{asset('images/no_sales.png')}}" alt="" class="img-fluid py-4">
                                </td>  
                            </tr>
                            <?php
                            }
                            else{
                                foreach ($data['sales'] as $key => $value) {
                            ?>
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->discount}}%</td>
                                    <td>
                                        <?php  
                                            if($value->products == 'Entire Store'){
                                                echo 'Entire Store';
                                            }
                                            else{
                                                echo count(explode(',', $value->products));
                                            }
                                        ?> 
                                    </td>
                                    <td>{{date('m-d-Y',strtotime($value->start_date))}}</td>
                                    <td>{{date('m-d-Y',strtotime($value->end_date))}}</td>
                                    
                                    <td><a href="{{route('storeDashboard.HostAsale').'/'.Crypt::encrypt($value->id)}}">
                                        <button type="button" class="edit-tab-btn me-3" {{ !empty($data['editsale'])? 'disabled': ''}} <?php if( strtotime($curdate) > strtotime($value->end_date)){ echo "disabled";}?>><img src="{{asset('images/tab-edit-icon.png')}}" class="img-fluid me-1"></button>
                                    </a></td>
                                    <td>
                                        <a>
                                            
                                            <button type="button" class="delete-tab-btn" data-sale-id="{{$value->id}}" {{ !empty($data['editsale'])? 'disabled': ''}} <?php if(strtotime($curdate) >= strtotime($value->start_date) && strtotime($curdate) <= strtotime($value->end_date)){ echo "disabled";}?>><img src="{{asset('images/tab-delete.png')}}" class="img-fluid me-1"></button>
                                        </a>
                                    </td>
                                    <td><a href="{{route('viewsale').'/'.Crypt::encrypt($value->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <?php
                     /*
                    <div class="text-center col-12 "><button type="button " class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover view-more ">New Sale </div>
                    */
                ?>
            </div>
        </div>
    </section>
<!-- no sales section end html -->
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('submit','form#host-a-sale-form',function(e){
            e.preventDefault();
            var fdata = $(this).serializeArray();
            $(".loading-product").css('display', 'flex');
            $.ajax({
                url: "{{route('host-a-sale.post')}}",
                type: 'POST',
                data: fdata,
            }).done(function (response, status, xhr) {
                $(".loading-product").hide();
                if (response.success === true) {
                    
                    $("#host-a-sale-form").hide();
                    $("#seller-product-list").html(response.renderhtml);
                    $("#seller-product-list").show();
                    /*
                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        title: 'Congratulations',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        //confirmButtonColor: '#3085d6',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        },
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("{{route('storeDashboard.HostAsale')}}");
                        }
                    });
                    */
                }
                if (response.success === false) {
                    Swal.fire({
                        title: 'Oops',
                        text: response.message,
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 2000,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
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

        $(document).on('click','.delete-tab-btn',function(e){
            e.preventDefault();
            var saleid = $(this).attr('data-sale-id');
            Swal.fire({
              title: 'Are you sure?',
              text: "You are Deleting a Sale",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('host-a-sale.delete')}}",
                        type: 'POST',
                        data: {'saleid':saleid, _token: '{{ csrf_token() }}'},
                        beforeSend: function (xhr) {
                            
                        }
                        }).done(function (response, status, xhr) {
                            if (response.success === true) {
                                Swal.fire({
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    title: 'Deleted',
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
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                                setTimeout(function(){
                                    window.location.reload();
                                },3000);
                            }
                            if (response.success === false) {
                                Swal.fire({
                                    title: 'Oops',
                                    text: response.message,
                                    icon: 'warning',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    //closeOnClickOutside: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
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
                }
            });
            
        });
        
        $(document).on('change','.check-all',function(e){
            e.preventDefault();
            if(this.checked) {
                $('.single-list').prop('checked', this.checked);
            }
            else{
                $('.single-list').prop('checked', false);
            }

        });

        $(document).on('change','.single-list',function(e){
            e.preventDefault(); 
            
            if ($('.single-list:checked').length == $('.single-list').length) {
                $('.check-all').prop('checked', true);
            }
            else{
                $('.check-all').prop('checked', false);
            }
        });

        $(document).on("keyup",'input[name="search_seller_products"]',function() {
           rq_filter_option();
        });

        $(document).on('click','#get-final-submit',function(e){
            e.preventDefault();
            if($("input.single-list:checkbox:checked").length === 0){
                Swal.fire({
                    title: 'Oops',
                    text: 'Please Select a Product',
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 2000,
                    //closeOnClickOutside: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }); 
                return false;
            }
            
            if($("input.check-all:checkbox:checked").length === 1){
                var pro = 'all';
            }
            else{
                var pro = [];
                $('input.single-list').each(function () {
                    if(this.checked){
                        pro.push($(this).val());
                    }
                });
            }
            $(".loading-product").css('display', 'flex');
            $.ajax({
                url : "{{route('host-a-sale.post')}}",
                type:"POST",
                data : {get_final_data:1,dateformdata:$('form#host-a-sale-form').serializeArray(),prods:pro, _token: '{{ csrf_token() }}'}
            }).done(function (response, status, xhr) {
                $(".loading-product").hide();
                if(response.success === true){

                   $('#final-check-sale-data').html(response.renderhtml);
                   $("#seller-product-list").hide();
                   $('#final-check-sale-data').show();
                }
                if (response.success === false) {
                    Swal.fire({
                        title: 'Oops',
                        text: response.message,
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 2000,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                }
            });
        });

        $(document).on('click','#final-submit',function(e){
            e.preventDefault();
            if($("input.check-all:checkbox:checked").length === 1){
                var pro = 'all';
            }
            else{
                var pro = [];
                $('input.single-list').each(function () {
                    if(this.checked){
                        pro.push($(this).val());
                    }
                });
            }
            $(".loading-product").css('display', 'flex');
            $.ajax({
                url: "{{route('host-a-sale.post')}}",
                type: 'POST',
                data: {dateformdata:$('form#host-a-sale-form').serializeArray(),prods:pro,_token: '{{ csrf_token() }}'},
                beforeSend: function (xhr) {
                    
                }
            }).done(function (response, status, xhr) {
                $(".loading-product").hide();
                if(response.success === true){
                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        title: 'Done',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        //confirmButtonColor: '#3085d6',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        },
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("{{route('storeDashboard.HostAsale')}}");
                        }
                    }); 

                    setTimeout(function(){
                         window.location.replace("{{route('storeDashboard.HostAsale')}}");
                    },3000);
                }
            });
        })

        $(document).on('click','#go-to-second',function(e){
            $("#final-check-sale-data").hide();
            $("#seller-product-list").show();
        });

        function rq_filter_option( selector, searchIn ){
            var search = jQuery('input[name="search_seller_products"]').val();
            
            jQuery('table#product-list-seller')
            .find('tr.filter-main')
            .hide()
            .filter(function() {
              var oksearch = true;
            
              if (search) {
                oksearch = jQuery(this).attr("class").toLowerCase().indexOf(search) > -1;
              }
              //only fade a room if it search
              return oksearch;
            }).fadeIn('fast');
        }
    });
</script>
@endpush