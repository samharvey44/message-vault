<?php

namespace Tests\Feature\Livewire;

use App\Livewire\PreviewSecret;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Support\Str;

class PreviewSecretTest extends TestCase
{
    public function test_renders_successfully_with_url(): void
    {
        Session::put('generatedUrl', Str::random());

        $this->get(route('secret.preview'))
            ->assertStatus(200)
            ->assertSeeLivewire(PreviewSecret::class);
    }

    public function test_redirects_to_home_without_url(): void
    {
        $this->get(route('secret.preview'))
            ->assertStatus(302)
            ->assertRedirect(route('home'));
    }
}
