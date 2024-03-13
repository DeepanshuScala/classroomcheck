@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--My Profile Section Starts Here-->
<section class="my_profile-section pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12  col-sm-12 col-md-8 col-lg-8 py-4">
                <h1 class="text-uppercase py-3"> My Profile</h1>
                <div class="position-relative profile-pic-box mb-5">
                    <img style="width:150px;height: 150px;" id="profileImageView"  src="{{ !empty(auth()->user()->image) ? Storage::disk('s3')->url('profile_picture/'.auth()->user()->image) : asset('images/book-img.png')}}" class="img-fluid rounded-circle" alt="myprofile-pic">
                    <div class="profile-pic-icon position-absolute  ">
                        <a href="javascript:void(0)"><img id="selectImgClick" src="{{asset('images/camera-icon.png')}}" alt="camera-icon " class="img-fluid "></a>
                        <form method="POST" enctype="multipart/form-data" name="profileImageUpdateForm" id="profileImageUpdateForm" action="javascript:void(0)" >
                            @csrf
                            <input type="file" name="profileImage" id="profileImage" class="drop-zone__inputQ" style="display: none;">
                        </form>
                    </div>
                </div>


                <div class="row mb-4 ">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-3 ">
                        <label class="form-label fw-bold "> Username:  </label>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-9 ">
                        <label class="form-label text-muted "><span class=""> {{auth()->user()->email}}</span> <a href="javascript:void(0)"><i data-input_name="email" data-modal_title="Update your Email:" class='fal fa-pencil fa-xs blue px-4 clickProfileEdit' ></i></a></label>
                    </div>
                </div>

                <div class="row mb-4 ">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-3 ">
                        <label class="form-label fw-bold float-start "> Name: </label>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-9 ">
                        <label class="form-label text-muted full_name_display"><span class=""> {{auth()->user()->first_name.' '.auth()->user()->surname}}</span> <a href="javascript:void(0)"><i data-input_name="full_name" data-modal_title="Update your name:" class='fal fa-pencil fa-xs blue px-4 clickProfileEdit' ></i></a></label>
                    </div>
                </div>

                <div class="row mb-4 ">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-3 ">
                        <label class="form-label fw-bold float-start "> Address:</label>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-9 ">
                        <label class="form-label text-muted address_display"><span class="address_display1"> 
                                {{auth()->user()->address_line1}} {{auth()->user()->address_line2}} {{auth()->user()->city}}</span>
                            <br>
                            <span class="address_display2">{{auth()->user()->state_province_region}} {{auth()->user()->country}} </span>
                            <a href="javascript:void(0)"><i data-input_name="address" data-modal_title="Update your full address:" class='fal fa-pencil fa-xs blue px-2 clickProfileEdit' ></i></a></label>
                    </div>
                </div>

                <div class="row mb-4 ">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-3 ">
                        <label class="form-label fw-bold float-start "> Phone:  </label>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-9 ">
                        <label class="form-label text-muted phone_display">
                            <span class=""> 
                                @if(auth()->user()->phone)
                                    ({{ auth()->user()->phone_country_code}}) {{auth()->user()->phone}}
                                @else
                                    Add Number
                                @endif
                            </span> 
                            <a href="javascript:void(0)"><i data-input_name="phone" data-modal_title="Update your phone:" class='fal fa-pencil fa-xs blue px-4 clickProfileEdit' ></i></a>
                        </label>
                    </div>
                </div>

                <div class="row mb-4 ">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-3 ">
                        <label class="form-label fw-bold float-start "> Email:</label>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-9 ">
                        <label class="form-label text-muted "><span> {{auth()->user()->email}}</span> <a href="javascript:void(0)"><!-- <i class='fal fa-pencil fa-xs blue px-2' ></i> --></a></label>
                    </div>
                </div>

                <div class="row mb-4 ">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-3 ">
                        <label class="form-label fw-bold float-start "> Password:</label>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-9 ">
                        <label class="form-label text-muted "> * * * * * * * * <a id="changePwdOpenModal" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#changePwdModal"><i class='fal fa-pencil fa-xs blue px-4' ></i></a></label>
                    </div>
                </div>

                <div class="row mb-4 ">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-3 ">
                        <label class="form-label fw-bold float-start "> Marketing:</label>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-9 px-0">
                        <div class="d-flex align-items-center pb-3">
                            <label class="switch_box me-3">
                                <input type="checkbox" class="switch_1" name="newsletter" id="newsletter" <?php if ($user->getUserSettings->newsletter == 1) { ?> checked="" <?php } ?>>
                            </label>
                            <label class="form-check-label" for="flexSwitchCheckChecked">Newsletter
                            </label>
                            <i class="fa fa-spin fa-cog" id="newletterSpinner" style="display: none"></i>
                        </div>

                        <div class="d-flex align-items-center pb-3 ">
                            <label class="switch_box me-3">
                                <input type="checkbox" class="switch_1" name="recommendation" id="recommendation" <?php if ($user->getUserSettings->recommendation == 1) { ?> checked="" <?php } ?>>
                            </label>
                            <label class="form-check-label text-muted " for="flexSwitchCheckDefault ">Recommendations
                            </label>
                            <i class="fa fa-spin fa-cog" id="recommendationSpinner" style="display: none"></i>
                        </div>

                        <div class="d-flex align-items-center pb-3 ">
                            <label class="switch_box me-3">
                                <input type="checkbox" class="switch_1" name="special_offer_sale" id="special_offer_sale" <?php if ($user->getUserSettings->special_offer_sale == 1) { ?> checked="" <?php } ?>>
                            </label>
                            <label class="form-check-label text-muted " for="flexSwitchCheckDisabled ">Special Offers and Sales
                            </label>
                            <i class="fa fa-spin fa-cog" id="special_offer_saleSpinner" style="display: none"></i>
                        </div>

                        <div class="d-flex align-items-center pb-3 ">
                            <label class="switch_box me-3">
                                <input type="checkbox" class="switch_1" name="marketing_from_fav_seller" id="marketing_from_fav_seller" <?php if ($user->getUserSettings->marketing_from_fav_seller == 1) { ?> checked="" <?php } ?>>
                            </label>
                            <label class="form-check-label text-muted " for="flexSwitchCheckChecked">Marketing from Favourite Sellers
                            </label>
                            <i class="fa fa-spin fa-cog" id="marketing_from_fav_sellerSpinner" style="display: none"></i>
                        </div>
                        <?php
                        /*
                        <div class="d-flex align-items-center pb-3 ">
                            <label class="switch_box me-3">
                                <input type="checkbox" class="switch_1" name="buyers_feedback" id="buyers_feedback" <?php if ($user->getUserSettings->buyers_feedback == 1) { ?> checked="" <?php } ?>>
                            </label>
                            <label class="form-check-label text-muted " for="flexSwitchCheckCheckedDisabled ">Buyers Feedback (Sellers Only)
                            </label>
                            <i class="fa fa-spin fa-cog" id="buyers_feedbackSpinner" style="display: none"></i>
                        </div>
                        */
                        ?>
                        <?php
                            $c = DB::table("countries")->select(['id'])->where('name',auth()->user()->country)->first();
                            $s = DB::table("states")->select(['name'])->where('name',auth()->user()->state_province_region)->first();
                        ?>
                        <div class="d-flex align-items-center pb-3 ">
                            <label class="switch_box me-3">
                                <input type="checkbox" class="switch_1" name="sales_alert" id="sales_alert" <?php if ($user->getUserSettings->sales_alert == 1) { ?> checked="" <?php } ?>>
                            </label>
                            <label class="form-check-label text-muted " for="flexSwitchCheckChecked ">Sales Alerts
                            </label>
                            <i class="fa fa-spin fa-cog" id="sales_alertSpinner" style="display: none"></i>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <a class="btn btn-danger text-uppercase w-200 mx-auto delete-account" href="{{url('/deactivate-account/'.auth()->user()->id)}}">Deactivate My Account</a>
                </div>
                <!--                    <div class="row mb-4 ">
                                        <div class="col-4 col-sm-4 col-md-4 col-lg-3 ">
                                            <label class="form-label fw-bold float-start "> Favourite Sellers:</label>
                                        </div>
                
                
                                        <div class="col-8 col-sm-8 col-md-8 col-lg-9 d-flex flex-column align-items-start fav-sellers">
                                            <label class="form-label mb-5 d-flex flex-row align-items-center "><img src="{{asset('images/Brit.jpg')}}" alt="Brit " class="img-fluid me-4 ">
                                                <a href="{{route('store.products')}}" class="text-muted float-start ">Brit Girl</a><span  class="px-5 "><a href="# "> <i class='fal fa-times-circle fa-lg blue' ></i></a></span></label>
                                            <label class="form-label d-flex flex-row align-items-center "><img src="{{asset('images/Kath.jpg')}}" alt="Kath " class="img-fluid me-4 ">
                                                <a href="{{route('store.products')}}" class="text-muted float-start "> Kath Smith</a><span class="px-3 "><a href="# "><i class='fal fa-times-circle fa-lg blue ' ></i></a></span></label>
                                        </div>
                                        <div class="col-8 col-sm-8 col-md-8 col-lg-9 d-flex flex-column align-items-start fav-sellers">
                                            <ul class="d-flex flex-row align-items-center ps-0">
                                                <li><img src="{{asset('images/Brit.jpg')}}" alt="Brit " class="img-fluid "></li>
                                                <li><a href="{{route('store.products')}}" class="text-muted float-start ">Brit Girl</a></li>
                                                <li><a href="# "> <i class='fal fa-times-circle fa-lg blue' ></i></a></li>
                                            </ul>
                                            <ul class="d-flex flex-row align-items-center  ps-0">
                                                <li><img src="{{asset('images/Kath.jpg')}}" alt="Kath " class="img-fluid"></li>
                                                <li><a href="{{route('store.products')}}" class="text-muted float-start "> Kath Smith</a></li>
                                                <li><a href="# "><i class='fal fa-times-circle fa-lg blue ' ></i></a></li>
                                            </ul>
                
                                        </div>
                                    </div>-->
            </div>



            <div class="col-12 col-sm-12 col-md-4 col-lg-4 pt-5 ">
                <div class="text-end pb-5 my_purchase_history-right">
                    <a href="{{route('account.dashboard')}}" class="blue acc-dashboard "><img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1 " alt=" ">Account Dashboard</a>
                </div>
                <!--<div class="float-end mobile-user"><img src="{{asset('images/mobile-user-pic.jpg')}}" class="img-fluid " alt="mobile-user-pic "></div>-->
            </div>

        </div>

    </div>
