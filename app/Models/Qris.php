<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qris extends Model
{
    use HasFactory;

    protected $fillable = ['bank_name', 'account_name', 'qris_image', 'is_active'];

    protected $table = 'qris';

    public function getQrisImageUrlAttribute()
    {
        return $this->qris_image ? asset('storage/' . $this->qris_image) : asset('images/qris-default.png');
    }
}