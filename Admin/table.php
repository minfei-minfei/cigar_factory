<!DOCTYPE html>
<html>
<head>
    <title>查看记录</title>
    <meta charset="utf-8">
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

<?php
//防止直接进入网站
require "php/login_is.php";
//地址传参

$date = date("Y年m月d日",strtotime($_GET['start']));
$date0 = date("Ymd",strtotime($_GET['start']));
//如果没传参数，默认为今天
if(!$_GET['start']){
    $date = date("Y年m月d日");
    $date0 = date("Ymd");
}
$start =  date("Y-m-d",strtotime($date0));
$datepre =  date("Y-m-d",strtotime($date0)-86400);
$datenext =  date("Y-m-d",strtotime($date0)+86400);
//echo $date;
//echo $date0;
//echo $start;
//echo $datepre;
//echo $datenext;
?>

<div class="loading">
    <h1>loading...</h1>
    <img src="images/loading.gif" alt="">
</div>

<div class="container nav">
    <div class="top-navbar header b-b"> <a data-original-title="Toggle navigation" class="toggle-side-nav pull-left" href="#"><i class="icon-reorder"></i> </a>
        <div class="brand pull-left"> <a href="javascript:;">湖北中烟广水卷烟厂</a></div>
        <ul class="nav navbar-nav navbar-right  hidden-xs">
            <li title="主页">
                <a href="index.php">
                    <i class="icon-large icon icon-home"></i>
                </a>
            </li>
            <li title="查看记录">
                <a href="table.php">
                    <i class="icon-large icon icon-table"></i>
                </a>
            </li>
            <li title="添加记录">
                <a href="form.php">
                    <i class="icon-large icon icon-edit"></i>
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
    <!--<div class="left-nav">
        <div id="side-nav">
            <ul id="nav">
                <li> <a href="index.php"> <i class="icon-large icon-home"></i> 主页 </a> </li>
                <li> <a href="javascript:;"> <i class="icon-large icon-table"></i> 日报表 <i class="arrow icon-angle-left"></i></a>
                    <ul class="sub-menu opened">
                        <li class="current"> <a href="table.php"> <i class="icon-angle-right"></i> 查看记录 </a> </li>
                        <li> <a href="form.php"> <i class="icon-angle-right"></i> 添加记录 </a> </li>
                    </ul>
                </li>
                <li> <a href="javascript:;"> <i class="icon-large icon-time"></i> 日志 </a> </li>
                <li> <a href="javascript:;"> <i class="icon-bar-chart"></i> 图表 </a> </li>
            </ul>
        </div>
    </div>-->
    <div class="page-content">
        <div class="content container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="widget">
                        <div class="widget-header"> <i class="icon-table"></i>
                            <h3><?php echo $date;?></h3>
                            <span id="switch">
                                <a href="table.php?start=<?php echo $datepre;?>" title="前一天"><i class="icon-caret-left"></i></a>
                                <a href="table.php?start=<?php echo $datenext;?>" title="后一天"><i class="icon-caret-right"></i></a>
                            </span>
                            <h3 class="pull-right">单位： 件、公斤</h3>
                        </div>

                        <div class="widget-content">
                            <div class="body">
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead>
                                    <tr>
                                        <th colspan="2">存货地点</th>
                                        <th rowspan="2" title="点击按存放名称排序">存放名称</th>
                                        <th rowspan="2" title="点击按类型排序">类型</th>
                                        <th rowspan="2" title="点击按省份排序">省份</th>
                                        <th rowspan="2" title="点击按烟叶年份排序">烟叶年份</th>
                                        <th colspan="2">期初结存</th>
                                        <th colspan="2">最大容量</th>
                                        <th colspan="2">本期收入</th>
                                        <th colspan="2">本期发出</th>
                                        <th colspan="2">期末结存</th>
                                        <th colspan="2">剩余面积可存量</th>
                                        <th rowspan="2" title="点击按仓库利用率排序">仓库利用率</th>
                                        <th rowspan="2">备注</th>
                                        <th rowspan="2">操作</th>
                                    </tr>
                                    <tr>
                                        <th title="点击按库号排序">库号</th>
                                        <th title="点击按垛号排序">垛号</th>
                                        <th title="点击按件数排序">件数</th>
                                        <th title="点击按重量排序">重量</th>
                                        <th title="点击按件数排序">件数</th>
                                        <th title="点击按重量排序">重量</th>
                                        <th title="点击按件数排序">件数</th>
                                        <th title="点击按重量排序">重量</th>
                                        <th title="点击按件数排序">件数</th>
                                        <th title="点击按重量排序">重量</th>
                                        <th title="点击按件数排序">件数</th>
                                        <th title="点击按重量排序">重量</th>
                                        <th title="点击按件数排序">件数</th>
                                        <th title="点击按重量排序">重量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        require_once "php/odbc_do_start.php";
                                        $single = "single".$_SESSION['ware'];
                                        $sql = "SELECT * FROM $single WHERE date = '$date0' ORDER BY storWare, storStack";
                                        require_once "php/odbc_do_end.php";

                                        if (mysqli_num_rows($result) > 0) {
                                            //echo "<br>number=".mysqli_num_rows($result);
                                            // 输出数据
                                            while($row = mysqli_fetch_assoc($result)) {
                                                if(intval($row["maxWeight"])){
                                                    $userate = round($row["endWeight"]/$row["maxWeight"]*100,2);
                                                }else{
                                                    $userate = 0;
                                                }
                                                echo "<tr>";
                                                echo "<td>" . $row["storWare"] . "</td>";
                                                echo "<td>" . $row["storStack"] . "</td>";
                                                echo "<td>" . $row["storName"] . "</td>";
                                                echo "<td>" . $row["type"] . "</td>";
                                                echo "<td>" . $row["province"] . "</td>";
                                                echo "<td>" . $row["tobaccoYear"] . "</td>";
                                                echo "<td>" . $row["startItem"] . "</td>";
                                                echo "<td>" . $row["startWeight"] . "</td>";
                                                echo "<td>" . $row["maxItem"] . "</td>";
                                                echo "<td>" . $row["maxWeight"] . "</td>";
                                                echo "<td>" . $row["curInItem"] . "</td>";
                                                echo "<td>" . $row["curInWeight"] . "</td>";
                                                echo "<td>" . $row["curOutItem"] . "</td>";
                                                echo "<td>" . $row["curOutWeight"] . "</td>";
                                                echo "<td>" . $row["endItem"] . "</td>";
                                                echo "<td>" . $row["endWeight"] . "</td>";
                                                echo "<td>" . $row["remainItem"] . "</td>";
                                                echo "<td>" . $row["remainWeight"] . "</td>";
                                                echo "<td>" . $userate . "%</td>";
                                                echo "<td title='".$row["remarks"]."'>" . $row["remarks"] . "</td>";
                                                $record = $row["record"];
                                                echo "<td>
                                                        <button class=\"btn btn-xs btn-primary edit\" onclick=\"self.location = 'form.php?record=$record';\">编辑</button>
                                                        <button data-backdrop=\"false\" data-target=\"#delModal\" data-toggle=\"modal\" class=\"btn btn-xs btn-warning del\" data-record='$record'>删除</button>
                                                    </td>";
                                                echo "</tr>";
                                            }
                                        }

                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="6">合&nbsp;&nbsp;&nbsp;计</th>
                                        <th id="si_t"></th>
                                        <th id="sw_t"></th>
                                        <th id="mi_t"></th>
                                        <th id="mw_t"></th>
                                        <th id="cii_t"></th>
                                        <th id="ciw_t"></th>
                                        <th id="coi_t"></th>
                                        <th id="cow_t"></th>
                                        <th id="ei_t"></th>
                                        <th id="ew_t"></th>
                                        <th id="ri_t"></th>
                                        <th id="rw_t"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="body">
    <div style="display: none;" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" id="delModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h4 id="myModalLabel" class="modal-title"> 确认删除这条记录？此记录以后的记录也将被删除</h4>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>存货地点-库号：</li>
                        <li>存货地点-垛位号：</li>
                        <li>存放名称：</li>
                        <li>类型：</li>
                        <li>省份：</li>
                        <li>烟叶年份：</li>
                        <li>期初结存-件数：</li>
                        <li>期初结存-重量：</li>
                        <li>最大容量-件数：</li>
                        <li>最大容量-重量：</li>
                        <li>本期收入-件数：</li>
                        <li>本期收入-重量：</li>
                        <li>本期发出-件数：</li>
                        <li>本期发出-重量：</li>
                        <li>期末结存-件数：</li>
                        <li>期末结存-重量：</li>
                        <li>剩余面积可存量-件数：</li>
                        <li>剩余面积可存量-重量：</li>
                        <li>仓库利用率：</li>
                        <li>备注：</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
                    <a class="btn btn-primary del-submit" type="button">确认</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="bottom-nav footer"> 2017 © Admin Systems by ShiMinfei. </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/smooth-sliding-menu.js"></script>
