<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-21
 * Time: 17:24
 */
namespace Home\Model;
use Think\Model;
class UserModel extends Model {
    /**用户注册方法
     * 参数：username,password
     **/
    public function register($username,$password) {
        if(empty($username) || empty($password)) {
            $data = array('error'=>1, 'msg'=>'用户名或密码不能为空');
            return $data;
        }
        if( preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username) ) {
            $data = array('error'=>1, 'msg'=>'用户名格式不正确');
            return $data;
        }
        //密码加密处理
        //1.生成8位随机密钥
        $salt = rand(10,99).substr(uniqid(),7,6);
        $new_password = md5(md5($password).$salt);
        $arr = array('username'=>$username, 'password'=>$new_password, 'salt'=>$salt);
        import('Org.Util.Verify');
        $verify = new \Verify();
        //1.如果用户格式为手机号
        if($verify->isMobile($username)) {
            $extends = array('mobile'=>$username);
        }
        //2.如果用户格式为邮箱
        if($verify->isEmail($username)) {
            $extends = array('email'=>$username);
        }

    }
}