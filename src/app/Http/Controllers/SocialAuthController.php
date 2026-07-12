<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        abort_unless($provider === 'google', 404);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        abort_unless($provider === 'google', 404);

        $socialUser = Socialite::driver($provider)->user();

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(32)),
                'avatar_url' => $socialUser->getAvatar(),
                'recruiter_status' => null,
                'is_active' => true,
            ]);

            $user->assignRole('pelamar');
        }

        Auth::login($user);

        request()->session()->regenerate();

        return app(AuthController::class)->redirectByRole();
    }
}
