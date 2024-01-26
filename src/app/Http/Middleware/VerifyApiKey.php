<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customAppKey = $request->header('X-API-KEY');
        if ($customAppKey !== env('API_KEY')) {
            return response()->json(['error' => 'Unauthorized - Invalid api key'], 401);
        }

        return $next($request);
    }
}
