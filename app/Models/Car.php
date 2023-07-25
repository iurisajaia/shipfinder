<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dimension(): HasOne
    {
        return $this->hasOne(Dimension::class);
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class , 'payment_method_id');
    }

    public function trailer_type(): BelongsTo
    {
        return $this->belongsTo(CarTrailerType::class , 'trailer_type_id');
    }

    public function body_types(): BelongsToMany
    {
        return $this->belongsToMany(CarBodyType::class, 'car_car_body_types');
    }

    public function loading_types(): BelongsToMany
    {
        return $this->belongsToMany(CarLoadingType::class, 'car_car_loading_types');
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'car_countries');
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'car_drivers');
    }








}
