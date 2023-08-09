<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\Secret;
use App\Services\EncryptionService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Locked;
use ZipArchive;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ViewSecret extends Component
{
    #[Locked]
    public string $secretText;

    #[Locked]
    public Collection $files;

    #[Locked]
    public bool $filesDownloaded = false;

    public function mount(string $token): void
    {
        $secret = Secret::where('token', $token)
            ->where('expiry', '>', now()->toDateTimeString())
            ->whereNull('viewed_at')
            ->with('files')
            ->first();

        abort_unless((bool) $secret, 404);

        $this->secretText = app(EncryptionService::class)->decrypt(
            $secret->secret,
            Request::query('encryptionKey'),
        );
        $this->files = $secret->files;

        if (is_null($secret->viewed_at)) {
            $secret->update(['viewed_at' => now()]);
        }
    }

    public function downloadFiles(): ?BinaryFileResponse
    {
        if ($this->filesDownloaded) {
            return null;
        }

        $zip = new ZipArchive();

        if (!Storage::exists('zip-downloads')) {
            Storage::makeDirectory('zip-downloads');
        }

        do {
            $path = Storage::path('zip-downloads/' . Str::random() . '.zip');
        } while (file_exists($path));

        if ($zip->open($path, ZipArchive::CREATE) === true) {
            $this->files->each(function (File $file) use ($zip) {
                $zip->addFile(Storage::path($file->path), $file->client_name);
            });

            $zip->close();
        }

        $this->filesDownloaded = true;

        return response()->download($path)->deleteFileAfterSend();
    }

    public function render()
    {
        return view('livewire.view-secret');
    }
}
