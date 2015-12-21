<?php
namespace Home\Model;
use Think\Model;
class IndexModel extends Model {
    public function header_city() {
        echo 'header_city';//__PREFIX__
        $city1 = new \Think\Model();
        $sql = "select r.* from __PREFIX__store_shipping_region as ssr left join __PREFIX__region as r on ssr.city=r.region_id where ssr.city>0 group by ssr.city";
        $rs = $city1->query($sql);
        var_dump($rs);
    }
}