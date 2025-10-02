<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'fruit_id', 'quantity'];
    protected $primaryKey = 'cart_item_id';

    public function fruit()
    {
        return $this->belongsTo(Fruit::class, 'fruit_id', 'fruit_id');// foreign_key in cart_items = fruit_id, owner_key in fruits = fruit_id
    }
}
