@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Gift Card  Section Starts Here-->
    <section class="gift_card_section pb-5 pt-5">
        <div class="container">
            <div class="row justify-content-start ">
                <!--<div class="col-lg-6 col-sm-12 my-0 py-4">-->
                <div class="col-lg-5 col-12 inner_page_title">
                    <h1 id="resetPwdError_message" class="mb-4">Reset your passsword</h1>
                    <form action="" method="post" name="resetPasswordForm" id="resetPasswordForm"  style="margin-top: 20px;">
                        @csrf
                        <div class="form-group" id="emailError">
                            <!--<label for="inputEmail " class="col-form-label">Enter Email :</label>-->
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your email address..." autocomplete="new-email">
                        </div>
                        </br>
                        <div class="form-group" id="passwordError">
                            <!--<label for="inputEmail " class="col-form-label">Enter New Password :</label>-->
                            <input type="password" class="form-control" placeholder="Enter New Password" name="password" id="password" autocomplete="new-passsword">
                        </div></br>
                        <div class="form-group" id="passwordError">
                            <!--<label for="inputEmail " class="col-form-label">Confirm New Password :</label>-->
                            <input type="password" class="form-control" placeholder="Confirm New Password" name="password_confirmation" id="password_confirmation" autocomplete="new-passsword">
                        </div></br>
                        
                        <input type="submit" class="btn-hover w-auto px-5" id="changePwdSubmitBtn" value="Save">
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!--Gift Card Section Ends Here-->
@endsection

@push('script')
<script>
//Reset password:
$("form[name='resetPasswordForm']").submit(function( event ) {
    event.preventDefault();
//    $("#changePwdSubmitBtn").prop('disabled', false);
//    $("#changePwdSubmitBtn").val('Save');
            
//    $("#changePwdSubmitBtn").prop('disabled', true);
//    $("#changePwdSubmitBtn").val('Processing...');
    var email                   =   $("form[name='resetPasswordForm']").find('input[name="email"]').val();
    var password                =   $("form[name='resetPasswordForm']").find('input[name="password"]').val();
    var password_confirmation   =   $("form[name='resetPasswordForm']").find('input[name="password_confirmation"]').val();
    var pwdResetToken   =   "{{$token}}";
    console.log(email);
    $(".error_msg").remove();
    $("#forgetPassErrorMessageDiv").remove();
    if(email == ''){
        $('#email').focus().select();
        $("#email").after('<small class="text-danger error_msg">Please enter your email!</small>');
        return false;
    }
    if(password == ''){
        $('#password').focus().select();
        $("#password").after('<small class="text-danger error_msg">Please enter your password!</small>');
        return false;
    }
    if(password_confirmation == ''){
        $('#password_confirmation').focus().select();
        $("#password_confirmation").after('<small class="text-danger error_msg">Please enter your password confirmation!</small>');
        return false;
    }
    if(password !== password_confirmation){
        $('#password_confirmation').focus().select();
        $("#password_confirmation").after('<small class="text-danger error_msg">Password confirmation does not matched!</small>');
        return false;
    }
    
//    if(email == ''){
//        $('#pwdemail').focus().select();
//        $("#pwdemail").after('<small class="text-danger error_msg">Please enter your email!</small>');
//        return false;
//    }

    $.ajax({
        url: "{{route('update.password')}}", type: 'POST',data: {email: email,password:password, password_confirmation:password_confirmation,token:pwdResetToken, _token:'{{ csrf_token() }}'},
    }).done(function(response, status, xhr) {
        if (response.success === true) {
            $("#forgetPassErrorMessageDiv").remove();
            $("#changePwdSubmitBtn").prop('disabled', false);
            $("#changePwdSubmitBtn").val('Save');
            
            $("#resetPwdError_message").after(`<div class="alert alert-success alert-dismissible fade show" id="changePassSuccessMessageDiv">
                <strong>Success!</strong> ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`);
            Swal.fire({
                title: 'Done,',
                text: response.message,
                icon: 'success',
                showConfirmButton: true,
//                timer: 3000,
                //closeOnClickOutside: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
            });        
            $(".swal2-confirm").click(function(){
                //location.reload();
                window.location.href = "{{route('classroom.index')}}";
            });        
            
        }
        if (response.success === false) {
            $("#changePwdSubmitBtn").prop('disabled', false);
            $("#changePwdSubmitBtn").val('Save');
            
            $("#resetPwdError_message").after(`<div class="alert alert-danger alert-dismissible fade show" id="forgetPassErrorMessageDiv">
                <strong>Error!</strong> ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`);
        }
    }).fail(function(xhr, ajaxOptions, responseJSON, thrownError){
        $("#changePwdSubmitBtn").prop('disabled', false);
        $("#changePwdSubmitBtn").val('Save');
        if(xhr.status == 419 && xhr.statusText == "unknown status"){
            swal.fire("Unauthorized! Session expired", "Please login again", "error");
//                    $(".swal2-confirm").click(function(){
//                        location.reload();
//                    });
        } else {
            if(xhr.responseJSON && xhr.responseJSON.message){
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
@endpush