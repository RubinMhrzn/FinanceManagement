<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();

            $user = Auth::user();


            /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

            if ($user->role?->name === 'admin') {

                return redirect()
                    ->route('admin.dashboard')
                    ->with(
                        'success',
                        'Welcome back, Admin!'
                    );
            }


            /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

            if ($user->role?->name === 'manager') {

                return redirect()
                    ->route('manager.dashboard')
                    ->with(
                        'success',
                        'Welcome back, Manager!'
                    );
            }


            /*
        |--------------------------------------------------------------------------
        | Regular User
        |--------------------------------------------------------------------------
        */

            return redirect()
                ->route('dashboard')
                ->with(
                    'success',
                    'Welcome back!'
                );
        }


        /*
    |--------------------------------------------------------------------------
    | Login Failed
    |--------------------------------------------------------------------------
    */

        return back()
            ->withErrors([
                'email' => 'The provided credentials are incorrect.',
            ])
            ->onlyInput('email');
    }
    /*
    |--------------------------------------------------------------------------
    | Show Register
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign User Role
        |--------------------------------------------------------------------------
        */

        $role = Role::where('name', 'user')->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'role_id' => $role->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Login New User
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        // Prevent session fixation
        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Account created successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        // Destroy current session
        $request->session()->invalidate();

        // Generate a new CSRF token
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out.');
    }
}
