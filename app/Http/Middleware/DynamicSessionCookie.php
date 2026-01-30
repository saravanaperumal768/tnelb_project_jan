<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DynamicSessionCookie
{
    public function handle(Request $request, Closure $next)
    {
        // Example logic based on route prefix
        if ($request->is('admin/*')) {
            config(['session.cookie' => 'admin_session']);
        } else {
            config(['session.cookie' => 'user_session']);
        }

        return $next($request);
    }
}
