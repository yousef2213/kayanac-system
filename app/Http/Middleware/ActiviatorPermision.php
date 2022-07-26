<?php

namespace App\Http\Middleware;

use App\TermsReference;
use Closure;

class ActiviatorPermision
{


    public function handle($request, Closure $next)
    {
        $item = TermsReference::all()->first();
        if ($item->movements == 0) {
            return redirect()->route('home')->with('msg', "السيستم غير مفعول من فضلك اتصل باحد عملاء الدعم الفني");
        }

        return $next($request);
    }
}
