<?php

//检查变量是否为空
function check_empty($data) {
    if(trim($data)=='') {
        return false;
    }
    return true;
}

//获取GMTime
function get_gmtime()
{
    return time();
}

function valid_tag($str)
{

    return preg_replace("/<(?!div|ol|ul|li|sup|sub|span|br|img|p|h1|h2|h3|h4|h5|h6|\/div|\/ol|\/ul|\/li|\/sup|\/sub|\/span|\/br|\/img|\/p|\/h1|\/h2|\/h3|\/h4|\/h5|\/h6|blockquote|\/blockquote|strike|\/strike|b|\/b|i|\/i|u|\/u)[^>]*>/i","",$str);
}


?>