<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/15
 * Time: 0:04
 * 将主要的业务逻辑封装在导演类中对整体而言可以取得比较好的稳定性。
 * 建造者模式很容易进行扩展。如果有新的需求，通过实现一个新的建造者类就可以完成，
 * 基本上不用修改之前已经测试通过的代码，因此也就不会对原有功能引入风险
 *
 *
 * 优点
 *
 * 建造者模式可以很好的将一个对象的实现与相关的“业务”逻辑分离开来，从而可以在不改变事件逻辑的前提下，使增加(或改变)实现变得非常容易。
 *
 * 缺点
 *
 * 建造者接口的修改会导致所有执行类的修改。
 */
//产品
class Product{
    private $_parts;
    public function __construct(){$this->_parts=array();}
    public function add($parts){$this->_parts[]=$parts;}
}
//建造者
abstract class Builder{
    public abstract function builderParty1();
    public abstract function builderParty2();
    public abstract function getResult();
}
class ConcreteBuilder extends Builder{
    private $_product;
    public function __construct(){$this->_product=new Product();}
    public function builderParty1(){$this->_product->add("Part1");}
    public function builderParty2(){$this->_product->add("Part2");}
    public function getResult(){return $this->_product;}
}
//导演者
class Director{
    public function __construct(Builder $concrete_builder){
        $concrete_builder->builderParty1();
        $concrete_builder->builderParty2();
    }
}
//客户
$builder=new ConcreteBuilder();
$director=new Director($builder);
$builder->getResult();