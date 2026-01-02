<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'class',
        'major',
        'description',
        'features',
        'avatar'
    ];

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/default-avatar.png');
    }

    public function getFeaturesArrayAttribute()
    {
        return $this->features ? explode(',', $this->features) : [];
    }
}