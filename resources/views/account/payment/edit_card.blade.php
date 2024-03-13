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
                    <a href="{{ URL('/buyer/payment-system') }}">
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
        <form class="row g-3 pt-2 pb-5 col-md-12 d-flex flex-row" action="" name="updateCardForm" id="updateCardForm" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label class="form-label fw-bold float-start">Card Type</label>
                        </div>
                        <div class="col-md-6 col-12">
                            <select class="form-select form-custom-input" name="card_type" id="card_type" required disabled="">
                                <option value="credit" <?php if ($data['result']['card_type'] == 'credit') { ?> selected="" <?php } ?>>Credit Card</option>
                                <option value="debit" <?php if ($data['result']['card_type'] == 'debit') { ?> selected="" <?php } ?>>Debit Card</option>
                            </select>                         
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $cardNumber = base64_decode($data['result']['card_number']);
            $cardNumber = "************" . substr($cardNumber, 0, -12);
            ?>
            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label class="form-label fw-bold float-start">Card Number</label>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text" readonly="" onkeypress="return /[0-9]/i.test(event.key)" oninput="javascript: if (this.value.length > 16) this.value = this.value.slice(0, 16);" class="form-custom-input" name="card_number" id="card_number" placeholder="Card Number" value="{{ $cardNumber }}">                        
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
                            <input type="text" class="form-custom-input" name="card_name" id="card_name" placeholder="Card Holder Name" value="{{ $data['result']['card_holder_name'] }}">
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
                            <select class="form-select form-custom-input" name="card_expiry_month" id="card_expiry_month" required>
                                <option value="" selected="" disabled="">Select Expiry Month</option>
                                <?php for ($m = 01; $m <= 12; $m++) { ?>
                                    <option value="{{$m}}" <?php if ($data['result']['exp_month'] == "$m") { ?> selected="" <?php } ?>>{{$m}}</option>
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
                            <select class="form-select form-custom-input" name="card_expiry_year" id="card_expiry_year" required>
                                <option value="" selected="" disabled="">Select Expiry Year</option>
                                <?php
                                $lastYear = date('Y') + 22;
                                $startYear = date('Y') - 22;
                                for ($y = $lastYear; $y >= $startYear; $y--) {
                                    ?>
                                    <option value="{{$y}}" <?php if ($data['result']['exp_year'] == "$y") { ?> selected="" <?php } ?>>{{$y}}</option>
                                <?php } ?>
                            </select>                  
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-8 col-lg-8 ">
                <div class="mb-3 form-check">
                    <input class="form-check-input my-2" type="checkbox" name="default_card" id="default_card" <?php if ($data['result']['is_default_card'] == 1) { ?> checked="" <?php } ?> style="display: none;">
                    <label class="form-check-label pt-1" for="default_card"  id="termsAndConditionsLabel" style="font-style:italic;">
                        Your payment details will be saved for faster processing
                    </label>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-8 col-lg-8 text-center">
                <button type="button" class="btn bg-blue btn-hover text-white text-uppercase my-5" id="addCardSubmitBtn">Update Card</button>
            </div>
        </form>
        <!--Form Section Ends Here-->
    </div>
</div>
</section>
@endsection
@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.2.0/jquery.creditCardValidator.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
                                $(document).ready(function () {
                                    //add new card
                                    $('#addCardSubmitBtn').click(function () {
                                        $('#addCardSubmitBtn').prop('disabled', true);
                                        $('#addCardSubmitBtn').html('Processing...');
                                        var err = 0;
                                        var card_id = "<?php echo $data['result']['id'] ?>";
                                        var card_type = $('#card_type').val();
                                        var card_name = $('#card_name').val();
                                        var card_expiry_month = $('#card_expiry_month').val();
                                        var card_expiry_year = $('#card_expiry_year').val();
                                        var default_card = 0;
                                        if ($("#default_card").is(":checked")) {
                                            default_card = 1;
                                        }
                                        $("#card_name").css('border-color', '#ced4da');
                                        $("#card_expiry_month").css('border-color', '#ced4da');
                                        $("#card_expiry_year").css('border-color', '#ced4da');
                                        if ($('#card_name').val() == '') {
                                            $('#card_name').css('border-color', 'red');
                                            err = 1;
                                        }
                                        if ($('#card_expiry_month option:selected').val() == '') {
                                            $('#card_expiry_month').css('border-color', 'red');
                                            err = 1;
                                        }
                                        if ($('#card_expiry_year option:selected').val() == '') {
                                            $('#card_expiry_year').css('border-color', 'red');
                                            err = 1;
                                        }
                                        if (err == 0) {
                                            $.ajax({
                                                url: "<?php echo URL('/buyer/save-card') ?>",
                                                data: {card_id: card_id, default_card: default_card, card_type: card_type, card_name: card_name, card_expiry_month: card_expiry_month, card_expiry_year: card_expiry_year, '_token': "{{ csrf_token() }}"},
                                                type: "post",
                                                dataType: 'json',
                                                success: function (response) {
                                                    if (response.success == 1) {
                                                        $('#addCardSubmitBtn').prop('disabled', false);
                                                        $('#addCardSubmitBtn').html('Update Card');
                                                        Swal.fire({
                                                            allowOutsideClick: false,
                                                            allowEscapeKey: false,
                                                            title: 'Done',
                                                            text: "Card updated successfully",
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
                                                                window.location.href = "<?php echo URL('/buyer/card-list') ?>";
                                                            }
                                                        });
                                                    } else if (response.success == 2) {
                                                        $('#addCardSubmitBtn').prop('disabled', false);
                                                        $('#addCardSubmitBtn').html('Update Card');
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
                                                    } else if (response.success == 3) {
                                                        $('#addCardSubmitBtn').prop('disabled', false);
                                                        $('#addCardSubmitBtn').html('Update Card');
                                                        Swal.fire({
                                                            title: 'Oops!! Card not valid',
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
                                                        window.location.href = "<?php echo URL('/buyer/card-list') ?>";
                                                    } else {
                                                        $('#addCardSubmitBtn').prop('disabled', false);
                                                        $('#addCardSubmitBtn').html('Update Card');
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
                                                    $('#addCardSubmitBtn').html('Update Card');
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
                                            $('#addCardSubmitBtn').html('Update Card');
                                        }
                                    });
                                });
</script>
@endpush