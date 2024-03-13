
<div class="container-fluid">
<form accept-charset="UTF-8" action="{{ url($data['form_url']) }}" class="require-validation"
    data-cc-on-file="false" data-stripe-publishable-key="{{env('STRIPE_publish_KEY')}}" id="payment-form" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="resource_id" value="{{$data['resource_id']}}">
    <input type="hidden" name="session_taken_by_user_id" value="{{$data['session_taken_by_user_id']}}">
    <input type="hidden" name="price" value="{{$data['price']}}">
    <input type="hidden" name="subject" value="{{$data['subject']}}">
    <input type="hidden" name="topic" value="{{$data['topic']}}">
    <input type="hidden" name="timeSlot" value="{{$data['timeSlot']}}">
    <input type="hidden" name="class_date" value="{{$data['class_date']}}">
    <input type="hidden" name="subscribed_plan_id" value="{{$data['subscribed_plan_id']}}">
    
    <div class="row">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Card Holders Name" value="" required name="card_holder_name" onkeypress="return /[a-z ]/i.test(event.key)">
            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
        </div>
    </div><br>
    <div class="row">
        <div class="form-group">
            <input autocomplete='off' class='form-control' size='20' type='text' placeholder='Card Number' name="card_number" id="card_number" minlength="16" maxlength="16"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
        </div><br>
<!--        <div class="form-group">
            <span><b>Save card for next time</b></span>
            <input type="checkbox" id="card_switch" />
            <label for="card_switch">Toggle</label>
            <small class='card_status hide'></small>
        </div>-->
    </div>
    
<!--    <div class="row ">
        <div class="form-group required">
            <input type="text" placeholder="Card Holders Name" value="" required name="card_holder_name" onkeypress="return /[a-z]/i.test(event.key)">
        </div>
    </div>-->

<!--    <div class="form-row">
        <div class="form-col full-field">
            <input autocomplete='off' class='form-control card-number' size='20' type='text' placeholder='Card Number' name="card_number" id="card_number" minlength="16" maxlength="16"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
        </div>
        <div>
            <span><b>Save card for next time</b></span>
            <input type="checkbox" id="card_switch" />
            <label for="card_switch">Toggle</label>
            <small class='card_status hide'></small>
        </div>
    </div>-->

    <div class="form-row">
        <div class="form-col half-field">
            <input type="text" name="exp_month" class="card-expiry-month" placeholder="Expiry Month(MM)" value="" minlength="2" maxlength="2"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
            <input type="text" name="exp_year" class="card-expiry-year" placeholder="Expiry Year(YYYY)" value="" minlength="4" maxlength="4"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
        </div>
        <div class="form-col half-field">
            <input type="text" class="card-cvc" placeholder="cvv" value="" name="cvv" minlength="3" maxlength="3"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
        </div>
    </div>

    <div class='form-row'>
        <div class='col-md-12'>
            <div class='form-control total btn btn-info'>
                Total: <span class='amount'>£{{$data['price']}}</span>
            </div>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-md-12 form-group'>
            <button style="background-color: #31708e;color: #fff;text-align: center;line-height: 5px"
                class='form-control button submit-button' type='submit'>Pay »</button>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-md-12 error form-group hide'>
            <div class='alert-danger alert'>Please correct the errors and try
                again.</div>
        </div>
    </div>
    <input type="text" value="" name="save_for_future" id="future_card" hidden>
</form>
    
    </div>