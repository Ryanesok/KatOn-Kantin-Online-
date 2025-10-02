<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTopping extends Model
{
    protected $fillable = [
        'order_id', 'topping_id', 'quantity', 'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function topping()
    {
        return $this->belongsTo(Topping::class);
    }
}
