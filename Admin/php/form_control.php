<?php
//防止直接进入网站
require "login_is.php";
//ajax验证
$storWare = $_GET['storWare'];
$storStack = $_GET['storStack'];
$storName = $_GET['storName'];
$province = $_GET['province'];
$tobaccoYear = $_GET['tobaccoYear'];
$date = date("Ymd",strtotime($_GET['date']));
$single = "single".$_SESSION['ware'];
/*查找是否为当日已经记录的卷烟品种*/
require "odbc_do_start.php";


$sql_id = "SELECT * FROM $single WHERE storWare='$storWare' AND storStack='$storStack' AND storName = '$storName' AND province = '$province' AND tobaccoYear = '$tobaccoYear' AND date >= '$date'";
$result_id = mysqli_query($conn,$sql_id);
if (mysqli_num_rows($result_id) > 0) {
    echo "danger";
}else if(mysqli_num_rows($result_id) == 0){
    echo "safe";
}else{
    echo "error";
}
mysqli_close($conn);
