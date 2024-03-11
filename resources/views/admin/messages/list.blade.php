@extends('layouts.admin')

@section('title', 'My Messages')

@section('content')

    <div class="container py-4">
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-center mb-4">Apartments</h2>
                <div class="list-group">
                    @foreach ($apartments as $apartment)
                        <a href="#" class=" p-4 card mb-3 apartment-title" data-id="{{ $apartment->id }}">
                            <h5 class="mb-1">{{ $apartment->title }}</h5>
                            <span class="mb-1 fw-normal">{{ $apartment->address }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="text-center mb-4">Messages List</h2>
                @foreach ($apartments as $apartment)
                    <div class="apartment-{{ $apartment->id }} d-none apartment-messages">
                        @foreach ($apartment->messages as $message)
                            <div class="message card mb-3" data-message-id="{{ $message->id }}"
                                data-message-text="{{ $message->message_text }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $message->sender_name }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $message->sender_email }}</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
                <h2 class="text-center mb-4">Message Details</h2>
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

@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const apartmentTitles = document.querySelectorAll(".apartment-title");
        const messageBody = document.querySelector(".message-body");

        apartmentTitles.forEach(function(apartmentTitle) {
            apartmentTitle.addEventListener("click", function() {
                const apartmentId = this.dataset.id;
                const apartmentMessages = document.querySelectorAll(".apartment-messages");
                const currentApartmentMessages = document.querySelector(
                    `.apartment-${apartmentId}`
                );

                // Hide currently displayed message body
                messageBody.classList.add("d-none");

                apartmentTitles.forEach(function(title) {
                    title.classList.remove("active");
                });

                apartmentMessages.forEach(function(message) {
                    message.classList.add("d-none");
                });

                if (currentApartmentMessages) {
                    currentApartmentMessages.classList.remove("d-none");
                    this.classList.add("active");
                }
            });
        });

        const messages = document.querySelectorAll(".message");
        messages.forEach(function(message) {
            message.addEventListener("click", function() {
                const messageText = this.dataset.messageText;
                const messageTextElement = document.querySelector("#message-text");

                messageTextElement.textContent = messageText;
                messageBody.classList.remove("d-none");

                messages.forEach(function(msg) {
                    msg.classList.remove("active");
                });

                this.classList.add("active");
            });
        });
    });
</script>
