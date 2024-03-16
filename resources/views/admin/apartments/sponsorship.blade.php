@extends('layouts.admin')

@section('title', 'Sponsor Apartment')

@section('content')




    {{-- <link rel="stylesheet" href="{{ asset('scss/partials/sponsorships-style.scss') }}"> --}}
    <div class="container py-4 sponsorship">
        <div>
            <span class="text-secondary">Admin</span>
            <span class="text-secondary">/</span>
            <span class="text-secondary">Apartments</span>
            <span class="text-secondary">/</span>
            <span>Sponsorships</span>
        </div>
        <div class="mt-5 mb-5 d-flex align-items">
            <h1>Sponsorship</h1>
        </div>
        <form id="payment-form" action="{{ route('admin.apartments.buySponsorship', $apartment->id) }}" method="POST">
            @csrf
            <div class="row gap-3 flex-column flex-lg-row ">
                <div class="d-flex col col-lg-4 radio-input gap-3 justify-content-center flex-column">
                    <h6 class="text-black">SELECT YOUR PLAN</h6>
                @foreach ($sponsorships as $sponsorship)
                    <input value="{{ $sponsorship->id }}" name="sponsorship_choice" id="sponsorship{{ $sponsorship->id }}"
                        type="radio" class="sponsorship-radio" required>
                    <label for="sponsorship{{ $sponsorship->id }}" class="row ">
                        <div class="col-3">
                            <span>icona</span>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <span>{{ $sponsorship->package_name }}</span>
                            <span>{{ $sponsorship->package_duration }}h</span>
                            <span class="align-self-end">€{{ $sponsorship->package_price }}</span>
                        </div>
                    </label>
                @endforeach
                </div>
                <div class="col col-lg-7 ps-4 mt-2">
                    <h6 class="text-black">PAYMENT</h6>
                    <div class="row mt-3 lg-gap-2">
                        <div class="col-3">
                            <div>
                                @if ($apartment->images)
                                    <img class="apartment-img-sponsorships"
                                        src="{{ asset('storage/' . explode(',', $apartment->images)[0]) }}"
                                        alt="apartment-image">
                                @else
                                    <img class="apartment-img-sponsorships"
                                        src="https://saterdesign.com/cdn/shop/products/property-placeholder_a9ec7710-1f1e-4654-9893-28c34e3b6399_600x.jpg?v=1500393334"
                                        alt="apartment-image">
                                @endif
                            </div>
                        </div>
                        <div class="col-9">
                            <h6>{{ $sponsorship->package_name }}</h6>
                            <h4>{{ $apartment->title }}</h4>
                        </div>
                    </div>
                    <div id="dropin-container" style="display:none;"></div>
                    
                </div>
            </div>
            <div class="row"> 
                <div class="mt-5">
                    <div class="d-flex flex-row-reverse">
                        <h2 class="strong">€{{ $sponsorship->package_price }}</h2>
                        <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm mb-4 "><i
                        class="fas fa-arrow-left"></i> Go Back</a>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="d-flex flex-row-reverse">
                        <button id="submit-button" class="buttonPayment buttonPayment--small buttonPayment--green"
                        style="display:none;">Pay Now</button>
                    </div>
                </div>
            </div>
        </form>
        

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
