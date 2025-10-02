<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartTopping extends Model
{
    protected $fillable = [
        'cart_id', 'topping_id', 'quantity', 'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function topping()
    {
        return $this->belongsTo(Topping::class);
    }
}
