<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function foodsName(): HasMany
    {
        return $this->hasMany(FoodsName::class);
    }
    public function depense(): HasMany
    {
        return $this->hasMany(Depense::class);
    }
}
