<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'orderNum', 'user_id'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }
    public function achat(): HasMany
    {
        return $this->hasMany(Achat::class);
    }
}
