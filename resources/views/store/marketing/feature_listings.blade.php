@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<style>
    a.day-label.dis {
        pointer-events: none;
        opacity: 0.5;
    }
    #pb-calendar.disable {
      pointer-events: none;
      opacity: 0.4;
    }
    .before-month .day-label,.after-month .day-label,.before-month .schedule-dot-list,.after-month .schedule-dot-list {
      display: none !important;
    }
    .day-label.active {
      background-color: #306eba !important;
      color: white !important;
      border-radius: 20px;
    }
    table.dataTable{
        margin-top: 0px !important;  
    }
    .pb-calendar .schedule-dot-item.blue{
        background-color: blue;
    }

    .pb-calendar .schedule-dot-item.red{
        background-color: red;
    }

    .pb-calendar .schedule-dot-item.green{
        background-color: green;
    }
    .pb-calendar .schedule-dot-item.grey {
        background-color: grey;
    }
    .pb-calendar > .calendar-head-frame > .row > .col > .schedule-dot-list > .schedule-dot-item, .pb-calendar > .calendar-body-frame > .row > .col > .schedule-dot-list > .schedule-dot-item {
        display: inline-block;
        /* border-radius: 50%; */
        width:7px;
        height:15px;
        vertical-align: top;
        margin-left:2px;
        margin-right:1px;
    }
    .pb-calendar .schedule-dot-item.green {
        background-color: #b9e133;
    }
</style>
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>FEATURE LISTING</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{ route('storeDashboard.marketingDashboard') }}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Marketing  Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- page title end  -->

