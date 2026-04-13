<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Periksa semua guard yang tersedia
        $guards = ['web', 'web2']; // Tambahkan guard lain jika diperlukan

        foreach ($guards as $guard) {
            $user = Auth::guard($guard)->user();

            // Cek jika user ada dan jika peran user ada dalam daftar yang diberikan untuk guard web
            if ($user) {
                if ($guard === 'web2' || in_array($user->role, $roles)) {
                    return $next($request);
                }
            }
        }

        dd("Kembali");
        // Jika tidak memenuhi syarat, arahkan ke halaman unauthorized
        return redirect('/unauthorized')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}