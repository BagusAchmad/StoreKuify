<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectUser(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $loginInput = trim($request->input('email') ?: $request->input('login'));

        if (empty($loginInput)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau username wajib diisi.',
            ]);
        }

        $request->validate([
            'password' => ['required'],
        ]);

        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Verify if user is active
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'email' => 'Akun kasir Anda sedang dinonaktifkan. Silakan hubungi Owner.',
                ]);
            }

            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            return $this->redirectUser($user);
        }

        throw ValidationException::withMessages([
            'email' => 'Email/username atau kata sandi yang Anda masukkan salah.',
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect the user based on their role.
     */
    protected function redirectUser($user)
    {
        if ($user->isOwner()) {
            return redirect()->intended(route('owner.dashboard'));
        }

        if ($user->isKasir()) {
            return redirect()->intended(route('kasir.dashboard'));
        }

        // Default fallback
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Peran pengguna tidak dikenali.',
        ]);
    }
}
