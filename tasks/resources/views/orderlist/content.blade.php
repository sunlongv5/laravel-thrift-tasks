<div id="page-wrapper" class="gray-bg">
	@include('layouts.header')

	<div class="wrapper wrapper-content">
	    <div class="row">
	        <div class="col-lg-12">
	            <div class="ibox float-e-margins">
	             	<!-- 搜索栏 -->
	             	<div class="ibox-title" style="padding-bottom: 0px;border-top:0;">
						<ul class="nav nav-tabs">
							<li><a href="/web/quote/{{$user_id}}">报价列表</a></li>
					        <li><a href="/web/followup/{{$user_id}}">跟进记录</a></li>
					        <li class="active"><a href="javascript:;">历史订单</a></li>
					        <li><a href="/web/details/{{$user_id}}">客户资料</a></li>
					        <li><a href="/web/onlinebehavior/{{$user_id}}">在线行为</a></li>
					        <li><a href="/web/buybehavior/{{$user_id}}">购买行为</a></li>
					    </ul>
	             	</div>

	             	<!-- 搜索栏 -->
		         	<div class="ibox-title" style="border-top:0;">
		         		<form class="form-inline" style="margin: 15px 0;">
		         			<div class="row">
								<div class="col-md-12" style="margin-left: 10px;">
									<div class="form-group show-space">
									    <label>订单编号</label>
										<input type="text" name="order_sn" class="form-control order_sn" value="{{$condition['order_sn']}}" placeholder="请输入订单编号">
									</div>

									<div class="form-group show-space">
									    <label>订单类型</label>
										<select name="order_type" class="form-control order_type">
											<option value="">全部</option>
											@if ($is_user_type == 1)
											<option value="1">猎芯平台</option>
											@else if ($is_user_type == 3)
											<option value="2">线下</option>
											@endif
										</select>
									</div>

									<div class="form-group show-space">
										<label>订单状态</label>
										<select name="order_status" class="form-control order_status">
											<option value="">全部</option>
											@if ($is_user_type == 1 || $is_user_type == 3)
												<option value="-1">已取消</option>
												<option value="1">待审核</option>
												<option value="2">待付款</option>
												<option value="3">待付尾款</option>
												<option value="4">待发货</option>
												<option value="7">部分发货</option>
												<option value="8">已发货</option>
												<option value="10">交易完成</option>
											@else 
												<option value="1">已取消</option>
												<option value="2">已付款</option>
												<option value="3">已发货</option>
												<option value="4">交易完成</option>
											@endif
										</select>
									</div>

									<div class="form-group show-space">
										<label>订单来源</label>
										<select name="platform" class="form-control platform">
											<option value="">全部</option>
											<option value="1">PC端</option>
											<option value="2">移动端</option>
										</select>
									</div>

									<div class="form-group show-space">
										<label>下单时间</label>

										<input type="text" name="begin_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['begin_time']) ? date('Y/m/d', $condition['begin_time']) : ''}}" autocomplete="off" />									
										<input type="text" name="end_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['end_time']) ? date('Y/m/d', $condition['end_time']) : ''}}" autocomplete="off" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-10">
									<button class="btn btn-info online-search" style="margin-left: 10px;">搜索</button>		
								</div>
							</div>
				    	</form>
		         	</div>
					
	             	<div class="ibox-content" style="margin-top: 10px;">
	             		<table class="table table-hover">
				            <thead>
				                <tr> 
				                	<th width="13%">订单编号</th>                
				                    <th width="10%">订单类型</th> 
				                    <th width="13%">订单状态</th>                                          
				                    <th width="13%">订单来源</th>  
				                    <th width="13%">订单金额</th> 			 
				                    <th width="14%">下单时间</th> 
				                    <th width="8%">操作</th>
				                </tr>
				            </thead>
				            <tbody>
				                @if (!empty($list) && $list->count())
				                    @foreach ($list as $key => $vo)
				                    <tr>
				                    	<td class="show-list">{{isset($vo->order_sn) ? $vo->order_sn : $vo->order_id}}</td>

				                        <td class="show-list">
											<?php 
												if (isset($vo->order_type)) {
													switch ($vo->order_type) {
														case 1 : echo '猎芯平台'; break;
														case 2 : echo '线下'; break;
													}
												} else {
													echo '京东';
												}
											?>
				                        </td> 
				                        
				                        <td class="show-list">
											<?php 
												if (isset($vo->status)) {
													switch ($vo->status) {
														case -1: echo '已取消'; break;
														case 1: echo '待审核'; break;
														case 2: echo '待付款'; break;
														case 3: echo '待付尾款'; break;
														case 4: echo '待发货'; break;
														case 7: echo '部分发货'; break;
														case 8: echo '已发货'; break;
														case 10: echo '交易完成'; break;
													}
												} else {
													switch ($vo->order_state) {
														case 'TRADE_CANCELED': echo '已取消'; break;
														case 'WAIT_SELLER_STOCK_OUT': echo '已付款'; break;
														case 'WAIT_GOODS_RECEIVE_CONFIRM': echo '已发货'; break;
														case 'FINISHED_L': echo '交易完成'; break;
													}
												}
											?>
				                        </td>

				                        <td class="show-list">
											<?php 
												if ($is_user_type == 1) {
													if (!empty($vo->order_source)) {
														if (preg_match('/pf=1/', $vo->order_source)) {
															echo 'PC端';
														} else if (preg_match('/pf=2/', $vo->order_source)) {
															echo '移动端';
														} 
													}
												} else {
													echo $vo->order_source;
												}
											?>
				                        </td>
				                        
				                        <td class="show-list">
				                            <?php 
				                                if (isset($vo->currency)) {
				                                	$currency = $vo->currency == 1 ? '￥' : '$';
				                                } else {
				                                	$currency = '￥';
				                                }

				                                echo isset($vo->order_amount) ? $currency.$vo->order_amount : $currency.$vo->order_payment;
				                            ?>
				                        </td>

				                        <td class="show-list">{{isset($vo->create_time) ? date('Y-m-d H:i:s', $vo->create_time) : date('Y-m-d H:i:s', $vo->order_start_time)}}</td>

				                        <td>
				                        	@if ($is_user_type == 1 || $is_user_type == 3)
												<a class="btn btn-info btn-xs orderDetail" data-id="{{$vo->order_id}}" data-type="{{$vo->order_goods_type}}">查看详情</a>
												
												<a class="btn btn-success btn-xs orderRemark" data-id="{{$vo->order_id}}" data-remark="{{$vo->order_remark}}">备注</a>
											@else 
												<a class="btn btn-info btn-xs orderDetail" data-id="{{$vo->address_id}}">查看详情</a>
											@endif
				                        </td>
				                    </tr>
									
									<!-- 展示隐藏信息 -->
				                    <tr class="show-other-content">
			                            <td colspan="7">
			                                <table class="table table-hover table-bordered">
			                                    <tr>
			                                        <td class="table-list-title" style="width:3%;">备注信息</td>
			                                        <td class="table-list-content">{{$vo->order_remark}}</td>
			                                    </tr>
			                                </table>
			                            </td>
			                        </tr>
				                    @endforeach
				                @else
				                    <tr class="text-center">
				                        <td colspan="12">没有查询到相关记录~</td>
				                    </tr>
				                @endif
				            </tbody>
				        </table>
	             	</div>

	             	<div style="float: left; padding: 20px 0 20px 5px;">共{{ !empty($list) ? $list->total() : 0 }}条记录</div>
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

<script>
	var order_type_condition = "{{$condition['order_type']}}"; 
	$('.order_type').val(order_type_condition);

	var order_status_condition = "{{$condition['order_status']}}"; 
	$('.order_status').val(order_status_condition);

	var platform_condition = "{{$condition['platform']}}"; 
	$('.platform').val(platform_condition);

	var is_user_type = "{{$is_user_type}}";
	var order_details_url = "{{Config('website.order_details_url')}}";
	var member_details_url = "{{Config('website.member_details_url')}}";

	$.lie.orderlist.index();

	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
</script>
