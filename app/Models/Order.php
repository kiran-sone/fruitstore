<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'uid',
        'order_date',
        'total_amount',
        'shipping_cost',
        'pay_method',
        'pay_status',
        'order_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
