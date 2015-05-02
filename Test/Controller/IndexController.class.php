<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2015/4/24
 * Time: 23:03
 */
namespace Test\Controller;

use \Think\Controller;

class IndexController extends Controller
{

    public function index()
    {

        header("Content-type: text/html; charset=utf-8");

        $class = new \ReflectionClass('Test\Controller\UserTestController');//建立 Person这个类的反射类

        $methods = $class->getMethods();

        foreach ($methods as $methodName) {
            if (strstr($methodName, "test")) {

                echo "Testing:";

                echo $methodName->getName();

                echo "<br/>";

                $methodName->invoke(new UserTestController());

                echo "<br/>";

            }
        }


    }


}