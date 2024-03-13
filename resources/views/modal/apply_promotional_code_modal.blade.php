<!--//Login Moadal:-->
<div class="modal fade" id="applyPromotionalCouponModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title blue display-6 mb-4 fw-bold" id="staticBackdropLabel">Apply Promotional Coupon</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="applyPromotionalCouponForm" id="applyPromotionalCouponForm">
                        @csrf
                        <div class="my-2">
                            <input type="text" class="form-control" name="promotional_coupon" id="promotional_coupon" placeholder="Enter Promotional Coupon" autocomplete="off" required="">
                        </div>
                        </br>
                        <div class="my-2 text-center">
                            <input type="submit" class="btn btn-primary btn-hover px-5" id="applyPromotionalCouponFormSubBtn" value="Apply" />
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
        
        $("#applyPromotionalCouponFormSubBtn").click(function (event) {
            event.preventDefault();
            $("#applyPromotionalCouponFormSubBtn").prop('disabled', true);
            $("#applyPromotionalCouponFormSubBtn").val('Processing...');
            $("#promotional_coupon").css('border-color', '#ced4da');
            if ($('#promotional_coupon').val() == '' || $.trim($('#promotional_coupon').val()).length == 0) {
                if ($.trim($('#promotional_coupon').val()).length == 0)
                    $('#promotional_coupon').val('')
                $('#promotional_coupon').focus().select();
                $("#promotional_coupon").css('border-color', 'red');
                $("#applyPromotionalCouponFormSubBtn").prop('disabled', false);
                $("#applyPromotionalCouponFormSubBtn").val('Apply');
                return false;
            }

            if($("#checkoutPaymentForm input[name='gift_code']").val() !== ''){
                $("#applyPromotionalCouponFormSubBtn").prop('disabled', false);
                $("#applyPromotionalCouponFormSubBtn").val('Apply');
                swal.fire("Oops!", 'You have already applied Gift card.', "error");
                return false;
            }

            $.ajax({
                url: "{{URL('/apply-promotional-coupon-to-cart')}}",
                type: 'POST',
                data: {promotional_coupon: $('#promotional_coupon').val(), '_token': "{{ csrf_token() }}"},
                dataType: 'json',
            }).done(function (response, status, xhr) {
                if (response.success === false) {
                    $("#promotional_coupon").css('border-color', 'red');
                    $("#applyPromotionalCouponFormSubBtn").prop('disabled', false);
                    $("#applyPromotionalCouponFormSubBtn").val('Apply');
                    swal.fire("Oops!", response.message, "error");
                }
                if (response.success === true) {
                    var ttl = (Math.round((parseInt(response.cartAmt,10)+parseInt(response.buyer_tax,10)) * 100) / 100).toFixed(2);
                    $("#promotional_coupon").css('border-color', '#ced4da');
                    $('#cartTotalAmt').html('$' + response.cartAmt);
                    $('#totalAmt').html('$' + ttl + ' AUD');
                    $('input[name=checkout_price]').val(ttl);
                    $('input[name=promotional_code]').val($("#promotional_coupon").val());
                    $("#promotional_coupon").val('');
                    $('#usePromotionalCouponBtn').hide();
                    $('#remove-promotion').show();
                    $('#applyPromotionalCouponModal').modal('hide');
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $("#applyPromotionalCouponFormSubBtn").prop('disabled', false);
                $("#applyPromotionalCouponFormSubBtn").val('Apply');
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

        $(document).on('click','#remove-promotion',function(e){
            e.preventDefault();
            Swal.fire({
              title: 'Are you sure?',
              text: "You are removing Promotional Coupon",
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
                        $('#totalAmt').html('$' + ttl + ' AUD');
                        $('input[name=checkout_price]').val(ttl);
                        $('input[name=promotional_code]').val('');
                        $("#promotional_coupon").val('');
                        $('#usePromotionalCouponBtn').show();
                        $('#remove-promotion').hide();
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