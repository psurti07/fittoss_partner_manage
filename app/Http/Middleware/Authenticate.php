<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards): Response
    {
        $this->authenticate($request, $guards);
        $user = Auth::user();

        if ($user->is_delete == 1) {
            Auth::logout();
            return redirect()->route('manage.auth');
        }

        $companyId = $user->company_id;
        $request->merge([
            'company_id' => $companyId
        ]);

        /*
        |--------------------------------------------------------------------------
        | Add Into Service Container
        | app('company_id')
        |--------------------------------------------------------------------------
        */
        app()->instance('company_id', $companyId);

        return $next($request);
    }

    /**
     * Get redirect path when unauthenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson()
            ? null
            : route('manage.auth');
    }
}