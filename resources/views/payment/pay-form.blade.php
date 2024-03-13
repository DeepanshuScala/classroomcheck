<div class="container-fluid">
    <form accept-charset="UTF-8" action="{{ url($data['form_url']) }}" class="require-validation"
          data-cc-on-file="false" data-stripe-publishable-key="{{env('STRIPE_PUBLISH_KEY')}}" id="payment-form" method="post">
        @csrf
        <input type="hidden" name="price" value="{{$data['checkout_price']}}">

        <div class="row">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Card Holders Name" value="" required name="card_holder_name" onkeypress="return /[a-z ]/i.test(event.key)">
                <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
            </div>
        </div><br>
        <div class="row">
            <div class="form-group">
                <input autocomplete='off' class='form-control card-number' size='20' type='text' placeholder='Card Number' name="card_number" id="card_number" minlength="16" maxlength="16"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
            </div><br>
            <!--        <div class="form-group">
                        <span><b>Save card for next time</b></span>
                        <input type="checkbox" id="card_switch" />
                        <label for="card_switch">Toggle</label>
                        <small class='card_status hide'></small>
                    </div>-->
        </div><br>
        <div class="row">
            <div class="form-group col-md-4 col-12">
                <input type="text" name="exp_month" class="card-expiry-month form-control" placeholder="Month(MM)" value="" minlength="2" maxlength="2"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
            </div>
            <!--<div class="col-1"></div>-->
            <div class="form-group col-md-4 col-12">
                <input type="text" name="exp_year" class="card-expiry-year form-control" placeholder="Year(YYYY)" value="" minlength="4" maxlength="4"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
            </div>
            <!--<div class="col-1"></div>-->
            <div class="form-group col-md-4 col-12">
                <input type="text" class="card-cvc form-control" placeholder="cvv" value="" name="cvv" minlength="3" maxlength="3"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
            </div>
        </div><br>


        <div class='form-row mb-3'>
            <div class='col-md-12'>
                <div class='form-control total btn btn-info '>
                    Total: <span class='amount'>&#36;{{$data['checkout_price']}}</span>
                </div>
            </div>
        </div>
        <div class='form-row '>
            <div class='col-md-12 form-group'>
                <button style="background-color: #31708e;color: #fff;text-align: center;line-height: 20px"
                        class='form-control button submit-button' type='submit'>Pay »</button>
            </div>
        </div>
        <div class='form-row mb-3 mt-3'>
            <div class='col-md-12'>
                <a href="{{ URL('/') }}">
                    <div class='form-control total btn btn-info'>
                        Back
                    </div>
                </a>
            </div>
        </div>
        <div class='form-row' style="display:none;">
            <div class='col-md-12 error form-group hide'>
                <div class='alert-danger alert'>Please correct the errors and try again.</div>
            </div>
        </div>
        <input type="text" value="" name="save_for_future" id="future_card" hidden>
    </form>

</div>