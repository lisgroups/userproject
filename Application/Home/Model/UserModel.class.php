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
    /**用户登录方法
     * 请求方法：POST请求
     * 参数：username,password
     **/
    public function login($username, $password) {
        if(empty($username) || empty($password)) {
            $data = array('error'=>1, 'msg'=>'用户名或密码不能为空');
            return $data;
        }
        if( preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username) ) {
            $data = array('error'=>1, 'msg'=>'用户名格式不正确');
            return $data;
        }
        $userinfo = $this->where(array('user_name'=>$username))->find();
        return $userinfo;
    }
    /**用户注册方法
     * 参数：username,password
     **/
    public function register($username, $password) {
        if(empty($username) || empty($password)) {
            $data = array('error'=>1, 'msg'=>'用户名或密码不能为空');
            return $data;
        }
        if( preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username) ) {
            $data = array('error'=>1, 'msg'=>'用户名格式不正确');
            return $data;
        }
        //首先判断用户名是否重复
        if($this->where(array('user_name'=>$username))->count()) {
            $data = array('error'=>1, 'msg'=>'此用户名已经注册');
            return $data;
        }
        //密码加密处理
        //1.生成8位随机密钥
        $salt = rand(10,99).substr(uniqid(),7,6);
        $new_password = md5(md5($password).$salt);
        $arr = array('user_name'=>$username, 'password'=>$new_password, 'salt'=>$salt, 'regtime'=>time());

        import('Org.Util.Verify');//引入验证类
        $verify = new \Verify();
        $extends = array();
        //1.如果用户格式为手机号
        if($verify->isMobile($username)) {
            $extends = array('phone'=>$username);
        }
        //2.如果用户格式为邮箱
        if($verify->isEmail($username)) {
            //此处需要生成token,暂时未添加
            $extends = array('email'=>$username);
        }

        //合并数据
        $arr = array_merge($arr,$extends);
        //var_dump($arr);exit;
        if($this->add($arr)) {
            $data = array('error'=>0, 'msg'=>'用户注册成功');
        }else {
            $data = array('error'=>1, 'msg'=>'用户注册失败,请稍后重试');
        }
        return $data;
    }
}