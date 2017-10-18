<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 15.10.17
 * Time: 15:16
 */

namespace ActiveRecord;


use ReflectionClass;

class Model
{
    protected static $tableName;



    public static function __callStatic($name, $arguments)
    {
        self::setTableName();
        $builder = new SQLBuilder(self::$tableName);
        if (substr($name, 0, 12) === 'find_all_by_') {
            $options = substr($name, 12);
            $stm = $builder->select()->where(Utils::to_sql($options, $arguments));
            return DataBinder::bindValuesArr($stm->exec($arguments, true), get_called_class());
        }

        if (substr($name, 0, 8) === 'find_by_'){
            $options = substr($name, 8);
            $stm = $builder->select()->where(Utils::to_sql($options, $arguments));
            return DataBinder::bindValues($stm->exec($arguments, false), get_called_class());
        }
    }

    public function __get($name)
    {

        return $this->$name;
    }

    public function __set($name, $value)
    {

        $this->$name = $value;
    }

    public function delete()
    {
        self::setTableName();
        $builder = new SQLBuilder(self::$tableName);
        $fetch =$builder->delete()->where("id = ?")->exec(array($this->id),false);
        return $fetch;
    }

    public function save(){
        self::setTableName();
        $builder = new SQLBuilder(self::$tableName);
        if (isset($this->id)){
            $vars = Utils::varsAsArray($this);
            return $builder->update(get_object_vars($this))->where("id = ".$this->id)->exec($vars,false);
        }else{
            return $builder->insert(get_object_vars($this))->exec(get_object_vars($this), false);

        }
    }

    public static function setTableName(){
        if (!isset(self::$tableName)) {
            $name =explode('\\',get_called_class() );
            $table = strtolower(array_pop($name));
            self::$tableName = $table;
        }
    }
}