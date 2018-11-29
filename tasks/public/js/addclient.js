+(function($){
	$.lie = $.lie || {version: "v1.0.0"};

	$.extend($.lie, {
		addClient:{
			index:function(){
                // 选择渠道来源
                $('.base-channel-source').change(function() {
                    if ($(this).val() == 6) {
                        $('.base-channel-source-other').show();
                    } else {
                        $('.base-channel-source-other').hide();
                    }
                })

                // 选择需求类型
                $('.base-need-type').change(function() {
                    if ($(this).val() == 4) {
                        $('.base-need-type-other').show();
                    } else {
                        $('.base-need-type-other').hide();
                    }
                })

                // 新增提交
                $('.add-client').click(function(){
                    // 基本资料
                    var base_source = $('.base-source').val();
                    var base_adtag = $('.base-adtag').val();
                    var base_mobile = $('.base-mobile').val();
                    var base_email = $('.base-email').val();
                    var com_name = $('.com_name').val();
                    var channel_source = $('.base-channel-source').val();
                    var channel_source_other = $('.channel-source-other').val();
                    var need_type = $('.base-need-type').val();
                    var need_type_other = $('.need-type-other').val();
                    var reg = /^\d{11}$/;

                    if (!base_mobile) {
                        layer.tips('请填写手机号码', $('.base-mobile'));
                        return false;
                    }

                    if (!reg.test(base_mobile)) {
                        layer.tips('请填写11位手机号码', $('.base-mobile'));
                        return false;
                    }

                    // 渠道来源
                    if (channel_source == 6) { // 其他
                        if (!channel_source_other) {
                            layer.tips('其他来源不能为空', $('.channel-source-other'));
                            return false;
                        }
                    }

                    // 需求类型
                    if (need_type == 4) { // 其他
                        if (!need_type_other) {
                            layer.tips('其他类型不能为空', $('.need-type-other'));
                            return false;
                        }
                    }

                    if (!com_name) {
                        layer.tips('请填写公司名称', $('.com_name'));
                        return false;
                    }
                    
                    $.ajax({
                        url : '/ajax/ajaxAddClient',
                        type: 'post',
                        data: $('.addClientForm').serialize(),
                        success : function (resp) {
                            if (resp.err_code == 0) {
                                layer.msg(resp.err_msg);
                                setTimeout(function(){
                                    location.href = '/web/list';
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
            }     
        }
    });
})(jQuery)