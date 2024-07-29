<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLeaderMiddleware
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
        $leader = auth()->user();

        if (!$leader->leader_login) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }

        return $next($request);
    }
}
