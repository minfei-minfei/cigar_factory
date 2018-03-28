<!DOCTYPE html>
<html>
<head>
    <title>修改登录名</title>
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
//防止直接进入网站
require "php/login_is.php";
//依赖文件
require "php/odbc_info.php";
require "php/function.php";
$ware = $_SESSION['ware'];
$admin_db = passport_decrypt($wares_db[$ware][0],"iloveshiminfei");
//表单提交成功
if($_POST["old"] && $_POST["new"] && $_POST["new1"]){
    if($_POST["old"]==$admin_db && $_POST["new"]){
        /*修改成功*/
        //加密密码
        $new  = passport_encrypt($_POST["new"],"iloveshiminfei");
//更改数据库密码
        require_once "php/odbc_do_start.php";
        $sql = "UPDATE login SET admin ='$new' WHERE warehouse = $ware";
        require_once "php/odbc_do_end.php";
        //强制重新登录
        session_destroy();
        @session_start();
        $_SESSION["change"]="true";
        echo "<script>
                self.location = 'login.php';
              </script>";
        exit();
    }else{
        /*修改失败*/
        $_SESSION["change"]="false";
    }
}

?>

<div class="loading">
    <h1>loading...</h1>
    <img src="images/loading.gif" alt="">
</div>

<div class="widget">
    <div class="login-content">
        <div class="widget-content" style="padding-bottom:0;">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="no-margin" id="change-form">
                <h3 style="color: white;">管理员更改登录名</h3>
                <fieldset>
                    <div class="form-group no-margin">
                        <label for="admin">Original</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="icon-lock"></i>
                                </span>
                            <input placeholder="请输入旧登录名" class="form-control input-lg" id="old" name="old">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">New</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="icon-key"></i>
                                </span>
                            <input placeholder="请输入新的登录名" class="form-control input-lg" id="new" name="new">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Confirm</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="icon-key"></i>
                                </span>
                            <input placeholder="请确认新的登录名" class="form-control input-lg" id="new1" name="new1">
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <button class="btn btn-default pull-left cancel" type="button">
                        取消 <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                    <button id="change" class="btn btn-warning pull-right" type="button">
                        确认 <i class="m-icon-swapright m-icon-white"></i>
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
        //提交登录表单
        $("#change").on("click",function () {
            var $old = $("#old").val();
            var $new = $("#new").val();
            var $new1 = $("#new1").val();
            if($old != "" && $new != "" && $new1 != ""){
                //检查两个新密码是否一致
                if($new1 != $new){
                    //弹出框
                    var settings = {
                        elem: "fieldset",
                        type: "alert-info",
                        strong: "",
                        info: "两次新的登录名不一致"
                    };
                    var changeAlert = new Alert(settings);
                    changeAlert.init();
                    //避免刷新
                    return false;
                }
                //检查旧密码是否正确
                if($old != '<?php echo $admin_db;?>'){
                    //弹出框
                    var settings = {
                        elem: "fieldset",
                        type: "alert-danger",
                        strong: "",
                        info: "原登录名错误"
                    };
                    var changeAlert = new Alert(settings);
                    changeAlert.init();
                    //避免刷新
                    return false;
                }
                //验证正确后，提交表单
                $("#change-form").submit();
            }else{
                //弹出框
                var settings = {
                    elem: "fieldset",
                    type: "alert-info",
                    strong: "",
                    info: "请填写完整信息"
                };
                var changeAlert = new Alert(settings);
                changeAlert.init();
                //避免刷新
                return false;
            }
        });

        //修改密码失败
        if("<?php echo $_SESSION['change'];?>" == "false"){
            var settings = {
                elem: "fieldset",
                type: "alert-warning",
                strong: "抱歉",
                info: "修改登录名失败"
            };
            var changeAlert = new Alert(settings);
            changeAlert.init();
        }
        //取消更改
        $(".cancel").on("click",function () {
            history.back();
        });

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
