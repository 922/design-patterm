<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/16
 * Time: 22:02
 *
 * 使用装饰模式会产生比使用继承关系更多的对象。并且这些对象看上去都很想像，从而使得查错变得困难。
 *
 */


//抽象构件
interface Component {
    public function operation();
}
//抽象装饰
abstract class Decorator implements  Component{
    protected $_component;
    public function __construct(Component $_component){$this->_component=$_component;}
    public function operation(){$this->_component->operation();}
}
//具体装饰
class ConcreteDecoratorA extends Decorator{
    public function __construct(Component $component){parent::__construct($component);}
    public function operation(){parent::operation();$this->addOperationA();}
    public function addOperationA(){}
}
class ConcreteDecoratorB extends Decorator{
    public function __construct(Component $component){parent::__construct($component);}
    public function operation(){parent::operation();$this->addOperationB();}
    public function addOperationB(){}
}
//具体构件
class ConcreteComponent implements Component{
    public function operation(){}
}
//客户
class Client{
    public static function operation(){
        $component=new ConcreteComponent();
        $decoratorA=new ConcreteDecoratorA($component);
        $decoratorB=new ConcreteDecoratorB($component);
        $decoratorA->operation();
        $decoratorB->operation();
    }
}
Client::operation();


/**
 * 装饰器模式与其他相关模式
 * Adapter 模式：Decorator模式不同于Adapter模式，因为装饰仅改变对象的职责而
 * 不改变它的接口；而适配器将给对象一个全新的接口。
 *
 * Composite模式：可以将装饰视为一个退化的、仅有一个组件的组
 * 合。然而，装饰仅给对象添加一些额外的职责—它的目的不在于对象聚集。
 *
 * Strategy模式：用一个装饰你可以改变对象的外表；而Strategy模
 * 式使得你可以改变对象的内核。这是改变对象的两种途径。
 */