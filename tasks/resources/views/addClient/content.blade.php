<div id="page-wrapper" class="gray-bg">
	@include('layouts.header')

	<div class="wrapper wrapper-content">
	    <div class="row">
	        <div class="col-lg-12">
	            <div class="ibox float-e-margins">
	             	<div class="ibox-content">
						<form class="form-horizontal addClientForm">
							<!-- 基本资料 -->
							<div class="hr-line-dashed"></div>
							<div class="row row-space">
								<label class="col-md-2 control-label"><h2>基本资料</h2></label>

								<div class="col-md-10">
									<div class="col-md-2">
										<label class="control-label">来源</label>    
			                            <select name="base-source" class="form-control base-source">
			                            	<option value="4" selected>线下</option>
			                            </select>       
									</div>
		
				             		<div class="col-md-2">
				                        <label class="control-label"><!-- <i class="text-danger base-adtag-danger">*</i> -->Adtag</label>
				                        <input type="text" name="base-adtag" class="form-control base-adtag" value="">
					                </div>
				                   
				                   	<div class="col-md-2">
				                        <label class="control-label">客户级别</label>
			                            <select name="base-grade" class="form-control base-grade">
			                            	<option value="0">--请选择--</option>
			                                <?php 
			                                    foreach (Config('config.customer_grade') as $k=>$v) {
			                                        echo '<option value="'.$k.'">'.$v.'</option>';
			                                    }
			                                ?>
			                            </select>	
				                    </div>	

				                    <div class="col-md-2">
				                        <label class="control-label">当前状态</label>
			                            <select name="base-status" class="form-control base-status">
			                            	<option value="0">--请选择--</option>
			                                <?php 
			                                    foreach (Config('config.customer_status') as $k=>$v) {
			                                        echo '<option value="'.$k.'">'.$v.'</option>'; 
			                                    }
			                                ?>
			                            </select>
				                    </div>

				                    <div class="col-md-2">
				                        <label class="control-label"><i class="text-danger base-mobile-danger">*</i>手机</label>
				                        <input type="text" name="base-mobile" class="form-control base-mobile" value="">      
									</div>
								</div>
							</div>

							<div class="row row-space">
								<label class="col-md-2 control-label"></label>

								<div class="col-md-10">
									<div class="col-md-2">									
				                        <label class="control-label">邮箱</label>				                        
				                        <input type="text" name="base-email" class="form-control base-email" value="">
									</div>

									<div class="col-md-2">									
				                        <label class="control-label">微信</label>
				                        <input type="text" name="base-wechat" class="form-control base-wechat" value=""> 
									</div>

									<div class="col-md-2">
					                    <label class="control-label">QQ</label>
					                    <input type="text" name="base-qq" class="form-control base-qq" value="">
									</div>

									<div class="col-md-2">
				                        <label class="control-label">是否加微信</label>
			                            <select name="base-add-wechat" class="form-control base-add-wechat">
			                            	<option value="">--请选择--</option>
			                                <option value="1">是</option>
			                                <option value="0">否</option>
			                            </select>				            
									</div>

									<div class="col-md-2">									
				                        <label class="control-label">是否加社群</label>
			                            <select name="base-join-group" class="form-control base-join-group">
			                            	<option value="">--请选择--</option>
			                                <option value="1">是</option>
			                                <option value="0">否</option>
			                            </select>				                        
									</div>
								</div>
							</div>

		                    <div class="row row-space">
		                     	<label class="col-md-2 control-label"></label>

								<div class="col-md-10">
									<div class="col-md-2">									 
				                        <label class="control-label">渠道来源</label>
			                            <select name="base-channel-source" class="form-control base-channel-source">
			                            	<option value="0">--请选择--</option>
			                                <?php 
			                                    foreach (Config('config.channel_source') as $k=>$v) {
			                                        echo '<option value="'.$k.'">'.$v.'</option>';
			                                    }
			                                ?>
			                            </select>				                        
									</div>

									<div class="col-md-2 base-channel-source-other">
										<label class="control-label">其他渠道来源</label>
				                        <input type="text" name="channel-source-other" class="form-control channel-source-other" value="" placeholder="填写其他渠道来源">
									</div>

									<div class="col-md-2">
				                        <label class="control-label">需求类型</label>
			                            <select name="base-need-type" class="form-control base-need-type">
			                            	<option value="0">--请选择--</option>
			                                <?php 
			                                    foreach (Config('config.need_type') as $k=>$v) {
			                                        echo '<option value="'.$k.'">'.$v.'</option>';
			                                    }
			                                ?>
			                            </select>
									</div>

									<div class="col-md-2 base-need-type-other">
					                    <label class="control-label">其他需求类型</label>
					                    <input type="text" name="need-type-other" class="form-control need-type-other" value="" placeholder="填写需求类型">
									</div>
			                    </div>
		                    </div>

		                    
		                    <!-- 公司资料 -->
							<div class="hr-line-dashed"></div>
							<div class="row row-space">
								<label class="col-md-2 control-label"><h2>公司资料</h2></label>

								<div class="col-md-10">
									<div class="col-md-2">
				                        <label class="control-label"><i class="text-danger com_name_danger">*</i>公司名称</label>
				                        <input type="text" name="com_name" class="form-control com_name" value="">
									</div>

									<div class="col-md-2">
				                        <label class="control-label">公司类型</label>
			                             <select name="com_type" class="form-control com_type">
			                             	<option value="0">--请选择--</option>
			                                <?php 
			                                    foreach (Config('config.company_type') as $k=>$v) {
			                                        echo '<option value="'.$k.'">'.$v.'</option>'; 
			                                    }
			                                ?>
			                            </select>
									</div>

									<div class="col-md-4">
				                        <label class="control-label">公司地址</label>
				                        <input type="text" name="address" class="form-control address" value="">
									</div>

									<div class="col-md-2">
					                    <label class="control-label">公司规模</label>
					                    <input type="text" name="com_scale" class="form-control com_scale" value="">
									</div>
								</div>
							</div>

							<div class="row row-space">
								<label class="col-md-2 control-label"></label>

								<div class="col-md-10">
									<div class="col-md-2">
				                        <label class="control-label">邮箱</label>
				                        <input type="text" name="com_email" class="form-control com_email" value="">
									</div>

									<div class="col-md-2">								
				                        <label class="control-label">座机</label>
				                        <input type="text" name="com_fixed_tel" class="form-control com_fixed_tel" value="">      
									</div>

									<div class="col-md-2">
				                        <label class="control-label">网站</label>
				                        <input type="text" name="com_website" class="form-control com_website" value="">
									</div>

									<div class="col-md-2">
				                        <label class="control-label">传真</label>
				                        <input type="text" name="com_fax" class="form-control com_fax" value="">
									</div>

									{{--<div class="col-md-2">--}}
				                        {{--<label class="control-label">项目名称</label>--}}
				                        {{--<input type="text" name="project_name" class="form-control project_name" value="">--}}
									{{--</div>--}}
								</div>
							</div>

							<div class="row row-space">
								<label class="col-md-2 control-label"></label>

								<div class="col-md-10">
									<div class="col-md-4">
					                    <label class="control-label">主营品牌</label>
					                    <textarea name="main_brand" class="form-control main_brand" cols="60" rows="3"></textarea>
									</div>

									<div class="col-md-4">	
					                    <label class="control-label">公司简介</label>
					                    <textarea name="com_desc" class="form-control com_desc" cols="60" rows="3"></textarea>
									</div>
								</div>
							</div>
		                   

							<!-- 联系人 -->
							<div class="hr-line-dashed"></div>
							<div class="row row-space">
								<label class="col-md-2 control-label"><h2>联系人</h2></label>

								<div class="col-md-10">
									<div class="col-md-2">
					                    <label class="control-label">姓名</label>    
					                    <input type="text" name="linkman_name" class="form-control linkman_name" value="">
									</div>
									
				             		<div class="col-md-2">
					                    <label class="control-label">部门</label>
					                    <input type="text" name="linkman_department" class="form-control linkman_department" value="">
				                    </div>
				                   
				                   <div class="col-md-2">
					                    <label class="control-label">职务</label>
					                    <input type="text" name="linkman_duty" class="form-control linkman_duty" value="">
				                    </div>	

				                    <div class="col-md-2">
					                    <label class="control-label">手机号码</label>
					                    <input type="text" name="linkman_mobile" class="form-control linkman_mobile" value="">
									</div>

									<div class="col-md-2">
					                    <label class="control-label">座机</label>    
					                    <input type="text" name="linkman_fixed_tel" class="form-control linkman_fixed_tel" value="">
									</div>
								</div>
							</div>

							<div class="row row-space">
								<label class="col-md-2 control-label"></label>

								<div class="col-md-10">
				             		<div class="col-md-2">
				                        <label class="control-label">性别</label>
			                            <select name="linkman_sex" class="form-control linkman_sex">
			                            	<option value="0">--请选择--</option>
			                                <option value="1">男</option>
			                                <option value="2">女</option>
			                            </select>
				                    </div>
				                   
				                   <div class="col-md-2">
				                        <label class="control-label">生日</label>
				                        <input type="text" name="linkman_birthday" class="form-control linkman_birthday" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"  value="" autocomplete="off" />
				                    </div>
								</div>
							</div>

							<!-- 公司发票 -->
							<div class="hr-line-dashed"></div>
							<div class="row row-space">
								<label class="col-md-2 control-label"><h2>公司发票</h2></label>

								<div class="col-md-10">
									<div class="col-md-2">
					                    <label class="control-label">公司全称</label>    
					                    <input type="text" name="inv_com_name" class="form-control inv_com_name" value="">
									</div>
									
				             		<div class="col-md-2">
					                    <label class="control-label">税务登记号</label>
					                    <input type="text" name="inv_tax_no" class="form-control inv_tax_no" value="">
				                    </div>

				                    <div class="col-md-2">
					                    <label class="control-label">电话</label>
					                    <input type="text" name="inv_telephone" class="form-control inv_telephone" value="">
									</div>

									<div class="col-md-4">
					                    <label class="control-label">注册地址</label>
					                    <input type="text" name="inv_addr" class="form-control inv_addr" value="">
				                    </div>	
								</div>
							</div>

							<div class="row row-space">
								<label class="col-md-2 control-label"></label>

								<div class="col-md-10">
									<div class="col-md-2">
					                    <label class="control-label">开户行名称</label>    
					                    <input type="text" name="inv_bank_name" class="form-control inv_bank_name" value="">
									</div>

				             		<div class="col-md-2">
					                    <label class="control-label">银行账号</label>
					                    <input type="text" name="inv_bank_account" class="form-control inv_bank_account" value="">
				                    </div>
				                   
				                   <div class="col-md-4">
					                    <label class="control-label">开户行地址</label>
					                    <input type="text" name="inv_bank_addr" class="form-control inv_bank_addr" value="">
				                    </div>
								</div>
							</div>
							
							<div class="hr-line-dashed"></div>
				            <div class="form-group">
				                <div class="col-md-6 col-md-offset-2">
				                  	<a class="btn btn-info add-client">提交</a>	
				                </div>
				            </div>			
						</form>
	             	</div>
	            </div>
	        </div>
	    </div>
	</div>
</div>


<script>
	$.lie.addClient.index();
	
	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
</script>
