<?php

// app/Models/Menu.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'stock', 'image_path', 'kantin_id',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function kantin()
    {
        return $this->belongsTo(Kantin::class);
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'menu_toppings');
    }
}
