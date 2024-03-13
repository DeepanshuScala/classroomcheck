@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<?php
$ogimage = url('images/logo.png');
?>
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>SOCIAL MEDIA CONTRIBUTIONS</h1>
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
        <div class="row mt-4">
            <div class="col-md-9">
                <div class="host-a-sale-txt">
                    <p>We love sharing your creations, thoughts, quotes, tips and more on our social media! </p>

                    <p>If you would like to share something on Classroom Copy social media, please complete the following form for consideration. <br><br>Note: We also search through Instagram for images to share by looking through the hashtag #Classroom Copy. 
                    
                    </p>
                </div>
                
            </div>
           <div class="col-md-3 text-end">
                <div class="text-muted text-capitalize text-size">Share This Resourse
                    <ul class="social-icons d-flex flex-lg-row ps-0 mt-3 justify-content-end">
                        <li>
                            <a href="http://www.facebook.com/sharer.php?u={{urlencode(Request::url())}}" target="_blank"><img src="{{asset('images/emailer-facebook.png')}}" class="img-fluid me-2" alt="facebook"></a>
                        </li>
                        <li>
                            <a href="http://pinterest.com/pin/create/button/?description=socialmediacontributions&url={{Request::url()}}" target="_blank"><img src="{{asset('images/emailer-pinterest.png')}}" class="img-fluid me-2" alt="pinterest"></a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{urlencode(Request::url())}}" target="_blank"><img src="{{asset('images/emailer-linkedin.png')}}" class="img-fluid me-2" alt="pinterest"></a>
                        </li>
                    </ul>
                </div>
           </div>
        </div>
    </div>
