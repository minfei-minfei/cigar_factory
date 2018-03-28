<?php
/*连接数据库*/
$host ="localhost";//服务器地址
$root ="root";//用户名
$password ="root";//密码
$database ="cigar_factor";//数据库名
$conn = mysqli_connect($host, $root, $password,$database);// 创建连接
mysqli_query($conn,"set names 'utf8'");//设置编码为utf-8
if(!$conn){
    //die("数据库连接失败!".mysqli_connect_error());
    echo "<script>
            self.location = 'error.php?error=0';
          </script>";
    exit();
}else {
    //echo"数据库连接成功";
}
ini_set('display_errors', 1);//打开报错信息
ini_set('date.timezone','Asia/Shanghai');//设置时区



