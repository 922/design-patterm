<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/16
 * Time: 23:22
 *
 * 把抽象部分和实现部分分离
 * Bridge模式将继承关系转换为组合关系，从而降低了系统间的耦合，减少了代码编写量
 *
 * 抽象类(Abstraction):定义抽象类的接口,维护一个指向Implementor类型对象的指针
 *
 * 扩充抽象类(RefinedAbstraction)：扩充由Abstraction定义的接口
 *
 * 实现类接口(Implementor)：定义实现类的接口，该接口不一定要与Abstraction的接口完全一致；
 * 事实上这两个接口可以完全不同。一般来讲， Implementor接口仅提供基本操作，
 * 而 Abstraction则定义了基于这些基本操作的较高层次的操作。
 *
 * 具体实现类(ConcreteImplementor)：实现Implementor接口并定义它的具体实现。
 *
 */

//实现类的接口
interface SendMessageImplementor{public function send($message,$toUser);}
//具体实现类A
class SendMessageSMS implements SendMessageImplementor{
    public function send($message,$toUser){
        echo "使用站内消息的方式发送消息:".$message."给".$toUser."<br>";
    }
}
//具体实现类B
class SendMessageEmail implements SendMessageImplementor{
    public function send($message,$toUser){
        echo "使用E-mail的方式发送消息:".$message."给".$toUser."<br>";
    }
}
//抽象类
abstract class AbstractMessage{
    protected $impl;//持有一个实现部分的对象
    public function __construct($impl){ $this->impl = $impl;}
    public function sendMessage($message,$toUser){$this->impl->send($message,$toUser);}
}
// 普通消息类的实现 扩充抽象类
class CommonMessage extends AbstractMessage{
    public function __construct($impl){
        parent::__construct($impl);
    }
    public function sendMessage($message, $toUser){
        $this->impl->send($message,$toUser);
    }
}
//加急消息类的实现 扩充抽象类
class UrgencyMessage extends AbstractMessage{
    public function __construct($impl){
        parent::__construct($impl);
    }

    public function sendMessage($message, $toUser){
        $message .= "<font color='red'>加急:".$message."</font>";
        $this->impl->send($message,$toUser);
    }

    /**
     * 扩展自己的新功能,监控某消息的处理过程
     * @param messageId 被监控的消息的编号
     * @return  包含监控到的数据对象,这里示意一下，为了区别各种消息类的区别
     */
    public function watch($messageId){
        //获取相应的数据,组织成监控的数据对象，然后返回
    }
}

//创建了一个用Email发送消息的功能实现
$impl_email = new SendMessageEmail();
//创建一个普通的消息对象，并把用$impl绑定给这个实例
$message = new CommonMessage($impl_email);
//发送消息
$message->sendMessage("产品部来了新的需求，请查看", "技术部经理");


//创建一个紧急消息,消息很紧急，我不但要发EMAIL，还要发短信告诉这个人
$UrgMessage1 = new UrgencyMessage(new SendMessageSMS());
$UrgMessage2 = new UrgencyMessage(new SendMessageEmail());

/**
 * 这里只是关于设计模式的探讨，在实际应用中，我们可以为抽象绑定多个业务实现
 * $protect $implArray = array();
 * 在调用send()函数时，可以轮询多种实现,这里就不具体去写这种实现方法了
 */
$UrgMessage1->sendMessage("有加急的任务，请速查邮件(内容就是这段话，因为是短信)", "运维部某某人");
$UrgMessage2->sendMessage("有加急的任务，请速查邮件(内容可能很长，因为这是邮件发送，所以全部内容都在)", "运维部某某人");


/**
 *桥连模式：将抽象部分与实现部分分离，使它们都可以独立的变化。
 * 它是一种结构性模式，又称柄体（Handle and body）模式或者接口（Interface）模式。
 * 当一个抽象可能有多个实现时，通常用继承来协调他们。抽象类的定义对该抽象的接口。
 * 而具体的子类则用不同的方式加以实现，但是此方法有时不够灵活。继
 * 承机制将抽象部分与他的视线部分固定在一起，使得难以对抽象部分和实现部分独立地进行修改、扩充和充用。
 *
 * 理解桥接模式，重点需要理解如何将抽象化(Abstraction)与实现化(Implementation)脱耦，使得二者可以独立地变化。
 *
 * 抽象化：抽象化就是忽略一些信息，把不同的实体当作同样的实体对待。
 * 在面向对象中，将对象的共同性质抽取出来形成类的过程即为抽象化的过程。
 *
 * 实现化：针对抽象化给出的具体实现，就是实现化，抽象化与实现化是一对互逆的概念，
 * 实现化产生的对象比抽象化更具体，是对抽象化事物的进一步具体化的产物。
 *
 * 脱耦：脱耦就是将抽象化和实现化之间的耦合解脱开，或者说是将它们之间的强关联改换成弱关联，
 * 将两个角色之间的继承关系改为关联关系。桥接模式中的所谓脱耦，
 * 就是指在一个软件系统的抽象化和实现化之间使用关联关系（组合或者聚合关系）而不是继承关系，
 * 从而使两者可以相对独立地变化，这就是桥接模式的用意。
 */