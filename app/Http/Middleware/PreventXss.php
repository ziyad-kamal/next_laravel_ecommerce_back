<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventXss
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $inputs = $request->input();

        if ($inputs != []) {
            array_walk_recursive(
                $inputs,
                function (&$input) { // Pass by reference
                    $input = strip_tags($input);
                }
            );

            $request->merge($inputs);
        }

        return $next($request);
    }
}
