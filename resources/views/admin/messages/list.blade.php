@extends('layouts.admin')

@section('title', 'My Messages')

@section('content')

    <div class="container py-4">
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-center mb-4">Apartments</h2>
                <div class="list-group">
                    @foreach ($apartments as $apartment)
                        <a href="#" class="p-4 card mb-3 apartment-title" data-id="{{ $apartment->id }}">
                            <h5 class="mb-1">{{ $apartment->title }}</h5>
                            <span class="mb-1 fw-normal">{{ $apartment->address }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="text-center mb-4">Messages List</h2>
                <div class="apartment-guide text-center">Select an apartment</div>
                <div id="messages-list">
                    <!-- Messages will be loaded here -->
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="text-center mb-4">Message Details</h2>
                <div class="message-guide text-center d-none">Select a message</div>
                <div class="card message-body d-none">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Message Body</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text" id="message-text"></p>
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
                <div class="message card mb-3 ${response.data.length === 1 && index === 0 ? 'active' : ''}" data-message-id="${message.id}">
                    <div class="card-body">
                        <h5 class="card-title">${message.sender_name}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">${message.sender_email}</h6>
                        <input type="hidden" class="message-text" value="${message.message_text}">
                    </div>
                </div>
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
