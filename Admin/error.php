<!DOCTYPE html>
<html>
<head>
<title>出错了</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
<link rel="shortcut icon" href="favicon.ico"/>
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/thin-admin.css" rel="stylesheet" media="screen">
<link href="css/font-awesome.css" rel="stylesheet" media="screen">
<link href="style/style.css" rel="stylesheet">

    <style>
        .description{
            display: none;
        }
    </style>

</head>
<body>

<?php
/*
    0=>'数据库连接失败',
    1=>'数据库查询失败',
    2=>'数据库操作失败',
    3=>'网站维修'
*/
$type = $_GET["error"];
?>

<!--<div class="loading">
    <h1>loading...</h1>
    <img src="images/loading.gif" alt="">
</div>-->

<div class="widget-404" style="margin-top: 50px;">
<div class="row">
    <div class="description type0">
        <h3>抱歉！无法连接到服务器</h3>
        <p>请检查你的网络，如未解决请尝试
            <strong>
                <a href="javascript:;">联系我</a>
            </strong>或者在以下搜索框搜索其他内容
        </p>
    </div>
    <div class="description type1">
        <h3>啊哦！你可能走丢了</h3>
        <p>没有你要找的内容，你可以
            <strong>
                <a href="index.php">回到主页</a>
            </strong>或者尝试在以下搜索框搜索其他内容
        </p>
    </div>
    <div class="description type2">
        <h3>抱歉！操作失败</h3>
        <p>请检查你的输入是否符合规范，你可以
            <strong>
                <a href="index.php">回到主页</a>
            </strong>或者尝试在以下搜索框搜索其他内容
        </p>
    </div>
    <div class="description type3">
        <img src="images/waiting.gif" alt="">
        <h3 style="text-align: center;">网站维修中，请耐心等待......</h3>
    </div>
</div>

<!--<div class="widget-404">
        <div class="form-actions">
            <form role="form" action="" method="post" class="form-inline form-search" id="error-form">
                <div class="input-group">
                    <input type="search" placeholder="Pages: Posts, Tags" class="form-control" id="search-input">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary">
                            &nbsp; 搜索 &nbsp;
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>

<!-- custom js file-->
<script src="js/jquery.cookie.js"></script>
<!--<script src="js/main.js"></script>-->


<script>
    $(document).ready(function () {
        //切换界面
        $(".type<?php echo $type;?>").show();
        //搜索
        /*$("#search-input").on("change",function () {
            $("#error-form").attr("action",$(this).val());
        });*/
    });
</script>

 

<!--switcher html start-->
<div class="demo_changer" style="right: -145px;">
                <div class="demo-icon"></div>
                <div class="form_holder">
                        

                    <div class="predefined_styles">
                        <a class="styleswitch" rel="a" href=""><img alt="" src="images/a.jpg"></a>	
                        <a class="styleswitch" rel="b" href=""><img alt="" src="images/b.jpg"></a>
                        <a class="styleswitch" rel="c" href=""><img alt="" src="images/c.jpg"></a>
                        <a class="styleswitch" rel="d" href=""><img alt="" src="images/d.jpg"></a>
                        <a class="styleswitch" rel="e" href=""><img alt="" src="images/e.jpg"></a>
                        <a class="styleswitch" rel="f" href=""><img alt="" src="images/f.jpg"></a>
                        <a class="styleswitch" rel="g" href=""><img alt="" src="images/g.jpg"></a>
                        <a class="styleswitch" rel="h" href=""><img alt="" src="images/h.jpg"></a>
                        <a class="styleswitch" rel="i" href=""><img alt="" src="images/i.jpg"></a>
                        <a class="styleswitch" rel="j" href=""><img alt="" src="images/j.jpg"></a>
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
