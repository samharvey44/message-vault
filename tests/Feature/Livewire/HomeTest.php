<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Home;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Str;

class HomeTest extends TestCase
{
    public function test_renders_successfully(): void
    {
        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSeeLivewire(Home::class);
    }

    public function test_can_create_secret(): void
    {
        Livewire::test(Home::class)
            ->set('secret', Str::random(50))
            ->set('expiry', now()->addDay()->format('d/m/Y H:i'))
            ->call('save')
            ->assertStatus(200);
    }
}
