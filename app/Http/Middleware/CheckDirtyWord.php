<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDirtyWord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $dirtyWords = ['fuck', 'crap', 'asshoke', 'bitch'];
        $parameters = $request -> all(); // 捕捉傳送的內容

        foreach ($parameters as $key => $value) {
            if ($key == 'content') { // 只檢查 key 為 content
                foreach ($dirtyWords as $word) {
                    // strpos 類似於 indexof(), strpos('參數1: 要檢查的val', '參數2: 要檢查的字是什麼'); 如果有回傳位置號碼，沒有則false
                    if (strpos($value, $word) !== false) {
                        return response('This content includes DIRTY WORD!', 400);
                    }
                }
            }
        }

        return $next($request);
    }
}
