<?php

namespace App\Http\Middleware;

use App\Keys;
use Closure;

class APIKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->tkn == null) {
            $res['status'] = false;
            $res['message'] = "Provide API Key!";
            return response($res);
        } else {
            $key = Keys::where('key', $request->tkn)->count();
            if ($key != 1) {
                $res['status'] = false;
                $res['message'] = "Invalid API Key!";
                return response($res);
            } else {
                return $next($request);
            }
        }
    }
}
