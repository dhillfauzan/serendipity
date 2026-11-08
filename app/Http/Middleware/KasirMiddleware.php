<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KasirMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role == 2) {
            // Daftar route yang diizinkan untuk kasir
            $allowedRoutes = [
                'backend.beranda',
                'backend.produk.index',
                'kasir.index',
                'laporan.index',
                'backend.orders.index',
                'backend.logout'
            ];
            
            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}