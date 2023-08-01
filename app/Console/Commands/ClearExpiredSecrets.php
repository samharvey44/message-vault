<?php

namespace App\Console\Commands;

use App\Models\Secret;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ClearExpiredSecrets extends Command
{
    protected $signature = 'secrets:clear-expired';

    protected $description = 'Clear all expired secrets from the database.';

    public function handle()
    {
        $now = CarbonImmutable::now();

        $expired = Secret::where('expiry', '<=', $now->toDateTimeString())
            ->orWhere(function (Builder $sq) use ($now) {
                $sq->whereNotNull('viewed_at')->where('viewed_at', '<=', $now->subHour()->toDateTimeString());
            })
            ->get();

        DB::transaction(function () use ($expired) {
            $expired->each(fn (Secret $secret) => $secret->delete());
        });
    }
}
