<?php
namespace DDEV;

class Utilities {
    /**
     * @param array $array
     * @param string $key
     */
    static public function pluck(array $array, string $key)
    {
        return array_map(function($v) use ($key) {
          return is_object($v) ? $v->$key : $v[$key];
        }, $array);
    }
}