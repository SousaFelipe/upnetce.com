<?php
namespace App\Http\Controllers\Financeiro;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function auth(Request $request)
    {
        return view('financeiro.auth.login');
    }



    public function login(Request $request)
    {
        $intended = URL::previous();
        $credentials = $request->only(['email', 'password']);
        $auth = (Auth::attempt($credentials, $request->has('remember'))) ? true : false;

        if ($auth) {
            return $request->ajax() ? (
                response()->json([
                    'auth' => $auth,
                    'intended' => $intended,
                    'errors' => []
                ])
            ) : (
                redirect()->intended(URL::route('financeiro.dashboard'))
            );
        }

        return response()->json([
            'auth' => false,
            'intended' => $intended,
            'errors' => ['login' => __('auth.failed')]
        ]);
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/financeiro/auth');
    }
}
