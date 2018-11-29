+(function($){
	$.lie = $.lie || {version: "v1.0.0"};

	$.extend($.lie, {
		followup:{
			index:function(){
                // 选择是否提醒
                $('.is_remind').click(function(){
                    if ($(this).val() == 1) {
                        $('.show-notice').show();
                    } else {
                        $('.show-notice').hide();
                    }
                })

                // 备注提醒 -- 提交
                $('.add-followup').click(function(){
                    var user_id = $('input[name=user_id]').val();
                    var fol_id = $('input[name=fol_id]').val();
                    var current_details = $('textarea[name=current_details]').val();
                    var is_contact = $('input[name=is_contact]:checked').val();
                    var grade = $('select[name=grade]').val();
                    var source = $('select[name=source]').val();
                    var next_details = $('textarea[name=next_details]').val();
                    var next_time = $('input[name=next_time]').val();
                    var is_remind = $('input[name=is_remind]:checked').val();
                    var remind_type = $('select[name=remind_type]').val();
                    var remind_time = $('input[name=remind_time]').val();
                    var sale_id = $('select[name=sale_id]').val();

                    if (fol_id) {
                        var url = '/ajax/ajaxEditFollowup';
                    } else {
                        var url = '/ajax/ajaxAddFollowup';
                    }

                    if (!current_details) {
                        layer.msg('请输入本次跟进详情');
                        return false;
                    }

                    if (is_contact == null) {
                        layer.msg('请选择是否接通');
                        return false;
                    }

                     if (!grade) {
                        layer.msg('请选择当前级别');
                        return false;
                    }

                    if (!source) {
                        layer.msg('请选择来源');
                        return false;
                    }

                    if (!next_details) {
                        layer.msg('请输入下次跟进事项');
                        return false;
                    }

                    if (!next_time) {
                        layer.msg('请选择下次跟进时间');
                        return false;
                    }

                    if (is_remind == null) {
                        layer.msg('请选择是否提醒');
                        return false;
                    }

                    if (is_remind == 1) {
                        if (remind_type == null) {
                            layer.msg('请选择提醒方式');
                            return false;
                        }

                        remind_type = remind_type.join(',');
                        $('.remind_type_val').val(remind_type);

                        if (remind_time == '') {
                            layer.msg('请选择提醒时间');
                            return false;
                        }
                    }

                    var data = $('.addFollowUpForm').serialize();

                    $.ajax({
                        url : url,
                        type: 'post',
                        data: data,
                        success : function (resp) {
                            if (resp.err_code == 0) {
                                layer.msg(resp.err_msg);
                                location.href = '/web/followup/'+user_id;
                            }

                            layer.msg(resp.err_msg);
                            return false;
                        },
                        error : function (err) {
                            console.log(err)
                        }
                    })
                })

                // 删除跟进记录
                $('.del-followup').click(function(){
                    var user_id = $('input[name=user_id]').val();
                    var fid = $(this).data('fid');

                    layer.open({
                        title : '删除跟进记录',
                        content : '确定删除该条记录吗？',
                        btn : ['确认', '取消'],
                        btn1 : function () {
                            $.ajax({
                                url : '/ajax/ajaxDelFollowUp',
                                type: 'post',
                                data: {user_id : user_id, fid : fid},
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
                        },
                    }) 
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