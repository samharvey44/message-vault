<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\Secret;
use App\Services\EncryptionService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DateTime;
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

    #[Locked]
    public DateTime $downloadValidUntil;

    public function mount(string $token): void
    {
        $now = CarbonImmutable::now();

        $secret = Secret::where('token', $token)
            ->where('expiry', '>', $now->toDateTimeString())
            ->whereNull('viewed_at')
            ->first();

        abort_unless((bool) $secret, 404);

        $this->secretText = app(EncryptionService::class)->decrypt(
            $secret->secret,
            Request::query('encryptionKey'),
        );
        $this->files = $secret->files;

        // Add a download validity time so that we can check whether
        // file downloads should still be valid before executing
        $this->downloadValidUntil = min(Carbon::parse($secret->expiry), $now->addHour());

        $secret->update(['viewed_at' => $now]);
    }

    public function downloadFiles(): ?BinaryFileResponse
    {
        if ($this->filesDownloaded) {
            return null;
        }

        if ($this->downloadValidUntil <= now()) {
            redirect()->route('home')->with('errors', 'Secret had expired!');

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
