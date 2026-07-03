<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class verifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {

            JWTAuth::parseToken()->authenticate();

        } catch (TokenInvalidException $e) {

            return response()->json([
                'message' => 'Token is Invalid'
            ],401);

        } catch (TokenExpiredException $e) {

            return response()->json([
                'message' => 'Token Expired'
            ],401);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Authorization Token not found'
            ],401);

        }

        return $next($request);
    }
}