</section>
@include('modal.change_password_popup_modal')
@include('modal.personal_details_update_modal')
<!--My Profile Section Ends Here-->
@endsection

@push('script')
<script>
    //Click to select image:
    $('#selectImgClick').click(function () {
        $("#personalDetailsUpdateForm .error_msg").remove();
        $("#personalDetailsUpdateForm .alert").remove();
        var personalDetailsUpdateForm1 = $('form[name="personalDetailsUpdateForm"]');
        var personalDetailsUpdateModal1 = $('#personalDetailsUpdateModal');
        $('#personalDetailsUpdateModal #inputContainer').html('');
        personalDetailsUpdateModal1.modal('show');

        personalDetailsUpdateModal1.find('#modalTitleView').html('Profile Picture');

        var emailInput = `  <div id="inputContainer">
                               
                                <div class="row align-items-center" id="imageAndDefaultImage">
                                    <div class="col-md-12 mb-4 col-12">
                                        <div class="profile-txt text-center mb-3 mb-md-0">
                                            <img src="{{asset('images/book-img.png')}}" alt="" class=" dtf-img resize-img mx-auto">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 ">
                                        <div class="profile-txt ">
                                            <div class="mb-3">
                                                <input type="file" class="form-custom-input" placeholder="Select file from computer" name="pimage" id="image" onchange="readURL(this);">
                                                <span class="my-3">Supported File Types: .jpg, .jpeg, .png, .gif, .tif, .tiff<br>
                                                Max File Size: 5Mb</span>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="default_image" id="flexCheckDefaultW" value="1">
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
                                <input type="text" name="profileimage" value="1" style="display:none">
                            </div>
                            `;
        
        personalDetailsUpdateForm1.find('input:hidden').after(emailInput);
    });
    // $("input[name='profileImage']").change(function () {
        //     var val = $(this).val();

        //     if (!val.match(/(?:bmp|gif|jpg|jpeg|png|tif|tiff)$/)) {
        //         // inputted file path is not an image of one of the above types:
        //         Swal.fire({
        //             title: 'Oops...',
        //             text: 'The profile image must be an image!',
        //             icon: 'error',
        //             showConfirmButton: false,
        //             allowOutsideClick: false,
        //             allowEscapeKey: false,
        //             timer: 3000
        //         });
        //         return false;
        //     }

        //     readURL(this);
        //     $("form[name='profileImageUpdateForm']").submit();
    // });
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

    $('#profileImageUpdateForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('profileImage.update')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response.success === true) {
                    $("#headerProfileImageUpdate").attr('src', response.img);
                    Swal.fire({
                        title: 'Done!',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: false,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 3000
                    });
                }
                if (response.success === false) {
                    $("#profileImageView").attr('src', response.img);
                    $("#headerProfileImageUpdate").attr('src', response.img);
                    Swal.fire({
                        title: 'Oops...',
                        text: response.message,
                        icon: 'error',
                        showConfirmButton: false,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 3000
                    });
                }

            },
            error: function (err) {
                $("#profileImageView").attr('src', err.img);
                $("#headerProfileImageUpdate").attr('src', err.img);
                Swal.fire({
                    title: 'Oops...',
                    text: err.message,
                    icon: 'error',
                    showConfirmButton: false,
                    //closeOnClickOutside: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 3000
                });
            }
        });
    });
