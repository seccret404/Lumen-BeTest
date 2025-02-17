<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class RequestLog
{


    public function handle($request, Closure $next)
    {
        Log::info('Request Info : ', [
            'method'    => $request->method(),
            'url'       => $request->fullUrl(),
            'body'      => $request->all()
        ]);
        return $next($request);
    }
}
