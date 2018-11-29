<div id="page-wrapper" class="gray-bg">
	@include('layouts.header')

	<div class="wrapper wrapper-content">
	    <div class="row">
	        <div class="col-lg-12">
	            <div class="ibox float-e-margins">
	             	<!-- 搜索栏 -->
	             	<div class="ibox-title" style="padding-bottom: 0px;border-top:0;">
						<ul class="nav nav-tabs" style="border-bottom: none;">
							<li><a href="/web/quote/{{$userInfo->user_id}}">报价列表</a></li>
					        <li><a href="/web/followup/{{$userInfo->user_id}}">跟进记录</a></li>
					        <li><a href="/web/orderlist/{{$userInfo->user_id}}">历史订单</a></li>
					        <li class="active"><a href="javascript:;">客户资料</a></li>
					        <li><a href="/web/onlinebehavior/{{$userInfo->user_id}}">在线行为</a></li>
					        <li><a href="/web/buybehavior/{{$userInfo->user_id}}">购买行为</a></li>
					    </ul>
	             	</div>
					
	             	<div class="ibox-content" style="border-style:none; padding: 0;">
	             		<input type="hidden" name="user_id" value="{{$userInfo->user_id}}">
	             		<!-- 基本资料 -->
						<div class="box-section">
							<div class="section-title">
								<div class="form-group">
									<h3 class="section-h3">基本资料</h3>
									<a href="javascript:;" class="btn btn-info rbtn base-edit">编辑</a>
								</div>
							</div>
							
							<div class="section-content base-edit-content">
								<div class="row">
									<div class="col-xs-2" style="width: 17%;">
										<div class="form-group">	
											<label>来源：</label>
										    <span>{{$userInfo->source ? Config('config.customer_source')[$userInfo->source] : ''}}</span>
										</div>	    
									</div>
									
									<div class="col-xs-2" style="width: 25%;">	
										<div class="form-group">
										    <label style="float: left;">Adtag：</label>
										    <span class="show-title" style="float: left; width: 170px;" title="{{$userInfo->adtag}}">{{$userInfo->adtag}}</span>
										</div>
									</div>
									
									<div class="col-xs-2" style="width: 18%;">
										<div class="form-group">
										    <label>客户级别：</label>
										    <span>{{$userInfo->grade ? Config('config.customer_grade')[$userInfo->grade] : ''}}</span>
										</div>
									</div>
									
									<div class="col-xs-2" style="width: 18%;">
										<div class="form-group">
										    <label>当前状态：</label>
										    <span>{{$userInfo->status ? Config('config.customer_status')[$userInfo->status] : ''}}</span>
										</div>
									</div>

									<div class="col-xs-2" style="width: 22%;">
										<div class="form-group">
										    <label>注册时间：</label>
										    <span>{{date('Y-m-d H:i:s', $userInfo->copy_ctime)}}</span>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-3" style="width: 17%;">
										<div class="form-group">
										    <label>手机账号：</label>
										    <span>{{$userInfo->mobile}}</span>
										</div>
									</div>
									
									<div class="col-xs-3" style="width: 25%;">
										<div class="form-group">
										    <label>邮箱账号：</label>
										    <span>{{$userInfo->email}}</span>
										</div>
									</div>

									<div class="col-xs-3" style="width: 18%;">
										<div class="form-group">
										    <label>微信：</label>
										    <span>{{$userInfo->wechat}}</span>
										</div>
									</div>
									
									<div class="col-xs-3" style="width: 18%;">
										<div class="form-group">
										    <label>QQ：</label>
										    <span>{{$userInfo->qq}}</span>
										</div>
									</div>
									
									<div class="col-xs-2" style="width: 22%;">
										<div class="form-group">
										    <label>建档时间：</label>
										    <span>{{date('Y-m-d H:i:s', $userInfo->create_time)}}</span>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-3" style="width: 17%;">
										<div class="form-group">
										    <label>渠道来源：</label>
										    <span>
												<?php 
													switch ($userInfo->channel_source) {
														case 1: echo '搜索引擎'; break;
														case 2: echo '社群'; break;
														case 3: echo '公众号'; break;
														case 4: echo '线下广告'; break;
														case 5: echo '朋友介绍'; break;
														case 6: echo $userInfo->channel_source_other; break;
														default: echo '未知'; break;
													}
												?>
										    </span>
										</div>
									</div>

									<div class="col-xs-3" style="width: 25%;">
										<div class="form-group">
										    <label>需求类型：</label>
										    <span>
												<?php 
													switch ($userInfo->need_type) {
														case 1: echo '采购'; break;
														case 2: echo '销售'; break;
														case 3: echo '报关'; break;
														case 4: echo $userInfo->need_type_other; break;
														default: echo '未知'; break;
													}
												?>
										    </span>
										</div>
									</div>

									<div class="col-xs-3" style="width: 18%;">
										<div class="form-group">
										    <label>是否加微信好友：</label>
										    <span>{{$userInfo->is_add_wechat == 1 ? '是' : '否'}}</span>
										</div>
									</div>
									
									<div class="col-xs-3" style="width: 18%;">
										<div class="form-group">
										    <label>是否加入社群：</label>
										    <span>{{$userInfo->is_join_group == 1 ? '是' : '否'}}</span>
										</div>
									</div>
	
									@if ($userInfo->source == 3) 
									<div class="col-xs-3" style="width: 22%;">
										<div class="form-group">
										    <label>京东账号：</label>
										    <span>{{$userInfo->jd_account}}</span>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
						@include('modal.userModal')			
			
						<!-- 公司资料 -->
						<div class="box-section">
							<div class="section-title">
								<div class="form-group">
									<h3 class="section-h3">公司资料</h3>
									@if (!empty($companyInfo)) 
										<a href="javascript:;" class="btn btn-info rbtn company-edit">编辑</a>
									@else
										<a href="javascript:;" class="btn btn-success rbtn company-add">新增</a>
									@endif
								</div>
							</div>
							
							@if (!empty($companyInfo)) 
							<div class="section-content company-edit-content">
								<div class="row">
									<div class="col-xs-4">
										<div class="form-group">	
											<label>公司名称：</label>
										    <span>{{$companyInfo->com_name}}</span>
										</div>	    
									</div>
									
									<div class="col-xs-4">	
										<div class="form-group">
										    <label>公司类型：</label>
										    <span>{{$companyInfo->com_type ? Config('config.company_type') [$companyInfo->com_type] : ''}}</span>
										</div>
									</div>

									<div class="col-xs-4">	
										<div class="form-group">
										    <label>公司地址：</label>
										    <span>{{$companyInfo->address}}</span>
										</div>
									</div>
								</div>
							
								<div class="row">								
									<div class="col-xs-4">
										<div class="form-group">
										    <label style="float: left;">联系信息：</label>
										    <div style="float: left;">
												<p>
													<label>邮箱：</label>
										    		<span>{{$companyInfo->email}}</span>
												</p>
												<p>
													<label>座机：</label>
										    		<span>{{$companyInfo->fixed_tel}}</span>
												</p>
												<p>
													<label>网站：</label>
										    		<span>{{$companyInfo->website}}</span>
												</p>
												<p>
													<label>传真：</label>
										    		<span>{{$companyInfo->fax}}</span>
												</p>
										    </div>
										</div>
									</div>

									<div class="col-xs-8">
										<div class="form-group">
										    <label style="float: left; width: 9%;">公司简介：</label>
										    <div style="float: left; width: 91%;">
												<p class="com_info">
													<label>主营品牌：</label>
										    		<span>{{$companyInfo->main_brand}}</span>
												</p>
												<p class="com_info">
													<label>公司规模：</label>
										    		<span>{{$companyInfo->com_scale}}</span>
												</p>
												<p class="com_info">
													<label>公司简介：</label>
										    		<span>{{$companyInfo->com_desc}}</span>
										    </div>
										</div>
									</div>
								</div>
							</div>
								@include('modal.companyModal')	
							@else
								@include('modal.addCompanyModal')	
							@endif
						</div>
						

						<!-- 联系人 -->
						<div class="box-section">
							<div class="section-title">
								<div class="form-group">
									<h3 class="section-h3">联系人</h3>
									<a href="javascript:;" class="btn btn-success rbtn linkman-add">新增</a>
								</div>
							</div>
							
							@if (!empty($linkmanInfo))
								@foreach ($linkmanInfo as $linkman)
									<div class="section-content linkman-edit-content">
										<div class="row">
											<div class="col-xs-2" style="width: 13%;">
												<div class="form-group">	
													<label>姓名：</label>
												    <span>{{$linkman->name}}</span>
												</div>	    
											</div>
											
											<div class="col-xs-2" style="width: 13%;">
												<div class="form-group">	
													<label>部门：</label>
												    <span>{{$linkman->department}}</span>
												</div>	    
											</div>

											<div class="col-xs-2" style="width: 13%;">
												<div class="form-group">	
													<label>职务：</label>
												    <span>{{$linkman->duty}}</span>
												</div>	    
											</div>

											<div class="col-xs-2" style="width: 14%;">
												<div class="form-group">	
													<label>手机：</label>
												    <span>{{$linkman->mobile}}</span>
												</div>	    
											</div>

											<div class="col-xs-2" style="width: 14%;">
												<div class="form-group">	
													<label>座机：</label>
												    <span>{{$linkman->fixed_tel}}</span>
												</div>	    
											</div>

											<div class="col-xs-2" style="width: 8%;">
												<div class="form-group">	
													<label>性别：</label>
												    <span>
														<?php 
															switch ($linkman->sex) {
																case 1: echo '男'; break;
																case 2: echo '女'; break;
																default: echo '未知'; break;
															}
														?>
												    </span>
												</div>	    
											</div>

											<div class="col-xs-2" style="width: 13%;">
												<div class="form-group">	
													<label>生日：</label>
												    <span>{{$linkman->birthday ? date('Y-m-d', $linkman->birthday) : ''}}</span>
												</div>	    
											</div>
											
											<div class="col-xs-2" style="width: 12%;">
												<a href="javascript:;" class="btn btn-info btn-xs rbtn linkman-edit" data-lid="{{$linkman->link_id}}">编辑</a>
												<a href="javascript:;" class="btn btn-danger btn-xs rbtn linkman-del" data-lid="{{$linkman->link_id}}">删除</a>
											</div>
										</div>
									</div>
									@include('modal.editLinkmanModal')
								@endforeach
							@endif
						</div>
						@include('modal.addLinkmanModal')

						<!-- 公司发票 -->
						<div class="box-section">
							<div class="section-title">
								<div class="form-group">
									<h3 class="section-h3">发票信息</h3>
									<a href="javascript:;" class="btn btn-success rbtn invoice-add">新增</a>
								</div>
							</div>
							
							@if (!empty($invoiceInfo))
								@foreach ($invoiceInfo as $invoice)
									<div class="section-content invoice-edit-content">
										<div class="row">
											<div class="col-xs-2 inv-info" style="width: 26%;">
												<div class="form-group">	
													<label style="float: left;">公司全称：</label>
												    <span class="show-title" style="float: left; width: 210px;" title="{{$invoice->com_name}}">{{$invoice->com_name}}</span>
												</div>	    
											</div>
											
											<div class="col-xs-2 inv-info" style="width: 22%;">
												<div class="form-group">	
													<label>税务登记号：</label>
												    <span>{{$invoice->tax_no}}</span>
												</div>	    
											</div>

											<div class="col-xs-2 inv-info" style="width: 14%;">
												<div class="form-group">	
													<label>电话：</label>
												    <span>{{$invoice->telephone}}</span>
												</div>	    
											</div>

											<div class="col-xs-2 inv-info" style="width: 26%;">
												<div class="form-group">	
													<label style="float: left;">注册地址：</label>
												    <span class="show-title" style="float: left; width: 210px;" title="{{$invoice->com_addr}}">{{$invoice->com_addr}}</span>
												</div>	    
											</div>
											
											<div class="col-xs-2" style="width: 12%;">
												<a href="javascript:;" class="btn btn-info btn-xs rbtn invoice-edit" data-vid="{{$invoice->inv_id}}">编辑</a>
												<a href="javascript:;" class="btn btn-danger btn-xs rbtn invoice-del" data-vid="{{$invoice->inv_id}}">删除</a>
											</div>
										</div>

										{{--<div class="row show-bank-info">--}}
										<div class="row">
											<div class="col-xs-2" style="width: 26%;">
												<div class="form-group">	
													<label style="float: left;">开户行名称：</label>
												    <span class="show-title" style="float: left; width: 200px;" title="{{$invoice->bank_name}}">{{$invoice->bank_name}}</span>
												</div>	    
											</div>

											<div class="col-xs-2" style="width: 23%;">
												<div class="form-group">	
													<label>银行账号：</label>
												    <span>{{$invoice->bank_account}}</span>
												</div>	    
											</div>

											<div class="col-xs-2" style="width: 51%;">
												<div class="form-group">	
													<label style="float: left;">开户行地址：</label>
												    <span class="show-title" style="float: left;" title="{{$invoice->bank_addr}}">{{$invoice->bank_addr}}</span>
												</div>	    
											</div>
										</div>
										{{--</div>--}}
									</div>
									@include('modal.editInvoiceModal')
								@endforeach
							@endif
						</div>
						@include('modal.addInvoiceModal')
	             	</div>
	            </div>
	        </div>
	    </div>
	</div>
</div>

<script>
	$.lie.details.index();

	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
</script>
