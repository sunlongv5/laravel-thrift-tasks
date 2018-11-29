<div class="modal fade" id="editQuoteModal_<?= $v->quote_id ?>" tabindex="-1" role="dialog" aria-labelledby="editQuoteModalLabel">
    <div class="modal-dialog" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editQuoteModalLabel">编辑报价</h4>
            </div>
            <div class="modal-body" style="padding-left: 10px; padding-right: 10px;">
                <form class="form-inline editQuoteForm_<?= $v->quote_id ?>"">
                    <input type="hidden" name="qid" value="<?= $v->quote_id ?>">
                    <div class="table-responsive">
                        <table class="table text-nowrap edit-quote-table">
                            <thead>
                                <tr>
                                    <th><label class="control-label"><i class="text-danger">*</i>型号</label></th>
                                    <th><label class="control-label"><i class="text-danger">*</i>品牌</label></th>
    
                                    <th><label class="control-label">采购数量</label></th>   
                                    <th><label class="control-label">采购单价</label></th>
                                    <th><label class="control-label">采购币种</label></th>
                                    <th><label class="control-label">采购汇率</label></th>
                                    <th><label class="control-label">采购总价</label></th>
                                    <th><label class="control-label">采购未税单价</label></th>
                                    <th><label class="control-label">采购含税单价</label></th>
                                    <th><label class="control-label">采购未税总价</label></th>
                                    <th><label class="control-label">采购含税总价</label></th>

                                    <th><label class="control-label"><i class="text-danger">*</i>销售数量</label></th>                        
                                    <th><label class="control-label"><i class="text-danger">*</i>销售单价</label></th>
                                    <th><label class="control-label"><i class="text-danger">*</i>销售币种</label></th>
                                    <th><label class="control-label">销售汇率</label></th>
                                    <th><label class="control-label">销售总价</label></th>
                                    <th><label class="control-label">销售未税单价</label></th>
                                    <th><label class="control-label">销售含税单价</label></th>
                                    <th><label class="control-label">销售未税总价</label></th>
                                    <th><label class="control-label">销售含税总价</label></th>
                                    
                                    <th><label class="control-label">毛利润未税</label></th>
                                    <th><label class="control-label">毛利润含税</label></th>
                                    <th><label class="control-label">毛利率</label></th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr class="add-quote-content">
                                    <td>
                                        <input type="hidden" name="goods_id" class="form-control goods_id" value="<?= $v->goods_id ?>">
                                        <input type="text" name="goods_name" class="form-control goods_name" value="<?= $v->goods_name ?>" required autocomplete="off" style="width: 120px;">
                                        <div class="show-query-box"></div> 
                                    </td>
                                    <td>
                                        <input type="hidden" name="brand_id" class="form-control brand_id" value="<?= $v->brand_id ?>">
                                        <input type="text" name="brand_name" class="form-control brand_name" value="<?= $v->brand_name ?>" required autocomplete="off" style="width: 120px;">
                                        <div class="show-query-box"></div>
                                    </td>

                                    <td>
                                        <input type="text" name="picking_num" class="form-control picking_num input_num" value="<?= $v->picking_num ? $v->picking_num : '' ?>" required autocomplete="off" style="width: 90px;"> 
                                    </td>
                                    <td>
                                        <input type="text" name="picking_price" class="form-control picking_price input_num" value="<?= $v->picking_price != 0.0000 ? $v->picking_price : '' ?>" autocomplete="off" style="width: 90px;">    
                                    </td>
                                    <td>                                
                                        <select name="picking_currency" class="form-control picking_currency">
                                            <option value="1" selected>￥</option>
                                            <option value="2">$</option>
                                            <option value="3">€</option>
                                        </select>
                                    </td>           
                                    <td>
                                        <input type="text" name="picking_rate" class="form-control picking_rate input_num" value="<?= $v->picking_rate ?>" autocomplete="off" style="width: 90px;" readonly="true">
                                    </td>
                                    <td><span class="picking_amount"><?= $picking_amount ?></span></td>
                                    <td><span class="picking_price_no_tax"><?= $picking_price_no_tax ?></span></td>
                                    <td><span class="picking_price_tax"><?= $picking_price_tax ?></span></td>
                                    <td><span class="picking_amount_no_tax"><?= $picking_amount_no_tax ?></span></td>
                                    <td><span class="picking_amount_tax"><?= $picking_amount_tax ?></span></td>
                                    
                                    <td>
                                        <input type="text" name="sale_num" class="form-control sale_num input_num" value="<?= $v->sale_num ?>" required autocomplete="off" style="width: 90px;"> 
                                    </td>
                                    <td>                                
                                        <input type="text" name="sale_price" class="form-control sale_price input_num" value="<?= $v->sale_price ?>" required autocomplete="off" style="width: 90px;">
                                    </td>
                                    <td>
                                        <select name="sale_currency" class="form-control sale_currency">
                                            <option value="1" selected>￥</option>
                                            <option value="2">$</option>
                                            <option value="3">€</option>
                                        </select>   
                                    </td>
                                    <td>
                                        <input type="text" name="sale_rate" class="form-control sale_rate input_num" value="<?= $v->sale_rate ?>" autocomplete="off" style="width: 90px;" readonly="true">
                                    </td>
                                    <td><span class="sale_amount"><?= $sale_amount ?></span></td>
                                    <td><span class="sale_price_no_tax"><?= $sale_price_no_tax ?></span></td>
                                    <td><span class="sale_price_tax"><?= $sale_price_tax ?></span></td>
                                    <td><span class="sale_amount_no_tax"><?= $sale_amount_no_tax ?></span></td>
                                    <td><span class="sale_amount_tax"><?= $sale_amount_tax ?></span></td>
     
                                    <td><span class="profit_no_tax"><?= $profit_no_tax ?></span></td>
                                    <td><span class="profit_tax"><?= $profit_tax ?></span></td>
                                    <td><span class="profit_rate"><?= $profit_rate ?></span></td>

                                    <script>
                                        $('.sale_currency').val('<?= $v->sale_currency ?>');
                                        $('.picking_currency').val('<?= $v->picking_currency ?>');
                                    </script>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>    
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary add-quote-success" data-type="2">确认</button>
            </div>
        </div>
    </div>
</div>