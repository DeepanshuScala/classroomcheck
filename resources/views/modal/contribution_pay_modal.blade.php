<!--//Login Moadal:-->
<div class="modal fade" id="contirbutionSupport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title blue display-6 mb-4 fw-bold" id="staticBackdropLabel">Support Now</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="contributionpay" id="contributionpay">
                        @csrf
                        <div class="my-2">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your name" autocomplete="off">
                        </div>
                        <div class="my-2">
                            <input type="text" onkeypress="return /[0-9]/i.test(event.key)" oninput="javascript: if (this.value.length > 16) this.value = this.value.slice(0, 16);" class="form-control" name="card_number" id="card_number" placeholder="Card Number">
                        </div>
                        <div class="my-2">
                            <select class="form-select" name="card_expiry_month" id="card_expiry_month">
                                <option value="" selected="" disabled="">Select Expiry Month</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="my-2">
                            <select class="form-select" name="card_expiry_year" id="card_expiry_year">
                                <option value="" selected="" disabled="">Select Expiry Year</option>
                                    <option value="2044">2044</option>
                                    <option value="2043">2043</option>
                                    <option value="2042">2042</option>
                                    <option value="2041">2041</option>
                                    <option value="2040">2040</option>
                                    <option value="2039">2039</option>
                                    <option value="2038">2038</option>
                                    <option value="2037">2037</option>
                                    <option value="2036">2036</option>
                                    <option value="2035">2035</option>
                                    <option value="2034">2034</option>
                                    <option value="2033">2033</option>
                                    <option value="2032">2032</option>
                                    <option value="2031">2031</option>
                                    <option value="2030">2030</option>
                                    <option value="2029">2029</option>
                                    <option value="2028">2028</option>
                                    <option value="2027">2027</option>
                                    <option value="2026">2026</option>
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                            </select>
                        </div>
                        <div class="my-2">
                            <input type="password" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" oninput="javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);" name="cvv" id="cvv" placeholder="CVV">
                        </div>
                        <div class="my-2">
                            <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter Amount" autocomplete="off" min="1">
                        </div>
                        </br>
                        <div class="my-2 text-center">
                            <input type="hidden" name="contribution_id">
                            <input type="submit" class="btn btn-primary btn-hover px-5" id="contributionpaySubmit" value="Pay Now" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.2.0/jquery.creditCardValidator.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click',"#contributionpaySubmit",function (event) {
            event.preventDefault();
            
            $("#name").css('border-color', '#ced4da');
            $("#card_number").css('border-color', '#ced4da');
            $("#card_expiry_month").css('border-color', '#ced4da');
            $("#cvv").css('border-color', '#ced4da');
            $("#amount").css('border-color', '#ced4da');
            $("form#contributionpay .error").remove();
            if ($('#name').val() == '') {
                $('#name').css('border-color', 'red');
                $('#name').after('<span class="error text-danger error_msg">Enter your name</span>');
                $('#name').focus().select();
                return false;
            }
            if ($('#card_number').val() == '') {
                $('#card_number').css('border-color', 'red');
                $('#card_number').after('<span class="error text-danger error_msg">Please Enter Your card number</span>');
                $('#card_number').focus().select();
                return false;
            }
            
            if (!$('#card_expiry_month').val()) {
                
                $('#card_expiry_month').css('border-color', 'red');
                $('#card_expiry_month').after('<span class="error text-danger error_msg">Please Select Expiry Month.</span>');
                $('#card_expiry_month').focus().select();
                return false;
            }
            if (!$('#card_expiry_year').val()) {
                
                $('#card_expiry_year').css('border-color', 'red');
                $('#card_expiry_year').after('<span class="error text-danger error_msg">Please Select Expiry Year.</span>');
                $('#card_expiry_year').focus().select();
                return false;
            }
            if ($('#cvv').val() == '') {
                $('#cvv').css('border-color', 'red');
                $('#cvv').after('<span class="error text-danger error_msg">Please enter CVV</span>');
                $('#cvv').focus().select();
                return false;
            }
            if ($('#amount').val() == '') {
                $('#amount').css('border-color', 'red');
                $('#amount').after('<span class="error text-danger error_msg">Please enter a amount.</span>');
                $('#amount').focus().select();
                return false;
            }

            var frm = $("form#contributionpay").serializeArray();
            var err = 0;
            $('#card_number').validateCreditCard(function (result) {
                $("form#contributionpay .error").remove();
                if (!result.valid) {
                    $('#card_number').after('<span class="error text-danger error_msg">Please enter Valid card.</span>');
                }
                else{
                    err = 1;
                }
            });
            if(err == 1){
                $.ajax({
                    url: "{{URL('/contributionpay')}}",
                    type: 'POST',
                    data: frm,
                    dataType: 'json',
                }).done(function (response, status, xhr) {
                        $("#contirbutionSupport").modal('hide');
                        if (response.success === false) {
                            swal.fire("Oops!", response.message, "error");
                        }
                        if (response.success === true) {
                            swal.fire("Done", response.message, "success");
                            setTimeout(function(){
                                location.reload();    
                            },3000);
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
</script>
@endpush