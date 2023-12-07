<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'price'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
