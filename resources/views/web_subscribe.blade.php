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
<section class="privacy-policy-section py-5">
    <div class="container">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-center">
                <img src="https://i.imgur.com/Dh7U4bp.png" width="200">
                <span class="d-block mt-3">Subscribe to our newsletter in order to receive updates, special offers<br> and free resources!</span>
                <div class="row justify-content-center my-4">
                    <div class="col-md-6">
                        <div class="input-group ">
                            <input type="email" id="email" name="email" class="form-control subscribe" placeholder="Enter email" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-primary btn-hover px-sm-4" type="button" id="button-addon2">Subscribe</button>
                        </div>
                    </div>
                </div>
                <!-- <span class="d-block mt-3 text-decoration-underline"><a href="{{ URL('/') }}">NO THANKS</a></span> -->
            </div>
        </div>
    </div>
</section>

<!--Privacy Policy Section Ends Here-->
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#button-addon2').click(function () {
            $('#button-addon2').prop('disabled', true);
            $('#button-addon2').html('Processing...');
            var regEmail = /\S+@\S+\.\S+/;
            var email = $.trim($('#email').val());
            $("#email").css('border-color', '#ced4da');
            if ($.trim($('#email').val()) == '' || $.trim($('#email').val()).length == 0 || !regEmail.test($('#email').val())) {
                $('#email').css('border-color', 'red');
                $('#email').val('');
                $('#email').focus().select();
                $('#button-addon2').prop('disabled', false);
                $('#button-addon2').html('Subscribe');
                return false;
            }

            $.ajax({
                url: "<?php echo URL('/subscribe') ?>",
                data: {
                    email: email,
                    '_token': "{{ csrf_token() }}"
                },
                type: "post",
                dataType: 'json',
                success: function (response) {
                    if (response.success == 1) {
                        $('#button-addon2').prop('disabled', false);
                        $('#button-addon2').html('Subscribe');
                        Swal.fire({
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            title: 'Congratulations',
                            text: "Subscribed successfully",
                            icon: 'success',
                            showCancelButton: false,
                            //confirmButtonColor: '#3085d6',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            },
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        $('#button-addon2').prop('disabled', false);
                        $('#button-addon2').html('Subscribe');
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
                    $('#button-addon2').prop('disabled', false);
                    $('#button-addon2').html('Subscribe');
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

