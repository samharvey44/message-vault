<?php

namespace App\Services;

use App\Models\Secret;
use DateTime;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SecretService
{
    public function create(string $secret, DateTime $expiry): string
    {
        $encryptionKey = Str::random(32);

        do {
            $token = Str::random();
        } while (Secret::whereToken($token)->exists());

        $secret = Secret::create([
            'secret' => app(EncryptionService::class)->encrypt($secret, $encryptionKey),
            'token' => $token,
            'expiry' => $expiry,
        ]);

        return URL::temporarySignedRoute('secret.view', $expiry, ['token' => $token, 'encryptionKey' => $encryptionKey]);
    }
}
