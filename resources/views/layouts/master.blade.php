<!DOCTYPE html>
<html lang="en">
    @include('layouts.partials.head')
    <body>
        <!--Header Starts Here-->
        @include('layouts.header')
        <div class="b-example-divider"></div>
        <!--Header Section Ends Here-->
        <!--Breadcrub Section Starts Here-->
        @yield('breadcrub_section')
        @if(auth()->user())
        @include('layouts.partials.breadcrub_section')
        @endif
        <!--Breadcrub Section Ends Here-->

        <!--Main Banner Section Starts Here-->
        @yield('main_banner_section')
        <!--Main Banner Section Ends Here-->

        <!--Slider Section Starts Here-->
        @yield('slider_section')
        <!--Slider Section Ends Here-->

        <!--Content Section Starts Here-->
        @yield('content')
        <!--Content Section Ends Here-->
        @if(!auth()->user())
        @include('modal.login_modal')
        @endif

        <!--Testimonial Section Starts Here-->
        @yield('testimonial_section')
        <!--Testimonial Section Ends Here-->


        <!--Footer Section Starts Here-->
        @include('layouts.footer')
        <!--Footer Section Ends Here-->

        @include('modal.rate_review_popup_modal')
        @include('modal.buy_license_share')
        <button type="button" class="btn bg-blue btn-floating btn-lg topbtn" id="toTopBtn">
            <i class="fas fa-arrow-up text-white"></i>
        </button>

        <!-- Separate Popper and Bootstrap JS -->
        @include('layouts.partials.script')
        <!-- Separate Popper and Bootstrap JS Ends Here-->
        @if(!auth()->user())
        <script>
            //$('#memberLogin').click(function(event){
            //$('.memberLogin').click(function(event){
            $(document).on('click', '.memberLogin', function (e) {
                e.preventDefault();
                $('form[name="loginForm"]')[0].reset();
                $('#loginModal #errorMessageDiv').remove();
                $('#loginModal').modal('show');
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                });
            });
            $('#forgetPassword').click(function (event) {
                $('form[name="forgetPasswordForm"]')[0].reset();

                $("#forgetPasswordForm .error_msg").remove();
                $("#forgetPassErrorMessageDiv").remove();
                $("#forgetPassSuccessMessageDiv").remove();

                $('#loginModal').modal('hide');
                $('#forgetPwdModal').modal('show');
            });
            $('.modal-close').click(function (event) {
                $('#loginModal').modal('hide');
                $('#forgetPwdModal').modal('hide');
            });
            $('#signIn').click(function (event) {
                $('form[name="loginForm"]')[0].reset();

                $("#loginForm .error_msg").remove();
                $("#errorMessageDiv").remove();

                $("#forgetPasswordForm .error_msg").remove();
                $("#forgetPassErrorMessageDiv").remove();
                $("#forgetPassSuccessMessageDiv").remove();

                $('#forgetPwdModal').modal('hide');
                $('#loginModal').modal('show');
            });

            $("form[name='loginForm']").submit(function (event) {
                event.preventDefault();
                $("#loginSubmitBtn").prop('disabled', true);
                $("#loginSubmitBtn").val('Processing...');

                var email = $("#loginEmail").val();
                var password = $("#loginPassword").val();
                $("#loginForm .error_msg").remove();
                $("#errorMessageDiv").remove();
                if (email == '') {
                    $('#loginEmail').focus().select();
                    $("#loginEmail").after('<small class="text-danger error_msg">Please enter your email!</small>');
                    $("#loginSubmitBtn").prop('disabled', false);
                    $("#loginSubmitBtn").val('Login');
                    return false;
                }
                else{
                     if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){

                     }
                     else{
                        $('#loginEmail').focus().select();
                        $("#loginEmail").after('<small class="text-danger error_msg">Please enter valid email!</small>');
                        $("#loginSubmitBtn").prop('disabled', false);
                        $("#loginSubmitBtn").val('Login');
                        return false;
                     }
                } 

                if (password == '') {
                    $('#loginPassword').focus().select();
                    $("#loginPassword").after('<small class="text-danger error_msg">Please enter your password!</small>');
                    $("#loginSubmitBtn").prop('disabled', false);
                    $("#loginSubmitBtn").val('Login');
                    return false;
                }

                $.ajax({
                    url: "{{route('auth.login.post')}}", type: 'POST', data: {email: email, password: password, _token: '{{ csrf_token() }}'},
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        $("#loginSubmitBtn").prop('disabled', false);
                        $("#loginSubmitBtn").val('Login');
                        $("#error_message").after(`<div class="alert alert-success alert-dismissible fade show" id="successMessageDiv">
                        <strong>Success!</strong> ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`);
                        if (response.user_type == 'account') {
                            //window.location.href = "{{route('account.dashboard')}}";
                            //window.location.href = "{{route('product.search.view')}}";
                            window.location.href = "{{route('classroom.index')}}";
                        }
                        if (response.user_type == 'store') {
                            window.location.href = "{{route('store.dashboard')}}";
                            //window.location.href = "{{route('product.search.view')}}";
                        }
                    }
                    if (response.success === false) {
                        $("#loginSubmitBtn").prop('disabled', false);
                        $("#loginSubmitBtn").val('Login');
                        $("#error_message").after(`<div class="alert alert-danger alert-dismissible fade show" id="errorMessageDiv">
                            ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`);
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $("#loginSubmitBtn").prop('disabled', false);
                    $("#loginSubmitBtn").val('Login');
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
            //Forgot password:
            $("form[name='forgetPasswordForm']").submit(function (event) {
                event.preventDefault();

                $("#forgetPwdSubmitBtn").prop('disabled', true);
                $("#forgetPwdSubmitBtn").val('Processing...');
                var email = $("#forgetPwdemail").val();
                $("#forgetPasswordForm .error_msg").remove();
                $("#forgetPassErrorMessageDiv").remove();
                $("#forgetPassSuccessMessageDiv").remove();
                if (email == '') {
                    $('#forgetPwdemail').focus().select();
                    $("#forgetPwdemail").after('<small class="text-danger error_msg">Please enter your email!</small>');
                    $("#forgetPwdSubmitBtn").prop('disabled', false);
                    $("#forgetPwdSubmitBtn").val('Send My Password');
                    return false;
                }

                $.ajax({
                    url: "{{route('forget.password.post')}}", type: 'POST', data: {email: email, _token: '{{ csrf_token() }}'},
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        $("#forgetPwdSubmitBtn").prop('disabled', false);
                        $("#forgetPwdSubmitBtn").val('Send My Password');

                        $("#pwdError_message").after(`<div class="alert alert-success alert-dismissible fade show" id="forgetPassSuccessMessageDiv">
                        <strong>Success!</strong> ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`);
                        if (response.user_type == 'account') {
                            window.location.href = "{{route('account.dashboard')}}";
                        }
                    }
                    if (response.success === false) {
                        $("#forgetPwdSubmitBtn").prop('disabled', false);
                        $("#forgetPwdSubmitBtn").val('Send My Password');

                        $("#pwdError_message").after(`<div class="alert alert-danger alert-dismissible fade show" id="forgetPassErrorMessageDiv">
                        <strong>Error!</strong> ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`);
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $("#forgetPwdSubmitBtn").prop('disabled', false);
                    $("#forgetPwdSubmitBtn").val('Send My Password');
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
                    //var msg = (responseJSON === 'Unauthorized') ? 'Session expired, Please login again.' : ((xhr.responseJSON && xhr.responseJSON.msg)? xhr.responseJSON.msg : 'Unable to process your request');
                });
            });
        </script>
        @endif
        @stack('script')

        @if(Auth::check())
        <script>
            $(document).ready(function () {
                totalCartItemCount();
            });

        </script>
        @endif
        <script>
            function totalCartItemCount() {
                $.ajax({
                    url: "{{route('totalCartItem.count')}}",
                    type: 'get',
                    data: {_token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {
                    }
                }).always(function () {
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        $("#cart").html(response.data);
                        //                totalCartItemCount(response.data);
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
        </script>
        <script>
            $(document).ready(function () {
                $('#giftCardForNotLoggedIn').click(function () {
                    swal.fire("Please Login with your account to access gift card", "", "error");
                });
            });
        </script>
    </body>
</html>


