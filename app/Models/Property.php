<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Property extends Model
{
    use HasFactory;

    public function values(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('value');
    }
}
