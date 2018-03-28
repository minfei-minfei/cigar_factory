<?php
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
}
mysqli_close($conn);
