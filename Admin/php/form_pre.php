<?php
//防止直接进入网站
require "login_is.php";
/*echo "<br>默认时区：".date_default_timezone_get();
echo "<br>日期".date("Y/m/d");
echo "<br>时间".date("H:i:s");
echo "<br>";*/

//插入数据（提交表单）
$storWare = $_POST["storWare"];
$storStack = $_POST["storStack"];
$storName = $_POST["storName"];
$type = $_POST["type"];
$province = $_POST["province"];
$tobaccoYear = $_POST["tobaccoYear"];
$startItem = $_POST["startItem"];
$startWeight = $_POST["startWeight"];
$maxItem = $_POST["maxItem"];
$maxWeight = $_POST["maxWeight"];
$curInItem = $_POST["curInItem"];
$curInWeight = $_POST["curInWeight"];
$curOutItem = $_POST["curOutItem"];
$curOutWeight = $_POST["curOutWeight"];
$endItem = $_POST["endItem"];
$endWeight = $_POST["endWeight"];
$remainItem = $_POST["remainItem"];
$remainWeight = $_POST["remainWeight"];
$remarks = $_POST["remarks"];
$date = $_POST["date"];

if($date==""){
    $date = date("Ymd");//年月日
    $start = date("Y-m-d");
}else{
    $date = date("Ymd",strtotime($date));
    $start = date("Y-m-d",strtotime($date));
}

