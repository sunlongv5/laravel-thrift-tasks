<script src="http://demo.htmleaf.com/1509/201509211641/js/center-loader.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<div class="layui-body"  style="bottom: 0;border-left: solid 2px #208FFF;padding: 0;margin: 0;background-color:#f1f2f7;" id="admin-body">
    <div class="layui-tab admin-nav-card layui-tab-brief" style="margin-top: 0;position: relative;" lay-filter="admin-tab">
        <ul id="q222" class="layui-tab-title layui-tab-more" style="background-color: #fff;border-top: 5px solid #208FFF;width: 95%;float:left; padding-right: 5%;height: auto;
    white-space: normal;">
            <li lay-id="" class="layui-this" >
                <i class="layui-icon"></i>
                <cite data-href="">新标签</cite>
                <i class="layui-icon layui-unselect layui-tab-close" data-id="1">ဆ</i>
            </li>
        </ul>
        <div class="layui-tab-content" style=" padding: 40px 0 0 0;">
            <div class="layui-tab-item layui-show"><iframe   src="{{isset($goto_url) && $goto_url ? $goto_url : "/dashboard"}}" data-id="1" style="height: 321px;"></iframe></div>
        </div>
    </div>
</div>
<script src="/static/js/jquery.js"></script>
<script>
function setFirstIframeHeight(value){
    if(value=="person"){
        var personHeight = $('#person').contents().find("meta").attr("content");
        $('#person').height(personHeight);
    }else if(value=="cell"){
        var cellHeight = $('#cell').contents().find("meta").attr("content");
        $('#cell').height(cellHeight);
    }
}

//(function(){
//    var kefuurl_href =  window.location.href;
//    var kefuurl = kefuurl_href.split("##");
//    var currentiframe = $(".layui-tab-content").find("iframe[data-id=1]");
//    var currenticon = $("#q222 li").children('i.layui-tab-close[data-id=1]');
//    if(kefuurl.length >=3){
//        var title = typeof(kefuurl[2]) != 'undefined' ? kefuurl[2] :'客服';
//        currentiframe[0].src = kefuurl[0]+"/"+kefuurl[1];
//        currenticon.siblings("cite").attr('href',kefuurl[0]+"/"+kefuurl[1]);
//        currenticon.siblings("cite").text(title)
//    }else{
//        if(window.location.pathname != "/"){
//            currentiframe[0].src = window.location.href;
//            currenticon.siblings("cite").attr('href',window.location.href);
//            currenticon.siblings("cite").text('新标签')
//        }else if(window.location.pathname == "/"){
//            currentiframe[0].src = '/dashboard';
//            currenticon.siblings("cite").attr('href',window.location.href);
//            currenticon.siblings("cite").text('首页')
//        }
//    }
//})();

//$(".layui-tab-content").find("iframe[data-id=1]").on('load',function(){
////    $(this).fadeIn();
//});

$(function(){
    $("#q222 li").children('i.layui-tab-close[data-id=1]').on('click',function(){
        $(this).parent().remove();
        $(".layui-tab-item").children("iframe[data-id=1]").parent().remove();
    })
})
</script>