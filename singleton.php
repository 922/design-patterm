<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/14
 * Time: 0:41
 */
class Singleton{
    static $instance;

    private function __construct(){}
    public static function getInstance(){
        if(!self::$instance instanceof Singleton){
            self::$instance=new Singleton();
        }
        return self::$instance;
    }
    final function __clone(){}
}