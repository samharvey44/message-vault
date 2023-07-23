<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="{{ mix('mix/css/app.css') }}" rel="stylesheet" type="text/css" />

        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        @include('components.layouts.navbar')

        <div class="container-fluid p-3">
            {{ $slot }}
        </div>
    </body>
</html>
