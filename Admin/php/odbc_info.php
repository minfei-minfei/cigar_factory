<?php
ini_set('display_errors', 1);//打开报错信息
ini_set('date.timezone','Asia/Shanghai');//设置时区
/*连接数据库*/
$host ="qdm168866513.my3w.com";//服务器地址
$root ="qdm168866513";//用户名
$password ="19970711smf";//密码
$database ="qdm168866513_db";//数据库名
$conn = mysqli_connect($host, $root, $password,$database);// 创建连接
mysqli_query($conn,"set names 'utf8'");//设置编码为utf-8
if(!$conn){
    //die("数据库连接失败!".mysqli_connect_error());
    $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
    echo "<script>
            self.location = '$root'+'error.php?error=0';
          </script>";
    exit();
}else {
    //echo "数据库连接成功！<br>";
    //查看数据库login
    $sql_login = "SELECT * FROM login";
    $result_login = mysqli_query($conn, $sql_login);
    if (mysqli_num_rows($result_login) > 0) {
        //echo "num=".mysqli_num_rows($result_login)."<br>";
        $wares_db = array();
        while($row_login = mysqli_fetch_assoc($result_login)) {
            $admin_db = $row_login["admin"];
            $psd_db = $row_login["psd"];
            $ware_db = $row_login["warehouse"];
            $wares_db[$ware_db]=array($admin_db,$psd_db);
        }
        //print_r($wares_db);
    }else{
        //echo "找不到账号";
        $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
        echo "<script>
                self.location = '$root'+'error.php?error=1';
              </script>";
        exit();
    }

}
mysqli_close($conn);
