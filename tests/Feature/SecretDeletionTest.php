<?php

namespace Tests\Feature;

use App\Models\Secret;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SecretDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_expired_secrets_are_deleted(): void
    {
        $notExpired = rand(1, 10);
        $expired = rand(11, 20);

        Secret::factory($notExpired)->create();
        Secret::factory($expired)->expired()->create();

        Artisan::call('secrets:clear-expired');

        $this->assertCount($notExpired, Secret::all());
    }
}
