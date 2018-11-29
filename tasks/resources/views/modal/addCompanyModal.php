<div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addCompanyModalLabel">新增公司信息</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal companyForm"> 
                    <input type="hidden" name="user_id" value="<?= $userInfo->user_id ?>">        
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><i class="text-danger">*</i> 公司名称：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_name" class="form-control com_name" value="">
                        </div>
                    </div>
                   
                   <div class="form-group">
                        <label class="col-sm-3 control-label">公司类型：</label>
                        <div class="col-sm-9">
                             <select name="com_type" class="form-control com_type">
                                <?php 
                                    foreach (Config('config.company_type') as $k=>$v) {    
                                        echo '<option value="'.$k.'">'.$v.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">公司地址：</label>
                        <div class="col-sm-9">
                            <input type="text" name="address" class="form-control address" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">邮箱：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_email" class="form-control com_email" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">座机：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_fixed_tel" class="form-control com_fixed_tel" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">网站：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_website" class="form-control com_website" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">传真：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_fax" class="form-control com_fax" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">项目名称：</label>
                        <div class="col-sm-9">
                            <input type="text" name="project_name" class="form-control project_name" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">主营品牌：</label>
                        <div class="col-sm-9">
                            <textarea name="main_brand" class="form-control main_brand" cols="60" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">公司规模：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_scale" class="form-control com_scale" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">公司简介：</label>
                        <div class="col-sm-9">
                            <textarea name="com_desc" class="form-control com_desc" cols="60" rows="3"></textarea>
                        </div>
                    </div>
                    
                </form>    

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary company-success">确认</button>
            </div>
        </div>
    </div>
</div>