<!--//Login Moadal:-->
<style>

    .fa-star:hover {

        color: #FF912C !important;

    }

i.fa{

    color:#ccc!important;

}

    .fa-star.selected {

        color: #FF912C !important;

    }

</style>
<div class="modal fade" id="rateReviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title text-black" id="staticBackdropLabel">Rating & Review</h3>
                </div>                  
                <div class="">
                    <form class="" action="" method="post" name="rateReviewForm" id="rateReviewForm">
                        @csrf
                        <div class="my-2 mt-3">
                            <ul class="h2 rating justify-content-center ps-0 pb-3 d-inline-flex w-100" data-mdb-toggle="rating">
                                <li>
                                    <i class="rating_star fa fa-star fa-lg text-primary" data-number="1"></i>
                                </li>
                                <li>
                                    <i class="rating_star fa fa-star fa-lg text-primary" data-number="2"></i>
                                </li>
                                <li>
                                    <i class="rating_star fa fa-star fa-lg text-primary" data-number="3"></i>
                                </li>
                                <li>
                                    <i class="rating_star fa fa-star fa-lg text-primary" data-number="4"></i>
                                </li>
                                <li>
                                    <i class="rating_star fa fa-star fa-lg text-primary" data-number="5"></i>
                                </li>
                            </ul>
                            
                        </div>
                        <div class="my-2">
                            <textarea class="form-control" name="review" id="review" cols="20" rows="5" placeholder="Write review"></textarea>
                        </div>
                        </br>
                        <div class="my-2 text-center float-start">
                            <input type="hidden" name="rating_id" id="rating_id">
                            <input type="hidden" name="seller_id" id="seller_id">
                            <input type="hidden" name="type" id="type">
                            <input type="hidden" name="order_id" id="order_id">
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="submit" class="btn btn-primary bg-blue btn-lg btn-hover btn-round h-auto me-3" id="rateReviewFormSubBtn" value="Submit" />
                        </div>
                        <button type="button" class="mt-2 btn btn-primary bg-blue btn-lg btn-hover btn-round" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('.rating_star').click(function () {
            var star = $(this);
            $('.rating_star').removeClass('selected');
            for (let i = 1; i <= $(this).attr('data-number'); i++) {
                $(".rating_star[data-number='"+i+"']").addClass('selected');
            }
        });
        $("#rateReviewFormSubBtn").click(function (event) {
            event.preventDefault();
            var ratingCount = 0;
            $('.rating_star').each(function (i, e) {
                if ($(this).hasClass('selected')) {
                    ratingCount += 1;
                }
            });
            $("#rateReviewFormSubBtn").prop('disabled', true);
            $("#rateReviewFormSubBtn").val('Processing...');
            $("#review").css('border-color', '#ced4da');
            // if ($('#review').val() == '' || $.trim($('#review').val()).length == 0) {
            //     if ($.trim($('#review').val()).length == 0)
            //         $('#review').val('')
            //     $('#review').focus().select();
            //     $("#review").css('border-color', 'red');
            //     $("#rateReviewFormSubBtn").prop('disabled', false);
            //     $("#rateReviewFormSubBtn").val('Submit');
            //     return false;
            // }

            $.ajax({
                url: "{{URL('/buyer/rate-review')}}",
                type: 'POST',
                data: {rating_id: $('#rating_id').val(), type: $('#type').val(), seller_id: $('#seller_id').val(), rating: ratingCount, review: $.trim($('#review').val()), order_id: $('#order_id').val(), product_id: $('#product_id').val(), '_token': "{{ csrf_token() }}"},
                dataType: 'json',
            }).done(function (response, status, xhr) {
                if (response.success === false) {
                    $("#rateReviewFormSubBtn").prop('disabled', false);
                    $("#rateReviewFormSubBtn").val('Submit');
                    swal.fire("Oops!", response.message, "error");
                }
                if (response.success === true) {
                    $('#rateReviewFormSubBtn').prop('disabled', false);
                    $('#rateReviewFormSubBtn').html('Submit');
                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        title: 'Done',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        timer: 3000,
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
                    setTimeout(function(){
                         window.location.reload();
                    },3000);
                    $("#rateReviewModal").modal('hide');
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $("#rateReviewFormSubBtn").prop('disabled', false);
                $("#rateReviewFormSubBtn").val('Submit');
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

