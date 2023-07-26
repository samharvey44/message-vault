<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use App\Services\SecretService;
use Livewire\Component;

class NewMessage extends Component
{
    #[Rule('required', message: 'Please enter a secret.')]
    public string $secret = '';

    public function save(): void
    {
        app(SecretService::class)->create($this->secret);
    }

    public function render()
    {
        return view('livewire.new-message');
    }
}
