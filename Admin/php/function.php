<?php
//加密函数
function passport_encrypt($txt,$key){
    $encrypt_key = md5(rand(0,32000));
    $ctr = 0;
    $tmp = '';
    for($i=0;$i<strlen($txt);$i++){
        $ctr = $ctr==strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
    }
    return base64_encode(passport_key($tmp,$key));
}
//解密函数
function passport_decrypt($txt,$key){
    $txt = passport_key(base64_decode($txt),$key);
    $tmp = '';
    for($i=0;$i<strlen($txt);$i++){
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

//生成长度为64的字符串
function passport_key($txt,$encrypt_key){
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    for($i=0;$i<strlen($txt);$i++){
        $ctr = $ctr==strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}

//生成验证码（参数$count表示生成位）
function captcha_create($count=5){
    $code = '';
    $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($charset) - 1;
    for($i=0; $i<$count; $i++){
        $code .= $charset[rand(0,$len)];
    }
    return $code;
}
//输出验证码图像（参数$code是验证码）
function captcha_show($code){
    $im = imagecreate($x=130,$y=40);
    imagecolorallocate($im,rand(50,200),rand(0,155),rand(0,155));
    $fontColor = imagecolorallocate($im,255,255,255);
    $fontStyle = '../font/captcha1.ttf';
    //生成指定长度的验证码
    for($i=0, $len=strlen($code); $i<$len; ++$i){
        imagettftext($im,
            20,
            rand(0,20) - rand(0,25),
            12+$i*30,rand(20,35),
            $fontColor,
            $fontStyle,
            $code[$i])
        ;
    }
    //添加干扰线
    for($i=0; $i<8; ++$i){
        $lineColor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
        imageline($im,rand(0,$x),0,rand(0,$x),$y,$lineColor);
    }
    //添加噪点
    for($i=0; $i<250; ++$i){
        imagesetpixel($im,rand(0,$x),rand(0,$y),$fontColor);
    }
    //向浏览器输出验证码图片
    header('Content-type:image/png');
    imagepng($im);
    imagedestroy($im);
}
//对验证码进行验证
function checkCode($code){
    $captcha = $_SESSION['cms']['captcha'];
    if(!empty($captcha)){
        unset($_SESSION['cms']['captcha']);
        return strtoupper($captcha) == strtoupper($code);//不区分大小写
    }
    return false;
}
