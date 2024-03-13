@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- Book Bin products section start -->
<section class="contribution-main inner_page pt-5">
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="inner_page_title mb-5">
                    <h1>REGISTER</h1>
                </div>
            </div>
        </div>   
        <form action="{{route('accountUser.Register.Post')}}" method="post" name="accountRegisterForm" id="accountRegisterForm" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p class="m-0">First Name:</p>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="profile-txt ">
                                <input type="text" class="form-custom-input" placeholder="First Name" name="first_name" id="first_name" value="{{old('first_name')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-3 col-12">
                            <div class="labels">
                                <p class="m-0">Last Name:</p>
                            </div>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="profile-txt ">
                                <input type="text" class="form-custom-input" placeholder="Last Name" name="surname" id="surname" value="{{old('surname')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p class="m-0">Address Line 1: <span class="d-inline-block">(Optional)</span></p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <input type="text" class="form-custom-input" placeholder="Street Number, Apartment, Suite, Unit, Building, Floor etc"  name="address_line1" id="address_line1" value="{{old('address_line1')}}">
                    </div>
                </div>

            </div>
            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p class="m-0">Address Line 2: <span class="d-inline-block">(Optional)</span></p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <input type="text" class="form-custom-input" placeholder="Street Address or P.O. Box" name="address_line2" id="address_line2" value="{{old('address_line2')}}">
                    </div>
                </div>
            </div>

            <div class="row ">
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p class="m-0">City: <span class="d-inline-block">(Optional)</span></p>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="profile-txt ">
                                <input type="text" class="form-custom-input" placeholder="City" name="city" id="city" value="{{old('city')}}" onkeypress="return /[a-z ]/i.test(event.key)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4 align-items-start">
                        <div class="col-md-3 col-12">
                            <div class="labels">
                                <p class="m-0">Area Code: <span class="d-block">(Optional)</span></p>
                            </div>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="profile-txt ">
                                <input type="text" class="form-custom-input" placeholder="Area Code" name="postal_code" id="postal_code" value="{{old('postal_code')}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p class="m-0">Country:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt " id="countryQ">
                        <select class="form-select select2 noValue" name="country" id="country" style="">
                            <option disabled="disabled" value="" selected>Please select country</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p class="m-0">State / Province
                            / Region:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt " id="state_province_regionQ">
                        <select class="form-select select2 noValue" name="state_province_region" id="state_province_region" >
                            <option disabled="disabled" value="" selected>Please select state / Province/ Region</option>
                        </select>
                    </div>
                </div>
            </div>

            <!--div class="row mb-4 ">
                    <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>City:</p>
                    </div>
                    </div>
                    <div class="col-md-10 col-12">
                        <div class="profile-txt ">
                            <input type="text" class="form-custom-input" placeholder="Enter your city" name="city" id="city" value="{{old('city')}}" onkeypress="return /[a-z ]/i.test(event.key)">
                                <!--                        <select class="form-control select2" name="state_province_region" name="city" id="city">
                                <option disabled="disabled" value="" selected>Please select your city</option>
                            </select>->
                        </div>
                    </div>
                    
                </div>
                <div class="row mb-4 ">
                    <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>ZIP / Postal Code:</p>
                    </div>
                    </div>
                    <div class="col-md-10 col-12">
                        <div class="profile-txt ">
                            <input type="text" class="form-custom-input" placeholder="ZIP / Postal Code" name="postal_code" id="postal_code" value="{{old('postal_code')}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>
                </div-->

            <div class="row ">
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p class="m-0">Phone: <span class="d-block">(Optional)</span></p>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="row ">
                                <!-- <div class="col-md-4 col-12">
                                    <div class="profile-txt mb-2 mb-md-0" id="phone_country_codeQ">
                                        <select class="form-select select2" name="phone_country_code" id="phone_country_code" style="">
                                            <option disabled="disabled" value="" selected>Country Code</option>
                                        </select>
                                        <input type="text" class="form-custom-input" name="phone_country_code" id="phone-country-code">
                                    </div>
                                </div> -->
                                <div class="col-md-4 col-12">
                                    <div class="profile-txt mt-2">
                                        <input type="text" class="form-custom-input" name="phone_country_code" id="phone-country-code" onkeydown="return false;" readonly="readonly" onfocus="this.removeAttribute('readonly');">
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="profile-txt mt-2">
                                        <input type="text" class="form-custom-input" placeholder="Phone" name="phone" id="phone" value="{{old('phone')}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-3 col-12">
                            <div class="labels">
                                <p class="m-0">Mob. Phone: <span class="d-block">(Optional)</span></p>
                            </div>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="row">
                                <!-- <div class="col-md-4 col-12">
                                    <div class="profile-txt mb-2 mb-md-0" id="mob_phone_country_codeQ">
                                        <select class="form-select select2" name="mob_phone_country_code" id="mob_phone_country_code" style="">
                                            <option disabled="disabled" value="" selected>Country Code</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-md-4 col-12">
                                    <div class="profile-txt mt-2">
                                        <input type="text" class="form-custom-input" placeholder="Mob. Phone" name="mob_phone_country_code" id="mob-phone-country_code" onkeydown="return false;" readonly="readonly" onfocus="this.removeAttribute('readonly');">
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="profile-txt mt-2">
                                        <input type="text" class="form-custom-input" placeholder="Mob. Phone" name="mob_phone" id="mob_phone" value="{{old('mob_phone')}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Phone:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="row align-items-center">
                        <div class="col-md-3 col-12">
                            <div class="profile-txt mb-2 mb-md-0" id="phone_country_codeQ">
                                <select class="form-select select2" name="phone_country_code" id="phone_country_code" style="">
                                    <option disabled="disabled" value="" selected>Country Code</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="profile-txt ">
                                <input type="text" class="form-custom-input" placeholder="Phone" name="phone" id="phone" value="{{old('phone')}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Mob. Phone:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="row align-items-center">
                        <div class="col-md-3 col-12">
                            <div class="profile-txt mb-2 mb-md-0" id="mob_phone_country_codeQ">
                                <select class="form-select select2" name="mob_phone_country_code" id="mob_phone_country_code" style="">
                                    <option disabled="disabled" value="" selected>Country Code</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="profile-txt ">
                                <input type="text" class="form-custom-input" placeholder="Mob. Phone" name="mob_phone" id="mob_phone" value="{{old('mob_phone')}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                    </div>
                </div>
            </div-->

            <div class="row ">
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p class="m-0">Email Address:</p>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="profile-txt ">
                                <input type="text" class="form-custom-input" placeholder="Email" name="email" id="account_email" value="{{old('email')}}"  autocomplete="new-email">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-3 col-12">
                            <div class="labels">
                                <p class="m-0">Confirm Email Address:</p>
                            </div>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="profile-txt ">
                                <input type="text" class="form-custom-input" placeholder="Confirm Email" name="confirm_email" id="account_confirm_email" value="{{old('confirm_email')}}"  autocomplete="new-email">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Email Address:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <input type="text" class="form-custom-input" placeholder="Enter your email" name="email" id="account_email" value="{{old('email')}}"  autocomplete="new-email" >
                    </div>
                </div>
            </div-->

            <div class="row ">
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p class="m-0">Password:</p>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="profile-txt ">
                                <input type="password" class="form-custom-input" placeholder="Password" name="password" id="account_password" autocomplete="new-password" value="{{old('password')}}" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-3 col-12">
                            <div class="labels">
                                <p class="m-0">Confirm Password:</p>
                            </div>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="profile-txt ">
                                <input type="password" class="form-custom-input" placeholder="Confirm Password" name="password_confirmation" id="account_password_confirmation"  autocomplete="new-confirm_password" value="{{old('password_confirmation')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p class="m-0">Age: <span class="d-block">(Optional)</span></p>
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <div class="profile-txt ">
                        <select class="form-custom-input" name="age" id="age">
                            <option value="">Select Age</option>
                            <option value="18 – 25">18 – 25</option>
                            <option value="25 – 30">25 – 30</option>
                            <option value="31 – 35">31 – 35</option>
                            <option value="36 – 40">36 – 40</option>
                            <option value="41 – 45">41 – 45</option>
                            <option value="46 – 50">46 – 50</option>
                            <option value="50 +">50 +</option>
                        </select>
                        <!-- <input type="number" class="form-custom-input" placeholder="age" name="age" id="age" value="" placeholder="Age"> -->
                    </div>
                </div>
            </div>

            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p class="m-0">Grade Taught: <span class="d-block">(Optional)</span></p>
                    </div>
                </div>
                <?php $gradeArr = (new \App\Http\Helper\ClassroomCopyHelper)->getProductLevel(); ?>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <select class="form-custom-input form-select noValue" name="grade_id" id="grade_id">
                            <option value="">Select Grade Taught</option>
                            <?php foreach ($gradeArr as $grade) { ?>
                                <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p class="m-0">Interest Areas: <span class="d-block">(Optional)</span></p>
                    </div>
                </div>
                <?php $interestArr = (new \App\Http\Helper\ClassroomCopyHelper)->getInterestAreas(); ?>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <select class="form-custom-input form-select noValue" name="interest_area" id="interest_area">
                            <option value="">Select Interest Area</option>
                            <?php foreach ($interestArr as $interest) { ?>
                                <option value="{{ $interest }}">{{ $interest }}</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p class="m-0">My Image :</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="row align-items-center" id="imageAndDefaultImage">
                        <div class="col-md-3 col-12">
                            <div class="profile-txt mb-3 mb-md-0">
                                <img src="{{asset('/storage/uploads/profile_picture/default_buyer_logo.png')}}" alt="" class="img-fluid w-100 dtf-img">
                            </div>
                        </div>
                        <div class="col-md-9 col-12 ">
                            <div class="profile-txt ">
                                <input type="file" class="form-custom-input" placeholder="Select file from computer" name="image" id="image" onchange="readURL(this);">
                                <span class="my-3">Supported File Types: .jpg, .jpeg, .png, .gif, .tif, .tiff<br>
                                    Max File Size: 5Mb</span>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="default_image" id="flexCheckDefaultW" value="1" checked>
                                                <label class="form-check-label" for="flexCheckDefaultQ">
                                                    Use the Classroom Copy default image 1
                                                </label>
                                            </div> 
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="default_image" id="flexCheckDefaultW" value="2">
                                                <label class="form-check-label" for="flexCheckDefaultQ">
                                                    Use the Classroom Copy default image 2
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="default_image" id="flexCheckDefaultW" value="3">
                                                <label class="form-check-label" for="flexCheckDefaultQ">
                                                    Use the Classroom Copy default image 3
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="default_image" id="flexCheckDefaultW" value="4">
                                                <label class="form-check-label" for="flexCheckDefaultQ">
                                                    Use the Classroom Copy default image 4
                                                </label>
                                            </div>
                                        </div>
                                    </div>                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Tell us about you: <span class="d-inline-block">(Optional)</span></p>
                        <span >(Teaching experience, year
                            levels taught, philosophy etc.) </span>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <textarea class="form-custom-input" rows="5" placeholder="Add text here" name="tell_us_about_you" id="tell_us_about_you">{{old('tell_us_about_you')}}</textarea>
                        <span class="mx-char">Max. Characters - 500</span>
                    </div>
                </div>

            </div>
            <div class="row mb-4 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Detail any additional
                            information: <span class="d-inline-block">(Optional)</span> </p>
                        <span >(Teaching experience, year 
                            levels taught, philosophy etc.)  </span>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <textarea class="form-custom-input" rows="5" placeholder="Add text here" name="detail_additional_information" id="detail_additional_information">{{old('detail_additional_information')}}</textarea>
                        <span class="mx-char">Max. Characters - 500</span>
                    </div>
                </div>

            </div>
            <div class="row mb-4 mt-5">
                <div class="col-md-2 col-12">
                </div>
                <div class="col-md-10 col-12">
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="flexCheckDefaultY" name="newsletter">
                        <label class="form-check-label" for="flexCheckDefaultT" id="newsletterLabel">
                            Sign up for our newsletter (you can cancel at any time)
                        </label>
                    </div>
                    <!-- <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="flexCheckDefaultR" name="classroom_contributions">
                        <label class="form-check-label" for="flexCheckDefaultE" id="classroomContributionsLabel">
                            Sign up to raise funds for your account through Classroom Contributions. 
                        </label>
                    </div> -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="flexCheckDefaultI" name="terms_and_conditions">
                        <label class="form-check-label" for="flexCheckDefaultU" id="termsAndConditionsLabel">
                            I agree to the <a href="{{url('/web/terms_policy')}}" target="_blank">Terms and Conditions</a> , <a href="{{url('/web/privacy_policy')}}" target="_blank">Privacy Policy</a> , <a href="{{url('/web/intellectual_property')}}" target="_blank">Intellectual Property Policy</a> and <a href="{{url('/web/seller_agreement')}}" target="_blank">Sellers Agreement</a>
                        </label>
                    </div>

                </div>

            </div>
            @if(isset($_GET['coupon']) && $_GET['coupon'] == 'apply')
                <input type="hidden" name="coupon" value="1">
            @endif
            <div class="row text-center mt-5">
                <div class="col-12">
                    <input type="submit" class="sbmt-btn btn btn-primary bg-blue btn-lg px-5 py-3  btn-hover text-uppercase" value="Sign up now">
                </div>
            </div>
        </form>
    </div>
</section>

<!-- book bin products section end  -->
@endsection
@push('script')
<script>
    var file = ''
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                file = e.target.result;
                $('img.dtf-img')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(function() {
      // $("#country").change(function() {
      //   let countryCode = $(this).find('option:selected').data('country-code');
      //   let value = "+" + $(this).val();
      //   $('#txtPhone').val(value).intlTelInput("setCountry", countryCode);
      // });
      $('#mob-phone-country_code').val('+61').intlTelInput({preferredCountries:["au","us", "gb","nz"]});
      $('#phone-country-code').val('+61').intlTelInput({preferredCountries:["au","us", "gb","nz"]});
    });
    //$('.select2').select2();
    $(".select2").select2({
        theme: "bootstrap-5",
    });
        //Initialize Select2 Elements
        //$('.select2bs4').select2({
        //  theme: 'bootstrap4'
        //});


</script>
<script>
//Getting Countries list:
    $(document).ready(function () {

        var uri = window.location.href.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }

        $("input[name='default_image']:checkbox").click(function(){
            
            if($(this).val() == 1 && $(this).is(':checked')){
                
                $("img.dtf-img").attr('src','{{url("/storage/uploads/profile_picture/default_buyer_logo.png")}}');
            }
            else if($(this).val() == 2 && $(this).is(':checked') ){
                
                $("img.dtf-img").attr('src','{{url("/storage/uploads/profile_picture/default_green_boy_logo.png")}}');
            }
            else if($(this).val() == 3 && $(this).is(':checked') ){
                
                $("img.dtf-img").attr('src','{{url("/storage/uploads/profile_picture/default_blue_boy_beard_logo.png")}}');
            }
            else if($(this).val() == 4 && $(this).is(':checked')){
            
                $("img.dtf-img").attr('src','{{url("/storage/uploads/profile_picture/default_pink_logo.png")}}');
            }
            else{
                if (file !== '') {
                        $('img.dtf-img').attr('src', file);
                }
                else{
                    $("img.dtf-img").attr('src','{{url("/storage/uploads/profile_picture/default_buyer_logo.png")}}');
                }
            }
            $("input[name='default_image']").not(this).prop('checked', false);
        });
        $.ajax({
            url: "{{route('get.allCountries.list')}}",
            type: "POST",
            data: {},
            dataType: "json",
            beforeSend: function (xhr) {}
        }).always(function () {
        }).done(function (response, status, xhr) {
            if (response.success === true) {
                var country_select = $("#accountRegisterForm").find("select[name='country']");
                var phone_country_code = $("#accountRegisterForm").find("select[name='phone_country_code']");
                var mob_phone_country_code = $("#accountRegisterForm").find("select[name='mob_phone_country_code']");
                    //                    country_select.find('option').remove();
                    //                    country_select.append(`<option value="" selected>Please select your country</option>`);
                $.each(response.data.countries, function (index, item) {
                    country_select.append(new Option(item.name + ' - ' + item.sortname, item.id));
                    //                        country_select.append(new Option(item.name +' - '+ item.sortname, item.name));
                });
                $.each(response.data.countries, function (index, item) {
                    phone_country_code.append(new Option(item.phonecode + " - " + item.name, item.phonecode));
                });
                $.each(response.data.countries, function (index, item) {
                    mob_phone_country_code.append(new Option(item.phonecode + " - " + item.name, item.phonecode));
                });
            }
            if (response.success === false) {
                        //                swal.fire('Oops...', response.msg, 'error');
                var country_select = $("#accountRegisterForm").find("select[name='country']");
                    //                    country_select.find('option').remove();
                    //                    country_select.append(`<option value="" selected>Please select your country</option>`);
            }

        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {

        });

        //Get states by country:
        $('#accountRegisterForm #country').on('change', function () {
            get_states(this.value);


        });

        $(document).on('submit',"form[name='accountRegisterForm']",function (event) {
            
            var accountRegisterForm = $("form[name='accountRegisterForm']");

            var first_name = accountRegisterForm.find("input[name='first_name']").val();
            var surname = accountRegisterForm.find("input[name='surname']").val();
            var email = accountRegisterForm.find("input[name='email']").val();
            var confirm_email = accountRegisterForm.find("input[name='confirm_email']").val();
            var password = accountRegisterForm.find("input[name='password']").val();
            var password_confirmation = accountRegisterForm.find("input[name='password_confirmation']").val();
            var address_line1 = accountRegisterForm.find("input[name='address_line1']").val();
            var address_line2 = accountRegisterForm.find("input[name='address_line2']").val();
            var country = accountRegisterForm.find("#country :selected").val();

            //    return false;
            //    var state_province_region   =   accountRegisterForm.find("input[name='state_province_region']").val();
            var state_province_region = accountRegisterForm.find("#state_province_region :selected").val();
            var city = accountRegisterForm.find("input[name='city']").val();
            //    var city                    =   accountRegisterForm.find("#city :selected").text();
            var postal_code = accountRegisterForm.find("input[name='postal_code']").val();
            //    var country                 =   accountRegisterForm.find("input[name='country']").val();

            // var phone_country_code = accountRegisterForm.find("#phone_country_code :selected").val();
            var phone_country_code = accountRegisterForm.find("input[name='phone_country_code']").val();
            var phone = accountRegisterForm.find("input[name='phone']").val();
            // var mob_phone_country_code = accountRegisterForm.find("#mob_phone_country_code :selected").val();
            var mob_phone_country_code = accountRegisterForm.find("input[name='mob_phone_country_code']").val();
            var mob_phone = accountRegisterForm.find("input[name='mob_phone']").val();
            var age = accountRegisterForm.find("#age :selected").val();
            //    var image                   =   accountRegisterForm.find("input[name='image']").val();
            var image = accountRegisterForm.find("#image");//.val();
            var default_image = accountRegisterForm.find("input[name='default_image']:checked").val();
            
            var tell_us_about_you = accountRegisterForm.find("textarea[name=tell_us_about_you]").val();
            var detail_additional_information = accountRegisterForm.find("textarea[name=detail_additional_information]").val();
            var newsletter = accountRegisterForm.find("input[name='newsletter']").prop('checked');
            var classroom_contributions = accountRegisterForm.find("input[name='classroom_contributions']").prop('checked');
            var terms_and_conditions = accountRegisterForm.find("input[name='terms_and_conditions']").prop('checked');
            //    console.log(tell_us_about_you);
            //    return false;
            //    var formData = new FormData($('#image')[0]);
            //    var formData = new FormData();
            //    formData.append('file', document.getElementById("image").files[0]);
            //    formData.append('name', 'dogName');
            //    var files = $('#image')[0].files;
            //
            //    if(files.length > 0){
            //        var form_data = new FormData();
            //        // Append data 
            //        form_data.append('image',files[0]);
            //        console.log(form_data);
            //     }
            //    var file = $('#image')[0].files;
            //    var formData = new FormData(this);
            //        formData.append('file', file[0]);
            //        var options = { content: formData };
            //        console.log(options);
            //    for (var key of form_data.entries()) {
            //        console.log(key[0] + ', ' + key[1]);
            //    }

            //    for (var key of formData.entries()) {
            //            console.log(key[0] + ', ' + key[1])
            //    }
            //    console.log(formData);
            //    return false;
            //$("form[name='accountRegisterForm']").submit();
            $("#accountRegisterForm .error_msg").remove();
            if (first_name == "" || !first_name.replace(/\s/g, '').length) {
                $("input[name='first_name']").focus().select();
                $("input[name='first_name']").after('<span class="error text-danger error_msg">Enter your first name</span>');
                return false;
            }
            if (surname == "" || !surname.replace(/\s/g, '').length) {
                accountRegisterForm.find("input[name='surname']").focus().select();
                accountRegisterForm.find("input[name='surname']").after('<span class="error text-danger error_msg">Enter your last name</span>');
                return false;
            }
            /*if (address_line1 == "") {
             accountRegisterForm.find("input[name='address_line1']").focus().select();
             accountRegisterForm.find("input[name='address_line1']").after('<span class="error text-danger error_msg">Enter your address line1</span>');
             return false;
             }
             if (address_line2 == "") {
             accountRegisterForm.find("input[name='address_line2']").focus().select();
             accountRegisterForm.find("input[name='address_line2']").after('<span class="error text-danger error_msg">Enter your address line2</span>');
             return false;
             }*/
            if (country == "") {
                accountRegisterForm.find("#country").focus().select();
                accountRegisterForm.find("#countryQ").after('<span class="error text-danger error_msg">Select your country name</span>');
                return false;
            }
            if (state_province_region == "") {
                accountRegisterForm.find("#state_province_region").focus().select();
                accountRegisterForm.find("#state_province_regionQ").after('<span class="error text-danger error_msg">Select your State / Province / Region</span>');
                return false;
            }
            // if (city == "") {
            //     accountRegisterForm.find("input[name='city']").focus().select();
            //     accountRegisterForm.find("input[name='city']").after('<span class="error text-danger error_msg">Enter your city</span>');
            //     //        accountRegisterForm.find("#city :selected").focus().select();
            //     //        accountRegisterForm.find("#city :selected").after('<span class="error text-danger error_msg">Enter your city</span>');
            //     return false;
            // }
            var postal_code_minLength = 4;
            var postal_code_maxLength = 10;
            /*if (postal_code == "") {
             accountRegisterForm.find("input[name='postal_code']").focus().select();
             accountRegisterForm.find("input[name='postal_code']").after('<span class="error text-danger error_msg">Enter your ZIP / Postal Code</span>');
             return false;
             } else {
             var charLength = postal_code.length;
             if (charLength < postal_code_minLength) {
             accountRegisterForm.find("input[name='postal_code']").focus().select();
             accountRegisterForm.find("input[name='postal_code']").after('<span class="error text-danger error_msg">Length is short, minimum ' + postal_code_minLength + ' required.');
             return false;
             }
             if (charLength > postal_code_maxLength) {
             accountRegisterForm.find("input[name='postal_code']").focus().select();
             accountRegisterForm.find("input[name='postal_code']").after('<span class="error text-danger error_msg">Length is not valid, maximum ' + postal_code_maxLength + ' allowed.');
             return false;
             }
             }*/
            if (postal_code != '') {
                var charLength = postal_code.length;
                if (charLength < postal_code_minLength) {
                    accountRegisterForm.find("input[name='postal_code']").focus().select();
                    accountRegisterForm.find("input[name='postal_code']").after('<span class="error text-danger error_msg">Area code must be of ' + postal_code_minLength + ' digits.');
                    return false;
                }
                if (charLength > postal_code_maxLength) {
                    accountRegisterForm.find("input[name='postal_code']").focus().select();
                    accountRegisterForm.find("input[name='postal_code']").after('<span class="error text-danger error_msg">Length is not valid, maximum ' + postal_code_maxLength + ' allowed.');
                    return false;
                }
            }

            //  accountRegisterForm.find(("#postal_code").on('keydown keyup change', function(){console.log('keyup keydown');
            //    $('#postal_code').on('change keyup', function() {console.log('keyup keydown');
            //        var charLength = postal_code.length;
            //        if(charLength < postal_code_minLength){
            //            accountRegisterForm.find("input[name='postal_code']").focus().select();
            //            accountRegisterForm.find("input[name='postal_code']").after('<span class="error text-danger error_msg">Length is short, minimum '+postal_code_minLength+' required.');
            //            return false;
            //        } else if (charLength > postal_code_maxLength){
            //            accountRegisterForm.find("input[name='postal_code']").focus().select();
            //            accountRegisterForm.find("input[name='postal_code']").after('<span class="error text-danger error_msg">Length is not valid, maximum '+postal_code_maxLength+' allowed.');
            //            return false;
            //        } else {
            //            accountRegisterForm.find("input[name='postal_code']").after('.error_msg-message').text();
            ////            $('.error_msg-message').text('');
            //        }


            //        var char = $(this).val();
            //        var charLength = $(this).val().length;
            //        if(charLength < minLength){
            //            $('#warning-message').text('Length is short, minimum '+minLength+' required.');
            //        }else if(charLength > maxLength){
            //            $('#warning-message').text('Length is not valid, maximum '+maxLength+' allowed.');
            //            $(this).val(char.substring(0, maxLength));
            //        }else{
            //            $('#warning-message').text('');
            //        }
            //    });
            var phone_country_code_minLength = 1;
            var phone_country_code_maxLength = 5;
            if (phone_country_code != "") {
                /*accountRegisterForm.find("#phone_country_code").focus().select();
                 accountRegisterForm.find("#phone_country_codeQ").after('<span class="error text-danger error_msg">Enter your phone country code</span>');
                 return false;
                 } else {*/
                var charLength = phone_country_code.length;
                if (charLength < phone_country_code_minLength) {
                    accountRegisterForm.find("#phone_country_code").focus().select();
                    accountRegisterForm.find("#phone_country_codeQ").after('<span class="error text-danger error_msg">Length is short, minimum ' + phone_country_code_minLength + ' required.');
                    return false;
                }
                if (charLength > phone_country_code_maxLength) {
                    accountRegisterForm.find("#phone_country_code").focus().select();
                    accountRegisterForm.find("#phone_country_codeQ").after('<span class="error text-danger error_msg">Length is not valid, maximum ' + phone_country_code_maxLength + ' allowed.');
                    return false;
                }
            }
            var phone_minLength = 5;
            var phone_maxLength = 12;
            if (phone != "") {
                /*accountRegisterForm.find("#phone").focus().select();
                 accountRegisterForm.find("#phone").after('<span class="error text-danger error_msg">Enter your phone</span>');
                 return false;
                 } else {*/
                var charLength = phone.length;
                if (charLength < phone_minLength) {
                    accountRegisterForm.find("#phone").focus().select();
                    accountRegisterForm.find("#phone").after('<span class="error text-danger error_msg">Length is short, minimum ' + phone_minLength + ' required.');
                    return false;
                }
                if (charLength > phone_maxLength) {
                    accountRegisterForm.find("#phone").focus().select();
                    accountRegisterForm.find("#phone").after('<span class="error text-danger error_msg">Length is not valid, maximum ' + phone_maxLength + ' allowed.');
                    return false;
                }
            }
            if (mob_phone_country_code != "") {
                /*accountRegisterForm.find("#mob_phone_country_code").focus().select();
                 accountRegisterForm.find("#mob_phone_country_codeQ").after('<span class="error text-danger error_msg">Enter your mobile phone country code</span>');
                 return false;
                 } else {*/
                var charLength = mob_phone_country_code.length;
                if (charLength < phone_country_code_minLength) {
                    accountRegisterForm.find("#mob_phone_country_code").focus().select();
                    accountRegisterForm.find("#mob_phone_country_codeQ").after('<span class="error text-danger error_msg">Length is short, minimum ' + phone_country_code_minLength + ' required.');
                    return false;
                }
                if (charLength > phone_country_code_maxLength) {
                    accountRegisterForm.find("#mob_phone_country_code").focus().select();
                    accountRegisterForm.find("#mob_phone_country_codeQ").after('<span class="error text-danger error_msg">Length is not valid, maximum ' + phone_country_code_maxLength + ' allowed.');
                    return false;
                }
            }
            if (mob_phone != "") {
                /*accountRegisterForm.find("#mob_phone").focus().select();
                 accountRegisterForm.find("#mob_phone").after('<span class="error text-danger error_msg">Enter your mobile phone</span>');
                 return false;
                 } else {*/
                var charLength = mob_phone.length;
                if (charLength < phone_minLength) {
                    accountRegisterForm.find("#mob_phone").focus().select();
                    accountRegisterForm.find("#mob_phone").after('<span class="error text-danger error_msg">Length is short, minimum ' + phone_minLength + ' required.');
                    return false;
                }
                if (charLength > phone_maxLength) {
                    accountRegisterForm.find("#mob_phone").focus().select();
                    accountRegisterForm.find("#mob_phone").after('<span class="error text-danger error_msg">Length is not valid, maximum ' + phone_maxLength + ' allowed.');
                    return false;
                }
            }
            if (email == "") {
                accountRegisterForm.find("input[name='email']").focus().select();
                accountRegisterForm.find("input[name='email']").after('<span class="error text-danger error_msg">Enter your email</span>');
                return false;
            }

            //    var inputEmail = document.getElementById('account_email');
            //    inputEmail.oninvalid = function(event) {alert('hghgh');
            //        event.target.setCustomValidity('Username should only contain lowercase letters. e.g. john');
            //        return false;
            //    }
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            //pattern="^[^(\.)][a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}"
            if (!emailReg.test(email)) {
            //        $("#account_email").after('<span class="error">Enter a valid email address.</span>');
                accountRegisterForm.find("input[name='email']").focus().select();
                accountRegisterForm.find("input[name='email']").after('<span class="error text-danger error_msg">Enter a valid email address.</span>');
                return false;
            }
            if (confirm_email == "") {
                accountRegisterForm.find("input[name='confirm_email']").focus().select();
                accountRegisterForm.find("input[name='confirm_email']").after('<span class="error text-danger error_msg">Enter your confirm email</span>');
                return false;
            }
            if (!emailReg.test(confirm_email)) {
                //$("#account_email").after('<span class="error">Enter a valid email address.</span>');
                accountRegisterForm.find("input[name='confirm_email']").focus().select();
                accountRegisterForm.find("input[name='confirm_email']").after('<span class="error text-danger error_msg">Enter a valid email address.</span>');
                return false;
            }
            if (confirm_email != email) {
                accountRegisterForm.find("input[name='confirm_email']").focus().select();
                accountRegisterForm.find("input[name='confirm_email']").after('<span class="error text-danger error_msg">Confirm email can not be differ</span>');
                return false;
            }

            if (password == "") {
                accountRegisterForm.find("input[name='password']").focus().select();
                accountRegisterForm.find("input[name='password']").after('<span class="error text-danger error_msg">Enter password</span>');
                return false;
            }
            if (password_confirmation == "") {
                accountRegisterForm.find("input[name='password_confirmation']").focus().select();
                accountRegisterForm.find("input[name='password_confirmation']").after('<span class="error text-danger error_msg">Enter confirm password</span>');
                return false;
            }
            if (password !== password_confirmation) {
                accountRegisterForm.find("input[name='password_confirmation']").focus().select();
                accountRegisterForm.find("input[name='password_confirmation']").after("<span class='error text-danger error_msg'>Confirm password doesn't match!</span>");
                return false;
            }
            /*
            if (age == "") {
                accountRegisterForm.find("#age").focus().select();
                accountRegisterForm.find("#age").after('<span class="error text-danger error_msg">Enter your age</span>');
                return false;
            }
            */
            var profile_pic_filePath = image.val();
            if (profile_pic_filePath == '' && default_image == undefined) {
                accountRegisterForm.find("input[name='image']").focus().select();
                accountRegisterForm.find("#imageAndDefaultImage").after('<small class="text-danger error_msg">Please select image OR Use the Classroom Copy default image </small>');
                return false;
            }
            // if (tell_us_about_you == "") {
            //  accountRegisterForm.find("textarea[name=tell_us_about_you]").focus().select();
            //  accountRegisterForm.find("textarea[name=tell_us_about_you]").after('<span class="error text-danger error_msg">Enter Tell us about you</span>');
            //  return false;
            //  }
             /*if (detail_additional_information == "") {
             accountRegisterForm.find("#detail_additional_information").focus().select();
             accountRegisterForm.find("textarea[name=detail_additional_information]").after('<span class="error text-danger error_msg">Enter Detail any additional information</span>');
             return false;
             }
            if (newsletter == false) {
                accountRegisterForm.find("input[name='newsletter']").focus().select();
                accountRegisterForm.find("#newsletterLabel").after('</br><small class="text-danger error_msg">Please select our newsletter</small>');
                return false;
            }*/
            // if (classroom_contributions == false) {
            //     accountRegisterForm.find("input[name='classroom_contributions']").focus().select();
            //     accountRegisterForm.find("#classroomContributionsLabel").after('</br><small class="text-danger error_msg">Please select (Sign up to raise funds for your account through Classroom Contributions)</small>');
            //     return false;
            // }
            if (terms_and_conditions == false) {
                accountRegisterForm.find("input[name='terms_and_conditions']").focus().select();
                accountRegisterForm.find("#termsAndConditionsLabel").after('</br><small class="text-danger error_msg">Please accept our (Terms and Conditions , Privacy Policy , Intellectual Property Policy and Sellers Agreement)</small>');
                return false;
            }
            $(".sbmt-btn").prop('disabled',true);
        });

         $(document).ready(function () {
                $.ajax({
                    url: "{{route('get.allCountries.list')}}",
                    type: "POST",
                    data: {},
                    dataType: "json",
                    beforeSend: function (xhr) {}
                }).always(function () {
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        var country_select = $("#accountRegisterForm").find("select[name='country']");
                        var phone_country_code = $("#accountRegisterForm").find("select[name='phone_country_code']");
                        var mob_phone_country_code = $("#accountRegisterForm").find("select[name='mob_phone_country_code']");
        //                    country_select.find('option').remove();
        //                    country_select.append(`<option value="" selected>Please select your country</option>`);
                        $.each(response.data.countries, function (index, item) {
                            country_select.append(new Option(item.name + ' - ' + item.sortname, item.id));
        //                        country_select.append(new Option(item.name +' - '+ item.sortname, item.name));
                        });
                        $.each(response.data.countries, function (index, item) {
                            phone_country_code.append(new Option(item.phonecode + " - " + item.name, item.phonecode));
                        });
                        $.each(response.data.countries, function (index, item) {
                            mob_phone_country_code.append(new Option(item.phonecode + " - " + item.name, item.phonecode));
                        });
                    }
                    if (response.success === false) {
        //                swal.fire('Oops...', response.msg, 'error');
                        var country_select = $("#accountRegisterForm").find("select[name='country']");
        //                    country_select.find('option').remove();
        //                    country_select.append(`<option value="" selected>Please select your country</option>`);
                    }

                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {

                });

        //Get states by country:
                $('#accountRegisterForm #country').on('change', function () {
                    get_states(this.value);

                });
        });
        function get_states(country_id) {
            $("#accountRegisterForm").find("select[name='state_province_region']").attr('disabled',true);
            $.ajax({
                url: "{{route('get.statesByCountry.list')}}",
                type: "POST",
                data: {country_id: country_id},
                dataType: "json",
                beforeSend: function (xhr) {}
            }).always(function () {
            }).done(function (response, status, xhr) {
                $("#accountRegisterForm").find("select[name='state_province_region']").attr('disabled',false);
                if (response.success === true) {
                    let countryCode = response.country.sortname;
                    let phonecode = "+"+response.country.phonecode;
                    $('#mob-phone-country_code').val(phonecode).intlTelInput("setCountry", countryCode);
                    $('#phone-country-code').val(phonecode).intlTelInput("setCountry", countryCode);
                    var state_select = $("#accountRegisterForm").find("select[name='state_province_region']");
                    state_select.html('');
                        //                    state_select.find('option').remove();
                        //                    state_select.append(`<option selected>Please select your state / Province/ Region</option>`);
                    $.each(response.data.states_by_country, function (index, item) {
                        state_select.append(new Option(item.name, item.name));
                        //                        state_select.append(new Option(item.name, item.name));
                    });
                }
                if (response.success === false) {
                    //                swal.fire('Oops...', response.msg, 'error');
                    var state_select = $("#accountRegisterForm").find("select[name='state_province_region']");
                    state_select.html('');
                    //                    state_select.find('option').remove();
                    //                    state_select.append(`<option selected>Please select your state / Province/ Region</option>`);
                }

            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $("#accountRegisterForm").find("select[name='state_province_region']").attr('disabled',false);
            });
        }


    });


</script>
@endpush