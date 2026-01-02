<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'price_per_day',
        'seats',
        'transmission',
        'fuel_type',
        'available',
        'image'
    ];

    protected $casts = [
        'available' => 'boolean',
        'price_per_day' => 'decimal:2'
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-car.jpg');
    }
}