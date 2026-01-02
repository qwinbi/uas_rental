<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'address',
        'phone',
        'email',
        'copyright',
        'social_links'
    ];

    public function getSocialLinksArrayAttribute()
    {
        return $this->social_links ? json_decode($this->social_links, true) : [];
    }
}