</script>
<script>
    $('#changePwdOpenModal').click(function (event) {
        $('form[name="changePwdForm"]')[0].reset();

        $("#changePwdForm .error_msg").remove();
        $("#changePwdErrorMessageDiv").remove();
        $("#changrPwdSuccessMessageDiv").remove();
    });
    $("form[name='changePwdForm']").submit(function (event) {
        event.preventDefault();
        $("#changePwdSubmitBtn").prop('disabled', true);
        $("#changePwdSubmitBtn").text('Processing...');

        var changePwdForm = $("form[name='changePwdForm']");

        var current_password = changePwdForm.find("input[name='current_password']").val();
        var new_password = changePwdForm.find("input[name='password']").val();
        var confirm_new_password = changePwdForm.find("input[name='password_confirmation']").val();

        $("#changePwdForm .error_msg").remove();
        $("#changePwdErrorMessageDiv").remove();
        $("#changrPwdSuccessMessageDiv").remove();

        if (current_password == "") {
            changePwdForm.find("input[name='current_password']").focus().select();
            changePwdForm.find("input[name='current_password']").after('<span class="error text-danger error_msg">Enter your current password</span>');
            $("#changePwdSubmitBtn").prop('disabled', false);
            $("#changePwdSubmitBtn").text('Submit');
            return false;
        }
        if (new_password == "") {
            changePwdForm.find("input[name='password']").focus().select();
            changePwdForm.find("input[name='password']").after('<span class="error text-danger error_msg">Enter your new password</span>');
            $("#changePwdSubmitBtn").prop('disabled', false);
            $("#changePwdSubmitBtn").text('Submit');
            return false;
        }
        if (confirm_new_password == "") {
            changePwdForm.find("input[name='password_confirmation']").focus().select();
            changePwdForm.find("input[name='password_confirmation']").after('<span class="error text-danger error_msg">Enter confirm password</span>');
            $("#changePwdSubmitBtn").prop('disabled', false);
            $("#changePwdSubmitBtn").text('Submit');
            return false;
        }
        if (new_password !== confirm_new_password) {
            changePwdForm.find("input[name='password_confirmation']").focus().select();
            changePwdForm.find("input[name='password_confirmation']").after('<span class="error text-danger error_msg">Confirm password was not matched!</span>');
            $("#changePwdSubmitBtn").prop('disabled', false);
            $("#changePwdSubmitBtn").text('Submit');
            return false;
        }

        var url = "{{route('accountDashboard.changePwd.post')}}";
        $.ajax({
            url: url, type: 'POST', data: {current_password: current_password, password: new_password, password_confirmation: confirm_new_password, _token: '{{ csrf_token() }}'},
        }).done(function (response, status, xhr) {
            if (response.success === true) {
                $("#changePwdSubmitBtn").prop('disabled', false);
                $("#changePwdSubmitBtn").text('Submit');
                $("#changePwdError_message").after(`<div class="alert alert-success alert-dismissible fade show" id="changrPwdSuccessMessageDiv">
                <strong>Success!</strong> ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`);
                setTimeout(function () {
                    $('#changePwdModal').modal('hide')
                }, 3000);
            }
            if (response.success === false) {
                $("#changePwdSubmitBtn").prop('disabled', false);
                $("#changePwdSubmitBtn").text('Submit');
                $("#changePwdError_message").after(`<div class="alert alert-danger alert-dismissible fade show" id="changePwdErrorMessageDiv">
                <strong>Error!</strong> ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`);
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            $("#changePwdSubmitBtn").prop('disabled', false);
            $("#changePwdSubmitBtn").text('Submit');
            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
                //                    $(".swal2-confirm").click(function(){
                //                        location.reload();
                //                    });
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    swal.fire(xhr.responseJSON.message, "Please try again", "error");
                    //                        $(".swal2-confirm").click(function(){
                    //                            location.reload();
                    //                        });
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                    //                        $(".swal2-confirm").click(function(){
                    //                            location.reload();
                    //                        });
                }
            }
        });
    });
