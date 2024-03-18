@extends('layouts.admin')

@section('title', 'My Messages')

@section('content')
    <div class="messages-mobile d-xl-none">
        <div class="py-4 px-4">
            <div class="path-page">
                <a href="{{ route('admin.dashboard') }}">Admin</a>
                <span>/</span>
                <a href="{{ route('admin.apartments.index') }}">Apartments</a>
                <span>/</span>
                <span>Messages</span>
            </div>
            <h1 class="page-title-mobile">Messages</h1>
        </div>

        <div class="row d-none" id="messages-column-mobile">
            <div class="col-md-12">
                <button id="back-button-apartments-mobile" id="back-button-apartments-mobile"
                    class="btn custom-button mb-3 ms-4">Back to Apartments</button>
                <div class="list-group" id="messages-list-mobile">
                    <!-- Messages will be loaded here -->
                </div>
            </div>
        </div>

        <div class="row d-none" id="message-details-column-mobile">
            <div class="col-md-12">
                <button id="back-button-messages-mobile" class="btn custom-button mb-3 ms-4">Back to Messages</button>
                <div class="message-body-mobile p-4">
                    <div class="user-mobile d-flex gap-2">
                        <div>
                            <img src="{{ asset('assets/images/message_user_icon.svg') }}" alt="">
                        </div>
                        <div class="message-user-info-mobile">
                            <div>
                                <h5 class="apartment-message-name-mobile" id="message-name-mobile">Nome</h5>
                                <span class="apartment-message-email-mobile" id="message-email-mobile">Email</span>
                                <div class="apartment-message-date-mobile" id="message-date-mobile">Data</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="card-custom-container apartment-message-text-mobile" id="message-text-mobile"></p>
                    </div>
                    <div>
                        <a class="btn custom-button" href="mailto:robertomalone@gmail.com">Reply</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="list-group">
                    @foreach ($apartments as $apartment)
                        <a href="#" class="p-4 apartment-title-mobile border-bottom-custom d-flex gap-3 w-100"
                            data-id="{{ $apartment->id }}">
                            <div class="d-none d-xl-block">
                                @if ($apartment->images)
                                    <img class="apartment-img-mobile"
                                        src="{{ asset('storage/' . explode(',', $apartment->images)[0]) }}"
                                        alt="apartment-image">
                                @else
                                    <img class="apartment-img-mobile"
                                        src="https://saterdesign.com/cdn/shop/products/property-placeholder_a9ec7710-1f1e-4654-9893-28c34e3b6399_600x.jpg?v=1500393334"
                                        alt="apartment-image">
                                @endif
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h5 class="apartment-message-title-mobile">{{ $apartment->title }}</h5>
                                <span class="apartment-message-description-mobile">{{ $apartment->address }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>


    <div class="messages d-none d-xl-block">

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
            <div class="col-md-4 ps-4">
                {{-- Title Section --}}
                <h2 class="text-left custom-title-section">Apartments</h2>
                <span class="custom-description-section">Select an apartment</span>
            </div>
            <div class="col-md-4 ps-4">
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
            <div class="col-md-4 pe-0 border-right-custom">

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
            <div class="col-md-4 p-0 border-right-custom">

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
        document.addEventListener("DOMContentLoaded", function() {
            const apartmentTitlesMobile = document.querySelectorAll(".apartment-title-mobile");
            const messagesColumnMobile = document.getElementById("messages-column-mobile");
            const messageDetailsColumnMobile = document.getElementById("message-details-column-mobile");
            const messagesListMobile = document.getElementById("messages-list-mobile");

            // Gestisci il clic sugli appartamenti
            apartmentTitlesMobile.forEach(function(apartmentTitleMobile) {
                apartmentTitleMobile.addEventListener("click", function(event) {
                    event.preventDefault();
                    const apartmentIdMobile = this.dataset.id;

                    // Nascondi la colonna degli appartamenti e mostra quella dei messaggi
                    messagesColumnMobile.classList.remove("d-none");
                    apartmentTitlesMobile.forEach(function(apartmentMobile) {
                        apartmentMobile.classList.add("d-none");
                    });

                    // Carica i messaggi relativi all'appartamento cliccato
                    axios.get(`http://127.0.0.1:8000/admin/messages/${apartmentIdMobile}`)
                        .then(response => {
                            messagesListMobile.innerHTML = '';
                            response.data.forEach(message => {
                                const messageDivMobile = document.createElement('div');

                                messageDivMobile.innerHTML = `
                            <a href="#" class="message-mobile border-bottom-custom p-4" data-message-id="${message.id}"
                                data-name="${message.sender_name}" data-email="${message.sender_email}"
                                data-date="${message.created_at}" data-text="${message.message_text}">
                                <div class="d-flex gap-3">
                                    <div> 
                                        <img class="icon-message-mobile" src="{{ asset('assets/images/mail_icon.svg') }}">
                                    </div>
                                    <div>
                                        <h5>${message.sender_name}</h5>
                                        <h6>${message.sender_email}</h6>
                                    </div>
                                </div>
                            </a>`;
                                messagesListMobile.appendChild(messageDivMobile);
                            });
                        })
                        .catch(error => console.error('Error fetching messages:', error));
                });
            });

            // Gestisci il clic sui messaggi
            messagesListMobile.addEventListener("click", function(event) {
                event.preventDefault();
                backButtonApartmentsMobile.classList.add('d-none');
                const messageMobile = event.target.closest(".message-mobile");
                if (messageMobile) {
                    // Nascondi la colonna dei messaggi e mostra quella dei dettagli del messaggio
                    messageDetailsColumnMobile.classList.remove("d-none");
                    messagesListMobile.classList.add("d-none");

                    // Aggiorna i dettagli del messaggio con i dati dal div cliccato

                    const luxonDateMobile = luxon.DateTime.fromISO(messageMobile.dataset.date, {
                        zone: "utc"
                    });
                    const formattedDateMobile = luxonDateMobile.toFormat(
                        "yyyy-MM-dd HH:mm");

                    const messageDateElementMobile = document.getElementById("message-date-mobile");
                    messageDateElementMobile.textContent = 'Received on: ' + formattedDateMobile;

                    const messageNameElementMobile = document.getElementById("message-name-mobile");
                    messageNameElementMobile.textContent = messageMobile.dataset.name;

                    const messageEmailElementMobile = document.getElementById("message-email-mobile");
                    messageEmailElementMobile.textContent = messageMobile.dataset.email;

                    const messageTextElementMobile = document.getElementById("message-text-mobile");
                    messageTextElementMobile.textContent = messageMobile.dataset.text;
                }
            });


            // Gestisci il clic sul pulsante back nella colonna degli appartamenti
            const backButtonApartmentsMobile = document.getElementById("back-button-apartments-mobile");
            if (backButtonApartmentsMobile) {
                backButtonApartmentsMobile.addEventListener("click", function(event) {
                    event.preventDefault();
                    backButtonMessagesMobile.classList.remove('d-none');
                    // Nascondi la colonna dei messaggi e mostra quella degli appartamenti
                    messagesColumnMobile.classList.add("d-none");
                    apartmentTitlesMobile.forEach(function(apartmentMobile) {
                        apartmentMobile.classList.remove("d-none");
                    });
                });
            }



            // Gestisci il clic sul pulsante back nella colonna dei messaggi
            const backButtonMessagesMobile = document.getElementById("back-button-messages-mobile");
            if (backButtonMessagesMobile) {
                backButtonMessagesMobile.addEventListener("click", function(event) {
                    event.preventDefault();
                    backButtonApartmentsMobile.classList.remove('d-none');
                    // Nascondi la colonna dei dettagli del messaggio e mostra quella dei messaggi
                    messageDetailsColumnMobile.classList.add("d-none");
                    messagesListMobile.classList.remove("d-none");
                });
            }




        });
    </script>

    <script>
        // PARTE DESKTOP
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
                                            <span class="sender-email">${message.sender_email}</span>
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
