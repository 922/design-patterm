<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/17
 * Time: 0:48
 *
 * 抽象构件角色（component）：是组合中的对象声明接口，在适当的情况下，实现所有类共有接口的默认行为。
 * 声明一个接口用于访问和管理Component子部件。这个接口可以用来管理所有的子对象。
 * (可选)在递归结构中定义一个接口，用于访问一个父部件，并在合适的情况下实现它。
 * 树叶构件角色(Leaf)：在组合树中表示叶节点对象，叶节点没有子节点。并在组合中定义图元对象的行为。
 * 树枝构件角色（Composite）：定义有子部件的那些部件的行为。存储子部件。在Component接口中实现与子部件有关的操作。
 * 客户角色（Client）：通过component接口操纵组合部件的对象。
 *
 * 实例 树形菜单
 */
//抽象接口
interface MenuComponent{
    public function getName();
    public function getUrl();
    public function displayOperation();
}
//树枝构件角色
class MenuComposite  implements MenuComponent{
    private $_items=array();
    private $_name=null;
    private $_align='';
    public function __construct($_name){$this->_name=$_name; }
    public function add($component){$this->_items[$component->getName()]=$component;}
    public function remove($component){$key=array_search($component,$this->_items);if($key !==false)unset($this->_items[$key]);}
    public function getItems(){return $this->_items;}
    public function displayOperation() {
        static $align = '|';
        if($this->getItems()) {
            //substr($align, strpos($align,));
            $align .= ' _ _ ';
        }else{
            $align .='';
        }
        echo $this->_name, " <br/>";
        foreach($this->_items as $name=> $item) {
            echo $align;
            $item->displayOperation();
        }
    }
    public function getName(){return $this->_name;}
    public function getUrl(){return $this->_url;}
}
//树叶构件角色(Leaf)
class ItemLeaf implements  MenuComponent{
    private $_name = null;
    private $_url = null;
    public function __construct($name,$url){$this->_name = $name;$this->_url = $url;}
    public function displayOperation(){
        echo '<a href="', $this->_url, '">' , $this->_name, '</a><br/>';
    }
    public function getName(){return $this->_name;}
    public function getUrl(){return $this->_url;}
}
//客户
class Client{
    public static function displayMenu(){
        $subMenu1 = new MenuComposite ("submenu1");
        $subMenu2 = new MenuComposite ("submenu2");
        $subMenu3 = new MenuComposite ("submenu3");
        $subMenu4 = new MenuComposite ("submenu4");
        $subMenu5 = new MenuComposite ("submenu5");
       /*
        $item1 = new ItemLeaf("sohu","www.163.com");
        $item2 = new ItemLeaf("sina","www.sina.com");
        $subMenu4 = new MenuComposite ("submenu4");
        $subMenu1->add($subMenu4);
        $subMenu4->add($item1);
        $subMenu4->add($item2);
        */
        $item3 = new ItemLeaf("baidu","www.baidu.com");
        $item4 = new ItemLeaf("google","www.google.com");
        $subMenu2->add($item3);
        $subMenu2->add($item4);

        $allMenu = new MenuComposite ("AllMenu");
        $allMenu->add($subMenu1);
        $allMenu->add($subMenu2);
        $allMenu->add($subMenu3);
        $subMenu3->add($subMenu4);
        $subMenu4->add($subMenu5);
        $allMenu->displayOperation();
    }
}

// 创建menu
Client::displayMenu();

/**
 *
 * 组合模式和其他相关模式
 * 装饰模式（Decorator模式）经常与Composite模式一起使用。当装饰和组合一起使用时，
 * 它们通常有一个公共的父类。因此装饰必须支持具有 Add、Remove和GetChild 操作的Component接口。
 *
 * Flyweight模式让你共享组件，但不再能引用他们的父部件。
 *
 *（迭代器模式）Itertor可用来遍历Composite。
 * 
 *（观察者模式）Visitor将本来应该分布在Composite和L e a f类中的操作和行为局部化。
 *
 * 总结
 * 组合模式解耦了客户程序与复杂元素内部结构，从而使客户程序可以向处理简单元素一样来处理复杂元素。
 * 如果你想要创建层次结构，并可以在其中以相同的方式对待所有元素，那么组合模式就是最理想的选择。
 *
 */