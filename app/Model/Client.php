<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'nom', 'phone', 'user_id'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vente(): HasMany
    {
        return $this->hasMany(Vente::class);
    }
    public function facture(): HasMany
    {
        return $this->hasMany(Facture::class);
    }
}
