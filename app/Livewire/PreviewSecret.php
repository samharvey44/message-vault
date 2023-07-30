<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class PreviewSecret extends Component
{
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

    public function render()
    {
        return view('livewire.preview-secret');
    }
}
