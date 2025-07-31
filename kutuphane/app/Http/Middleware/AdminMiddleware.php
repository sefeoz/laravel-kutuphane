<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Giriş yapmanız gerekiyor.');
        }
        if(Auth::check() && Auth::user()->role === 'admin'){
            return $next($request);
        }
        return redirect()->route('dashboard')->with('error', 'Bu sayfaya erişim yetkiniz yok. Sadece admin kullanıcıları erişebilir.');
                    
    }
}
