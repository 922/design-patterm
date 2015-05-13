<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/12
 * Time: 23:34
 * 工厂模式可以分为三类：
 * 1）简单工厂模式（Simple Factory）
 * 2）工厂方法模式（Factory Method）
 * 3）抽象工厂模式（Abstract Factory）
 * 这三种模式从上到下逐步抽象，并且更具一般性。
 * GOF在《设计模式》一书中将工厂模式分为两类：工厂方法模式（Factory Method）与抽象工厂模式（Abstract Factory）。
 * 将简单工厂模式（Simple Factory）看为工厂方法模式的一种特例，两者归为一类。
 * 工厂方法模式：
 * 一个抽象产品类，可以派生出多个具体产品类。
 * 一个抽象工厂类，可以派生出多个具体工厂类。
 * 每个具体工厂类只能创建一个具体产品类的实例。
 * 抽象工厂模式：
 * 多个抽象产品类，每个抽象产品类可以派生出多个具体产品类。
 * 一个抽象工厂类，可以派生出多个具体工厂类。
 * 每个具体工厂类可以创建多个具体产品类的实例。
 * 区别：
 * 工厂方法模式只有一个抽象产品类，而抽象工厂模式有多个。
 * 工厂方法模式的具体工厂类只能创建一个具体产品类的实例，而抽象工厂模式可以创建多个。
 * 两者皆可。
 *
 * 以下三种方法 PHP中最常用的还是第一种 简单工厂模式 虽然其违背了开闭原则
 * 其次是第三种 可以创建多个产品实例
 * 应该避免使用第二种  基本上没啥用 还是没有解决开闭原则的问题 反而增加了多余的类
 */

/**
 * simple factory
 */

//产品
abstract class BMW{
    function __construct(){}
}
class X3 extends BMW{}
class X5 extends BMW{}
//工厂
class BMWFactory{
    static public function createBMW($type){
        switch($type){
            case 'x3':
                return new X3();
            case 'x5':
                return new X5();
        }
    }
}
//client
$factory=new BMWFactory();
var_dump($factory::createBMW('x3'));

/**
 * factory method
 */
//产品
abstract class BMW2{
    function __construct(){}
}
class X32 extends BMW2{}
class X52 extends BMW2{}
//工厂
interface BMWFactory2{
    function createBMW();
}
class BMWX3Factory implements BMWFactory2{
    function createBMW(){
        return new X32();
    }
}
class BMWX5Factory implements BMWFactory2{
    function createBMW(){
        return new X52();
    }
}
//客户
class Client2{
    function operation($type){
        switch($type){
            case 'x3':
                $x3=new BMWX3Factory();
                return $x3->createBMW();
            case 'x5':
                $x5=new BMWX5Factory();
                return $x5->createBMW();
        }
    }
}
$factory2=new Client2();
var_dump($factory2->operation('x3'));

/**
 * abstract factory
 */
//产品
abstract class BMW3{}
class X33 extends BMW{}
class X53 extends BMW{}
abstract class Audi{}
class Q5 extends Audi{}
class Q7 extends Audi{}
//工厂
interface CarFactory{
    function createBMW();
    function createAudi();
}
class FactoryLower implements CarFactory{
    function createBMW(){
        return new X33();
    }
    function createAudi(){
        return new Q5();
    }
}
class FactoryHigh implements CarFactory{
    function createBMW(){
        return new X53();
    }
    function createAudi(){
        return new Q7();
    }
}
//客户
class client3{
    function getCar($type){
        $factory=new ReflectionClass('Factory'.$type);
        $instance=$factory->newInstance();
        $this->BMW=$instance->createBMW();
        $this->Audi=$instance->createAudi();
    }
}
$factory3=new client3();
$factory3->getCar('Lower');
var_dump($factory3->BMW);
var_dump($factory3->Audi);
