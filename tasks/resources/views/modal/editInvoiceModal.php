<div class="modal fade" id="editInvoiceModal_<?= $invoice->inv_id ?>" tabindex="-1" role="dialog" aria-labelledby="editInvoiceModalLabel_<?= $invoice->inv_id ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editInvoiceModalLabel_<?= $invoice->inv_id ?>">编辑发票</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal editInvoiceForm_<?= $invoice->inv_id ?>"> 
                    <input type="hidden" name="inv_id" value="<?= $invoice->inv_id ?>">         
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><i class="text-danger">*</i> 公司全称：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_name" class="form-control com_name" value="<?= $invoice->com_name ?>">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">税务登记号：</label>
                        <div class="col-sm-9">
                            <input type="text" name="tax_no" class="form-control tax_no" value="<?= $invoice->tax_no ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">电话：</label>
                        <div class="col-sm-9">
                            <input type="text" name="telephone" class="form-control telephone" value="<?= $invoice->telephone ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">注册地址：</label>
                        <div class="col-sm-9">
                            <input type="text" name="com_addr" class="form-control com_addr" value="<?= $invoice->com_addr ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">开户行名称：</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_name" class="form-control bank_name" value="<?= $invoice->bank_name ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">银行账号：</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_account" class="form-control bank_account" value="<?= $invoice->bank_account ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">开户行地址：</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_addr" class="form-control bank_addr" value="<?= $invoice->bank_addr ?>">
                        </div>
                    </div>                        
                </form>    
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary invoice-success" data-vid="<?= $invoice->inv_id ?>">确认</button>
            </div>
        </div>
    </div>
</div>