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
					        <li><a href="/web/orderlist/{{$user_id}}">历史订单</a></li>
					        <li><a href="/web/details/{{$user_id}}">客户资料</a></li>
					        <li class="active"><a href="javascript:;">在线行为</a></li>
					        <li><a href="/web/buybehavior/{{$user_id}}">购买行为</a></li>
					    </ul>
	             	</div>

	             	<!-- 搜索栏 -->
		         	<div class="ibox-title" style="border-top:0;">
		         		<form class="form-inline" style="margin: 15px 0;">
		         			<div class="row">
								<div class="col-md-12" style="margin-left: 10px;">
									<div class="form-group show-space">
									    <label>行为搜索</label>
												
										<select name="action" class="form-control action">
											<option value="">全部</option>
											<option value="1">访问</option>
	                                        <option value="2">注册</option>
	                                        <option value="3">登录</option>
	                                        <option value="4">加入购物车</option>
	                                        <option value="5">立即购买</option>
	                                        <option value="6">立即结算</option>
	                                        <option value="7">立即付款</option>
	                                        <option value="8">客服服务</option>
	                                        <option value="9">优惠券</option>
	                                        <option value="10">抽奖</option>
	                                        <option value="11">搜索</option>
										</select>
									</div>

									<div class="form-group show-space">
										<label>行为参数</label>
										<input type="text" name="action_param" class="form-control action_param" value="{{$condition['action_param']}}" placeholder="请输入ptag值">
									</div>

									<div class="form-group show-space">
										<label>场景搜索</label>
										<input type="text" name="scene" class="form-control scene" value="{{$condition['scene']}}" placeholder="请输入ptag值">
									</div>

									<div class="form-group show-space">
										<label>使用平台</label>
										<select name="platform" class="form-control platform">
											<option value="">全部</option>
											<option value="1">PC端</option>
											<option value="2">移动端</option>
										</select>
									</div>

									<div class="form-group show-space">
										<label>ptag搜索</label>
										<input type="text" name="ptag" class="form-control ptag" value="{{$condition['ptag']}}" placeholder="请输入ptag值">
									</div>

									<div class="form-group show-space">
										<label>Adtag搜索</label>
										<input type="text" name="adtag" class="form-control adtag" value="{{$condition['adtag']}}" placeholder="请输入Adtag值" >
									</div>

									<div class="form-group show-space">
										<label>行为时间</label>

										<input type="text" name="begin_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['begin_time']) ? date('Y/m/d', $condition['begin_time']) : ''}}" autocomplete="off" />									
										<input type="text" name="end_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd'})"  value="{{!empty($condition['end_time']) ? date('Y/m/d', $condition['end_time']) : ''}}" autocomplete="off" />
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-10">
									<button class="btn btn-info">搜索</button>
								</div>
							</div>
				    	</form>
		         	</div>
					
	             	<div class="ibox-content" style="margin-top: 10px;">
	             		 <table class="table table-hover">
				            <thead>
				                <tr> 
				                	<th width="10%">用户行为</th>                
				                    <th width="13%">Adtag</th> 
				                    <th width="13%">ptag</th>                                          
				                    <th width="13%">行为参数</th>  
				                    <th width="13%">场景</th> 			 
				                    <th width="7%">使用平台</th> 
				                    <th width="7%">行为结果</th>
				                    <th width="14%">创建时间</th> 
				                </tr>
				            </thead>
				            <tbody>
				                @if (!empty($list) && $list->count())
				                    @foreach ($list as $key => $vo)
				                    <tr class="show-list">
				                    	<td>
				                            <?php 
				                                switch ($vo->behavior) {
				                                    case 1: echo '访问'; break;
				                                    case 2: echo '注册'; break;
				                                    case 3: echo '登录'; break;
				                                    case 4: echo '加入购物车'; break;
				                                    case 5: echo '立即购买'; break;
				                                    case 6: echo '立即结算'; break;
				                                    case 7: echo '立即付款'; break;
				                                    case 8: echo '客服服务'; break;
				                                    case 9: echo '优惠券'; break;
				                                    case 10: echo '抽奖'; break;
				                                    case 11: echo '搜索'; break;
				                                    default: echo '未知'; break;
				                                }
				                            ?>
				                        </td>

				                        <td>
				                            <p class="show-title" title="{{$vo->adtag}}" style="width: 150px;">{{$vo->adtag}}</p>
				                        </td> 
				                        
				                        <td>
				                        	<p class="show-title" title="{{$vo->ptag}}" style="width: 150px;">{{$vo->ptag}}</p>
				                        </td>                 
				                        <td>
				                            <p class="show-title" title="{{$vo->param}}" style="width: 150px;">{{$vo->param}}</p>
				                        </td>
				                        <td >          
				                            <p class="show-title" title="{{$vo->scene}}" style="width: 150px;">{{$vo->scene}}</p>
				                        </td>
				                        
				                        <td>
				                            <?php 
				                                switch ($vo->platform) {
				                                    case 1: echo 'PC端'; break;
				                                    case 2: echo '移动端'; break;
				                                    default: echo '未知'; break;
				                                }
				                            ?>
				                        </td>

	                                    <td>
	                                        <?php 
	                                            switch ($vo->result) {
	                                                case -1: echo '失败'; break;
	                                                case 1: echo '成功'; break;
	                                                default: echo '未知'; break;
	                                            }
	                                        ?>
	                                    </td>

				                        <td>{{date('Y-m-d H:i:s', $vo->create_time)}}</td>
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
	var action_condition = "{{$condition['action']}}"; 
	$('.action').val(action_condition);

	var platform_condition = "{{$condition['platform']}}"; 
	$('.platform').val(platform_condition);

	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
</script>
