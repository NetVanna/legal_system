<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /** Show the login page */
    public function login()
    {
        return view('auth.login');
    }

    /** Authenticate the user */
    public function authenticate(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_id';

        $credentials = [
            $loginType => $request->input('login'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $todayDate = now();

            // info_details is already an array thanks to $casts
            $infoDetails = $user->info_details ?? [];

            Session::put([
                'name'          => $user->name,
                'email'         => $user->email,
                'user_id'       => $user->id,
                'joining_date'  => $user->joining_date,
                'last_login'    => $todayDate,
                'phone'         => $user->phone,
                'address'       => $user->address,
                'role'          => $user->role,
                'profile'       => $user->profile,
                'position'      => $infoDetails['position'] ?? null,
                'department_id' => $user->department_id,
            ]);

            flash()->success('Login successful :)');
            // Role-based redirect
            return $this->redirectBasedOnRole($user->role);
        } else {
            flash()->error('Wrong username/email or password.');
            return redirect()->back();
        }
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectBasedOnRole(string $role)
    {
        return match ($role) {
            'admin' => redirect()->intended('home'),
            'criminal' => redirect()->intended('criminal/home'),
            'civil' => redirect()->intended('civil/home'),
            'protection' => redirect()->intended('protection/home'),
            'outcourt' => redirect()->intended('outcourt/home'),
            'contract' => redirect()->intended('contract/home'),
            'sop' => redirect()->intended('sop/home'),
            'protectbusiness' => redirect()->intended('businessprotection/home'),
            'protectfamily' => redirect()->intended('familyprotection/home'),
            'protectindividual' => redirect()->intended('individualprotection/home'),
            default => redirect()->intended('home')
        };
    }


    /** Show logout page */
    public function logoutPage()
    {
        return view('auth.logout');
    }

    /** Logout and forget session */
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        flash()->success('Logout successful :)');
        return redirect('logout/page');
    }
}
