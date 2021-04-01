<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [''];
    public function cartItems() { // 這邊因為是反向 一對多 所以是複數(s)
        return $this -> hasMany(CartItem::class); // hasMany 因為我Carts 的 id, 對到的可能是會多筆 cart_items 所以是使用 hasMany
    }
    public function user() {
        return $this -> belongsTo(User::class);
    }
    public function order() {
        return $this -> hasOne(Order::class);
    }

    public function checkout() {
        $order = $this -> order() -> create([
            'user_id' => $this -> user_id
        ]);
        foreach ($this -> cartItems as $cartItem) {
            $order -> orderItems() -> create([
                'product_id' => $cartItem -> product_id,
                'price' => $cartItem -> product -> price
            ]);
        }
        $this -> update(['checkouted' => true]);
        $order -> orderItems;
        return $order;
    }
}
