/*定义一个Alert类*/
function Alert(settings){
    this.$alert = $('<div class="alert alert-block fade in"></div>');
    this.$close = $('<button type="button" class="close close-sm" data-dismiss="alert"></button>');
    this.$icon = $('<i class="icon-remove"></i>');
    this.$strong = $('<strong></strong>');
    this.$info = $('<span></span>');
    this.defaultSettings = {
        elem: "body",
        type: "alert-danger",/*danger,warning,info,success*/
        strong: "警告",
        info: "网络连接错误",
        site: "append"
    };
    $.extend(this.defaultSettings,settings);
}
Alert.prototype.init = function(){
    this.$close.append(this.$icon);
    this.$alert.append(this.$close).append(this.$strong).append(this.$info);
    if(this.defaultSettings.site=="append"){
        $(this.defaultSettings.elem).append(this.$alert);
    }else{
        $(this.defaultSettings.elem).prepend(this.$alert);
    }
    this.$strong.html(this.defaultSettings.strong+"!");
    this.$info.html(this.defaultSettings.info);
    this.$alert.addClass(this.defaultSettings.type);
    //过5秒没有叉掉自动消失
    setTimeout(function (){
        this.close();
    }.bind(this),5000);
};
Alert.prototype.close = function(){
    this.$close.trigger("click");
};
/*-----------------------------------*/

function Modal(settings) {
    this.$modal = $('<div style="display: none;" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade"></div>');
    this.$dialog = $('<div class="modal-dialog"></div>');
    this.$content = $('<div class="modal-content"></div>');
    this.$header = $('<div class="modal-header"></div>');
    this.$close = $('<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>');
    this.$h4 = $('<h4 id="myModalLabel" class="modal-title"></h4>');
    this.$body = $('<div class="modal-body"></div>');
    this.$footer = $('<div class="modal-footer"></div>');
    this.$cancel = $('<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>');
    this.$submit = $('<a class="btn btn-primary">确认</a>');
    this.defaultSettings = {
        bind: "",
        id: "myModal",
        elem: "body",
        header: "是否确认？",
        body: "温馨提示：请谨慎操作！",
        href : "javascript:;"
    };
    $.extend(this.defaultSettings,settings);
}
Modal.prototype.init = function () {
    this.$header.append(this.$close).append(this.$h4);
    this.$footer.append(this.$cancel).append(this.$submit);
    this.$content.append(this.$header).append(this.$body).append(this.$footer);
    this.$dialog.append(this.$content);
    this.$modal.attr("id",this.defaultSettings.id).append(this.$dialog);
    //插入dom结构
    $(this.defaultSettings.elem).append(this.$modal);
    this.$h4.html(this.defaultSettings.header);
    this.$body.html(this.defaultSettings.body);
    this.$submit.attr("href",this.defaultSettings.href);
    //绑定
    $(this.defaultSettings.bind).attr({
        'data-toggle' : 'modal',
        'data-target' : '#'+this.defaultSettings.id,
        'data-backdrop' : 'false'
    });
};
Modal.prototype.pop = function(){
    //console.log($("#"+this.defaultSettings.id));
    //$(this).modal('show');

};
Modal.prototype.close = function(){
    this.$close.trigger("click");
};
//给所有退出登录添加模态框
var modSet = {
    bind: ".signout",
    header: "确认退出？",
    body: "温馨提示：请谨慎操作！",
    href : "php/logout_pre.php"
};
var modal = new Modal(modSet);
modal.init();

/*定义loading方法*/
function loading() {
    $(".loading").show();
    //禁止滚动条
    $("html").css({
        "height":"100%",
        "overflow":"hidden"
    });
    $("body").css({
        "height":"100%",
        "overflow":"hidden"
    });
    //图片预加载
    var oImg = new Image();
    oImg.onload = function () {
        //隐藏加载图片
        $(".loading").delay(500).fadeOut(500);
        //启动滚动条
        $("html").css("overflow","auto");
        $("body").css("overflow","auto");
    };
    //获取cookie
    if ($.cookie("style")) {
        oImg.src = "images/" + $.cookie("style") + ".jpg";
    } else {
        oImg.src = "images/a.jpg";
    }
}
//先执行一次loading
loading();

