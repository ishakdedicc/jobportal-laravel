<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = $request->user();

        $user->tokens()->delete();

        $token = $user->createToken('web-app')->plainTextToken;

        $request->session()->put('api_token', $token);

        return redirect()
            ->intended(route('home'))
            ->with('success', 'You are now logged in!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
        }

        Auth::logout();

        $request->session()->forget('api_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'))
            ->with('success', 'You are now logged out.');
    }
}
