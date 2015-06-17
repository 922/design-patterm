<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/18
 * Time: 22:36
 *
 *策略模式非常适合复杂数据管理系统或数据处理系统，二者在数据筛选、搜索或处理的方式方面需要较高的灵活性。
 *
 * 抽象策略(Strategy）角色：定义所有支持的算法的公共接口。
 * 通常是以一个接口或抽象来实现。Context使用这个接口来调用其ConcreteStrategy定义的算法
 *
 * 具体策略(ConcreteStrategy)角色：以Strategy接口实现某具体算法
 *
 * 环境(Context)角色：持有一个Strategy类的引用，用一个ConcreteStrategy对象来配置
 *
 */
//抽象策略角色
interface Strategy{
    public function algorithmInterface();
}
//具体策略角色
class ConcreteStrategyA implements Strategy{
    public function algorithmInterface(){}
}
class ConcreteStrategyB implements Strategy{
    public function algorithmInterface(){}
}
class ConcreteStrategyC implements Strategy{
    public function algorithmInterface(){}
}
//环境角色
class Context{
    private $_strategy;
    public function __construct(Strategy $strategy){$this->_strategy=$strategy;}
    public function contextInterface(){$this->_strategy->algorithmInterface();}
}
//客户
$strategyA=new ConcreteStrategyA();
$context=new Context($strategyA);
$context->contextInterface();

$strategyB=new ConcreteStrategyB();
$context=new Context($strategyB);
$context->contextInterface();

$strategyC = new ConcreteStrategyC();
$context = new Context($strategyC);
$context->contextInterface();
/**
 * 优点
 * 策略模式提供了管理相关的算法族的办法
 * 策略模式提供了可以替换继承关系的办法 将算封闭在独立的Strategy类中使得你可以独立于其Context改变它
 * 使用策略模式可以避免使用多重条件转移语句。
 *
 * 缺点
 * 客户必须了解所有的策略 这是策略模式一个潜在的缺点
 * Strategy和Context之间的通信开销
 * 策略模式会造成很多的策略类
 */