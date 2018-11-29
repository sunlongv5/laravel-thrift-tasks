<div class="modal fade" id="addInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="addInvoiceModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addInvoiceModalLabel">新增发票</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal addInvoiceForm">          
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><i class="text-danger">*</i> 公司全称：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_name" class="form-control com_name" value="<?= !empty($companyInfo) ? $companyInfo->com_name : '' ?>">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">税务登记号：</label>
                        <div class="col-sm-9">
                            <input type="text" name="tax_no" class="form-control tax_no" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">电话：</label>
                        <div class="col-sm-9">
                            <input type="text" name="telephone" class="form-control telephone" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">注册地址：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_addr" class="form-control com_addr" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">开户行名称：</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_name" class="form-control bank_name" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">银行账号：</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_account" class="form-control bank_account" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">开户行地址：</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_addr" class="form-control bank_addr" value="">
                        </div>
                    </div>                 
                </form>    
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary invoice-success">确认</button>
            </div>
        </div>
    </div>
</div>