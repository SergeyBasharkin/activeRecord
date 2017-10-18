<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.10.17
 * Time: 19:55
 */

namespace ActiveRecord;


class DataBinder
{
    public static function bindValuesArr(array $values, $class){
        $arr = array();
        foreach ($values as $value){
            $cl = new $class;
            self::bind($value, $cl);
            array_push($arr, $cl);
        }
        return $arr;
    }

    public static function bindValues(array $values, $class)
    {
        $cl = new $class;
        self::bind($values, $cl);
        return $cl;
    }

    private static function bind(array $values, &$class){
        foreach ($values as $key => $field){
            $class->$key = $field;
        }
    }
}