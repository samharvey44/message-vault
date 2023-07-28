<?php

namespace App\Livewire;

use App\Services\SecretService;
use DateTime;
use Livewire\Component;

class Home extends Component
{
    public string $secret = '';

    public string $expiry = '';

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
            DateTime::createFromFormat('d/m/Y H:i', $this->expiry),
        );

        $this->redirect(
            sprintf('%s?secretUrl="%s"', route('secret.preview'), urlencode($secretUrl))
        );
    }

    public function render()
    {
        return view('livewire.home');
    }
}
