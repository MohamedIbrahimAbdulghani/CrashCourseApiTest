<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LangSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the 'lang' parameter is present in the request and set the application locale accordingly
        if(isset($request->lang) && $request->lang == "ar") {
            app()->setLocale("ar");
        }
        return $next($request);
    }
}
