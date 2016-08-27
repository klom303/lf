<?php
/**
 * Created by PhpStorm.
 * User: yejialu
 * Date: 16/8/27
 * Time: 15:04
 */
namespace App\Models;

use Frame\Database\DB;
use Frame\Model;

class User extends Model
{
    public static function getLogin($username,$password)
    {
        $user = DB::table('user')->where('username','=',$username)->select('*');
        if(empty($user)){
            return false;
        }
        $user = $user[0];
        $password = sha1($password.$user['salt']);
        if($password != $user['password']){
            return false;
        }
        return $user;
    }

    public static function register($username,$password,$email='')
    {
        $salt = substr(md5(time()),0,16);
        $password = sha1($password.$salt);
        return DB::table('user')->insert([
            'username'=>$username,
            'password'=>$password,
            'salt'=>$salt,
            'email'=>$email
        ]);
    }
}