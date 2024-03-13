@extends('layouts.master')
@section('title', 'Gift Card')
@section('description', 'Give the gift of choice with a Classroom Copy gift card (e-voucher). E-vouchers are emailed to the recipient via the address provided at checkout. Classroom Copy Gift Cards never expire!')
<?php
$ogimage = asset('images/GIft-Card.jpg');
?>
@section('content')
<!--Gift Card  Section Starts Here-->
<section class="gift_card_section pb-5">
    <div class="container">
        <div class="row flex-lg-row-reverse align-items-start g-4">
            <div class="col-12 col-sm-12 col-lg-6 pt-5">
                <img src="{{asset('images/GIft-Card.jpg')}}" class="d-block mx-lg-auto img-fluid mb-3" alt="GIft-Card">
                <div class="row">
                    <div class="col-12 col-sm-12 col-lg-7 ms-auto float-start gift-search-box">
                        <p>Check Your Gift Card Balance Here:</p>
                        <div class="gift-search mb-2"> 
                            <input type="text" id="gift_code" name="gift_code" class="form-control" placeholder="Gift Code (10 Digit)"> 
                            <button class="btn-hover" id="checkGiftCardBalance">Go</i></button> 
                            <p id="showBalance"></p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-lg-4  d-flex justify-content-end ">
                        <div class="text-muted py-1 text-capitalize social-icon-box">
                            <p>Share This Resourse:</p>
                            <ul class="social-icons d-flex flex-lg-row ps-0 mt-2">
                                <li>
                                    <a href="http://www.facebook.com/sharer.php?u={{urlencode(Request::url())}}" target="_blank"><img src="{{asset('images/emailer-facebook.png')}}" class="img-fluid me-2" alt="facebook"></a>
                                </li>
                                <li>
                                    <a href="http://pinterest.com/pin/create/button/?description=giftcard&url={{Request::url()}}" target="_blank"><img src="{{asset('images/emailer-pinterest.png')}}" class="img-fluid me-2" alt="pinterest"></a>
                                </li>
                                
                                <li>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{urlencode(Request::url())}}" target="_blank"><img src="{{asset('images/emailer-linkedin.png')}}" class="img-fluid me-2" alt="pinterest"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12 my-0 py-4">
                <h1 class="text-uppercase pt-0 pt-lg-5">
                    Gift Card
                </h1>
                <p class="pb-3 ">Give the gift of choice with a Classroom Copy gift card (e-voucher) <br>  E-vouchers are emailed to the recipient via the address provided at checkout. Classroom Copy Gift Cards never expire! </p>
                <form class="pb-5" action="{{ route('gift.card') }}" method="post" id="giftCardForm" name="giftCardForm">
                    @csrf
                    <div class="row mb-3">
                        <?php $giftCardAmount = (new App\Http\Helper\ClassroomCopyHelper)->getGiftCardAmount(); ?>
                        <label for="amount" class="col-sm-3 col-form-label">Amount:</label>
                        <div class="col-sm-9">
                            <select id="amount" name="amount" class="form-select bg-light noValue">
                                <option selected value="" disabled="">Select Amount</option>
                                @foreach($giftCardAmount as $amt)
                                <option value="{{$amt}}" {{ (isset($data['gift_amount']) && $data['gift_amount']== $amt) ? 'selected' : '' }}>${{$amt}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class=" row mb-3 ">
                        <label for="from_name" class="col-sm-3 col-form-label ">From:</label>
                        <div class="col-sm-9 ">
                            <input type="text" class="form-control bg-light" id="from_name" name="from_name" value="{{ isset($data['from_name']) ? $data['from_name'] : '' }}">
                        </div>
                    </div>
                    <?php
                    /*
                        <div class="row mb-3">
                            <label for="recipient_role" class="col-sm-3 col-form-label">Recipient Type:</label>
                            <div class="col-sm-9">
                                <select id="recipient_role" name="recipient_role" class="form-select bg-light" required="">
                                    <option selected value="" disabled="">Select Type</option>
                                    <option value="1" {{ (isset($data['recipient_role']) && $data['recipient_role']== 1) ? 'selected' : '' }}>Buyer</option>
                                    <option value="2" {{ (isset($data['recipient_role']) && $data['recipient_role']== 2) ? 'selected' : '' }}>Seller</option>
                                </select>
                            </div>
                        </div>
                    */
                    ?>
                    <div class="row mb-3 ">
                        <label for="recipient_email" class="col-sm-3 col-form-label pe-0">Recipient Email :</label>
                        <div class="col-sm-9 ">
                            <input type="email" class="form-control bg-light" id="recipient_email" name="recipient_email" value="{{ isset($data['recipient_email']) ? $data['recipient_email'] : '' }}">
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label for="message" class="col-sm-3 col-form-label ">Message :</label>
                        <div class="col-sm-9 ">
                            <textarea class="form-control bg-light" id="message" rows="3" name="message">{{ isset($data['message']) ? $data['message'] : '' }}</textarea>
                            <div class="text-end blue character py-2">150 Character Max.</div>
                        </div>
                    </div>
                    <input type="hidden" name="recipient_user_id" id="recipient_user_id"value="{{ isset($data['recipient_user_id']) ? $data['recipient_user_id'] : '' }}">
                    <input type="hidden" name="gift_card_edit_id" id="gift_card_edit_id" value="{{ isset($data['gift_card_edit_id']) ? $data['gift_card_edit_id'] : '' }}">
                    <button type="submit" class="px-4 py-3 btn bg-blue text-white float-end add-to-cart text-uppercase w-auto h-auto position-relative" name="addGiftCardBtn" id="addGiftCardBtn" value=""><i class="fal fa-shopping-cart me-2"></i>{{ isset($data['gift_card_edit_id']) ? 'Update Cart' : 'Add to cart' }}</button>
                </form>


                <h5 class="py-2">Fine Print :</h5>
                <ul class="fine-print ps-0">
                    <li><span><i class='fal fa-chevron-double-right pe-2 text-info'></i></span> Card balance remains on the card and is not applied as a credit to your account.
                    </li>
                    <li><span><i class='fal fa-chevron-double-right pe-2 text-info'></i></span> Discount codes cannot be applied to gift card purchases.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--Gift Card Section Ends Here-->
@endsection

@push('script')
<script>
    $(document).ready(function () {
        //check gift balance
        $('#checkGiftCardBalance').click(function () {
            $("#checkGiftCardBalance").prop('disabled', true);
            $("#gift_code").css('border-color', '#E4E4E4');
            if ($('#gift_code').val() == '' || $.trim($('#gift_code').val()).length == 0) {
                if ($.trim($('#gift_code').val()).length == 0)
                    $('#gift_code').val('')
                $("#gift_code").css('border-color', 'red');
                $("#checkGiftCardBalance").prop('disabled', false);
                $('#showBalance').html('');
            } else {
                $.ajax({
                    url: "{{URL('/check-gift-card-balance')}}",
                    type: 'POST',
                    data: {gift_code: $('#gift_code').val(), '_token': "{{ csrf_token() }}"},
                    dataType: 'json',
                }).done(function (response, status, xhr) {
                    $("#checkGiftCardBalance").prop('disabled', false);
                    if (response.success === false) {
                        $('#showBalance').html(response.message);
                    }
                    if (response.success === true) {
                        var balance = parseFloat(response.balance).toFixed(2);
                        $('#showBalance').html('Your Current Balance is $' + balance);
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $("#checkGiftCardBalance").prop('disabled', false);
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
        });

        //
        $("#gift_code").keyup(function(e){
            if(e.keyCode == 13){
                $("#checkGiftCardBalance").prop('disabled', true);
                $("#gift_code").css('border-color', '#E4E4E4');
                if ($('#gift_code').val() == '' || $.trim($('#gift_code').val()).length == 0) {
                    if ($.trim($('#gift_code').val()).length == 0)
                        $('#gift_code').val('')
                    $("#gift_code").css('border-color', 'red');
                    $("#checkGiftCardBalance").prop('disabled', false);
                    $('#showBalance').html('');
                } else {
                    $.ajax({
                        url: "{{URL('/check-gift-card-balance')}}",
                        type: 'POST',
                        data: {gift_code: $('#gift_code').val(), '_token': "{{ csrf_token() }}"},
                        dataType: 'json',
                    }).done(function (response, status, xhr) {
                        $("#checkGiftCardBalance").prop('disabled', false);
                        if (response.success === false) {
                            $('#showBalance').html(response.message);
                        }
                        if (response.success === true) {
                            var balance = parseFloat(response.balance).toFixed(2);
                            $('#showBalance').html('Your Current Balance is $' + balance);
                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        $("#checkGiftCardBalance").prop('disabled', false);
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
            }
        });

        //submit gift card form
        $("#addGiftCardBtn").on('click',function (event) {
            event.preventDefault();
            //return false;
            $("#addGiftCardBtn").prop('disabled', true);
            $("#addGiftCardBtn").val('Processing...');
            $("#amount").css('border-color', '#E4E4E4');
            $("#from_name").css('border-color', '#E4E4E4');
            $("#recipient_email").css('border-color', '#E4E4E4');
            $("#message").css('border-color', '#E4E4E4');
            $("form#giftCardForm .error_msg").remove();
            if ($('#amount').val() == '' || $.trim($('#amount').val()).length == 0) {
                if ($.trim($('#amount').val()).length == 0)
                    $('#amount').val('')
                $('#amount').focus().select();
                $("#amount").css('border-color', 'red');
                $("#amount").after('<span class="error text-danger error_msg">Select Amount</span>');
                $("#addGiftCardBtn").prop('disabled', false);
                $("#addGiftCardBtn").val('Add to Cart');
                return false;
            }
            if ($('#from_name').val() == '' || $.trim($('#from_name').val()).length == 0) {
                if ($.trim($('#from_name').val()).length == 0)
                    $('#from_name').val('')
                $('#from_name').focus().select();
                $("#from_name").css('border-color', 'red');
                $("#from_name").after('<span class="error text-danger error_msg">Please enter a name</span>');
                $("#addGiftCardBtn").prop('disabled', false);
                $("#addGiftCardBtn").val('Add to Cart');
                return false;
            }
            
            if ($('#recipient_email').val() == '' || $.trim($('#recipient_email').val()).length == 0) {
                if ($.trim($('#recipient_email').val()).length == 0)
                    $('#recipient_email').val('')
                $('#recipient_email').focus().select();
                $("#recipient_email").css('border-color', 'red');
                $("#recipient_email").after('<span class="error text-danger error_msg">Please add an recipient email</span>');
                $("#addGiftCardBtn").prop('disabled', false);
                $("#addGiftCardBtn").val('Add to Cart');
                return false;
            }
            if ($('#message').val() == '' || $.trim($('#message').val()).length == 0) {
                if ($.trim($('#message').val()).length == 0)
                    $('#message').val('')
                $('#message').focus().select();
                $("#message").css('border-color', 'red');
                $("#message").after('<span class="error text-danger error_msg">Please enter a message</span>');
                $("#addGiftCardBtn").prop('disabled', false);
                $("#addGiftCardBtn").val('Add to Cart');
                return false;
            } else {
                if ($.trim($('#message').val()).length > 150) {
                    $('#message').focus().select();
                    $("#message").css('border-color', 'red');
                    $("#message").after('<span class="error text-danger error_msg">Please enter a message less than 150 words</span>');
                    $("#addGiftCardBtn").prop('disabled', false);
                    $("#addGiftCardBtn").val('Add to Cart');
                    return false;
                }
            }

            //check recipient email exist or not
            $.ajax({
                url: "{{URL('/check-email')}}",
                type: 'POST',
                data: {email: $('#recipient_email').val(), '_token': "{{ csrf_token() }}"},
                dataType: 'json',
            }).done(function (response, status, xhr) {
                if (response.success === false) {
                    $("#recipient_email").css('border-color', 'red');
                    $("#addGiftCardBtn").prop('disabled', false);
                    $("#addGiftCardBtn").val('Add to Cart');
                    swal.fire("Oops!", "Recipient email not valid", "error");
                }
                if (response.success === true) {
                    $("#recipient_email").css('border-color', '#E4E4E4');
                    $('#recipient_user_id').val(response.recipient_user_id);
                    $("#addGiftCardBtn").prop('disabled', false);
                    $('#giftCardForm').submit();
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $("#addGiftCardBtn").prop('disabled', false);
                $("#addGiftCardBtn").val('Add to Cart');
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
        });
    });
</script>
@endpush