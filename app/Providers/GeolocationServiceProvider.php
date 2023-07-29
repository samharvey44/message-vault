<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class GeolocationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (App::runningInConsole()) {
            return;
        }

        if (Session::get('timezone')) {
            return;
        }

        if (!App::isProduction()) {
            Session::put('timezone', 'Europe/London');

            return;
        }

        if (!$ip = Request::ip()) {
            return;
        }

        $response = Http::get(sprintf('%s/%s', config('ip-api.url'), $ip));

        if ($response->failed()) {
            return;
        }

        $json = $response->json();

        if ($json['status'] !== 'success') {
            return;
        }

        Session::put('timezone', $json['timezone']);
    }
}
