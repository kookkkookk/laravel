<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [''];

    // 設定 是使用 belongsTo or hasMany 要清楚這張 Table 的一對多、多對多的關係

    // 設定 Order 的關聯
    public function orderItems() { // 這邊因為是反向 一對多 所以是複數(s)
        return $this -> hasMany(OrderItem::class); // hasMany 因為我 Orders 的 id, 對到的可能是會多筆 order_items 所以是使用 hasMany
    }

    // 設定 User 的關聯
    public function user() { // 因為 user 為該自己這個帳號，所以是單數
        return $this -> belongsTo(User::class);
    }

    // 設定 Cart 的關聯
    public function cart() {
        return $this -> belongsTo(Cart::class);
    }
}
