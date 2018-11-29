<div class="modal fade" id="editLinkmanModal_<?= $linkman->link_id ?>" tabindex="-1" role="dialog" aria-labelledby="editLinkmanModalLabel_<?= $linkman->link_id ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editLinkmanModalLabel_<?= $linkman->link_id ?>">编辑联系人</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal editLinkmanForm_<?= $linkman->link_id ?>">          
                    <div class="form-group">
                        <input type="hidden" name="link_id" value="<?= $linkman->link_id ?>">
                        <label class="col-sm-2 control-label"><i class="text-danger">*</i> 姓名：</label>
                        <div class="col-sm-10">
                            <input type="text" name="linkman_name" class="form-control linkman_name" value="<?= $linkman->name ?>">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="text-danger">*</i> 部门：</label>
                        <div class="col-sm-10">
                            <input type="text" name="department" class="form-control department" value="<?= $linkman->department ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="text-danger">*</i> 职务：</label>
                        <div class="col-sm-10">
                            <input type="text" name="duty" class="form-control duty" value="<?= $linkman->duty ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">手机：</label>
                        <div class="col-sm-10">
                            <input type="text" name="linkman_mobile" class="form-control linkman_mobile" value="<?= $linkman->mobile ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">座机：</label>
                        <div class="col-sm-10">
                            <input type="text" name="linkman_fixed_tel" class="form-control linkman_fixed_tel" value="<?= $linkman->fixed_tel ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">性别：</label>
                        <div class="col-sm-10">
                            <select name="linkman_sex" class="form-control linkman_sex">
                                <option value="1" <?= $linkman->sex == 1 ? 'selected' : '' ?>>男</option>
                                <option value="2" <?= $linkman->sex == 2 ? 'selected' : '' ?>>女</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">生日：</label>
                        <div class="col-sm-10">
                            <input type="text" name="linkman_birthday" class="form-control linkman_birthday" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"  value="<?= !empty($linkman->birthday) ? date('Y-m-d', $linkman->birthday) : '' ?>" autocomplete="off" />
                        </div>
                    </div>                 
                </form>    
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary linkman-success" data-lid="<?= $linkman->link_id ?>">确认</button>
            </div>
        </div>
    </div>
</div>