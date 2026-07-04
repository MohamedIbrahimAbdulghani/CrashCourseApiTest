<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->api_password != env('API_PASSWORD')) {
            return response()->json([
                'message' => trans('messages.Unauthenticated')
            ], 500);
        }
        return $next($request);
    }
}