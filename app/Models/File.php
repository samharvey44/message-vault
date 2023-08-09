<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'path',
    ];

    public function secret(): BelongsTo
    {
        return $this->belongsTo(Secret::class, 'secret_id');
    }
}
