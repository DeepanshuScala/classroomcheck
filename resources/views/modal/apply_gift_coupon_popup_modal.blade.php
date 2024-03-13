<!--//Login Moadal:-->
<div class="modal fade" id="applyGiftCouponModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title blue display-6 mb-4 fw-bold" id="staticBackdropLabel">Apply Gift Coupon</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="applyGiftCouponForm" id="applyGiftCouponForm">
                        @csrf
                        <div class="my-2">
                            <input type="text" class="form-control" name="gift_coupon" id="gift_coupon" placeholder="Enter Gift Coupon" autocomplete="off" required="">
                        </div>
                        </br>
                        <div class="my-2 text-center">
                            <input type="submit" class="btn btn-primary btn-hover px-5" id="applyGiftCouponFormSubBtn" value="Apply" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $("#applyGiftCouponFormSubBtn").click(function (event) {
            event.preventDefault();
            $("#applyGiftCouponFormSubBtn").prop('disabled', true);
            $("#applyGiftCouponFormSubBtn").val('Processing...');
            $("#gift_coupon").css('border-color', '#ced4da');
            if ($('#gift_coupon').val() == '' || $.trim($('#gift_coupon').val()).length == 0) {
                if ($.trim($('#gift_coupon').val()).length == 0)
                    $('#gift_coupon').val('')
                $('#gift_coupon').focus().select();
                $("#gift_coupon").css('border-color', 'red');
                $("#applyGiftCouponFormSubBtn").prop('disabled', false);
                $("#applyGiftCouponFormSubBtn").val('Apply');
                return false;
            }
            if($("#checkoutPaymentForm input[name='promotional_code']").val() !== ''){
                $("#applyGiftCouponFormSubBtn").prop('disabled', false);
                $("#applyGiftCouponFormSubBtn").val('Apply');
                swal.fire("Oops!", 'You have already applied promotional code.', "error");
                return false;
            }
            $.ajax({
                url: "{{URL('/apply-gift-coupon-to-cart')}}",
                type: 'POST',
                data: {gift_coupon: $('#gift_coupon').val(), '_token': "{{ csrf_token() }}"},
                dataType: 'json',
            }).done(function (response, status, xhr) {
                if (response.success === false) {
                    $("#gift_coupon").css('border-color', 'red');
                    $("#applyGiftCouponFormSubBtn").prop('disabled', false);
                    $("#applyGiftCouponFormSubBtn").val('Apply');
                    swal.fire("Oops!", response.message, "error");
                }
                if (response.success === true) {
                    var ttl = (Math.round((parseInt(response.cartAmt,10)+parseInt(response.buyer_tax,10)) * 100) / 100).toFixed(2);

                    $("#gift_coupon").css('border-color', '#ced4da');
                    $('#cartTotalAmt').html('$' + response.cartAmt);
                    $('#buyertax').html('$' + response.buyer_tax);
                    $('#totalAmt').html('$' + ttl + ' AUD');
                    $('input[name=checkout_price]').val(ttl);
                    $('input[name=gift_code]').val($("#gift_coupon").val());
                    $("#gift_coupon").val('');
                    $('#useGiftCouponBtn').hide();
                    $('#remove-coupon').show();
                    $('#applyGiftCouponModal').modal('hide');
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $("#applyGiftCouponFormSubBtn").prop('disabled', false);
                $("#applyGiftCouponFormSubBtn").val('Apply');
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

        $(document).on('click','#remove-coupon',function(e){
            e.preventDefault();
            Swal.fire({
              title: 'Are you sure?',
              text: "You are removing gift card",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Remove it!'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('removegiftcard.post')}}",
                    type: 'POST',
                    data: {_token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {

                    }
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        var ttl = (Math.round((parseInt(response.cartAmt,10)+parseInt(response.buyer_tax,10)) * 100) / 100).toFixed(2);
                        $('#cartTotalAmt').html('$' + response.cartAmt);
                        $('#buyertax').html('$' + response.buyer_tax);
                        $('#totalAmt').html('$' + ttl + ' AUD');
                        $('input[name=checkout_price]').val(ttl);
                        $('input[name=gift_code]').val('');
                        $("#gift_coupon").val('');
                        $('#useGiftCouponBtn').show();
                        $('#remove-coupon').hide();
                    }
                    if (response.success === false) {

                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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

