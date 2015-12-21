<?php if (!defined('THINK_PATH')) exit();?><li onMouseOver="show_city1();" onMouseOut="hide_city1();"><font style="color:#fff;" id='header_city_name'><?php echo ($nowcityname); ?></font>
    <div id="city-box1" style="display:block;">
        <table width="100%" cellpadding=5 cellspacing=1>
            <tr>
                <td class="nowcityname" colspan=2>当前城市：<b id='header_city_name2'><?php echo ($nowcityname); ?></b></td>
            </tr>
            <?php if(is_array($zimu_city)): foreach($zimu_city as $city_key=>$city_val): ?><tr>
                <td width="8%" valign="top" class="city_key" style=""><b><?php echo ($city_key); ?></b></td>
                <td valign="top"  class="city_key">
                    <?php if(is_array($city_val)): foreach($city_val as $key=>$ccity): ?><a href="javascript:void(0)" onclick="chang_city('<?php echo ($ccity["region_id"]); ?>')" class="region_name"><?php echo ($ccity["region_name"]); ?></a>&nbsp;<?php endforeach; endif; ?>
                </td>
            </tr><?php endforeach; endif; ?>
        </table>
    </div>
</li>