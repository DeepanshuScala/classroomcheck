<!--Change Password Pop Up Starts Here-->
<!-- Modal -->
<div class="modal change-pwd" id="changePwdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="text-end pt-3 pe-3">
                <button type="button" class=" blue  border-0 fs-2 rounded-circle px-3 " data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row ">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6"><img src="{{asset('images/change-pwd-pic.jpg')}}" class="img-fluid" alt="change-pwd-pic"></div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <h1 id="changePwdError_message" class="modal-title text-uppercase pt-4 pb-3" id="exampleModalLabel">Change Password</h1>
                        <!--Error/Success message shows here:-->
                        <form action="" name="changePwdForm" id="changePwdForm" >
                            @csrf
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <input type="password" class="form-control bg-light border" name="current_password" id="current_password" autocomplete="new_password">

                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control bg-light border" name="password" id="new_password" autocomplete="new_password">
                            </div>

                            <div class="my-3">
                                <label for="confirm-newPassword" class="form-label"> Confirm New Password</label>
                                <input type="password" class="form-control bg-light border" name="password_confirmation"  id="confirm_new_password" autocomplete="new_password">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-md bg-blue btn-hover btn-lg px-4 text-white text-uppercase my-2" id="changePwdSubmitBtn">Submit</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!--Change Password Pop Up Ends Here-->