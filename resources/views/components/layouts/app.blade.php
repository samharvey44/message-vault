<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="{{ mix('build/css/app.css') }}" rel="stylesheet" type="text/css" />

        <title>{{ config('app.name') }}</title>
    </head> 

    {{ $slot }}
</html>
