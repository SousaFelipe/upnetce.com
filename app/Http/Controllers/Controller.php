<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function csrf(Request $request)
    {
        return $this->json(
            $request->session()->token(),
            'csrf_token'
        );
    }



    protected function csrfBroken($request)
    {
        $sessionToken = $request->session()->token();
        $headerToken = $request->header('X-CSRF-TOKEN');

        return (
            (is_null($sessionToken) || is_null($headerToken)) || ($sessionToken != $headerToken)
        );
    }



    protected function unauthorized($json = true)
    {
        return $json
            ? response()->json([ 401 => 'Unauthorized' ])
            : "View::";
    }



    protected function json($data, $name = false)
    {
        $response = self::convertRecursively($data);
        $dataName = ($name && is_string($name)) ? $name : false;

        return ($name != false)
            ? response()->json(["$dataName" => $response])
            : response()->json($response);
    }



    protected static function convertRecursively($data)
    {
        if (is_string($data)) {
            return utf8_encode($data);
        }
        elseif (is_array($data)) {
            $ret = [];
            foreach ($data as $i => $d) $ret[$i] = self::convertRecursively($d);
            return $ret;
        }
        elseif (is_object($data)) {
            foreach ($data as $i => $d) $data->$i = self::convertRecursively($d);
            return $data;
        }
        else {
            return $data;
        }
    }
}
