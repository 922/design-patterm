<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/18
 * Time: 22:42
 *
 * 相对于其它模式，Flyweight模式在PHP实现似乎没有太大的意义，
 * 因为PHP的生命周期就在一个请求，请求执行完了，php占用的资源都被释放。
 * 只是为了学习而学习
 */
// 抽象享元角色
abstract class Flyweight {
    /**
     * @param string $state 外部状态
     */
    abstract public function operation($state);
}
// 具体享元角色
class ConcreteFlyweight extends Flyweight {
    private $_intrinsicState = null;
    public function __construct($state) {$this->_intrinsicState = $state;}
    public function operation($state) {
        echo 'ConcreteFlyweight operation, Intrinsic State = ' . $this->_intrinsicState
            . ' Extrinsic State = ' . $state . '<br />';
    }
}
//不共享的具体享元，客户端直接调用
class UnsharedConcreteFlyweight extends Flyweight {
    private $_flyweights;
    public function __construct() {$this->_flyweights = array();}
    public function operation($state) {
        foreach ($this->_flyweights as $flyweight) {
            $flyweight->operation($state);
        }
    }
    public function add($state, Flyweight $flyweight) {$this->_flyweights[$state] = $flyweight;}
}

// 享元工厂角色
class FlyweightFactory {
    private $_flyweights;
    public function __construct() {$this->_flyweights = array();}
    public function getFlyweigth($state) {
        if (is_array($state)) { //  复合模式
            $uFlyweight = new UnsharedConcreteFlyweight();
            foreach ($state as $row) {
                $uFlyweight->add($row, $this->getFlyweigth($row));
            }
            return $uFlyweight;
        } else if (is_string($state)) {
            if (isset($this->_flyweights[$state])) {
                return $this->_flyweights[$state];
            } else {
                return $this->_flyweights[$state] = new ConcreteFlyweight($state);
            }
        } else {
            return null;
        }
    }
}
//客户
class Client{
    static function main (){
        $flyweightFactory = new FlyweightFactory();
        $flyweight = $flyweightFactory->getFlyweigth('state A');
        $flyweight->operation('other state A');
        $flyweight = $flyweightFactory->getFlyweigth('state B');
        $flyweight->operation('other state B');
        /* 复合对象*/
        $uflyweight = $flyweightFactory->getFlyweigth(array('state A', 'state B'));
        $uflyweight->operation('other state A');
    }
}
/**
 * 享元模式是一个考虑系统性能的设计模式，通过使用享元模式可以节约内存空间，提高系统的性能。
 *
 * 享元模式的核心在于享元工厂类，享元工厂类的作用在于提供一个用于存储享元对象的享元池，
 * 用户需要对象时，首先从享元池中获取，如果享 元池中不存在，
 * 则创建一个新的享元对象返回给用户，并在享元池中保存该新增对象。
 *
 * 享元模式以共享的方式高效地支持大量的细粒度对象，享元对象能做到共享的关键是区
 * 分内部状态(Internal State)和外部状态(External State)。
 * 内部状态是存储在享元对象内部并且不会随环境改变而改变的状态，因此内部状态可以共享。
 * 外部状态是随环境改变而改变的、不可以共享的状态。
 * 享元对象的外部状态必须由客户端保存，并在享元对象被创建之后，在需要使用的时候
 * 再传入到享元对象内部。一个外部状态与另一个外部状态之间是相互独立的。
 *
 */