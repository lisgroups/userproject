<?php
/**
 *  用户登录函数
 *
 * @access  public
 * @param   string  $username
 * @param   string  $password
 *
 * @return void
 */
function login($username, $password, $remember = null)
{
    if ($this->check_user($username, $password) > 0)
    {
        if ($this->need_sync)
        {
            $this->sync($username,$password);
        }
        $this->set_session($username);
        $this->set_cookie($username, $remember);

        return true;
    }
    else
    {
        return false;
    }
}
/**
 *  设置指定用户SESSION
 *
 * @access  public
 * @param
 *
 * @return void
 */
function set_session ($username='')
{
    if (empty($username))
    {
        $GLOBALS['sess']->destroy_session();
    }
    else
    {
        $sql = "SELECT user_id, password, email,mobile_phone, headimg FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_name='$username' LIMIT 1";
        $row = $GLOBALS['db']->getRow($sql);

        if ($row)
        {
            $_SESSION['user_id']   = $row['user_id'];
            $_SESSION['user_name'] = $username;
            $_SESSION['email']     = $row['email'];
            $_SESSION['mobile_phone'] = $row['mobile_phone'];
            $_SESSION['headimg'] = $row['headimg'];
        }
    }
}
/**
 *  设置cookie
 *
 * @access  public
 * @param
 *
 * @return void
 */
function set_cookie($username='', $remember= null )
{
    if (empty($username))
    {
        /* 摧毁cookie */
        $time = time() - 3600;
        setcookie("ECS[user_id]",  '', $time, $this->cookie_path);
        setcookie("ECS[password]", '', $time, $this->cookie_path);
        setcookie("ECS[username]", '', $time, $this->cookie_path);

    }
    elseif ($remember)
    {
        /* 设置cookie */
        $time = time() + 3600 * 24 * 15;

        setcookie("ECS[username]", $username, $time, $this->cookie_path, $this->cookie_domain);
        $sql = "SELECT user_id, password FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_name='$username' LIMIT 1";
        $row = $GLOBALS['db']->getRow($sql);
        if ($row)
        {
            setcookie("ECS[user_id]", $row['user_id'], $time, $this->cookie_path, $this->cookie_domain);
            setcookie("ECS[password]", $row['password'], $time, $this->cookie_path, $this->cookie_domain);
        }
    }
}

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

function GetPinyin($str, $ishead=0, $isclose=1) {
    global $pinyins;
    $restr = '';
    $str = trim($str);
    if(EC_CHARSET != 'gbk') {
        $str = iconv(EC_CHARSET, 'gbk', $str);
    }
    $slen = strlen($str);
    if($slen < 2) {
        return $str;
    }
    if(count($pinyins) == 0) {
        $fp = fopen(ROOT_PATH.'userproject/Public/codetable/pinyin.dat', 'r');
        while(!feof($fp)) {
            $line = trim(fgets($fp));
            $pinyins[$line[0].$line[1]] = substr($line, 3, strlen($line)-3);
        }
        fclose($fp);
    }
    for($i=0; $i<$slen; $i++) {
        if(ord($str[$i])>0x80) {
            $c = $str[$i].$str[$i+1];
            $i++;
            if(isset($pinyins[$c])) {
                if($ishead==0) {
                    $restr .= $pinyins[$c];
                }
                else {
                    $restr .= $pinyins[$c][0];
                }
            }else {
                $restr .= "_";
            }
        }else if( preg_match("/[a-z0-9]/i", $str[$i]) ) {
            $restr .= $str[$i];
        }
        else {
            $restr .= "_";
        }
    }
    if($isclose==0) {
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

