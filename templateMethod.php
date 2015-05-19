<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/19
 * Time: 23:46
 *
 * 抽象模板(AbstractClass)角色
 * 定义一个或多个抽象方法让子类实现。这些抽象方法叫做基本操作，它们是顶级逻辑的组成部分。
 *
 * 定义一个模板方法。这个模板方法一般是一个具体方法，它给出顶级逻辑的骨架，
 * 而逻辑的组成步骤在对应的抽象操作中，这些操作将会推迟到子类中实现。
 * 同时，顶层逻辑也可以调用具体的实现方法
 *
 * 具体模板(ConcrteClass)角色
 * 实现父类的一个或多个抽象方法，作为顶层逻辑的组成而存在。
 * 每个抽象模板可以有多个具体模板与之对应，而每个具体模板有其自己对抽象方法
 * （也就是顶层逻辑的组成部分）的实现，从而使得顶层逻辑的实现各不相同。
 */
//抽象模板角色
abstract class AbstractClass{
    //模板方法 调用基本方法组装成顶层逻辑
    public function templateMethod(){
        $this->primitiveOperation1();
        $this->primitiveOperation2();
    }
    abstract protected function primitiveOperation1();
    abstract protected function primitiveOperation2();
}
//具体模板方法
class ConcreteClass extends AbstractClass{
    protected function primitiveOperation1(){}
    protected function primitiveOperation2(){}
}
$class= new ConcreteClass();
$class->templateMethod();

/**
 *与其他相关模式
 *
 * 策略模式：模板方法使用继承来改变算法的一部分。 Strategy使用委托来改变整个算法。模板方法模式与策略模式的作用十分类似，有时可以用策略模式替代模板方法模式。模板方法模式通过继承来实现代码复用，而策略模式使用委托，把不确定的行为集中到一个接口中，并在主类委托这个接口。委托比继承具有更大的灵活性。
 *
 *模式的扩展
 *
 * 1）模板方法模式与控制反转（好莱坞原则）在模板方法模式中，子类不显式调用父类的方法，
 * 而是通过覆盖父类的方法来实现某些具体的业务逻辑，父类控制对子类的调用，
 * 这种机制被称为好莱坞原则(Hollywood Principle)，好莱坞原则的定义为：“不要给我们打电话，
 * 我们会给你打电话(Don‘t call us, we’ll call you)”。在好莱坞，把简历递交给演艺公司后就只有回家等待。
 * 由演艺公司对整个娱乐项的完全控制，演员只能被动式的接受公司的差使,在需要的环节中，完成自己的演出。
 * 模板方法模式充分的体现了“好莱坞”原则。由父类完全控制着子类的逻辑，子类不需要调用父类，
 * 而通过父类来调用子类，子类可以实现父类的可变部份，却继承父类的逻辑,不能改变业务逻辑。
 *
 * 2）模板方法模式符合开闭原则
 *
 * 模板方法模式意图是由抽象父类控制顶级逻辑，并把基本操作的实现推迟到子类去实现,
 * 这是通过继承的手段来达到对象的复用，同时也遵守了开闭原则。
 *
 * 父类通过顶级逻辑，它通过定义并提供一个具体方法来实现，我们也称之为模板方法。
 * 通常这个模板方法才是外部对象最关心的方法。在上面的银行业务处理例子中，
 * templateMethodProcess这个方法才是外部对象最关心的方法。所以它必须是public的,
 * 才能被外部对象所调用。
 *
 * 子类需要继承父类去扩展父类的基本方法，但是它也可以覆写父类的方法。
 * 如果子类去覆写了父类的模板方法，从而改变了父类控制的顶级逻辑，这违反了“开闭原则”。
 * 我们在使用模板方法模式时，应该总是保证子类有正确的逻辑。所以模板方法应该定义为final的。
 * 所以AbstractClass类的模板方法templateMethodProcess方法应该定义为final。
 *
 * 模板方法模式中,抽象类的模板方法应该声明为final的。因为子类不能覆写一个被定义为final的方法。
 * 从而保证了子类的逻辑永远由父类所控制。
 *
 * 3）模板方法模式与对象的封装性
 *
 * 面向对象的三大特性：继承，封装，多态。
 *
 * 对象有内部状态和外部的行为。封装是为了信息隐藏，通过封装来维护对象内部数据的完整性。
 * 使得外部对象不能够直接访问一个对象的内部状态，而必须通过恰当的方法才能访问。
 *
 * 对象属性和方法赋予指定的修改符(public、protected、private)来达到封装的目的，
 * 使得数据不被外部对象恶意的访问及方法不被错误调用导造成破坏对象的封装性。
 *
 * 降低方法的访问级别，也就是最大化的降低方法的可见度是一种很重要的封装手段。
 * 最大化降低方法的可见度除了可以达到信息隐藏外，还能有效的降低类之间的耦合度,降低一个类的复杂度。
 * 还可以减少开发人员发生的的错误调用。
 *
 * 一个类应该只公开外部需要调用的方法。而所有为public方法服务的方法都应该声明为protected或private。
 * 如是一个方法不是需要对外公开的，但是它需要被子类进行扩展的或调用。那么把它定义为protected.否则应该为private。
 *
 * 显而易见，模板方法模式中的声明为abstract的基本操作都是需要迫使子类去实现的，
 * 它们仅仅是为模板方法服务的。它们不应该被抽象类（AbstractClass）所公开，所以它们应该protected。
 *
 * 因此模板方法模式中，迫使子类实现的抽象方法应该声明为protected abstract。
 *
 * 4）模板方法与勾子方法(hookMethod)
 *
 * 模板方法模式的抽象类定义方法：
 *
 * 模板方法：一个模板方法是定义在抽象类中的、把基本操作方法组合在一起形成一个总算法或一个总行为的方法。
 * 基本方法：基本方法是实现算法各个步骤的方法，是模板方法的组成部分。基本方法如下：
 * •抽象方法(Abstract Method)
 * •具体方法(Concrete Method)
 * •钩子方法(Hook Method)：“挂钩”方法和空方法，
 * hook方法在抽象类中的实现为空，是留给子类做一些可选的操作。
 * 如果某个子类需要一些特殊额外的操作，则可以实现hook方法，当然也可以完全不用理会，
 * 因为hook在抽象类中只是空方法而已。
 * 1）钩子方法的引入使得子类可以控制父类的行为。
 * 2）最简单的钩子方法就是空方法，也可以在钩子方法中定义一个默认的实现，
 * 如果子类不覆盖钩子方法，则执行父类的默认实现代码。
 * 3）比较复杂一点的钩子方法可以对其他方法进行约束，这种钩子方法通常返回一个boolean类型，
 * 即返回true或false，用来判断是否执行某一个基本方法。由子类来决定是否调用hook方法。
 *
 * 总结与分析
 *
 * 1）模板方法模式是一种类的行为型模式，在它的结构图中只有类之间的继承关系，没有对象关联关系。
 * 2）板方法模式是基于继承的代码复用基本技术，模板方法模式的结构和用法也是面向对象设计的核心之一。
 * 在模板方法模式中，可以将相同的代码放在父类中，而将不同的方法实现放在不同的子类中。
 * 3）在模板方法模式中，我们需要准备一个抽象类，将部分逻辑以具体方法以及具体构造函数的形式实现，
 * 然后声明一些抽象方法来让子类实现剩余的逻辑。不同的子类可以以不同的方式实现这些抽象方法，
 * 从而对剩余的逻辑有不同的实现，这就是模板方法模式的用意。
 * 模板方法模式体现了面向对象的诸多重要思想，是一种使用频率较高的模式。
 *
 */