<!DOCTYPE html>
<?php
//防止直接进入网站
require "php/login_is.php";
?>
<html>
<head>
    <title>表单</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico"/>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/thin-admin.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.css" rel="stylesheet" media="screen">
    <link href="style/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="loading">
    <h1>loading...</h1>
    <img src="images/loading.gif" alt="">
</div>
<div class="container nav">
    <div class="top-navbar header b-b"> <a data-original-title="Toggle navigation" class="toggle-side-nav pull-left" href="#"><i class="icon-reorder"></i> </a>
        <div class="brand pull-left"> <a href="javascript:;">湖北中烟广水卷烟厂</a></div>
        <ul class="nav navbar-nav navbar-right  hidden-xs">
            <li title="最新消息">
                <a href="javascript:;">
                    <i class="icon-large icon icon-bell"></i>
                </a>
            </li>
            <li title="帮助文档">
                <a href="javascript:;">
                    <i class="icon-large icon icon-book"></i>
                </a>
            </li>
            <li title="网站建议">
                <a href="javascript:;">
                    <i class="icon-large icon icon-envelope-alt"></i>
                </a>
            </li>
            <li class="dropdown user"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-large icon-male"></i> <span class="username">管理员<?php echo $_SESSION['ware'];?></span> <i class="icon-caret-down small"></i> </a>
                <ul class="dropdown-menu">
                    <li><a href="account.php"><i class="icon-user"></i> 更改登录名 </a></li>
                    <li class="divider"></li>
                    <li><a href="psd.php"><i class="icon-key"></i> 更改密码 </a></li>
                    <li class="divider"></li>
                    <li class="signout"><a href="javascript:;"><i class="icon-signout"></i> 退出登录 </a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="wrapper">
    <div class="left-nav">
        <div id="side-nav">
            <ul id="nav">
                <li> <a href="index.php"> <i class="icon-large icon-home"></i> 主页 </a> </li>
                <li> <a href="javascript:;"> <i class="icon-large icon-table"></i> 日报表 <i class="arrow icon-angle-left"></i></a>
                    <ul class="sub-menu opened">
                        <li> <a href="table.php"> <i class="icon-angle-right"></i> 查看记录 </a> </li>
                        <li class="current"> <a href="form.php"> <i class="icon-angle-right"></i> 添加记录 </a> </li>
                    </ul>
                </li>
                <li> <a href="javascript:;"> <i class="icon-large icon-time"></i> 日志 </a> </li>
                <li> <a href="javascript:;"> <i class="icon-bar-chart"></i> 图表 </a> </li>
            </ul>
        </div>
    </div>
    <div class="page-content">
        <div class="content container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="widget">
                        <div class="widget-header"> <i class="icon-file-alt"></i>
                            <h3>日报表输入</h3>
                        </div>
                        <div class="widget-content">
                            <div class="panel-body">
                                <form action="" class="form-horizontal row-border" data-validate="parsley" id="myForm" method="post">
                                <?php
                                //如果传了record参数,表示编辑
                                $record = $_GET["record"];
                                if($record){
                                    /*连接数据库*/
                                    require "php/odbc_do_start.php";
                                    $single = "single".$_SESSION['ware'];
                                    $sql = "SELECT * FROM $single WHERE record = '$record'";
                                    require "php/odbc_do_end.php";
                                    //echo "<br>sql=$sql";
                                    if (mysqli_num_rows($result) > 0) {
                                    //echo "<br>number=".mysqli_num_rows($result);
                                    // 输出数据
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $storWare = $row["storWare"];
                                            $storStack = $row["storStack"];
                                            $storName = $row["storName"];
                                            $type = $row["type"];
                                            $province = $row["province"];
                                            $tobaccoYear = $row["tobaccoYear"];
                                            $startItem = $row["startItem"];
                                            $startWeight = $row["startWeight"];
                                            $maxItem = $row["maxItem"];
                                            $maxWeight = $row["maxWeight"];
                                            $curInItem = $row["curInItem"];
                                            $curInWeight = $row["curInWeight"];
                                            $curOutItem = $row["curOutItem"];
                                            $curOutWeight = $row["curOutWeight"];
                                            $endItem = $row["endItem"];
                                            $endWeight = $row["endWeight"];
                                            $remainItem = $row["remainItem"];
                                            $remainWeight = $row["remainWeight"];
                                            $remarks = $row["remarks"];
                                            $date = date("Y-m-d",strtotime($row["date"]));
                                        }
                                    }else {
                                        echo "<script>
                                                self.location = 'error.php?error=1';
                                              </script>";
                                        exit();
                                        }
                                }
                                //如果传了日期参数，表示添加
                                if($_GET["start"]){
                                    $date = $_GET["start"];
                                }
                                //从侧栏链接直接跳转过来
                                if(!$date){
                                    $date = date("Y-m-d");
                                }
                                ?>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">存货地点-库号</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="storWare" placeholder="必填项" value="<?php echo $storWare;?>" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">存货地点-垛位号</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="storStack" placeholder="必填项" value="<?php echo $storStack;?>" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">存放名称</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="storName" placeholder="必填项"  value="<?php echo $storName;?>" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">类型</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="type" placeholder=""  value="<?php echo $type;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">省份</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="province" placeholder="必填项"  value="<?php echo $province;?>" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">烟叶年份</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="tobaccoYear" placeholder="必填项（格式：YYYY）"  value="<?php echo $tobaccoYear;?>" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">期初结存-件数</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="startItem" data-type="number" placeholder=""  value="<?php echo $startItem;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">期初结存-重量</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="startWeight" data-type="number" placeholder=""  value="<?php echo $startWeight;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">最大容量-件数</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="maxItem" data-type="number" placeholder=""  value="<?php echo $maxItem;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">最大容量-重量</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="maxWeight" data-type="number" placeholder=""  value="<?php echo $maxWeight;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">本期收入-件数</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="curInItem" data-type="number" placeholder=""  value="<?php echo $curInItem;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">本期收入-重量</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="curInWeight" data-type="number" placeholder=""  value="<?php echo $curInWeight;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">本期发出-件数</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="curOutItem" data-type="number" placeholder=""  value="<?php echo $curOutItem;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">本期发出-重量</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="curOutWeight" data-type="number" placeholder=""  value="<?php echo $curOutWeight;?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">期末结存-件数</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="endItem" data-type="number" placeholder=""  value="<?php echo $endItem;?>" class="form-control" readonly="readonly"/>
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">期末结存-重量</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="endWeight" data-type="number" placeholder=""  value="<?php echo $endWeight;?>" class="form-control" readonly="readonly"/>
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">剩余面积可存量-件数</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="remainItem" data-type="number" placeholder=""  value="<?php echo $remainItem;?>" class="form-control" readonly="readonly"/>
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">剩余面积可存量-重量</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="remainWeight" data-type="number" placeholder=""  value="<?php echo $remainWeight;?>" class="form-control" readonly="readonly"/>
                                        </div>
                                    </div>

                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">日期</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="date" data-type="dateIso" placeholder="YYYY-MM-DD"  value="<?php echo $date;?>" class="form-control" title="默认为今天"/>
                                        </div>
                                    </div>
                                    <div class="form-group lable-padd">
                                        <label class="col-sm-3">备注</label>
                                        <div class="col-sm-6">
                                            <textarea name="remarks" rows="3" placeholder="说点什么"  class="form-control"><?php echo $remarks;?></textarea>
                                        </div>
                                    </div>
                                <?php /*mysqli_close($conn);*/?>
                                </form>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <div class="btn-toolbar" style="text-align: center">
                                            <button class="btn-primary btn primary" disabled="disabled">提交</button>
                                            <button class="btn-default btn cancel">取消</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--模态框-->
    <div style="display: none;" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h4 id="myModalLabel" class="modal-title"> 确认更改这条记录？</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
                    <button class="btn btn-primary" type="button">确认</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

