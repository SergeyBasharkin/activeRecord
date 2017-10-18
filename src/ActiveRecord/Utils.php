<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 16.10.17
 * Time: 20:57
 */

namespace ActiveRecord;


class Utils
{
    public static function to_sql(string $options, array $arguments)
    {
        $where = '';
        /** @var array $optionsArray */
        $optionsArray = explode("_", $options);
        for ($i = 0, $j = 0; $i < count($optionsArray); $i += 2, $j++) {
            $opt =($i + 1 >= count($optionsArray)) ?'': $optionsArray[$i + 1] . ' ';
            if (is_null($arguments[$j])) {
                $where .= $optionsArray[$i] . ' IS NULL '.$opt;

            } else {
                $where .= $optionsArray[$i] . ' = ' . '? '.$opt;
            }
        }
        return $where;
    }

    public static function varsAsArray($class)
    {
        $vars = array();
        foreach (get_object_vars($class) as $val){
            array_push($vars,$val);
        }
        return $vars;
    }
}