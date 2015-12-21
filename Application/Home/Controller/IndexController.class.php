<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //header("Content-type:text/html;charset=utf-8");
        $index = D('Region');
        $zimu_city = $index->header_city();
        $this->assign('zimu_city', $zimu_city);
        $this->assign('nowcityname','苏州');
        $this->display();
    }

    //获取用户笔画数
    public function num() {
        $num = getNamenum('晓');
        echo $num;
        $this->display();
    }
}