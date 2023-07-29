<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
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

        // if (!App::isProduction()) {
        //     Session::put('timezone', 'Europe/London');

        //     return;
        // }

        if (Cache::get(config('ip-api.rate-limit-cache'))) {
            // We have used our API quota, we'll wait until this has released
            // to send any more geolocation requests.
            return;
        }

        if (!$ip = Request::ip()) {
            return;
        }

        $response = Http::get(sprintf('%s/%s', config('ip-api.url'), $ip));

        if ($response->failed()) {
            return;
        }

        if ($response->header('X-Rl') === '0') {
            // If we have used our API quota, put a cache flag in place to be released
            // when the quota refreshes.
            Cache::put(config('ip-api.rate-limit-cache'), now()->addSeconds((int) $response->header('X-Ttl')));
        }

        $json = $response->json();

        if ($json['status'] !== 'success') {
            return;
        }

        Session::put('timezone', $json['timezone']);
    }
}
