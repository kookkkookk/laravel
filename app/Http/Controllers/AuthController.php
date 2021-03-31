<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 登入的套件
use App\Http\Requests\CreateUser; // vaildation
use App\Models\User; // model

class AuthController extends Controller
{
    public function signup(CreateUser $request) {
        $validatedData = $request -> validated(); // 要經過驗證
        // 使用建構方式先將資料建起來
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // bcrypt('字串') 會讓該文字變成視覺無法辨識的值 (安全性)
        ]);

        $user -> save();
        return response('success', 201); // 201 為成功建立資源的狀態碼
    }

    // 登入部分驗證就沒有特別轉到 validation Request, 在該 function 裡驗證， 所以用一般 Request
    public function login(Request $request) {
        $validatedData = $request -> validate([ // 注意這邊是 validate 沒有 d 結尾
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        // attempt 是登入套件的一個涵式，把參數丟進去會自動去該 Table user 檢查是否通過
        // dd($request -> user()); // 如果登入沒成功就取得該user資料，就會得到 null
        if (!Auth::attempt($validatedData)) {
            return response('授權失敗', 401); // 401 代表有帳密錯等等的錯誤
        }
        // 如果登入驗證成功，就會把該user的 data row 會傳自 $request, 並且可以用 ->user() 取得
        $user = $request -> user();
        // dd($user);

        $tokenResult = $user -> createToken('Token'); //建立通行證
        dump($tokenResult);
        $tokenResult -> token -> save(); // 將產生出來的 token 存進資料庫，未來使用者做一些api動作時就可以驗證
        return response(['token' => $tokenResult -> accessToken]); // 將 accessToken 回傳給前端
    }

    public function logout(Request $request) {
        // -> user() ->token() 這樣可以拿到該 user 相關的 accessToken
        // -> revoke() 是讓該 accessToke 強制過期
        $request -> user() -> token() -> revoke();
        return response(['message' => '成功登出']);
    }

    public function user(Request $request) {
        return response($request -> user());
    }
}
