<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class GeolocationServiceProvider extends ServiceProvider
{
    private const DEFAULT_TIMEZONE = 'Europe/London';

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (Session::get('timezone')) {
            return;
        }

        if (
            App::runningInConsole()
            || Cache::get(config('ip-api.rate-limit-cache'))
            || App::isProduction() === false
            || is_null($ip = Request::ip())
        ) {
            Session::put('timezone', self::DEFAULT_TIMEZONE);

            return;
        }

        $response = Http::get(sprintf('%s/%s', config('ip-api.url'), $ip));

        if ($response->failed()) {
            Session::put('timezone', self::DEFAULT_TIMEZONE);

            Log::error("Failed to obtain user timezone! Failed with response code - {$response->status()}");

            return;
        }

        if ($response->header('X-Rl') === '0') {
            // If we have used our API quota, put a cache flag in place to be released
            // when the quota refreshes.
            Cache::put(config('ip-api.rate-limit-cache'), true, now()->addSeconds((int) $response->header('X-Ttl')));
        }

        $json = $response->json();

        if ($json['status'] !== 'success') {
            return;
        }

        Session::put('timezone', $json['timezone'] ?? self::DEFAULT_TIMEZONE);
    }
}
