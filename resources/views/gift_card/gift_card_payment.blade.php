@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>Gift Card Payment</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (Session::has('error')) {
    ?>
    <script>
        Swal.fire({
            title: 'Oops!',
            text: "{{ Session::get('error') }}",
            icon: 'error',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    </script>
<?php } if (Session::has('success')) { ?>
    <script>
        Swal.fire({
            title: 'Congratulations!',
            text: "{{ Session::get('success') }}",
            icon: 'success',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    </script>
<?php } ?>
<section class="add_product_section">
    <div class="container">
        <div class="row mb-3">
            <?php if (count($data['result']) > 0) { ?>
                <form class="pb-3" name="giftCardPaymentForm" id="giftCardPaymentForm" method="post">
                    <?php
                    foreach ($data['result'] as $key => $row) {
                        $cardNumber = "************" . substr(base64_decode($row['card_number']), 0, -12);
                        ?>
                        <div class="d-flex flex-row pb-3">
                            <div class="d-flex align-items-center pe-2">
                                <input class="form-check-input" value="{{ $row['id'] }}" type="radio" 
                                       name="card_id" id="radioNoLabel_{{$key}}" aria-label="..." <?php if ($row['is_default_card'] == 1) { ?> checked="checked" <?php } ?> />
                            </div>
                            <div class="rounded border d-flex w-100 p-3 align-items-center">
                                <p class="mb-0">
                                    <i class="fab fa-cc-visa fa-lg text-dark pe-2"></i>{{ $row['brand'] }} {{ ucfirst($row['card_type']) }}
                                </p>
                                <div class="ms-auto">{{ $cardNumber }}</div>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <input type="password" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" oninput="javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);" name="cvv" id="cvv" placeholder="CVV">                      
                    <p class="text-danger" id="cardErr" style="display: none">Please select card</p>
                    <input type="submit" class="btn bg-blue text-white float-end add-to-cart text-uppercase mt-3" name="payBtn" id="payBtn" value="Pay">
                </form>
            <?php } else {
                ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-danger" role="alert">
                        No Card Exist Yet
                    </div>
                    <?php
                    if (auth()->user()->role_id == 1) {
                        $addCardUrl = URL('/buyer/add-card');
                    }if (auth()->user()->role_id == 2) {
                        $addCardUrl = URL('/seller/add-card');
                    }
                    ?>
                    <a class="btn bg-blue btn-hover text-white text-uppercase" href="{{ $addCardUrl }}">
                        Add Card
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
@endsection
@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        //gift card payment form
        $("form[name='giftCardPaymentForm']").submit(function (event) {
            event.preventDefault();
            var regCVV = /^[0-9]{3,4}$/;
            $("#payBtn").prop('disabled', true);
            $("#payBtn").val('Processing...');
            $('#cardErr').css('display', 'none');
            var card_id = '';
            var from_name = "{{ $data['giftCardData']['from_name'] }}";
            var recipient_user_id = "{{ $data['giftCardData']['recipient_user_id'] }}";
            var recipient_email = "{{ $data['giftCardData']['recipient_email'] }}";
            var amount = "{{ $data['giftCardData']['gift_amount'] }}";
            var message = "{{ $data['giftCardData']['message'] }}";
            $("#cvv").css('border-color', '#ced4da');

            if ($('input[name="card_id"]').length > 0) {
                var card_id = $('input[name="card_id"]:checked').val();
                if (typeof card_id === 'undefined') {
                    $("#payBtn").prop('disabled', false);
                    $("#payBtn").val('Pay');
                    $('#cardErr').html('Please select card');
                    $('#cardErr').css('display', 'block');
                    return false;
                }
            } else {
                $("#payBtn").prop('disabled', false);
                $("#payBtn").val('Add to Cart');
                $('#cardErr').html('Please select card');
                $('#cardErr').css('display', 'block');
                return false;
            }
            if ($('#cvv').val() == '' || $.trim($('#cvv').val()).length == 0) {
                if ($.trim($('#cvv').val()).length == 0)
                    $('#cvv').val('')
                $("#cvv").css('border-color', 'red');
                $("#payBtn").prop('disabled', false);
                $("#payBtn").val('Pay');
                $('#cardErr').html('Please enter CVV');
                $('#cardErr').css('display', 'block');
                return false;
            } else {
                if (!regCVV.test($('#cvv').val())) {
                    $("#cvv").css('border-color', 'red');
                    $("#payBtn").prop('disabled', false);
                    $("#payBtn").val('Pay');
                    $('#cardErr').html('Please enter valid CVV');
                    $('#cardErr').css('display', 'block');
                    return false;
                }
            }

            Swal.fire({
                allowOutsideClick: false,
                allowEscapeKey: false,
                title: 'Are you sure?',
                text: "You want to pay!",
                icon: 'success',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-info ms-2'
                },
                confirmButtonText: 'Yes, Pay!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{URL('/send-gift-card')}}",
                        type: 'POST',
                        data: {cvv: window.btoa($('#cvv').val()), card_id: card_id, from_name: from_name, recipient_user_id: recipient_user_id, recipient_email: recipient_email, amount: amount, message: message, '_token': "{{ csrf_token() }}"},
                        dataType: 'json',
                    }).done(function (response, status, xhr) {
                        if (response.success === true) {
                            $("#payBtn").prop('disabled', false);
                            $("#payBtn").val('Pay');
                            Swal.fire({
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                title: 'Congratulations',
                                text: "Gift card sent successfully",
                                icon: 'success',
                                showCancelButton: true,
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-info mx-2 bg-blue text-white'
                                },
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('gift.card') }}";
                                }
                            });
                        }
                        if (response.success === false) {
                            $("#payBtn").prop('disabled', false);
                            $("#payBtn").val('Pay');
                            swal.fire("Oops!", response.message, "error");
                        }
                    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                        $("#payBtn").prop('disabled', false);
                        $("#payBtn").val('Pay');
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
        });
    });
</script>
@endpush