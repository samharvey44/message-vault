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
        $notExpired = 2;
        $viewedUnderAnHourAgo = 3;

        $expired = 10;
        $viewedOverAnHourAgo = 11;

        Secret::factory($notExpired)->create();
        Secret::factory($viewedUnderAnHourAgo)->viewedUnderAnHourAgo()->create();
        Secret::factory($expired)->expired()->create();
        Secret::factory($viewedOverAnHourAgo)->viewedOverAnHourAgo()->create();

        Artisan::call('secrets:clear-expired');

        $this->assertCount($notExpired + $viewedUnderAnHourAgo, Secret::all());
    }
}
