<!--//Buy License to share Modal:-->
<div class="modal fade pe-0" id="buyLicenseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="text-start" id="error_message">
                    <h3 class="modal-title display-8 mb-3 fw-bold" id="staticBackdropLabel">Product Licensing</h3>
                    <p class="buy-license-to-share-price">For this item, the cost for one user (you) is <strong class="single-buy-license-to-share">$5.95</strong>. If you plan to share this product with other teachers in your school, please add the number of additional users' licenses that you need to purchase. Additional license costs only <strong class="mutiple-buy-license-to-share">$5.36</strong>.</p>
                    <hr>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="licenseForm" id="licenseForm">
                        @csrf
                        <div class="my-4 mb-4 d-flex align-items-center" id="emailError">
                            <strong>I need to purchase</strong>
                            <input type="number" class="form-control mx-3 h-auto py-2" name="quantity" id="quantity" value="1" min="0">
                            <strong>additional licenses.</strong>
                        </div>
                        <table id="price-description" class="table align-middle m-0 ">
                            <thead>
                                <tr class="text-start"> 
                                    <th>License</th>
                                    <th>Price</th>
                                </tr> 
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="my-2 mt-4 text-start float-start">
                            <input type="hidden" name="product_id">
                            <input type="submit" class="btn btn-primary btn-hover px-4 py-2 me-3 h-auto" id="loginSubmitBtn" value="Buy More Licenses" />
                        </div>
                        <button type="button" class="btn btn-primary btn-hover px-4 py-2 mt-4" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('keyup change',"form#licenseForm input[name='quantity']",function(){

            var price = $("form#licenseForm .total-price").attr('data-price');
            var sprice = $("form#licenseForm .single-license-price").attr('data-single-license');
            var qty = ($(this).val() !== '' && $(this).val() > 0 ) ? (parseInt($(this).val())+1) : 0;
            var qty1 = ($(this).val() !== '' && $(this).val() > 0 ) ? qty-1 : 1;
            var ttl = Number(qty* price).toFixed(2);
            if(qty === 0){
                ttl = $("form#licenseForm .single-license-price").attr('data-single-license');
                $("body .single-license-price").html('$'+sprice);
                $("body form#licenseForm .multiple-license-price").html("0 x $"+price);
            }
            else{
                $(".single-license-price").html('$'+price); 
                $("form#licenseForm .multiple-license-price").html( qty1 + ' x $' + price);
            }
            $("form#licenseForm .total-price").html('$' + ttl );

        });

        $(document).on('submit','form#licenseForm',function(e){
            e.preventDefault();

            var product_id = $('form#licenseForm input[name="product_id"]').val();
            var qty = $('form#licenseForm input[name="quantity"]').val() !== '' ? (parseInt($('form#licenseForm input[name="quantity"]').val())+1) : 1;
            $('form#licenseForm input[type="submit"]').prop('disabled',true);
            $.ajax({
                    url: "{{route('check.if.alreadypurached')}}",
                    type: 'POST',
                    data: {product_id: product_id, _token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {
                        //$(".is-favourite").prop('disabled', true);
                        $(".add-remove-cart-action").css("pointer-events", 'none');
                    } 
            }).done(function (response, status, xhr) {
                $('form#licenseForm input[type="submit"]').prop('disabled',false);
                if(response.status == 1){
                    Swal.fire({
                        title: 'Product Already Purchased',
                        showDenyButton: true,
                        confirmButtonText: 'Buy Again',
                        denyButtonText: 'No',
                    }).then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                url: "{{route('change.quantity.cart')}}",
                                type: 'POST',
                                data: {product_id: product_id,quantity:qty,type:'add' ,_token: '{{ csrf_token() }}'},
                            }).done(function (response, status, xhr) {

                                if (response.success === true) {

                                    window.location.replace("{{route('accountDashboard.myCart')}}");
                                
                                }
                                if (response.success === false) {
                                    $('form#licenseForm input[type="submit"]').prop('disabled',false);
                                    Swal.fire({
                                        title: 'Oops',
                                        text: response.message,
                                        icon: 'warning',
                                        showConfirmButton: false,
                                        timer: 2000,
                                        //closeOnClickOutside: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                    });
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
                        else if (result.isDenied) {
                            Swal.close();
                            return false;
                        }
                    })
                }    
                if(response.status == 2){
                    $.ajax({
                        url: "{{route('change.quantity.cart')}}",
                        type: 'POST',
                        data: {product_id: product_id,quantity:qty,type:'add' ,_token: '{{ csrf_token() }}'},
                    }).done(function (response, status, xhr) {

                        if (response.success === true) {

                            window.location.replace("{{route('accountDashboard.myCart')}}");
                        
                        }
                        if (response.success === false) {
                            $('form#licenseForm input[type="submit"]').prop('disabled',false);
                            Swal.fire({
                                title: 'Oops',
                                text: response.message,
                                icon: 'warning',
                                showConfirmButton: false,
                                timer: 2000,
                                //closeOnClickOutside: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
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
                if(response.status == 0){
                    swal.fire(response.message,"", "warning");
                }
                $('#buyLicenseModal').modal('hide');
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                if (xhr.status == 419 && xhr.statusText == "unknown status") {
                    swal.fire("Unauthorized! Session expired", "Please login again", "error");
                } else {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        Swal.fire({
                            title: 'Oops...',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            showConfirmButton: true,
                            //closeOnClickOutside: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            //        timer: 3000
                        });
                    } else {
                        swal.fire('Unable to process your request', "Please try again", "error");
                    }
                }
            });
        });

    });
</script>
@endpush