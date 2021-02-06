@extends('layouts.base')

@section('content')
    <x-jet-banner />
    @livewire('navigation-menu')
    <header class="d-flex py-3 bg-white shadow-sm border-bottom">
        <div class="container">
            {{ $header }}
        </div>
    </header>
    <main class="container my-5">
        {{ $slot }}
    </main>
@endsection
