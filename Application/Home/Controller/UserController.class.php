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
            //未添加验证码处理，后续更新
            $user = D('user');
            $data = $user->login(I('username'), I('password'));
            var_dump($data);
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
            $data = $user->register($username, $pass);
            echo $data['msg']; //if $data['error'] == 1为失败
        }

        $this->display();
    }
}