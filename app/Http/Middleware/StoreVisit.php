<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;

class StoreVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ip    = $request->ip();
        $visit = Visit::query()
            ->where('ip', $ip)
            ->whereBetween('created_at', [
                now()->startOfDay(),
                now()->endOfDay(),
            ])
            ->first();

        if (! $visit) {
            Visit::create(['ip' => $ip]);
        }

        return $next($request);
    }
}
