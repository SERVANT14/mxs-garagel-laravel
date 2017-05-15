<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<v-app id="app">
    @include('partials.nav-bar')

    <main>
        <v-content>
            <mxs-validation-alert :validation-errors="validationErrors"></mxs-validation-alert>
            <v-alert v-for="(error, index) in genericErrors"
                     :key="index"
                     error
                     dismissible
                     v-model="error.visible"
            >@{{ error.message }}</v-alert>

            @yield('content')
        </v-content>
    </main>
</v-app>

<!-- Scripts -->
<script>
    Laravel = {!! json_encode([
    'appUrl' => url('/'),
    'csrfToken' => csrf_token(),
    ]) !!}
</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
