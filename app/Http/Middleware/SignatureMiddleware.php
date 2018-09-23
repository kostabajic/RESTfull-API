<?php

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $header_name = 'X-Name')
    {
        $response = $next($request);
        $response->headers->set($header_name, config('app.name'));

        return $response;
    }
}
