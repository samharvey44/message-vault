<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use App\Services\SecretService;
use DateTime;
use Livewire\Component;

class Home extends Component
{
    #[Rule('required', message: 'Please enter a secret.')]
    public string $secret = '';

    #[Rule('sometimes|nullable|date_format:d/m/Y H:i', message: 'The date entered must be in a valid format.')]
    public string $expiry = '';

    public function save(): void
    {
        $this->validate();

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
