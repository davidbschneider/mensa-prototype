<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'David Schneider') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @livewireStyles
        <script src="{{ mix('js/app.js') }}" defer></script>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/mensa_logo.svg') }}">
    </head>
    <body class="font-sans antialiased bg-light d-flex flex-column h-100">
        <div class="flex-shrink-0">
            @yield('content')
        </div>
        <footer class="mt-auto bg-dark text-white">
            @isset($footer)
                {{ $footer }}
            @else
                <div class="container">
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="row pt-2">
                            <div class="col">
                                <ul>
                                    <li>
                                        <a class="text-white" href="{{ route('admin.login') }}">
                                            {{ __('common.Administration') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col">
                                <ul>
                                    <li>
                                        <a class="text-white" target="_blank" href="{{ route('policy.show') }}">{{ __('Privacy Policy') }}</a>
                                    </li>
                                    <li>
                                        <a class="text-white" target="_blank" href="{{ route('terms.show') }}">{{ __('Terms of Service') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="row py-2">
                        <div class="col text-center">
                            &copy; David Schneider {{ \Carbon\Carbon::now()->year }}
                        </div>
                    </div>
                </div>
            @endisset
        </footer>
        @stack('modals')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
