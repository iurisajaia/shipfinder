<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PackageType::class, 'package_type_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(ContactInfo::class, 'package_id');
    }

}
