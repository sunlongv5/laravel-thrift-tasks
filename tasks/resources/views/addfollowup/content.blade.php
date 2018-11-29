<div id="page-wrapper" class="gray-bg">
	@include('layouts.header')
	<div class="wrapper wrapper-content">
	    <div class="row">
	        <div class="col-lg-12">
	            <div class="ibox float-e-margins">
	             	<div class="ibox-content">
	             		<form class="form-horizontal addFollowUpForm" style="width: 50%;">  
		                    <input type="hidden" name="user_id" value="{{$user_id}}">
		                    <input type="hidden" name="fol_id" value="{{ isset($followup) ? $fid : '' }}">
		                   
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">本次跟进详情：</label>
		                        <div class="col-sm-10">
		                            <textarea name="current_details" class="form-control current_details" rows="3">{{ isset($followup) ? $followup->current_details : '' }}</textarea>
		                        </div>
		                    </div>

		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">是否接通:</label>

		                        <div class="col-sm-10">
		                            <label class="radio-inline">
		                                <input type="radio" checked="checked" name="is_contact" class="is_contact" value="1"> 是
		                            </label>
		                            <label class="radio-inline">
		                                <input type="radio" name="is_contact" class="is_contact" value="0"> 否
		                            </label>
		                        </div>
		                    </div>

		                    <div class="form-group">
	                            <label class="col-sm-2 control-label">当前级别：</label>
	                            <div class="col-sm-5">
	                                <select name="grade" class="form-control grade">
	                                	<option value="">全部</option>
	                                    @foreach (Config('config.followup_grade') as $k=>$v)
											<option @if(isset($userinfo->grade) && $userinfo->grade > 0 && $userinfo->grade == $k ) selected="selected" @endif  value="{{$k}}">{{$v}} </option>
										@endforeach
	                                </select>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-sm-2 control-label">来源：</label>
	                            <div class="col-sm-5">
	                                <select name="source" class="form-control source">
	                                	<option value="">全部</option>
	                                    @foreach (Config('config.followup_source') as $k=>$v)
											<option value="{{$k}}">{{$v}}</option>
										@endforeach
	                                </select>
	                            </div>
	                        </div>

	                        <div class="form-group">
		                        <label class="col-sm-2 control-label">下次跟进事项：</label>
		                        <div class="col-sm-10">
		                            <textarea name="next_details" class="form-control next_details" rows="3">{{ isset($followup) ? $followup->next_details : '' }}</textarea>
		                        </div>
		                    </div>

		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">下次跟进时间：</label>
		                        <div class="col-sm-5">
		                            <input type="text" name="next_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd HH:mm:ss'})"  value="{{ isset($followup) ? date('Y-m-d m:i:s', $followup->next_time) : '' }}" autocomplete="off" />	
		                        </div>
		                    </div>
		  
		                    <div class="form-group">
		                        <label class="col-sm-2 control-label">是否提醒：</label>
		                        <div class="col-sm-10">
		                            <label class="radio-inline">
		                                <input type="radio" name="is_remind" class="is_remind" value="1"> 是
		                            </label>
		                            <label class="radio-inline">
		                                <input type="radio" name="is_remind" class="is_remind" value="0"> 否
		                            </label>
		                        </div>
		                    </div>

		                    <div class="show-notice">
		                        <div class="form-group">
		                            <label class="col-sm-2 control-label">提醒方式：</label>
		                            <div class="col-sm-5">
		                            	<input type="hidden" name="remind_type_val" class="remind_type_val" value="">
		                                <select name="remind_type" class="form-control selectpicker remind_type"  title="全部" data-live-search="true" data-live-search-placeholder="搜索" multiple>
		                                    <option value="1">系统弹窗</option>
		                                    <option value="2">钉钉</option>
		                                    <!-- <option value="3">微信</option> -->
		                                    <option value="4">短信</option>
		                                </select>
		                            </div>
		                        </div>

		                         <div class="form-group">
		                            <label class="col-sm-2 control-label">提醒时间：</label>
		                            <div class="col-sm-5">
		                                <input type="text" name="remind_time" class="form-control" onfocus="WdatePicker({dateFmt:'yyyy/MM/dd HH:mm:ss'})"  value="{{ isset($followup) ? date('Y-m-d m:i:s', $followup->remind_time) : '' }}" autocomplete="off" readonly />
		                            </div>
		                        </div>
		                    </div> 

		                    <div class="form-group">
	                            <label class="col-sm-2 control-label"></label>
	                            <div class="col-sm-10">
	                                <a class="btn btn-info add-followup">确认提交</a>
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
	$(".selectpicker").selectpicker({
        actionsBox:true, //在下拉选项添加选中所有和取消选中的按钮
        countSelectedText:"已选中{0}项",
        selectedTextFormat:"count > 5",
        selectAllText: '全选',
        deselectAllText: '取消全选',
    })

    var is_contact = "{{isset($followup) ? $followup->is_contact : ''}}";
	$('.is_contact').each(function(){
		if ($(this).val() == is_contact) {
			$(this).attr('checked', true);
		}
	})

    var grade = "{{isset($followup) ? $followup->grade : ''}}";
	var _grade = "{{(isset($userinfo->grade) && $userinfo->grade > 0) ? $userinfo->grade : ''}}";




    var source = "{{isset($followup) ? $followup->source : ''}}";


	(function(){
		grade = grade ? grade : _grade;
		$('.source').val(source);
		$('.grade').val(grade);
	})()


    var is_remind = "{{isset($followup) ? $followup->is_remind : ''}}";
	$('.is_remind').each(function(){
		if ($(this).val() == is_remind) {
			$(this).attr('checked', true);
		}

		if (is_remind == 1) {
			$('.show-notice').show();
		}
	})

	// 下拉列表赋值
	var remind_type = "{{isset($followup) ? $followup->remind_type : ''}}";
	$('.remind_type').selectpicker('val', remind_type.split(',')).trigger("change");

	$.lie.followup.index();

	$('#side-menu').children('li').eq(1).attr('class', 'active');
	$('#side-menu').children('li').eq(1).children('ul').children('li').eq(0).attr('class', 'active');
</script>
