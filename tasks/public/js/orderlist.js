+(function($){
	$.lie = $.lie || {version: "v1.0.0"};

	$.extend($.lie, {
		orderlist:{
			index:function(){
                // 查看订单详情
                $('.orderDetail').click(function(){
                	var id = $(this).data('id');
                	
                	if (is_user_type == 1 || is_user_type == 3) {
                        if ($(this).data('type') == 1) {
                            var url = order_details_url+id;
                        } else {
                            var url = order_details_url+id+'?tags=self';
                        }               		
                	} else {
                		var url = member_details_url+id;
                	}

                	layer.open({
                		title: '订单详情',
                		area:['1000px', '600px'],
                		type: 2,
                		content: url,
                	});
                })

                // 添加备注
                $('.orderRemark').click(function() {
                    var order_id = $(this).data('id');
                    var order_remark = $(this).data('remark');
                    var content = '<textarea name="remark" class="form-control remark" cols="60" rows="8" placeholder="请输入备注信息" style="resize:none;">'+order_remark+'</textarea>';

                    layer.open({
                        title: '添加备注',
                        area:['500px', '300px'],
                        content: content,
                        btn : ['确认', '取消'],
                        btn1 : function (index) {
                            var remark = $('.remark').val();

                            // if (!remark) {
                            //     layer.tips('请输入备注信息', $('.remark'));
                            //     return false;
                            // }

                            $.ajax({
                                url : '/ajax/ajaxOrderRemark',
                                type: 'post',
                                data: {order_id: order_id, remark: remark},
                                success : function (resp) {
                                    if (resp.err_code == 0) {
                                        layer.msg(resp.err_msg);
                                        setTimeout(function(){
                                            location.reload();
                                        }, 1000);
                                    }

                                    layer.msg(resp.err_msg);
                                    return false;
                                },
                                error : function (err) {
                                    console.log(err)
                                }
                            })
                        },
                        btn2 : function (index) {
                            layer.close(index);
                        } 
                    });
                })

                // 展示列表下的内容
                $('.show-list').click(function(){
                    var nextTr = $(this).parent('tr').next('.show-other-content');

                    if (nextTr.css('display') == 'none') {
                        $(this).parent('tr').siblings('.show-other-content').hide();
                        nextTr.show();
                    } else {
                        nextTr.hide();
                    }
                })

            }
        }
    });
})(jQuery)