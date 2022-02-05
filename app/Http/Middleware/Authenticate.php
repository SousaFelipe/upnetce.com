<?php
namespace App\Http\Middleware;


use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if ( ! Auth::check()) {
            return redirect()->route('financeiro.auth')->with('login', 'Erro de autenticação.');
        }

        return $next($request);
    }



    protected function redirectTo($request)
    {
        if ( ! $request->expectsJson()) {
            return route('login');
        }
    }
}
