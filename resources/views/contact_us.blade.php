@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@if(!auth()->user())
@section('breadcrub_section')
<section class="breadcrumb-section bg-light-blue pt-2">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if(isset($data['home']) && $data['home'])
                <li class="breadcrumb-item active"><a href="{{route('classroom.index')}}"><i class='fal fa-home-alt'></i> {{$data['home']}}</a></li>
                @endif
                @if(isset($data['breadcrumb1']) && $data['breadcrumb1'])
                <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb1']}}</li>
                @endif
                @if(isset($data['breadcrumb2']) && $data['breadcrumb2'])
                <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb2']}}</li>
                @endif
                @if(isset($data['breadcrumb3']) && $data['breadcrumb3'])
                <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb3']}}</li>
                @endif
                @if(isset($data['breadcrumb4']) && $data['breadcrumb4'])
                <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb4']}}</li>
                @endif

            </ol>
        </nav>
    </div>
</section>
@endsection('breadcrub_section')
@endif

@section('content')
<!--Privacy Policy Section Starts Here-->
<section class="privacy-policy-section contact-us">
    <div class="container ">
        <div class="contact-form">
        <form method="post" action="" name="contactUsForm" id="contactUsForm">
            @csrf
            <h1 class="pb-4 mt-0 mb-3">Contact Us</h1>
            <div class="row">
                <div class="col-md-6 col-lg-5 col-12">
                    <div class="form-group mb-3">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="" required="" />
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="" required="" />
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone Number" required="" value="" />
                    </div>
                    <div class="form-group mb-3">
                        <select name="topic" class="form-select" id="topic" required="required">
                            <option value="">Select Topic</option>
                            <option value="My Account">My Account</option>
                            <option value="Login or password issues">Login or password issues</option>
                            <option value="Technical issue with a resource">Technical issue with a resource</option>
                            <option value="Feedback and ratings">Feedback and ratings</option>
                            <option value="Rules, policies, and guidelines">Rules, policies, and guidelines</option>
                            <option value="School Purchase Orders">School Purchase Orders</option>
                            <option value="Payouts">Payouts</option>
                            <option value="Refund request">Refund request</option>
                            <option value="Suggestions">Suggestions</option>
                            <option value="Report a site issue">Report a site issue</option>
                            <option value="Consumer Privacy Rights Request">Consumer Privacy Rights Request</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group  mb-5">
                        <textarea name="message" id="message" class="form-control" placeholder="Message" style="width: 100%; height: 140px;"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <input type="button" name="btnSubmit" id="btnSubmit" class="btnContact" value="Submit" required="" />
                    </div>
                </div>
                
            </div>
        </form>
    </div>
    </div>
    <figure class="contact-image">
        <img src="{{asset('images/contact-image.jpg')}}" alt="">
    </figure>
       <!--<div class="contact-image">-->
       <!--      <img src="{{asset('images/contact-image.png')}}" class="img-fluid">-->
       <!-- </div>-->
</section>

<!--Privacy Policy Section Ends Here-->
@endsection
@push('script')
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#btnSubmit').click(function () {
            $('#btnSubmit').prop('disabled', true);
            $('#btnSubmit').val('Processing...');
            var regNumber = /^[0-9]{10,15}$/;
            var regEmail = /\S+@\S+\.\S+/;
            var name = $.trim($('#name').val());
            var email = $.trim($('#email').val());
            var phone = $.trim($('#phone').val());
            var message = $.trim($('#message').val());
            var topic = $.trim($('#topic').val());
            $("#name").css('border-color', '#ced4da');
            $("#email").css('border-color', '#ced4da');
            $("#phone").css('border-color', '#ced4da');
            $("#message").css('border-color', '#ced4da');
            $("#topic").css('border-color', '#ced4da');
            $("#contactUsForm .error_msg").remove();
            if ($.trim($('#name').val()) == '' || $.trim($('#name').val()).length == 0) {
                $('#name').css('border-color', 'red');
                $('#name').val('');
                $('#name').focus().select();
                $("#name").after('<span class="error text-danger error_msg">Please enter name.</span>');
                $('#btnSubmit').prop('disabled', false);
                $('#btnSubmit').val('Send Message');
                return false;
            }
            if ($.trim($('#email').val()) == '' || $.trim($('#email').val()).length == 0 || !regEmail.test($('#email').val())) {
                $('#email').css('border-color', 'red');
                $('#email').val('');
                $('#email').focus().select();
                $("#email").after('<span class="error text-danger error_msg">Please enter email.</span>');
                $('#btnSubmit').prop('disabled', false);
                $('#btnSubmit').val('Send Message');
                return false;
            }
            if ($.trim($('#phone').val()) == '' || $.trim($('#phone').val()).length == 0 || !regNumber.test($('#phone').val())) {
                $('#phone').css('border-color', 'red');
                $('#phone').val('');
                $('#phone').focus().select();
                $("#phone").after('<span class="error text-danger error_msg">Please enter phone.</span>');
                $('#btnSubmit').prop('disabled', false);
                $('#btnSubmit').val('Send Message');
                return false;
            }
            
            if ($.trim($('#topic').val()) == '' || $.trim($('#topic').val()).length == 0) {
                console.log('here');
                $('#topic').css('border-color', 'red');
                $('#topic').val('');
                $('#topic').focus().select();
                $("#topic").after('<span class="error text-danger error_msg">Please enter Topic.</span>');
                $('#btnSubmit').prop('disabled', false);
                $('#btnSubmit').val('Send Message');
                return false;
            }

            if ($.trim($('#message').val()) == '' || $.trim($('#message').val()).length == 0) {
                $('#message').css('border-color', 'red');
                $('#message').val('');
                $('#message').focus().select();
                $("#message").after('<span class="error text-danger error_msg">Please enter message.</span>');
                $('#btnSubmit').prop('disabled', false);
                $('#btnSubmit').val('Send Message');
                return false;
            }

            $.ajax({
                url: "<?php echo URL('/contact-us') ?>",
                data: {name: name,
                    email: email,
                    phone: phone,
                    message: message,
                    topic: topic,
                    '_token': "{{ csrf_token() }}"
                },
                type: "post",
                dataType: 'json',
                success: function (response) {
                    if (response.success == 1) {
                        $('#btnSubmit').prop('disabled', false);
                        $('#btnSubmit').val('Send Message');
                        Swal.fire({
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            title: 'Congratulations',
                            text: "Message Sent successfully",
                            icon: 'success',
                            showCancelButton: false,
                            timer:3000,
                            //confirmButtonColor: '#3085d6',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            },
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = window.location.href;
                            }
                        });
                        setTimeout(function(){
                             window.location.href = window.location.href;
                        },3000);
                    } else {
                        $('#btnSubmit').prop('disabled', false);
                        $('#btnSubmit').val('Send Message');
                        var message = (response.message != '') ? response.message : "Oops!! Something went wrong";
                        Swal.fire({
                            title: message,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                },
                error: function () {
                    $('#btnSubmit').prop('disabled', false);
                    $('#btnSubmit').val('Send Message');
                    Swal.fire({
                        title: 'There was some error performing the AJAX call!',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        });
    });
</script>
@endpush


