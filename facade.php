<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/16
 * Time: 23:02
 *
 * 外观角色（Facade）：是模式的核心，他被客户client角色调用，知道各个子系统的功能。
 * 同时根据客户角色已有的需求预订了几种功能组合
 *
 * 子系统角色（Subsystem classes）：实现子系统的功能，并处理由Facade对象指派的任务。
 * 对子系统而言，facade和client角色是未知的，没有Facade的任何相关信息；即没有指向Facade的实例。
 *
 * 客户角色（client）：调用facade角色获得完成相应的功能。
 */

//外观角色
class SwitchFacade{
    private $_light ;   //电灯
    private $_ac ;      //空调
    private $_fan ;     //风扇
    private $_tv ;      //电视
    public function __construct(){
        $this->_light=new Light();
        $this->_ac=new AirConditioner();
        $this->_fan=new Fan();
        $this->_tv=new Television();
    }
    //晚上开灯
    public function method1($isOpen =1) {
        if ($isOpen == 1) {
            $this->_light->on();
            $this->_fan->on();
            $this->_ac->on();
            $this->_tv->on();
        }else{
            $this->_light->off();
            $this->_fan->off();
            $this->_ac->off();
            $this->_tv->off();
        }
    }
    //白天不需要电灯
    public function method2($isOpen) {
        if ($isOpen == 1) {
            $this->_fan->on();
            $this->_ac->on();
            $this->_tv->on();
        }else{
            $this->_fan->off();
            $this->_ac->off();
            $this->_tv->off();
        }
    }
}
//子系统角色
class Light{
    private $_isOpen = 0;
    public function on() {$this->_isOpen = 1;}
    public function off() {$this->_isOpen = 0;}
}

class Fan{
    private $_isOpen = 0;
    public function on() {$this->_isOpen = 1;}
    public function off() {$this->_isOpen = 0;}
}

class AirConditioner{
    private $_isOpen = 0;
    public function on() {$this->_isOpen = 1;}
    public function off() { $this->_isOpen = 0;}
}
class Television{
    private $_isOpen = 0;
    public function on() {$this->_isOpen = 1;}
    public function off() {$this->_isOpen = 0;}
}

//客户
class Client{

    static function open() {
        $f = new  SwitchFacade();
        $f->method1(1);
    }
    static function close() {
        $f = new  SwitchFacade();
        $f->method1(0);
    }
}
Client::open();
Client::close();

/**
 * 与其他相关模式
 * 抽象工厂模式：
 * Abstract Factory式可以与Facade模式一起使用以提供一个接口，
 * 这一接口可用来以一种子系统独立的方式创建子系统对象。
 * Abstract Factory也可以代替Facade模式隐藏那些与平台相关的类。
 * 中介模式：
 * Mediator模式与Facade模式的相似之处是，它抽象了一些已有的类的功能。
 * 然而，Mediator的目的是对同事之间的任意通讯进行抽象，通常集中不属于任何单个对象的功能。
 * Mediator的同事对象知道中介者并与它通信，而不是直接与其他同类对象通信。
 * 相对而言，Facade模式仅对子系统对象的接口进行抽象，从而使它们更容易使用；
 * 它并不定义新功能，子系统也不知道Facade的存在。
 * 通常来讲，仅需要一个Facade对象，因此Facade对象通常属于Singleton模式。
 * Adapter模式：
 * 适配器模式是将一个接口通过适配来间接转换为另一个接口。
 * 外观模式的话，其主要是提供一个整洁的一致的接口给客户端。
 *
 * 总结
 *
 * 根据“单一职责原则”，在软件中将一个系统划分为若干个子系统有利于降低整个系统的复杂性，
 * 一个常见的设计目标是使子系统间的通信和相互依赖关系达到最小，
 * 而达到该目标的途径之一就是引入一个外观对象，它为子系统的访问提供了一个简单而单一的入口。
 *
 * 外观模式也是“迪米特法则”的体现，通过引入一个新的外观类可以降低原有系统的复杂度，
 * 外观类充当了客户类与子系统类之间的“第三者”，同时降低客户类与子系统类的耦合度。
 * 外观模式就是实现代码重构以便达到“迪米特法则”要求的一个强有力的武器。
 *
 * 外观模式要求一个子系统的外部与其内部的通信通过一个统一的外观对象进行，
 * 外观类将客户端与子系统的内部复杂性分隔开，使得客户端只需要与外观对象打交道，
 * 而不需要与子系统内部的很多对象打交道。
 *
 * 外观模式从很大程度上提高了客户端使用的便捷性，使得客户端无须关心子系统的工作细节，通过外观角色即可调用相关功能。
 *
 * 不要试图通过外观类为子系统增加新行为 ，不要通过继承一个外观类在子系统中加入新的行为，这种做法是错误的。
 * 外观模式的用意是为子系统提供一个集中化和简化的沟通渠道，而不是向子系统加入新的行为，
 * 新的行为的增加应该通过修改原有子系统类或增加新的子系统类来实现，不能通过外观类来实现。
 *
 * 对客户屏蔽子系统组件，减少了客户处理的对象数目并使得子系统使用起来更加容易。
 * 通过引入外观模式，客户代码将变得很简单，与之关联的对象也很少。
 *
 * 实现了子系统与客户之间的松耦合关系，这使得子系统的组件变化不会影响到调用它的客户类，只需要调整外观类即可。
 *
 * 降低了大型软件系统中的编译依赖性，并简化了系统在不同平台之间的移植过程，
 * 因为编译一个子系统一般不需要编译所有其他的子系统。一个子系统的修改对其他子系统没有任何影响，
 * 而且子系统内部变化也不会影响到外观对象。
 *
 * 只是提供了一个访问子系统的统一入口，并不影响用户直接使用子系统类。
 * Facade模式的缺点
 * 不能很好地限制客户使用子系统类，如果对客户访问子系统类做太多的限制则减少了可变性和灵活性。
 * 在不引入抽象外观类的情况下，增加新的子系统可能需要修改外观类或客户端的源代码，违背了“开闭原则”。
 *
 */