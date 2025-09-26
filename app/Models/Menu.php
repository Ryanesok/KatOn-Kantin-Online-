<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'kantin_id',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'status',
    ];

    // Relasi: Satu Menu dimiliki oleh satu Kantin
    public function kantin()
    {
        return $this->belongsTo(Kantin::class);
    }
}