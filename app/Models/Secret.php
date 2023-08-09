<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Secret extends Model
{
    use HasFactory;

    protected $fillable = [
        'secret',
        'token',
        'expiry',
        'viewed_at',
    ];

    protected $dates = [
        'expiry',
        'viewed_at',
    ];

    protected $with = [
        'files',
    ];

    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'secret_id');
    }
}
