<!DOCTYPE html>
<html>
<head>
    <title>登录</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico"/>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/thin-admin.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="style/style.css" rel="stylesheet">
</head>
<body>
<?php
@session_start();
//echo "session_id=".session_id();
//echo "isLogin=".$_SESSION['isLogin'];
    /*session["isLogin"]
     * none--未登录
     * 1--登录成功
     * 2--登录超时
     * 3--非法入侵
     * */
//echo "是否登录：".$_SESSION['isLogin'];
$urlpre = $_SERVER['HTTP_REFERER']; //得到上一页的地址
$basepre = basename($urlpre);//得到上一页的文件名
$urlcur = $_SERVER['PHP_SELF']; //得到当前页的地址
$basecur = basename($urlcur);//得到当前页的文件名
//echo $basepre;
if(isset($_GET['ware'])){
    $ware = $_GET['ware'];
}else{
    $ware = 0;
}
?>

<div class="loading">
    <h1>loading...</h1>
    <img src="images/loading.gif" alt="">
</div>

<div class="widget">
    <div class="login-content">
        <div class="widget-content" style="padding-bottom:0;">
            <form method="post" action="index.php" class="no-margin" id="login-form">
                <h3 class="form-title" >管理员登录</h3>

                <fieldset>
                    <div class="form-group no-margin">
                        <label for="admin">Admin</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="icon-user"></i>
                                </span>
                            <input placeholder="请输入登录名" class="form-control input-lg" id="admin" name="admin">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="icon-lock"></i>
                                </span>
                            <input type="password" placeholder="请输入密码" class="form-control input-lg" id="password" name="psd">
                        </div>
                    </div>

                    <div class="form-group captcha-module" style="display: none;">
                        <label for="captcha">Captcha</label>
                        <div class="captcha">
                            <img src="php/captcha.php" title="换一张">
                            <input type="text" placeholder="请输入验证码" class="form-control" name="captcha">
                        </div>

                    </div>
                </fieldset>
                <div class="form-actions">
                    <a href="index.html" class="btn btn-default pull-left type="button">
                        返回 <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                    <button id="login" class="btn btn-warning pull-right" type="button">
                        登录 <i class="m-icon-swapright m-icon-white"></i>
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- custom js file-->
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>

