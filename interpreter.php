<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2015/5/21
 * Time: 23:35
 *
 * 解释器模式
 *
 */
class Expression{
    function interpreter($str){return $str;}
}

class ExpressionNum extends Expression{
    function interpreter($str){
        switch($str) {
            case "0": return "零";
            case "1": return "一";
            case "2": return "二";
            case "3": return "三";
            case "4": return "四";
            case "5": return "五";
            case "6": return "六";
            case "7": return "七";
            case "8": return "八";
            case "9": return "九";
        }
    }
}

class ExpressionCharater extends Expression{
    function interpreter($str){return strtoupper($str);}
}

class Interpreter{
    function execute($string){
        $expression = null;
        for($i = 0;$i<strlen($string);$i++) {
            $temp = $string[$i];
            switch(true) {
                case is_numeric($temp): $expression = new ExpressionNum(); break;
                default: $expression = new ExpressionCharater();
            }
            echo $expression->interpreter($temp);
        }
    }
}
$obj = new Interpreter();
$obj->execute("12345abc");

/**
 * 各种模板引擎的解析也是解释器模式的体现
 */