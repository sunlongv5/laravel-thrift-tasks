<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userModalLabel">编辑基本资料</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">    
                        <label class="col-sm-3 control-label">来源：</label>    
                        <div class="col-sm-9">
                            <select name="base-source" class="form-control base-source">
                                <?php 
                                    foreach (Config('config.customer_source') as $k=>$v) {
                                        if ($userInfo->source == $k) {
                                            echo '<option value="'.$k.'" selected>'.$v.'</option>';
                                        } else {
                                            echo '<option value="'.$k.'">'.$v.'</option>';
                                        }  
                                    }
                                ?>
                            </select>
                        </div>                              
                    </div>
             
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Adtag：</label>
                        <div class="col-sm-9">
                            <input type="text" name="base-adtag" class="form-control base-adtag" value="<?= $userInfo->adtag ?>">
                        </div>
                    </div>
                   
                   <div class="form-group">
                        <label class="col-sm-3 control-label">客户级别：</label>
                        <div class="col-sm-9">
                             <select name="base-grade" class="form-control base-grade">
                                <?php 
                                    foreach (Config('config.customer_grade') as $k=>$v) {
                                        if ($userInfo->grade == $k) {
                                            echo '<option value="'.$k.'" selected>'.$v.'</option>';
                                        } else {
                                            echo '<option value="'.$k.'">'.$v.'</option>';
                                        }  
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">当前状态：</label>
                        <div class="col-sm-9">
                            <select name="base-status" class="form-control base-status">
                                 <?php 
                                    foreach (Config('config.customer_status') as $k=>$v) {
                                        if ($userInfo->status == $k) {
                                            echo '<option value="'.$k.'" selected>'.$v.'</option>';
                                        } else {
                                            echo '<option value="'.$k.'">'.$v.'</option>';
                                        }  
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">渠道来源：</label>
                        <div class="col-sm-9">
                            <select name="base-channel-source" class="form-control base-channel-source">
                                 <?php 
                                    foreach (Config('config.channel_source') as $k=>$v) {
                                        if ($userInfo->channel_source == $k) {
                                            echo '<option value="'.$k.'" selected>'.$v.'</option>';
                                        } else {
                                            echo '<option value="'.$k.'">'.$v.'</option>';
                                        }  
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group base-channel-source-other">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            <input type="text" name="channel-source-other" class="form-control channel-source-other" value="<?= $userInfo->channel_source_other ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">需求类型：</label>
                        <div class="col-sm-9">
                            <select name="base-need-type" class="form-control base-need-type">
                                 <?php 
                                    foreach (Config('config.need_type') as $k=>$v) {
                                        if ($userInfo->need_type == $k) {
                                            echo '<option value="'.$k.'" selected>'.$v.'</option>';
                                        } else {
                                            echo '<option value="'.$k.'">'.$v.'</option>';
                                        }  
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group base-need-type-other">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            <input type="text" name="need-type-other" class="form-control need-type-other" value="<?= $userInfo->need_type_other ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">是否加微信好友：</label>
                        <div class="col-sm-9">
                            <select name="base-add-wechat" class="form-control base-add-wechat">
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">是否加入社群：</label>
                        <div class="col-sm-9">
                            <select name="base-join-group" class="form-control base-join-group">
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">手机：</label>
                        <div class="col-sm-9">
                            <input type="text" name="base-mobile" class="form-control base-mobile" value="<?= $userInfo->mobile ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">邮箱：</label>
                        <div class="col-sm-9">
                            <input type="text" name="base-email" class="form-control base-email" value="<?= $userInfo->email ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">微信：</label>
                        <div class="col-sm-9">
                            <input type="text" name="base-wechat" class="form-control base-wechat" value="<?= $userInfo->wechat ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">QQ：</label>
                        <div class="col-sm-9">
                            <input type="text" name="base-qq" class="form-control base-qq" value="<?= $userInfo->qq ?>">
                        </div>
                    </div>
                </form>    

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary base-success">确认</button>
            </div>

            <script>
                var channel_source = "<?= $userInfo->channel_source ?>";
                if (channel_source == 6) {
                    $('.base-channel-source-other').show();
                }

                var need_type = "<?= $userInfo->need_type ?>";
                if (need_type == 4) {
                    $('.base-need-type-other').show();
                }

                var is_add_wechat = "<?= $userInfo->is_add_wechat ?>";
                $('.base-add-wechat').val(is_add_wechat);

                var is_join_group = "<?= $userInfo->is_join_group ?>";
                $('.base-join-group').val(is_join_group);
            </script>
        </div>
    </div>
</div>