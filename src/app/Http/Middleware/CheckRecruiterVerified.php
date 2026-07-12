<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRecruiterVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->isRecruiter() && $user->recruiter_status !== 'verified') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Akun recruiter Anda belum diverifikasi oleh admin. Silakan tunggu konfirmasi.',
                ]);
        }

        return $next($request);
    }
}