<script>

    //文档就绪
    $(function () {
        //切换验证码图像
        $(".captcha img").on("click",function () {
            $(this).attr("src","php/captcha.php");
        });

        if(<?php echo $ware;?> == 6){
            $(".captcha-module").show();
            //提交登录表单
            $("#login").on("click",function () {
                var $admin = $("#admin").val();
                var $psd = $("#password").val();
                var $captcha = $("input[name=captcha]").val();
                if($admin != "" && $psd != "" && $captcha != ""){
                    //检查登录名和密码
                    $.get("php/login_pre.php",{admin:$admin,psd:$psd,code:$captcha,ware:<?php echo $ware;?>},function (res) {
                        if(res=="ware_not") {
                            //弹出框
                            var settings = {
                                elem: "fieldset",
                                type: "alert-danger",
                                strong: "",
                                info: "请先选择仓库"
                            };
                            var loginAlert = new Alert(settings);
                            loginAlert.init();
                            //切换验证码
                            $(".captcha img").attr("src","php/captcha.php");
                        }else if(res=="captcha_err") {
                            //弹出框
                            var settings = {
                                elem: "fieldset",
                                type: "alert-danger",
                                strong: "",
                                info: "验证码错误"
                            };
                            var loginAlert = new Alert(settings);
                            loginAlert.init();
                            //切换验证码
                            $(".captcha img").attr("src","php/captcha.php");
                        }else if(res=="error"){
                            //弹出框
                            var settings = {
                                elem: "fieldset",
                                type: "alert-danger",
                                strong: "",
                                info: "登录名或密码错误"
                            };
                            var loginAlert = new Alert(settings);
                            loginAlert.init();
                            //切换验证码
                            $(".captcha img").attr("src","php/captcha.php");
                        }else if(res=="failed"){
                            var settings = {
                                elem: "fieldset",
                                type: "alert-info",
                                strong: "很抱歉",
                                info: "登录失败,请重新尝试"
                            };
                            var loginAlert = new Alert(settings);
                            loginAlert.init();
                            //切换验证码
                            $(".captcha img").attr("src","php/captcha.php");
                        }else if(res=="success"){
                            $("#login-form").submit();
                        }else{
                            //数据库连接失败
                            self.location = "error.php?error=0";
                        }
                    });
                }else{
                    //弹出框
                    var settings = {
                        elem: "fieldset",
                        type: "alert-warning",
                        strong: "",
                        info: "请填写完整信息"
                    };
                    var loginAlert = new Alert(settings);
                    loginAlert.init();
                    //切换验证码
                    $(".captcha img").attr("src","php/captcha.php");
                }
            });
        }else{
            //提交登录表单
            $("#login").on("click",function () {
                var $admin = $("#admin").val();
                var $psd = $("#password").val();
                if($admin != "" && $psd != ""){
                    //检查登录名和密码
                    $.get("php/login_pre.php",{admin:$admin,psd:$psd,ware:<?php echo $ware;?>},function (res) {
                        if(res=="ware_not") {
                            //弹出框
                            var settings = {
                                elem: "fieldset",
                                type: "alert-danger",
                                strong: "",
                                info: "请先选择仓库"
                            };
                            var loginAlert = new Alert(settings);
                            loginAlert.init();
                        }else if(res=="error"){
                            //弹出框
                            var settings = {
                                elem: "fieldset",
                                type: "alert-danger",
                                strong: "",
                                info: "登录名或密码错误"
                            };
                            var loginAlert = new Alert(settings);
                            loginAlert.init();
                        }else if(res=="failed"){
                            var settings = {
                                elem: "fieldset",
                                type: "alert-info",
                                strong: "很抱歉",
                                info: "登录失败,请重新尝试"
                            };
                            var loginAlert = new Alert(settings);
                            loginAlert.init();
                        }else if(res=="success"){
                            $("#login-form").submit();
                        }else{
                            //数据库连接失败
                            self.location = "error.php?error=0";
                        }
                    });
                }else{
                    //弹出框
                    var settings = {
                        elem: "fieldset",
                        type: "alert-warning",
                        strong: "",
                        info: "请填写完整信息"
                    };
                    var loginAlert = new Alert(settings);
                    loginAlert.init();
                }
            });
        }


        //非法入侵
        //如果$basepre是Admin则不是非法入侵
        if("<?php echo $_SESSION['isLogin'];?>" == 3 && "<?php echo $basepre;?>" != "index.html" && "<?php echo $basepre;?>" != "login.php" && "<?php echo $basepre;?>" != "Admin"){
            var settings = {
                elem: "fieldset",
                type: "alert-danger",
                strong: "请先登录",
                info: ""
            };
            var loginAlert = new Alert(settings);
            loginAlert.init();
        }
        if("<?php echo $_SESSION['isLogin'];?>" == 2){
            var settings = {
                elem: "fieldset",
                type: "alert-danger",
                strong: "登录超时",
                info: "请重新登录"
            };
            var loginAlert = new Alert(settings);
            loginAlert.init();
        }

        if("<?php echo $_SESSION['change'];?>" == "true" && ("<?php echo $basepre;?>" == "psd.php" || "<?php echo $basepre;?>" == "account.php")){
            var settings = {
                elem: "fieldset",
                type: "alert-success",
                strong: "修改成功",
                info: "请重新登录（需重新选择仓库）"
            };
            var loginAlert = new Alert(settings);
            loginAlert.init();
        }
        //退出登录
        if($.cookie("logout") == 1){
            //弹出框
            var settings = {
                elem: "fieldset",
                type: "alert-info",
                strong: "您已退出登录",
                info: "请重新选择仓库"
            };
            var loginAlert = new Alert(settings);
            loginAlert.init();
        }



        //记住密码
        /*if($.cookie("remember")){
            $(".remember").addClass("checked");
            $(".remember").prop("checked",true);
        }
        $(".remember").on("change",function () {
            $(this).toggleClass("checked");
            if($(this).hasClass("checked")){
                $("this").prop("checked",true);
                $.cookie("remember",true,{ expires: 30, path:'/'});
            }else{
                $("this").prop("checked",false);
                $.cookie("remember", null,{path:'/'});
            }
        });*/
    });

</script>

<!--switcher html start-->
<div class="demo_changer" style="right: -145px;">
    <div class="demo-icon" title="换肤"></div>
    <div class="form_holder">
        <div class="predefined_styles">
            <a class="styleswitch" rel="a" href="" title="地球之光"><img alt="" src="img/thumb_a.jpg"></a>
            <a class="styleswitch" rel="b" href="" title="质感"><img alt="" src="img/thumb_b.jpg"></a>
            <a class="styleswitch" rel="c" href="" title="延绵不绝的绿原"><img alt="" src="img/thumb_c.jpg"></a>
            <a class="styleswitch" rel="d" href="" title="蓝天白云"><img alt="" src="img/thumb_d.jpg"></a>
            <a class="styleswitch" rel="e" href="" title="孤舟"><img alt="" src="img/thumb_e.jpg"></a>
            <a class="styleswitch" rel="f" href="" title="樱花"><img alt="" src="img/thumb_f.jpg"></a>
            <a class="styleswitch" rel="g" href="" title="天堂岛"><img alt="" src="img/thumb_g.jpg"></a>
            <a class="styleswitch" rel="h" href="" title="唯美花卉"><img alt="" src="img/thumb_h.jpg"></a>
            <a class="styleswitch" rel="i" href="" title="沙滩"><img alt="" src="img/thumb_i.jpg"></a>
            <a class="styleswitch" rel="j" href="" title="晶莹世界"><img alt="" src="img/thumb_j.jpg"></a>
        </div>

    </div>
</div>


<!--switcher html end-->
<script src="assets/switcher/switcher.js"></script>
<script src="assets/switcher/moderziner.custom.js"></script>
<link href="assets/switcher/switcher.css" rel="stylesheet">
<link href="assets/switcher/switcher-defult.css" rel="stylesheet">
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/a.css" title="a" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/b.css" title="b" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/c.css" title="c" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/d.css" title="d" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/e.css" title="e" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/f.css" title="f" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/g.css" title="g" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/h.css" title="h" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/i.css" title="i" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/j.css" title="j" media="all" />

</body>
</html>
