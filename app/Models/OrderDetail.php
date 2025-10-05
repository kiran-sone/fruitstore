<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'od_id';

    protected $fillable = [
        'oid',
        'fid',
        'qty',
        'unit_price',
        'sub_total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'oid', 'order_id');
    }

    public function fruit()
    {
        return $this->belongsTo(Fruit::class, 'fid', 'fruit_id');
    }
}
