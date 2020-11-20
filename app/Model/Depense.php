<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Depense extends Model
{
    protected $guarded = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
