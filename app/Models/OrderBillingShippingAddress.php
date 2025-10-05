<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBillingShippingAddress extends Model
{
    use HasFactory;

    protected $primaryKey = 'oa_id';
    public $timestamps = false;

    protected $fillable = [
        'oid',
        'b_fullname',
        'b_phone',
        'b_email',
        'b_address',
        'b_pincode',
        's_fullname',
        's_phone',
        's_email',
        's_address',
        's_pincode',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'oid', 'order_id');
    }
}
