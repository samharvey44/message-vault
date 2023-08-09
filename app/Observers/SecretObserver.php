<?php

namespace App\Observers;

use App\Models\File;
use App\Models\Secret;
use Illuminate\Support\Facades\Storage;

class SecretObserver
{
    public function deleting(Secret $secret): void
    {
        $secret->files->each(function (File $file) {
            Storage::delete($file->path);

            $file->delete();
        });
    }
}
