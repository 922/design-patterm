<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/21
 * Time: 19:22
 *
 * 观察者模式
 * 目标（Subject）: 目标知道它的观察者。可以有任意多个观察者观察同一个目标。 提供注册和删除观察者对象的接口。
 * 具体目标（ConcreteSubject）:  将有关状态存入各ConcreteObserver对象。
 * 观察者(Observer):  为那些在目标发生改变时需获得通知的对象定义一个更新接口。当它的状态发生改变时, 向它的各个观察者发出通知。
 * 具体观察者(ConcreteObserver):   维护一个指向ConcreteSubject对象的引用。
 * 存储有关状态，这些状态应与目标的状态保持一致。实现O b s e r v e r的更新接口以使自身状态与目标的状态保持一致。
 */
/**
 * 这一模式的概念是SplSubject类维护了一个特定状态，当这个状态发生变化时，它就会调用notify()方法。
 * 调用notify()方法时，所有之前使用attach()方法注册的SplObserver实例的update方法都会被调用。
 * 详情参考laravel的event
 */
interface SplSubject{
    public function attach(SplObserver $observer);
    public function detach(SplObserver $observer);
    public function notify();
}
interface SplObserver{public function update(SplSubject $observer);}
class ConcreteSubject implements SplSubject{
    private $observers,$_state;
    public function __construct(){$this->observers=array();}
    public function attach(SplObserver $observer){$this->observers[]=$observer;}
    public function detach(SplObserver $observer){
        if($idx=array_search($observer,$this->observers,true)){
            unset($this->observers[$idx]);
        }
    }
    public function notify(){
        foreach($this->observers as $observer){
            if ($observer->getState() == $this->_state) {
                $observer->update($this);
            }
        }
    }
    public function setState($state) {
        $this->_state = $state;
        $this->notify();
    }
    public function getState() {return $this->_state;}
}

abstract class bserver{
    private $_state;
    function __construct($state) { $this->_state = $state;}
    public function setState($state) {
        $this->_state = $state;
        $this->notify();
    }
    public function getState() {return $this->_state;}
}
class ConcreteObserver1 implements SplObserver{
    function __construct($state) {parent::__construct($state);}
    public function update(SplSubject $subject){}
}
class ConcreteObserver2 implements SplObserver {
    function __construct($state) {parent::__construct($state);}
    public function update(SplSubject $subject) {}
}
$subject = new ConcreteSubject();
$observer1 = new ConcreteObserver1(1);
$observer2 = new ConcreteObserver2(2);
$subject->attach($observer1);
$subject->attach($observer2);
$subject->setState(1);

/**
 * Observer模式允许你独立的改变目标和观察者。你可以单独复用目标对象而无需同时复用其观察者, 反之亦然。
 * 它也使你可以在不改动目标和其他的观察者的前提下增加观察者。
 * 下面是观察者模式其它一些优点:
 * 1 )观察者模式可以实现表示层和数据逻辑层的分离,并定义了稳定的消息更新传递机制，
 * 抽象了更新接口，使得可以有各种各样不同的表示层作为具体观察者角色。
 *
 * 2 )在观察目标和观察者之间建立一个抽象的耦合 ：一个目标所知道的仅仅是它有一系列观察者 ,
 * 每个都符合抽象的Observer类的简单接口。目标不知道任何一个观察者属于哪一个具体的类。
 * 这样目标和观察者之间的耦合是抽象的和最小的。因为目标和观察者不是紧密耦合的,
 * 它们可以属于一个系统中的不同抽象层次。一个处于较低层次的目标对象可与一个处于较高层次的观察者通信并通知它 ,
 * 这样就保持了系统层次的完整。如果目标和观察者混在一块 , 那么得到的对象要么横贯两个层次 (违反了层次性),
 * 要么必须放在这两层的某一层中(这可能会损害层次抽象)。
 *
 * 3) 支持广播通信 :不像通常的请求, 目标发送的通知不需指定它的接收者。
 * 通知被自动广播给所有已向该目标对象登记的有关对象。目标对象并不关心到底有多少对象对自己感兴趣 ;
 * 它唯一的责任就是通知它的各观察者。这给了你在任何时刻增加和删除观察者的自由。
 * 处理还是忽略一个通知取决于观察者。
 *
 * 4) 观察者模式符合“开闭原则”的要求。
 *
 * 观察者模式的缺点
 * 1) 如果一个观察目标对象有很多直接和间接的观察者的话，将所有的观察者都通知到会花费很多时间。
 * 2) 如果在观察者和观察目标之间有循环依赖的话，观察目标会触发它们之间进行循环调用，可能导致系统崩溃。
 * 3) 观察者模式没有相应的机制让观察者知道所观察的目标对象是怎么发生变化的，而仅仅只是知道观察目标发生了变化。
 * 4)  意外的更新 因为一个观察者并不知道其它观察者的存在 , 它可能对改变目标的最终代价一无所知。
 * 在目标上一个看似无害的的操作可能会引起一系列对观察者以及依赖于这些观察者的那些对象的更新。
 * 此外 , 如果依赖准则的定义或维护不当，常常会引起错误的更新 , 这种错误通常很难捕捉。
 * 简单的更新协议不提供具体细节说明目标中什么被改变了 , 这就使得上述问题更加严重。
 * 如果没有其他协议帮助观察者发现什么发生了改变，它们可能会被迫尽力减少改变。
 *
 */