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
        $token = $request->header('Authorization');

        if (Session::isInvalid($token)) {
            return false;
        }

        $user = User::where('ixc_token', $token)->first();

        return $user;
    }



    public function name()
    {
        return $this->name;
    }



    public function email()
    {
        return $this->email;
    }
}
