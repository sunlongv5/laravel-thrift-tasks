var Utils = {
    sprintf: function() {
        var arg = arguments,
                str = arg[0] || '',
                i, n;
        for (i = 1, n = arg.length; i < n; i++) {
            str = str.replace(/%s/, arg[i]);
        }
        return str;
    },

    //获取窗口的宽、高
    getDocWH: function () {
        var doc = jQuery(document), win = jQuery(window), Obj = {
            doc_h: doc.height(), //页面的高、宽
            doc_w: doc.width(),
            sTop: doc.scrollTop(), //页面卷上的高、宽
            sLeft: doc.scrollLeft(),
            win_h: win.height(), //浏览器窗口的高、宽
            win_w: win.width()
        };
        return Obj;
    },

    //是否是数组
    isArray: function (a) {
        return a &&
                typeof a === 'object' &&
                typeof a.length === 'number' &&
                typeof a.splice === 'function' &&
                !(a.propertyIsEnumerable('length'));
    },

    //判断值是否在数组内
    inArray: function (str, arr) {
        for (var i = 0; i < arr.length; i++) {
            if (arr[i].toString() == str) {
                return true;
            }
        }
        return false;
    },

    //是否为空，allowBlank为是否可为空字符串
    isEmpty: function (v, allowBlank) {
        return v === null || v === undefined || ((Utils.isArray(v) && !v.length)) || (!allowBlank ? v === '' : false);
    },

    hasOwnProperty: function (sKey) {
        try{
            return (new RegExp("(?:^|;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
        }catch(e){}

        return "";
    },

    //添加Cookie
    addCookie: function (sKey, sValue, cookieDay)
    {
        try{
            if(!sKey) { return; }

            var str = "";
            if (cookieDay > 0){
                //为0时不设定过期时间，浏览器关闭时cookie自动消失
                var date = new Date();
                var ms = cookieDay * 24 * 3600 * 1000;
                date.setTime(date.getTime() + ms);
                str = ";expires=" + date.toGMTString();
            }

            document.cookie = escape(sKey) + "=" + escape(sValue) + "; path=/"+str;
        }catch(e){}
    },

    //删除Cookie
    removeCookie: function (sKey)
    {
        try{
            if (!sKey || !Utils.hasOwnProperty(sKey)) { return; }
            document.cookie = escape(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
        }catch(e){}
    },

    //获取指定名称的cookie的值
    getCookie: function (sKey)
    {
        try{
            if (!sKey || !Utils.hasOwnProperty(sKey)) { return null; }
            return unescape(document.cookie.replace(new RegExp("(?:^|.*;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*((?:[^;](?!;))*[^;]?).*"), "$1"));
        }catch(e){}

        return "";
    },

    /**
     * 仿smarty 标签替换
     * eg: renderTpl(tpl, replace, ...)
     * renderTpl(tpl, {placeholder: replace, ...})
     */
    renderTpl: function (tpl, data) {
        var reg = /{[^<^=^}.]*}/ig,
                mode = 1,
                args = arguments,
                count = 1;
        d = data;
        if (arguments.length > 2) {
            mode = 1;
        }
        else if (Object.prototype.toString.apply(data) === '[object Object]') {
            mode = 2;
        }
        // 将字符串中所有以{开始，以}结束的字符串替换为对应的值
        return tpl.replace(reg, function (placeholder, pos) {
            placeholder = placeholder.substr(1, placeholder.length - 2);
            var groups = placeholder.split('|'),
                    valueOnEmpty = '',
                    wrapper = '',
                    replace = '',
                    i, sep;
            if (groups.length == 2) {
                placeholder = groups[0];
                if (groups[1].toUpperCase() == 'S') {
                    if (groups[1] == 's') {
                        wrapper = '\'';
                    }
                    else {
                        wrapper = '\"';
                    }
                }
                else {
                    valueOnEmpty = groups[1];
                }
            }
            else if (groups.length == 3) {
                placeholder = groups[0];
                valueOnEmpty = groups[1];
                if (groups[2] == 's') {
                    wrapper = '\'';
                }
                else {
                    wrapper = '"';
                }
            }
            if (mode === 1) {
                replace = args[count++] || valueOnEmpty;
            }
            else if (mode === 2) {
                replace = data[placeholder] || valueOnEmpty;
            }
            return wrapper + replace + wrapper;
        });
    },

    /**
     * 页面滚动到指定位置
     * @param target<int/object> 指定的位置
     */
    scrollTo: function(target){
        var top = 0;
        if (typeof target == 'object') {
            top = target.offset().top;
        } else {
            top = target;
        }
        $('html,body').animate({
            scrollTop: top - 60
        }, 400);
    },

    //阻止事件冒泡函数
    stopBubble: function (e) {
        var evt = e || window.event;

        if (evt.stopPropagation) {
            evt.stopPropagation();
        }

        evt.cancelBubble = true;
    },

    //阻止默认事件
    preventDefault: function (e) {
        var evt = e || window.event;

        if (evt.preventDefault) {
            evt.preventDefault();
        } else {
            evt.returnValue = false;
        }

        return false;
    }
};

var sidebar = function(){
    jQuery('.page-sidebar').on('click', 'ul.page-sidebar-menu li > a', function(e){
        if ($(this).next().hasClass('sub-menu') == false) {
            return;
        }

        var parent = jQuery(this).parent().parent();
        parent.children('li.open').children('.sub-menu').slideUp(300);
        parent.children('li.open').removeClass('open ');

        var sub = jQuery(this).next();
        if (!sub.is(":hidden")) {
            jQuery(this).parent().removeClass("open");
            jQuery(this).parent().parent().removeClass("open");
            sub.slideUp(300, function () {});
        } else {
            jQuery(this).parent().addClass("open");
            jQuery(this).parent().parent().addClass("open");
            sub.slideDown(300, function () {});
        }
        e.preventDefault();
    });

    //是否为首页
    var parentLiOjb = jQuery('.page-sidebar ul.page-sidebar-menu>li');
    if (parentLiOjb && parentLiOjb.length) {
        var len = parentLiOjb.length;
        var isHome = true;
        for(var i = 0; i < len; i++) {
            if (jQuery(parentLiOjb[i]).hasClass('active')) {
                isHome = false;
            }
        }
        isHome && jQuery('.page-sidebar ul.page-sidebar-menu>li').eq(0).addClass('active');
    }
};

//行政区域选择
var region = {
    boxOjb: null,
    dataCache: {
        provinces: null,
        citys: null,
        towns: null
    },
    /*
     * 初始化
     * @param container <string/Object> 行政区域表单容器
     */
    init: function(container, provinceId, cityId, districtId){
        var self = this;
        if ((typeof container).toLowerCase() == 'string') {
            self.boxOjb = $(container);
        } else {
            self.boxOjb = container;
        }
        self.getRegionData(function(){
            self.makeRegionHtml(1, 1, provinceId || 0);
            self.makeRegionHtml(2, provinceId || 2, cityId || 0);
            self.makeRegionHtml(3, cityId || 52, districtId || 0);
            self.bind();
        });
    },

    getRegionData: function(callback){
        var self = this;
        if(self.dataCache.provinces) {
            if (typeof callback == 'function') {
                callback();
            }
            return false;
        }

        $.ajax({
            type: 'post',
            url: '/region/getAll',
            dataType: 'json',
            success: function(resp){
                if (!resp) {
                    return layer.msg('网络异常，请稍后再试~');
                }

                if (resp.provinces) self.dataCache.provinces = resp.provinces;
                if (resp.citys) self.dataCache.citys = resp.citys;
                if (resp.towns) self.dataCache.towns = resp.towns;

                if (typeof callback == 'function') {
                    callback();
                }
            }
        })
    },

    bind: function(){
        var self = this, parent_id = 0;
        //省份选择事件
        $(self.boxOjb).find('select.s_province').on('change', function(){
            parent_id = $(this).val();
            self.makeRegionHtml(2, parent_id);
        });
        //城市选择事件
        $(self.boxOjb).find('select.s_city').on('change', function(){
            parent_id = $(this).val();
            self.makeRegionHtml(3, parent_id);
        });
    },

    makeRegionHtml: function(level, parentId, selectId){

        var optionHtml = [], self = this, _data = null, selectName = '', d_parent_id = 0;
        switch (level) {
            case 1:
                selectName = 's_province';
                _data = self.dataCache.provinces;
                break;
            case 2:
                selectName = 's_city';
                _data = self.dataCache.citys;
                break;
            case 3:
                selectName = 's_county';
                _data = self.dataCache.towns;
                break;
        }

        if (_data) {
            var item = null, children = null;
            for (var i in _data) {

                item = _data[i];
                if (item && item.parent_id == parentId) {
                    children = item.children;
                    optionHtml.push('<option value="0">请选择</option>');

                    for (var j in children) {
                        if (!d_parent_id) {
                            d_parent_id = children[j].region_id;
                        }
                        optionHtml.push('<option value="' + children[j].region_id + '">' + children[j].region_name + '</option>');
                    }
                    break;
                }
            }
        }

        self.boxOjb.find('select.' + selectName + '').html(optionHtml.join(''));

        if (level == 2) {
            self.makeRegionHtml(3, d_parent_id);
        }

        if (selectId) self.boxOjb.find('select.' + selectName + '').val(selectId);
    }
};

/* 公共js执行入口 */
+(function ($) {
    if ($ == undefined) {//依赖未加载
        alert('jQuery未加载');
        return;
    }
    $.lie = $.lie || {version: "v1.0.0"};
    //把对象调整到中心位置
    $.fn.setmiddle = function () {
        var dl = $(document).scrollLeft(),
                dt = $(document).scrollTop(),
                ww = $(window).width(),
                wh = $(window).height(),
                ow = $(this).width(),
                oh = $(this).height(),
                left = (ww - ow) / 2 + dl,
                top = (oh < 4 * wh / 7 ? wh * 0.382 - oh / 2 : (wh - oh) / 2) + dt;

        $(this).css({left: Math.max(left, dl) + 'px', top: Math.max(top, dt) + 'px'});
        return this;
    };
    //启用兼容placeholder 的赋值
    $.fn.setval=function(val){
        var obj=$(this);
        if(undefined==val&&null==val&&val==''){
            return;
        }
        $(this).prev('.label-prompt').hide();
         if(obj.prop('tagName')=='TEXTAREA'){
            $(this).text(val);
         }else if(obj.prop('tagName')=='INPUT' ){
            $(this).prev('.label-prompt').hide();
            $(this).val(val);
        }
    };

    //设置元素高度,高度为当前位置到屏幕底部位置
    $.fn.setFullHeight = function () {
        var eh = jQuery(window).height() - jQuery(this).offset().top - 20;  //.main-frame .content-customize 设置了padding 20 所以减去20

        jQuery(this).css("height", eh);
    };
    //提示信息 可自动消失  也可用于loading
     //提示信息 可自动消失  也可用于loading
    $.tip = function (options) {
        var settings = {
            content: '', //提示内容
            icon: 'success', //提示级别  success  error  alert, loading暂无图标
            time: 2000, //默认3秒消失
            close: false,
            zindex: 2999,
            event: function () {
            }   //关闭后调用
        };
        if (options) {
            $.extend(settings, options);
        }
        if (settings.close) {
            $(".tipbox").hide();
            return;
        }
        if (!$('.tipbox')[0]) {
            $('body').append('<div class="tipbox" style="display:none"><div class="tip-l"><i class="icon-tip"></i></div><div class="tip-c"></div><div class="tip-r"></div></div>');
            $('.tipbox').css('z-index', parseInt(settings.zindex));
        }
        $('.tipbox').attr('class', 'tipbox tip-' + settings.icon);
        $('.tipbox .tip-c').html(settings.content);
        $('.tipbox').css('z-index', parseInt($('.tipbox').css('z-index')) + 1).setmiddle().show();

        if (settings.time > 0) {
            setTimeout(function () {
               $(".tipbox").fadeOut();
                settings.event();
            }, settings.time);
        }
    };

    //以下调用 类似  $.lie.dialog(...)  或 jQuery.lie.dialog(...)
    $.extend($.lie, {
        //初始化就需要调用的
        init:function(){
            //控件美化
            this.controls();

            $(document).ready(function(){
                //还有兼容需调整,暂时关闭
                $.lie.placeholder();
            });

            $.lie.changeColor($('.changeColor'));
            $.lie.changeFont($('.changeFont'));
            $.lie.droplist($('.droplist'));
        },

        //兼容的获取可视区宽高
        screen:function(){
            var _width = window.innerWidth;
            var _height = window.innerHeight;
            if(typeof _width != 'number'){
                _width=$(window).width();
                _height=$(window).height();
            }
            return {width:_width,height:_height};
        },

        //公用的ajax取数据  post 方式
        //params  支持键值对象{a:1,b:1} 或 a=1&b=1形式
        //callback 回调函数
        //type:返回数据格式,默认不传即 json
        //isloading 是否显示loading 条,默认false
        post:function(uri,params,callback,type,isloading){
            var dtype=type||'json';
            isloading=isloading||false;
            //默认配置
            var settings={
                url:uri||'?',
                type:'POST',
                cache:false,//不缓存
                data:params||{},
                dataType:dtype,
                beforeSend:function (XMLHttpRequest){
                    //这里可以启动 loading
                    isloading&&$.lie.waitloading(true);
                },
                complete:function(XMLHttpRequest, textStatus){
                    //这里结束  loading
                    isloading&&$.lie.waitloading(false);
                },
                success:function(data, textStatus, jqXHR){
                    if(dtype=='json'){
                        if(data.errcode==255){
                            $.tip({content:data.errmsg,'icon':'error',event:function(){
                                location.href='login.php';
                            }});
                        }
                    }
                    if(typeof callback=='function'){
                        callback(data);
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){

                }
            };
            $.ajax(settings);
        },

        //参数及返回均与 post 一样
        get:function(uri,params,callback,type,isloading,isasync){
            var dtype=type||'json';
            isloading=isloading||false;
            //默认配置
            var settings={
                url:uri||'?',
                type:'GET',
                cache:false,//不缓存
                data:params||{},
                dataType:dtype,
                async: (typeof isasync == 'undefined' ? true : isasync),
                beforeSend:function (XMLHttpRequest){
                    //这里可以启动 loading
                    isloading&&$.lie.waitloading(true);
                },
                complete:function(XMLHttpRequest, textStatus){
                    //这里结束  loading
                    isloading&&$.lie.waitloading(false);
                },
                success:function(data, textStatus, jqXHR){
                    if(dtype=='json'){
                        if(data.errcode==255){
                            $.tip({content:data.errmsg,'icon':'error',event:function(){
                                location.href=$.lie.U('Admin/Index/index');
                            }});
                        }
                    }

                    if(typeof callback=='function'){
                        callback(data);
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){

                }
            };
            $.ajax(settings);
        },

        /*
        * 公用加载图标
        * 参数说明：
        * show：是否显示加载图标，true:显示 - false：消失
        * divid：定位div元素id,默认为body
        * */
        waitloading:function(show,divid){
            var o= jQuery('body');
            var pst = null;
            if(typeof divid =="string" && divid!="" ) {
                var p = $("#"+divid).offset();
                var p_h = $("#" + divid).height();
                var p_w = $("#" + divid).width();
                var t = p.top + (p_h<186?0:(p_h/3 - 62));
                var l = p.left + (p_w<124?0:(p_w/2 - 62));
                pst = 'top: ' + t + 'px;left:' + l + 'px;';

            }else{
                var t=o.height()/2-62;
                var l=o.width()/2-62;
                pst='top: '+t+'px;left:'+l +'px;';
            }
            $(".ktms_loading").remove();
            var html = "<div style='position:absolute;"+pst+"Z-index: 1999;'><img src=\"/img/loading.gif\" class=\"img-circle\"></div>";
            if (show) {
                o.append('<div class="ktms_loading" style="position:absolute;"></div>');
                o.find(".ktms_loading").append('<div class="wait_loading" style="position:relative;"></div>');
                jQuery(".ktms_loading .wait_loading").append(html);
            }
        },
        dialog: function (options) {//弹出框
            //默认的配置
            var setting = {
                id: 'dialog', //标识, 不建议覆盖, 这样一个页面就只会有一个弹框存在
                title: '系统提示', //弹窗标题
                pannel:'',   //弹框内显示的内容 非滚动区域 content 是 pannel的子集 与 content 互斥
                content: '', //弹框内显示的内容 滚动区域内容 与 pannel 互斥
                footer:'',  //底部内容
                style: '', //弹窗class样式支持,只针对model 本身
                css: {}, //覆盖样式支持,只针对model 本身
                layer: '<div id="dialog" class="modal"  role="dialog" aria-hidden="true"></div>',
                button_layer: {//弹出框按扭组
                    close: '<button class="btn" data-dismiss="modal" aria-hidden="true">close</button>',
                    ok: '<button class="btn btn-primary" >ok</button>'
                },
                button: ['close'], //默认显示启用的按扭
                button_title: {//按钮显示的名称
                    close: '关闭',
                    ok: '提交'
                },
                button_event: {
                    close: function (e) {
                        return true;
                    }, //关闭事件支持
                    ok: function () {
                    }   //提交事件支持
                },

                url: '', //弹框需要加载的链接 优先于content
                close: function (e) {
                    return true;
                }, //弹框关闭
                loaded: function () {
                }, //加载数据完执行
                time: 0, //打开后险多久自动关闭
                backdrop: 'static',  //true 为添加蒙版背景， static为点击弹框区域外不关闭
                autohide:false,     //点击其它地方是否自动关闭, 如果为true 请记得在 点击的按钮上添加   e.stopPropagation();阻止冒泡
                loading:false       //是否显示加载中  只针对传 url的

            };
            setting = $.extend({}, setting, options);
            var isExistButton = ((typeof setting.button == 'object' && setting.button != null && setting.button.length > 0) ? true : false);

            if (!$.fn.hasOwnProperty('modal')) {
                alert('缺少组件!');
                return;
            }

            //初始化,这里改变ID
            var dg = $('#' + setting.id);
            if (!dg[0]) {
                dg=$(setting.layer).attr('id', setting.id).appendTo('body');
            }else{
                dg.detach() .appendTo('body') ;
            }
            dg.removeAttr('style');
            dg.attr('class','modal hide');
            dg.html('<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4></h4></div><div class="modal-panel"> <div class="modal-content"></div> </div> <div class="modal-footer"></div>');

            //弹框应用大框架
            if (setting.style != '') {
                dg.addClass(setting.style);
            }
            //内容重置
            dg.find('.modal-content').html('');
            dg.find('.modal-footer').html('');


            //扩展调用
            $.extend(dg,{
                //显示事件
                open:function(){

                    this.show();
                    this.backdrop('show');

                    if(typeof setting.loaded=='function'){
                        setting.loaded();
                    }
                },
                //关闭窗口, 这里只是隐藏
                close:function(){
                    //关闭之前  调用自定义close
                    if(( typeof setting.close=='function'&& false===setting.close(this))
                        ||(setting.button_event.hasOwnProperty('close')&&typeof setting.button_event.close=='function'&&false===setting.button_event.close(this))){
                        return;
                    }
                    this.backdrop();
                    this.hide();
                },
                //外部直接调用remove方法只清除了窗口本身，未关联遮罩层操作
                //销毁窗口, 关联了遮罩层的
                destroy:function(){
                    this.backdrop();
                    this.remove();
                },
                //处理背景遮罩
                backdrop:function(opt){

                    if(setting.backdrop.toString()=='false'){
                        //this.css({'z-index':1039});
                        return;
                    }

                    if(opt=='show'){
                        //标示当前弹窗关联的遮罩
                        this.attr('data-backdrop','modal-backdrop');
                        //添加遮罩
                        if(!$('.modal-backdrop')[0]){
                            $('<div class="modal-backdrop  in"></div>').insertBefore( this );
                        }
                    }else{
                        if($('.modal[data-backdrop]').not(':hidden').length==1){
                            $('.modal-backdrop').remove();
                        }
                    }
                },
                modal:function(opt){
                    if(typeof opt!='string'){
                        alert('因为BS原生modal两次调用有堆栈溢出问题，已弃用，本方法现在只支持参数值现只有 show 与 hide');
                        return;
                    }
                    if(opt=='show'){
                        this.open();
                    }else if(opt=='hide'){
                        this.close();
                    }
                },
                //自适应可视区,在这之前应该填充除了标题以外的所有内容
                autoresize:function(){
                    var obj=this;

                     obj.open();

                        //可视区
                    var screen_h= $.lie.screen().height  ,screen_w= $.lie.screen().width,

                        //框内三块高度
                        dg_header=obj.find('.modal-header'), dg_panel=obj.find('.modal-panel'), dg_body=obj.find('.modal-content'),dg_footer=obj.find('.modal-footer'),

                        //最小高宽
                        min_w= parseInt(obj.css('min-width'))||0,
                        min_h=parseInt(obj.css('min-height'))||0,
                        //实际内容的高度
                        dg_body_h=dg_body.prop('scrollHeight'),
                        dg_body_w=dg_body.prop('scrollWidth'),

                        //实际弹窗的高宽
                        dg_h= 0,
                        //未指定宽度时 以内容宽度为准
                        dg_w= parseInt(setting.css.width)||(dg_body_w),

                        //居顶高度
                        dg_off_top=0,
                        //居左高度
                        dg_off_left=0,

                        dg_margin_left= parseInt(obj.css('margin-left')),
                        dg_title=dg_header.find('h4');

                    //实际的弹窗高度

                    if( parseInt(setting.css.height)>0){
                        dg_h= parseInt(setting.css.height);
                    }else{
                        dg_h=dg_header.outerHeight(true) +dg_footer.outerHeight(true);
                        dg_h+=dg_body_h;
                        //同组元素
                        dg_body.siblings().each(function(){
                            dg_h+=$(this).outerHeight(true);
                        });
                    }

                    //高宽重置到可视区范围内
                    dg_w= dg_w>screen_w?screen_w:dg_w;
                    dg_h= dg_h>screen_h?screen_h:dg_h;


                    //最小高宽限制
                     dg_w= dg_w<min_w?min_w:dg_w;
                     dg_h= dg_h<min_h?min_h:dg_h;


                    //窗口位置置入可视区中间
                    if(setting.css.left){
                        dg_off_left=parseInt( setting.css.left);
                    }else{
                        dg_off_left= (screen_w- dg_w)/2;
                    }
                    if(setting.css.top){
                        dg_off_top=parseInt( setting.css.top);
                    }else{
                        dg_off_top= (screen_h- dg_h)/2;
                    }
                    //重算偏移
                    if(dg_w+dg_off_left>screen_w){
                        //重新定义左偏移
                        dg_off_left=(screen_w-dg_w)/2;
                    }
                    //顶偏移后超出可视区纠正
                    if(dg_h+dg_off_top>screen_h){
                        //这里特殊处理//高度小于160的时候移位置,>300的时候收起高度
                        dg_off_top=  (screen_h-dg_h)/2;
                    }

                    //子项定宽
                    dg_panel.width( dg_w );
                    dg_body.width( dg_w );

                    //弹框标题限宽
                    dg_title.width(dg_w-
                                    parseInt(dg_header.css('padding-left'))-parseInt(dg_header.css('padding-right'))
                                    -dg_header.find('.close').outerWidth(true)- parseInt(dg_title.css('padding-left'))- parseInt(dg_title.css('padding-right')) -30 );
                    dg_title.text(setting.title);


                    //子项定高
                    dg_panel.height(dg_h-dg_header.outerHeight(true)-dg_footer.outerHeight(true));

                     if(dg_body_w>dg_w){
                         dg_body.css({'overflow-x':'auto'});
                     }
                     if(dg_body_h> dg_panel.height()){
                         dg_body.css({'overflow-y':'auto'});
                     }

                    obj.resizebody();

                    obj.css({
                        margin:'0px',//这里一定给清了
                        width:dg_w,
                        height:dg_h,
                        left:dg_off_left,
                        top:dg_off_top
                    });
                },
                //重置modal-body高度
                resizebody:function(){
                    var dg_panel= this.find('.modal-panel');
                    var dg_body= this.find('.modal-content');
                    var dg_body_h= dg_panel.height();
                    //var dg_h= this.find('.modal-header h4');
                    dg_body.siblings().each(function(){
                        dg_body_h-=$(this).outerHeight(true);
                    });
                    dg_body.css({height:dg_body_h,maxHeight:dg_body_h});
                },
                //外部可调用设置 modal-panel
                setpanel:function(content){
                    this.find('.modal-panel').html(content);
                    this.resizebody();
                },
                //外部可调用设置 modal-body内容
                setcontent:function(content){
                    this.find('.modal-content').html(content);
                },
                //外部可调用设置 modal-footer内容
                setfooter:function(content){
                    this.find('.modal-footer').html(content);
                },
                //外部可调用设置 modal-header 中的 h4内容
                settitle:function(title){
                    this.find('.modal-header h4').text(title);
                }
            });



            //底部按钮事件
            if (isExistButton) {
                //setting.button 决定要显示的按钮
                for (var i = 0; i < setting.button.length; i++) {
                    if (setting.button_layer.hasOwnProperty(setting.button[i])) {
                        var btn = $(setting.button_layer[setting.button[i]]);

                        if (setting.button_title.hasOwnProperty(setting.button[i])) {
                            btn.text(setting.button_title[setting.button[i]]);
                        }
                        btn.attr('data-tag', setting.button[i]).appendTo('#' + setting.id + ' .modal-footer');
                        //事件绑定
                        if (setting.button_event[setting.button[i]]) {
                            btn.unbind('click').click(setting.button_event[ setting.button[i]]);
                        }
                    }
                }
            }
            else {
                if(typeof setting.footer=='string'&&setting.footer!='') {
                    dg.setfooter( setting.footer ) ;
                }else{
                    dg.find('.modal-footer').remove();
                }
            }


             //优先地址加载
            if (setting.url != null && setting.url != '') {
                $.lie.get(setting.url,{},function (html) {
                    try {
                        json = JSON.parse(html);
                        if(json.errcode==1){
                            layer.msg(json.errmsg);
                            dg.close();
                        }
                    } catch(e) {
                        dg.setcontent(html);
                        dg.autoresize();
                    }
                },'html',setting.isloading);
                //dg_opt.remote默认只加载了一次,这是因为第二次调用的时候 modal未重新load
                //dg_opt.remote=setting.url;
            } else if (setting.content != ''||setting.pannel != '') {
                if(setting.pannel != ''){
                    dg.setpanel(setting.pannel );
                }
                if(setting.content!=''){
                    dg.setcontent(setting.content);
                }
                dg.autoresize();
            }

            //阻止关闭
            /*dg.find('[data-dismiss=modal]').unbind('click').click(function (e) {
                //其它按钮
                var button_tag = $(this).attr('data-tag');
                if (button_tag && setting.button_event.hasOwnProperty(button_tag)) {
                    if (setting.button_event[button_tag](e)) {
                        return true;
                    }
                }
                return false;
            });
            */
            //关闭事件
            dg.find('[data-dismiss=modal]').unbind('click').click(function(){
                dg.close();
            });

            if(setting.autohide){
                //这里 注意  #main_frame必须是全可视区
                //弃用body是因为事件冲突了
                $('#main_frame').click(function(){
                    dg.close();
                });
                $('.modal-backdrop').click(function(){
                    dg.close();
                });
            }
            //返回给外部调用
            return dg;
        },
        alert: function (msghtml, _setting) {
            var setting = {
                "width": "400px",
                "height": "auto",
                "_title": "系统提示",
                "_btn": "确定",
                "_callback": function () {
                    return true;
                }
            };
            for (var key in _setting) {
                if (_setting.hasOwnProperty(key)) {
                    setting[key] = _setting[key];
                }
            }
            jQuery.lie.dialog({
                title: setting['_title'], //弹窗标题
                button: ['close'], //默认显示启用的按扭
                css:{width:setting['width'],height:setting['height']},
                button_title: {//按钮显示的名称
                    close: '确定'
                },
                button_event: {
                    close: function() {setting['_callback'].call(null,null);return true}
                },
                content: "<div style=\"padding:10px 15px;\">"+msghtml+"</div>"      //弹框内显示的内容
            });
        },
        confirm: function (msghtml, _setting) {
            var setting = {
                "width": "400px",
                "height": "auto",
                "_title": "系统提示",
                "_btnOn": "确定",
                "_btnOff": "取消",
                "_callback_on": function () {
                    return true;
                },
                "_callback_off": function () {
                    return true;
                }
            };
            for (var key in _setting) {
                if (_setting.hasOwnProperty(key)) {
                    setting[key] = _setting[key];
                }
            }
           var dg= jQuery.lie.dialog({
                title: setting['_title'], //弹窗标题
                button: ['close','ok'], //默认显示启用的按扭
                css:{width:setting['width'],height:setting['height']},
                button_title: {//按钮显示的名称
                    ok: setting['_btnOn'],
                    close: setting['_btnOff']
                },
                button_layer: {//弹出框按扭组
                    ok: '<button class="btn btn-primary"  aria-hidden="true">'+setting['_btnOn']+'</button>',
                    close: '<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">'+setting['_btnOff']+'</button>'
                },
                button_event: {
                    ok: function() {
                    setting['_callback_on'].call(null,null);
                    dg.close();
                    return true},
                    close: function() {setting['_callback_off'].call(null,null);return true}
                },
                content: "<div style=\"padding:10px 15px;\">"+msghtml+"</div>"      //弹框内显示的内容
            });
        },

        //生成url地址
        U: function(str){
            var url = sysConfig.siteUrl;
            if (str) {
                var _url = str.split('/');

                //URL模式
                url += '/Admin';
                url += '/' + _url.join('/');
            }
            return url;
        },

        placeholder:function(){
            var input_tips='<label for="text-input" class="label-prompt" style="display: block;">请输入内容</label>';
            $('input[placeholder]').each(function(){
                var obj=$(this),
                tips=$(input_tips);
                tips.width(obj.width());

                var text= obj.val()||obj.text();
                if(text&&text!=''){

                }else{
                    tips.text(obj.attr('placeholder'));
                    obj.before( tips );
                    obj.removeAttr('placeholder');
                }

                obj.focus(function(){
                    $(this).prev('.label-prompt').hide();

                    setTimeout(function(){
                        //obj.trigger('focus');
                    },0);

                }).focusout(function(){
                    if($(this).val()==''){
                        $(this).prev('.label-prompt').show();
                    }
                });
                tips.click(function(){
                    $(this).hide();
                    $(this).next(':text').focus();
                });
            });

            $(window).resize(function(){
                $('.label-prompt').each(function(){
                    var obj=$(this);
                    obj.width( obj.next(':text').width());
                });
            });
        },

        changeColor:function(){
            $(function() {
                $('<input />', {id:'changeColor',name:$('.changeColor').attr('name'),type:'hidden',value:''}).appendTo($('.changeColor'));
                //输入事件
                $('#insColor').bind('input propertychange',function(e){
                    e.stopPropagation();
                    var item=$(this);
                    //设置选项值
                    $('#changeColor').val(item.attr('data-val')||'');
                });
            });
        },
        changeFont:function(){
            $(function() {
                $('<input />', {id:'changeFont',name:$('.changeFont').attr('name'),type:'hidden',value:''}).appendTo($('.changeFont'));
                //输入事件
                $('#insFont').bind('input propertychange',function(e){
                    e.stopPropagation();
                    var item=$(this);
                    //设置选项值
                    $('#changeFont').val(item.attr('data-val')||'');
                });
            });
        },

        //下拉框
        droplist:function(obj,callback){
            if (!obj[0]) {
                return ;
            }
            //支持批量绑定
            obj.each(function(){
                var dp=$(this);
                var s_list= dp.find('.dropdown-menu');
                var h_input=dp.find(':hidden[name="' +  (dp.attr('name')||'droplist')  +  '"]');
                var label=dp.find('span.dp-text');
                var icon= dp.find('span.right');
                var defval= dp.attr('data-default')||'';

                if(!label[0]){
                    //创建显示区
                    $('<span class="dp-text"></span>').appendTo(dp);
                    label=dp.find('span.dp-text');
                }

                if(!icon[0]){
                    //创建图标区
                    $('<span class="right"><i class="nicon-chevron-down"></i></span>').appendTo(dp);
                    icon=dp.find('span.right');
                }
                if(!h_input[0]){
                    //创建隐藏域
                    $('<input type="hidden"  name="'+(dp.attr('name')||'droplist') +'" value=""/>').appendTo(dp);
                    h_input=dp.find(':hidden[name="' +  (dp.attr('name')||'droplist')  +  '"]');
                }

                //扩展调用
                $.extend(dp,{
                    //设置选中的项
                    select:function(val){
                        var value= val||'';
                        var chk_item= $(this).find('.dropdown-menu li[data-val="'+val+'"]');

                        chk_item.siblings().removeClass('active');
                        chk_item.addClass('active');
                        h_input.val(value);
                        label.text(chk_item.text());
                    }
                });

                //选框事件
                dp.unbind('click').click(function(e){
                    //e.stopPropagation();
                    //$('.dropdown-menu').hide();
                    $(this).find('.nicon-chevron-down').toggleClass('active');
                    $(this).find('.dropdown-menu').fadeToggle('fast','linear');
                });

                //选项事件
                // $(".dp-color li").addClass("hide");
                s_list.on('click','li',function(e){
                    e.stopPropagation();
                    var item=$(this);
                    //设置选项值
                    h_input.val(item.attr('data-val')||'');
                    label.text(item.text());
                    //设置选项对应颜色
                    // var n = item.index();
                    // $(".dp-color li").addClass("hide");
                    // $(".dp-color li").eq(n).removeClass("hide");
                    //设置选中状态
                    item.siblings().removeClass('active');
                    item.addClass('active');
                    //切换显示
                    item.parents('.dropdown-menu').fadeToggle('fast','linear');
                    item.parents('.droplist').find('.nicon-chevron-down').toggleClass('active');
                    //回调
                   if(typeof callback=='function'){
                     callback(item,dp); //增加返回当前的下框dp
                   }
                });
                //设置默认选项
                dp.select(defval);
            });   

            $(document).click(function(e){
                var target=$(e.target);
                if(target.hasClass('.droplist')|| target.parents('.droplist')[0]){
                       target=target.hasClass('.droplist')?target:target.parents('.droplist');
                }
                obj.each(function(){
                    var dp=$(this);
                    if(target.is(dp)){
                        //当前项如果隐藏
                        if(dp.find('.dropdown-menu').is(':hidden')){

                        }
                    }else{
                        dp.find('.dropdown-menu').hide();
                        dp.find('.nicon-chevron-down').removeClass('active');
                    }
                });
            });
            return obj;
        },

        //公用简单控件美货
        controls:function(){
            //单选框切换
            $(document).on('change','.icon-input-radio :radio',function(){
                var obj=$(this);
                var lastcheck= obj.prop('checked');
                if(lastcheck){
                    $(':radio[name="'+obj.prop('name')+'"]').parents('.icon-input-radio').removeClass('active');
                    obj.parents('.icon-input-radio').addClass('active');
                }
            });
            //蓝色单选框切换
            $(document).on('change','.icon-input-radio-blue :radio',function(){
                var obj=$(this);
                var lastcheck= obj.prop('checked');
                if(lastcheck){
                    $(':radio[name="'+obj.prop('name')+'"]').parents('.icon-input-radio-blue').removeClass('active');
                    obj.parents('.icon-input-radio-blue').addClass('active');
                }
            });
            //复选框切换
            $(document).on('change','.icon-input-checkbox :checkbox',function(){
                var obj=$(this);
                if (obj.is(':checked')) {
                    obj.parents('.icon-input-checkbox').addClass('active');
                }else{
                    obj.parents('.icon-input-checkbox').removeClass('active');
                }
            });
        },

        //表单验证
        validator:function( form ,options){
            if(!form[0]){
                //未指定容器，不处理验证
                return;
            }
            var settings={
                submit:function(fm){
                    //提交验证
                },
                //验证规则
                valids:{}
            };
            //合并用户配置
            settings=$.extend({},settings,options);

            //支持验证的控件
            //目前支持 有name的 input textarea 控件
            var controls=':text[name],:password[name],textarea[name]';

            //扩展方法
            $.extend(form,{
                //获取指定控件的验证规则
                getruls:function(input){
                    var name=input.prop('name'),
                        valid=input.prop('valid')||{}, //控件上的验证
                        optvalid=settings.valids[name]||{};   //自定义的验证
                    var rule=$.extend({},valid,optvalid);
                    return rule;
                },
                //解决重名name引起的问题
                geterrorname:function(input){
                    //控件名
                    var input_name=input.prop('name');
                    //同名控件排序
                    var index=  input.index('[name="'+input_name+'"]');
                    return input_name.replace(/[\[\]]+/,'')+index.toString()+'error';
                },
                //创建提示框
                //input 验证的输入框
                //opt 对应input的验证规则
                //flag 创建后是否直接验证
                createvalid:function(input,opt,flag){
                    var id= this.geterrorname(input) ;
                    var rules=opt.rules||[];
                    //消息提示显示位置
                    var _left=0,_top=0;
                    //提示消息
                    var msg=$('<ul></ul>');
                    var msg_count=0;
                    if($('#'+id)[0]){
                        return;
                    }
                    //必填项,无分组
                    if(opt.require||false){
                        $('<li><i class="icon-warning-small"></i>必填项</li>').appendTo( msg );
                        msg_count++;
                    }
                    //规则提示, 引入分组
                    for(var i=0;i<rules.length;i++){

                        $('<li '+  (rules[i].hasOwnProperty('group')?('chk-group="'+rules[i].group+'"'):'')  +'><i class="icon-warning-small"></i>'+ rules[i].msg +'</li>').appendTo( msg );
                        msg_count++;
                    }
                    //如果是组合框，则取组合框外部位置
                    var div_input= input.parents('div.input-append,div.input-prepend,div.input-comb');
                    if(div_input[0]){
                         _top=  div_input.offset().top-   msg_count*20/2 + div_input.outerHeight(true)/2;
                        _left= div_input.offset().left+div_input.outerWidth(true);
                    }else{
                        _top= input.offset().top- msg_count*20/2+ input.outerHeight(true)/2;
                        _left=input.offset().left+ input.outerWidth(true);
                    }
                    //显示错误信息
                    var fchk= $.lie.pop({
                        id:id,
                        content:msg.prop('outerHTML'),
                        top:_top,
                        left:_left,
                        type:'form-chk right J_form_tips'
                    });
                    fchk.attr('data-type','validator');

                    //兼容一下折叠面板
                    if(input.parents('.accordion-group')[0]){
                        if(!input.parents('.accordion-group').find('.accordion-body').hasClass('in')){
                            input.parents('.accordion-group').find('.accordion-toggle').trigger('click');
                        }
                    }


                    if(flag){
                        this.valid( input,opt );
                    }
                },
                //异步验证
                //url 验证地址
                //id 错误容器id
                //index 错误项
                remote:function(url,params,id,index){//return true;
                    var obj=this;
                    var flag = false;
                    $.lie.get(url,params ,function(res){
                        if(res.errcode==0){
                            obj.showerror(id,index, true,res.errmsg );
                        }else{
                            obj.showerror(id,index, false,res.errmsg );
                        }
                        flag = res.errcode==0 ? true: false;
                    },null,'',false,false);
                    return flag;
                },
                //字符数
                bytelength:function(str){
                    return str.replace(/[^\x00-\xff]/g,"00").length;
                },
                //极值验证，最长
                extrememax:function(input,rules){
                    var val=input.val();
                    var flag=true;
                    $(rules).each(function(){
                        var rule=$(this)[0];
                        if(rule.hasOwnProperty('max')&& !isNaN( val )){
                            //暂时只做最长验证
                            //flag = val*1<=rule.max;
                        }else if(rule.hasOwnProperty('maxlen')){
                            flag = val.length<= rule.maxlen;
                            if(!flag){
                                val= val.substr(0,rule.maxlen);
                                input.val(val);
                            }
                        }
                        return flag;
                    });
                    return flag;
                },
                //对指定控件进行验证
                valid:function(input,opt){
                    var obj=this;
                    var rules=opt.rules||[];
                    var name=input.prop('name');
                    var value= $.trim(input.val())||'';
                    if(input.prop('tagName').toLowerCase()=='textarea'){
                        //value=input.text()||'';
                    }

                    var errorname=obj.geterrorname(input) ;
                    //是否必填
                    var ismust=opt.require||false;
                    //是否验证通过,只要有一个不通过，则为false
                    var ischk=true;
                    var isitemchk=true;
                    var remote_index=-1;
                    //分组的
                    var group_chk={};

                    //必填验证
                    if(ismust){
                        ischk=value!='';
                        obj.showerror(errorname,0,value!='');
                    }

                    //执行值验证
                    var check_rule=function(isnotnull,rule,val){
                        //非空, 或value不为空时
                        if(isnotnull||val!=''){
                            //关联主输入框验证
                            if(rule.hasOwnProperty('master')){

                                if(val!=  obj.find('[name="'+ rule.master +'"]') .val()   ){
                                    return false;
                                }
                            }

                            //min  max 验证   值大小验证
                            if(rule.hasOwnProperty('min')||rule.hasOwnProperty('max')){
                                 if(isNaN(val)){
                                    return false;
                                 }

                                 if( rule.hasOwnProperty('min')&&val<rule.min){
                                     return false;
                                 }
                                 if( rule.hasOwnProperty('max')&&val>rule.max){
                                     return false;
                                 }
                            }

                            //minlen   maxlen 验证
                            if(rule.hasOwnProperty('minlen')||rule.hasOwnProperty('maxlen')){
                                 if( rule.hasOwnProperty('minlen')&& obj.bytelength(val)<rule.minlen){
                                     return false;
                                 }
                                 if( rule.hasOwnProperty('maxlen')&&obj.bytelength(val)>rule.maxlen){
                                     return false;
                                 }
                            }
                            //正则验证
                            if(rule.hasOwnProperty('regex')){
                                var reg=new RegExp(rule.regex);
                                return reg.test(val);
                            }
                        }
                        return true;
                    };

                    //验证结果
                    var chk_result={};



                    //其它验证
                    for(var i=0;i<rules.length;i++){
                        var rule=rules[i]||{};
                        if(!rule.hasOwnProperty('regex')&&!rule.hasOwnProperty('remote')
                           &&!rule.hasOwnProperty('min')&&!rule.hasOwnProperty('max')
                           &&!rule.hasOwnProperty('minlen')&&!rule.hasOwnProperty('maxlen')
                           &&!rule.hasOwnProperty('master')
                            ){
                            //不在验证范围
                            continue;
                        }
                        //异步验证
                        if(rule.hasOwnProperty('remote')){
                            remote_index=i;
                            continue;
                        }
                        //无组验证
                        if(!rule.hasOwnProperty('group')){
                            isitemchk= check_rule(ismust,rule,value );
                            //输出错误
                            obj.showerror(errorname,(ismust?(i+1):i),isitemchk);
                        }else{//有组验证
                            //组内排在前面的已验证通过
                            if(group_chk.hasOwnProperty( rule.group )){
                                if(!group_chk[ rule.group]){
                                    //
                                    group_chk[ rule.group]=  check_rule(ismust,rule,value );
                                }
                            }else{
                                //添加分组验证
                                group_chk[ rule.group]=  check_rule(ismust,rule,value );
                            }
                            obj.showerror(errorname,(ismust?(i+1):i),group_chk[ rule.group]);
                        }
                        //
                        ischk= ischk?isitemchk:ischk;
                    }
                    //合并有分组的
                    for(var g in group_chk ){
                        if(!group_chk[g]){
                          ischk=false;
                          break;
                        }
                    }

                    //remote 验证
                    if(ischk&&value!=''&&remote_index>=0){
                        //必须是所有验证都通过后才去验证
                        var params={};
                        var rule= rules[remote_index];
                        params[name]=value;
                        ischk = obj.remote(rule.remote,params,errorname, (ismust?(remote_index+1):remote_index) );
                    }
                    return ischk;
                },
                //批量执行验证
                validates:function(){
                    var obj=this;
                    var flag=true;
                    obj.find(controls).each(function(){
                        var opt= obj.getruls($(this));
                        //验证不通过
                         flag= obj.valid($(this),opt);
                         //
                         if(!flag){
                             form.createvalid($(this),opt,true);
                            //$(this).trigger('focus');
                         }
                         return flag;//为false 时 each中断
                    });
                    return flag;
                },
                //指定显示错误
                showerror:function(id,index,flag,msg){
                    var error= $('#'+id);
                    var erroritem=null;
                    var errorli=null;
                    if(!error[0]){
                        //创建
                        return;
                    }
                    erroritem=error.find('li:eq('+index.toString()+') .icon-warning-small');
                    if(!erroritem[0]){
                        //没有那项
                        return;
                    }
                    errorli=erroritem.parents('li:eq(0)');//第一层父级li

                    //分组
                    var group= errorli.attr('chk-group')||'';
                    //先移除状态
                    erroritem.removeClass('active');
                    if(!flag){
                        erroritem.addClass('active')
                    }else{
                        //验证通过
                        if(group!=''){
                            //清除分组的
                            errorli.siblings('[chk-group='+group+']').find('.icon-warning-small').removeClass('active');
                        }
                    }
                    if(undefined!=msg&&null!=msg&&''!=msg){
                        error.find('li:eq('+index.toString()+')').html( erroritem.prop('outerHTML')+msg );
                    }
                },
                //清除验证成功的项
                clearsuccess:function(id){
                    var error= $('#'+id);
                    if(error.find('li.active')[0]){
                        //当有验证未通过
                        return;
                    }else{
                        //当验证全通过
                        error.remove();
                    }
                },
                //清除所有提示
                clear:function(){

                }
            });

            //以下事件使用 on 绑定，支持表单内异步添加输入框
            //获得焦点时
            form.on('focus',controls,function(){
                var input=$(this);   //自定义的验证
                var opt=  form.getruls(input);

                if(opt.hasOwnProperty('isfocus')&& opt.isfocus==false){
                    return;
                }
                form.createvalid(input,opt,true);
            });
            //输入时
            form.on('keyup keypress',controls,function(){
                var input=$(this);          //自定义的验证
                var opt= form.getruls(input);   //当前规则

                //输入限定
                if(!form.extrememax(input,opt.rules)){
                    return false;
                }
                //验证
                form.valid(input,opt);
            });

            //离开时,验证全对才消除
            form.on('blur',controls,function(){
                var input=$(this);   //自定义的验证
                var id=form.geterrorname(input);
                form.clearsuccess( id);
            });

            //处理事件冒泡冲突
            $(document).bind('click',function(e){
                 var target=$(e.target);
                 var errorid="";
                //点击tips本身
                if(target.parents('.J_form_tips')[0]){
                    //关闭非自已的提示
                    $('.J_form_tips').not('#'+target.parents('.J_form_tips').prop('id') ).remove();
                }
                //点击tips关联的控件
                else if(target.is(controls)){
                    errorid=  form.geterrorname( target );
                    $('.J_form_tips').not('#'+ errorid ).remove();
                }
                //点击其它区域
                else{
                    //非功能性的提交按钮
                    //.J_form_submit 这个是非form的提交按钮
                    //.J_button_submit  这个是提供form里面非submit按钮提交
                    //.btn-submit 这个是兼容之前的表单提交
                    //:submit   这个是兼容submit按钮提交
                    if(!target.is('.J_form_submit,.J_button_submit,.btn-submit,:submit')){
                        $('.J_form_tips').remove();
                    }
                }
            });

            //提交事件
            if(form.is('form')){
                //支持表单提交
                form.unbind('submit').submit(function(e){
                    // e.preventDefault();
                    //批量验证
                    var flag=true;
                    if(form.validates()){
                        if(typeof settings.submit=='function'){
                            var ret= settings.submit(form);
                            if(false===ret){
                                //阻止窗口提交
                                flag=false;
                            }
                        }
                    }else{
                        //验证失败
                        flag=false;
                    }
                    return flag;
                });
            }else{
            //支持非 form容器验证
               form.find('.J_form_submit').unbind('click').click(function(){
                   //批量验证
                    var flag=true;
                    if(form.validates()){
                        if(typeof settings.submit=='function'){
                            var ret= settings.submit(form);
                            if(false===ret){
                                //阻止窗口提交
                                flag=false;
                            }
                        }
                    }else{
                        //验证失败
                        flag=false;
                    }
                    //return false;
                    return flag;
               });
            }

            return form;
        },

        //显示一个气泡,目前应用场景为表单验证弹出提示项
        pop:function(options){
            var settings={
                id:'J_popover_chk',
                title:'',
                content:'',
                top:0,
                left:0,
                pannel:'',//容器
                type:'form-chk right',
                autohide:false
            };

            settings=$.extend({},settings,options);
            //应用bs工具提示
            var _p_html='<div class="popover '+(settings.type||'form-chk right')  +'" style="display:none"><div class="arrow"></div><div class="popover-content"></div></div>';
            //标示唯一
            var obj=$(_p_html).attr('id',settings.id||'J_popover_chk');
            if(!$('#'+(settings.id||'J_popover_chk'))[0] ){
                if(settings.pannel!=''&&settings.pannel!=null){
                    obj.appendTo(settings.pannel);
                }else{
                    obj.appendTo('body');
                }
            }else{
                obj=$('#'+(settings.id||'J_popover_chk'));
            }
            obj.css({position:'absolute',top:settings.top,left:settings.left});
            //加入内容
            if(settings.content==''||settings.content==null||$(settings.content).text()==''){
                obj.remove();
            }else{
                obj.find('.popover-content').html(settings.content);
                obj.show();
            }

            if(settings.autohide ){
                $(document).click(function(){
                    obj.remove();
                });
            }
            return obj;
        },

        //保存数据
        execute_ajax: function(data, url){
            $.ajax({
                type: 'post',
                data: data,
                dataType: 'json',
                url: url,
                success: function(resp){
                    if (resp.errcode == 0){
                        if (resp.jumpUrl) {
                            window.location.href = resp.jumpUrl;
                        } else {
                            window.location.reload();
                        }
                        return ;
                    }

                    $.lie.dialog({
                        id: 'dialog',
                        button: [''],
                        content: '<p style="text-align:center;" class="error">'+(resp.errmsg||'操作失败~')+'</p>'
                    });
                    return false;
                }
            });
        }
    });

    //初始化调用
    $.lie.init();
})(jQuery);