<?php

namespace App\Http\Middleware;

use App\Powers;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermision
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $name_page = '')
    {

        $id = Auth::user()->id;
        $power = Powers::where('user_id', $id)->first();
        if ($power[$name_page] == 0) {
            return redirect()->route('home')->with('msg', 'ليس لديك صلاحية لفتح الشاشة');
        } else {
        }
        return $next($request);
    }
}
