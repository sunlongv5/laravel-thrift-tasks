<div id="page-wrapper" class="gray-bg">
	@include('layouts.header')

	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<!-- 搜索栏 -->
					<div class="ibox-title" style="border-top: none;">
						<form class="form-inline search-bar">
							<div class="row">
								<div class="col-md-12" style="margin-left: 10px;">
									<div class="form-group show-space">
										<input class="form-control" type="text" name="com_name" value="{{$condition['com_name']}}" placeholder="请输入公司名">
									</div>

									<div class="form-group show-space">
										<input class="form-control" type="text" name="lx_account" value="{{$condition['lx_account']}}" placeholder="请输入平台账号">
									</div>

									<div class="form-group show-space">
										<label>客户来源</label>
										<select class="form-control" name="source" id="source" style="width:135px">
											<option value="">全部</option>
											<option value="1">猎芯平台PC端</option>
											<option value="2">猎芯平台移动端</option>
											<option value="3">京东</option>
											<option value="4">线下</option>
										</select>
									</div>

									<div class="form-group show-space">
										<label>跟进业务员</label>
										<select class="form-control" name="salesman" id="salesman">
											<option value="">全部</option>
											@foreach ($sales_list as $k=>$v)
												@if ($condition['salesman'] == $v->userId)
													<option value="{{$v->userId}}" selected>{{$v->name}}</option>
												@else
													<option value="{{$v->userId}}">{{$v->name}}</option>
												@endif
											@endforeach
										</select>
									</div>

									<div class="form-group show-space">
										<label>客户级别</label>
										<select class="form-control" name="customer_grade" id="customer_grade">
											<option value="">全部</option>
											@foreach (Config('config.customer_grade') as $k=>$v)
												@if ($condition['customer_grade'] == $k)
													<option value="{{$k}}" selected>{{$v}}</option>
												@else
													<option value="{{$k}}">{{$v}}</option>
												@endif
											@endforeach
										</select>
									</div>

									<div class="form-group show-space">
										<label>当前状态</label>
										<select class="form-control" name="customer_status" id="customer_status">
											<option value="">全部</option>
											@foreach (Config('config.customer_status') as $k=>$v)
												@if ($condition['customer_status'] == $k)
													<option value="{{$k}}" selected>{{$v}}</option>
												@else
													<option value="{{$k}}">{{$v}}</option>
												@endif
											@endforeach
										</select>
									</div>

									<div class="form-group show-space">
										<label>是否有跟进业务员</label>
										<select class="form-control" name="is_sale" style="width: 100px">
											<option value="all">全部</option>
											<option @if(\Input::get('is_sale','all') == '1') selected @endif value="1">是</option>
											<option @if(\Input::get('is_sale','all') == '0') selected @endif value="0">否</option>
										</select>
									</div>

									<div class="form-group show-space">
										<label class="control-label">建档时间</label>

										<input type="text" name="begin_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['begin_time']) ? date('Y/m/d', $condition['begin_time']) : ''}}" autocomplete="off" />
										<input type="text" name="end_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['end_time']) ? date('Y/m/d', $condition['end_time']) : ''}}" autocomplete="off" />
									</div>



									<div class="form-group show-space">
										<button class="btn btn-info search-list">搜索</button>
									</div>

								</div>
							</div>


						</form>
					</div>

					<div class="ibox-content">
						<table class="table table-hover">
							<tr>
								{{--<th width="20%">公司名称</th>--}}
								{{--<th width="10%">平台账号</th>--}}
								<th width="20%">账号/名称</th>
								<th width="11%">客户来源</th>
								<th width="7%">客户级别</th>
								<th width="7%">当前状态</th>
								<th width="10%">跟进业务员</th>
								<th width="13%">建档时间</th>
								<th width="13%">操作</th>
							</tr>

							@if (!empty($list) && $list->count())
								@foreach ($list as $key => $vo)
									<tr>
										<td>
											@if($vo->com_name)
												{{$vo->com_name}}
											@else
												@if($vo->source == 1 || $vo->source == 2)
													{{$vo->mobile ? $vo->mobile : $vo->email}}
												@elseif($vo->source == 3)
													{{$vo->source == 3 ? $vo->jd_account : ''}}
												@endif
											@endif
										</td>
										<td>
											<?php
											switch ($vo->source) {
												case 1: echo '猎芯平台PC端'; break;
												case 2: echo '猎芯平台移动端'; break;
												case 3: echo '京东'; break;
												case 4: echo '线下'; break;
												default: echo '未知'; break;
											}
											?>
										</td>
										<td>{{$vo->grade ? (isset(Config('config.customer_grade')[$vo->grade]) ? Config('config.customer_grade')[$vo->grade] : '未定') : '未定'}}</td>
										<td>{{$vo->status ? Config('config.customer_status')[$vo->status] : '未定'}}</td>
										<td>
											<?php
											$sales = App\Http\Controllers\getSalesName($vo->user_id);
											echo $sales;
											?>
										</td>
										<td>{{$vo->copy_ctime ? date('Y-m-d H:i:s', $vo->copy_ctime) : ''}}</td>
										<td>
											<a class="btn btn-xs btn-info" target="_blank" href="/web/quote/{{$vo->user_id}}">查看</a>
											<a class="btn btn-xs btn-success open_sales_modal" data-uid="{{$vo->user_id}}" data-saleid="{{ App\Http\Controllers\getSaleId($vo->user_id) }}" href="javascript:;">推送</a>
											@if ($sales)
												<a class="btn btn-xs btn-danger roll-out" data-uid="{{$vo->user_id}}" data-type="2">转出</a>
											@endif
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

@include('assign.assignModal')

<script>
	var source = "{{$condition['source']}}";
	$('#source').val(source);

	$.lie.assign.index();
</script>
