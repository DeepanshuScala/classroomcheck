@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
@include('modal.coupon_offers_modal')
<?php 
 $storeRes = $data['store_result'];
 $checkofferappliead = DB::Table('Sellerofferapplied')->where('userid',auth()->user()->id)->first();
?>
<!-- page title start -->
<section class="inner_page pb-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 mb-2">
                <div class="inner_page_title">
                    <h1>My Store Profile</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{ route('store.dashboard') }}"><img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1"> Store Dashboard</a>
                </div>
            </div>
        </div>  
        <div class="row align-items-center">
            <div class="col-md-12 my-3 my-md-4 ">
                <div class="inner_page_title">
                    <!-- <h1>STORE DETAILS</h1> -->
                </div>
            </div>
        </div>                  
    </div>
</section>


<!-- page title end  -->
<!-- Book Bin products section start -->
<section class="contribution-main pt-0">
    <div class="container">
        <form class="" name="addStoreForm" id="addStoreForm" method="post" enctype="multipart/form-data">
            @if($storeRes)
                <div class="row mb-4 align-items-center ">
                    <div class="col-md-4 col-12">
                        <div class="labels">
                            <p>Store url:</p>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="row">
                            <div class="col-md-8">
                                <p>{{($storeRes == null) ? '' :url('/seller-profile/'.str_replace(' ','-',$storeRes->store_name))}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mb-4 align-items-center ">
                <div class="col-md-4 col-12">
                    <div class="labels">
                        <p>Choose a name for your store:</p>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <?php
                            $storeId = ($storeRes == null) ? 0 : $storeRes->id;
                            $storeName =
                             ($storeRes == null) ? '' : $storeRes->store_name;
                            $storeLogo = ($storeRes == null) ? '' : Storage::disk('s3')->url('store/' . $storeRes->store_logo);
                            $storeBanner = ($storeRes == null) ? '' : Storage::disk('s3')->url('store/' . $storeRes->store_banner);
                            ?>
                            <div class="profile-txt ">
                                <input type="text" name="store_name" id="store_name" value="{{ $storeName }}" class="form-custom-input" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" id="checkStoreNameAvailableBtn" class="btn btn-primary bg-blue btn-lg px-4 py-2  btn-hover text-uppercase custom-btn">Check availability</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-top ">
                <div class="col-md-4 col-12">
                    <div class="labels">
                        <p>Upload your store logo:</p>
                        <span>Supported File Types: .jpeg, .png, .jpg,<br>
                            Max File Size: 5Mb</span>
                    </div>

                </div>
                <div class="col-md-8 col-12">
                    <div class="profile-txt ">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="profile-txt mb-4 ">
                                    <!-- <input type="text" id="logo_name" readonly="" class="form-custom-input" placeholder="Store Logo"> -->
                                    <input type="file" onchange="fileChnage(this,'store_logo')"  name="store_logo" id="store_logo" class="form-custom-input Logo {{empty($storeId)?'store-logo1':'' }}" accept="image/jpg,image/png,image/jpeg,image/JPG,image/JPEG,image/PNG">
                                    <p class="text-danger text-sm d-none" id="logo-err-msg">Please select store logo!</p>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="default_store_logo" id="flexCheckDefaultW" <?php if(isset($storeRes->default_store_logo) && $storeRes->default_store_logo == 1){ echo "checked";}?>>
                                    <label class="form-check-label" for="flexCheckDefaultQ">
                                        Use the Classroom Copy default store logo
                                    </label>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 text-end">
                                <button type="button" onclick ="previewFileLogo(this);" class="btn btn-primary bg-blue btn-lg px-4 py-2  btn-hover text-uppercase custom-btn">Upload</button>
                            </div> -->
                        </div>
                    </div>
                    <style>
                        .profile-txt input[type="file"]::file-selector-button {
                                display: none;
                            }
                           
                    </style>
                    <?php if ($storeLogo != '') { ?>
                        <!-- <div class="profile-txt mb-5">
                            <div class="row">
                                <img src="{{ $storeLogo }}" style="width: 30% !important">
                            </div>
                        </div> -->
                    <?php } ?>
                    <div class="store-img mt-4">
                        <div class="drop-zone store-logo">
                            @if(!empty($storeLogo))
                            <div class="drop-zone__thumb" data-label="1659100993_store_logo.jpg" style="background-image:url('{{$storeLogo}}')">
                            </div>
                            @else
                            <h4 class="drop-zone__prompt">Store Logo 
                                <small> 'Drag File Here' <br>
                                    250x200px</small>
                            </h4>
                            @endif
                            <input type="file" name="store_logo"  id="store_logo" class="drop-zone__input drop-zone__input__logo {{empty($storeId)?'drag-store-logo1':'' }}" accept="image/jpg,image/png,image/jpeg,image/JPG,image/JPEG,image/PNG">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-top ">
                <div class="col-md-4 col-12">
                    <div class="labels">
                        <p>Upload your store banner</p>
                        <span>Supported File Types: jpeg, .png, .jpg,<br>
                            Max File Size: 5Mb</span>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="profile-txt ">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="profile-txt mb-4">
                                   <!--  <input type="text" id="banner_name" readonly="" class="form-custom-input" placeholder="Store Banner"> -->

                                    <input type="file" onchange="fileChnage(this,'store_banner')"  name="store_banner" id="store_banner" class="form-custom-input {{empty($storeId)?'store-banner1':'' }}" accept="image/jpg,image/png,image/jpeg,image/JPG,image/JPEG,image/PNG">
                                     <p class="text-danger text-sm d-none" id="banner-err-msg">Please select store banner!</p>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="default_store_banner" id="flexCheckDefaultW" <?php if(isset($storeRes->default_store_banner) && $storeRes->default_store_banner == 1){ echo "checked";}?>>
                                    <label class="form-check-label" for="flexCheckDefaultQ">
                                        Use the Classroom Copy default store banner
                                    </label>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 text-end">
                                <button type="button" onclick ="previewFileBanner(this);" class="btn btn-primary bg-blue btn-lg px-4 py-2  btn-hover text-uppercase custom-btn">Upload</button>
                            </div> -->
                        </div>
                    </div>
                    <?php if ($storeBanner != '') { ?>
                        <!-- <div class="profile-txt mb-5">
                            <div class="row">
                                <img src="{{ $storeBanner }}" style="width: 30% !important">
                            </div>
                        </div> -->
                    <?php } ?>
                    <div class="store-img-1 mt-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="drop-zone store-banner">
                                    @if(!empty($storeBanner))
                                    <div class="drop-zone__thumb" data-label="1659100993_store_logo.jpg" style="background-image:url('{{$storeBanner}}')">
                                    </div>
                                    @else
                                    <h4 class="drop-zone__prompt">Store Banner 
                                        <small> 'Drag File Here' <br>
                                            750x200px</small>
                                    </h4>
                                    @endif
                                    <input type="file" name="store_banner" id="store_banner" class="drop-zone__input drop-zone__input__banner {{empty($storeId)?'drag-store-banner1':'' }}" accept="image/jpg,image/png,image/jpeg,image/JPG,image/JPEG,image/PNG">
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                    </div>
                </div>
            </div>
            <?php if ($storeId == 0) { ?>
                <div class="row mb-4 align-items-center ">
                    <div class="col-md-4 col-12">
                        <div class="labels">
                            <p>Apply Promotional Offers:</p>
                                <a id="couponOffersModalBtn" class="btn btn-primary bg-blue btn-hover custom-btn text-capitalize" style="cursor: pointer;{{!empty($checkofferappliead)?'display:none':''}}">View Current Offers</a>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="profile-txt ">
                                    <input type="text" name="coupon_code" id="coupon_code" class="form-custom-input" placeholder="" value="{{!empty($checkofferappliead)?'sb26dg3663dg':''}}" {{!empty($checkofferappliead)?'readonly':''}}>
                                    <a href="#" class="removeoffer" {{(!empty($checkofferappliead))?'':"style=display:none;"}}>Remove Coupon</a>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="button" id="applyCoupon" class="btn btn-primary {{!empty($checkofferappliead)?'bg-black':'bg-blue'}} btn-lg px-4 py-2  btn-hover text-uppercase custom-btn applyselleroffer" {{!empty($checkofferappliead)?'disabled':''}}>{{!empty($checkofferappliead)?'APPLIED':'APPLY'}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="row mb-4 mt-5">
                <div class="col-md-4 col-12">
                </div>
                <div class="col-md-8 col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            I hereby confirm that I have accessed, read and agree to the <a href="{{url('/web/privacy_policy')}}" target="_blank">Privacy Policy</a> , 
                            <a href="{{url('/web/copyright_intellectual_property')}}" target="_blank">Intellectual Property Policy</a> 
                            and <a href="{{url('/web/seller_agreement')}}" target="_blank">Sellers Agreement</a>.
                        </label>
                    </div>
                    <p class="text-danger text-sm" style="display: none" id="checkBoxError">Please check checkbox to proceed</p>
                </div>

            </div>

            <div class="row text-center mt-5">
                <div class="col-12">
                    <?php $btnText = ($storeRes == null) ? 'Set up now' : 'Update Store' ?>
                    <input type="hidden" name="store_id" id="store_id" value="{{$storeId}}">
                    <button type="submit" id="addStoreSubBtn" id="addStoreSubBtn" class="btn btn-primary bg-blue btn-lg px-5 py-3  btn-hover text-uppercase">{{ $btnText }}</button>
                </div>
            </div>
        </form>
        <div class="row text-center mt-5 d-none">
            <div class="col-12">
                <div class="congratualtion-box">
                    <h5 class="mb-0 mb-md-4">congratulations!</h5>
                    <a href="#">VIEW YOUR STORE NOW</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- book bin products section end  -->
@endsection

@push('script')
<script>
    $("input#store_banner").on('change',function(){
        if($(this).val().length > 0){
            $('input[name="default_store_banner"').prop('checked',false);
        }
    });
    $("input#store_logo").on('change',function(){
        if($(this).val().length > 0){
            $('input[name="default_store_logo"').prop('checked',false);
        }
    });
    function fileChnage(e,cls){
        if(cls == "store_logo"){
            previewFileLogo(e)
        }else{
           previewFileBanner(e) 
        }
    }
    var lfile = '{{$storeLogo}}'
    function previewFileLogo(input){
        $('input[name="default_store_logo"').prop('checked',false);
        $('.drop-zone__input__logo').removeAttr('name');
        var file = $("input[name=store_logo]").get(0).files[0];
        // console.log(file.name);
        if(file){
            $('#logo-err-msg').addClass('d-none');
            var reader = new FileReader();
            reader.onload = function(){
                lfile = reader.result;
                $('.store-logo .drop-zone__prompt').remove();
                $('.store-logo .drop-zone__thumb').remove();
                
                let _htnl = '<div class="drop-zone__thumb logo-img" data-label="'+file.name+'"></div>';
                 //$('.store-logo').empty();
                $('.store-logo').append(_htnl)
                //$("#previewImg").attr("src", reader.result);
                $('.logo-img').css("background-image","url('"+reader.result+"')")
                //$('.drop-zone__input__logo').removeAttr('name');
            }
            reader.readAsDataURL(file);
        }else{
            $('#logo-err-msg').removeClass('d-none');
        }
    }
    var bfile= '{{$storeBanner}}';
    function previewFileBanner(input){
        console.log('here');
        $('input[name="default_store_banner"').prop('checked',false);
        $('.drop-zone__input__banner').removeAttr('name');
        var file = $("input[name=store_banner]").get(0).files[0];
        if(file){
            $('#banner-err-msg').addClass('d-none');
            var reader = new FileReader();
            reader.onload = function(){
                bfile = reader.result;
                $('.store-banner .drop-zone__prompt').remove();
                $('.store-banner .drop-zone__thumb').remove();
                let _htnl = '<div class="drop-zone__thumb banner" data-label="'+file.name+'"></div>';
                //$('.store-banner').empty();
                $('.store-banner').append(_htnl)
                //$("#previewImg").attr("src", reader.result);
                $('.banner').css("background-image","url('"+reader.result+"')")
                //$('.drop-zone__input__logo').removeAttr('name');
            }
            reader.readAsDataURL(file);
        }else{
            $('#banner-err-msg').removeClass('d-none');
        }
    }
    $(document).ready(function () {
        $(".applyselleroffer").on('click',function(){
            $(".applyselleroffer").prop("disabled",true);
            $.ajax({
                url: "{{route('storeDashboard.applyselleroffer')}}",
                type: 'POST',
                data: {'coupon':$("#coupon_code").val(),'_token': "{{ csrf_token() }}"},
            }).done(function (response, status, xhr) {
                $(".applyselleroffer").prop("disabled",false);
                if (response.success === true) {
                    swal.fire("","Offer Applied Successfully" , "success");
                    $("body #couponOffersModalBtn").hide();
                    $("body .removeoffer").show();
                    $("body #applyCoupon").prop('disabled',true);
                    $("body #applyCoupon").text('APPLIED');
                    $("body #applyCoupon").addClass('bg-black');
                    $("body #applyCoupon").removeClass('bg-blue');
                    $("body #coupon_code").val('sb26dg3663dg');
                    $("body #coupon_code").prop('readonly',true);
                }
                if (response.success === false) {
                    swal.fire("Oops!", response.message, "error");
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $(".applyselleroffer").prop("disabled",false);
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
        $(".removeoffer").on('click',function(e){
            e.preventDefault();
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to remove it?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{url('/storeDashboard-removeselleroffer')}}",
                        type: 'POST',
                        data: {'_token': "{{ csrf_token() }}"},
                    }).done(function (response, status, xhr) {
                        if (response.success === true) {
                            swal.fire("",response.message , "success");
                            $("#couponOffersModalBtn").show();
                            $(".removeoffer").hide();
                            $("#applyCoupon").prop('disabled',false);
                            $("#applyCoupon").removeClass('bg-black');
                            $("#applyCoupon").addClass('bg-blue');
                            $("#applyCoupon").text('APPLY');
                            $("#coupon_code").val('');
                            $("body #coupon_code").prop('readonly',false);
                        }
                        if (response.success === false) {
                            swal.fire("Oops!", response.message, "error");
                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        $(".applyselleroffer").prop("disabled",false);
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
                    window.location.href = $(this).attr('href');
                }
            });
        });
        $('#couponOffersModalBtn').click(function (event) {
            $('#couponOffersModal').modal('show');
        });

        function copyCode(clickedEle) {
            /* Get the text field */
            var copyText = clickedEle.value;
            var inp = document.createElement('input');
            document.body.appendChild(inp);
            inp.value = copyText;
            inp.select();
            document.execCommand('copy', false);
            inp.remove();
            alert("Coupon Code Copied");
        }

        var store_id = "{{ $storeId }}";
        $('#checkStoreNameAvailableBtn').click(function () {
            $("#store_name").css('border', '0px');
            var storeName = $.trim($('#store_name').val());
            if (storeName.length <= 0) {
                $('#store_name').val('')
                $('#store_name').focus().select();
                $("#store_name").css('border', '1px solid red');
                return false;
            } else {
                $.ajax({
                    url: "{{route('storeDashboard.checkStoreNameAvailability')}}",
                    type: 'POST',
                    data: {'store_name': storeName, 'store_id': store_id, '_token': "{{ csrf_token() }}"},
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        swal.fire("", "Store Name Available", "success");
                    }
                    if (response.success === false) {
                        swal.fire("Oops!", response.message, "error");
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

        $("form[name='addStoreForm']").submit(function (event) {
            event.preventDefault();
            $("#addStoreSubBtn").prop('disabled', true);
            $("#addStoreSubBtn").html('Processing...');
            $("#store_name").css('border', '0px');
            $('#checkBoxError').css('display', 'none');
            $(".store-logo").css('border', '1px dashed #306EBA');
            $(".store-banner").css('border', '1px dashed #306EBA');
            $("input[name='default_store_logo']").css('border', '0px');
            $("input[name='default_store_banner']").css('border', '0px');
            
            // var store_logo = $('#store_logo').prop('files')[0];
            

            // var store_banner = $('#store_banner').prop('files')[0];
            

            if ($('#store_name').val() == '' || $.trim($('#store_name').val()).length == 0) {
                if ($.trim($('#store_name').val()).length == 0)
                    $('#store_name').val('')
                $('#store_name').focus().select();
                $("#store_name").css('border', '1px solid red');
                $("#addStoreSubBtn").prop('disabled', false);
                $("#addStoreSubBtn").html("{{ $btnText }}");
                return false;
            }
            if (store_id == 0) {
                var store_logo = $('.store-logo1').prop('files')[0];
                var store_log1 = $('.drag-store-logo1').prop('files')[0];
                
                var store_banner = $('.store-banner1').prop('files')[0];
                var store_banner1 = $('.drag-store-banner1').prop('files')[0];
                // if (store_logo == undefined) {
                if ( (store_logo == undefined && store_log1 == undefined) && !$("input[name='default_store_logo']").is(":checked")  )  {
                    $('#store_logo').focus().select();
                    $(".store-logo").css('border', '1px solid red');
                    $("#addStoreSubBtn").prop('disabled', false);
                    $("#addStoreSubBtn").html("{{ $btnText }}");
                    return false;
                }
                // if (store_banner == undefined) {
                if ( (store_banner == undefined && store_banner1 == undefined) && !$("input[name='default_store_banner']").is(":checked")) {
                    $('#store_banner').focus().select();
                    $(".store-banner").css('border', '1px solid red');
                    $("#addStoreSubBtn").prop('disabled', false);
                    $("#addStoreSubBtn").html("{{ $btnText }}");
                    return false;
                }
            }else{
                var store_logo = $('#store_logo').prop('files')[0];
                var store_banner = $('#store_banner').prop('files')[0];
            }
            if (!$("#flexCheckDefault").is(":checked")) {
                $('#checkBoxError').css('display', 'block');
                $("#addStoreSubBtn").prop('disabled', false);
                $("#addStoreSubBtn").html("{{ $btnText }}");
                return false;
            }

            var storeName = $.trim($('#store_name').val());
            $.ajax({
                url: "{{route('storeDashboard.checkStoreNameAvailability')}}",
                type: 'POST',
                data: {'store_name': storeName, 'store_id': store_id, '_token': "{{ csrf_token() }}"},
            }).done(function (response, status, xhr) {
                if (response.success === false) {
                    $("#addStoreSubBtn").prop('disabled', false);
                    $("#addStoreSubBtn").html("{{ $btnText }}");
                    swal.fire("Oops!", response.message, "error");
                }
                if (response.success === true) {
                    var frm = $('#addStoreForm');
                    var formData = new FormData(frm[0]);
                    //formData.append('file', $('input[name=store_banner]')[0].files[0]);
                    //formData.append('file', $('input[name=store_banner]')[0].files[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('store_id', store_id);

                    $.ajax({
                        url: "{{route('storeDashboard.storeSetup')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false
                    }).done(function (response, status, xhr) {
                        if (response.success === true) {
                            $("#addStoreSubBtn").prop('disabled', false);
                            $("#addStoreSubBtn").html("{{ $btnText }}");
                            Swal.fire({
                                title: 'Done',
                                text: response.message,
                                icon: 'success',
                                showCancelButton: false,
                                buttonsStyling: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                //timer:2000,
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-info mx-2 bg-blue text-white'
                                },
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{route('store.products')}}";
                                }
                            });
                        }
                        if (response.success === false) {
                            $("#addStoreSubBtn").prop('disabled', false);
                            $("#addStoreSubBtn").html("{{ $btnText }}");
                            swal.fire("Oops!", response.message, "error");
                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        $("#addStoreSubBtn").prop('disabled', false);
                        $("#addStoreSubBtn").html("{{ $btnText }}");
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

        $("input[name='default_store_logo']:checkbox").click(function(){
            if($(this).is(':checked')){
                if($(".drag-store-logo1").prev("h4.drop-zone__prompt").length > 0){
                    $(".drag-store-logo1").prev("h4.drop-zone__prompt").remove();
                    var lo = '{{url("/storage/uploads/store/default_store_logo.png")}}';
                    $(".drag-store-logo1").after("<div class='drop-zone__thumb' style='background-image:url("+lo+");'></div>");
                }
                else{
                    $(".drop-zone.store-logo .drop-zone__thumb").css('background-image',"url('{{url('/storage/uploads/store/default_store_logo.png')}}')");
                }
            }
            else{
                if (lfile !== '') {
                    $(".drop-zone.store-logo .drop-zone__thumb").css('background-image',"url("+lfile+")");
                }
                else{
                    $(".drop-zone__input.drag-store-logo1").next(".drop-zone__thumb").remove();
                    $('<h4 class="drop-zone__prompt">Store Logo<small> Drag File Here <br>250x200px</small></h4>').insertBefore('.drag-store-logo1');
                }
            }
        });
        $("input[name='default_store_banner']:checkbox").click(function(){
            if($(this).is(':checked')){
                if($(".drag-store-banner1").prev("h4.drop-zone__prompt").length > 0){
                    $(".drag-store-banner1").prev("h4.drop-zone__prompt").remove();
                    var ba = '{{url("/storage/uploads/store/default_store_banner.png")}}';
                    $(".drag-store-banner1").after("<div class='drop-zone__thumb' style='background-image:url("+ba+");'></div>");
                }
                else{
                    $(".drop-zone.store-banner .drop-zone__thumb").css('background-image',"url('{{url('/storage/uploads/store/default_store_banner.png')}}')");
                }
            }
            else{
                if (bfile !== '') {
                    $(".drop-zone.store-banner .drop-zone__thumb").css('background-image',"url("+bfile+")");
                }
                else{
                    $(".drop-zone__input.drag-store-banner1").next(".drop-zone__thumb").remove();
                    $('<h4 class="drop-zone__prompt">Store Banner<small> Drag File Here <br>750x200px</small></h4>').insertBefore('.drag-store-banner1');
                }
            }
        });
    });
</script>
@endpush