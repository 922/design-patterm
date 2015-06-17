<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/21
 * Time: 22:07
 *
 * 备忘录模式
 *
 * 备忘录模式是一种行为型模式，它在不破坏封装性的前提下，捕获一个对象的内部状态，
 * 并在该对象之外保存这个状态。这样可以在以后把该对象的状态恢复到之前保存的状态。
 *
 * 备忘录(Memento)角色：存储发起人(Originator)对象的内部状态，
 * 而发起人根据需要决定备忘录存储发起人的哪些内部状态。
 * 备忘录可以保护其内容不被发起人(Originator)对象之外的任何对象所读取。
 * 发起人(Originator)角色：创建一个含有当前的内部状态的备忘录对象，使用备忘录对象存储其内部状态
 * 负责人(Caretaker)角色：负责保存备忘录对象，不检查备忘录对象的内容
 *
 * 下面是一个命令模式和备忘录模式混合使用的实例，
 * 用命令模式来实现具体各种算法的操作，使用备忘录模式来完成撤销及恢复的功能。
 */
// 发起人(Originator)角色
class Originator {
    private $_state;
    public function __construct() {
        $this->_state = '';
    }
    public function createMemento() { // 创建备忘录
        return new Memento($this->_state);
    }
    public function restoreMemento(Memento $memento) { // 将发起人恢复到备忘录对象记录的状态上
        $this->_state = $memento->getState();
    }
    public function setState($state) { $this->_state = $state; }
    public function getState() { return $this->_state; }
    public function showState() {echo $this->_state;}
}
// 备忘录(Memento)角色
class Memento {
    private $_state;
    public function __construct($state) {$this->setState($state);}
    public function getState() { return $this->_state; }
    public function setState($state) { $this->_state = $state;}
}
// 负责人(Caretaker)角色
class Caretaker {
    private $_memento;
    public function getMemento() { return $this->_memento; }
    public function setMemento(Memento $memento) { $this->_memento = $memento; }
}
// client
/* 创建目标对象 */
$org = new Originator();
$org->setState('open');
$org->showState();
/* 创建备忘 */
$memento = $org->createMemento();
/* 通过Caretaker保存此备忘 */
$caretaker = new Caretaker();
$caretaker->setMemento($memento);
/* 改变目标对象的状态 */
$org->setState('close');
$org->showState();
/* 还原操作 */
$org->restoreMemento($caretaker->getMemento());
$org->showState();

