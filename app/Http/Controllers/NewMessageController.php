<?php

namespace App\Http\Controllers;

use App\Livewire\NewMessage;

class NewMessageController extends Controller
{
    public function show(): string
    {
        $view = new NewMessage();

        return $view();
    }
}
