<?php
@session_start();
require "function.php";
$code = captcha_create(4);
captcha_show($code);
$_SESSION['cms']['captcha'] = $code;