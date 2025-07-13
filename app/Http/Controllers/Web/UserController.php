<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Show user registration form
     */
    public function showRegistrationForm()
    {
        return view('web.auth.register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'phone' => 'required|string|max:20|regex:/^[+]?[0-9\s\-\(\)]+$/',
            'date_of_birth' => 'required|date|before:' . now()->subYears(13)->format('Y-m-d'),
            'gender' => 'required|in:male,female,other',
            'terms' => 'required|accepted',
        ], [
            'name.regex' => 'Name should only contain letters and spaces.',
            'email.confirmed_email' => 'Please enter a valid email address.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'phone.regex' => 'Please enter a valid phone number.',
            'phone.required' => 'Phone number is required.',
            'date_of_birth.before' => 'You must be at least 13 years old to register.',
            'date_of_birth.required' => 'Date of birth is required.',
            'gender.required' => 'Please select your gender.',
            'terms.required' => 'You must accept the Terms of Service and Privacy Policy.',
            'terms.accepted' => 'You must accept the Terms of Service and Privacy Policy.',
        ]);

        // Additional business logic validation
        if ($request->phone && !$this->isValidPhoneNumber($request->phone)) {
            return back()->withErrors(['phone' => 'Please enter a valid phone number.'])
                        ->withInput();
        }

        $user = User::create([
            'name' => ucwords(strtolower(trim($request->name))),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'phone' => $this->formatPhoneNumber($request->phone),
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'role' => User::ROLE_USER,
            'is_active' => true,
            'email_verified_at' => now(), // Auto-verify for now, implement email verification later
        ]);

        // Log the registration
        Log::info('New user registered', [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        Auth::login($user, true); // Remember the user

        // Send welcome email (you can implement this later)
        // $this->sendWelcomeEmail($user);

        return redirect()->route('web.view.index')
                         ->with('success', 'Welcome to Taysan & Co! Your account has been created successfully.');
    }

    /**
     * Validate phone number format
     */
    private function isValidPhoneNumber($phone)
    {
        // Remove all non-digit characters except +
        $cleaned = preg_replace('/[^\d+]/', '', $phone);
        
        // Check if it's a valid international format
        if (preg_match('/^\+[1-9]\d{6,14}$/', $cleaned)) {
            return true;
        }
        
        // Check if it's a valid local format (10-15 digits)
        if (preg_match('/^\d{10,15}$/', $cleaned)) {
            return true;
        }
        
        return false;
    }

    /**
     * Format phone number for storage
     */
    private function formatPhoneNumber($phone)
    {
        // Remove all non-digit characters except +
        $cleaned = preg_replace('/[^\d+]/', '', $phone);
        
        // If no country code, assume it's a local number
        if (!str_starts_with($cleaned, '+')) {
            return $cleaned;
        }
        
        return $cleaned;
    }

    /**
     * Send welcome email to new user
     */
    private function sendWelcomeEmail($user)
    {
        // Implement welcome email functionality
        // Mail::to($user->email)->send(new WelcomeEmail($user));
    }

    /**
     * Show user login form
     */
    public function showLoginForm()
    {
        return view('web.auth.login');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact support.',
                ]);
            }

            // Regenerate session ID for security
            $request->session()->regenerate();
            
            // Set a longer session lifetime if remember me is checked
            if ($remember) {
                // Remember for 30 days
                config(['session.lifetime' => 43200]); // 30 days in minutes
            }

            return redirect()->intended(route('web.view.index'))
                             ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('web.view.index')
                         ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        $user->loadCount(['orders', 'reviews']);
        return view('web.user.profile', compact('user'));
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('web.user.edit-profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['avatar']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('web.user.profile')
                         ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        return view('web.user.change-password');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('web.user.profile')
                         ->with('success', 'Password updated successfully.');
    }

    /**
     * Show user's orders
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['orderItems.product'])->orderBy('created_at', 'desc')->paginate(10);
        
        return view('web.user.orders', compact('orders'));
    }

    /**
     * Show user's reviews
     */
    public function reviews()
    {
        $user = Auth::user();
        $reviews = $user->reviews()->with('product')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('web.user.reviews', compact('reviews'));
    }

    /**
     * Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'The password is incorrect.',
            ]);
        }

        // Delete avatar
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();
        $user->delete();

        return redirect()->route('web.view.index')
                         ->with('success', 'Your account has been deleted successfully.');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('web.auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show password reset form
     */
    public function showResetForm($token)
    {
        return view('web.auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('web.user.login.form')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
