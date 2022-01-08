<?php
namespace App\Http\Middleware;


use Closure;

use App\Models\Session;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $headerToken = $request->header('authentication');

        if (( ! $headerToken) || Session::isInvalid($headerToken)) {
            return Controller::unauthorized();
        }

        return $next($request);
    }
}
