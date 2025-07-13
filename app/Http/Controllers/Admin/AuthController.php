<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt authentication
        if (!auth()->attempt($validated)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        $user = auth()->user();

        // Check if user has admin role
        if ($user->role !== User::ROLE_ADMIN) {
            Auth::logout(); // Logout non-admin user
            return back()->withErrors(['email' => 'Access denied. Admin privileges required.'])->withInput();
        }

        // Check if admin user is active
        if (!$user->is_active) {
            Auth::logout(); // Logout inactive user
            return back()->withErrors(['email' => 'Your account has been deactivated. Please contact support.'])->withInput();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
