<?php

namespace App\Livewire;

use App\Services\SecretService;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Home extends Component
{
    #[Locked]
    public string $timezone;

    public string $secret = '';

    public string $expiry = '';

    public function mount(): void
    {
        $this->timezone = Session::get('timezone');

        $this->expiry = now($this->timezone)->addHour()->format('d/m/Y H:i');
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
                ], [
                    'secret.required' => 'Please enter a secret!',
                    'secret.max' => 'The secret is too long!',
                    'expiry.date_format' => 'The expiry time must be in valid format.',
                    'expiry.after' => 'The expiry time must be in the future.',
                ]);

                $secretUrl = app(SecretService::class)->create(
                    $this->secret,
                    DateTime::createFromFormat(
                        'd/m/Y H:i',
                        $this->expiry,
                        new DateTimeZone($this->timezone),
                    )->setTimezone(new DateTimeZone(config('app.timezone'))),
                );

                redirect()->to(route('secret.preview'))->with('generatedUrl', $secretUrl);
            },
        );

        abort_unless($stored, 429);
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
