<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/21
 * Time: 23:16
 *
 * 中介者模式
 *
 * 中介者模式是一种行为型模式，它包装了一系列对象相互作用的方式，
 * 使得这些对象不必相互明显作用，从而使它们可以松散偶合。当某些对象之的作用发生改变时，
 * 不会立即影响其他的一些对象之间的作用，保证这些作用可以彼此独立的变化。
 *
 * 主要角色
 * 中介者(Mediator）角色：定义了对象间相互作用的接口
 * 具体中介者(ConcreteMediator)角色：实现了中介者定义的接口。
 * 具体对象(ConcreteColleague)角色：通过中介者和别的对象进行交互
 *
 */
// 中介者角色
abstract class Mediator {
    abstract public function send($message,$colleague);
}
// 抽象对象
abstract class Colleague {
    private $_mediator = null;
    public function __construct($mediator) {
        $this->_mediator = $mediator;
    }
    public function send($message) {
        $this->_mediator->send($message,$this);
    }
    abstract public function notify($message);
}
// 具体中介者角色
class ConcreteMediator extends Mediator {
    private $_colleague1 = null;
    private $_colleague2 = null;
    public function send($message,$colleague) {
        if($colleague == $this->_colleague1) {
            $this->_colleague1->notify($message);
        } else {
            $this->_colleague2->notify($message);
        }
    }
    public function set($colleague1,$colleague2) {
        $this->_colleague1 = $colleague1;
        $this->_colleague2 = $colleague2;
    }
}
// 具体对象角色
class Colleague1 extends Colleague {
    public function notify($message) { echo 'ConcreteColleague1 m:', $message, '<br/>';  }
}
// 具体对象角色
class Colleague2 extends Colleague {
    public function notify($message) { echo 'ConcreteColleague2 m:', $message, '<br/>';  }
}
// 客户
$objMediator = new ConcreteMediator();
$objC1 = new Colleague1($objMediator);
$objC2 = new Colleague2($objMediator);
$objMediator->set($objC1,$objC2);
$objC1->send("to c2 from c1");
$objC2->send("to c1 from c2");


/**
 * 1)迪米特法则的一个典型应用:在中介者模式中，通过创造出一个中介者对象，
 * 将系统中有关的对象所引用的其他对象数目减少到最少，
 * 使得一个对象与其同事之间的相互作用被这个对象与中介者对象之间的相互作用所取代。
 * 因此，中介者模式就是迪米特法则的一个典型应用。
 *
 * 2) 通过引入中介者对象，可以将系统的网状结构变成以中介者为中心的星形结构，
 * 中介者承担了中转作用和协调作用。中介者类是中介者模式的核心，它对整个系统进行控制和协调，
 * 简化了对象之间的交互，还可以对对象间的交互进行进一步的控制。
 *
 * 3) 中介者模式的主要优点在于简化了对象之间的交互，将各同事解耦，还可以减少子类生成，
 * 对于复杂的对象之间的交互，通过引入中介者，可以简化各同事类的设计和实现；
 * 中介者模式主要缺点在于具体中介者类中包含了同事之间的交互细节，可能会导致具体中介者类非常复杂，使得系统难以维护。
 *
 * 4) 中介者模式适用情况包括：系统中对象之间存在复杂的引用关系，产生的相互依赖关系结构混乱且难以理解；
 * 一个对象由于引用了其他很多对象并且直接和这些对象通信，导致难以复用该对象；
 * 想通过一个中间类来封装多个类中的行为，而又不想生成太多的子类
 *
 */