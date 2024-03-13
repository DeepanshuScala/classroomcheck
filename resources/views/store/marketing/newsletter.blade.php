@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>NEWSLETTER CONTRIBUTIONS</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{ route('storeDashboard.marketingDashboard') }}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Marketing Dashboard
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-9">
                <div class="host-a-sale-txt">
                    <p>We love sharing your creations in our newsletter!</p>

                    <p>Not only is this a great way to share your amazing creations, but a fantastic way to promote your business and boost sales. 
                    If you would like to be a part of our newsletter and share your Classroom Copy products, please complete the following form for future consideration. 
                    
                    </p>
                </div>
            </div>
           
        </div>
    </div>
</section>
<!-- page title end  -->

<section class="inner_page pt-3">
    <div class="container">
        <div class="row mb-4 mb-md-5">
            <div class="col-12">
                <div class="inner_page_title">
                    <h1>NEWSLETTER SUGGESTED RESOURCES</h1>
                </div>
            </div>
        </div> 
        <form class="custom-form" method="post" action="{{route('newsletter.seller')}}">
            @csrf
            <div class="row mb-4 align-items-center ">
                <div class="col-md-2 col-12">
                <div class="labels">
                    <p>Store Web Address:</p>
                </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <input type="url" name="store_url" class="form-custom-input" value="" placeholder="URL" >
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-center ">
                <div class="col-md-2 col-12">
                <div class="labels">
                    <p>Store Name:</p>
                </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <input type="text" name="store_name" class="form-custom-input" placeholder="Store Name" >
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-center ">
                <div class="col-md-2 col-12">
                <div class="labels">
                    <p>Email Address:</p>
                </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <input type="email" name="email" class="form-custom-input" placeholder="Email Address" >
                    </div>
                </div>
            </div>
           <!-- <div class="row mb-4 align-items-center ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Resource Grade:</p>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <?php
                        $gradeLevelArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductLevel();
                        ?>
                        <select name="resource_grade" class=" form-custom-input position-relative form-select" >
                            <option value="">Select Most Appropriate</option>
                            @foreach($gradeLevelArr as $level)
                                <option value="{{$level->grade}}">{{$level->grade}}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
            </div> -->
           <div class="row mb-4 align-items-center ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Resource Subject:</p>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <?php
                        $productSubjectArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductSubjectArea();
                        ?>
                        <select name="resource_subject" class=" form-custom-input position-relative form-select" id="category">
                            <option value="">Select Most Appropriate</option>
                            @foreach($productSubjectArr as $productSubject)
                                <option value="{{$productSubject->name}}" data-v="<?php echo $productSubject->id;?>">{{$productSubject->name}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-center ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Product:</p>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <select name="product_id" id="product_id" class="form-custom-input position-relative form-select noValue">
                            <option value="" selected="" disabled="">Select your product</option>
                           
                        </select>
                    </div>
                </div>
            </div>
            <!-- <div class="row mb-4">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                             <div class="labels">
                        <p>Product Price:</p>
                    </div>
                        </div>
                        <div class="col-md-8 col-12 position-relative">
                            <div class=" form-check-inline ps-0">
                                <input type="radio" name="product_price_type" id="product_price_type" value="paid"  />
                                <label class="form-check-label" for="flexRadioDefault">Paid</label>
                            </div>
                            <div class=" form-check-inline ps-0" id="isPaidOrFreeValidation">
                                <input type="radio" name="product_price_type"id="product_price_type1" value="free"  />
                                <label class="form-check-label product-price-type-error" for="flexRadioDefault1">
                                    Free
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row mb-4">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-start">
                        <div class="col-md-2 col-12">
                            <div class="labels">
                        <p>Previous Listing:</p>
                    </div>
                        </div>
                        <div class="col-md-8 col-12 ">
                            <div class="news">
                                <p>Have you ever previously had a product marketed in a Classroom Copy newsletter?</p>
                            </div>
                            <div class="position-relative">
                                <div class=" form-check-inline ps-0">
                                    <input type="radio" name="previous_listing" id="previous_listing" value="1"  />
                                    <label class="form-check-label" for="flexRadioDefault">Yes</label>
                                </div>
                                <div class=" form-check-inline ps-0" id="isPaidOrFreeValidation">
                                    <input type="radio" name="previous_listing"id="previous_listing1" value="0"  />
                                    <label class="form-check-label previous-listing-error" for="flexRadioDefault1">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 text-center">
                <input type="submit" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase " value="Confirm">
            </div>
            <div class="row mt-4">
                <div class="col-12 blue-txt">
                    <p>NOTE: Maximum of one free and/or one paid submission per submission Selected contributors will not be advised, so please check the newsletter regularly.</p>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('submit',"form.custom-form",function (event) {
            
            var socialmediaform = $("form.custom-form");

            var store_url = socialmediaform.find("input[name='store_url']").val();
            var store_name = socialmediaform.find("input[name='store_name']").val();
            var email = socialmediaform.find("input[name='email']").val();
            var product = socialmediaform.find("select[name='product_id'] :selected").val();
            var resource_subject = socialmediaform.find("select[name='resource_subject'] :selected").val();
            var product_price_type = socialmediaform.find("input[name='product_price_type']:checked").val();
            var previous_listing = socialmediaform.find("input[name='previous_listing']:checked").val();
            $("form.custom-form .error_msg").remove();
            $('input[name=product_price_type]').css('box-shadow', 'none');
            $('input[name=previous_listing]').css('box-shadow', 'none');
            if (store_url == "") {
                $("input[name='store_url']").focus().select();
                $("input[name='store_url']").after('<span class="error text-danger error_msg">Enter your store URL</span>');
                return false;
            }
            
            if (store_name == "") {
                socialmediaform.find("input[name='store_name']").focus().select();
                socialmediaform.find("input[name='store_name']").after('<span class="error text-danger error_msg">Enter your store name</span>');
                return false;
            }

            if (email == "") {
                socialmediaform.find("input[name='email']").focus().select();
                socialmediaform.find("input[name='email']").after('<span class="error text-danger error_msg">Enter your email</span>');
                return false;
            }
            
            






            if (resource_subject == "") {
                socialmediaform.find("select[name='resource_subject']").focus().select();
                socialmediaform.find("select[name='resource_subject']").after('<span class="error text-danger error_msg">Select your Resource Subject</span>');
                return false;
            }
           
            if (product == "" || typeof product === 'undefined' ) {
                socialmediaform.find("select[name='product_id']").focus().select();

                socialmediaform.find("select[name='product_id']").after('<span class="error text-danger error_msg">Select Product</span>');
                return false;
            }

            if (typeof previous_listing === 'undefined') {
                $('input[name=previous_listing]').css('box-shadow', '0 0 2px 0 red');
                socialmediaform.find('input[name="previous_listing"]').focus().select();
                socialmediaform.find('input[name="previous_listing"]').next(".previous-listing-error").after('<span class="error text-danger error_msg price-error"></br>Please Select a Option</span>');
                return false;
            }
        });

        //On Category change
        $("#category").on('change',function(e){
            e.preventDefault();
            $(".loading").show();
            $.ajax({
                url: "{{url('/seller/marketing/get-category-products')}}",
                type: 'POST',
                data: {category: $(this).find(':selected').attr('data-v') ,'_token': "{{ csrf_token() }}"}
            }).done(function (response, status, xhr) {
                $(".loading").hide();
                if (response.data.length > 0) {
                    $('#product_id').html('');
                    var html = '<option value="" selected disabled>Select your product</option>';
                    for (var i = 0; i <= response.data.length - 1; i++) {
                            html += '<option value="' + response.data[i]['id'] + '">' + response.data[i]['product_title'] + '</option>';
                    }
                    $('#product_id').html(html);
                } else {
                    $('#product_id').html('<option value="" selected disabled>Select your product</option>');
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
    });

</script>
@endpush