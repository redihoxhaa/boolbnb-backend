@extends('layouts.admin')

@section('title', 'My Messages')

@section('content')
    <div class="messages">

        {{-- Title --}}
        <div class="py-4 px-5">

            {{-- Path Page --}}
            <div>
                <span>Admin</span>
                <span>/</span>
                <span>Apartments</span>
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
                <h2 class="text-left custom-title-section">Listed Messages</h2>
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
                                <h5 class="apartment-message-description">Nome</h5>
                                <span class="apartment-message-description">Email</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="card-custom-container" id="message-text"></p>
                    </div>
                    <div>
                        <a class="btn custom-button" href="mailto:vitodurso98@gmail.com">Reply</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const apartmentTitles = document.querySelectorAll(".apartment-title");
            const messagesList = document.getElementById("messages-list");
            const messageBody = document.querySelector(".message-body");
            const apartmentGuide = document.querySelector(".apartment-guide");
            const messageGuide = document.querySelector(".message-guide");

            apartmentTitles.forEach(function(apartmentTitle) {
                apartmentTitle.addEventListener("click", function() {
                    // Rimuovi la classe "active" da tutti gli appartamenti
                    apartmentTitles.forEach(function(apartment) {
                        apartment.classList.remove("active");
                    });

                    // Aggiungi la classe "active" all'appartamento cliccato
                    this.classList.add("active");

                    const apartmentId = this.dataset.id;
                    axios.get(`http://127.0.0.1:8000/admin/messages/${apartmentId}`)
                        .then(response => {
                            messagesList.innerHTML = '';
                            response.data.forEach((message, index) => {
                                const messageDiv = document.createElement('div');
                                messageDiv.innerHTML = `
                                <div class="message border-bottom-custom p-4 ${response.data.length === 1 && index === 0 ? 'active' : ''}" data-message-id="${message.id}">
                                    <div class="d-flex gap-3">
                                        <div> 
                                            <img class="icon-message" src="{{ asset('assets/images/mail_icon.svg') }}">
                                        </div>
                                    <div>
                                    <h5 class="apartment-message-title">${message.sender_name}</h5>
                                    <h6 class="apartment-message-description">${message.created_at}</h6>
                                </div>
                                <input type="hidden" class="message-text" value="${message.message_text}">
                                `;
                                messagesList.appendChild(messageDiv);

                                // Se c'è solo un messaggio e siamo nell'ultimo ciclo, mostra il corpo del messaggio
                                if (response.data.length === 1 && index === response
                                    .data.length - 1) {
                                    const messageText = messageDiv.querySelector(
                                        '.message-text').value;
                                    const messageTextElement = document.querySelector(
                                        "#message-text");
                                    messageTextElement.textContent = messageText;
                                    messageBody.classList.remove("d-none");
                                }
                            });

                            // Nascondi il corpo del messaggio se ci sono più messaggi
                            if (response.data.length > 1) {
                                messageBody.classList.add("d-none");
                            }

                            // Mostra il div dei messaggi e nascondi il div degli appartamenti
                            messageGuide.classList.remove("d-none");
                            apartmentGuide.classList.add("d-none");

                            // Nascondi la scritta "Select a message" se ci sono messaggi
                            if (response.data.length > 0) {
                                messageGuide.classList.add("d-none");
                            }
                        })
                        .catch(error => console.error('Error fetching messages:', error));
                });

                // Verifica se c'è solo un appartamento nei risultati
                if (apartmentTitles.length === 1) {
                    // Simula un click sull'unico appartamento
                    apartmentTitle.click();
                }
            });

            messagesList.addEventListener("click", function(event) {
                const messageElement = event.target.closest(".message");
                if (messageElement) {
                    const messageText = messageElement.querySelector('.message-text').value;
                    const messageTextElement = document.querySelector("#message-text");

                    messageTextElement.textContent = messageText;
                    messageBody.classList.remove("d-none");

                    // Rimuovi la classe "active" da tutti i messaggi
                    document.querySelectorAll(".message").forEach(function(msg) {
                        msg.classList.remove("active");
                    });

                    // Aggiungi la classe "active" solo al messaggio selezionato
                    messageElement.classList.add("active");

                    // Nascondi la scritta "Select a message" quando viene selezionato un messaggio
                    messageGuide.classList.add("d-none");
                }
            });
        });
    </script>

@endsection
