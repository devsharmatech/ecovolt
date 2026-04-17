<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:Admin,Dealer,Accounts'
        ]);

        $requestedRole = strtolower($request->role);

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Verify if user actually has the requested role
            if (!$user->hasRole($requestedRole)) {
                Auth::logout();
                return redirect()->route('login')->with('error', "Your account is not registered as a {$request->role}.");
            }

            Log::info('Login successful', [
                'user_id' => $user->id,
                'role'    => $requestedRole,
            ]);

            // ROLE-BASED REDIRECTION
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
            }

            if ($user->hasRole('dealer')) {
                return redirect()->route('dealer.dashboard')->with('success', 'Welcome Dealer!');
            }

            if ($user->hasRole('accounts')) {
                return redirect()->route('accounts.dashboard')->with('success', 'Welcome Accounts!');
            }

            // If no valid role found matching the redirection
            Auth::logout();
            return redirect()->route('login')->with('error', 'Unauthorized role access!');
        }
        else
        {

        }

        Log::warning('Login failed', ['email' => $request->email]);
        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

}
