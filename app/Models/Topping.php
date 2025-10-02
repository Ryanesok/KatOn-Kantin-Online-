<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    protected $fillable = [
        'kantin_id', 'name', 'price', 'description', 'is_available'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean'
    ];

    // Relationships
    public function kantin()
    {
        return $this->belongsTo(Kantin::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_toppings');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_toppings')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }
}
