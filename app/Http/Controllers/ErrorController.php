<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;


class ErrorController extends Controller
{
    public static function unauth($json = true)
    {
        return $json
            ? response()->json([ 401 => 'Unauthorized' ])
            : "View::";
    }
}
