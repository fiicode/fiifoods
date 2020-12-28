<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\User;

class Role extends Model
{
    
    use HasFactory;
    protected $guarded = [];

    public  function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
