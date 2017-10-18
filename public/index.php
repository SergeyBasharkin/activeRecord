<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 15.10.17
 * Time: 15:07
 */

use Models\Something\User;

require_once __DIR__ . '/../vendor/autoload.php';

//dump(\ActiveRecord\User::$tableName);
//$user = User::find_by_id_or_name(1,null);
//dump($user);
//dump($user->delete());

$user = User::find_by_id(8);
$user->name = "da da2";
dump($user->save());