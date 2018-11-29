<div id="page-wrapper" class="gray-bg">
	@include('layouts.header')

	<div class="wrapper wrapper-content">
	    <div class="row">
	        <div class="col-lg-12">
	            <div class="ibox float-e-margins">
	             	<!-- 搜索栏 -->
	             	<div class="ibox-title" style="padding-bottom: 0px;border-top:0;">
						<ul class="nav nav-tabs" style="border-bottom: none;">
							<li><a href="/web/quote/{{$user_id}}">报价列表</a></li>
							<li><a href="/web/followup/{{$user_id}}">跟进记录</a></li>
							<li><a href="/web/orderlist/{{$user_id}}">历史订单</a></li>
					        <li><a href="/web/details/{{$user_id}}">客户资料</a></li>
					        <li><a href="/web/onlinebehavior/{{$user_id}}">在线行为</a></li>
					        <li class="active"><a href="javascript:;">购买行为</a></li>
					    </ul>
	             	</div>
					
	             	<div class="ibox-content">
				    	<table class="table table-hover">
							<tr>
								<td width="25%"><label>猎芯平台下单数：</label><span>{{ isset($lx) ? $lx['count'] : 0 }}</span></td>
								<td width="25%"><label>京东下单数：</label><span>{{ isset($jd) ? $jd['count'] : 0 }}</span></td>
								<td width="25%"><label>线下订单数：</label><span>{{ isset($erp) ? $erp['count'] : 0 }}</span></td>
								<td width="25%"><label>最近下单时间：</label><span>{{ !empty($last_time) ? date('Y-m-d H:i:s', $last_time) : '无' }}</span></td>
							</tr>

							<tr>
								<td><label>猎芯平台已付款订单数：</label><span>{{ isset($lx) ? $lx['paid_count'] : 0 }}</span></td>
								<td><label>京东已付款订单数：</label><span>{{ isset($jd) ? $jd['paid_count'] : 0 }}</span></td>
								<td width="25%"><label>线下已付款订单数：</label><span>{{ isset($erp) ? $erp['done_count'] : 0 }}</span></td>
								<td>
									<!-- <label>历史订单记录：</label>
									<a class="btn btn-info btn-xs" href="/web/buybehavior/{{$user_id}}/orderlist">查看</a> -->
								</td>
							</tr>

							<tr>
								<td><label>猎芯平台已付款订单总额：</label><span>{{ !empty($lx['paid_count']) ? '￥'.$lx['paid_amount']['rmb'].'， $'.$lx['paid_amount']['usd'] : 0 }}</span></td>
								<td><label>京东已付款订单总额：</label><span>{{ !empty($jd['paid_count']) ? $jd['paid_amount'] : 0 }}</span></td>
								<td><label>线下已付款订单总额：</label><span>{{ !empty($erp['done_count']) ? '￥'.$erp['order_amount']['rmb'].'， $'.$erp['order_amount']['usd'] : 0 }}</span></td>
								<td></td>
							</tr>

							<tr>
								<td>
									<label>猎芯平台已付款订单客单价：</label>
									<span>
										<?php 
											if (!empty($lx['paid_count'])) {
												$lx['paid_count'] = $lx['paid_count'] == 0 ? 1 : $lx['paid_count'];
												$lx_rmb = number_format($lx['paid_amount']['rmb'] / $lx['paid_count'], 2);
												$lx_usd = number_format($lx['paid_amount']['usd'] / $lx['paid_count'], 2);

												echo '￥'.$lx_rmb.'， $'.$lx_usd;
											} else {
												echo 0;
											}	
										?>
									</span>
								</td>
								<td>
									<label>京东已付款订单客单价：</label>
									<span>
										<?php 
											if (!empty($jd['paid_count'])) {
												$jd['paid_count'] = $jd['paid_count'] == 0 ? 1 : $jd['paid_count'];
												echo number_format($jd['paid_amount'] / $jd['paid_count'], 2);
											} else {
												echo 0;
											}	
										?>
									</span>
								</td>
								<td>
									<label>线下已付款订单客单价：</label>
									<span>
										<?php 
											if (!empty($erp['done_count'])) {
												$erp['done_count'] = $erp['done_count'] == 0 ? 1 : $erp['done_count'];
												$erp_rmb = number_format($erp['order_amount']['rmb'] / $erp['done_count'], 2);
												$erp_usd = number_format($erp['order_amount']['usd'] / $erp['done_count'], 2);

												echo '￥'.$erp_rmb.'， $'.$erp_usd;
											} else {
												echo 0;
											}	
										?>
									</span>
								</td>
								<td></td>
							</tr>
				    	</table>
	             	</div>
	            </div>
	        </div>
	    </div>
	</div>
</div>

<script>
	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
</script>
