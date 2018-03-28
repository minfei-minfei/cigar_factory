<?php
//防止直接进入网站
require "login_is.php";

$record = $_GET["record"];
$start = $_GET["start"];
require_once "odbc_do_start.php";
//删除此记录相同id的以后的所有记录
//查找id
$single = "single".$_SESSION['ware'];
$sql = "select * from $single WHERE record = '$record'";
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $identity_db = $row['identity'];
        $date_db = $row['date'];
    }
}else{
    //echo "找不到记录";
    $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
    echo "<script>
                self.location = '$root'+'error.php?error=1';
              </script>";
    exit();
}
$sql = "select * from $single WHERE identity = '$identity_db' AND date >= '$date_db' ORDER BY date";
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $record_del = $row['record'];
        //执行删除语句
        $sql_del = "DELETE FROM $single WHERE record = '$record_del'";
        $result_del = mysqli_query($conn,$sql_del);
        if (!$result_del) {
            //die("<br>Error!" . mysqli_error($conn));
            $root = 'http://' . $_SERVER['HTTP_HOST'] . "/Admin/";
            echo "<script>
                    self.location = '$root'+'error.php?error=2';
                  </script>";
            exit();
        }
    }
}else{
    //echo "找不到记录";
    $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
    echo "<script>
                self.location = '$root'+'error.php?error=1';
              </script>";
    exit();
}
mysqli_close($conn);
//删除成功！
$lifeTime = 10;//过期时间10s
setcookie("del", 1, time() + $lifeTime,"/");
@header("location:../table.php?start=".$start);
?>