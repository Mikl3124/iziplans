@extends('layouts.app')

@section('content')
<div class="container">
    <div id="generic_price_table">
        <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <!--PRICE HEADING START-->
                            <div class="price-heading clearfix">
                                <h1>Bootstrap Pricing Table</h1>
                            </div>
                            <!--//PRICE HEADING END-->
                        </div>
                    </div>
                </div>
                <div class="container">

                    <!--BLOCK ROW START-->
                    <div class="row">
                        <div class="col-md-4">

                            <!--PRICE CONTENT START-->
                            <div class="generic_content clearfix">

                                <!--HEAD PRICE DETAIL START-->
                                <div class="generic_head_price clearfix">

                                    <!--HEAD CONTENT START-->
                                    <div class="generic_head_content clearfix">

                                        <!--HEAD START-->
                                        <div class="head_bg"></div>
                                        <div class="head">
                                            <span>Basic</span>
                                        </div>
                                        <!--//HEAD END-->

                                    </div>
                                    <!--//HEAD CONTENT END-->

                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">
                                        <span class="price">
                                            <span class="sign">€</span>
                                            <span class="currency">17</span>
                                            <span class="cent">.90</span>
                                            <span class="month">/Mois</span>
                                        </span>
                                    </div>
                                    <!--//PRICE END-->

                                </div>
                                <!--//HEAD PRICE DETAIL END-->

                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li><span>2GB</span> Bandwidth</li>
                                        <li><span>150GB</span> Storage</li>
                                        <li><span>12</span> Accounts</li>
                                        <li><span>7</span> Host Domain</li>
                                        <li><span>24/7</span> Support</li>
                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->

                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a href="#exampleModalCenter" data-toggle="modal" data-target="#exampleModalCenter">CHOISIR</a>
                                </div>
                                <!--//BUTTON END-->

                            </div>
                            <!--//PRICE CONTENT END-->

                        </div>

                        <div class="col-md-4">

                            <!--PRICE CONTENT START-->
                            <div class="generic_content active clearfix">

                                <!--HEAD PRICE DETAIL START-->
                                <div class="generic_head_price clearfix">

                                    <!--HEAD CONTENT START-->
                                    <div class="generic_head_content clearfix">

                                        <!--HEAD START-->
                                        <div class="head_bg"></div>
                                        <div class="head">
                                            <span>Standard</span>
                                        </div>
                                        <!--//HEAD END-->

                                    </div>
                                    <!--//HEAD CONTENT END-->

                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">
                                        <span class="price">
                                            <span class="sign">$</span>
                                            <span class="currency">199</span>
                                            <span class="cent">.99</span>
                                            <span class="month">/MON</span>
                                        </span>
                                    </div>
                                    <!--//PRICE END-->

                                </div>
                                <!--//HEAD PRICE DETAIL END-->

                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li><span>2GB</span> Bandwidth</li>
                                        <li><span>150GB</span> Storage</li>
                                        <li><span>12</span> Accounts</li>
                                        <li><span>7</span> Host Domain</li>
                                        <li><span>24/7</span> Support</li>
                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->

                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a class="" href="">Sign up</a>
                                </div>
                                <!--//BUTTON END-->

                            </div>
                            <!--//PRICE CONTENT END-->

                        </div>
                        <div class="col-md-4">

                            <!--PRICE CONTENT START-->
                            <div class="generic_content clearfix">

                                <!--HEAD PRICE DETAIL START-->
                                <div class="generic_head_price clearfix">

                                    <!--HEAD CONTENT START-->
                                    <div class="generic_head_content clearfix">

                                        <!--HEAD START-->
                                        <div class="head_bg"></div>
                                        <div class="head">
                                            <span>Unlimited</span>
                                        </div>
                                        <!--//HEAD END-->

                                    </div>
                                    <!--//HEAD CONTENT END-->

                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">
                                        <span class="price">
                                            <span class="sign">$</span>
                                            <span class="currency">299</span>
                                            <span class="cent">.99</span>
                                            <span class="month">/MON</span>
                                        </span>
                                    </div>
                                    <!--//PRICE END-->

                                </div>
                                <!--//HEAD PRICE DETAIL END-->

                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li><span>2GB</span> Bandwidth</li>
                                        <li><span>150GB</span> Storage</li>
                                        <li><span>12</span> Accounts</li>
                                        <li><span>7</span> Host Domain</li>
                                        <li><span>24/7</span> Support</li>
                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->

                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a class="" href="">Sign up</a>
                                </div>
                                <!--//BUTTON END-->

                            </div>
                            <!--//PRICE CONTENT END-->

                        </div>
                    </div>
                    <!--//BLOCK ROW END-->

                </div>
            </section>
        	<div>

    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/subscribe" method="POST" id="payment-form">
                @csrf
                <div>
                        <select name="plan" class="form-control my-2" id="subscription-plan">
                                <option value="iziplans_monthly">Mois 17€90</option>
                                <option value="iziplans_trimester">Trimestre 49€90</option>
                                <option value="iziplans_yearly">Année 179€90</option>
                        </select>

                        <input placeholder="Nom du titulaire de la carte" class="form-control mb-2" id="card-holder-name" type="text">

                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element" class="form-control my-2"></div>
                        <div id="card-errors"  class="" role="alert"></div>
                    </div>

                    <button class="mt-2 btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">
                        S'abonner
                    </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
{{-- ----------------------- Card ------------------------------ --}}



<script src="https://js.stripe.com/v3/"></script>


  <script>
    window.addEventListener('load', function(){
        const cardButton = document.getElementById('card-button');
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
            const elements = stripe.elements();
            const clientSecret = cardButton.dataset.secret;
        const cardElement = elements.create('card',{
                hidePostalCode: true,
            style: {
                base: {
            },
        }
    });
    cardElement.mount('#card-element');
    // Create a token or display an error when the form is submitted.
    // Handle real-time validation errors from the card Element.
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
        }
    });
    // Handle form submission.
    var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
                event.preventDefault();
            stripe
                .handleCardSetup(clientSecret, cardElement, {
                payment_method_data: {
                //billing_details: { name: cardHolderName.value }
            }
            })
                .then(function(result) {
                console.log(result);
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
                    } else {
                console.log(result);
            // Send the token to your server.
            stripeTokenHandler(result.setupIntent.payment_method);
        }
    });
    })
    // Submit the form with the token ID.
        function stripeTokenHandler(paymentMethod) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'paymentMethod');
            hiddenInput.setAttribute('value', paymentMethod);
            form.appendChild(hiddenInput);
    // Submit the form
    form.submit();
    }
    });
</script>

@endsection




