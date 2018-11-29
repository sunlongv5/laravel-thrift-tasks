+(function($){
	$.lie = $.lie || {version: "v1.0.0"};

	$.extend($.lie, {
		assign:{
			index:function(){
                // 推送modal
                $('.open_sales_modal').click(function(){ 
                    var uid = $(this).data('uid');
                    var sale_id = $(this).data('saleid');

                    $('#assignModal').modal('show');
                    $('input[name=user_id]').val(uid); // 指定用户ID

                    $('.salesman').prop('checked', false); //全不选中

                    if (sale_id) {
                        var reg = /,/;
                        if (reg.test(sale_id)) {
                           var sid = sale_id.split(','); 

                           for (var i = 0; i < sid.length; i++) {
                                $('.sale_'+sid[i]).prop('checked', true); 
                           }
                        } else {
                           $('.sale_'+sale_id).prop('checked', true); 
                        }     
                    } 
                })

                // 指派
                $('.assign_to_salesman').click(function(){
                    var user_id = $('input[name=user_id]').val(); 
                    var sale_id = $('.salesman:checked').val();

                    if (!sale_id) {
                        layer.msg('请选择业务员');
                        return false;
                    } 

                    var data = $('.assignForm').serialize();

                    $.ajax({
                        url : '/ajax/ajaxAssign',
                        type: 'post',
                        data: data,
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
                })

                // 转出客户
                $('.roll-out').click(function() {
                    var uid = $(this).data('uid');
                    var type = $(this).data('type');

                    if (type == 1) {
                        var content = '确定转出该客户到客户池吗？';
                    } else {
                        var content = '确定转出所有业务员，重新分配吗？';
                    }

                    layer.open({
                        area: ['300px', '150px'],
                        title: '转出提示',
                        content: content,
                        btn: ['确定', '取消'],
                        btn1 : function (index) {
                            $.ajax({
                                url : '/ajax/ajaxRollOut',
                                type: 'post',
                                data: {user_id: uid, type: type},
                                success : function (resp) {
                                    if (resp.err_code == 0) {
                                        layer.msg(resp.err_msg);
                                        location.reload();
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
                    })
                })
            }
        }
    });
})(jQuery)