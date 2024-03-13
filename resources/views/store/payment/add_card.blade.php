@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>Add Card</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{ URL('/seller/payment-system') }}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Payment Systems
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="add_product_section1">
    <div class="container">
        <!--Form Section Starts Here-->
        <form class="row g-3 pt-2 pb-5 col-md-12 d-flex flex-row" action="" name="addCardForm" id="addCardForm" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label class="form-label fw-bold float-start">Card Type</label>
                        </div>
                        <div class="col-md-6 col-12">
                            <select class="form-select form-custom-input" name="card_type" id="card_type">
                                <option value="credit">Credit Card</option>
                                <option value="debit">Debit Card</option>
                            </select>                         
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label class="form-label fw-bold float-start">Card Number</label>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text" onkeypress="return /[0-9]/i.test(event.key)" oninput="javascript: if (this.value.length > 16) this.value = this.value.slice(0, 16);" class="form-custom-input" name="card_number" id="card_number" placeholder="Card Number">                        
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label class="form-label fw-bold float-start">Card Holder Name</label>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text" class="form-custom-input" name="card_name" id="card_name" placeholder="Card Holder Name">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label class="form-label fw-bold float-start">Expiry Month</label>
                        </div>
                        <div class="col-md-6 col-12">
                            <select class="form-select form-custom-input" name="card_expiry_month" id="card_expiry_month">
                                <option value="" selected="" disabled="">Select Expiry Month</option>
                                <?php for ($m = 01; $m <= 12; $m++) { ?>
                                    <option value="{{$m}}">{{$m}}</option>
                                <?php } ?>
                            </select>                        
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label class="form-label fw-bold float-start">Expiry Year</label>
                        </div>
                        <div class="col-md-6 col-12">
                            <select class="form-select form-custom-input" name="card_expiry_year" id="card_expiry_year">
                                <option value="" selected="" disabled="">Select Expiry Year</option>
                                <?php
                                $lastYear = date('Y') + 22;
                                $startYear = date('Y') - 22;
                                for ($y = $lastYear; $y >= $startYear; $y--) {
                                    ?>
                                    <option value="{{$y}}">{{$y}}</option>
                                <?php } ?>
                            </select>                  
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label class="form-label fw-bold float-start">CVV</label>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="password" class="form-custom-input" onkeypress="return /[0-9]/i.test(event.key)" oninput="javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);" name="cvv" id="cvv" placeholder="CVV">                      
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-8 col-lg-8 ">
                <div class="mb-3">
                    <input class="form-check-input my-2" type="checkbox" name="default_card" id="default_card" style="display:none;">
                    <label class="form-check-label pt-1" for="default_card"  id="termsAndConditionsLabel" style="font-style:italic;">
                        Your payment details will be saved for faster processing
                    </label>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-8 col-lg-8 text-center">
                <button type="button" class="btn bg-blue btn-hover text-white text-uppercase my-5" id="addCardSubmitBtn">Save Card</button>
                <a href="{{@$data['prevURl']}}" class="btn bg-blue btn-hover text-white text-uppercase my-5 ms-2" id="addCardSubmitBtn">‎Cancel</a>
            </div>
        </form>
        <!--Form Section Ends Here-->
    </div>
