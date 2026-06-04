<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScopeToBranch
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role !== 'super-admin' && $user->branch_id) {
            app()->instance('current.branch_id', $user->branch_id);
        }

        return $next($request);
    }
}
