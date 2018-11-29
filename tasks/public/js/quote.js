+(function($){
	$.lie = $.lie || {version: "v1.0.0"};

	$.extend($.lie, {
		quote:{
			index:function(){
                // 显示新增报价按钮
                // $('.is_quote').click(function(){
                //     var val = $(this).val();

                //     if (val != 0) {
                //         $('.add-quote').show();
                //     } else {
                //         $('.add-quote').hide();
                //     }
                // })

                // 新增报价
                $('.add-quote').click(function(){
                    $('#addQuoteModal').modal('show');   
                })

                // 编辑报价
                $('.edit-quote').click(function(){
                    var qid = $(this).data('qid');
                    $('#editQuoteModal_'+qid).modal('show');   
                })

                // 数量、单价校验
                $('body').delegate('.input_num', 'keyup', function(){
                    if(!(/^\d{0,7}(\.\d{0,4})?$/g.test( $(this).val()))){//判断输入是否合法，不合法强制转换
                        if(isNaN(parseFloat($(this).val()))){
                            layer.msg('只能是数字和小数组成');
                            $(this).val('');
                        }else{
                            $(this).val(parseFloat($(this).val()).toFixed(4));
                        }
                    }

                    if ($(this).val() < 0) {
                        layer.msg('只能是正整数');
                        $(this).val('');
                        return false;
                    }
                })

                // 查询型号和品牌名称
                query('goods_id', 'goods_name', '/ajax/ajaxQueryGoodsName');
                query('brand_id', 'brand_name', '/ajax/ajaxQueryBrandName');

                // 点击表单区域，隐藏下拉框
                $('body').delegate('#addQuoteModal, .editQuoteForm', 'click', function(){
                    $('.show-query-box').hide();
                })

                function query(field_id, field, url) 
                {
                    $(document).delegate('.'+field, 'keyup', function(e){
                        e.stopPropagation();
                        e.cancelBubble = true;
                        var k = window.event ? e.keyCode : e.which;
                        var self = $(this);
                        var val = self.val();

                        if (val != "" && k != 38 && k != 40 && k != 13) {      
                            $.ajax({
                                url : url,
                                type: 'post',
                                data: {keyword : val},
                                dataType: 'json',
                                success : function (resp) { 
                                    if (resp.err_code == 0) {
                                        var data = resp.data;
                                        var table = '<table class="table table-hover query-table">';

                                        for (var i = 0; i < data.length; i++) {
                                            table += '<tr class="line" data-id="'+data[i][field_id]+'"><td class="std">'+data[i][field]+'</td></tr>'
                                        }

                                        table += '</table>';

                                        self.siblings('.show-query-box').show();
                                        self.siblings('.show-query-box').empty();
                                        self.siblings('.show-query-box').append(table);
                                        $(".line:first").addClass("active"); 

                                        //鼠标点击事件  
                                        $(".line").click(function () {  
                                            var id = $(this).data('id');
                                            self.val($(this).text());  
                                            self.siblings('.'+field_id).val(id);
                                            self.siblings('.show-query-box').hide(); 
                                        }); 
                                    } else {
                                        self.siblings('.show-query-box').empty();
                                        self.siblings('.show-query-box').hide();
                                    }
                                },
                                error : function (err) {
                                    console.log(err)
                                }
                            })
                        }  else if (k == 38) { //上箭头  
                            $('.query-table tr.active').prev().addClass("active");  
                            $('.query-table tr.active').next().removeClass("active");  
                            self.val($('.query-table tr.active').text());  
                        } else if (k == 40) { //下箭头  
                            $('.query-table tr.active').next().addClass("active");  
                            $('.query-table tr.active').prev().removeClass("active");  
                            self.val($('.query-table tr.active').text());  
                        } else if (k == 13) { //回车  
                            self.val($('.query-table tr.active').text());  
                            self.siblings('.show-query-box').empty();  
                            self.siblings('.show-query-box').hide();  
                        } else {
                            self.siblings('.show-query-box').empty();  
                            self.siblings('.show-query-box').hide(); 
                        }  
                    })
                }    

                // 新增报价行
                $('.add-new-quote').click(function() {
                    var key = $('.add-quote-table').find('.add-quote-content').length; // 报价行数

                    // 新增行内容
                    var content = '<tr class="add-quote-content">'+
                                    '<td>'+
                                        '<input type="hidden" name="quote['+key+'][goods_id]" class="form-control goods_id" value="">'+
                                        '<input type="text" name="quote['+key+'][goods_name]" class="form-control goods_name" value="" required autocomplete="off" style="width: 120px;">'+
                                        '<div class="show-query-box"></div>'+ 
                                    '</td>'+
                                    '<td>'+
                                       '<input type="hidden" name="quote['+key+'][brand_id]" class="form-control brand_id" value="">'+
                                        '<input type="text" name="quote['+key+'][brand_name]" class="form-control brand_name" value="" required autocomplete="off" style="width: 120px;">'+
                                        '<div class="show-query-box"></div>'+
                                    '</td>'+                            
    
                                    '<td>'+
                                        '<input type="text" name="quote['+key+'][picking_num]" class="form-control picking_num input_num" value="" required autocomplete="off" style="width: 90px;">'+ 
                                    '</td>'+
                                    '<td>'+
                                        '<input type="text" name="quote['+key+'][picking_price]" class="form-control picking_price input_num" value="" autocomplete="off" style="width: 90px;"> '+   
                                    '</td>'+
                                    '<td>'+                                
                                        '<select name="quote['+key+'][picking_currency]" class="form-control picking_currency">'+
                                            '<option value="1">￥</option>'+
                                            '<option value="2">$</option>'+
                                            '<option value="3">€</option>'+
                                        '</select>'+
                                    '</td>'+
                                    '<td><input type="text" name="quote['+key+'][picking_rate]" class="form-control picking_rate input_num" value="1" autocomplete="off" style="width: 90px;" readonly="true"></td>'+
                                    '<td><span class="picking_amount"></span></td>'+
                                    '<td><span class="picking_price_no_tax"></span></td>'+
                                    '<td><span class="picking_price_tax"></span></td>'+
                                    '<td><span class="picking_amount_no_tax"></span></td>'+
                                    '<td><span class="picking_amount_tax"></span></td>'+

                                    '<td>'+
                                        '<input type="text" name="quote['+key+'][sale_num]" class="form-control sale_num input_num" value="" required autocomplete="off" style="width: 90px;"> '+
                                    '</td>'+
                                    '<td>'+                           
                                        '<input type="text" name="quote['+key+'][sale_price]" class="form-control sale_price input_num" value="" required autocomplete="off" style="width: 90px;">'+
                                    '</td>'+
                                    '<td>'+
                                        '<select name="quote['+key+'][sale_currency]" class="form-control sale_currency">'+
                                            '<option value="1">￥</option>'+
                                            '<option value="2">$</option>'+
                                            '<option value="3">€</option>'+
                                        '</select>'+
                                    '</td>'+
                                    '<td><input type="text" name="quote['+key+'][sale_rate]" class="form-control sale_rate input_num" value="1" autocomplete="off" style="width: 90px;" readonly="true"></td>'+
                                    '<td><span class="sale_amount"></span></td>'+
                                    '<td><span class="sale_price_no_tax"></span></td>'+
                                    '<td><span class="sale_price_tax"></span></td>'+
                                    '<td><span class="sale_amount_no_tax"></span></td>'+
                                    '<td><span class="sale_amount_tax"></span></td>'+

                                    '<td><span class="profit_no_tax"></span></td>'+
                                    '<td><span class="profit_tax"></span></td>'+
                                    '<td><span class="profit_rate"></span></td>'+

                                    '<td style="vertical-align: middle;">'+
                                        '<a class="btn btn-danger btn-xs add-quote-row-del">删除</a>'+
                                    '</td>'
                                '</tr>';

                    $('.add-quote-table').append(content);
                })

                // 删除row
                $('body').delegate('.add-quote-row-del', 'click', function() {
                    $(this).parents('.add-quote-content').remove();
                })

                // 输入数量、单价
                commonFunc('.picking_num', 'keyup', 'picking');
                commonFunc('.picking_price', 'keyup', 'picking');
                commonFunc('.sale_num', 'keyup', 'sale');
                commonFunc('.sale_price', 'keyup', 'sale');

                function commonFunc(selector, event, key) 
                {
                    $('body').delegate(selector, event, function(){
                        var num = $(this).parents('tr').find('.picking_num').val(); // 以采购数量为主

                        if (!num) { // 若为空，以对应元素数量为准
                            num = $(this).parents('tr').find('.'+key+'_num').val();
                        }

                        var price = $(this).parents('tr').find('.'+key+'_price').val();
                        var rate = $(this).parents('tr').find('.'+key+'_rate').val();

                        if (num && price && rate) {
                            commonCount($(this), num, price, rate, key, selector);     
                        }

                        // 输入采购数量时，销售数据变化
                        if (selector == '.picking_num') {
                            price = $(this).parents('tr').find('.sale_price').val();
                            rate = $(this).parents('tr').find('.sale_rate').val();
                            commonCount($(this), num, price, rate, 'sale', '.sale_price');
                        }
                    })
                }

                // 计算各项费用
                function commonCount(self, num, price, rate, key, selector)
                {
                    var fixed_fee = 1 + parseFloat(quote_fixed_fee); // 固定税率

                    var amount = parseFloat(num * price).toFixed(6); // 总价：数量*单价
                    var price_no_tax = parseFloat(price * rate).toFixed(6); // 未税单价：单价*汇率
                    var price_tax = parseFloat(price_no_tax * fixed_fee).toFixed(6); // 含税单价：未税单价*固定税率
                    var amount_no_tax = parseFloat(num * price_no_tax).toFixed(6); // 总价未税：数量*未税单价
                    var amount_tax = parseFloat(num * price_tax).toFixed(6); // 总价含税：数量*含税单价
                    console.log(price_no_tax);
                    console.log(fixed_fee);

                    self.parents('tr').find('.'+key+'_amount').text(amount);
                    self.parents('tr').find('.'+key+'_price_no_tax').text(price_no_tax);
                    self.parents('tr').find('.'+key+'_price_tax').text(price_tax);
                    self.parents('tr').find('.'+key+'_amount_no_tax').text(amount_no_tax);
                    self.parents('tr').find('.'+key+'_amount_tax').text(amount_tax);

                    if (selector == '.picking_num') { // 采购数量变化，同时调整销售数据
                        var sale_price = self.parents('tr').find('.sale_price').val();
                        var sale_amount = parseFloat(num * sale_price).toFixed(6); // 总价：数量*单价
                        var sale_price_no_tax = parseFloat(sale_price * rate).toFixed(6); // 未税单价：单价*汇率
                        var sale_price_tax = parseFloat(sale_price_no_tax * fixed_fee).toFixed(6); // 含税单价：未税单价*固定税率
                        var sale_amount_no_tax = parseFloat(num * sale_price_no_tax).toFixed(6); // 总价未税：数量*未税单价
                        var sale_amount_tax = parseFloat(num * sale_price_tax).toFixed(6); // 总价含税：数量*含税单价

                        self.parents('tr').find('.sale_amount').text(sale_amount);
                        self.parents('tr').find('.sale_price_no_tax').text(sale_price_no_tax);
                        self.parents('tr').find('.sale_price_tax').text(sale_price_tax);
                        self.parents('tr').find('.sale_amount_no_tax').text(sale_amount_no_tax);
                        self.parents('tr').find('.sale_amount_tax').text(sale_amount_tax);
                    }
                    
                    // 确定毛利
                    if (key == 'sale') {
                        var picking_num = self.parents('tr').find('.picking_num').val();
                        var picking_price = self.parents('tr').find('.picking_price').val();

                        if (picking_num && picking_price) {
                            profitCount(self);
                        }
                    } else {
                        var sale_num = self.parents('tr').find('.sale_num').val();
                        var sale_price = self.parents('tr').find('.sale_price').val();

                        if (sale_price) {
                            profitCount(self);
                        }
                    }
                }

                // 计算毛利
                function profitCount(self) 
                {
                    var sale_amount_no_tax = delSymbol(self.parents('tr').find('.sale_amount_no_tax').text());
                    var sale_amount_tax = delSymbol(self.parents('tr').find('.sale_amount_tax').text());
                    var picking_amount_no_tax = delSymbol(self.parents('tr').find('.picking_amount_no_tax').text());
                    var picking_amount_tax = delSymbol(self.parents('tr').find('.picking_amount_tax').text());

                    var profit_no_tax = parseFloat(sale_amount_no_tax - picking_amount_no_tax).toFixed(6); // 毛利未税：销售未税总价-采购未税总价 
                    var profit_tax = parseFloat(sale_amount_tax - picking_amount_tax).toFixed(6); // 毛利含税：销售含税总价—采购含税总价 
                    var profit_rate = parseFloat(profit_no_tax / picking_amount_no_tax * 100).toFixed(4)+'%'; // 毛利率：毛利润未税/采购未税总价

                    self.parents('tr').find('.profit_no_tax').text(profit_no_tax);
                    self.parents('tr').find('.profit_tax').text(profit_tax);
                    self.parents('tr').find('.profit_rate').text(profit_rate);
                }

                // 去掉数字千位符
                function delSymbol(num)
                {
                  var x = num.split(',');
                  return parseFloat(x.join(""));
                } 

                // 切换币种
                changeCurrency('.sale_currency', 'change', 'sale');
                changeCurrency('.picking_currency', 'change', 'picking');

                function changeCurrency(selector, event, key) 
                {
                    $('body').delegate(selector, event, function() {
                        var currency = $(this).val();
                        var num = $(this).parents('tr').find('.picking_num').val(); // 以采购数量为主

                        if (!num) { // 若为空，以对应元素数量为准
                            num = $(this).parents('tr').find('.'+key+'_num').val();
                        }

                        var price = $(this).parents('tr').find('.'+key+'_price').val();

                        if (currency == 2) {
                            $(this).parent('td').next('td').children('input').val(usd_rate);

                            if (num && price) {
                                commonCount($(this), num, price, usd_rate, key);     
                            }
                        } else if (currency == 3) {
                            $(this).parent('td').next('td').children('input').val(eur_rate);

                            if (num && price) {
                                commonCount($(this), num, price, eur_rate, key);     
                            }
                        } else {
                            $(this).parent('td').next('td').children('input').val(1);

                            if (num && price) {
                                commonCount($(this), num, price, 1, key);     
                            }
                        }
                    }) 
                } 

                // 新增/编辑报价 -- 完成
                $('.add-quote-success').click(function(){
                    var type = $(this).data('type');
                    var add_goods_name = add_brand_name = add_sale_num = add_sale_price = add_picking_num = add_picking_price = true; 

                    if (type == 1) {
                        var selector = '.addQuoteForm';
                        var title = '新增报价';
                        var content = '确定新增报价吗？';
                        var url = '/ajax/ajaxAddQuote'; // 新增
                    } else {
                        var qid = $(this).parents('.modal-content').find('input[name=qid]').val();
                        var selector = '.editQuoteForm_'+qid;
                        var title = '编辑报价';
                        var content = '确定编辑报价吗？';
                        var url = '/ajax/ajaxEditQuote'; // 编辑
                    }

                    $(selector).find('.sale_price').each(function(){
                        if ($(this).val() == '') {
                            layer.tips('请填写销售单价', $(this));
                            add_sale_price = false;
                            return false;
                        }
                    })

                    $(selector).find('.sale_num').each(function(){
                        if ($(this).val() == '') {
                            layer.tips('请填写销售数量', $(this));
                            add_sale_num = false;
                            return false;
                        }
                    })

                    // $(selector).find('.picking_price').each(function(){
                    //     if ($(this).val() == '') {
                    //         layer.tips('请填写采购单价', $(this));
                    //         add_picking_price = false;
                    //         return false;
                    //     }
                    // })

                    // $(selector).find('.picking_num').each(function(){
                    //     if ($(this).val() == '') {
                    //         layer.tips('请填写采购数量', $(this));
                    //         add_picking_num = false;
                    //         return false;
                    //     }
                    // })

                    $(selector).find('.brand_name').each(function(){
                        if ($(this).val() == '') {
                            layer.tips('请填写品牌', $(this));
                            add_brand_name = false;
                            return false;
                        }
                    })

                    $(selector).find('.goods_name').each(function(){
                        if ($(this).val() == '') {
                            layer.tips('请填写型号', $(this));
                            add_goods_name = false;
                            return false;
                        }
                    }) 

                    // if (!add_goods_name || !add_brand_name || !add_sale_num || !add_sale_price || !add_picking_num || !add_picking_price) {
                    if (!add_goods_name || !add_brand_name || !add_sale_num || !add_sale_price) {
                        return false;
                    } else {
                        var user_id = $('input[name=user_id]').val();
                        var data = $(selector).serialize() + '&user_id=' + user_id;

                        // 提交报价
                        layer.open({
                            title : title,
                            content : content,
                            btn : ['确认', '取消'],
                            btn1 : function () {
                                $.ajax({
                                    url : url,
                                    type: 'post',
                                    data: data,
                                    cache:false,
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
                            },
                        }) 
                    }   
                })

                // 币种名称
                function checkCurrency(val) 
                {
                    var str = '';

                    switch (val) {
                        case '1': str = '人民币'; break;
                        case '2': str = '美元'; break;
                        case '3': str = '欧元'; break;
                        default: str = '未知'; break;
                    }

                    return str;
                }

                // 删除报价明细
                $(document).delegate('.del-quote', 'click', function(){
                    var self = $(this);
                    var user_id = $('input[name=user_id]').val();
                    var qid = self.data('qid');

                    if (qid) {
                        layer.open({
                            title : '删除报价',
                            content : '确定删除该条报价吗？',
                            btn : ['确认', '取消'],
                            btn1 : function () {
                                $.ajax({
                                    url : '/ajax/ajaxDelQuote',
                                    type: 'post',
                                    data: {user_id : user_id, qid : qid},
                                    success : function (resp) {
                                        if (resp.err_code == 0) {
                                            layer.msg(resp.err_msg);
                                            self.parents('tr').remove();
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
                    } else {
                        $(this).parents('tr').remove();   
                    } 
                })

                // 搜索
                $('.quotelist-search').click(function() {
                    var user_id    = $('input[name=user_id]').val(),
                        begin_time = $('input[name="begin_time"]').val(),
                        end_time   = $('input[name="end_time"]').val(),
                        listUrl    = '/web/quote/'+user_id;

                    if(begin_time){
                        begin_time = Date.parse(begin_time) / 1000;
                    }

                    if(end_time){
                        end_time = Date.parse(end_time) / 1000 + (24*60*60-1);
                    }

                    location.href = listUrl + '?begin_time=' + begin_time + '&end_time=' + end_time;
                })

                // 导出
                $('.quotelist-export').click(function() {
                    var user_id = $('input[name=user_id]').val();
                    var begin_time = $('input[name=begin_time]').val();
                    var end_time = $('input[name=end_time]').val();

                    //if (!begin_time && !end_time) {
                    //    layer.msg('请选择报价时间');
                    //    return false;
                    //}
                    //alert(555)
                    if (begin_time) {
                        begin_time = Date.parse(begin_time) / 1000;
                    }

                    if (end_time) {
                        end_time = Date.parse(end_time) / 1000 + 86399; // xxxx/xx/xx 23:59:59
                    }

                    location.href = '/web/quotelist/'+user_id+'/export?begin_time='+begin_time+'&end_time='+end_time;
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