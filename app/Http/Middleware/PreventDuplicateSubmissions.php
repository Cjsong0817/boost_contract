<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class PreventDuplicateSubmissions
{
    public function handle($request, Closure $next)
    {
        $key = $this->getRequestKey($request);

        if (Cache::has($key)) {
            return response()->json(['message' => 'Duplicate request detected'], 429);
        }

        Cache::put($key, true, 4); // 10秒钟的去重窗口

        return $next($request);
    }

    protected function getRequestKey($request)
    {
        return sha1($request->fullUrl() . '|' . json_encode($request->all()));
    }
}
