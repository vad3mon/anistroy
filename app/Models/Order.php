<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'name',
        'email',
        'phone',
        'address',
        'amount',
        'status',
        'payment_status',
        'comment',
        'ms_id',
        'ms_error',
        'ms_products_added'
        ];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
