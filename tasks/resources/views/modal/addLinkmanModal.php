<div class="modal fade" id="addLinkmanModal" tabindex="-1" role="dialog" aria-labelledby="addLinkmanModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addLinkmanModalLabel">新增联系人</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal addLinkmanForm">          
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="text-danger">*</i> 姓名：</label>
                        <div class="col-sm-10">
                            <input type="text" name="linkman_name" class="form-control linkman_name" value="">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="text-danger">*</i> 部门：</label>
                        <div class="col-sm-10">
                            <input type="text" name="department" class="form-control department" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="text-danger">*</i> 职务：</label>
                        <div class="col-sm-10">
                            <input type="text" name="duty" class="form-control duty" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">手机：</label>
                        <div class="col-sm-10">
                            <input type="text" name="linkman_mobile" class="form-control linkman_mobile" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">座机：</label>
                        <div class="col-sm-10">
                            <input type="text" name="linkman_fixed_tel" class="form-control linkman_fixed_tel" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">性别：</label>
                        <div class="col-sm-10">
                            <select name="linkman_sex" class="form-control linkman_sex">
                                <option value="1">男</option>
                                <option value="2">女</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">生日：</label>
                        <div class="col-sm-10">
                            <input type="text" name="linkman_birthday" class="form-control linkman_birthday" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"  value="" autocomplete="off" />
                        </div>
                    </div>                 
                </form>    
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary linkman-success">确认</button>
            </div>
        </div>
    </div>
</div>