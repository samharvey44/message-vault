<?php

namespace App\Livewire;

use App\Services\EncryptionService;
use App\Services\SecretService;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Str;

class Home extends Component
{
    use WithFileUploads;

    #[Locked]
    public string $timezone;

    public string $secret = '';

    public string $expiry = '';

    public array $files = [];

    #[Locked]
    public int $filesUploadIteration = 1;

    #[Locked]
    public string $encryptionKey;

    public function mount(): void
    {
        $this->timezone = Session::get('timezone');
        $this->expiry = now($this->timezone)->addHour()->format('d/m/Y H:i');
        $this->encryptionKey = Str::random(32);
    }

    public function updating(string $property, mixed $value): void
    {
        if ($property !== 'files') {
            return;
        }

        foreach (Arr::wrap($value) as $uploadedFile) {
            $filePath = $uploadedFile->getRealPath();
            $fileContents = file_get_contents($filePath);

            // Livewire will store the uploaded file in its temporary folder ready for usage later.
            // However, this means we will have unencrypted files stored, which defeats the purpose.
            // To prevent this, we'll overwrite uploaded files with the encrypted equivalent of their
            // value, ensuring we aren't going to be holding any unencrypted files.
            $encryptedFileContents = app(EncryptionService::class)->encrypt($fileContents, $this->encryptionKey);
            file_put_contents($filePath, $encryptedFileContents);
        }
    }

    public function clearFiles(): void
    {
        foreach ($this->files as $file) {
            $file->delete();
        }

        // Cause the input field to rebuild itself, therefore ensuring the
        // field's description text will remain up-to-date
        $this->filesUploadIteration++;
    }

    public function save(): void
    {
        $stored = RateLimiter::attempt(
            'create-secret-' . Request::ip(),
            5,
            function () {
                $this->validate([
                    'secret' => 'required|max:99999',
                    'expiry' => 'required|date_format:d/m/Y H:i|after:' . now($this->timezone)->toDateTimeString(),
                    'files' => 'sometimes|nullable|array|max:5',
                    'files.*' => 'required|file|max:5000',
                ], [
                    'secret.required' => 'Please enter a secret!',
                    'secret.max' => 'The secret is too long!',
                    'expiry.date_format' => 'The expiry time must be in valid format.',
                    'expiry.after' => 'The expiry time must be in the future.',
                    'files.max' => 'You may only upload up to 5 files at a time.',
                    'files.*.max' => 'The max file size permitted is 5MB.',
                ]);

                $secretUrl = app(SecretService::class)->create(
                    $this->secret,
                    $this->files,
                    DateTime::createFromFormat(
                        'd/m/Y H:i',
                        $this->expiry,
                        new DateTimeZone($this->timezone),
                    )->setTimezone(new DateTimeZone(config('app.timezone'))),
                    $this->encryptionKey,
                );

                redirect()->route('secret.preview')->with('generatedUrl', $secretUrl);
            },
        );

        abort_unless($stored, 429);
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
