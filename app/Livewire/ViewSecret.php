<?php

namespace App\Livewire;

use App\Models\Secret;
use App\Services\EncryptionService;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\Attributes\Locked;

class ViewSecret extends Component
{
    #[Locked]
    public string $secretText;

    public function mount(string $token): void
    {
        $secret = Secret::where('token', $token)
            ->where('expiry', '>', now()->toDateTimeString())
            ->whereNull('viewed_at')
            ->first();

        abort_unless((bool) $secret, 404);

        $this->secretText = app(EncryptionService::class)->decrypt(
            $secret->secret,
            Request::query('encryptionKey'),
        );

        if (is_null($secret->viewed_at)) {
            $secret->update(['viewed_at' => now()]);
        }
    }

    public function render()
    {
        return view('livewire.view-secret');
    }
}
