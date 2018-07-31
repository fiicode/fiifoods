<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $fillable = [
        'name',
        'unite',
        'user_id',
        'versemFournisseur',
        'creditFournisseur',
        'versemClient',
        'creditClient',
        'client_id',
        'fournisseur_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function foodsName(): HasMany
    {
        return $this->hasMany(FoodsName::class);
    }
}
