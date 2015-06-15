<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/16
 * Time: 21:42
 *
 * 目标角色（Target）：— 定义Client使用的与特定领域相关的接口。
 * 客户角色（Client）：与符合Target接口的对象协同。
 * 被适配橘色（Adaptee)：定义一个已经存在并已经使用的接口，这个接口需要适配。
 * 适配器角色（Adapte) ：适配器模式的核心。它将对被适配Adaptee角色已有的接口转换为目标角色Target匹配的接口。
 * 对Adaptee的接口与Target接口进行适配.
 *
 * 类适配器
 * 用一个具体的Adapter类对Adaptee和Target进行匹配。
 * 结果是当我们想要匹配一个类以及所有它的子类时，类Adapter将不能胜任工作。
 * 使得Adapter可以重定义Adaptee的部分行为，因为Adapter是Adaptee的一个子类。
 * 仅仅引入了一个对象，并不需要额外的指针以间接得到 Adaptee。
 *
 * 对象适配器则
 * 允许一个Adapter与多个Adaptee—即Adaptee本身以及它的所有子类（如果有子类的话）—同时工作。
 * Adapter也可以一次给所有的Adaptee添加功能。
 * 使得重定义Adaptee的行为比较困难。这就需要生成Adaptee的子类并且使得Adapter引用这个子类而不是引用Adaptee本身。
 */

/**
 * 类适配器
 */
//目标角色
interface Target{
    public function hello();
    public function world();
}
//源角色
class Adaptee{
    public function great(){echo 'great';}
    public function world(){echo 'world';}
}
//适配器角色
class Adapter extends Adaptee implements Target{
    public function hello(){parent::great();}
}
//客户
class Client{
    public static function operation(){
        $adapter=new Adapter();
        $adapter->hello();
        $adapter->world();
    }
}
Client::operation();

/**
 * 对象适配器
 */
//目标
interface Target1{
    public function hello();
    public function world();
}
//源
class Adaptee1 {
    public function world(){ echo ' world ';}
    public function greet(){ echo ' greet ';}
}
//适配器
class Adapter1 implements Target1{
    public $adaptee;
    public function __construct(Adaptee1 $adaptee){$this->adaptee=$adaptee;}
    public function hello(){return $this->adaptee->greet();}
    public function world(){return $this->adaptee->world();}
}
//客户
class Client1{
    public static function operation(){
        $adaptee=new Adaptee1();
        $adapter=new Adapter1($adaptee);
        $adapter->hello();
        $adapter->world();
    }
}
Client1::operation();

/**
 * 适配器模式与其它相关模式

 * 桥梁模式(bridge模式)：桥梁模式与对象适配器类似，但是桥梁模式的出发点不同：
 * 桥梁模式目的是将接口部分和实现部分分离，从而对它们可以较为容易也相对独立的加以改变。
 * 而对象适配器模式则意味着改变一个已有对象的接口
 *
 * 装饰器模式(decorator模式)：装饰模式增强了其他对象的功能而同时又不改变它的接口。
 * 因此装饰模式对应用的透明性比适配器更好。
 * 结果是decorator模式支持递归组合，而纯粹使用适配器是不可能实现这一点的。
 *
 * Facade（外观模式）：适配器模式的重点是改变一个单独类的API。
 * Facade的目的是给由许多对象构成的整个子系统，提供更为简洁的接口。
 * 而适配器模式就是封装一个单独类，适配器模式经常用在需要第三方API协同工作的场合，
 * 设法把你的代码与第三方库隔离开来。
 *
 * 适配器模式与外观模式都是对现相存系统的封装。但这两种模式的意图完全不同，
 * 前者使现存系统与正在设计的系统协同工作而后者则为现存系统提供一个更为方便的访问接口。
 * 简单地说，适配器模式为事后设计，而外观模式则必须事前设计，因为系统依靠于外观。
 * 总之，适配器模式没有引入新的接口，而外观模式则定义了一个全新的接口。
 *
 *
 * 代理模式（Proxy ）在不改变它的接口的条件下，为另一个对象定义了一个代理。
 *
 * 装饰者模式，适配器模式，外观模式三者之间的区别：
 *
 * 装饰者模式的话，它并不会改变接口，而是将一个一个的接口进行装饰，也就是添加新的功能。
 *
 * 适配器模式是将一个接口通过适配来间接转换为另一个接口。
 *
 * 外观模式的话，其主要是提供一个整洁的一致的接口给客户端。
 *
 */