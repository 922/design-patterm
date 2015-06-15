<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/14
 * Time: 0:41
 */
//抽象接口
interface Prototype{public function copy();}
//具体原型
class ConcretePrototype implements  Prototype{
    private  $name;

    function __construct($name){$this->name=$name;}
    public  function copy(){
        return clone $this;//深拷贝
//        return  $this;//浅拷贝
    }
}
//原型类的属性，进行深浅拷贝时有区别
class Demo {}

// 客户端
$demo = new Demo();
$object1 = new ConcretePrototype($demo);
$object2 = $object1->copy();