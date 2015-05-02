<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2015/4/24
 * Time: 17:59
 */
namespace Test\Controller;


class UserTestController extends BasicTestController
{

    public function before(){

    }

    public function testLoginWithValidInfo()
    {

        // 所有的URL的生成，是
        $url = U("User/findUserPass",array("requestTarget"=>"testMode",'username'=>'cimer','password'=>'cimer'));

        $result =  D("HttpClient","Service")->httpRequest($url);

        // 生成报告
        $this->println("正在以用户名cimer,密码cimer测试用户登录接口！");

        $this->println("测试结果:".$result);
    }

    public function testFindUserInfo(){

        // 所有的URL的生成，是
        $url = U("User/findUserInfo",array("requestTarget"=>"testMode",'uid'=>'10001'));

        $result =  D("HttpClient","Service")->httpRequest($url);

        // 生成报告
        $this->println("正在获取UID为10001的用户信息！");

        $this->println("测试结果:".urldecode(json_decode($result,false)));
    }

    public function testUpdateUserInfo(){

        // 所有的URL的生成，是
        $url = U("User/findUserInfo",array("requestTarget"=>"testMode",'uid'=>'10001'));

        $result =  D("HttpClient","Service")->httpRequest($url);

        // 生成报告
        $this->println("正在获取UID为10001的用户信息！");

        $this->println("测试结果:".json_decode($result,false));

    }

    public function after(){

    }

} 