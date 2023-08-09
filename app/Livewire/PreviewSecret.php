<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;

class PreviewSecret extends Component
{
    #[Locked]
    public string $generatedUrl;

    public function mount(): void
    {
        $url = Session::get('generatedUrl');

        if (is_null($url)) {
            redirect()->to(route('home'));

            return;
        }

        $this->generatedUrl = $url;
    }

    public function render(): View
    {
        return view('livewire.preview-secret');
    }
}
