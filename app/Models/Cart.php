<?php

// app/Models/Cart.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'menu_id', 'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'cart_toppings')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    // Helper untuk total harga termasuk toppings
    public function getTotalPriceAttribute()
    {
        $menuTotal = $this->menu->price * $this->quantity;
        $toppingsTotal = $this->toppings->sum(function ($topping) {
            return $topping->pivot->price * $topping->pivot->quantity;
        });
        
        return $menuTotal + $toppingsTotal;
    }
}
