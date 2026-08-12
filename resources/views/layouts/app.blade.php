<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-lyra-theme-key="lyra-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    {{-- Antes das folhas de estilo: aplica o tema guardado no primeiro paint. --}}
    @lyraThemeScript

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{ $slot ?? '' }}
    @yield('content')
</body>
</html>
