<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends APIRequest // 這邊一樣換成之前做的 APIRequest 讓他繼承該 failedValidation 功能
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 這個先改成 true, 這邊目前還用不到
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users', //email 限制email格式, unique 限制唯一
            'password' => 'required|string|confirmed',
            // confirmed 傳來的 key 必須要有 password、password_confirmation 這兩個 value 要一樣
        ];
    }
}
