@extends('layouts.app')

@section('content')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/helper.js') }}?v={{ time() }}" defer></script>

  <div class="container">
    <x-network_connections :suggestionCount="$suggestionCount" :sentRequestCount="$sentRequestCount" :receivedRequestCount="$receivedRequestCount" :connectionCount="$connectionCount">
      @foreach ($users as $user)
      <x-suggestion :user="$user" />
      @endforeach
    </x-network_connections>
  </div>
  <script>
    var authId = {{ auth()->id() }};
  </script>
  <script src="{{ asset('js/main.js') }}?v={{ time() }}" defer></script>

@endsection