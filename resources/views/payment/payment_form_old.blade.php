<html lang="en">

    <head>
        <style>

            /**
            * Switch case*
            **/
            input[type=checkbox] {
                height: 0;
                width: 0;
                visibility: hidden;
            }

            label {
                cursor: pointer;
                text-indent: -9999px;
                width: 50px;
                height: 25px;
                background: grey;
                display: block;
                border-radius: 100px;
                position: relative;
            }

            label:after {
                content: "";
                position: absolute;
                top: 5px;
                left: 5px;
                width: 15px;
                height: 15px;
                background: #fff;
                border-radius: 90px;
                transition: 0.3s;
            }

            input:checked + label {
                background: #bada55;
            }

            input:checked + label:after {
                left: calc(100% - 5px);
                transform: translateX(-100%);
            }

            label:active:after {
                width: 10px;
            }

            .card_status{
                padding: 0.5em;
            }

            .cursor{
                cursor: pointer;
            }

        </style>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--<link rel="stylesheet" href="{{--asset('css/all.css')--}}">--> 
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <!--<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css"-->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="icon" href="{{asset('images/favicon.jpg')}}" type="image/jpg"> 
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        <link rel="stylesheet" href="{{asset('css/media.css')}}">
        <!-- Select2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <link rel="stylesheet" href="{{--asset('plugins/select2/css/select2.min.css')--}}">
        <link rel="stylesheet" href="{{--asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')--}}">

        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">-->
        <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/simplePagination.css')}}">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    </head>

    <body>
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
        <?php }if (Session::has('success')) { ?>
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

        <!--    <div class="learnArenaLoader"></div>-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-12"></div>
                <div class="col-md-4 col-12">
                    <div id="payment-popup" class="payment-popup stripe_pay">

                        <div class="payment-popup-detail">
                            <div class="payment-popup-left w-50Q pr-0">
                                <div id="tab-1" class="tab-content current">
                                    <div class="custom_form">
                                        <h3 class="mb-3">CARD DETAILS</h3>
                                        <!--<span class="learnArenaLoader"><img src="{{--asset('assets/images/Bounce-Bar-Preloader.gif')--}}"></span>-->
                                        <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
                                        @include('payment.pay-form')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
        </div>



        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">-->
        <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js">-->

        <!-- Separate Popper and Bootstrap JS -->
        <!-- Popper JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

        <script type="text/javascript" src="{{asset('js/owl.carousel.min.js')}}"></script>

        <!-- Scripts -->
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="{{asset('js/dropzone.js')}}"></script>
        <!-- Select2 -->
        <script src="{{--asset('plugins/select2/js/select2.full.min.js')--}}"></script>
        <!-- SweetAlert2 -->
        <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        </script>
        <script>


            $('#card_number').keyup(function () {
                clearTimeout($.data(this, 'timer'));
                var wait = setTimeout(checkCard, 500);
                $(this).data('timer', wait);

            });

            $('#card_switch').change(function () {
                if (this.checked) {
                    $('#future_card').val(1);
                } else {
                    $('.card_status').addClass('hide');
                    $('#future_card').val(0);
                }
            });
            var user_data = '';
            function checkCard() {
                var cardNumber = $('#card_number').val();
                if (cardNumber.length >= 13) {
                    $.ajax({
                        method: "POST",
                        url: "/payment/getCardStatus",
                        data: {"_token": "{{ csrf_token() }}", "card_number": cardNumber}
                    }).done(function (msg) {
                        if (msg.status == 'success') {
                            $('.card_status').html(`This card already exist! click <a onclick="fillForm()" class="cursor">here</a> to use`);
                            $('.card_status').removeClass('hide alert-success').addClass('alert-danger');
                            $('#card_switch').attr({'checked': false, disabled: true});
                            $('#future_card').val(0);
                            user_data = msg.data;

                        } else {
                            $('.card_status').text('This is a new card! Switch on to save this');
                            $('.card_status').removeClass('hide alert-danger').addClass('alert-success');
                            $('#card_switch').attr({'checked': true, disabled: false});
                            $('#future_card').val(1);
                        }

                    });
                } else {
                    $('.card_status').addClass('hide');
                    // $('#card_switch').attr({'checked':true,disabled:false});
                    $('#future_card').val(0);
                }
            }

            function fillForm() {
                console.log(user_data);
                $('input[name=card_holder_name]').val(user_data.card_holder_name);
                $('input[name=card_number]').val(user_data.card_number);
                $('input[name=exp_month]').val(user_data.exp_month);
                $('input[name=exp_year]').val(user_data.exp_year);
                $('.card_status').addClass('hide');
            }
            $(function () {
                $('form.require-validation').bind('submit', function (e) {
                    console.log('submited');
                    var $form = $(e.target).closest('form'),
                            inputSelector = ['input[type=email]', 'input[type=password]',
                                'input[type=text]', 'input[type=file]',
                                'textarea'].join(', '),
                            $inputs = $form.find('.required').find(inputSelector),
                            $errorMessage = $form.find('div.error'),
                            valid = true;
                    $errorMessage.addClass('hide');
                    $('.has-error').removeClass('has-error');
                    $inputs.each(function (i, el) {
                        var $input = $(el);
                        if ($input.val() === '') {
                            $input.parent().addClass('has-error');
                            $errorMessage.removeClass('hide');
                            e.preventDefault(); // cancel on first error
                        }
                    });
                });
            });
            $(function () {
                var $form = $("#payment-form");
                $form.on('submit', function (e) {
                    if (!$form.data('cc-on-file')) {
                        e.preventDefault();
                        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                        Stripe.createToken({
                            number: $('.card-number').val(),
                            cvc: $('.card-cvc').val(),
                            exp_month: $('.card-expiry-month').val(),
                            exp_year: $('.card-expiry-year').val()
                        }, stripeResponseHandler);
                    }
                });
                function stripeResponseHandler(status, response) {
                    if (response.error) {
                        $('.error')
                                .removeClass('hide')
                                .find('.alert')
                                .text(response.error.message);
                    } else {
                        // token contains id, last4, and card type
                        var token = response['id'];
                        // insert the token into the form so it gets submitted to the server
                        $form.find('input[type=text]').empty();
                        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                        $(".submit-button").prop('disabled', true);
//                                  $(".learnArenaLoader").fadeIn();
                        $('body').after('<div class="loader"></div>');
                        $form.get(0).submit();
                    }
                }
            })
        </script>
        <script type="text/javascript">
            setTimeout(function () {
                $('.success-message').fadeOut('fast');
            }, 2000);
        </script>
        <script type="text/javascript">
            function preventBack() {
                window.history.forward();
            }
            setTimeout("preventBack()", 0);
            window.onunload = function () {
                null
            };
        </script>
    </body>

</html>