</section>
<!-- page title end  -->
<section class="inner_page pt-0">
    <div class="container">
        <div class="row ">
            <div class="col-12">
                <div class="inner_page_title">
                    
                </div>
            </div>
        </div> 
        <form class="custom-form" method="post" action="{{route('socialMedia.seller')}}" enctype="multipart/form-data">
            @csrf 
            <div class="row mb-4 align-items-center ">
                <div class="col-md-3 col-12">
                <div class="labels">
                    <p>Classroom Copy Store URL:</p>
                </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <input type="url" name="storeurl" class="form-custom-input" value="" placeholder="URL" >
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-center ">
                <div class="col-md-3 col-12">
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
            <div class="row mb-4 align-items-center  ">
                <div class="col-md-3 col-12">
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
            <div class="row mb-4 align-items-center ">
                <div class="col-md-3 col-12">
                <div class="labels">
                    <p>Store Facebook URL:</p>
                </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <input type="url" name="store_fb_url" class="form-custom-input" placeholder="Optional">
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-center ">
                <div class="col-md-3 col-12">
                <div class="labels">
                    <p>Store Instagram URL:</p>
                </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <input type="url" name="store_insta_url" class="form-custom-input" placeholder="Optional">
                    </div>
                </div>
            </div>
             <div class="row mb-4 align-items-start">
                <div class="col-md-3 col-12">
                    <div class="labels">
                        <p>Submission Type:</p>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt d-sm-flex justify-content-between">
                        <div class="form-check form-check-inline custom-check">
                            <input class="form-check-input8" type="radio" name="submission_type" id="inlineRadio1" value="tips" >
                            <label class="form-check-label" for="inlineRadio1">Tips
                            </label>
                          </div>
                          <div class="form-check form-check-inline custom-check">
                            <input class="form-check-input8" type="radio" name="submission_type" id="inlineRadio2" value="quote">
                            <label class="form-check-label" for="inlineRadio2">Quote</label>
                          </div>
                          <div class="form-check form-check-inline custom-check">
                            <input class="form-check-input8" type="radio" name="submission_type" id="inlineRadio3" value="resource">
                            <label class="form-check-label" for="inlineRadio3">Resource</label>
                          </div>
                          <div class="form-check form-check-inline custom-check" id="labelValidation">
                            <input class="form-check-input8" type="radio" name="submission_type" id="inlineRadio4" value="story">
                            <label class="form-check-label" for="inlineRadio4">Story</label>
                          </div>
                    </div>
                    <div class="profile-txt mt-3">
                        <input type="text" name="submission_type_details" class="form-custom-input" placeholder="Please Detail" >
                    </div>
                </div>
            </div>
           <div class="row mb-4 align-items-center ">
                <div class="col-md-3 col-12">
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
            </div>
           <div class="row mb-4 align-items-center  ">
                <div class="col-md-3 col-12">
                    <div class="labels">
                        <p>Resource Subject:</p>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <?php
                        $productSubjectArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductSubjectArea();
                        ?>
                        <select name="resource_subject" class=" form-custom-input position-relative form-select" >
                            <option value="">Select Most Appropriate</option>
                            @foreach($productSubjectArr as $productSubject)
                                <option value="{{$productSubject->name}}">{{$productSubject->name}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-start">
                <div class="col-md-3 col-12">
                <div class="labels">
                    <p>Share / Explain Submission:</p>
                </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt ">
                        <textarea name="explain_submission" rows="5"  class="form-custom-input" ></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-4 align-items-start">
                <div class="col-md-3 col-12">
                <div class="labels">
                    <p>Photo / Video:</p>
                </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="profile-txt imagediv">
                        <div class="drop-zone justify-content-start drop-height">
                            <h4 class="drop-zone__prompt">Drag File Here </h4>
                            <input type="file" name="media" class="drop-zone__input">
                        </div>
                        <span class="my-3">Max File Size: 50 MB</span>
                    </div>
                </div>
            </div>
           <div class="row mb-4">
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" >
                        <label class="form-check-label pt-1" for="flexCheckDefault" id="please-accept">
                            I understand and agree that Classroom Copy may use the content I have submitted for its own present and future marketing or<br> promotional purposes, including but not limited to, the purposes identified in this form. 

                        </label>
                      </div>
                </div>
                
            </div>
                
            <div class="mt-5 text-center">
                <input type="submit" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase " value="Submit">
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

            var store_url = socialmediaform.find("input[name='storeurl']").val();
            var store_name = socialmediaform.find("input[name='store_name']").val();
            var email = socialmediaform.find("input[name='email']").val();
            var submission_type = socialmediaform.find("input[name='submission_type']:checked").val();
            var submission_type_details = socialmediaform.find("input[name='submission_type_details']").val();
            var resource_grade = socialmediaform.find("select[name='resource_grade'] :selected").val();
            var resource_subject = socialmediaform.find("select[name='resource_subject'] :selected").val();
            var explain_submission = socialmediaform.find("textarea[name=explain_submission]").val();
            var media = socialmediaform.find("input[name='media']").val();
            var check = socialmediaform.find("input#flexCheckDefault").prop('checked');
            $("form.custom-form .error_msg").remove();
            
            if (store_url == "") {
                $("input[name='storeurl']").focus().select();
                $("input[name='storeurl']").after('<span class="error text-danger error_msg">Enter your store url</span>');
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
            if (typeof submission_type === 'undefined') {
                $('input[name=submission_type]').css('box-shadow', '0 0 2px 0 red');
                socialmediaform.find('input[name="submission_type"]').focus().select();
                socialmediaform.find("#labelValidation").after('<span class="error text-danger error_msg"></br>Please Select Submission Type</span>');
                return false;
            }
            
            if (submission_type_details == "") {
                socialmediaform.find("input[name='submission_type_details']").focus().select();
                socialmediaform.find("input[name='submission_type_details']").after('<span class="error text-danger error_msg">Enter your Submission Details</span>');
                return false;
            }
            
            if (resource_grade == "") {
                socialmediaform.find("select[name='resource_grade']").focus().select();
                socialmediaform.find("select[name='resource_grade']").after('<span class="error text-danger error_msg">Select your Resource grade</span>');
                return false;
            }

            if (resource_subject == "") {
                socialmediaform.find("select[name='resource_subject']").focus().select();
                socialmediaform.find("select[name='resource_subject']").after('<span class="error text-danger error_msg">Select your Resource Subject</span>');
                return false;
            }
           
            if (explain_submission == "") {
                socialmediaform.find("textarea[name='explain_submission']").focus().select();
                socialmediaform.find("textarea[name='explain_submission']").after('<span class="error text-danger error_msg">Enter your explain submission</span>');
                return false;
            }

            
            if (media == '') {
                socialmediaform.find("input[name='image']").focus().select();
                socialmediaform.find(".profile-txt.imagediv").after('<small class="text-danger error_msg">Please add photo or video </small>');
                return false;
            }
           
            if (check == false) {
                socialmediaform.find("input#flexCheckDefault").focus().select();
                socialmediaform.find("#please-accept").after('</br><small class="text-danger error_msg">Please accept it.</small>');
                return false;
            }
        });
    });

</script>
@endpush
