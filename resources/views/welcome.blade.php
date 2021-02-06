<x-guest-layout>
    <x-slot name="header">
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-4">{{ __('welcome.jumbotron.title') }}</h1>
                <hr class="my-4">
                <p>{{ __('welcome.jumbotron.text') }}</p>
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </div>
        </div>
    </x-slot>
</x-guest-layout>
