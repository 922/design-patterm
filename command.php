<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/21
 * Time: 21:04
 *
 * 命令模式
 *
 * 将一个请求封装为一个对象从而使你可用不同的请求对客户进行参数化,
 * 对请求排除或记录请求日志,以及支持可取消的操作
 *
 * “行为请求者”与“行为实现者”解耦
 * 将一个请求封装为一个对象，从而使我们可用不同的请求对客户进行参数化；
 * 对请求排队或者记录请求日志，以及支持可撤销的操作。
 * 命令模式又称为动作(Action)模式或事务(Transaction)模式。
 * （Command Pattern: Encapsulate a request asan object,
 * thereby letting youparameterize clients withdifferent requests,
 * queueor log requests,andsupportundoable operations. ）
 *
 * 抽象命令类(Command): 声明执行操作的接口。调用接收者相应的操作，以实现执行的方法Execute。
 * 具体命令类(ConcreteCommand): 创建一个具体命令对象并设定它的接收者。
 * 通常会持有接收者，并调用接收者的功能来完成命令要执行的操作。
 * 调用者(Invoker): 要求该命令执行这个请求。通常会持有命令对象，可以持有很多的命令对象。
 * 接收者(Receiver): 知道如何实施与执行一个请求相关的操作。
 * 任何类都可能作为一个接收者,只要它能够实现命令要求实现的相应功能。
 * 客户类(Client): 创建具体的命令对象，并且设置命令对象的接收者。真正使用命令的客户端是从Invoker来触发执行。
 */

interface Command{public function execute();}
class Invoker{
    private $_command=array();
    public function setCommand($command) {$this->_command[] =$command;}
    public function executeCommand(){
        foreach($this->_command as$command) {
            $command->execute();
        }
    }

    public function removeCommand($command){
        $key=array_search($command,$this->_command);
        if($key!==false) {
            unset($this->_command[$key]);
        }
    }
}

class Receiver{
    private $_name=null;
    public function __construct($name) {$this->_name =$name;}
    public function action(){echo$this->_name." action<br/>";}
    public function action1(){echo$this->_name." action1<br/>";}
}

class ConcreteCommand implements Command{
    private$_receiver;
    public function __construct($receiver){$this->_receiver =$receiver;}
    public function execute(){$this->_receiver->action();}
}

class ConcreteCommand1 implements Command{
    private$_receiver;
    public function __construct($receiver){$this->_receiver =$receiver;}
    public function execute(){$this->_receiver->action1();}
}

class ConcreteCommand2 implements Command{
    private$_receiver;
    public function __construct($receiver){$this->_receiver =$receiver;}
    public function execute(){
        $this->_receiver->action();
        $this->_receiver->action1();
    }
}

$objRecevier=new Receiver("No.1");
$objRecevier1=new Receiver("No.2");
$objRecevier2=new Receiver("No.3");

$objCommand=new ConcreteCommand($objRecevier);
$objCommand1=new ConcreteCommand1($objRecevier);
$objCommand2=new ConcreteCommand($objRecevier1);
$objCommand3=new ConcreteCommand1($objRecevier1);
$objCommand4=new ConcreteCommand2($objRecevier2); // 使用 Recevier的两个方法

$objInvoker=new Invoker();
$objInvoker->setCommand($objCommand);
$objInvoker->setCommand($objCommand1);
$objInvoker->executeCommand();
$objInvoker->removeCommand($objCommand1);
$objInvoker->executeCommand();

$objInvoker->setCommand($objCommand2);
$objInvoker->setCommand($objCommand3);
$objInvoker->setCommand($objCommand4);
$objInvoker->executeCommand();


/**
 * Command模式优点：
 * 1) 降低系统的耦合度:Command模式将调用操作的对象与知道如何实现该操作的对象解耦。
 * 2) Command是头等的对象。它们可像其他的对象一样被操纵和扩展。
 * 3) 组合命令:你可将多个命令装配成一个组合命令，即可以比较容易地设计一个命令队列和宏命令。
 * 一般说来，组合命令是Composite模式的一个实例。
 * 4) 增加新的Command很容易，因为这无需改变已有的类。
 * 5）可以方便地实现对请求的Undo和Redo。
 *
 * 命令模式的缺点：
 * 使用命令模式可能会导致某些系统有过多的具体命令类。
 * 因为针对每一个命令都需要设计一个具体命令类，
 * 此某些系统可能需要大量具体命令类，这将影响命令模式的使用。
 *
 *
 * 1）命令模式的本质是对命令进行封装，将发出命令的责任和执行命令的责任分割开。
 * 2）每一个命令都是一个操作：请求的一方发出请求，要求执行一个操作；接收的一方收到请求，并执行操作
 * 3）命令模式允许请求的一方和接收的一方独立开来，使得请求的一方不必知道接收请求的一方的接口，
 * 更不必知道请求是怎么被接收，以及操作是否被执行、何时被执行，以及是怎么被执行的。
 * 4）命令模式使请求本身成为一个对象，这个对象和其他对象一样可以被存储和传递。
 * 5）命令模式的关键在于引入了抽象命令接口，且发送者针对抽象命令接口编程，
 * 只有实现了抽象命令接口的具体命令才能与接收者相关联。
 *
 */