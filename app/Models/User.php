<?php
namespace App\Models;


use App\Models\Session;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;


class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    
    protected $hidden = [
        'password',
    ];



    public static function auth(Request $request)
    {
        $token = $request->header('authentication');

        if ( ! Session::isInvalid($token)) {
            $user = User::where('ixc_token', $token);
            return $user;
        }

        return false;
    }
}
