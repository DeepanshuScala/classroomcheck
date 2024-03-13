@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>FEATURE LISTING PAYMENT</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{ URL('/seller/marketing/feature-listing') }}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Feature Listing
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page title end  -->

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

<!-- page title start -->
<section class="inner_page pb-0">
    <div class="container">                  
        <div class="row mb-3">
            <?php if (count($data['cards']) > 0) { ?>
                <form class="pb-3" name="paymentForm" id="paymentForm" method="post">
                    @csrf
                    <?php
                    foreach ($data['cards'] as $key => $row) {
                        $cardNumber = "************" . substr(base64_decode($row['card_number']), 0, -12);
                        ?>
                        <div class="d-flex flex-row pb-3">
                            <div class="d-flex align-items-center">
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
                    <input type="button" class="btn bg-blue text-white float-Start add-to-cart cursor-default text-uppercase mt-3" value="Amount : ${{ number_format($data['amount'],2) }} {{ env('CURRENCY') }}" >
                    <input type="button" class="btn bg-blue text-white float-end add-to-cart text-uppercase mt-3" name="payBtn" id="payBtn" value="Pay »">
                </form>
            <?php } else {
                ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-danger" role="alert">
                        No Card Exist Yet
                    </div>
                    <?php
                    $addCardUrl = URL('/seller/add-card');
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
        $("#payBtn").click(function (event) {
            event.preventDefault();
            var regCVV = /^[0-9]{3,4}$/;
            $("#payBtn").prop('disabled', true);
            $("#payBtn").val('Processing...');
            $('#cardErr').css('display', 'none');
            var card_id = '';
            $("#cvv").css('border-color', '#ced4da');

            if ($('input[name="card_id"]').length > 0) {
                var card_id = $('input[name="card_id"]:checked').val();
                if (typeof card_id === 'undefined') {
                    $("#payBtn").prop('disabled', false);
                    $("#payBtn").val('Pay >>');
                    $('#cardErr').html('Please select card');
                    $('#cardErr').css('display', 'block');
                    return false;
                }
            } else {
                $("#payBtn").prop('disabled', false);
                $("#payBtn").val('Pay >>');
                $('#cardErr').html('Please select card');
                $('#cardErr').css('display', 'block');
                return false;
            }
            if ($('#cvv').val() == '' || $.trim($('#cvv').val()).length == 0) {
                if ($.trim($('#cvv').val()).length == 0)
                    $('#cvv').val('')
                $("#cvv").css('border-color', 'red');
                $("#payBtn").prop('disabled', false);
                $("#payBtn").val('Pay >>');
                $('#cardErr').html('Please enter CVV');
                $('#cardErr').css('display', 'block');
                return false;
            } else {
                if (!regCVV.test($('#cvv').val())) {
                    $("#cvv").css('border-color', 'red');
                    $("#payBtn").prop('disabled', false);
                    $("#payBtn").val('Pay >>');
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
                    $('#paymentForm').submit();
                } else {
                    $("#payBtn").prop('disabled', false);
                    $("#payBtn").val('Pay >>');
                }
            });

        });
    });
</script>
@endpush
