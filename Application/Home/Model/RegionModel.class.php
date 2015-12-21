<?php
namespace Home\Model;
use Think\Model;
class RegionModel extends Model {
    public function header_city() {
        //echo 'header_city';//__PREFIX__
        $city1 = new \Think\Model();
        $sql = "select r.* from __PREFIX__store_shipping_region as ssr left join __PREFIX__region as r on ssr.city=r.region_id where ssr.city>0 group by ssr.city";
        $row_region = $city1->query($sql);
        foreach($row_region as $v) {
            $zimu = GetPinyin($v['region_name'], 1);
            //var_dump($zimu);
            $zimu = strtoupper(substr($zimu, 0, 1));
            $zimu_city[$zimu][] = array(
                'region_id' => $v['region_id'],
                'region_name' => $v['region_name']
            );
        }
        return $zimu_city;
        //var_dump($zimu_city);
    }
}