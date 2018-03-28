<!DOCTYPE html>
<html>
<head>
<title>主页</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="favicon.ico"/>
    <!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/thin-admin.css" rel="stylesheet" media="screen">
<link href="css/font-awesome.css" rel="stylesheet" media="screen">
<link href="style/style.css" rel="stylesheet">
<link href="style/fullcalendar.css" rel="stylesheet" />
<link href="style/fullcalendar.print.css" rel="stylesheet" media="print"/>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<?php
@session_start();
//echo "是否登录：". $_SESSION['isLogin'];
//防止直接进入网站
require "php/login_is.php";
$basepre = basename($_SERVER['HTTP_REFERER']);//得到上一页的文件名
//echo $basepre;

require_once "php/odbc_do_start.php";
$single = "single".$_SESSION['ware'];
$sql = "select distinct date from $single ORDER BY date ASC";
require_once "php/odbc_do_end.php";
//echo "<br>number=".mysqli_num_rows($result);
$dates_db = array();
while($row = mysqli_fetch_assoc($result)) {
    $date_db = date("Y-m-d",strtotime($row["date"]));
    $date_today = date("Y-m-d");
    array_push($dates_db,$date_db);
    //记下最后一天有记录的日期
    $date_last = $date_db;
}

?>

<div class="loading" style="display: none;">
    <h1>loading...</h1>
    <img src="images/loading.gif" alt="">
</div>
<div class="container nav">
  <div class="top-navbar header b-b"> <a data-original-title="Toggle navigation" class="toggle-side-nav pull-left" href="#"><i class="icon-reorder"></i> </a>
    <div class="brand pull-left"> <a href="javascript:;">湖北中烟广水卷烟厂</a></div>
    <ul class="nav navbar-nav navbar-right">
        <li title="最新消息" class="hidden-xs">
            <a href="javascript:;">
                <i class="icon-large icon icon-bell"></i>
            </a>
        </li>
        <li title="帮助文档" class="hidden-xs">
            <a href="javascript:;">
                <i class="icon-large icon icon-book"></i>
            </a>
        </li>
        <li title="网站建议" class="hidden-xs">
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
                <li class="current"> <a href="index.php"> <i class="icon-large icon-home"></i> 主页 </a> </li>
                <li> <a href="javascript:;"> <i class="icon-large icon-table"></i> 日报表 <i class="arrow icon-angle-left"></i></a>
                    <ul class="sub-menu opened">
                        <li> <a href="table.php"> <i class="icon-large icon-angle-right"></i> 查看记录 </a> </li>
                        <li> <a href="form.php"> <i class="icon-large icon-angle-right"></i> 添加记录 </a> </li>
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
            <div class="widget-header"> <i class="icon-calendar"></i>
              <h3>管理员日历</h3>
            </div>
            <div class="widget-content">
              <div id='calendar'></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="bottom-nav footer pull-right"> 2017 © Admin Systems by ShiMinfei. </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/smooth-sliding-menu.js"></script>
<script src="javascript/jquery.min.js"></script>
<script src="javascript/jquery-ui.custom.min.js"></script>
<script src="javascript/fullcalendar.min.js"></script>
<!-- custom js file-->
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>
<script>

	$(document).ready(function() {
	    var last = "<?php echo $date_last;?>";
	    var today = "<?php echo $date_today;?>";

        if(last<today){
            //self.location = "php/do_transfer.php?start="+last+"&end="+today;
            $.get("php/do_transfer.php",{start:last,end:today},function (res) {
                if(res=="success"){
                    location.reload();
                }
            });
        }

        $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			editable: true,
            eventSources:[
                {
                    events: [
                        <?php for($x=0;$x<count($dates_db);$x++){
                        echo "{";
                        echo "title: '查看记录',";
                        echo "start: '".$dates_db[$x]."'";
                        echo "},";
                    } ?>
                    ]
                },{
                    events:[

                    ],
                    color: '#428bca'
                }
            ],
            eventClick: function(calEvent, jsEvent, view) {
                var eventDate = $.fullCalendar.formatDate( calEvent.start ,'yyyy-MM-dd');
                self.location = "table.php?start="+eventDate;
            },
            dayClick: function (date, jsEvent, view) {
                /*var dayDate = $.fullCalendar.formatDate( date ,'yyyy-MM-dd');
                self.location = "table.php?start="+dayDate;*/
            }
        });
        //登录成功
        if($.cookie("isLogin") == 1){
            //弹出框
            var settings = {
                elem: ".page-content",
                type: "alert-success",
                strong: "恭喜您，登录成功",
                info: "现在您可以开始管理您的<?php echo $_SESSION['ware'];?>号仓库了！",
                site: "prepend"
            };
            var indexAlert = new Alert(settings);
            indexAlert.init();
        }
        //结转成功
        if($.cookie("transfer") == 1){
            //弹出框
            var settings = {
                elem: ".page-content",
                type: "alert-success",
                strong: "所有记录结转完成",
                info: "",
                site: "prepend"
            };
            var indexAlert = new Alert(settings);
            indexAlert.init();
        }

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
