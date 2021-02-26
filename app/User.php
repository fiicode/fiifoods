<?php

namespace App;

use App\Model\Depense;
use App\Model\FoodsName;
use App\Model\Option;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function foodsName(): HasMany
    {
        return $this->hasMany(FoodsName::class);
    }

    public function option(): HasMany
    {
        return $this->hasMany(Option::class);
    }
    public function depense(): HasMany
    {
        return $this->hasMany(Depense::class);
    }

}
