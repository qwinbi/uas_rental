<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $fillable = ['logo_path', 'favicon_path', 'is_active'];

    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : asset('images/logo.png');
    }

    public function getFaviconUrlAttribute()
    {
        return $this->favicon_path ? asset('storage/' . $this->favicon_path) : asset('images/favicon.png');
    }
}