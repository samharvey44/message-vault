<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ViewSecret;
use App\Models\Secret;
use App\Services\SecretService;
use Tests\TestCase;

class ViewSecretTest extends TestCase
{
    public function test_renders_successfully_with_valid_secret(): void
    {
        $url = app(SecretService::class)->create('Test - a very nice secret!', [], now()->addHour());

        $this->get($url)
            ->assertStatus(200)
            ->assertSeeLivewire(ViewSecret::class);
    }

    public function test_fails_for_expired_secret(): void
    {
        $url = app(SecretService::class)->create('Test - an expired secret!', [], now()->subHours(2));

        // 403 as signed URL will be invalid
        $this->get($url)->assertStatus(403);
    }

    public function test_fails_for_viewed_secret(): void
    {
        $url = app(SecretService::class)->create('Test - a viewed secret!', [], now()->addHours(5));

        Secret::latest('id')->first()->update(['viewed_at' => now()]);

        $this->get($url)->assertStatus(404);
    }
}
