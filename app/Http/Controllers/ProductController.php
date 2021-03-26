<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // increment 該 data row 增加多少值, 第2參數沒填則是1
        DB::table('sbl_team_data') -> where('id', 532) -> increment('win', 2000);
        // decrement 該 data row 減少多少值, 第2參數沒填則是1
        DB::table('sbl_team_data') -> where('id', 533) -> decrement('win');
        return response(123);
    }

    public function getData()
    {
        return collect([
            collect(['id' => 0, 'title' => 'Test product - 1', 'content' => 'It\'s good prodect!', 'price' => 50]),
            collect(['id' => 1, 'title' => 'Test product - 2', 'content' => 'It\'s not bad prodect!', 'price' => 30]),
        ]);
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
        // dump('store: ', $request -> all());
        $data = $this -> getData();
        $newData = $request -> all();
        // array_push($data, $newData);
        $data -> push(collect($newData)); // 該為 collect 的 push 方式
        dump($data);
        return response($data);
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
    public function update(Request $request, $id) // $id 就是傳進來的id值
    {
        $form = $request -> all(); // 取得到傳來的參數
        $data = $this -> getData();
        $selectedData = $data -> where('id', $id) -> first();
        // where('keyName', 參數值) 比對並抓取該單一筆[]資料出來
        // first() 用來取得該層一層級就好，原本沒有使用first我們的資料是 [[...]], 使用first後 就會變成[...]
        // dump($selectedData);
        $selectedData = $selectedData -> merge(collect($form)); // 把 $form 更新到 $selectedData

        return response($selectedData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this -> getData();
        // use($id) 是什麼? 由於在 filter 裡的涵式是封閉的 所以需要用一個use將外部參數帶進去
        $data = $data -> filter(function($product) use($id) {
            return $product['id'] != $id;
        });
        // 由於filter過後會重新組陣列 ex: [1:[...],2:[...],...]; 使用values() 可以過濾此重新產生的 key ex: [[...],[...],...]
        return response($data -> values()); // 將刪除後的該組資料呈現回傳
    }
}
