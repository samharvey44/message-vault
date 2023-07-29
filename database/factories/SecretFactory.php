<?php

namespace Database\Factories;

use App\Services\EncryptionService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Secret>
 */
class SecretFactory extends Factory
{
    public function definition(): array
    {
        return [
            'secret' => app(EncryptionService::class)->encrypt($this->faker->sentence(), Str::random(32)),
            'token' => Str::random(),
            'expiry' => now()->addDay(),
        ];
    }

    public function expired(): Factory
    {
        return $this->state(fn (array $attributes) => ['expiry' => now()->subDay()]);
    }
}
