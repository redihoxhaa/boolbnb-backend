@extends('layouts.admin')

@section('title', 'Sponsor Apartment')

@section('content')


    <div class="container py-3">

        <div class="text-center mb-5">Buy a sponsorhip for {{ $apartment->title }}</div>

        <form action="{{ route('admin.apartments.buySponsorship', $apartment->id) }}" method="POST">
            @csrf
            <div class="row radio-input gap-5 justify-content-center">
                @foreach ($sponsorships as $sponsorship)
                    <input value="{{ $sponsorship->id }}" name="sponsorship_choice" id="sponsorship{{ $sponsorship->id }}"
                        type="radio" required>
                    <label for="sponsorship{{ $sponsorship->id }}" class="col-3 d-flex flex-column align-items-center">
                        <span>{{ $sponsorship->package_name }}</span>
                        <span>€{{ $sponsorship->package_price }}</span>
                        <span>{{ $sponsorship->package_duration }}h</span>
                    </label>
                @endforeach
            </div>
            <div id="dropin-container"></div>
            <button id="submit-button" class="buttonPayment buttonPayment--small buttonPayment--green">Purchase</button>
        </form>
        <div class="mt-3 text-center">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm mb-4"><i
                    class="fas fa-arrow-left"></i> Go Back</a>
        </div>

        <div>
            <div>CARTA DEBUG</div>
            <div>4525 2612 7890 2412</div>
            <div>02 / 2027</div>
        </div>

    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.js"></script>

    <script>
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
            selector: '#dropin-container'
        }, function(err, instance) {
            button.addEventListener('click', function() {
                instance.requestPaymentMethod(function(err, payload) {
                    // Submit payload.nonce to your server
                });
            })
        });
    </script>
@endsection
