@extends('layouts.admin')

@section('title', 'Sponsor Apartment')

@section('content')




    {{-- <link rel="stylesheet" href="{{ asset('scss/partials/sponsorships-style.scss') }}"> --}}
    <div class="container py-4 px-3 px-lg-5 sponsorship">

        {{-- Path Page --}}
        <div class="path-page">
            <a href="{{ route('admin.dashboard') }}">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.apartments.index') }}">Apartments</a>
            <span>/</span>
            <span>Sponsorship</span>
        </div>

        <div class="mt-5 mb-5 d-flex align-items">
            <h1>Sponsorship</h1>
        </div>
        <form id="payment-form" action="{{ route('admin.apartments.buySponsorship', $apartment->id) }}" method="POST">
            @csrf
            <div class="row gap-3 flex-column flex-lg-row">
                <div class="d-flex col col-lg-4 radio-input px-4 px-sm-0 gap-3 justify-content-center flex-column">
                    <h6 class="text-black">SELECT YOUR PLAN</h6>
                    @foreach ($sponsorships as $sponsorship)
                        <input value="{{ $sponsorship->id }}" name="sponsorship_choice"
                            id="sponsorship{{ $sponsorship->id }}" type="radio" class="sponsorship-radio"
                            data-package-price="{{ $sponsorship->package_price }}"
                            @if ($preference === $sponsorship->package_name) checked @endif required>
                        <label for="sponsorship{{ $sponsorship->id }}" class="row">
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <div>
                                    @if ($sponsorship->package_name === 'Gold')
                                        <img src="{{ asset('assets/images/gold.svg') }}" class="darken" alt="Bathrooms">
                                    @elseif ($sponsorship->package_name === 'Diamond')
                                        <img src="{{ asset('assets/images/diamond.svg') }}" class="darken" alt="diamond">
                                    @else
                                        <img src="{{ asset('assets/images/emerald.svg') }}" class="darken" alt="emerald">
                                    @endif
                                </div>
                            </div>
                            <div class="col-6 py-3 d-flex flex-column justify-content-center">
                                <h4 class="mb-0">{{ $sponsorship->package_name }}</h4>
                                @if ($sponsorship->package_name === 'Gold')
                                    <span class="fw-normal">1 day</span>
                                @elseif ($sponsorship->package_name === 'Diamond')
                                    <span class="fw-normal">3 days</span>
                                @else
                                    <span class="fw-normal">6 days</span>
                                @endif

                            </div>
                            <div class="col-3 mt-auto text-end">
                                <span class="package-price align-self-end">€{{ $sponsorship->package_price }}</span>
                            </div>

                        </label>
                    @endforeach
                </div>
                <div class="col col-lg-7 ps-4 mt-2">
                    <h6 class="text-black">PAYMENT</h6>
                    <div class="d-flex mt-3 mb-4 lg-gap-2">
                        <div class="me-4">

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
                        <div class="">
                            <h6 class="selected-plan"></h6>
                            <h4>{{ $apartment->title }}</h4>
                            <div class="d-flex">
                                <span class="start-date">Increase your booking chances!</span>

                            </div>
                        </div>
                    </div>

                    <div id="dropin-container" style="display:none;"></div>
                </div>

            </div>
            <div class="row">
                <div class="mt-5">
                    <div class="">
                        <div class="text-end total d-none">Total (VAT Included):</div>
                        <h2 class="price text-end"></h2>
                        {{-- <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm mb-4 "><i
                        class="fas fa-arrow-left"></i> Go Back</a> --}}
                    </div>
                </div>
                <div class="mt-4">
                    <div class="d-flex flex-row-reverse gap-4">
                        <button id="submit-button" class="buttonPayment buttonPayment--small buttonPayment--green"
                            style="display:none;">Pay Now</button>
                        <button class="buttonPayment buttonPayment--small bg-white"><a
                                href="{{ route('admin.apartments.index') }}">Back</a></button>
                    </div>
                </div>
            </div>
        </form>


        {{-- <div>
            <div>CART DEBUG</div>
            <div>4525 2612 7890 2412</div>
            <div>02 / 2027</div>
        </div> --}}

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

        // Impostazione totale da pagare
        document.addEventListener("DOMContentLoaded", function() {
            const radioButtons = document.querySelectorAll('.sponsorship-radio');
            const priceDiv = document.querySelector('.price');
            const totalDiv = document.querySelector('.total');

            radioButtons.forEach(function(radioButton) {
                radioButton.addEventListener('change', function() {
                    if (this.checked) {
                        const packagePrice = this.getAttribute('data-package-price');
                        priceDiv.textContent = "€" + packagePrice;
                        totalDiv.classList.remove("d-none");
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const dropinContainer = document.querySelector('#dropin-container');
            const button = document.querySelector('#submit-button');
            const checkedRadioButton = document.querySelector('.sponsorship-radio:checked');
            const startDateDiv = document.querySelector('.start-date');

            if (checkedRadioButton) {
                dropinContainer.style.display = 'block';
                button.style.display = 'block';

                const packagePrice = parseFloat(checkedRadioButton.getAttribute('data-package-price'));
                let startDateText = '';

                if (packagePrice === 2.99) {
                    startDateText = '1 day of boost will be added to your listing!';
                } else if (packagePrice === 5.99) {
                    startDateText = '3 days of boost will be added to your listing!';
                } else if (packagePrice === 9.99) {
                    startDateText = '6 days of boost will be added to your listing!';
                }

                startDateDiv.textContent = startDateText;
            } else {
                dropinContainer.style.display = 'none';
                button.style.display = 'none';
                startDateDiv.textContent = ''; // Pulisce il testo se nessun radio button è selezionato
            }
        });

        // Impostazione delle info pacchetto
        document.addEventListener("DOMContentLoaded", function() {
            const radioButtons = document.querySelectorAll('.sponsorship-radio');
            const startDateDiv = document.querySelector('.start-date');

            radioButtons.forEach(function(radioButton) {
                radioButton.addEventListener('change', function() {
                    if (this.checked) {
                        const packagePrice = parseFloat(this.getAttribute('data-package-price'));
                        let startDateText = '';

                        if (packagePrice ===
                            2.99) {
                            startDateText = '1 day of boost will be added to your listing!';
                        } else if (packagePrice ===
                            5.99) {
                            startDateText = '3 days of boost will be added to your listing!';
                        } else if (packagePrice ===
                            9.99) {
                            startDateText = '6 days of boost will be added to your listing!';
                        }

                        startDateDiv.textContent = startDateText;
                    }
                });
            });
        });
    </script>
@endsection
