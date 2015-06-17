<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/21
 * Time: 22:32
 *
 * 状态模式
 * 允许一个对象在其内部状态改变时改变它的行为,对象看起来似乎修改了它所属的类
 * 状态模式是一种行为型模式，它允许一个对象在其内部状态改变时改变它的行为。
 * 对象看起来似乎修改了它的类，状态模式变化的位置在于对象的状态。
 *
 * 抽象状态(State)角色：定义一个接口，用以封装环境对象的一个特定的状态所对应的行为
 * 具体状态（ConcreteState)角色：每一个具体状态类都实现了环境（Context）的一个状态所对应的行为
 * 环境(Context)角色：定义客户端所感兴趣的接口，并且保留一个具体状态类的实例。这个具体状态类的实例给出此环境对象的现有状态
 *
 */

interface State{
    public function handle($state);
    public function display();
}

class Context{
    private $_state = null;
    public function __construct($state){$this->setState($state);}
    public function setState($state){$this->_state = $state;}
    public function request(){
        $this->_state->display();
        $this->_state->handle($this);
    }
}

class StateA implements State{
    public function handle($context){$context->setState(new StateB());}
    public function display(){echo "state A<br />";}
}

class StateB implements State{
    public function handle($context){$context->setState(new StateC());}
    public function display(){echo "state B<br/>";}
}

class StateC implements State{
    public function handle($context){$context->setState(new StateA());}
    public function display(){echo "state C<br/>";}
}
 // 实例化一下
$objContext = new Context(new StateB());
$objContext->request();
$objContext->request();
$objContext->request();
$objContext->request();
$objContext->request();


/**
 * 状态模式的理解，关键有2点：
 * 1. 通常命令模式的接口中只有一个方法。
 * 而状态模式的接口中有1个或者多个方法。而且，状态模式的实现类的方法，一般返回值；
 * 或者是改变实例变量的值。也就是说，状态模式一般和对象的状态有关。
 * 实现类的方法有不同的功能，覆盖接口中的方法。状态模式和命令模式一样，
 * 也可以用于消除if…else等条件选择语句。
 *
 * 2. 主要的用途是，作为实例变量，是一个对象引用。命令模式的主要的使用方式是参数回调模式。
 * 命令接口作为方法的参数传递进来。然后，在方法体内回调该接口。而状态模式的主要使用方法，
 * 是作为实例变量，通过set属性方法，或者构造器把状态接口的具体实现类的实例传递进来。
 * 因此，可以这样比较命令模式和状态模式的异同。
 *
 * State模式和command模式都是十分常用，粒度比较小的模式，是很多更大型模式的一部分。
 * 基本上，state模式和command模式是十分相似的。
 * 只要开发者心中对单例和多例有一个清醒的认识，即使不把它们分为两种模式也没事。
 */
