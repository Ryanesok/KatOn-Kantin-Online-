<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'menu_id', 'kantin_id', 'quantity', 'total_price', 'status', 'order_date',
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function kantin()
    {
        return $this->belongsTo(Kantin::class);
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'order_toppings')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
