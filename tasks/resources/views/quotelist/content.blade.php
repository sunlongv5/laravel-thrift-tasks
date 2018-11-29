<div id="page-wrapper" class="gray-bg">
	@include('layouts.header')
	<style>
		.col-lg-10{
			MARGIN-TOP: 15PX;
			padding-left: 8px;
		}
	</style>
	<div class="wrapper wrapper-content">
		<div class="row">
		    <div class="col-lg-12">
		        <div class="ibox float-e-margins">
		        	<div class="ibox-title" style="padding-bottom: 0px;border-top:0;">
			        	<ul class="nav nav-tabs">
			        		<li class="active"><a href="javascript:;">报价列表</a></li>
					        <li><a href="/web/followup/{{$user_id}}">跟进记录</a></li>
					        <li><a href="/web/orderlist/{{$user_id}}">历史订单</a></li>
					        <li><a href="/web/details/{{$user_id}}">客户资料</a></li>
					        <li><a href="/web/onlinebehavior/{{$user_id}}">在线行为</a></li>
					        <li><a href="/web/buybehavior/{{$user_id}}">购买行为</a></li>
					    </ul>
					</div>

		         	<!-- 搜索栏 -->
		         	<div class="ibox-title" style="border-top:0;">
		         		<form class="form-inline" style="margin-top: 15px;">
		         			<input type="hidden" name="user_id" value="{{$user_id}}">
		         			<div class="row">
								<div class="col-md-12" style="margin-left: 10px;">
									<div class="form-group show-space">
										<label>报价时间</label>

										<input type="text" name="begin_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['begin_time']) ? date('Y/m/d', $condition['begin_time']) : ''}}" autocomplete="off" />									
										<input type="text" name="end_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['end_time']) ? date('Y/m/d', $condition['end_time']) : ''}}" autocomplete="off" />
									</div>

									<div class="form-group" style="margin-bottom: 10px;">
										<a class="btn btn-info quotelist-search" href="javascript:;">搜索</a>
										<a class="btn btn-primary add-quote" href="javascript:;">新增</a>
										<a class="btn btn-success quotelist-export" href="javascript:;">导出</a>
										<button type="button" class="btn btn-success search-list" id="test1">
											导入报价
										</button>
										<a class="btn btn-primary add-customer" href="/excel/import-report-price.xls" target="_blank">下载导入模板</a>
									</div>
								</div>
							</div>
				    	</form>
		         	</div>
					
		         	<div class="ibox-content" style="margin-top: 10px;">
						<table class="table table-hover">
							<tr>
								<th><label class="control-label">报价时间</label></th>

								<th><label class="control-label">型号</label></th>
                                <th><label class="control-label">品牌</label></th>

                                <th><label class="control-label">销售数量</label></th>               
                                <th><label class="control-label">销售单价</label></th>
                                <th><label class="control-label">销售币种</label></th>
                                <th><label class="control-label">销售汇率</label></th>
                                <th><label class="control-label">销售总价</label></th>
                                <th><label class="control-label">销售未税单价</label></th>
                                <th><label class="control-label">销售含税单价</label></th>
                                <th><label class="control-label">销售未税总价</label></th>
                                <th><label class="control-label">销售含税总价</label></th>

                                <th><label class="control-label">操作</label></th>
							</tr>

							@if (!empty($list) && $list->count())
			                    @foreach($list as $k => $v)
									<?php 
										$fixed_fee = 1 + Config('config.quote-fixed-fee');
//										dump($fixed_fee);
										switch ($v->picking_currency) {
											case '1': $picking_currency_name = '人民币'; break;
											case '2': $picking_currency_name = '美元'; break;
											case '3': $picking_currency_name = '欧元'; break;
										}
										// 总价：数量*单价
										$picking_amount = $v->picking_num && $v->picking_price ? number_format($v->picking_num * $v->picking_price, 6) : ''; 
										// 未税单价：单价*汇率
										$picking_price_no_tax = $v->picking_num && $v->picking_price ? number_format($v->picking_price * $v->picking_rate, 6) : '';
										// 含税单价：未税单价*固定税率
										$picking_price_tax = $v->picking_num && $v->picking_price ? number_format($picking_price_no_tax * $fixed_fee, 6) : '';
//										dump($picking_price_no_tax);
//										dump($fixed_fee);
										// 总价未税：数量*未税单价
										$picking_amount_no_tax = $v->picking_num && $v->picking_price ? number_format($v->picking_num * $picking_price_no_tax, 6) : '';
										// 总价含税：数量*含税单价
										$picking_amount_tax = $v->picking_num && $v->picking_price ? number_format($v->picking_num * $picking_price_tax, 6) : '';
//										dump($v->picking_num);
//										dump($picking_price_tax);
										switch ($v->sale_currency) {
											case '1': $sale_currency_name = '人民币'; break;
											case '2': $sale_currency_name = '美元'; break;
											case '3': $sale_currency_name = '欧元'; break;
										}

										$num = $v->picking_num ? $v->picking_num : $v->sale_num; // 数量

										// 总价：数量*单价
										$sale_amount = number_format($num * $v->sale_price, 6); 
										// 未税单价：单价*汇率
										$sale_price_no_tax = number_format($v->sale_price * $v->sale_rate, 6); 
										// 含税单价：未税单价*固定税率
										$sale_price_tax = number_format($sale_price_no_tax * $fixed_fee, 6); 
										// 总价未税：数量*未税单价
										$sale_amount_no_tax = number_format($num * $sale_price_no_tax, 6);
										// 总价含税：数量*含税单价
										$sale_amount_tax = number_format($num * $sale_price_tax, 6);

										// 毛利未税：销售未税总价-采购未税总价 
                                        $profit_no_tax = $v->picking_num != 0 ? number_format($sale_amount_no_tax - $picking_amount_no_tax, 6) : '';
                                        // 毛利含税：销售含税总价—采购含税总价
