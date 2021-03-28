<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// class UpdateCartItem extends FormRequest
class UpdateCartItem extends APIRequest // 由於是獨立的 管理的 validation API, 所以並沒有可以回船上一層，這邊就做一個 APIRequest 去接。另外 APIRequest 是同一層所以不用 use
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 這邊先設定成 true, 這是做授權驗證用的，目前還沒用到
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() // 規則定義
    {
        return [
            'quantity' => 'required|integer|between:1,10'
        ];
    }

    public function messages() // 如果有這個 messages function Laravel 就會自己套用該自定義的錯誤回傳
    {
        return [
            'quantity.between' => '您更新購買的數量為 :input 項，最少購買 :min 項 ; 最多購買 :max 項'
        ];
    }
}
