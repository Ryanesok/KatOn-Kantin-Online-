<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kantin'];

    // Relasi: Satu Kantin memiliki banyak Menu
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Relasi: Satu Kantin dikelola oleh satu User (Admin)
    public function admin()
    {
        return $this->hasOne(User::class);
    }
}