@extends('auth.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            
            <table border="0" cellpadding="0" cellspacing="0" width="650" style="margin: auto; border: 1px solid #ddd; font-family: Arial;">
                <tr>
                    <td>
                        <table border="0" cellpadding="15" cellspacing="0" bgcolor="ffffff" style="width: 100%;">
                            <tr>
                                <td style="padding-top: 0px; padding-bottom: 20px;padding-left:0px;padding-right:0px;text-align:center;position: relative !important;">
                                    <div style="width:100%;height:50px;background-color: #306eba;">
                                        <a href="{{url('/')}}" target="_blank"  style="text-decoration: none;">
                                            <img src="{{asset('images/logo.png')}}" width="250px" style="padding-top:5px;">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="15" cellspacing="0" style="width: 100%;padding-top: 50px;padding-left: 10px;">
                            <tr>
                                <td align="left">
                                    <p  style="font-family: Arial;font-size:16px; color:#242424;">Dear User,</p>
                                    <p  style="font-family: Arial;font-size:16px; color:#242424;">
                                    We hope this email finds you well. You've requested a password reset for your account with Classroom Copy. No worries – we're here to help you regain access to your account quickly and securely.</a></p>
                                    <p  style="font-family: Arial;font-size:16px; color:#242424;">
                                    To reset your password, please follow the link below:</p>
                                    <p style="font-family: Arial;font-size:16px; color:#242424;"><a href="{{ url('reset-password/'.$token) }}" style="color:#306eba;">{{ url('reset-password/'.$token) }}</a></p>

                                    <p style="font-family: Arial;font-size:16px; color:#242424;">If you did not request a password reset, please ignore this email. Your account security is important to us, and no changes will be made without your confirmation.</p>
                                    <p style="font-family: Arial;font-size:16px; color:#242424;">The password reset link will expire in 12 hours for security reasons. If you cannot complete the process within this time frame, you can always request another reset by visiting our password recovery page.</p>
                                    <p style="font-family: Arial;font-size:16px; color:#242424;">If you continue to experience issues or have any questions, feel free to reach out to our support team at <a href="{{url('contact-us')}}" target="_blank" style="color:#306eba;text-decoration:none;">Contact Us.</a></p>
                                    <p style="font-family: Arial;font-size:16px; color:#242424;">
                                    Thank you for choosing Classroom Copy.
                                    </p>
                                    <p style="padding-bottom: 10px;font-family: Arial;font-size:16px; color:#242424;">Team Classroom Copy</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 30px 15px 20px;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                        
                                        <tr>
                                            <td><hr></td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <a href="{{url('/')}}" target="_blank"  style="text-decoration: none;">
                                                    <img src="{{asset('images/logo.png')}}" width="150" style="margin-top: 10px;">
                                                </a>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="center" style="font-family: Arial;padding-top: 10px;padding-bottom: 10px;font-size: 14px;">PO Box 7005, Southport Park, Qld, Australia 4215</td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <a href="https://www.facebook.com/ClassroomCopy" target="_blank"  style="text-decoration: none;padding-left:5px;padding-right: 5px;">
                                                    <img src="{{asset('images/emailer-facebook.png')}}" alt="facebook" width="24" height="24">
                                                </a>
                                                <a href="https://www.instagram.com/classroomcopy/ " target="_blank" style="text-decoration: none;padding-left:5px;padding-right: 5px;">
                                                    <img src="{{asset('images/emailer-instagram.png')}}" alt="facebook" width="24" height="24">
                                                </a>
                                                <a href="https://www.linkedin.com/company/classroom-copy" target="_blank" style="text-decoration: none;padding-left:5px;padding-right: 5px;">
                                                    <img src="{{asset('images/emailer-linkedin.png')}}" alt="facebook" width="24" height="24">
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            





            <!-- <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address by clicking the Password Reset Link button') }}</div>

                <div class="card-body">
                    <a href="{{ url('reset-password/'.$token) }}"  class="btn btn-link p-0 m-0 align-baseline">Password Reset Link</a>
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection
