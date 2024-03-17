@extends('layouts.admin')

@section('title', 'My Messages')

@section('content')

    @php
        // Importa Carbon
        use Carbon\Carbon;
    @endphp
    <div class="messages">

        {{-- Title --}}
        <div class="py-4 px-4">

            {{-- Path Page --}}
            <div class="path-page">
                <a href="{{ route('admin.dashboard') }}">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.apartments.index') }}">Apartments</a>
                <span>/</span>
                <span>Messages</span>
            </div>

            {{-- Title Page --}}
            <h1 class="page-title">Messages</h1>

        </div>

        {{-- Messages Header --}}
        <div class="d-flex border-bottom-custom pb-4">
            <div class="col-md-5 ps-4">
                {{-- Title Section --}}
                <h2 class="text-left custom-title-section">Apartments</h2>
                <span class="custom-description-section">Select an apartment</span>
            </div>
            <div class="col-md-3 ps-4">
                {{-- Title Section --}}
                <h2 class="text-left custom-title-section">Messages</h2>
                <span class="custom-description-section">Select a message</span>
            </div>
            <div class="col-md-4 ps-4">
                {{-- Title Section --}}
                <h2 class="text-left custom-title-section">Body Message</h2>
            </div>
        </div>

        {{-- Content --}}
        <div class="row">

            {{-- Apartment --}}
            <div class="col-md-5 pe-0 border-right-custom">

                {{-- Apartment List --}}
                <div class="list-group">

                    {{-- Apartment Element --}}
                    @foreach ($apartments as $apartment)
                        <a href="#" class="p-4 apartment-title border-bottom-custom d-flex gap-3 w-100"
                            data-id="{{ $apartment->id }}">
                            <div class="d-none d-xl-block">
                                @if ($apartment->images)
                                    <img class="apartment-img"
                                        src="{{ asset('storage/' . explode(',', $apartment->images)[0]) }}"
                                        alt="apartment-image">
                                @else
                                    <img class="apartment-img"
                                        src="https://saterdesign.com/cdn/shop/products/property-placeholder_a9ec7710-1f1e-4654-9893-28c34e3b6399_600x.jpg?v=1500393334"
                                        alt="apartment-image">
                                @endif
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h5 class="apartment-message-title">{{ $apartment->title }}</h5>
                                <span class="apartment-message-description">{{ $apartment->address }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>

            {{-- Messages List --}}
            <div class="col-md-3 p-0 border-right-custom">

                <div id="messages-list">
                    <!-- Messages will be loaded here -->
                </div>

            </div>

            {{-- Messages --}}
            <div class="col-md-4 p-4">
                <div class="message-body d-none">
                    <div class="user d-flex gap-2">
                        <div>
                            <img src="{{ asset('assets/images/message_user_icon.svg') }}" alt="">
                        </div>
                        <div class="message-user-info">
                            {{-- Informazioni da javascript --}}
                            <div>
                                <h5 class="apartment-message-name" id="message-name">Nome</h5>
                                <span class="apartment-message-email" id="message-email">Email</span>
                                <div class="apartment-message-date" id="message-date">Data</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="card-custom-container apartment-message-text" id="message-text"></p>
                    </div>
                    <div>
                        <a class="btn custom-button" href="mailto:robertomalone@gmail.com">Reply</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/3.4.4/luxon.min.js"
        integrity="sha512-dUlSLLkxslGILhPdCkALwk4szPhp3xmZIKFtlUD+O9Lslq41Aksmdt5OGqpomDoT4FsCUH70jQU8ezZHI3v1RQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function updateMessageDetails(message) {
            const messageDate = message.querySelector('.apartment-message-date').value;
            const messageDateElement = document.querySelector("#message-date");
            messageDateElement.textContent = 'received on: ' + messageDate;

            const messageName = message.querySelector('.apartment-message-name').value;
            const messageNameElement = document.querySelector("#message-name");
            messageNameElement.textContent = messageName;

            const messageText = message.querySelector('.apartment-message-text').value;
            const messageTextElement = document.querySelector("#message-text");
            messageTextElement.textContent = messageText;

            const messageEmail = message.querySelector('.apartment-message-email').value;
            const messageEmailElement = document.querySelector("#message-email");
            messageEmailElement.textContent = messageEmail;
        }

        document.addEventListener("DOMContentLoaded", function() {
            const apartmentTitles = document.querySelectorAll(".apartment-title");
            const messagesList = document.getElementById("messages-list");
            const messageBody = document.querySelector(".message-body");
            const apartmentGuide = document.querySelector(".apartment-guide");
            const messageGuide = document.querySelector(".message-guide");

            apartmentTitles.forEach(function(apartmentTitle) {
                apartmentTitle.addEventListener("click", function() {
                    apartmentTitles.forEach(function(apartment) {
                        apartment.classList.remove("active");
                    });
                    this.classList.add("active");

                    const apartmentId = this.dataset.id;
                    axios.get(`http://127.0.0.1:8000/admin/messages/${apartmentId}`)
                        .then(response => {
                            messagesList.innerHTML = '';
                            response.data.forEach((message, index) => {
                                const messageDiv = document.createElement('div');

                                const inputDate = message.created_at;
                                const luxonDate = luxon.DateTime.fromISO(inputDate, {
                                    zone: "utc"
                                });
                                const formattedDate = luxonDate.toFormat(
                                    "yyyy-MM-dd HH:mm");

                                messageDiv.innerHTML = `
                                <div class="message border-bottom-custom p-4 ${response.data.length === 1 && index === 0 ? 'active' : ''}" data-message-id="${message.id}">
                                    <div class="d-flex gap-3">
                                        <div> 
                                            <img class="icon-message" src="{{ asset('assets/images/mail_icon.svg') }}">
                                        </div>
                                        <div>
                                            <h5>${message.sender_name}</h5>
                                            <h6>${message.sender_email}</h6>
                                        </div>
                                    </div>
                                    <input type="hidden" class="apartment-message-name" value="${message.sender_name}">
                                    <input type="hidden" class="apartment-message-email" value="${message.sender_email}">
                                    <input type="hidden" class="apartment-message-date" value="${formattedDate}">
                                    <input type="hidden" class="apartment-message-text" value="${message.message_text}">
                                </div>`;
                                messagesList.appendChild(messageDiv);

                                if (response.data.length === 1 && index === response
                                    .data.length - 1) {
                                    updateMessageDetails(messageDiv);
                                    messageBody.classList.remove("d-none");
                                }
                            });

                            if (response.data.length > 1) {
                                messageBody.classList.add("d-none");
                            }

                            messageGuide.classList.remove("d-none");
                            apartmentGuide.classList.add("d-none");

                            if (response.data.length > 0) {
                                messageGuide.classList.add("d-none");
                            }
                        })
                        .catch(error => console.error('Error fetching messages:', error));
                });

                if (apartmentTitles.length === 1) {
                    apartmentTitle.click();
                }
            });

            messagesList.addEventListener("click", function(event) {
                const messageElement = event.target.closest(".message");
                if (messageElement) {
                    updateMessageDetails(messageElement);
                    messageBody.classList.remove("d-none");

                    document.querySelectorAll(".message").forEach(function(msg) {
                        msg.classList.remove("active");
                    });

                    messageElement.classList.add("active");
                    messageGuide.classList.add("d-none");
                }
            });
        });
    </script>


@endsection
