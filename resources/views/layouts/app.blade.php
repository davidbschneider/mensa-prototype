@extends('layouts.base')

@section('content')
    <x-jet-banner />
    @if(request()->routeIs('admin.*'))
        @include('admin.navigation-menu')
    @else
        @livewire('navigation-menu')
    @endauth
    <header class="d-flex py-3 bg-white shadow-sm border-bottom">
        <div class="container">
            {{ $header }}
        </div>
    </header>
    <main class="container my-5">
        {{ $slot }}
    </main>
@endsection
