<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'session_id',
        'user_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}

