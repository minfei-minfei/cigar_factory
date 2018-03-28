<?php
@session_start();
require "odbc_info.php";
require "function.php";
$ware = htmlspecialchars($_GET['ware']);
//选择仓库
if(!$ware){
    echo "ware_not";
    exit();
}
//验证码
if($ware==6){
    $captcha = htmlspecialchars($_GET['code']);
    if(!checkCode($captcha)){
        echo "captcha_err";
        exit();
    }
}

//检查登录名和密码
$admin=htmlspecialchars($_GET['admin']);
$psd=htmlspecialchars($_GET['psd']);
$admin_db = passport_decrypt($wares_db[$ware][0],"iloveshiminfei");
$psd_db = passport_decrypt($wares_db[$ware][1],"iloveshiminfei");
if($admin==$admin_db && $psd==$psd_db && $ware){
    //记录session
    $_SESSION['isLogin']=1;
    $_SESSION['ware']=$ware;
    $lifeTime = 10;//过期时间10s
    setcookie("isLogin", 1, time() + $lifeTime,"/");
//插入管理员登录日志
    require_once "login_info.php";
    require_once "odbc_do_start.php";
    $sessionId = session_id();
    $time = date("Y-m-d H:i:s");
     $sql="INSERT INTO adminlog".
         "(os,browser,ip,sessionId,time,warehouse) " .
         "VALUES ('$loginOs','$loginBro','$trueIp','$sessionId','$time',$ware)";
//echo $sql;
    $result = mysqli_query($conn,$sql);
    if(!$result){
        //die("<br>Error!" . mysqli_error($conn));
        echo "failed";
    }else{
        //echo "<br>Success!";
        echo "success";
    }
    mysqli_close($conn);
}else{
    echo "error";
}