<!-- Book Bin products section start -->
<!--section class="help-faq-section products_dashboard pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <a href="{{route('storeDashboard.HostAsale')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_1 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/piggy-icon.png')}}" class="img-fluid " alt="store-dash-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">Host a Sale</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3">
                <a href="#">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/newsletters.png')}}" class="img-fluid " alt="store-dash-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">Newsletter</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3">
                <a href="{{URL('seller/marketing/feature-listing')}}">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_4 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/feature-listing.png')}}" class="img-fluid " alt="store-dash-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">Featured Listings</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3">
                <a href="#">
                    <div class="card card-box border-0 text-center h-100 py-4 ">
                        <div class="card-body das-card">
                            <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5 ">
                                <img src="{{asset('images/social-media-icon.png')}}" class="img-fluid " alt="store-dash-1 ">
                            </div>
                            <h4 class="pt-3 mb-2">Social Media</h4>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section-->
<!-- book bin products section end  -->

<!-- page title start -->
<section class="inner_page pb-0 pt-0">
    <div class="container">                  
        <div class="row">
            <div class="col-md-9">
                <!--div class="inner_page_title mb-3">
                    <h1>FEATURED LISTINGS</h1>
                </div-->
                <div class="host-a-sale-txt">
                    <p>By marketing your products on Classroom Copy you are paying to have your products featured at the top of the relevant search criterion pages. This allows you to specifically target audiences, instead of waiting for them to find you organically.</p>
                    <p class="blue-txt pt-2">Boost your exposure for just $3.00 per day!</p>
                </div>
            </div>
            <div class="col-md-3 text-md-end mt-4 mt-md-0">
                <img src="{{ asset('images/graph-img.png') }}" alt="Host a sale"  class="img-fluid">
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

<!-- Book Bin products section start -->
<section class="inner_page pt-5">
    <div class="container">
        <form class="custom-form" method="post" name="featurListingForm" id="featurListingForm">
            @csrf
            <div class="row justify-content-between">
                <div class="col-lg-7 pe-5">
                    <div class="row mb-4 mb-md-4">
                        <div class="col-12">
                            <div class="inner_page_title">
                                <h1>SET UP MARKETING ON CLASSROOM COPY</h1>
                            </div>
                        </div>
                    </div> 

                    <div class="row mb-4 align-items-center  ">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p>Select Category:</p>
                            </div>
                        </div>
                        <?php 
                            $categoryArr = (new \App\Http\Helper\ClassroomCopyHelper)->getFeatureListingCategory();
                        ?>
                        <div class="col-md-8 col-12">
                            <div class="profile-txt ">
                                <select name="category" id="category" class="form-custom-input position-relative form-select noValue">
                                    <option value="" selected="" disabled="">Select..</option>
                                    <?php
                                    if(isset($categoryArr['subjects']) && !empty($categoryArr['subjects'])){
                                    ?>
                                    <optgroup label="Subject">
                                    <?php
                                        foreach($categoryArr['subjects'] as $subs){
                                    ?>
                                    <option value="<?php echo $subs['id'];?>"><?php echo $subs['name'];?></option> 
                                    <?php
                                        }
                                    }
                                    ?>

                                    <?php
                                    /*
                                        if(isset($categoryArr['grdelvl']) && !empty($categoryArr['grdelvl'])){
                                        ?>
                                        <optgroup label="Grade">
                                        <?php
                                            foreach($categoryArr['grdelvl'] as $grdlvl){
                                        ?>
                                        <option value="<?php echo $grdlvl['grade'];?>"><?php echo $grdlvl['grade'];?></option> 
                                        <?php
                                            }
                                        }
                                    */
                                    ?>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center ">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p>Select Product:</p>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="profile-txt ">
                                <select name="product_id" id="product_id" class="form-custom-input position-relative form-select noValue">
                                    <option value="" selected="" disabled="">Select your product to market</option>
                                   
                                </select>

                            </div>
                        </div>
                    </div>
                    <?php
                    /*
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p>Select Dates:</p>
                            </div>
                        </div>

                        <div class="col-md-8 col-12">
                            <div class="profile-txt position-relative">
                                <input type="text" name="date" id="date" class="form-custom-input" placeholder="Select Dates:" autocomplete="off">
                                <button type="button" class="border-0 bg-transparent calender-btn">
                                    <img src="{{asset('images/calender.png')}}" class="img-fluid" alt="calender icon" id="id_imgcalendar">
                                </button>
                            </div>
                        </div>
                    </div>
                    */
                    ?>  
                    <div class="row">
                        <div class="col-12">
                            <input type='hidden' name="amount" id="amount" value="{{ env('FEATURE_LISTING_PER_PRODUCT_PRICE') }}">
                           <button type="button" class="btn bg-blue btn-hover text-white text-uppercase float-end" id="FeatureProdSubmitBtn">Add To Cart</button>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-4 text-end mt-lg-0 mt-4">
                    <div class="main-calender-box">
                        <div class="blue-head">
                            <div class="static-data">
                                <ul>
                                    <li><p>Choose desired days by clicking on the date (available slots are shown in green)</p></li>
                                    <li><p>Select ‘add to cart’ button</p></li>
                                </ul> 
                            </div>
                        </div>
                        <!--<div id="calendar"></div>-->
                        <div class="position-relative">
                            <div class="loading" style="display: none;"><img src="{{asset('images/loading.gif')}}" class="img-fluid" alt="icon"></div>
                            <div id="pb-calendar" class="pb-calendar disable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- book bin products section end  -->
<!-- no sales section start html -->
<section class="no_sales mb-5">
    <div class="container">
        <div class="row mt-4">

            <div class="col-md-8 ">
                <div class="my-sales-list">
                    <h5>Planned Marketing</h5>
                </div>
                <div class="view-table-box table-responsive">
                    <table id="featureListPlannedMarketingList" class="table align-middle mb-0 table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Delete</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <!--<th class="text-center">Category</th>-->
                                <th class="text-center">Product</th>
                                <th class="text-center">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data['plannedMarketingResult'] as $planMarketing) {
                                $statusTxt = ($planMarketing['status'] == 0) ? 'Payment Pending' : 'Expired';
                                $statusCls = ($planMarketing['status'] == 0) ? 'warning' : 'danger';
                                ?>
                                <tr>
                                    <td>
                                        <a title="Delete" class="btn btn-danger btn-xs deletePlannedMarketing" data-id="{{ $planMarketing['encrypt_id'] }}"> 
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $statusCls }}">{{ $statusTxt }}</span>
                                    </td>
                                    <td>{{ date('d M, Y',strtotime($planMarketing['date'])) }}</td>
                                    <!--<td>{{ $planMarketing['category'] }}</td>-->
                                    <td>{{ $planMarketing['product_title'] }}</td>
                                    <td>${{ number_format($planMarketing['amount'],2) }} {{ env('CURRENCY') }}</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pie-gragh ps-0 pt-0 size-bg">
                    <div class="graph-box px-3 mt-4 mt-md-0">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="single-chart">
                                    <p class="d-flex justify-content-between">
                                        <span>Subtotal</span> 
                                        <span class="text-end">${{ number_format($data['plannedMarketingTotal'],2) }}</span>
                                    </p>
                                    <hr>
                                    <p class="d-flex justify-content-between m-0 total-p">
                                        <span>Total</span> 
                                        <span class="text-end">${{ number_format($data['plannedMarketingTotal'],2) }} {{ env('CURRENCY') }}</span>
                                    </p>
                                    <p class="d-flex justify-content-between float-end mt-4">
                                        <button type="button" class="btn bg-blue btn-hover text-white text-uppercase" id="ProceedBtn" <?php if($data['plannedMarketingTotal'] == 0){ echo "disabled";}?>>Proceed</button>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 ">
                <div class="my-sales-list">
                    <h5>Confirmed Marketing</h5>
                </div>
                <div class="view-table-box table-responsive">
                    <table id="featureListConfirmedMarketingList" class="table align-middle mb-0 table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Date</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['confirmedMarketingResult'] as $key => $confirmMarketing) {
                                ?>
                                <tr>
                                    <td>{{ date('d M, Y',strtotime($confirmMarketing['date'])) }}</td>
                                    <td>
                                        <?php
                                        if(is_numeric($confirmMarketing['category'])){
                                            $r = DB::table('crc_subject_details')->select(['name'])->where('id',$confirmMarketing['category'])->first();
                                            if(!is_null($r)){
                                                echo $r->name;
                                            }
                                        }
                                        ?> 
                                    </td>
                                    <td>{{ $confirmMarketing['product_title'] }}</td>
                                    <td>${{ number_format($confirmMarketing['amount'],2) }} {{ env('CURRENCY') }}</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--div class="row text-center mt-5">
            <div class="col-12">
                <div class="congratualtion-box flex-column d-flex">
                    <button type="button" class="btn btn-primary bg-blue btn-lg px-5 py-2  btn-hover text-uppercase " style="width: fit-content;margin:10px auto 20px">New sale</button>
                    <a href="#">View Marketing Reports</a>
                </div>
            </div>
        </div-->
    </div>
