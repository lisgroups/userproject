<?php
/**
 *created by 2261617274@qq.com at 2015-10-15 15:18:06
 *@param 姓名
 *@return 笔画数
 *author：winter
 *getNamenum(‘王小明’);
 */
function getNamenum($name){
    $sur = mb_substr($name,0,1,'utf-8');
    $t_hz = M('namenum');
    $thzval = $t_hz->field('sum')->where("chinese='".$sur."'")->find();
    return $thzval['sum'];
}

function GetPinyin($str, $ishead=0, $isclose=1)
{
    global $pinyins;
    $restr = '';
    $str = trim($str);
    if(EC_CHARSET != 'gbk')
    {
        $str = iconv(EC_CHARSET, 'gbk', $str);
    }
    $slen = strlen($str);
    if($slen < 2)
    {
        return $str;
    }
    if(count($pinyins) == 0)
    {
        $fp = fopen(ROOT_PATH.'includes/codetable/pinyin.dat', 'r');
        while(!feof($fp))
        {
            $line = trim(fgets($fp));
            $pinyins[$line[0].$line[1]] = substr($line, 3, strlen($line)-3);
        }
        fclose($fp);
    }
    for($i=0; $i<$slen; $i++)
    {
        if(ord($str[$i])>0x80)
        {
            $c = $str[$i].$str[$i+1];
            $i++;
            if(isset($pinyins[$c]))
            {
                if($ishead==0)
                {
                    $restr .= $pinyins[$c];
                }
                else
                {
                    $restr .= $pinyins[$c][0];
                }
            }else
            {
                $restr .= "_";
            }
        }else if( preg_match("/[a-z0-9]/i", $str[$i]) )
        {
            $restr .= $str[$i];
        }
        else
        {
            $restr .= "_";
        }
    }
    if($isclose==0)
    {
        unset($pinyins);
    }
    return $restr;
}

/*
 * 获取选择的城市下的所有信息
 */
function insert_select_region($arr){
    global $ecs,$db,$smarty;
    $need_cache = $smarty->caching;
    $need_compile = $smarty->force_compile;

    $newpcca = array();
    $pcca = $_REQUEST['datainfo'];
    foreach($pcca as $key=>$val){
        if(isset($_REQUEST[$val]) && intval($_REQUEST[$val])>0){
            $newpcca[$key]=intval($_REQUEST[$val]);
        }
    }
    //echo "<pre>";
    //print_r($newpcca);
    $regions =array();
    foreach($newpcca as $k=>$v){

        if($k == 1){//所有省
            $sql = "select r.region_id,r.region_name from ". $ecs->table("store_shipping_region") ." as ssr left join ". $ecs->table("region") ." as r on ssr.".$pcca[$k]."=r.region_id where ssr.".$pcca[$k].">0 group by ".$pcca[$k];
        }else{//所有市，县，区
            //$sql = "select region_id,region_name from ". $ecs->table("region") ." where parent_id = ".$newpcca[$k-1];
            $sql = "select r.region_id,r.region_name from ". $ecs->table("store_shipping_region") ." as ssr left join ". $ecs->table("region") ." as r on ssr.".$pcca[$k]."=r.region_id where ssr.".$pcca[$k].">0 and ssr.".$pcca[$k-1]."=".$newpcca[$k-1]." group by ".$pcca[$k];
        }
        //$sql = "select r.region_id,r.region_name from ". $ecs->table("store_shipping_region") ." as ssr left join ". $ecs->table("region") ." as r on ssr.".$pcca[$k]."=r.region_id where ssr.".$pcca[$k].">0 group by ".$pcca[$k];
        $res= $db->query($sql);
        while($row = $db->fetchRow($res))
        {
            $regions[$pcca[$k]][$row['region_id']] = $row['region_name'] ;
        }
    }
    $names = array();
    $sql = "select region_id,region_name,region_type from ". $ecs->table("region") ." where region_id in (".implode(',',$newpcca).")";
    $ress = $db->query($sql);
    while($rows = $db->fetchRow($ress)){
        $names[$rows['region_type']] = $rows['region_name'];
    }
    ksort($names);
    foreach($pcca as $key=>$val){//填满四个地区的位置
        if(!isset($names[$key])){
            $names[$key] = '';
        }
    }


    $smarty->assign('divlevels',$pcca);//共多少级层
    $smarty->assign('levelsinfo',$regions);//每级层当中的内容
    $smarty->assign('shownames',$names);//要显示的地址名称
    $smarty->assign('fullname',implode('',$names));//要显示的全名
    $smarty->assign('from',$arr['from']);
    $smarty->assign('address_title',$arr['title']);

    $val = $smarty->fetch('library/region_city.lbi');

    $smarty->caching = $need_cache;
    $smarty->force_compile = $need_compile;

    return $val;
}

