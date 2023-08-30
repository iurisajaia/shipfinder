<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrgo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'from' => 'array',
        'to' => 'array'
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class , 'package_id');
    }
}