<div class="bottom-nav footer"> 2017 © Admin Systems by ShiMinfei. </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/smooth-sliding-menu.js"></script>
<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>
<script type='text/javascript' src='assets/plugins/form-parsley/parsley.min.js'></script>
<script type='text/javascript' src='assets/js/demo-formvalidation.js'></script>
<!-- custom js file-->
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>

<script>
    $(document).ready(function () {
        var $si = $("input[name='startItem']");
        var $sw = $("input[name='startWeight']");
        var $mi = $("input[name='maxItem']");
        var $mw = $("input[name='maxWeight']");
        var $cii = $("input[name='curInItem']");
        var $ciw = $("input[name='curInWeight']");
        var $coi = $("input[name='curOutItem']");
        var $cow = $("input[name='curOutWeight']");
        var $ei = $("input[name='endItem']");
        var $ew = $("input[name='endWeight']");
        var $ri = $("input[name='remainItem']");
        var $rw = $("input[name='remainWeight']");
        //input默认值
        if(!$si.val()){
            $si.val(0.0);
        }
        if(!$sw.val()){
            $sw.val(0.00);
        }
        if(!$mi.val()){
            $mi.val(0.0);
        }
        if(!$mw.val()){
            $mw.val(0.00);
        }
        if(!$cii.val()){
            $cii.val(0.0);
        }
        if(!$ciw.val()){
            $ciw.val(0.00);
        }
        if(!$coi.val()){
            $coi.val(0.0);
        }
        if(!$cow.val()){
            $cow.val(0.00);
        }
        if(!$ei.val()){
            $ei.val(0.0);
        }
        if(!$ew.val()){
            $ew.val(0.00);
        }
        if(!$ri.val()){
            $ri.val(0.0);
        }
        if(!$rw.val()){
            $rw.val(0.00);
        }


        var $myForm = $('#myForm');
        var $primary = $(".primary");
        //切换“提交”和“更改”
        if("<?php echo $record;?>"!=""){
            $primary.html("修改");
        }
        ////
        var $input = $(":input.form-control");
        var $startItem = parseFloat($si.val());
        var $curInItem = parseFloat($cii.val());
        var $curOutItem = parseFloat($coi.val());
        var $endItem = $startItem+$curInItem-$curOutItem;
        var $startWeight = parseFloat($sw.val());
        var $curInWeight = parseFloat($ciw.val());
        var $curOutWeight = parseFloat($cow.val());
        var $endWeight = $startWeight+$curInWeight-$curOutWeight;
        var $maxItem = parseFloat($mi.val());
        var $remainItem = $maxItem-$endItem;
        var $maxWeight = parseFloat($mw.val());
        var $remainWeight = $maxWeight-$endWeight;
        $input.on("change",function () {
            //当任意输入框的值改变的时候取消禁用.primary按钮
            $primary.removeAttr("disabled");

            //期末结存=期初结存+收入-发出
            $startItem = parseFloat($si.val());
            $curInItem = parseFloat($cii.val());
            $curOutItem = parseFloat($coi.val());
            $endItem = $startItem+$curInItem-$curOutItem;
            $ei.val($endItem.toFixed(1));
            $startWeight = parseFloat($sw.val());
            $curInWeight = parseFloat($ciw.val());
            $curOutWeight = parseFloat($cow.val());
            $endWeight = $startWeight+$curInWeight-$curOutWeight;
            $ew.val($endWeight.toFixed(2));
            //剩余面积可存量=最大容量-期末结存
            $maxItem = parseFloat($mi.val());
            $remainItem = $maxItem-$endItem;
            $ri.val($remainItem.toFixed(1));
            $maxWeight = parseFloat($mw.val());
            $remainWeight = $maxWeight-$endWeight;
            $rw.val($remainWeight.toFixed(2));

        });
        //取消表单
        $(".btn-toolbar .cancel").on("click",function () {
            history.back();
        });
        //提交表单
        $primary.on("click",function () {
            //判断是“提交”还是“修改”
            if($primary.text()=="修改"){
                $myForm.attr("action","php/form_pre.php?update=true&record=<?php echo $record;?>");
                $myForm.submit();
            }else{
                //如果是提交要先判断identity字段是否已存在
                var $storWare = $("input[name='storWare']").val();
                var $storStack = $("input[name='storStack']").val();
                var $storName = $("input[name='storName']").val();
                var $province = $("input[name='province']").val();
                var $tobaccoYear = $("input[name='tobaccoYear']").val();
                var $date = $("input[name='date']").val();
                $.get("php/form_control.php",{storWare:$storWare,storStack:$storStack,storName:$storName,province:$province,tobaccoYear:$tobaccoYear,date:$date},function (res) {
                    if(res=="safe"){
                        $myForm.attr("action","php/form_pre.php");
                        $myForm.submit();
                    }else if(res=="danger"){
                        $('html,body').animate({scrollTop:0},300);//回到顶部
                        //弹出框
                        var settings = {
                            elem: ".page-content",
                            type: "alert-danger",
                            strong: "该记录已存在，不能重复插入",
                            info: "请检查输入是否正确，或者在原始记录上进行更改",
                            site: "prepend"
                        };
                        var formAlert = new Alert(settings);
                        formAlert.init();
                    }else if(res=="error"){
                        //出错啦
                        self.location = "error.php?error=2";
                    }else{
                        //数据库连接失败
                        self.location = "error.php?error=0";
                    }
                });

            }
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
