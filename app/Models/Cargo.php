<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Cargo extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'from' => 'array',
        'to' => 'array'
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class , 'package_id');
    }

    public function bids(): HasMany{
        return $this->hasMany(Bid::class , 'cargo_id');
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class , 'bid_id');
    }


}