//										dump($sale_amount_tax);
//										dump($picking_amount_tax);
                                        $profit_tax = $v->picking_num != 0 ? number_format($sale_amount_tax - $picking_amount_tax, 6) : '';
                                        // 毛利率：毛利润未税/采购未税总价
										if($picking_amount_no_tax>0){
											$profit_rate = $v->picking_num != 0 ? number_format($profit_no_tax / $picking_amount_no_tax * 100, 4).'%' : '';
										}else{
											$profit_rate = '';
										}

									?>

									<tr class="quote-row quote_key_{{$k}}">
										<td class="show-list"><span class="create_time">{{date('Y-m-d H:i:s', $v->create_time)}}</span></td>

                                        <td class="show-list">{{$v->goods_name}}</td>
                                        <td class="show-list">{{$v->brand_name}}</td>

                                        <td class="show-list">{{$v->sale_num}}</td>
                                        <td class="show-list">{{$v->sale_price}}</td>
                                        <td class="show-list">{{$sale_currency_name}}</td>
                                        <td class="show-list">{{$v->sale_rate}}</td>
                                        <td class="show-list"><span class="sale_amount_val">{{$sale_amount}}</span></td>
                                        <td class="show-list"><span class="sale_price_no_tax_val">{{$sale_price_no_tax}}</span></td>
                                        <td class="show-list"><span class="sale_price_tax_val">{{$sale_price_tax}}</span></td>
                                        <td class="show-list"><span class="sale_amount_no_tax_val">{{$sale_amount_no_tax}}</span></td>
                                        <td class="show-list"><span class="sale_amount_tax_val">{{$sale_amount_tax}}</span></td> 

                                        <td>
											<a class="btn btn-xs btn-info edit-quote" href="javascript:;" data-qid="{{$v->quote_id}}">编辑</a>
											<a class="btn btn-xs btn-danger del-quote" href="javascript:;" data-qid="{{$v->quote_id}}">删除</a>
                                        </td>                                      
                                    </tr>
									
									<!-- 点击展示内容 -->
                                    <tr class="show-other-content">
			                            <td colspan="13">
			                                <table class="table table-hover table-bordered">
			                                    <tr>
			                                        <td class="table-list-title">采购数量</td>
			                                        <td class="table-list-content">{{$v->picking_num ? $v->picking_num : ''}}</td>  
			                                        <td class="table-list-title">采购单价</td>
			                                        <td class="table-list-content">{{$v->picking_price != 0.0000 ? $v->picking_price : ''}}</td>
			                                    </tr>  
			                                    <tr>
			                                        <td class="table-list-title">采购币种</td>
			                                        <td class="table-list-content">{{$picking_currency_name}}</td>  
			                                        <td class="table-list-title">采购汇率</td>
			                                        <td class="table-list-content">{{$v->picking_rate}}</td>
			                                    </tr>
			                                    <tr>
			                                        <td class="table-list-title">采购总价</td>
			                                        <td class="table-list-content">{{$picking_amount}}</td>
			                                        <td class="table-list-title">采购未税单价</td>
			                                        <td class="table-list-content">{{$picking_price_no_tax}}</td>
			                                    </tr>
			                                    <tr>
			                                        <td class="table-list-title">采购含税单价</td>
			                                        <td class="table-list-content">{{$picking_price_tax}}</td>  
			                                        <td class="table-list-title">采购未税总价</td>
			                                        <td class="table-list-content">{{$picking_amount_no_tax}}</td>
			                                    </tr>
			                                    <tr>
			                                        <td class="table-list-title">采购含税总价</td>
			                                        <td class="table-list-content">{{$picking_amount_tax}}</td>  
			                                        <td class="table-list-title">毛利润未税</td>
			                                        <td class="table-list-content">{{$profit_no_tax}}</td>
			                                    </tr>
			                                    <tr>
			                                        <td class="table-list-title">毛利润含税</td>
			                                        <td class="table-list-content">{{$profit_tax}}</td>  
			                                        <td class="table-list-title">毛利率</td>
			                                        <td class="table-list-content">{{$profit_rate}}</td>
			                                    </tr>
			                                </table>
			                            </td>
			                        </tr>
			                        <tr style="display: none;">
										<td>@include('modal.editQuoteModal')</td>
			                        </tr>
                                @endforeach
			                @else
			                    <tr class="text-center">
			                        <td colspan="13">没有查询到相关记录</td>
			                    </tr>
			                @endif
						</table>
		         	</div>

		         	<div style="float: left; padding: 20px 0 20px 5px;"><?php echo '共'.$list->total().'条记录'; ?></div>
				    <div style="float:right;">
				        <?php 
				            if (!$_REQUEST) {
				                echo !empty($list) && $list->count() ? $list->links() : '';
				            } else {
				                echo !empty($list) && $list->count() ? $list->appends($condition)->links() : '';
				            }
				        ?>
				    </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
@include('modal.addQuoteModal')

<script>
	var quote_fixed_fee = "{{Config('config.quote-fixed-fee')}}"; // 固定税率
	var usd_rate = "{{Config('config.usd-rate')}}"; // 美元汇率
	var eur_rate = "{{Config('config.eur-rate')}}"; // 欧元汇率

	$.lie.quote.index();

	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
</script>
@include('quotelist.js_footer')