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
										<select class="form-control" name="source" id="source">
											<option value="">全部</option>
											<option value="1">猎芯平台PC端</option>
											<option value="2">猎芯平台移动端</option>
											<option value="3">京东</option>
											<option value="4">线下</option>   	
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
										<label class="control-label">指派时间</label>

										<input type="text" name="assign_begin_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['assign_begin_time']) ? date('Y/m/d', $condition['assign_begin_time']) : ''}}" autocomplete="off" />									
										<input type="text" name="assign_end_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['assign_end_time']) ? date('Y/m/d', $condition['assign_end_time']) : ''}}" autocomplete="off" />
									</div>

									<div class="form-group show-space">
										<label class="checkbox-inline">
											@if (!empty($condition['only_com_name']))
										  		<input type="checkbox" name="only_com_name" class="only_com_name" value="1" checked> 只看有公司名称的客户
										  	@else
										  		<input type="checkbox" name="only_com_name" class="only_com_name" value="1"> 只看有公司名称的客户
										  	@endif
										</label>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-10">
									<button class="btn btn-info search-list">搜索</button>	
									<a class="btn btn-primary add-customer" href="/web/addClient" target="_blank">新增</a>
									{{--<button type="button" class="btn btn-info search-list" id="test1">--}}
										{{--导入报价--}}
									{{--</button>--}}
									<button type="button" class="btn btn-info search-list" id="export_customer">
										导入客户
									</button>

									<a class="btn btn-primary add-customer" href="/excel/import-customer.xls" target="_blank">下载导入模板</a>
								</div>
							</div>
						</form>
	             	</div>

	             	<div class="ibox-content">
						<table class="table table-hover">
							<tr>
								{{--<th width="28%">公司名称</th>--}}
								<th width="20%">账号/名称</th>
								{{--<th width="10%">京东账号</th>--}}
								<th width="10%">客户来源</th>
								<th width="7%">客户级别</th>
								<th width="7%">当前状态</th>
								<th width="13%">指派时间</th>
								<th width="15%">操作</th>
							</tr>

							@if (!empty($list) && $list->count())
			                    @foreach ($list as $key => $vo)
			                    <tr>
			                        {{--<td>--}}
			                        	{{--<p class="show-title" title="{{$vo->com_name}}" style="width:260px;">{{$vo->com_name}}</p>--}}
			                        {{--</td>--}}
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
			                        <td>{{$vo->grade ? Config('config.customer_grade')[$vo->grade] : '未定'}}</td>
			                        <td>{{$vo->status ? Config('config.customer_status')[$vo->status] : '未定'}}</td>
			                        <td>{{$vo->assign_time ? date('Y-m-d m:i:s', $vo->assign_time) : ''}}</td>
			                        <td>
										<a class="btn btn-xs btn-info" target="_blank" href="/web/quote/{{$vo->user_id}}">查看明细</a>
										<a class="btn btn-xs btn-danger roll-out" data-uid="{{$vo->user_id}}" data-type="1">转出</a>
			                        </td>
			                    </tr>
			                    @endforeach
			                @else
			                    <tr class="text-center">
			                        <td colspan="8">没有查询到相关记录~</td>
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
	var source = "{{$condition['source']}}";
	$('#source').val(source);
	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
	$.lie.assign.index();
</script>
@include('list.js_footer')