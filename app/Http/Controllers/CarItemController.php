<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // 檢查參數用 (Validator)
use App\Http\Requests\UpdateCartItem;

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
        // 把要檢查的參數放到裡面
        $massages = [
            'required' => ':attribute 為必填', // :attribute 為該 key
            'integer' => ':attribute 必須為數字',
            'between' => ':attribute 您購買的數量為 :input 項，最少購買 :min 項 ; 最多購買 :max 項', // 回傳 err 訊息各種特別參數都有特別的:命名，請參考官方文件
        ];
        $validator = Validator::make($request -> all(), [
            'cart_id' => 'required|integer', // required 指一定需要該參數，| 或 (就是指可以有複數規則)，integer 一定要數字類型
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|between:1,10', // between:最小直,最大值
        ], $massages); 
        if ($validator -> fails()) {  // fails() 如果 Validator::make 沒通過的 key 會加到 fails, 就可以被 fails() 呼叫到
            return response($validator -> errors(), 400); // 將 $validator 依 errors() 傳出去
        }

        $validatedData = $validator -> validate(); // 如果驗證成功 $validator 呼叫 validate() 把參數回傳至到新變數上
        dd($validatedData);
        DB::table('cart_items') -> insert([
            'cart_id' => $validatedData['cart_id'],
            'product_id' => $validatedData['product_id'],
            'quantity' => $validatedData['quantity'],
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

    public function update(UpdateCartItem $request, $id) // 將 Request 換成自定義的 Validation UpdateCartItem
    {
        $form = $request -> validated(); // 因為上面已經使用 Validation 的 request 所以這邊可以使用 validated() 呼叫成功驗證後的資料
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
