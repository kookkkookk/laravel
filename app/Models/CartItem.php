<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 引入軟刪除

class CartItem extends Model
{
    use HasFactory;
    use SoftDeletes; // 套用使用軟刪除

    // protected $fillable = ['quantity']; // 使用 protected 命名變數 $fillable 只有這個陣列內的 key 是可以被改變的
    // protected $guarded = ['quantity']; // 使用 protected 命名變數 $guarded 只有這個陣列內的 key 是不可以被改變的，其餘則可以
    protected $guarded = ['']; // $guarded 設定空陣列，等於全部都可以允許被改動
    // protected $hidden = ['updated_at', 'product_id']; // $hidden 為隱藏該 data row, 回傳不會顯示該陣列內的 key
    // protected $appends = ['current_price']; // $appends 為自定義 key 回傳
    // public function getCurrentPriceAttribute() { // 該key的回傳 value 涵式定義，命名方式為 get + 大駝峰命名該Key + Attribute
    //     return $this -> quantity * 10;
    // }

    public function product() { // 設定此張 Table 的關聯
        return $this -> belongsTo(Product::class);
    }
    public function cart() {
        return $this -> belongsTo(Cart::class);
    }
}
