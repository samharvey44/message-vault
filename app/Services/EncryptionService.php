<?php

namespace App\Services;

use Illuminate\Encryption\Encrypter;

class EncryptionService
{
    public function encrypt(string $value, ?string $key = null): string
    {
        $encrypter = new Encrypter($key ?? config('app.key'), strtolower(config('app.cipher')));

        return $encrypter->encrypt($value);
    }

    public function decrypt(string $value, ?string $key = null): string
    {
        $encrypter = new Encrypter($key ?? config('app.key'), strtolower(config('app.cipher')));

        return $encrypter->decrypt($value);
    }
}
