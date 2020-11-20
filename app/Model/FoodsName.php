<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodsName extends Model
{
    protected $fillable = [
        'foodsName', 'unite_id', 'user_id', 'inventaire'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function achat(): HasMany
    {
        return $this->hasMany(Achat::class);
    }
}
