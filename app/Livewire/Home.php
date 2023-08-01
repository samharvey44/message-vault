<?php

namespace App\Livewire;

use App\Services\SecretService;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\View\View;
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
        $this->timezone = Session::get('timezone') ?? 'Europe/London';

        $this->expiry = now($this->timezone)->addHour()->format('d/m/Y H:i');
    }

    public function save(): void
    {
        $this->validate([
            'secret' => 'required',
            'expiry' => 'required|date_format:d/m/Y H:i|after:' . now($this->timezone)->toDateTimeString(),
        ], [
            'secret.required' => 'Please enter a secret!',
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
    }

    public function render(): View
    {
        return view('livewire.home')->layout(config('livewire.layout'));
    }
}
