<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 17.10.17
 * Time: 17:28
 */

namespace ActiveRecord;


use PDO;

class SQLBuilder
{
    private $table;

    private $query;

    /**
     * SQLBuilder constructor.
     * @param $table - Table name
     * @param $arguments - method arguments
     * @param $options - sql options
     */
    public function __construct($table)
    {
        $this->table = $table.'s';
    }


    public function select()
    {
        $this->query .= 'SELECT * FROM '.$this->table.' ';
        return $this;
    }

    public function where(string $sql){

        $this->query .='WHERE '.$sql;
        return $this;
    }

    public function insert($fields){

        $this->query .= 'INSERT INTO '.$this->table.'(';
        $this->generateInsert($fields);
        $this->query .= ')';
        return $this;
    }

    public function exec(array $arguments, bool $all){
        $stm = Connection::getInstance()->prepare($this->query);
        foreach ($arguments as $index=>$argument){
            if (!is_null($argument)) $stm->bindValue($index+1,$argument);
        }
        if ($stm->execute()){
            if ($all) {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $stm->fetch(PDO::FETCH_ASSOC);
            }
        } else{
            return null;
        }
    }

    public function delete()
    {
        $this->query .= 'DELETE FROM '.$this->table.' ';
        return $this;
    }

    private function generateInsert($fields){
        foreach ($fields as $key=>$value){
            $this->query .= $key.',';
        }
        $this->query = rtrim($this->query,",");
        $this->query .= ') VALUES (';
        foreach ($fields as $key=>$value){
            $this->query .= '?,';
        }
        $this->query = rtrim($this->query,",");
    }

    public function update($fields)
    {
        $this->query .= 'UPDATE '.$this->table.' SET ';
        foreach ($fields as $key=>$value){
            $this->query .= $key.'= ?,';
        }
        $this->query = rtrim($this->query,",");
        $this->query .= ' ';
        return $this;
    }

}