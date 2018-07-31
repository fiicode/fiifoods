<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achat extends Model
{
    protected $fillable = [
        'foods_name_id', 'code', 'qtt', 'priceOfPurchase', 'sellingPrice', 'paye', 'fournisseur_id', 'order_id', 'user_id'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function foodsName(): BelongsTo
    {
        return $this->belongsTo(FoodsName::class);
    }
    public  function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
