<?php
//防止直接进入网站
require "login_is.php";

//接收日期参数
$date = date("Ymd",strtotime($_GET["start"]));
$dateEnd = date("Ymd",strtotime($_GET["end"]));
$single = "single".$_SESSION['ware'];
require_once "odbc_do_start.php";

while($date<$dateEnd){
    $dateNext = date("Ymd",strtotime($date)+86400);
    $sql = "select * from $single WHERE date = '$date'";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            //print_r($row);
            $identity = $row["identity"];
            $storWare = $row["storWare"];
            $storStack = $row["storStack"];
            $storName = $row["storName"];
            $type = $row["type"];
            $province = $row["province"];
            $tobaccoYear = $row["tobaccoYear"];
            $startItem_tsf = $row["endItem"];
            $startWeight_tsf = $row["endWeight"];
            $maxItem = $row["maxItem"];
            $maxWeight = $row["maxWeight"];
            $endItem = $startItem_tsf;
            $endWeight = $startWeight_tsf;
            $remainItem = $maxItem-$endItem;
            $remainWeight = $maxWeight-$endWeight;
            $sql_tsf = "INSERT INTO $single".
                "(date,identity,storWare,storStack,storName,type,province,tobaccoYear,startItem,startWeight,maxItem,maxWeight,curInItem,curInWeight,curOutItem,curOutWeight,endItem,endWeight,remainItem,remainWeight,remarks) " .
                "VALUES ('$dateNext',$identity,'$storWare','$storStack','$storName','$type','$province','$tobaccoYear',$startItem_tsf,$startWeight_tsf,$maxItem,$maxWeight,0,0,0,0,$endItem,$endWeight,$remainItem,$remainWeight,'')";
            //echo $sql_tsf;
            $result_tsf = mysqli_query($conn,$sql_tsf);
            if(!$result_tsf){
                //die("<br>Error!" . mysqli_error($conn));
                $root = 'http://'.$_SERVER['HTTP_HOST']."/Admin/";
                echo "<script>
                    self.location = '$root'+'error.php?error=2';
                  </script>";
                exit();
            }
        }
        //结转完成
        //过期时间10s
        $lifeTime = 10;
        setcookie("transfer", 1, time() + $lifeTime,"/");
        //setrawcookie("transfer",1,time()+60,"/");
        //@header("Location:../index.php");
        //echo "success";
    }else{
        //echo "没有需要结转的记录";
        setcookie("transfer", 2, time() + 10);
        //@header("Location:../index.php");
        //echo "null";
    }
    $date = $dateNext;
}
echo "success";
mysqli_close($conn);
