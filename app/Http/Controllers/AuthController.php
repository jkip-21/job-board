<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Handle the login attempt.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        Log::info('Login Attempt', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            Log::info('Authentication successful', ['user' => Auth::user()->id]);

            return redirect()->intended('/')->with('success', 'Logged in successfully!');
        }

        Log::warning('Authentication failed', ['email' => $credentials['email']]);

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.'
        ])->onlyInput('email');
    }

    /**
     * Logout the user.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }
}
