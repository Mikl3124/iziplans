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
                                <h1 class="mt-3">ABONNEMENTS</h1>
                                <h1>{{ env('STRIPE_KEY') }}</h1>
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
                                            <span>Mensuel</span>
                                        </div>
                                        <!--//HEAD END-->

                                    </div>
                                    <!--//HEAD CONTENT END-->

                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">
                                        <span class="price mb-2">
                                            <span class="sign">€</span>
                                            <span class="currency">24</span>
                                            <span class="cent">.90</span>
                                            <span class="month">/mois</span>
                                        </span>

                                    </div>
                                    <!--//PRICE END-->

                                </div>
                                <!--//HEAD PRICE DETAIL END-->

                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li>Idéal pour faire un essai</li>
                                        <li>Réponses illimitées aux projets</li>
                                        <li>Alerte E-mail "Nouveaux projets"</li>
                                        <li>Messagerie privée</li>
                                        <li>Sans engagement</li>

                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->

                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a href="#ModalMensuel" data-toggle="modal" data-target="#ModalMensuel">CHOISIR</a>
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
                                            <span>Trimestriel</span>
                                        </div>


                                        <!--//HEAD END-->

                                    </div>
                                    <!--//HEAD CONTENT END-->

                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">
                                        <span class="price mb-2">
                                            <span class="sign">€</span>
                                            <span class="currency">63</span>
                                            <span class="cent">.90</span>
                                            <span class="month">/trimestre</span>
                                        </span>
                                    </div>
                                    <!--//PRICE END-->

                                </div>
                                <!--//HEAD PRICE DETAIL END-->

                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li>Vous économisez 10%</li>
                                        <li>Réponses illimitées aux projets</li>
                                        <li>Alerte E-mail "Nouveaux projets"</li>
                                        <li>Messagerie privée</li>
                                        <li>Sans engagement</li>

                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->

                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a href="#ModalTrimestriel" data-toggle="modal" data-target="#ModalTrimestriel">CHOISIR</a>
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
                                            <span>Annuel</span>
                                        </div>
                                        <!--//HEAD END-->

                                    </div>
                                    <!--//HEAD CONTENT END-->

                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">
                                        <span class="price mb-2">
                                            <span class="sign">€</span>
                                            <span class="currency">249</span>
                                            <span class="cent">.00</span>
                                            <span class="month">/an</span>
                                        </span>
                                    </div>
                                    <!--//PRICE END-->

                                </div>
                                <!--//HEAD PRICE DETAIL END-->

                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li>2 Mois gratuits</li>
                                        <li>Réponses illimitées aux projets</li>
                                        <li>Alerte E-mail "Nouveaux projets"</li>
                                        <li>Messagerie privée</li>
                                        <li>Sans engagement</li>

                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->

                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a href="#ModalAnnuel" data-toggle="modal" data-target="#ModalAnnuel">CHOISIR</a>
                                </div>
                                <!--//BUTTON END-->

                            </div>
                            <!--//PRICE CONTENT END-->

                        </div>

                        </div>
                    </div>
                    <!--//BLOCK ROW END-->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <!--PRICE HEADING START-->
                                <div class="price-heading clearfix">
                                    <p class="mt-1 mb-5"><em>Vous pouvez vous désinscrire quand vous le souhaitez!</p></em>
                                </div>
                                <div class="text-center mb-5">
                                    <a href="{{ route('home')}}" class="btn btn-outline-primary">Continuer Gratuitement</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </section>
        <div>

    </div>


<!-- Modal Mensuel-->
<div class="modal fade" id="ModalMensuel" tabindex="-1" role="dialog" aria-labelledby="ModalMensuel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">MENSUEL à 24.90€ / mois</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/subscribe" method="POST" id="payment-form">
                @csrf
                <div>
                    <input type="hidden" name="plan" value="price_1HLnPWC1QIYXU5hhGMqIx1AZ">
                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element" class="form-control my-2"></div>
                        <div id="card-errors"  class="text-danger" role="alert"></div>
                    </div>
                    <div class=text-center>
                        <img class="secure-payment" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/icon-paiement.png" alt="iziplans paiement sécurisé">
                    </div>
                        <button class="mt-3 btn btn-success btn-block" id="card-button" data-secret="{{ $intent->client_secret }}">
                            S'abonner
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
  <!-- Modal Trimestriel-->
<div class="modal fade" id="ModalTrimestriel" tabindex="-1" role="dialog" aria-labelledby="ModalTrimestriel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">TRIMESTRIEL à 63.90€ / trimestre</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/subscribe" method="POST" id="payment-form-trimestre">
                @csrf
                <div>
                    <input type="hidden" name="plan" value="price_1HLnOwC1QIYXU5hh2r9IsgCS">
                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element-trimestre" class="form-control my-2"></div>
                        <div id="card-errors-trimestre"  class="text-danger" role="alert"></div>
                    </div>
                    <div class=text-center>
                        <img class="secure-payment" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/icon-paiement.png" alt="iziplans paiement sécurisé">
                    </div>
                    <button class="mt-3 btn btn-success btn-block" id="card-button-trimestre" data-secret="{{ $intent->client_secret }}">
                        S'abonner
                    </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>

    <!-- Modal Annuel-->
<div class="modal fade" id="ModalAnnuel" tabindex="-1" role="dialog" aria-labelledby="ModalAnnuel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">ANNUEL à 249.00€ / an</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/subscribe" method="POST" id="payment-form-annuel">
                @csrf
                <div>
                    <input type="hidden" name="plan" value="price_1HLnPkC1QIYXU5hhQfpujV4V">
                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element-annuel" class="form-control my-2"></div>
                        <div id="card-errors-annuel"  class="text-danger" role="alert"></div>
                        <div class='form-group cvc required'>
                    </div>
                    <div class=text-center>
                        <img class="secure-payment" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/icon-paiement.png" alt="iziplans paiement sécurisé">
                    </div>
                    <button class="mt-3 btn btn-success btn-block" id="card-button-annuel" data-secret="{{ $intent->client_secret }}">
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
    //Mensuel
    window.addEventListener('load', function(){
        const cardButton = document.getElementById('card-button');
        console.log('test');
        console.log('{{ env('STRIPE_KEY') }}');
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

<script>
    // Trimestriel
    window.addEventListener('load', function(){
        const cardButton = document.getElementById('card-button-trimestre');
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
    cardElement.mount('#card-element-trimestre');
    // Create a token or display an error when the form is submitted.
    // Handle real-time validation errors from the card Element.
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors-trimestre');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
        }
    });
    // Handle form submission.
    var form = document.getElementById('payment-form-trimestre');
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
                        var errorElement = document.getElementById('card-errors-trimestre');
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

<script>
    // Annuel
    window.addEventListener('load', function(){
        const cardButton = document.getElementById('card-button-annuel');
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
    cardElement.mount('#card-element-annuel');
    // Create a token or display an error when the form is submitted.
    // Handle real-time validation errors from the card Element.
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors-annuel');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
        }
    });
    // Handle form submission.
    var form = document.getElementById('payment-form-annuel');
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
                        var errorElement = document.getElementById('card-errors-annuel');
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




