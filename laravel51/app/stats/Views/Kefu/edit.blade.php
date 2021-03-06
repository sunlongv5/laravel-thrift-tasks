@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">
                        <a href="http://mg.com/contract/contracts/29">MG-NJ-01007</a>
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </h4>
                </header>
                <div class="panel-body">
                    <div class="account">
                        <form method="POST" action="http://mg.com/refund/refunds/3/update" accept-charset="UTF-8" class="form-horizontal"><input name="_method" type="hidden" value="PUT"><input name="_token" type="hidden" value="dv2RT57s9na6PNR1Z2zIbBA2qdoMYtuqcbLOJgPR">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><i class="required">*</i>合同编号</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="contract_code" value="MG-NJ-01007">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><i class="required">*</i>退款金额</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="data[money]" value="500000" placeholder="元">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><i class="required">*</i>退款说明及备注</label>
                                <div class="col-sm-8">
                                    <textarea name="data[note]" placeholder="请详细填写退款说明和备注，方便财务确认" class="form-control">业委会不同意</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button class="btn btn-primary" id="commit" type="button">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        $(function(){
            $("#commit").click(function(){
                var pay_money = $("input[name ='data[money]']").val();
                if(pay_money != parseInt(pay_money)){
                    alertMsg('请填写退款金额！');
                    $("input[name ='data[money]']").focus();
                    return;
                }
                var note = $("textarea").val();
                if(note.length < 10){
                    alertMsg('请详细填写退款说明！');
                    $("textarea").focus();
                    return;
                }
                $(this).parents("form").submit();
            });
        });
    </script>
    <link rel="stylesheet" type="text/css" href="/static/css/mystyle.css">
    <style type="text/css">
        #fancybox-overlay {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: #000;
            background-color: rgba(102, 102, 102,0.3);
            z-index: 1100;
            display: none;
        }
        #fancybox-wrap {
            position: absolute;
            top: 0;
            left: 0;
            margin: 0;
            padding: 10px;
            z-index: 1101;
            display: none;
            box-sizing: initial;
        }
        #fancybox-outer {
            position: relative;
            width: 100%;
            height: 100%;
            background: #FFF;
        }
        #fancybox-inner {
            position: absolute;
            top: 0;
            left: 0;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: 0;
            outline: none;
            overflow: hidden;
        }
        #fancybox-img {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            border: none;
            outline: none;
            line-height: 0;
            vertical-align: top;
            -ms-interpolation-mode: bicubic;
        }
    </style>
    <div id="fancybox-overlay">
        <div id="fancybox-wrap" style="width: 485px; height: 485px; top: 100px; left: 300px; display: block;">
            <div id="fancybox-outer">
                <div id="fancybox-inner" style="top: 10px; left: 10px; width: 465px; height: 465px;">
                    <img id="fancybox-img" style="cursor: zoom-out" src="" alt="">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            //图片查看关闭
            $("#fancybox-overlay").click(function(){
                $(this).hide();
            });
            $(".photo img").hover(function(){
                $(this).css('cursor','zoom-in');
            },function(){});

            $(".photo img").dblclick(function(){
                var default_width = 600;
                var imgsrc = $(this).attr('src');
                $("#fancybox-img").attr('src',imgsrc);
                var image = new Image();
                image.src = imgsrc;
                image.onload = function() {
                    if(image.width < default_width){
                        $("#fancybox-wrap").css({"width":image.width+20+'px',"height":image.height+20+'px',
                            "left":parseInt((window.innerWidth-image.width-20)/2)+'px',"top":parseInt((window.innerHeight-image.height-20)/2)+'px'});
                        $("#fancybox-inner").css({"width":image.width+'px',"height":image.height+'px'});
                    }else{
                        var autoheight = parseInt(default_width * image.height / image.width);
                        $("#fancybox-wrap").css({"width":default_width+20+'px',"height": autoheight+20+'px',
                            "left":parseInt((window.innerWidth-default_width-20)/2)+'px',"top":parseInt((window.innerHeight-autoheight-20)/2)+'px'});
                        $("#fancybox-inner").css({"width":default_width+'px',"height": 'auto'});
                    }
                    $("#fancybox-overlay").show();
                };
            });
        });
    </script>
@stop
