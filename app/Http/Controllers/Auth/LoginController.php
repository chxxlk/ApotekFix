<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    // INFO: menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // INFO: melakukan auth user
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // INFO: Cek apakah user ada
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Password atau Email tidak valid.',
            ])->withInput();
        }

        // INFO: Login user
        Auth::login($user);
        // INFO: Buat session dengan informasi tambahan
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('id', $user->id);
            $request->session()->put('email', $user->email);
            $request->session()->put('name', $user->name);
            $request->session()->put('phone_number', $user->phone_number);
            $request->session()->put('address', $user->address);

            // INFO: Buat cookie
            $cookie = cookie('user_login', $request->session()->put('name', $user->name), 60 * 24);

            // INFO: Redirect sesuai role
            return $this->redirectBasedOnRole($user->role)->withCookie($cookie);
        }
    }

    // INFO: Redirect sesuai role
    protected function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('users.dashboard');
            default:
                return redirect()->route('login')->with('error', 'Role tidak valid');
        }
    }
    // INFO: Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush(); // Menghapus semua data sesi
        $request->session()->invalidate(); // Menghentikan sesi saat ini
        $request->session()->regenerateToken(); // Menghasilkan token CSRF baru

        // Menghapus semua cookie
        foreach ($request->cookies->all() as $name => $value) {
            Cookie::queue(Cookie::forget($name));
        }
        return redirect()->route('welcome');
    }
}
