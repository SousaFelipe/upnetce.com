<?php
namespace App\Utils;


class Vetor
{
    public static function just(array $keys, $subject)
    {
        $array = (!is_array($subject)) ? ((array) $subject) : $subject;

        foreach ($array as $key => $value) {
            if (array_search($key, $keys) === false) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}
