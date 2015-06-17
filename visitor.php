<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/21
 * Time: 22:54
 *
 *
 * 访问者模式
 *
 * 访问者模式是一种行为型模式，访问者表示一个作用于某对象结构中各元素的操作。
 * 它可以在不修改各元素类的前提下定义作用于这些元素的新操作，即动态的增加具体访问者角色。
 * 访问者模式利用了双重分派。先将访问者传入元素对象的Accept方法中，
 * 然后元素对象再将自己传入访问者，之后访问者执行元素的相应方法。
 * 主要角色
 *
 * 抽象访问者角色(Visitor)：为该对象结构(ObjectStructure)中的每一个具体元素提供一个访问操作接口。
 * 该操作接口的名字和参数标识了 要访问的具体元素角色。这样访问者就可以通过该元素角色的特定接口直接访问它。
 * 具体访问者角色(ConcreteVisitor)：实现抽象访问者角色接口中针对各个具体元素角色声明的操作。
 * 抽象节点（Node）角色：该接口定义一个accept操作接受具体的访问者。
 * 具体节点（Node）角色：实现抽象节点角色中的accept操作。
 * 对象结构角色(ObjectStructure)：这是使用访问者模式必备的角色。
 * 它要具备以下特征：能枚举它的元素；可以提供一个高层的接口以允许该访问者访问它的元素；
 * 可以是一个复合（组合模式）或是一个集合，如一个列表或一个无序集合(在PHP中我们使用数组代替，
 * 因为PHP中的数组本来就是一个可以放置任何类型数据的集合)
 *
 */
// 抽象访问者角色
interface Visitor {
    public function visitConcreteElementA(ConcreteElementA $elementA);
    public function visitConcreteElementB(concreteElementB $elementB);
}
// 抽象节点角色
interface Element {
    public function accept(Visitor $visitor);
}
// 具体的访问者1
class ConcreteVisitor1 implements Visitor {
    public function visitConcreteElementA(ConcreteElementA $elementA) {echo 'ConcreteVisitor1--'.$elementA->getName().'<br>';}
    public function visitConcreteElementB(ConcreteElementB $elementB) {echo 'ConcreteVisitor1--'.$elementB->getName().'<br>';}
}
// 具体的访问者2
class ConcreteVisitor2 implements Visitor {
    public function visitConcreteElementA(ConcreteElementA $elementA) {echo 'ConcreteVisitor2--'.$elementA->getName().'<br>';}
    public function visitConcreteElementB(ConcreteElementB $elementB) {echo 'ConcreteVisitor2--'.$elementB->getName().'<br>';}
}
// 具体元素A
class ConcreteElementA implements Element {
    private $_name;
    public function __construct($name) { $this->_name = $name; }
    public function getName() { return $this->_name; }
    public function accept(Visitor $visitor) { // 接受访问者调用它针对该元素的新方法
        $visitor->visitConcreteElementA($this);
    }
}
// 具体元素B
class ConcreteElementB implements Element {
    private $_name;
    public function __construct($name) { $this->_name = $name;}
    public function getName() { return $this->_name; }
    public function accept(Visitor $visitor) { // 接受访问者调用它针对该元素的新方法
        $visitor->visitConcreteElementB($this);
    }
}
// 对象结构 即元素的集合
class ObjectStructure {
    private $_collection;
    public function __construct() { $this->_collection = array(); }
    public function attach(Element $element) {
        return array_push($this->_collection, $element);
    }
    public function detach(Element $element) {
        $index = array_search($element, $this->_collection);
        if ($index !== FALSE) {
            unset($this->_collection[$index]);
        }
        return $index;
    }
    public function accept(Visitor $visitor) {
        foreach ($this->_collection as $element) {
            $element->accept($visitor);
        }
    }
}

// client
$elementA = new ConcreteElementA("ElementA");
$elementB = new ConcreteElementB("ElementB");
$elementB2 = new ConcreteElementB("ElementB2");
$visitor1 = new ConcreteVisitor1();
$visitor2 = new ConcreteVisitor2();

$os = new ObjectStructure();
$os->attach($elementA);
$os->attach($elementB);
$os->attach($elementB2);
$os->detach($elementA);
$os->accept($visitor1);
$os->accept($visitor2);





/**
 * 访问者模式的优点:
 * •使得增加新的访问操作变得很容易。如果一些操作依赖于一个复杂的结构对象的话，
 * 那么一般而言，增加新的操作会很复杂。而使用访问者模式，增加新的操作就意味着增加一个新的访问者类，因此，变得很容易。
 * •将有关元素对象的访问行为集中到一个访问者对象中，而不是分散到一个个的元素类中。
 * •访问者模式可以跨过几个类的等级结构访问属于不同的等级结构的成员类。
 * 迭代子只能访问属于同一个类型等级结构的成员对象，而不能访问属于不同等级结构的对象。访问者模式可以做到这一点。
 * •让用户能够在不修改现有类层次结构的情况下，定义该类层次结构的操作。
 *
 * 访问者模式的缺点:
 * •增加新的元素类很困难。在访问者模式中，每增加一个新的元素类都意味着要在
 * 抽象访问者角色中增加一个新的抽象操作，并在每一个具体访问者类中增加相应的具体操作，违背了“开闭原则”的要求。
 * •破坏封装。访问者模式要求访问者对象访问并调用每一个元素对象的操作，
 * 这意味着元素对象有时候必须暴露一些自己的内部操作和内部状态，否则无法供访问者访问。
 *
 */