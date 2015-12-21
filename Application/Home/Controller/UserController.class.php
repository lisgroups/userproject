<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
        header("Content-type:text/html;charset=utf-8");
        $this->display();
    }

    //注册方法
    public function register() {
        if(IS_POST) {
            var_dump($_POST);
        }
        $this->display();
    }
}