<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="assignModalLabel">分配业务员</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal assignForm">
                    <input type="hidden" name="user_id" value="">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label col-sm-2">经理：</label>
                        <div class="col-sm-10">
                            <?php 
                                if (!empty($manager)) {
                                    $managerStr = '';

                                    foreach ($manager as $k=>$v) {
                                        $managerStr .= '<label class="checkbox-inline" style="margin-left:10px;">
                                                            <input class="salesman sale_'.$v->userId.'" type="checkbox" name="sale_id[]" value="'.$v->userId.'">'.$v->name.'
                                                        </label>';
                                    }

                                    echo $managerStr;
                                }
                            ?>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="message-text" class="control-label col-sm-2">业务员：</label>
                        <div class="col-sm-10">
                            <?php 
                                if (!empty($salesman)) {
                                    $salesmanStr = '';

                                    foreach ($salesman as $k=>$v) {
                                        $salesmanStr .= '<label class="checkbox-inline" style="margin-left:10px;">
                                                            <input class="salesman sale_'.$v->userId.'" type="checkbox" name="sale_id[]" value="'.$v->userId.'">'.$v->name.'
                                                        </label>';
                                    }

                                    echo $salesmanStr;
                                }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary assign_to_salesman">确认</button>
            </div>
        </div>
    </div>
</div>