</script>
<script>
    $('body .clickProfileEdit').click(function (event) {
        $("#personalDetailsUpdateForm .error_msg").remove();
        $("#personalDetailsUpdateForm .alert").remove();
        var personalDetailsUpdateForm = $('form[name="personalDetailsUpdateForm"]');
        var personalDetailsUpdateModal = $('#personalDetailsUpdateModal');

        personalDetailsUpdateForm[0].reset();
        personalDetailsUpdateForm.find("#inputContainer").remove();
        //personalDetailsUpdateForm.find('input[name="surname"]').remove();
        personalDetailsUpdateModal.modal('show');

        var input_name = $(this).data("input_name");
        var modal_title = $(this).data("modal_title");
        //Update email
        if(input_name == 'email'){
            let email = '{{auth()->user()->email}}';
            personalDetailsUpdateModal.find('#modalTitleView').html(modal_title);
            var emailInput = `<div class="alert alert-warning" role="alert">
                              This will also update your seller account email address
                            </div>
                            <div id="inputContainer">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email:</label>
                                        <input type="email" class="form-control" name="email" id="email" value="${email}" placeholder="Enter your first email.">
                                    </div>
                                    <div class="mb-3">
                                        <label for="cemail" class="form-label">Confirm Email:</label>
                                        <input type="email" class="form-control" name="cemail" id="cemail" value="" placeholder="Confirm email.">
                                    </div>
                                </div>`;
            personalDetailsUpdateForm.find('input:hidden').after(emailInput);
        }
        //Update Name:
        if (input_name == 'full_name') {
            let firstName = '{{auth()->user()->first_name}}';
            let surName = '{{auth()->user()->surname}}';
            personalDetailsUpdateModal.find('#modalTitleView').html(modal_title);
            var nameInput = `<div id="inputContainer">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name:</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="${firstName}" placeholder="Enter your first name.">
                                    </div>
                                    <div class="mb-3">
                                        <label for="surname" class="form-label">Surname</label>
                                        <input type="text" class="form-control" name="surname" id="surname" value="${surName}" placeholder="Enter your Surname.">
                                    </div>
                                </div>`;
            personalDetailsUpdateForm.find('input:hidden').after(nameInput);
        }
        //Update Address:
        if (input_name == 'address') {
            let address_line1 = '{{auth()->user()->address_line1}}';
            let address_line2 = '{{auth()->user()->address_line2}}';
            let country = '{{$c->id}}';
            let state_province_region = '{{ (!empty($s))?$s->name:""}}';

            let city = '{{auth()->user()->city}}';
            let code = '{{auth()->user()->postal_code}}';
            personalDetailsUpdateModal.find('#modalTitleView').html(modal_title);
            var addressInput = `<div id="inputContainer">
                                        <div class="mb-3">
                                            <label for="address_line1" class="form-label">Address Line 1:</label>
                                            <input type="text" class="form-control" name="address_line1" id="address_line1" value="${address_line1}" placeholder="Enter addressline1.">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address_line2" class="form-label">Address Line 2:</label>
                                            <input type="text" class="form-control" name="address_line2" id="address_line2" value="${address_line2}" placeholder="Enter address line2.">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address_line2" class="form-label">City:</label>
                                            <input type="text" class="form-control" name="city" id="address_line2" value="${city}" placeholder="Enter City.">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address_line2" class="form-label">Country:</label>
                                            <select class="form-select" name="country" id="country">
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address_line2" class="form-label">State / Province / Region:</label>
                                            <select class="form-select" name="state_province_region" id="state_province_region">
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address_line2" class="form-label">Area Code:</label>
                                            <input type="text" class="form-control" name="postal_code" id="postal_code" value="${code}" placeholder="Area Code">
                                        </div>
                                    </div>`;
            personalDetailsUpdateForm.find('input:hidden').after(addressInput);
    //            get_country_list();
            $.ajax({
                url: "{{route('get.allCountries.list')}}",
                type: "POST",
                data: {},
                dataType: "json",
                beforeSend: function (xhr) {}
            }).always(function () {
            }).done(function (response, status, xhr) {
                if (response.success === true) {
                    var country_select = $('form[name="personalDetailsUpdateForm"]').find("select[name='country']");
                    country_select.find('option').remove();
                    country_select.append(`<option>Please select your country</option>`);
                    $.each(response.data.countries, function (index, item) {
                        country_select.append(new Option(item.name + ' - ' + item.sortname, item.id));
                        //                        country_select.append(new Option(item.name +' - '+ item.sortname, item.name));
                    });
                    $('#country').val(country).trigger('change');
                }
                if (response.success === false) {
                    //swal.fire('Oops...', response.msg, 'error');
                    var country_select = $('form[name="personalDetailsUpdateForm"]').find("select[name='country']");
                    country_select.find('option').remove();
                    country_select.append(`<option selected>Please select your country</option>`);
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {});
            $(".select2").select2({
                theme: "bootstrap-5",
            });
        }

        //Update Phone:
        if (input_name == 'phone') {
            let phone = '{{auth()->user()->phone}}';
            let phone_country_code = '{{auth()->user()->phone_country_code}}';
            personalDetailsUpdateModal.find('#modalTitleView').html(modal_title);
            var phoneInput = `<div id="inputContainer">
                                        <div class="row mb-4 align-items-center">
                                            <div class="col-md-2 col-12">
                                            <div class="labels">
                                                <p class="m-0">Phone:</p>
                                            </div>
                                            </div>
                                            <div class="col-md-10 col-12">
                                                <div class="row align-items-center g-0">
                                                    <div class="col-md-4 col-3 ">
                                                        <div class="profile-txt mb-md-0">
                                                             <input type="text" class="text-center pe-0 form-control border-end-0 rounded-start rounded-0" placeholder="Country Code" id="phone_country_code" name="phone_country_code" value="${phone_country_code}"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" onkeydown="return false;"> 
                                                        </div>
                                                    </div>
                                                   <div class="col-md-8 col-9">
                                                         <input type="text" class="form-control border-start-0 ps-0 rounded-end rounded-0" placeholder="Enter your Phone" name="phone" id="phone" value="${phone}"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="limitToNumbers(this)">
                                                    </div>
                                                </div>
                                                <!-- <div class="profile-txt ">
                                                    <input type="text" class="form-custom-input" placeholder="">
                                                </div> -->
                                            </div>

                                        </div>
                                    </div>`;
            personalDetailsUpdateForm.find('input:hidden').after(phoneInput);
            $('#phone_country_code').val('+'+phone_country_code).intlTelInput({preferredCountries:["au","us", "gb","nz"]});
        }

    });

    $('#personalDetailsUpdateForm').submit(function (e) {
        e.preventDefault();
        $("#personalDetailsUpdateForm .error_msg").remove();
        var personalDetailsUpdateForm = $('form[name="personalDetailsUpdateForm"]');
        var first_name = personalDetailsUpdateForm.find("input[name='first_name']").val();
        var surname = personalDetailsUpdateForm.find("input[name='surname']").val();
        var address_line1 = personalDetailsUpdateForm.find("input[name='address_line1']").val();
        var address_line2 = personalDetailsUpdateForm.find("input[name='address_line2']").val();
        var phone = personalDetailsUpdateForm.find("input[name='phone']").val();
        var email = personalDetailsUpdateForm.find("input[name='email']").val();
        var cemail = personalDetailsUpdateForm.find("input[name='cemail']").val();

        if(cemail == ""){
            personalDetailsUpdateForm.find("input[name='cemail']").focus().select();
            personalDetailsUpdateForm.find("input[name='cemail']").after('<span class="error text-danger error_msg">Confirm Email is required</span>');
            return false;
        }

        if(email != cemail){
            personalDetailsUpdateForm.find("input[name='cemail']").focus().select();
            personalDetailsUpdateForm.find("input[name='cemail']").after('<span class="error text-danger error_msg">Please Enter Same Email</span>');
            return false;
        }

        if (first_name == "") {
            personalDetailsUpdateForm.find("input[name='first_name']").focus().select();
            personalDetailsUpdateForm.find("input[name='first_name']").after('<span class="error text-danger error_msg">Enter your first name</span>');
            return false;
        }
        if (surname == "") {
            personalDetailsUpdateForm.find("input[name='surname']").focus().select();
            personalDetailsUpdateForm.find("input[name='surname']").after('<span class="error text-danger error_msg">Enter your surname</span>');
            return false;
        }

        if (address_line1 == "") {
            personalDetailsUpdateForm.find("input[name='address_line1']").focus().select();
            personalDetailsUpdateForm.find("input[name='address_line1']").after('<span class="error text-danger error_msg">Enter your address line1</span>');
            return false;
        }
        if (address_line2 == "") {
            personalDetailsUpdateForm.find("input[name='address_line2']").focus().select();
            personalDetailsUpdateForm.find("input[name='address_line2']").after('<span class="error text-danger error_msg">Enter your address line2</span>');
            return false;
        }
        if (phone == "") {
            personalDetailsUpdateForm.find("#phone").focus().select();
            personalDetailsUpdateForm.find("#phone").after('<span class="error text-danger error_msg">Enter your phone</span>');
            return false;
        }

        $("#personalDetailsUpdateSubmitBtn").prop('disabled', true);
        $("#personalDetailsUpdateSubmitBtn").val('Processing...');
        var frm = $('form[name="personalDetailsUpdateForm"]');
        var formData = new FormData(frm[0]);
        console.log(formData)
        $.ajax({
            url: "{{ route('personalDetails.update')}}",
            type: 'POST',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: (response) => {
                if (response.success == true) {
                    $('#personalDetailsUpdateModal').modal('hide');
                    $("#personalDetailsUpdateSubmitBtn").prop('disabled', false);
                    $("#personalDetailsUpdateSubmitBtn").val('Update');
                    //                $("#headerProfileImageUpdate").attr('src', response.img);
                    if (response.input_name == 'full_name') {
                        $(".full_name_display span").text(response.name);
                    }
                    if (response.input_name == 'address') {
                        $(".address_display .address_display1").text(response.address_display1);
                        $(".address_display .address_display2").text(response.address_display2);
                    }
                    if (response.input_name == 'phone') {
                        $(".phone_display span").text(response.phone);
                    }

                    Swal.fire({
                        title: 'Done!',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: false,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 3000
                    }).then(() => {
                        location.reload(true);
                    });
                } else {
                    $("#personalDetailsUpdateSubmitBtn").prop('disabled', false);
                    $("#personalDetailsUpdateSubmitBtn").val('Update');
                    //                $("#headerProfileImageUpdate").attr('src', response.img);
                    //                    $(".text-muted span").text(response.name);
                    Swal.fire({
                        title: 'Oops!',
                        text: response.message,
                        icon: 'error',
                        showConfirmButton: false,
                        //closeOnClickOutside: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 3000
                    });
                }
            },
            error: function (err) {
                $("#personalDetailsUpdateSubmitBtn").prop('disabled', false);
                $("#personalDetailsUpdateSubmitBtn").val('Update');
                Swal.fire({
                    title: 'Oops...',
                    text: err.message,
                    icon: 'error',
                    showConfirmButton: false,
                    //closeOnClickOutside: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 3000
                });
            }
        });
    });

    //            $('<input>').attr({
    //                type: 'text',
    //                name: 'first_name',
    //                id: 'first_name',
    //            }).appendTo(personalDetailsUpdateForm);
    //            $('<input>').attr({
    //                type: 'text',
    //                name: 'surname',
    //                id: 'surname',
    //            }).appendTo(personalDetailsUpdateForm);

</script>
<script>
    //Getting Countries list:
    $(document).ready(function () {

        $(document).on('click',"input[name='default_image']:checkbox",function(){
            
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
                    $("img.dtf-img").attr('src','{{url("/images/book-img.png")}}');
                }
            }
            $("input[name='default_image']").not(this).prop('checked', false);
        });

        check = 1;
        function get_country_list() {
            $.ajax({
                url: "{{route('get.allCountries.list')}}",
                type: "POST",
                data: {},
                dataType: "json",
                beforeSend: function (xhr) {}
            }).always(function () {
            }).done(function (response, status, xhr) {
                if (response.success === true) {
                    var country_select = $('form[name="personalDetailsUpdateForm"]').find("select[name='country']");
                    country_select.find('option').remove();
                    country_select.append(`<option selected>Please select your country</option>`);
                    $.each(response.data.countries, function (index, item) {
                        country_select.append(new Option(item.name + ' - ' + item.sortname, item.id));
                        //                        country_select.append(new Option(item.name +' - '+ item.sortname, item.name));
                    });
                }
                if (response.success === false) {
    //                swal.fire('Oops...', response.msg, 'error');
                    var country_select = $('form[name="personalDetailsUpdateForm"]').find("select[name='country']");
                    country_select.find('option').remove();
                    country_select.append(`<option selected>Please select your country</option>`);
                }

            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {

            });
        }
    //Get states by country:
        $(document).on('change', '#personalDetailsUpdateForm #country',function () {
            get_states(this.value);

        });
        function get_states(country_id) {
            $.ajax({
                url: "{{route('get.statesByCountry.list')}}",
                type: "POST",
                data: {country_id: country_id},
                dataType: "json",
                beforeSend: function (xhr) {}
            }).always(function () {
            }).done(function (response, status, xhr) {
                if (response.success === true) {
                    var state_select = $("#personalDetailsUpdateForm").find("select[name='state_province_region']");
                    state_select.find('option').remove();
                    state_select.append(`<option selected>Please select your state / Province/ Region</option>`);
                    $.each(response.data.states_by_country, function (index, item) {
                        state_select.append(new Option(item.name, item.name));
    //                        state_select.append(new Option(item.name, item.name));
                    });
                    //if(check === 1){
                        let stateid = '{{ !empty(auth()->user()->state_province_region)?auth()->user()->state_province_region:""}}';
                        console.log(stateid);
                        $('#personalDetailsUpdateForm select[name="state_province_region"]').val(stateid).trigger('change');
                        check = 0;
                    //}
                    
                }
                if (response.success === false) {
    //                swal.fire('Oops...', response.msg, 'error');
                    var state_select = $("#personalDetailsUpdateForm").find("select[name='state_province_region']");
                    state_select.find('option').remove();
                    state_select.append(`<option selected>Please select your state / Province/ Region</option>`);
                }

            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {

            });
        }

    });


</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.switch_1').click(function () {
            var attrName = $(this).attr('name');
            var attrVal = ($(this).is(":checked") == true) ? 1 : 0;

            $.ajax({
                url: "{{URL('buyer/update-user-settings')}}",
                type: "POST",
                data: {key: attrName, attrVal: attrVal},
                dataType: "json",
                beforeSend: function (xhr) {
                    $('#' + attrName + "Spinner").css('display', 'block');
                    $('#' + attrName + "Spinner").parent('div').css({opacity: 0.5});
                }
            }).always(function () {
                $('#' + attrName + "Spinner").css('display', 'block');
                $('#' + attrName + "Spinner").parent('div').css({opacity: 0.5});
            }).done(function (response, status, xhr) {
                if (response.success === true) {
                    if (attrVal == 1) {
                        $(this).attr('checked', true);
                    } else {
                        $(this).attr('checked', false);
                    }
                    $('#' + attrName + "Spinner").css('display', 'none');
                    $('#' + attrName + "Spinner").parent('div').css({opacity: 1});

                }
                if (response.success === false) {
                    $('#' + attrName + "Spinner").css('display', 'none');
                    $('#' + attrName + "Spinner").parent('div').css({opacity: 1});
                    swal.fire('Oops...', response.msg, 'error');
                }

            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $('#' + attrName + "Spinner").css('display', 'none');
                $('#' + attrName + "Spinner").parent('div').css({opacity: 1});
                swal.fire('Oops...', "Something went wrong", 'error');
            });
        });
        $(document).on('click','.delete-account',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
              title: 'Are you sure you want to deactivate the account?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, deactivate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;  
                }
            });
            
        });
    });
</script>
@endpush