<!--动态选项-->
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<!-- custom js file-->
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        var sum_si=0.0;
        var sum_sw=0.00;
        var sum_mi=0.0;
        var sum_mw=0.00;
        var sum_cii=0.0;
        var sum_ciw=0.00;
        var sum_coi=0.0;
        var sum_cow=0.00;
        var sum_ei=0.0;
        var sum_ew=0.00;
        var sum_ri=0.0;
        var sum_rw=0.00;
        //配置表格参数
        $('#myTable').dataTable( {
            "sPaginationType": "full_numbers",
            "bStateSave": true, //改变每页显示数据数量
            "aLengthMenu": [25, 50, 100, 150],
            /*合计*/
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if(iDisplayIndex==0) {
                    sum_si=0.0;
                    sum_sw=0.00;
                    sum_mi=0.0;
                    sum_mw=0.00;
                    sum_cii=0.0;
                    sum_ciw=0.00;
                    sum_coi=0.0;
                    sum_cow=0.00;
                    sum_ei=0.0;
                    sum_ew=0.00;
                    sum_ri=0.0;
                    sum_rw=0.00;
                }
                sum_si+=parseFloat(aData[6]);
                sum_sw+=parseFloat(aData[7]);
                sum_mi+=parseFloat(aData[8]);
                sum_mw+=parseFloat(aData[9]);
                sum_cii+=parseFloat(aData[10]);
                sum_ciw+=parseFloat(aData[11]);
                sum_coi+=parseFloat(aData[12]);
                sum_cow+=parseFloat(aData[13]);
                sum_ei+=parseFloat(aData[14]);
                sum_ew+=parseFloat(aData[15]);
                sum_ri+=parseFloat(aData[16]);
                sum_rw+=parseFloat(aData[17]);
                $("#si_t").html(sum_si.toFixed(1));
                $("#sw_t").html(sum_sw.toFixed(2));
                $("#mi_t").html(sum_mi.toFixed(1));
                $("#mw_t").html(sum_mw.toFixed(2));
                $("#cii_t").html(sum_cii.toFixed(1));
                $("#ciw_t").html(sum_ciw.toFixed(2));
                $("#coi_t").html(sum_coi.toFixed(1));
                $("#cow_t").html(sum_cow.toFixed(2));
                $("#ei_t").html(sum_ei.toFixed(1));
                $("#ew_t").html(sum_ew.toFixed(2));
                $("#ri_t").html(sum_ri.toFixed(1));
                $("#rw_t").html(sum_rw.toFixed(2));
                return nRow;
            }

        });
        //如果没有记录则去掉tfoot
        if($("tbody").text()=="暂无记录"){
            $("tfoot").css("display","none");
        }


        //记录模态框静态内容
        var $recordsName = $(".modal-body ul li");
        var $modStatic = [];
        for(var i=0; i<$recordsName.length; i++){
            $modStatic.push($recordsName.eq(i).text());
        }
        $(".del").on("click",function () {
            //将动态记录插入模态框
            var $recordsCont = $(this).parent().siblings();
            for(var i=0; i<$recordsCont.length; i++){
                var $modDynamic = $recordsCont.eq(i).text();
                $recordsName.eq(i).text($modStatic[i]+$modDynamic);
            }
            //确认删除按钮
            var $record = $(this).data("record");
            $(".del-submit").attr("href","php/table_del.php?record="+$record+"&start="+"<?php echo $start;?>");
            //console.log($(".del-submit").attr("href"));
        });
        //添加记录按钮
        var $add = ("<a class=\"btn btn-success add\">" +
            "<i class=\" icon-plus\"></i>" +
            "<span>添加记录</span>" +
            "</a>");

        $("#myTable_filter").append($add);
        $(".add").css("margin-left","1em").attr("href","form.php?start="+"<?php echo $start;?>");

        //修改成功
        if($.cookie("update") == 1){
            //弹出框
            var settings = {
                elem: ".page-content",
                type: "alert-success",
                strong: "恭喜您",
                info: "修改成功",
                site: "prepend"
            };
            var loginAlert = new Alert(settings);
            loginAlert.init();
        }
        if($.cookie("add") == 1){
            //弹出框
            var settings = {
                elem: ".page-content",
                type: "alert-success",
                strong: "恭喜您",
                info: "添加成功",
                site: "prepend"
            };
            var loginAlert = new Alert(settings);
            loginAlert.init();
        }
        if($.cookie("del") == 1){
            //弹出框
            var settings = {
                elem: ".page-content",
                type: "alert-success",
                strong: "恭喜您",
                info: "删除成功",
                site: "prepend"
            };
            var loginAlert = new Alert(settings);
            loginAlert.init();
        }

    } );
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
