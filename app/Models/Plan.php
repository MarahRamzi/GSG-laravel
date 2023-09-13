<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    public function features()
    {
        return $this->belongsToMany(Feature::class , 'plan_feature')
        ->withPivot(['feature_value']);
    }

    public function subscriptions() :HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function users() :BelongsToMany
    {
        return $this->belongsToMany(User::class , 'subscriptions'); //subscriptions => pivot table between plan and user
    }

    public function Price() :Attribute
    {
        return new Attribute(
            get: fn($price) => $price / 100,
            set: fn($price) => $price * 100
        );
    }



}
