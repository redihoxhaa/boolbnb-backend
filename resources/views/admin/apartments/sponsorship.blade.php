@extends('layouts.admin')

@section('title', 'Sponsor Apartment')

@section('content')


    <div class="container py-3">

        <div class="text-center mb-5">Buy a sponsorship for {{ $apartment->title }}</div>

        <form id="payment-form" action="{{ route('admin.apartments.buySponsorship', $apartment->id) }}" method="POST">
            @csrf
            <div class="row radio-input gap-5 justify-content-center">
                @foreach ($sponsorships as $sponsorship)
                    <input value="{{ $sponsorship->id }}" name="sponsorship_choice" id="sponsorship{{ $sponsorship->id }}"
                        type="radio" class="sponsorship-radio" required>
                    <label for="sponsorship{{ $sponsorship->id }}" class="col-3 d-flex flex-column align-items-center">
                        <span>{{ $sponsorship->package_name }}</span>
                        <span>€{{ $sponsorship->package_price }}</span>
                        <span>{{ $sponsorship->package_duration }}h</span>
                    </label>
                @endforeach
            </div>
            <div id="dropin-container" style="display:none;"></div>
            <button id="submit-button" class="buttonPayment buttonPayment--small buttonPayment--green"
                style="display:none;">Purchase</button>
        </form>
        <div class="mt-3 text-center">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm mb-4"><i
                    class="fas fa-arrow-left"></i> Go Back</a>
        </div>

        <div>
            <div>CART DEBUG</div>
            <div>4525 2612 7890 2412</div>
            <div>02 / 2027</div>
        </div>

    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.js"></script>

    <script>
        const button = document.querySelector('#submit-button');
        const dropinContainer = document.querySelector('#dropin-container');
        const paymentForm = document.querySelector('#payment-form');

        const radioButtons = document.querySelectorAll('.sponsorship-radio');

        radioButtons.forEach(function(radioButton) {
            radioButton.addEventListener('change', function() {
                if (this.checked) {
                    dropinContainer.style.display = 'block';
                    button.style.display = 'block';
                } else {
                    dropinContainer.style.display = 'none';
                    button.style.display = 'none';
                }
            });
        });

        braintree.dropin.create({
            authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
            selector: '#dropin-container'
        }, function(err, instance) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent form submission
                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    // Submit payload.nonce to your server
                    // Here you can add your validation logic before submitting the form
                    setTimeout(function() {
                        paymentForm.submit(); // Submit the form after 2 seconds delay
                    }, 1500); // Delay in milliseconds (2000 milliseconds = 2 seconds)
                });
            });
        });
    </script>
@endsection
