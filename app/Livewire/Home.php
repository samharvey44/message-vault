<?php

namespace App\Livewire;

use App\Services\SecretService;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Home extends Component
{
    public string $timezone;

    public string $secret = '';

    public string $expiry = '';

    public function mount(): void
    {
        $this->timezone = Session::get('timezone') ?? 'Europe/London';

        $this->expiry = now($this->timezone)->addHour()->format('d/m/Y H:i');
    }

    public function save(): void
    {
        $this->validate([
            'secret' => 'required',
            'expiry' => 'required|date_format:d/m/Y H:i|after:' . now('Europe/London')->toDateTimeString(),
        ], [
            'expiry.date_format' => 'The expiry time must be in valid format.',
            'expiry.after' => 'The expiry time must be in the future.',
        ]);

        $secretUrl = app(SecretService::class)->create(
            $this->secret,
            DateTime::createFromFormat('d/m/Y H:i', $this->expiry, new DateTimeZone($this->timezone))->setTimezone(new DateTimeZone('UTC')),
        );

        $this->redirect(route('secret.preview', ['secretUrl' => urlencode($secretUrl)]));
    }

    public function render()
    {
        return view('livewire.home');
    }
}
