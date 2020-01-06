@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="/subscribe" method="POST" id="payment-form">
                @csrf
                <div>
                    <div class="card-header">Abonnement</div>
                    
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




