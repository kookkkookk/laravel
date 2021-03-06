<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $cart = DB::table('carts') -> get() -> first();
        // // 如果資料庫該table完全沒有資料就建立第一筆
        // if (empty($cart)) { // empty() 如果為空
        //     DB::table('carts') -> insert(['created_at' => now(), 'updated_at' => now()]); // insert 建立, now() 抓取系統當下時間
        //     $cart = DB::table('carts') -> get() -> first();
        // }

        // // 因為 Table cart_items 有關連 Table carts, 這邊也幫需要取得 Table carts 底下有關聯到的 cart_items (row: cart_id 與 Table carts row: id相同者)
        // $cartItems = DB::table('cart_items') -> where('cart_id', $cart -> id) -> get();
        // $cart = collect($cart); // 將 $cart 轉換為 collect
        // $cart['items'] = collect($cartItems);
        
        // firstOrCreate() 是Get該資料，但如果目前沒有就會產生一筆資料進去該 Table 格式只有單純 [id, created_at, updated_at]
        // with([該目前表單的關聯]) 這樣就會撈出該 關聯的data
        // $cart = Cart::with(['cartItems']) -> firstOrCreate();

        $user = auth() -> user();
        // 這邊因為串接了 user, 改成查看每一個個人 user_id 的購物車內容, 如果沒有則就建立第一筆該 user 自己的 carts: data row
        $cart = Cart::with(['cartItems']) -> where('user_id', $user -> id) -> firstOrCreate([
            'user_id' => $user -> id
        ]);
        
        
        return response($cart);

    }

    public function checkout() {
        $user = auth() -> user();
        // with() 可以減少效能消耗，會預先執行 lazyload 該 table, 撈取時候會比較快
        $cart = $user -> carts() -> where('checkouted', false) -> with('cartItems') -> first();
        if ($cart) {
            $result = $cart -> checkout();
            return response($result);
        } else {
            return response('沒有購物車', 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
