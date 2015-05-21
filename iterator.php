<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/21
 * Time: 20:02
 *
 * 迭代器模式
 * 在PHP中的迭代器模式得到了官方的肯定，结果就是 SPL库 以下的实例就用到了SPL库
 * 在PHP的内部实现中 foreach循环 的底层实现 在迭代循环时  会去查看被迭代的元素是否实现了iterator接口，
 * 若是，则按其定义的循环规则，否则，就用默认的规则循环之。
 *
 * 抽象迭代器(Iterator): 迭代器定义访问和遍历元素的接口。
 * 具体迭代器(ConcreteIterator):  具体迭代器实现迭代器Iterator接口。对该聚合遍历时跟踪当前位置。
 * 抽象聚合类(Aggregate): 聚合定义创建相应迭代器对象的接口。
 * 具体聚合类(ConcreteAggregate): 体聚合实现创建相应迭代器的接口，该操作返回ConcreteIterator的一个适当的实例。
 */


/**
 * 具体迭代器(ConcreteIterator):  具体迭代器实现迭代器Iterator接口。对该聚合遍历时跟踪当前位置。
 */
class  ConcreteIterator implements  Iterator {
    protected $_key;
    protected $_collection;
    public function __construct($collection){
//        echo 'this is ConcreteIterator';//有输出 证明了PHP的内部运行机制 SPL库
        $this->_collection = $collection;
        $this->_key = 0;
    }
    public function rewind(){
        $this->_key = 0;
    }
    public function valid(){

        return isset($this->_collection[$this->_key]);
    }
    public function key(){
        return $this->_key;
    }
    public function current(){
        return $this->_collection[$this->_key];
    }
    public function next(){
        return ++$this->_key;
    }

}

/**
 * 具体聚合类(ConcreteAggregate):
 */
class ConcreteAggregate implements IteratorAggregate{
    protected $_arr;
    public function __construct($array){
        $this->_arr = $array;
    }

    public function getIterator(){
//        echo 'this is getIterator';//有输出 证明了PHP的内部运行机制 SPL库、
        return new    ConcreteIterator($this->_arr);
    }
}

$collectionay = array(1,2,3,3,4);
$it = new ConcreteAggregate($collectionay);
foreach($it as $key=>$value){
    echo $key.':'.$value.'<br/>';
}