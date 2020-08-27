<!DOCTYPE html>

<html>

<head>

	<title>Laravel 5 - Stripe Payment Gateway Integration Example - ItSolutionStuff.com</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style type="text/css">

        .panel-title {

        display: inline;

        font-weight: bold;

        }

        .display-table {

            display: table;

        }

        .display-tr {

            display: table-row;

        }

        .display-td {

            display: table-cell;

            vertical-align: middle;

            width: 61%;

        }

    </style>

</head>

<body>



<div class="container">



    <h1>Laravel 5 - Stripe Payment Gateway Integration Example <br/> ItSolutionStuff.com</h1>
    <h2 class = "text-center">Order Id: {{ session('order_id_from_checkout_page') }}</h2>



    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            <div class="panel panel-default credit-card-box">

                <div class="panel-heading display-table" >

                    <div class="row display-tr" >

                        <h3 class="panel-title display-td" >Payment Details</h3>

                        <div class="display-td" >

                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">

                        </div>

                    </div>

                </div>

                <div class="panel-body">



                    @if (Session::has('success'))

                        <div class="alert alert-success text-center">

                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                            <p>{{ Session::get('success') }}</p>

                        </div>

                    @endif
{{-- class="require-validation" --}}


                    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"

                                                     data-cc-on-file="false"

                                                    data-stripe-publishable-key="{{ 'pk_test_51H9EP2BNMg4E7zr1rbT2mwi7L6M9d4uKC4ufJjBg57Rm867xass3IdLcFm79fFtIAFgQQX6WxRmDBm14w5KlzlNW00Mt2CyPQv' }}"

                                                    id="payment-form">

                        @csrf



                        <div class='form-row row'>

                            <div class='col-xs-12 form-group required'>

                                <label class='control-label'>Name on Card</label> <input

                                    class='form-control' id = "card-name" size='4' type='text'>

                            </div>

                        </div>



                        <div class='form-row row'>

                            <div class='col-xs-12 form-group card required'>

                                <label class='control-label'>Card Number</label> <input

                                    autocomplete='off' class='form-control' id = "card-number" size='20'

                                    type='text'>

                            </div>

                        </div>



                        <div class='form-row row'>

                            <div class='col-xs-12 col-md-4 form-group cvc required'>

                                <label class='control-label'>CVC</label> <input autocomplete='off'

                                    class='form-control' id = "card-cvc" placeholder='ex. 311' size='4'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Month</label> <input

                                    class='form-control' id = "card-expiry-month" placeholder='MM' size='2'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Year</label> <input

                                    class='form-control' id = "card-expiry-year" placeholder='YYYY' size='4'

                                    type='text'>

                            </div>

                        </div>



                        <div class='form-row row'>

                            <div class='col-md-12 error form-group hide'>

                                <div class='alert-danger alert'>Please correct the errors and try

                                    again.</div>

                            </div>

                        </div>



                        <div class="row">

                            <div class="col-xs-12">

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ({{ session('sub_total') - session('discount_amount') }}TK)</button>

                            </div>

                        </div>



                    </form>

                </div>

            </div>

        </div>

    </div>



</div>



</body>



<script type="text/javascript" src="https://js.stripe.com/v2/"></script>



<script type="text/javascript">

$(function() {

    var $form         = $(".require-validation");

  $('form.require-validation').bind('submit', function(e) {

    var $form         = $(".require-validation"),

        inputSelector = ['input[type=email]', 'input[type=password]',

                         'input[type=text]', 'input[type=file]',

                         'textarea'].join(', '),

        $inputs       = $form.find('.required').find(inputSelector),

        $errorMessage = $form.find('div.error'),

        valid         = false;

        $errorMessage.addClass('hide');



        $('.has-error').removeClass('has-error');

    $inputs.each(function(i, el) {

      var $input = $(el);

      if ($input.val() === '') {

        $input.parent().addClass('has-error');

        $errorMessage.removeClass('hide');

        e.preventDefault();

      }

    });



    if (!$form.data('cc-on-file')) {

      e.preventDefault();

      Stripe.setPublishableKey($form.data('stripe-publishable-key'));

      Stripe.createToken({

        number: $('#card-number').val(),

        cvc: $('#card-cvc').val(),

        exp_month: $('#card-expiry-month').val(),

        exp_year: $('#card-expiry-year').val(),

        // name: $('#card-name').val(),

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

            $form.get(0).submit();

        }

    }



});

</script>

</html>
