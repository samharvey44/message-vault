<?php

namespace App\Services;

use Illuminate\Encryption\Encrypter;

class EncryptionService
{
    private function getEncrypter(?string $key): Encrypter
    {
        return new Encrypter($key ?? config('app.key'), strtolower(config('app.cipher')));
    }

    public function encrypt(string $value, ?string $key = null): string
    {
        return $this->getEncrypter($key)->encrypt($value);
    }

    public function decrypt(string $value, ?string $key = null): string
    {
        return $this->getEncrypter($key)->decrypt($value);
    }
}
