<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    /**用户登录方法
     * 请求方法：POST请求
     * 参数：username,password
     **/
    public function index(){
        if(IS_POST) {
            //preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username) --无效的用户名
            $username = I('username');
            var_dump($_POST);
        }
        $this->display();
    }

    /**用户注册方法
     * 请求方法：POST请求
     * 参数：username,password
     **/
    public function register() {
        if(IS_POST) {
            $username = I('username');
            $pass = I('password');
            $user = D('user');
        }
        echo rand(10,99).substr(uniqid(),7,6).'<br/>';
        echo $str = substr(uniqid(),7,6);
        $this->display();
    }
}