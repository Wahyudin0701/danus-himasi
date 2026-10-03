<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode;
use Symfony\Component\HttpFoundation\Response;

class CheckActivePeriode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $activePeriode = Periode::active();
            
            if (!$activePeriode || Auth::user()->periode_id !== $activePeriode->id) {
                // Allow them to visit the inactive page or logout route
                if (!$request->routeIs('inactive.periode') && !$request->routeIs('logout')) {
                    return redirect()->route('inactive.periode');
                }
            } else {
                // If they are in the active periode but try to access the inactive page, redirect to dashboard
                if ($request->routeIs('inactive.periode')) {
                    return redirect()->route('dashboard');
                }
            }
        }

        return $next($request);
    }
}