//identity=库号+垛位号+名称+省份+存放年份，是用来标志不同的垛位存放不同的卷烟
/*查找是否为已经记录的卷烟品种*/
require_once "odbc_do_start.php";
$store = "store".$_SESSION['ware'];
$sql_id = "SELECT * FROM $store WHERE storWare='$storWare' AND storStack='$storStack' AND storName = '$storName' AND province = '$province' AND tobaccoYear = '$tobaccoYear'";
//echo $sql_id;
$result_id = mysqli_query($conn,$sql_id);
if (mysqli_num_rows($result_id) == 0) {
    //此品种为新品种
    $sql_new_id = "INSERT INTO $store".
        "(storWare,storStack,storName,province,tobaccoYear)".
        "VALUES ('$storWare','$storStack','$storName','$province','$tobaccoYear')";
    $result_new_id = mysqli_query($conn,$sql_new_id);//返回boolean值
    if($result_new_id){
        //重新查询
        $sql_id = "SELECT * FROM $store WHERE storWare='$storWare' AND storStack='$storStack' AND storName = '$storName' AND province = '$province' AND tobaccoYear = '$tobaccoYear'";
        $result_id = mysqli_query($conn,$sql_id);
        if (mysqli_num_rows($result_id) > 0) {
            //记录成功！
            while($row_id = mysqli_fetch_assoc($result_id)) {
                $identity_db = $row_id["identity"];
            }
        }else{
            //记录失败！
            //die("<br>Error!" . mysqli_error($conn));
            $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
            echo "<script>
                    self.location = '$root'+'error.php?error=2';
                  </script>";
            exit();
        }
    } else{
        //记录失败！
        //die("<br>Error!" . mysqli_error($conn));
        $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
        echo "<script>
                self.location = '$root'+'error.php?error=2';
              </script>";
        exit();
    }
}else{
    //库存中已有记录
    //echo "库存中已有记录！";
    while($row_id = mysqli_fetch_assoc($result_id)) {
        $identity_db = $row_id["identity"];
    }
}
//echo $identity_db;
/*===============================================*/
//更新数据（修改表单）
$update_b = $_GET["update"];
$update_record = $_GET["record"];
$single = "single".$_SESSION['ware'];
if($update_b){
    //更新
    $sql = "replace into $single".
        " (record,date,identity,storWare,storStack,storName,type,province,tobaccoYear,startItem,startWeight,maxItem,maxWeight,curInItem,curInWeight,curOutItem,curOutWeight,endItem,endWeight,remainItem,remainWeight,remarks)".
        "VALUES ($update_record,'$date',$identity_db,'$storWare','$storStack','$storName','$type','$province','$tobaccoYear',$startItem,$startWeight,$maxItem,$maxWeight,$curInItem,$curInWeight,$curOutItem,$curOutWeight,$endItem,$endWeight,$remainItem,$remainWeight,'$remarks')";

}else{
    //插入
$sql ="INSERT INTO $single".
    "(date,identity,storWare,storStack,storName,type,province,tobaccoYear,startItem,startWeight,maxItem,maxWeight,curInItem,curInWeight,curOutItem,curOutWeight,endItem,endWeight,remainItem,remainWeight,remarks) " .
    "VALUES ('$date',$identity_db,'$storWare','$storStack','$storName','$type','$province','$tobaccoYear',$startItem,$startWeight,$maxItem,$maxWeight,$curInItem,$curInWeight,$curOutItem,$curOutWeight,$endItem,$endWeight,$remainItem,$remainWeight,'$remarks')";
}
//echo $sql;
$result = mysqli_query($conn,$sql);
if(!$result){
    //die("<br>Error!" . mysqli_error($conn));
    $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
    echo "<script>
            self.location = '$root'+'error.php?error=2';
          </script>";
    exit();
}else{
    //echo "<br>Success!";
if($update_b){
    //更新语句执行完以后检查是否需要修改关联记录(日期大于当前修改日期)
    $sql = "select * from $single WHERE identity = $identity_db AND date > '$date' ORDER BY date";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
        //echo "num=".mysqli_num_rows($result);
        $endItem_temp = $endItem;
        $endWeight_temp = $endWeight;
        while ($row = mysqli_fetch_assoc($result)) {
            $record_tsf = $row["record"];
            $date_tsf = $row["date"];
            $curInItem_tsf = $row["curInItem"];
            $curInWeight_tsf = $row["curInWeight"];
            $curOutItem_tsf = $row["curOutItem"];
            $curOutWeight_tsf = $row["curOutWeight"];
            $startItem_tsf = $endItem_temp;
            $startWeight_tsf = $endWeight_temp;
            $endItem_tsf = $startItem_tsf + $curInItem_tsf - $curOutItem_tsf;
            $endWeight_tsf = $startWeight_tsf + $curInWeight_tsf - $curOutWeight_tsf;
            $remainItem_tsf = $maxItem - $endItem_tsf;
            $remainWeight_tsf = $maxWeight - $endWeight_tsf;
            $remarks_tsf = $row["remarks"];
            //更新
            $sql_tsf = "replace into $single".
                " (record,date,identity,storWare,storStack,storName,type,province,tobaccoYear,startItem,startWeight,maxItem,maxWeight,curInItem,curInWeight,curOutItem,curOutWeight,endItem,endWeight,remainItem,remainWeight,remarks)".
                "VALUES ($record_tsf,'$date_tsf',$identity_db,'$storWare','$storStack','$storName','$type','$province','$tobaccoYear',$startItem_tsf,$startWeight_tsf,$maxItem,$maxWeight,$curInItem_tsf,$curInWeight_tsf,$curOutItem_tsf,$curOutWeight_tsf,$endItem_tsf,$endWeight_tsf,$remainItem_tsf,$remainWeight_tsf,'$remarks_tsf')";

            echo $sql_tsf;
            $result_tsf = mysqli_query($conn, $sql_tsf);
            if (!$result_tsf) {
                //die("<br>Error!" . mysqli_error($conn));
                $root = 'http://' . $_SERVER['HTTP_HOST'] . "/Admin/";
                echo "<script>
                    self.location = '$root'+'error.php?error=2';
                  </script>";
                exit();
            }
            //下一条记录基准
            //$endItem_temp = $row["endItem"];
            //$endWeight_temp = $row["endWeight"];
            $endItem_temp = $endItem_tsf;
            $endWeight_temp = $endWeight_tsf;
        }
    }
    //修改成功！
    $lifeTime = 10;//过期时间10s
    setcookie("update", 1, time() + $lifeTime,"/");
}else{
    //添加完要检查是否同步以后的日期
    $sql = "select DISTINCT date from $single WHERE date > '$date' ORDER BY date";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $date = $row["date"];
            $startItem_tsf = $endItem;
            $startWeight_tsf = $endWeight;
            $endItem_tsf = $startItem_tsf;
            $endWeight_tsf = $startWeight_tsf;
            $remainItem_tsf = $maxItem - $endItem_tsf;
            $remainWeight_tsf = $maxWeight - $endWeight_tsf;
            //插入
            $sql_tsf = "INSERT INTO $single".
                "(date,identity,storWare,storStack,storName,type,province,tobaccoYear,startItem,startWeight,maxItem,maxWeight,curInItem,curInWeight,curOutItem,curOutWeight,endItem,endWeight,remainItem,remainWeight,remarks) " .
                "VALUES ('$date',$identity_db,'$storWare','$storStack','$storName','$type','$province','$tobaccoYear',$startItem_tsf,$startWeight_tsf,$maxItem,$maxWeight,0,0,0,0,$endItem,$endWeight,$remainItem,$remainWeight,'')";
            //echo $sql_tsf;
            $result_tsf = mysqli_query($conn, $sql_tsf);
            if (!$result_tsf) {
                //die("<br>Error!" . mysqli_error($conn));
                $root = 'http://' . $_SERVER['HTTP_HOST'] . "/Admin/";
                echo "<script>
                    self.location = '$root'+'error.php?error=2';
                  </script>";
                exit();
            }
        }
    }
    //修改成功！
    $lifeTime = 10;//过期时间10s
    setcookie("add", 1, time() + $lifeTime,"/");
}
    @header("Location:../table.php?start=".$start);
}

mysqli_close($conn);
?>
