<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>演示：PHP用户注册案例，支持验证用户名为手机、邮箱、用户名的注册方法</title>
    <meta name="keywords" content="PHP用户注册案例，支持验证用户名为手机、邮箱、用户名的注册方法" />
    <meta name="description" content="PHP用户注册案例，支持验证用户名为手机、邮箱、用户名的注册方法" />
    <link rel="stylesheet" type="text/css" href="http://www.sucaihuo.com/jquery/css/common.css" />
    <style type="text/css">
        .demo{width:400px; margin:40px auto 0 auto; min-height:250px;}
        .demo p{line-height:30px; padding:4px}
    </style>
</head>
<body>
<div class="head">
    <div class="head_inner clearfix">
        <ul id="nav">
            <li><a href="http://www.sucaihuo.com">首 页</a></li>
            <li><a href="http://www.sucaihuo.com/templates">网站模板</a></li>
            <li><a href="http://www.sucaihuo.com/js">网页特效</a></li>
            <li><a href="http://www.sucaihuo.com/php">PHP</a></li>
            <li><a href="http://www.sucaihuo.com/site">精选网址</a></li>
        </ul>
        <a class="logo" href="http://www.sucaihuo.com"><img src="http://www.sucaihuo.com/Public/images/logo.jpg" alt="素材火logo" /></a>
    </div>
</div>
<div class="container">
    <div class="demo">
        <h2 class="title"><a href="http://www.sucaihuo.com/js/325.html">教程：PHP激活用户注册验证邮箱</a></h2>

        <form id="reg" action="/tp3/index.php/Home/User" method="post" onsubmit="return chk_form();">
            <p>用户名：<input type="text" class="input" name="username" id="user"></p>
            <p>密 &nbsp; 码：<input type="password" class="input" name="password" id="pass"></p>
            <!--<p>E-mail：<input type="text" class="input" name="email" id="email"></p>-->
            <p><input type="submit" class="btn" value="提交注册"></p>
        </form>
    </div>
</div>
<div class="foot">
    Powered by sucaihuo.com  本站皆为作者原创，转载请注明原文链接：<a href="http://www.sucaihuo.com" target="_blank">www.sucaihuo.com</a>
</div>
<script type="text/javascript" src="http://libs.useso.com/js/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
    function chk_form() {
        var user = document.getElementById("user");
        if (user.value == "") {
            alert("用户名不能为空！");
            return false;
        }
        var pass = document.getElementById("pass");
        if (pass.value == "") {
            alert("密码不能为空！");
            return false;
        }
        var email = document.getElementById("email");
        if (email.value == "") {
            alert("Email不能为空！");
            return false;
        }
        var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email
        if (!preg.test(email.value)) {
            alert("Email格式错误！");
            return false;
        }
    }
</script>
</body>
</html>