<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/18
 * Time: 21:42
 *
 *
 * 抽象主题角色(Subject)：它的作用是统一接口。
 * 此角色定义了真实主题角色和代理主题角色共用的接口，这样就可以在使用真实主题角色的地方使用代理主题角色。
 * 真实主题角色(RealSubject)：隐藏在代理角色后面的真实对象。
 * 代理主题角色(ProxySubject)：它的作用是代理真实主题，在其内部保留了对真实主题角色的引用。
 * 它与真实主题角色都继承自抽象主题角色，保持接口的统一。它可以控制对真实主题的存取，
 * 并可能负责创建和删除真实对象。代理角色并不是简单的转发，
 * 通常在将调用传递给真实对象之前或之后执行某些操作，当然你也可以只是简单的转发。
 * 与适配器模式相比：适配器模式是为了改变对象的接口，而代理模式并不能改变所代理对象的接口。
 *
 */

// 抽象主题角色
abstract class Subject {
    abstract public function action();
}
// 真实主题角色
class RealSubject extends Subject {
    public function __construct() {}
    public function action() {}
}
// 代理主题角色
class ProxySubject extends Subject {
    private $_real_subject = NULL;
    public function __construct() {}
    public function action() {
        $this->_beforeAction();//权限控制等操作
        if (is_null($this->_real_subject)) {$this->_real_subject = new RealSubject();}
        $this->_real_subject->action();
        $this->_afterAction();
    }
    private function _beforeAction() {}
    private function _afterAction() {}
}

// client
$subject = new ProxySubject();
$subject->action();

/**
 * 与其他相关模式
 *
 * 适配器模式Adapter
 * 适配器Adapter 为它所适配的对象提供了一个不同的接口。
 * 相反，代理提供了与它的实体相同的接口。然而，用于访问保护的代理可能会拒绝执行实体会执行的操作，
 * 因此，它的接口实际上可能只是实体接口的一个子集。
 *
 * 装饰器模式Decorator
 * 尽管Decorator的实现部分与代理相似，但
 * Decorator的目的不一样。Decorator为对象添加一个或多个功能，而代理则控制对对象的访问。
 *
 *
 */