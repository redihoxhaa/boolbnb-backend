@extends('layouts.admin')

@section('title', 'My Messages')

@section('content')

    <div>messaggi</div>

    <ul>
        @foreach ($messages as $index => $message)
            <li>
                <h2>{{ $message->sender_name }} - {{ $index }}</h2>
                <span>{{ $message->apartment->title }}</span>
                <h5>{{ $message->sender_email }}</h5>
                <p>{{ $message->message_text }}</p>
            </li>
        @endforeach
        <li></li>
    </ul>



@endsection
