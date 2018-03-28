<?php
//判断是否登录
@session_start();
//echo "login_is=".$_SESSION['isLogin'];
//非法入侵
if($_SESSION['isLogin'] != 1)
{
    $_SESSION['isLogin'] = 3;
    //重定向
    $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
    echo "<script>
            self.location = '$root'+'login.php';
          </script>";
    exit();
}
//用户10分钟内无操作，自动退出
if(isset($_SESSION['last_access']) && (time()-$_SESSION['last_access'])>600)
{
    //修改isLogin
    $_SESSION['isLogin'] = 2;
    //释放last_access
    unset($_SESSION['last_access']);
    $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
    echo "<script>
            self.location = '$root'+'login.php';
          </script>";
    exit();
}
//session 中last_access的值没有设置或者设置的时间大于30秒就重新设置为当前时间
if(!isset($_SESSION['last_access'])||(time()-$_SESSION['last_access'])>30)
{
    $_SESSION['last_access'] = time();
    //echo "最后一次操作时间：".$_SESSION['last_access'];
}



