+(function($){
	$.lie = $.lie || {version: "v1.0.0"};

	$.extend($.lie, {
		details:{
			index:function(){
                // 编辑基本资料
                $('.base-edit').click(function(){
                    $('#userModal').modal('show');

                    var source  = $('.base-source').val();
                    var adtag   = $('.base-adtag').val();

                    if (source) {
                        $('.base-source').attr('disabled', true);
                    }

                    if (adtag) {
                        $('.base-adtag').attr('disabled', true);
                    }
                })

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

                // 编辑基本资料 -- 完成
                $('.base-success').click(function(){
                    var user_id = $('input[name=user_id]').val();
                    var source  = $('.base-source').val();
                    var adtag   = $('.base-adtag').val();
                    var grade   = $('.base-grade').val();
                    var status  = $('.base-status').val();
                    var mobile  = $('.base-mobile').val();
                    var email   = $('.base-email').val();
                    var wechat  = $('.base-wechat').val();
                    var qq      = $('.base-qq').val();
                    var channel_source = $('.base-channel-source').val();
                    var channel_source_other = $('.channel-source-other').val();
                    var need_type = $('.base-need-type').val();
                    var need_type_other = $('.need-type-other').val();
                    var add_wechat = $('.base-add-wechat').val();
                    var join_group = $('.base-join-group').val();

                    $.ajax({
                        url : '/ajax/ajaxEditUser',
                        type: 'post',
                        data: {user_id : user_id, source : source, adtag : adtag, grade : grade, status : status, mobile : mobile, email : email, wechat : wechat, qq : qq, channel_source : channel_source, channel_source_other : channel_source_other, need_type : need_type, need_type_other : need_type_other, add_wechat : add_wechat, join_group : join_group},
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

                // 新增公司
                $('.company-add').click(function(){
                    $('#addCompanyModal').modal('show');
                })

                // 编辑公司
                $('.company-edit').click(function(){
                    $('#companyModal').modal('show');
                })

                 // 新增/编辑公司 -- 完成
                $('.company-success').click(function(){
                    var user_id       = $('input[name=user_id]').val();
                    var com_name      = $('.com_name').val();
                    var com_type      = $('.com_type').val();
                    var address       = $('.address').val();
                    var com_email     = $('.com_email').val();
                    var com_fixed_tel = $('.com_fixed_tel').val();
                    var com_website   = $('.com_website').val();
                    var com_fax       = $('.com_fax').val();
                    var project_name  = $('.project_name').val();
                    var main_brand    = $('.main_brand').val();
                    var com_scale     = $('.com_scale').val();
                    var com_desc      = $('.com_desc').val();
                    var com_id        = $('input[name=com_id]').val();

                    if (!com_name) {
                        layer.msg('请填写公司名称');
                        return false;
                    }

                    // if (!address) {
                    //     layer.msg('请填写公司地址');
                    //     return false;
                    // }

                    if (com_id) {
                        var url = '/ajax/ajaxEditCompany';
                    } else {
                        var url = '/ajax/ajaxAddCompany';
                    }

                    var data = $('.companyForm').serialize();

                    $.ajax({
                        url : url,
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

                // 新增联系人
                $('.linkman-add').click(function() {
                    $('#addLinkmanModal').modal('show');
                })

                // 编辑联系人
                $('.linkman-edit').click(function() {
                    var lid = $(this).data('lid');
                    $('#editLinkmanModal_'+lid).modal('show');
                })

                $('.linkman_mobile, .bank_account').keyup(function(){
                    var val = $(this).val();

                    if (val) {
                        if (isNaN(val)) {
                            layer.msg('只能是数字');
                            $(this).val('');
                        }    
                    }
                })

                // 新增/编辑联系人 -- 提交
                $('.linkman-success').click(function(){
                    var user_id = $('input[name=user_id]').val();
                    var linkman_name = $(this).parent().siblings('.modal-body').find('input[name=linkman_name]').val();
                    var department = $(this).parent().siblings('.modal-body').find('input[name=department]').val();
                    var duty = $(this).parent().siblings('.modal-body').find('input[name=duty]').val();
                    var linkman_mobile = $(this).parent().siblings('.modal-body').find('input[name=linkman_mobile]').val();

                    if (!linkman_name) {
                        layer.msg('请填写姓名');
                        return false;
                    }

                    if (!department) {
                        layer.msg('请填写部门');
                        return false;
                    }

                    if (!duty) {
                        layer.msg('请填写职务');
                        return false;
                    }

                    if (linkman_mobile) {
                        var reg = /^\d{11}$/;
                        if (!reg.test(linkman_mobile)) {
                            layer.msg('请填写11位手机号码');
                            return false;
                        }
                    }

                    var lid = $(this).data('lid');

                    if (lid) {
                        var data = $('.editLinkmanForm_'+lid).serialize();
                        var url = '/ajax/ajaxEditLinkman';
                    } else {
                        var data = $('.addLinkmanForm').serialize();
                        var url = '/ajax/ajaxAddLinkman';
                    }
                    
                    data = data + '&user_id=' + user_id;
                    
                    $.ajax({
                        url : url,
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

                // 删除联系人
                $('.linkman-del').click(function(){
                    var user_id = $('input[name=user_id]').val();
                    var lid = $(this).data('lid');

                    layer.open({
                        title : '删除联系人',
                        content : '确定删除联系人吗？',
                        btn : ['确认', '取消'],
                        btn1 : function () {
                            $.ajax({
                                url : '/ajax/ajaxDelLinkman',
                                type: 'post',
                                data: {user_id : user_id, link_id : lid},
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

                // 新增公司发票
                $('.invoice-add').click(function(){
                    $('#addInvoiceModal').modal('show');
                })

                // 编辑公司发票
                $('.invoice-edit').click(function() {
                    var vid = $(this).data('vid');
                    $('#editInvoiceModal_'+vid).modal('show');
                })

                // 新增 / 编辑公司发票 -- 提交
                $('.invoice-success').click(function(){
                    var user_id = $('input[name=user_id]').val();
                    var com_name = $(this).parent().siblings('.modal-body').find('input[name=com_name]').val();
                    var tax_no = $(this).parent().siblings('.modal-body').find('input[name=tax_no]').val();
                    var bank_account = $(this).parent().siblings('.modal-body').find('input[name=bank_account]').val();

                    if (!com_name) {
                        layer.msg('请填写公司名称');
                        return false;
                    }

                    if (!tax_no) {
                        // layer.msg('请填写税务登记号');
                        // return false;
                    } else {
                        var tax_reg = /^[A-Z0-9\-]+$/;
                        if (!tax_reg.test(tax_no)) {
                            layer.msg('格式有误，税务登记号包含数字、大写字母及横线-');
                            return false;
                        }

                        if (tax_no.length != 15 && tax_no.length != 18 && tax_no.length != 20) {
                            layer.msg('请填写15、18或20位税务登记号');
                            return false;
                        }
                    }

                    if (bank_account) {
                        var bank_reg = /^\d{16,21}$/;
                        console.log(bank_reg.test(bank_account))
                        if (!bank_reg.test(bank_account)) {
                            layer.msg('请填写16到21位银行账号');
                            return false;
                        }
                    }

                    var vid = $(this).data('vid');

                    if (vid) {
                        var data = $('.editInvoiceForm_'+vid).serialize();
                        var url = '/ajax/ajaxEditInvoice';
                    } else {
                        var data = $('.addInvoiceForm').serialize();
                        var url = '/ajax/ajaxAddInvoice';
                    }
                                        
                    data = data + '&user_id=' + user_id;
                    
                    $.ajax({
                        url : url,
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

                // 删除公司发票
                $('.invoice-del').click(function(){
                    var user_id = $('input[name=user_id]').val();
                    var vid = $(this).data('vid');

                    layer.open({
                        title : '删除公司发票',
                        content : '确定删除该发票吗？',
                        btn : ['确认', '取消'],
                        btn1 : function () {
                            $.ajax({
                                url : '/ajax/ajaxDelInvoice',
                                type: 'post',
                                data: {user_id : user_id, inv_id : vid},
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

                // 公司发票 ---展开银行信息
                $('.inv-info').click(function(){
                    $(this).parent('.row').next('.show-bank-info').toggle();
                })

                /***                备注提醒部分                   ***/          
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

                // 删除备注
                $('.del-remark').click(function(){
                    var user_id = $('input[name=user_id]').val();
                    var rid = $(this).data('rid');

                    layer.open({
                        title : '删除备注提醒',
                        content : '确定删除该条备注吗？',
                        btn : ['确认', '取消'],
                        btn1 : function () {
                            $.ajax({
                                url : '/ajax/ajaxDelRemark',
                                type: 'post',
                                data: {user_id : user_id, rid : rid},
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



            }
        }
    });
})(jQuery)