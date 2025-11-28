<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="/images/govt_logo.png" type="image/png">
        <title>@yield('title', 'Default Title')</title>

        {{-- Global CSS files --}}

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/global.css') }}">
        <link rel="stylesheet" href="{{ asset('css/header.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">


        {{-- Page specific CSS files --}}
        @yield('styles')

    </head>
    <body>
        @include('layouts.partials.header', ['navbarClass' => $navbarClass ?? ''])

        @yield('content')

        @include('layouts.partials.footer')

        {{-- Global JS (if any) --}}
        <script src="{{ asset('js/app.js') }}"></script>

        {{-- Page-specific JS --}}
        @yield('scripts')
    </body>
</html>