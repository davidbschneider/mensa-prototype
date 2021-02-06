@extends('layouts.base')

@section('content')
    <x-jet-banner />
    @livewire('navigation-menu')
    <?= $header ?? '' ?>
    <main class="container my-5">
        {{ $slot }}
    </main>
@endsection