</section>
<!-- no sales section end html -->
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        //show slot on calendar
        var current_yyyy = moment().format("YYYY");
        var current_mm = moment().format("MM");
        var current_yyyymm_ = moment().format("YYYYMM");
        var temp_schedule_list_ = {};
        var checkloop = 0;
        var lpmnth;
        for(var i = parseInt(current_yyyy);i<=parseInt(current_yyyy)+1;i++){
            if(checkloop == 8){
                break;
            }
            if(i == current_yyyy){
                lpmnth = parseInt(current_mm);
            }
            else{
                lpmnth = 1;
            }
            for(var j=lpmnth ;j<=12;j++){
                for(var k=1;k<=31;k++){
                    var obj = [];
                    if( temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] == undefined ){
                        for (var l = 1; l <= 4; l++) {
                            obj.push({'ID': l, style: "green"})
                        }
                        temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] = obj;
                    }
                }
                checkloop++;
            }

        }
        $("#pb-calendar").pb_calendar({
                        'day_selectable':true,
                        schedule_list: function (callback_, yyyymm_) {
                            callback_(temp_schedule_list_);
                        },
                        schedule_dot_item_render: function (dot_item_el_, schedule_data_) {
                            dot_item_el_.addClass(schedule_data_['style'], true);
                            return dot_item_el_;
                        }
        });

        // $('body .row-day a.day-label').on('click',function(e){
        //     $(this).toggleClass('active');
        // });

        // $(document).on('click','.row-day a.day-label',function(e){
        //     $(this).toggleClass('active');
        // });
        /*
            $.ajax({
                url: "{{url('/seller/marketing/get-feature-product-slots')}}",
                type: 'POST',
                data: {year: current_yyyy, month: current_mm, '_token': "{{ csrf_token() }}"}
            }).done(function (response, status, xhr) {
                if (response.data.length > 0) {
                   
                    for (var i = 0; i < response.data.length; i++) {
                        var dateArr = response.data[i].date.split("-");
                        var total = response.data[i].total;
                        var dateMonth = dateArr[1];
                        var date = dateArr[2];
                        var obj = [];
                        for (var j = 1; j <= total; j++) {
                            obj.push({'ID': j, style: "green"})
                        }
                        temp_schedule_list_[current_yyyy + dateMonth + date] = obj;
                    }
                    $("#pb-calendar").pb_calendar({
                        schedule_list: function (callback_, yyyymm_) {
                            callback_(temp_schedule_list_);
                        },
                        schedule_dot_item_render: function (dot_item_el_, schedule_data_) {
                            dot_item_el_.addClass(schedule_data_['style'], true);
                            return dot_item_el_;
                        }
                    });
        
                    $(document).on('click', '.prev-btn, .next-btn' ,(e) => {
                        e.preventDefault();
                        console.log('hereeeee');
                        var year = $('.year').html();
                        var monthName = $('.month').html();
                        var month = (String(['Jan',
                            'Feb',
                            'March',
                            'April',
                            'May',
                            'June',
                            'July',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'].indexOf(monthName) + 1).padStart(2, '0'));
                        current_yyyymm_ = year + month;
                        //temp_schedule_list_ = {};
                        $.ajax({
                            url: "{{url('/seller/marketing/get-feature-product-slots')}}",
                            type: 'POST',
                            data: {year: year, month: month, category: $(this).val(),'_token': "{{ csrf_token() }}"}
                        }).done(function (response, status, xhr) {
                            if (response.data.length > 0) {
                                //var temp_schedule_list_ = {};
                                for (var i = 0; i < response.data.length; i++) {
                                    var dateArr = response.data[i].date.split("-");
                                    var total = response.data[i].total;
                                    var dateMonth = dateArr[1];
                                    var date = dateArr[2];
                                    var dateYear = dateArr[0];
                                    var obj = [];
                                    for (var j = 1; j <= total; j++) {
                                        obj.push({'ID': j, style: "green"})
                                    }
                                    temp_schedule_list_[dateYear + dateMonth + date] = obj;
                                }
                            } else {
                                temp_schedule_list_ = {};
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
                    
                } else {
                    temp_schedule_list_ = {};
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
        */
        var expiredPlannedMarketingcount = "{{ $data['expiredPlannedMarketingcount'] }}";
        var no_data_img = "{{asset('images/no_current.png')}}";
        //for datepicker
        $(function () {
            $("#id_imgcalendar").on("click", function (e) {
                //$('#date').datepicker('show');
                $('#date').datepicker({
                    startDate: new Date(),
                    autoclose: true,
                }).datepicker('show');
            });
        });
        //datatable
        $('#featureListPlannedMarketingList').DataTable({
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "language": {
                "emptyTable": '<img src="' + no_data_img + '" alt="" class="img-fluid py-4">'
            }

        });
        $('#featureListConfirmedMarketingList').DataTable({
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "language": {
                "emptyTable": '<img src="' + no_data_img + '" alt="" class="img-fluid py-4">'
            }

        });
        //Delete Planned Marketing Popup
        $(document).on('click','.deletePlannedMarketing',function (e) {
            var id = $(this).data('id');
            Swal.fire({
                allowOutsideClick: false,
                allowEscapeKey: false,
                title: 'Are you sure?',
                text: "You want to delete this!",
                icon: 'danger',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-info ms-3'
                },
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo URL('/seller/marketing/delete-feature-product') ?>" + '/' + id;
                }
            });
        });
        //Pay For Planned Marketing
        $('#ProceedBtn').click(function (e) {
            if (expiredPlannedMarketingcount > 0) {
                Swal.fire({
                    title: "Some items expired from planned marketing, please remove these items to proceed for payment",
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            } else {
                window.location.href = "<?php echo URL('/seller/marketing/feature-list/payment') ?>";
            }
        });
        //proceed for payment
        $('#FeatureProdSubmitBtn').click(function () {
            $('#FeatureProdSubmitBtn').prop('disabled', true);
            $('#FeatureProdSubmitBtn').html('Processing...');
            var err = 0;
            var category = $('#category').val();
            var product_id = $('#product_id').val();
            var dates = [];
            var errmsg = '';
            $("#category").css('border', '0px');
            $("#product_id").css('border', '0px');
            $("#date").css('border', '0px');
            $("#pb-calendar .calendar-body-frame .row-day .col").each(function(e,l){
                if($(this).find('.day-label').hasClass('active')){
                    dates.push($(this).find('.day-label').attr('data-selectable-day-yyyymmdd'));
                }
            });

            if ($('#category option:selected').val() == '') {
                $('#category').css('border', '1px solid red');
                err = 1;
                errmsg = 'please select category';
                $("#category").focus().select();
            }
            else if ($('#product_id option:selected').val() == '') {
                $('#product_id').css('border', '1px solid red');
                err = 1;
                errmsg = 'Please select product'
                $("#product_id").focus().select();
            }
            else if(dates.length === 0){
                err = 1
                errmsg = 'Please select dates';
            }
            if (err == 0) {
                $.ajax({
                    url: "<?php echo URL('/seller/marketing/feature-listing') ?>",
                    data: {
                        category: category,
                        product_id: product_id,
                        dates: dates,
                        amount: $('#amount').val(),
                        '_token': "{{ csrf_token() }}"
                    },
                    type: "post",
                    dataType: 'json',
                    success: function (response) {
                        if (response.success == 1) {
                            $('#FeatureProdSubmitBtn').prop('disabled', false);
                            $('#FeatureProdSubmitBtn').html('Add To Cart');
                            //var feature_id = response.feature_id;
                            var message = (response.message != '') ? response.message : "Congratulations";
                            Swal.fire({
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                title: 'Done',
                                text: "Product added successfully",
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
                                    window.location.reload();
                                    //window.location.href = "<?php //echo URL('/seller/marketing/feature-list/payment')                                                                                                                           ?>" + "/" + feature_id;
                                }
                            });
                            setTimeout(function(){
                                 window.location.reload();
                            },2000);
                        } else {
                            $('#FeatureProdSubmitBtn').prop('disabled', false);
                            $('#FeatureProdSubmitBtn').html('Add To Cart');
                            var message = (response.message != '') ? response.message : "Oops!! Something went wrong";
                            Swal.fire({
                                title: message,
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    },
                    error: function () {
                        $('#FeatureProdSubmitBtn').prop('disabled', false);
                        $('#FeatureProdSubmitBtn').html('Add To Cart');
                        Swal.fire({
                            title: 'There was some error performing the AJAX call!',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: errmsg,
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
                $('#FeatureProdSubmitBtn').prop('disabled', false);
                $('#FeatureProdSubmitBtn').html('Add To Cart');
            }
        });
        
        /*
        $(document).on('click', '.prev-btn, .next-btn' ,function(e){
            e.preventDefault();
            console.log('hereeeee');
            var year = $('.year').html();
            var monthName = $('.month').html();
            var month = (String(['Jan',
                'Feb',
                'March',
                'April',
                'May',
                'June',
                'July',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'].indexOf(monthName) + 1).padStart(2, '0'));
            current_yyyymm_ = year + month;
            //temp_schedule_list_ = {};
            $.ajax({
                url: "{{url('/seller/marketing/get-feature-product-slots')}}",
                type: 'POST',
                data: {year: year, month: month, category: $(this).val(),'_token': "{{ csrf_token() }}"}
            }).done(function (response, status, xhr) {
                if (response.data.length > 0) {
                    //var temp_schedule_list_ = {};
                    for (var i = 0; i < response.data.length; i++) {
                        var dateArr = response.data[i].date.split("-");
                        var total = response.data[i].total;
                        var dateMonth = dateArr[1];
                        var date = dateArr[2];
                        var dateYear = dateArr[0];
                        var obj = [];
                        for (var j = 1; j <= total; j++) {
                            obj.push({'ID': j, style: "green"})
                        }
                        temp_schedule_list_[dateYear + dateMonth + date] = obj;
                    }
                } else {
                    temp_schedule_list_ = {};
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
        */
        //On Category change
        $("#category").on('change',function(e){
            e.preventDefault();
            $(".loading").show();
            $.ajax({
                url: "{{url('/seller/marketing/get-category-products')}}",
                type: 'POST',
                data: {category: $(this).val() ,'_token': "{{ csrf_token() }}"}
            }).done(function (response, status, xhr) {
                $(".loading").hide();
                $("#pb-calendar").addClass('disable');
                if (response.data.length > 0) {
                    $('#product_id').html('');
                    var html = '<option value="" selected disabled>Select your product to market</option>';
                    for (var i = 0; i <= response.data.length - 1; i++) {
                            html += '<option value="' + response.data[i]['id'] + '">' + response.data[i]['product_title'] + '</option>';
                    }
                    $('#product_id').html(html);
                } else {
                    $('#product_id').html('<option value="" selected disabled>Select your product to market</option>');
                }
                /*
                temp_schedule_list_ = {};
                if (response.data.length > 0) {
                    for (var i = 0; i < response.data.length; i++) {
                        var dateArr = response.data[i].date.split("-");
                        var total = response.data[i].total;
                        var dateMonth = dateArr[1];
                        var date = dateArr[2];
                        var obj = [];
                        for (var j = 1; j <= total; j++) {
                            obj.push({'ID': j, style: "grey"})
                        }
                        if(total < 4){
                            j++;
                            for(var k=1; k<=(4-total);k++){
                                obj.push({'ID': j, style: "green"});
                            }
                        }
                        temp_schedule_list_[current_yyyy + dateMonth + date] = obj;
                    }
                    var checkloop = 0;
                    var lpmnth;
                    for(var i = parseInt(current_yyyy);i<=parseInt(current_yyyy)+1;i++){
                        if(checkloop == 8){
                            break;
                        }
                        if(i == current_yyyy){
                            lpmnth = parseInt(current_mm);
                        }
                        else{
                            lpmnth = 1;
                        }
                        for(var j=lpmnth ;j<=12;j++){
                            for(var k=1;k<=31;k++){
                                var obj = [];
                                if( temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] == undefined ){
                                    for (var l = 1; l <= 4; l++) {
                                        obj.push({'ID': l, style: "green"})
                                    }
                                    temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] = obj;
                                }
                            }
                            checkloop++;
                        }

                    }
                    $("#pb-calendar").pb_calendar({
                        schedule_list: function (callback_, yyyymm_) {
                            callback_(temp_schedule_list_);
                        },
                        schedule_dot_item_render: function (dot_item_el_, schedule_data_) {
                            dot_item_el_.addClass(schedule_data_['style'], true);
                            return dot_item_el_;
                        }
                    });
                } else {
                    temp_schedule_list_ = {};
                    var checkloop = 0;
                    for(var i = parseInt(current_yyyy);i<=parseInt(current_yyyy)+1;i++){
                        if(checkloop == 8){
                            break;
                        }
                        if(i == current_yyyy){
                            lpmnth = parseInt(current_mm);
                        }
                        else{
                            lpmnth = 1;
                        }
                        for(var j=lpmnth ;j<=12;j++){
                            for(var k=1;k<=31;k++){
                                var obj = [];
                                if( temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] == undefined ){
                                    for (var l = 1; l <= 4; l++) {
                                        obj.push({'ID': l, style: "green"})
                                    }
                                    temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] = obj;
                                }
                            }
                            checkloop++;
                        }

                    }
                    $("#pb-calendar").pb_calendar({
                        schedule_list: function (callback_, yyyymm_) {
                            callback_(temp_schedule_list_);
                        },
                        schedule_dot_item_render: function (dot_item_el_, schedule_data_) {
                            dot_item_el_.addClass(schedule_data_['style'], true);
                            return dot_item_el_;
                        }
                    });
                }
                
                $(".next-btn").trigger('click');
                setTimeout(function(){
                    $(".prev-btn").trigger('click');  
                    $(".loading").hide();
                },1000);
                */
                
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

        //On Product change
        $("#product_id").on('change',function(e){
            e.preventDefault();
            $(".loading").show();
            $.ajax({
                url: "{{url('/seller/marketing/get-feature-product-slots')}}",
                type: 'POST',
                data: {year: current_yyyy,prodid:$(this).val() ,month:current_mm,category: $('#category').val() ,'_token': "{{ csrf_token() }}"},
                }).done(function (response, status, xhr) {
                temp_schedule_list_ = {};
                $("#pb-calendar").removeClass('disable');
                if (response.data.length > 0) {
                   
                    for (var i = 0; i < response.data.length; i++) {
                        var dateArr = response.data[i].date.split("-");
                        var total = response.data[i].total;
                        var dateMonth = dateArr[1];
                        var date = dateArr[2];
                        var obj = [];
                        for (var j = 1; j <= total; j++) {
                            obj.push({'ID': j, style: "grey"})
                        }
                        if(total < 4){
                            j++;
                            for(var k=1; k<=(4-total);k++){
                                obj.push({'ID': j, style: "green"});
                            }
                        }
                        temp_schedule_list_[current_yyyy + dateMonth + date] = obj;
                    }
                    var checkloop = 0;
                    var lpmnth;
                    for(var i = parseInt(current_yyyy);i<=parseInt(current_yyyy)+1;i++){
                        if(checkloop == 8){
                            break;
                        }
                        if(i == current_yyyy){
                            lpmnth = parseInt(current_mm);
                        }
                        else{
                            lpmnth = 1;
                        }
                        for(var j=lpmnth ;j<=12;j++){
                            for(var k=1;k<=31;k++){
                                var obj = [];
                                if( temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] == undefined ){
                                    for (var l = 1; l <= 4; l++) {
                                        obj.push({'ID': l, style: "green"})
                                    }
                                    temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] = obj;
                                }
                            }
                            checkloop++;
                        }

                    }
                    $("#pb-calendar").pb_calendar({
                        schedule_list: function (callback_, yyyymm_) {
                            callback_(temp_schedule_list_);
                        },
                        schedule_dot_item_render: function (dot_item_el_, schedule_data_) {
                            dot_item_el_.addClass(schedule_data_['style'], true);
                            return dot_item_el_;
                        }
                    });
                } else {
                    temp_schedule_list_ = {};
                    var checkloop = 0;
                    for(var i = parseInt(current_yyyy);i<=parseInt(current_yyyy)+1;i++){
                        if(checkloop == 8){
                            break;
                        }
                        if(i == current_yyyy){
                            lpmnth = parseInt(current_mm);
                        }
                        else{
                            lpmnth = 1;
                        }
                        for(var j=lpmnth ;j<=12;j++){
                            for(var k=1;k<=31;k++){
                                var obj = [];
                                if( temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] == undefined ){
                                    for (var l = 1; l <= 4; l++) {
                                        obj.push({'ID': l, style: "green"})
                                    }
                                    temp_schedule_list_[i +''+ pad(j) +''+ pad(k)] = obj;
                                }
                            }
                            checkloop++;
                        }

                    }
                    $("#pb-calendar").pb_calendar({
                        schedule_list: function (callback_, yyyymm_) {
                            callback_(temp_schedule_list_);
                        },
                        schedule_dot_item_render: function (dot_item_el_, schedule_data_) {
                            dot_item_el_.addClass(schedule_data_['style'], true);
                            return dot_item_el_;
                        }
                    });
                }
                
                $(".next-btn").trigger('click');
                setTimeout(function(){
                    $(".prev-btn").trigger('click');  
                    $(".loading").hide();
                    $(document).on('click','.row-day a.day-label',function(e){
                        $(this).toggleClass('active');
                    });
                },1000);

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

        function pad(n) {
            return (n < 10) ? ("0" + n) : n;
        }
    });

</script>
@endpush
