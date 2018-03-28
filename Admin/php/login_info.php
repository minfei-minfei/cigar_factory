<?php

function get_os(){
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $os = false;

    if (preg_match('/win/i', $agent) && strpos($agent, '95'))
    {
        $os = 'Windows 95';
    }
    else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))
    {
        $os = 'Windows ME';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))
    {
        $os = 'Windows 98';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent))
    {
        $os = 'Windows Vista';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent))
    {
        $os = 'Windows 7';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent))
    {
        $os = 'Windows 8';
    }else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent))
    {
        $os = 'Windows 10';#添加win10判断
    }else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent))
    {
        $os = 'Windows XP';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent))
    {
        $os = 'Windows 2000';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent))
    {
        $os = 'Windows NT';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent))
    {
        $os = 'Windows 32';
    }
    else if (preg_match('/linux/i', $agent))
    {
        $os = 'Linux';
    }
    else if (preg_match('/unix/i', $agent))
    {
        $os = 'Unix';
    }
    else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent))
    {
        $os = 'SunOS';
    }
    else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent))
    {
        $os = 'IBM OS/2';
    }
    else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent))
    {
        $os = 'Macintosh';
    }
    else if (preg_match('/PowerPC/i', $agent))
    {
        $os = 'PowerPC';
    }
    else if (preg_match('/AIX/i', $agent))
    {
        $os = 'AIX';
    }
    else if (preg_match('/HPUX/i', $agent))
    {
        $os = 'HPUX';
    }
    else if (preg_match('/NetBSD/i', $agent))
    {
        $os = 'NetBSD';
    }
    else if (preg_match('/BSD/i', $agent))
    {
        $os = 'BSD';
    }
    else if (preg_match('/OSF1/i', $agent))
    {
        $os = 'OSF1';
    }
    else if (preg_match('/IRIX/i', $agent))
    {
        $os = 'IRIX';
    }
    else if (preg_match('/FreeBSD/i', $agent))
    {
        $os = 'FreeBSD';
    }
    else if (preg_match('/teleport/i', $agent))
    {
        $os = 'teleport';
    }
    else if (preg_match('/flashget/i', $agent))
    {
        $os = 'flashget';
    }
    else if (preg_match('/webzip/i', $agent))
    {
        $os = 'webzip';
    }
    else if (preg_match('/offline/i', $agent))
    {
        $os = 'offline';
    }
    else
    {
        $os = '未知操作系统';
    }
    return $os;
}
function browser(){
    $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
    if (stripos($sys, "Firefox/") > 0) {
        preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
        $exp[0] = "Firefox";
        $exp[1] = $b[1];  //获取火狐浏览器的版本号
    } elseif (stripos($sys, "Maxthon") > 0) {
        preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
        $exp[0] = "傲游";
        $exp[1] = $aoyou[1];
    } elseif (stripos($sys, "MSIE") > 0) {
        preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
        $exp[0] = "IE";
        $exp[1] = $ie[1];  //获取IE的版本号
    } elseif (stripos($sys, "OPR") > 0) {
        preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
        $exp[0] = "Opera";
        $exp[1] = $opera[1];
    } elseif(stripos($sys, "Edge") > 0) {
        //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
        preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
        $exp[0] = "Edge";
        $exp[1] = $Edge[1];
    } elseif (stripos($sys, "Chrome") > 0) {
        preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
        $exp[0] = "Chrome";
        $exp[1] = $google[1];  //获取google chrome的版本号
    } elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){
        preg_match("/rv:([\d\.]+)/", $sys, $IE);
        $exp[0] = "IE";
        $exp[1] = $IE[1];
    }else {
        $exp[0] = "未知浏览器";
        $exp[1] = "";
    }
    return $exp[0].'('.$exp[1].')';
}
function clientIp(){
    $cIP= getenv($_SERVER['REMOTE_ADDR']);
    $cIP1 = getenv($_SERVER['HTTP_X_FORWORD_FOR']);
    $cIP2 = getenv($_SERVER['HTTP_CLIENT_IP']);
    $cIP1?$cIP= $cIP1:null;
    $cIP2?$cIP = $cIP2:null;
    return $cIP;
}
function serverIP(){
 return gethostbyname($_SERVER['SERVER_NAME']);
}
/*
 * 获取客户端的真实IP地址
 */
function get_client_ip_from_ns($proxy_override = false)
{
    if ($proxy_override) {
        /* 优先从代理那获取地址或者 HTTP_CLIENT_IP 没有值 */
        $ip = empty($_SERVER["HTTP_X_FORWARDED_FOR"]) ? (empty($_SERVER["HTTP_CLIENT_IP"]) ? NULL : $_SERVER["HTTP_CLIENT_IP"]) : $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        /* 取 HTTP_CLIENT_IP, 虽然这个值可以被伪造, 但被伪造之后 NS 会把客户端真实的 IP 附加在后面 */
        $ip = empty($_SERVER["HTTP_CLIENT_IP"]) ? NULL : $_SERVER["HTTP_CLIENT_IP"];
    }

    if (empty($ip)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    /* 真实的IP在以逗号分隔的最后一个, 当然如果没用代理, 没伪造IP, 就没有逗号分离的IP */
    if ($p = strrpos($ip, ",")) {
        $ip = substr($ip, $p+1);
    }

    return trim($ip);
}

/*
 * 检查客户端从什么地方过来的请求
 */
function check_client_referer($restrict = true, $allow = '.xx5.com')
{
    $referer = isset($_SERVER['HTTP_REFERER']) ? trim($_SERVER['HTTP_REFERER']) : null;
    if (empty($referer)) { return true;    } /* 空的 referer 直接允许 */

    if ($restrict) {

        /* 更加严格的查检, 此值为true时, allow 可以输入正则来匹配 */
        $url = parse_url($referer);
        /* host 为空时直接返回不false */
        if (empty($url['host'])) { return false; }

        /* 将正则中的.替换掉为\.真正匹配.再进行匹配 */
        $allow = '/'.str_replace('.', '\.', $allow).'/';
        return 0 < preg_match($allow, $url['host']);
    }

    return false !== strpos($referer, $allow);
}
function get_ip() {
    $unknown = 'unknown';
    if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown) ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    /*
    处理多层代理的情况
    或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
    */
    if (false !== strpos($ip, ','))
        $ip = reset(explode(',', $ip));
    return $ip;
}

$loginOs = get_os();
$loginBro = browser();
$clientIp = clientIP();
$serverIp = serverIP();
$trueIp = get_ip();
$from = get_client_ip_from_ns();
$check = check_client_referer();

/*echo "<br>";
echo "os=".$loginOs." bro=".$loginBro." clientIp=".$clientIp." serverIp=".$serverIp;
echo " trueIp=".$tureIp." from=".$from." check=".$check;*/
