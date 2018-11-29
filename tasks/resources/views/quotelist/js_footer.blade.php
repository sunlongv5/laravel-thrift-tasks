{{--<link rel="stylesheet" href="/js/plugins/layui/css/layui.css"  media="all">--}}
<script src="/js/plugins/layui/layui.js" charset="utf-8"></script>
<script>
    layui.use('upload', function(){
        var $ = layui.jquery;
        var upload = layui.upload;
        upload.render({
            elem: '#test1',
            url: '/ajax/updateCrmQuote',
            accept: 'file' ,
            exts: 'xls',
            done: function(res){
                layer.msg(res.err_msg);
                if(res.err_code == 0){
                    setTimeout(function(){
                        location.reload()
                    },3000);
                }
            }
        });

        upload.render({
            elem: '#export_customer',
            url: '/ajax/uploadCustomer',
            accept: 'file' ,
            exts: 'xls',
            done: function(res){
//                console.log(res);
                layer.msg(res.err_msg);
                if(res.err_code == 0){
                    setTimeout(function(){
                        location.reload()
                    },3000);
                }
            }
        });
    });


</script>