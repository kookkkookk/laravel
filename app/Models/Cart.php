<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function cartItems() { // 這邊因為是反向 一對多 所以是複數(s)
        return $this -> hasMany(CartItem::class); // hasMany 因為我Carts 的 id, 對到的可能是會多筆 cart_items 所以是使用 hasMany
    }
}