</section>
@endsection
@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.2.0/jquery.creditCardValidator.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
$(document).ready(function () {
    var isFromGiftCard = "<?php echo (session()->has('giftCardData')) ? 1 : 0 ?>";
    var checkURlArr = ['feature-list/payment', 'checkout/payment'];
    var urlInArray = false;
    var prevURl = "{{ $data['prevURl'] }}";
    $.each(checkURlArr, function (i, v) {
        var prevURl = "{{ $data['prevURl'] }}";
        if (prevURl.indexOf(checkURlArr[i]) > -1) {
            urlInArray = true;
            return false;
        }
    });

    //add new card
    $('#addCardSubmitBtn').click(function () {
        $('#addCardSubmitBtn').prop('disabled', true);
        $('#addCardSubmitBtn').html('Processing...');
        var err = 0;
        var regCVV = /^[0-9]{3,4}$/;
        var card_type = $('#card_type').val();
        var card_number = $('#card_number').val();
        var card_name = $('#card_name').val();
        var card_expiry_month = $('#card_expiry_month').val();
        var card_expiry_year = $('#card_expiry_year').val();
        var cvv = $('#cvv').val();
        var default_card = 0;
        if ($("#default_card").is(":checked")) {
            default_card = 1;
        }
        $("#card_number").css('border-color', '#ced4da');
        $("#card_name").css('border-color', '#ced4da');
        $("#card_expiry_month").css('border-color', '#ced4da');
        $("#card_expiry_year").css('border-color', '#ced4da');
        $("#cvv").css('border-color', '#ced4da');
        $(".error_msg").remove();
        if ($('#card_number').val() == '') {
            $("#card_number").css('border-color', 'red');
            $('#card_number').focus().select();
            $('#card_number').after('<span class="error text-danger error_msg">Enter Card Number</span>');
           
            $('#addCardSubmitBtn').prop('disabled', false);
            $('#addCardSubmitBtn').html('Save Card');
            err = 1;
            return false;
        }
        else{
            $('#card_number').validateCreditCard(function (result) {
                $(".error_msg").remove();   
                if (!result.valid) {

                    $("#card_number").css('border-color', 'red');
                    $('#card_number').after('<span class="error text-danger error_msg">Enter Valid Card Number</span>');
                    $('#card_number').focus();
                    $('#addCardSubmitBtn').prop('disabled', false);
                    $('#addCardSubmitBtn').html('Save Card');
                    err = 1;
                    return false;
                }
            });
        }
        if ($('#card_name').val() == '' && err == 0) {
            $('#card_name').css('border-color', 'red');
            $('#card_name').focus().select();
            $('#card_name').after('<span class="error text-danger error_msg">Please Enter Card Name</span>');
            $('#addCardSubmitBtn').prop('disabled', false);
            $('#addCardSubmitBtn').html('Save Card');
            return false;
            err = 1;
        }
        if ($('#card_expiry_month option:selected').val() == '' && err == 0) {
            $('#card_expiry_month').css('border-color', 'red');
            $('#card_expiry_month').focus().select();
            $('#card_expiry_month').after('<span class="error text-danger error_msg">Please Select Expiry Month</span>');
            $('#addCardSubmitBtn').prop('disabled', false);
            $('#addCardSubmitBtn').html('Save Card');
            return false;
            err = 1;
        }
        if ($('#card_expiry_year option:selected').val() == '' && err == 0) {
            $('#card_expiry_year').css('border-color', 'red');
            $('#card_expiry_year').focus().select();
            $('#card_expiry_year').after('<span class="error text-danger error_msg">Please Select Expiry Year</span>');
            $('#addCardSubmitBtn').prop('disabled', false);
            $('#addCardSubmitBtn').html('Save Card');
            return false;   
            err = 1;
        }
        if ( ($('#cvv').val() == '' || !regCVV.test($('#cvv').val())) && err == 0) {
            $('#cvv').css('border-color', 'red');
            $('#cvv').css('border-color', 'red');
            $('#cvv').focus().select();
            $('#cvv').after('<span class="error text-danger error_msg">Please Enter CVV</span>');
            $('#addCardSubmitBtn').prop('disabled', false);
            $('#addCardSubmitBtn').html('Save Card');
            return false;   
            err = 1;
        }
        if (err == 0) {
            $.ajax({
                url: "<?php echo URL('/seller/save-card') ?>",
                data: {default_card: default_card,
                    card_type: card_type,
                    card_number: window.btoa(card_number),
                    card_name: card_name,
                    card_expiry_month: card_expiry_month,
                    card_expiry_year: card_expiry_year,
                    cvv: window.btoa(cvv),
                    '_token': "{{ csrf_token() }}"
                },
                type: "post",
                dataType: 'json',
                success: function (response) {
                    if (response.success == 1) {
                        $('#addCardSubmitBtn').prop('disabled', false);
                        $('#addCardSubmitBtn').html('Save Card');
                        Swal.fire({
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            title: 'Congratulations',
                            text: "Card added successfully",
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
                                if (parseInt(isFromGiftCard) == 1) {
                                    window.location.href = "<?php echo URL('/gift-card-payment') ?>";
                                } else if (urlInArray == true) {
                                    window.location.href = prevURl;
                                } else {
                                    window.location.href = "<?php echo URL('/seller/card-list') ?>";
                                }
                            }
                        });
                    } else if (response.success == 2) {
                        $('#addCardSubmitBtn').prop('disabled', false);
                        $('#addCardSubmitBtn').html('Save Card');
                        Swal.fire({
                            title: 'Oops!! Card already exist',
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
                    } else {
                        $('#addCardSubmitBtn').prop('disabled', false);
                        $('#addCardSubmitBtn').html('Save Card');
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
                    $('#addCardSubmitBtn').prop('disabled', false);
                    $('#addCardSubmitBtn').html('Save Card');
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
        } else {
            $('#addCardSubmitBtn').prop('disabled', false);
            $('#addCardSubmitBtn').html('Save Card');
        }
    });
});
</script>
@endpush