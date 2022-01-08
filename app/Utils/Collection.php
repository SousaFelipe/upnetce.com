<?php
namespace App\Utils;


class Collection
{
    private $collection = null;



    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }



    public static function create(array $data, string $classname)
    {
        $classvars = get_class_vars($classname);
        $objects = [];

        if (count($data) > 0) {
            foreach ($data as $record) {

                $obj = new $classname;

                foreach ($classvars as $vname => $vval) {
                    $obj->$vname = isset($record[$vname]) ? $record[$vname] : null;
                }

                $objects[] = $obj;
            }
        }

        return new self($objects);
    }



    public function get($index)
    {
        if ($index < 0 || is_null($this->collection) || count($this->collection) <= 0)
            return null;

        return $this->collection[$index];
    }



    public function first()
    {
        if (is_null($this->collection) || count($this->collection) <= 0) {
            return null;
        }

        return $this->collection[0];
    }



    public function last()
    {
        $ccount = count($this->collection);

        if (is_null($this->collection) || $ccount <= 0) {
            return null;
        }

        return $this->collection[$ccount - 1];
    }



    public function all()
    {
        return $this->collection;
    }
}
