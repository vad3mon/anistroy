<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCsync extends Model
{
    use HasFactory;

    protected $table = 'mc_syncs';

    protected $fillable = [
        'type',
        'result',
        'offset',
        'size',
        'resultSize'
    ];

}
