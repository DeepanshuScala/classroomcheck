<!--//Login Moadal:-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-title text-center" id="error_message">
          <h4>Login</h4>
        </div>
        <!-- Error Alert -->
<!--            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> A problem has been occurred while submitting your data.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>-->
            <!-- Success Alert -->
<!--            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Your message has been sent successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>-->
        <!-- Error Alert Ends here -->
        <div class="d-flex flex-column text-center">
            <form action="" method="post" name="loginForm" id="loginForm">
                @csrf
                <div class="form-group" id="emailError">
                    <input type="email" class="form-control" name="login_email" id="login_email"placeholder="Enter your user name" autocomplete="new_email">
                </div>
                <!--</br>-->
                <div class="form-group" id="passwordError">
                    <input type="password" class="form-control" name="login_password"  id="login_password" placeholder="Enter Your password" autocomplete="new_passsword">
                </div>
                <!--</br>-->
                <input type="submit" class="btn btn-info btn-block btn-round" value="Login" />
          </form>
          
<!--          <div class="text-center text-muted delimiter">or use a social network</div>
          <div class="d-flex justify-content-center social-buttons">
            <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip" data-placement="top" title="Twitter">
              <i class="fab fa-twitter"></i>
            </button>
            <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip" data-placement="top" title="Facebook">
              <i class="fab fa-facebook"></i>
            </button>
            <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip" data-placement="top" title="Linkedin">
              <i class="fab fa-linkedin"></i>
            </button>
          </di>
        </div>-->
      </div>
    </div>
    <div class="modal-footer d-flex justify-content-center">
        <div class="signup-section">Forget Password? <a href="#a" class="text-info" id="forgetPassword"> Click Here</a>.</div>
    </div>
  </div>
</div>
</div>


<!--//Forget Password Modal:-->
<div class="modal fade" id="forgetPwdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">

                                    <p id="pwdError_message">If you have forgotten your password you can reset it here.</p>
                                    <div class="panel-body" id="error_message_forgetPass">
                                        <form action="" method="post" name="forgetPasswordForm" id="forgetPasswordForm">
                                            @csrf
                                            <fieldset>
                                                <div class="form-group">
                                                    <input class="form-control input-lg" placeholder="E-mail Address" name="pwdemail" id="pwdemail" type="email">
                                                </div></br>
                                                <!--<input class="btn btn-lg btn-primary btn-block" value="Send My Password" type="submit">-->
                                                <input class="btn btn-info btn-block btn-round" value="Send My Password" id="resetPwdSubmitBtn" type="submit">
                                            </fieldset>
                                        </form>    
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
<!--            <div class="modal-footer">
                <div class="col-md-12">
                    <button class="btn modal-close" data-dismiss="modal" aria-hidden="true">Cancel</button>
                </div>	
            </div>-->
            <div class="modal-footer d-flex justify-content-center">
                <div class="signup-section">Sign In? <a href="#a" class="text-info" id="signIn"> Click Here</a>.</div>
            </div>
        
        </div>
    </div>
</div>
