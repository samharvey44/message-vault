<?php

namespace App\Console\Commands;

use App\Models\Secret;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearExpiredSecrets extends Command
{
    protected $signature = 'secrets:clear-expired';

    protected $description = 'Clear all expired secrets from the database.';

    public function handle()
    {
        $expired = Secret::whereDate('expiry', '<=', now()->toDateTimeString())->get();

        DB::transaction(function () use ($expired) {
            $expired->each(fn (Secret $secret) => $secret->delete());
        });
    }
}
