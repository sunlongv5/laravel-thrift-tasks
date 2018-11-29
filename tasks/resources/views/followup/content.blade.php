<div id="page-wrapper" class="gray-bg">
	@include('layouts.header')

	<div class="wrapper wrapper-content">
		<div class="row">
		    <div class="col-lg-12">
		        <div class="ibox float-e-margins">
		        	<div class="ibox-title" style="padding-bottom: 0px;border-top:0;">
			        	<ul class="nav nav-tabs">   
			        		<li><a href="/web/quote/{{$user_id}}">报价列表</a></li>  
					        <li class="active"><a href="javascript:;">跟进记录</a></li> 
					        <li><a href="/web/orderlist/{{$user_id}}">历史订单</a></li>  
			        		<li><a href="/web/details/{{$user_id}}">客户资料</a></li>
					        <li><a href="/web/onlinebehavior/{{$user_id}}">在线行为</a></li>
					        <li><a href="/web/buybehavior/{{$user_id}}">购买行为</a></li>
					    </ul>
					</div>

		         	<!-- 搜索栏 -->
		         	<div class="ibox-title" style="border-top:0;">
		         		<form class="form-inline" style="margin: 15px 0;">
		         			<input type="hidden" name="user_id" value="{{$user_id}}">
		         			<div class="row">
								<div class="col-md-12" style="margin-left: 10px;">
									<div class="form-group show-space">
										<label>是否接通</label>
										<select class="form-control" name="is_contact" id="is_contact" style="width:135px">
											<option value="">全部</option>
											<option value="1">是</option>
											<option value="0">否</option> 	
										</select>
									</div>

									<div class="form-group show-space">
										<label>当前级别</label>
										<select class="form-control" name="grade" id="grade">
											<option value="">全部</option>
											@foreach (Config('config.followup_grade') as $k=>$v)
												@if ($condition['grade'] == $k)
											   		<option value="{{$k}}" selected>{{$v}}</option>
											   	@else
													<option value="{{$k}}">{{$v}}</option>
											   	@endif
											@endforeach
										</select>
									</div>

									<div class="form-group show-space">
										<label>来源</label>
										<select class="form-control" name="source" id="source">
											<option value="">全部</option>
										   	@foreach (Config('config.followup_source') as $k=>$v)
											   	@if ($condition['source'] == $k)
											   		<option value="{{$k}}" selected>{{$v}}</option>
											   	@else
													<option value="{{$k}}">{{$v}}</option>
											   	@endif
											@endforeach
										</select>
									</div>	

									<div class="form-group show-space">
										<label class="control-label">跟进时间</label>

										<input type="text" name="begin_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['begin_time']) ? date('Y/m/d', $condition['begin_time']) : ''}}" autocomplete="off" />									
										<input type="text" name="end_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['end_time']) ? date('Y/m/d', $condition['end_time']) : ''}}" autocomplete="off" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-10">
									<button class="btn btn-info remarks-search" style="margin-left: 10px;">搜索</button>
									<a class="btn btn-success add-remark" href="/web/addfollowup/{{$user_id}}" target="_blank">新增</a>
								</div>
							</div>
				    	</form>
		         	</div>
					
		         	<div class="ibox-content" style="margin-top: 10px;">
						<table class="table table-hover">
							<tr>
								<th>本次跟进详情</th>
								<th>是否接通</th>
								<th>当前级别</th>
								<th>来源</th>
								<th>是否提醒</th>
								<th>本次跟进时间</th>
								<th>操作</th>
							</tr>

							@if (!empty($list) && $list->count())
			                    @foreach ($list as $key => $vo)
			                    <tr>
			                        <td class="show-list">
										<p class="show-title" title="{{$vo->current_details}}">{{$vo->current_details}}</p>
			                        </td>
									<td class="show-list">{{$vo->is_contact == 1 ? '是' : '否'}}</td>
									<td class="show-list">{{$vo->grade ?  Config('config.followup_grade')[$vo->grade] : ''}}</td>
									<td class="show-list">{{$vo->source ?  Config('config.followup_source')[$vo->source] : ''}}</td>

			                        <td class="show-list">{{$vo->is_remind == 1 ? '是' : '否'}}</td>
									<td class="show-list">{{date('Y-m-d H:i:s', $vo->create_time)}}</td>
			                        <td>
										<a class="btn btn-info btn-xs" href="/web/editfollowup/{{$user_id}}/{{$vo->fol_id}}" target="_blank">编辑</a>
										<a class="btn btn-danger btn-xs del-followup" data-fid="{{$vo->fol_id}}">删除</a>
			                        </td>
			                    </tr>

			                    <!-- 点击展示内容 -->
		                        <tr class="show-other-content">
		                            <td colspan="9">
		                                <table class="table table-hover table-bordered">
		                                    <tr>
		                                        <td class="table-list-title">下次跟进事项</td>
		                                        <td class="table-list-content">
													<p class="show-title" title="{{$vo->next_details}}">{{$vo->next_details}}</p>
		                                        </td>
		                                        <td class="table-list-title">下次跟进时间</td>
		                                        <td class="table-list-content">{{$vo->next_time ? date('Y-m-d H:i:s', $vo->next_time) : ''}}</td>  
		                                    </tr>
		                                    <tr>
		                                        <td class="table-list-title">提醒方式</td>
		                                        <td class="table-list-content">
													<?php 
														if (!empty($vo->remind_type)) {
															$remind_type = explode(',', $vo->remind_type);
															$remind_type_str = '';

															foreach ($remind_type as $v) {
																switch ($v) {
																	case 1: $remind_type_str .= '系统弹窗, '; break;
																	case 2: $remind_type_str .= '钉钉, '; break;
																	case 3: $remind_type_str .= '微信, '; break;
																	case 4: $remind_type_str .= '短信, '; break;
																	default : $remind_type_str .= '未知, '; break;
																}
															}
															
															echo rtrim($remind_type_str, ', ');
														}
													?>
		                                        </td>
		                                        <td class="table-list-title">提醒时间</td>
		                                        <td class="table-list-content">{{$vo->remind_time ? date('Y-m-d H:i:s', $vo->remind_time) : ''}}</td>  
		                                    </tr>
		                                </table>
		                            </td>
		                        </tr> 
			                    @endforeach
			                @else
			                    <tr class="text-center">
			                        <td colspan="9">没有查询到相关记录~</td>
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

<script>
	$.lie.followup.index();

	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
</script>


