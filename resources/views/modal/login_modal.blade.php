<!--//Login Moadal:-->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
<!--                <h6 class="modal-title" id="staticBackdropLabel">Login</h6>-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title blue display-6 mb-4 fw-bold" id="staticBackdropLabel">Login</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="loginForm" id="loginForm">
                        @csrf
                        <div class="my-2 mb-4" id="emailError">
                            <!--<label for="login_email"> Student Name: </label>-->
                            <input type="email" class="form-control" name="email" id="loginEmail"placeholder="Enter your user name" autocomplete="new_email">
                        </div>
                        
                        <div class="my-2" id="passwordError">
                            <!--<label for="login_password"> Student Name: </label>-->
                            <input type="password" class="form-control" name="password"  id="loginPassword" placeholder="Enter Your password" autocomplete="new_passsword">
                        </div>
                        <div class="my-2 mt-4 text-center">
                            <input type="submit" class="btn btn-primary btn-hover px-4 py-2" id="loginSubmitBtn" value="Login" />
                        </div>
                  </form>
                </div>
            </div>
            
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <div class="signup-section">Forgot Password? <a href="javascript:void(0)" class="text-info-link" id="forgetPassword"> Click Here</a>.</div>
            </div>
        </div>
    </div>
</div>







<!--//Forget Password Modal:-->
<div class="modal fade" id="forgetPwdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
<!--                <h6 class="modal-title" id="staticBackdropLabel">Login</h6>-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h3 class="modal-title blue display-6 mb-4 fw-bold" id="staticBackdropLabel">Forgot Password</h3>
                </div>
                <h6 id="pwdError_message" class="text-center">If you have forgotten your password you can reset it here.</h6>
                <div class="panel-body pt-2" id="error_message_forgetPass">
                    <form class="" action="" method="post" name="forgetPasswordForm" id="forgetPasswordForm">
                        @csrf
                        <div class="my-2" id="emailError">
                            <!--<label for="forgetPwdemail"> Email: </label>-->
                            <input type="email" class="form-control input-lg" placeholder="E-mail Address" name="email" id="forgetPwdemail">
                        </div>
                        </br>
                        
                        <div class="my-2 text-center">
                            <input class="btn btn-primary btn-hover px-4 py-2" value="Send My Password" id="forgetPwdSubmitBtn" type="submit">
                        </div>
                  </form>
                </div>
            </div>
            
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <div class="">Sign In? <a href="javascript:void(0)" class="text-info-link" id="signIn"> Click Here</a>.</div>
            </div>
        </div>
    </div>
</div>



