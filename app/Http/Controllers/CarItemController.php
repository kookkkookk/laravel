<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request) // store, 就是 POST 會進來的 function
    {
        $form = $request -> all(); // 這邊 $request 就是收到前端來的值
        // dd('$form: ', $form);
        DB::table('cart_items') -> insert([
            'cart_id' => $form['cart_id'],
            'product_id' => $form['product_id'],
            'quantity' => $form['quantity'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
        // 通常建立成功，會回傳剛寫進資料庫的以上參數或單一true
        return response() -> json(true); // 使用 -> json(true) 可以讓前端收到的 response 顯示true, 不然如果只使用 response(true) 則會顯示: 1.
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
    public function update(Request $request, $id) // update, 就是 PUT/PATCH 會進來的 function; $id 前端網址帶上的id
    {
        $form = $request -> all(); // 這邊 $request 就是收到前端來的值
        DB::table('cart_items') -> where('id', $id) -> update([ // where 尋找要被改的id; update 更新該 table 資料
            'quantity' => $form['quantity'],
            'updated_at' => now() // 只更新 updated_at 的時間
        ]);
        return response() -> json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // destroy, 就是 DELETE 會進來的 function; $id 前端網址帶上的id; 如果刪除有條件也可以使用參數 Request $request
    public function destroy($id)
    {
        DB::table('cart_items') -> where('id', $id) -> delete();
        return response() -> json(true);
    }
}
