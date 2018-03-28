<?php
/*退出登录*/
@session_start();
//释放指定的session变量isLogin
//unset($_SESSION['isLogin']);
//彻底销毁 session
session_destroy();
$lifeTime = 10;//过期时间10s
setcookie("logout", 1, time() + $lifeTime,"/");
@header("Location:../login.php");
?>