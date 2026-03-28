<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Register Form
    |--------------------------------------------------------------------------
    */
    public function showRegister()
    {
        // View file: resources/views/register.blade.php
        // If yours is inside an auth folder, change to: view('auth.register')
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | Handle Registration
    | ✅ Does NOT auto-login after registration.
    |    Redirects to the LOGIN page with a success flash message.
    |    This prevents the guest middleware from blocking the register page
    |    and avoids any DashboardController errors for new users.
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:admin,manager,user'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // ✅ Redirect to login — NOT dashboard.
        // The login page SweetAlert will show this success message.
        return redirect()
            ->route('login')
            ->with('register_success', 'Account created successfully! Please sign in to continue.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show Login Form
    |--------------------------------------------------------------------------
    */
    public function showLogin()
    {
        // View file: resources/views/login.blade.php
        // If yours is inside an auth folder, change to: view('auth.login')
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Handle Login
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $redirectTo = match($user->role) {
                'admin', 'manager' => route('manager.dashboard'),
                default            => route('dashboard'),
            };

            return redirect($redirectTo)
                ->with('login_success', 'Welcome back, ' . $user->name . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('logout_success', 'You have been logged out successfully.');
    }
}