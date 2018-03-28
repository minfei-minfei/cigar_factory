<?php

$url = 'http://'.$_SERVER['HTTP_HOST']."/ThinAdmin/";
echo $url;
header("Location:".$url."error.php");

?>