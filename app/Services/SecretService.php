<?php

namespace App\Services;

use App\Models\File;
use App\Models\Secret;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SecretService
{
    public function create(string $secret, array $files, DateTime $expiry, ?string $encryptionKey = null): string
    {
        $encryptionKey ??= Str::random(32);

        do {
            $token = Str::random();
        } while (Secret::whereToken($token)->exists());

        DB::transaction(function () use ($secret, $files, $expiry, $encryptionKey, $token) {
            $secret = Secret::create([
                'secret' => app(EncryptionService::class)->encrypt($secret, $encryptionKey),
                'token' => $token,
                'expiry' => $expiry,
            ]);

            foreach ($files as $uploadedFile) {
                $path = $uploadedFile->store('secret-files');

                $file = File::make([
                    'client_name' => $uploadedFile->getClientOriginalName(),
                    'path' => $path,
                ]);

                $file->secret()->associate($secret);
                $file->save();
            }
        });

        return URL::temporarySignedRoute('secret.view', $expiry, ['token' => $token, 'encryptionKey' => $encryptionKey]);
    }
}
