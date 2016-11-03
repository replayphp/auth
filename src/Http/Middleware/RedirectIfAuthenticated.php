<?php

namespace Replay\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = "replay")
    {
        if (app("auth")->guard($guard)->check()) {
            return redirect(config(
                "replay.auth.redirects.authenticated", "replay"
            ));
        }

        return $next($request);
    }
}
