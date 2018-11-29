<div class="modal fade" id="addQuoteModal" tabindex="-1" role="dialog" aria-labelledby="addQuoteModalLabel">
    <div class="modal-dialog" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addQuoteModalLabel">新增报价</h4>
            </div>
            <div class="modal-body" style="padding-left: 10px; padding-right: 10px;">
                <form class="form-inline addQuoteForm">
                    <div class="table-responsive">
                        <table class="table text-nowrap add-quote-table">
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
                                        <input type="hidden" name="quote[0][goods_id]" class="form-control goods_id" value="">
                                        <input type="text" name="quote[0][goods_name]" class="form-control goods_name" value="" required autocomplete="off" style="width: 120px;">
                                        <div class="show-query-box"></div> 
                                    </td>
                                    <td>
                                        <input type="hidden" name="quote[0][brand_id]" class="form-control brand_id" value="">
                                        <input type="text" name="quote[0][brand_name]" class="form-control brand_name" value="" required autocomplete="off" style="width: 120px;">
                                        <div class="show-query-box"></div>
                                    </td>
                                    
                                    <td>
                                        <input type="text" name="quote[0][picking_num]" class="form-control picking_num input_num" value="" required autocomplete="off" style="width: 90px;"> 
                                    </td>
                                    <td>
                                        <input type="text" name="quote[0][picking_price]" class="form-control picking_price input_num" value="" autocomplete="off" style="width: 90px;">    
                                    </td>
                                    <td>                                
                                        <select name="quote[0][picking_currency]" class="form-control picking_currency">
                                            <option value="1" selected>￥</option>
                                            <option value="2">$</option>
                                            <option value="3">€</option>
                                        </select>
                                    </td>           
                                    <td>
                                        <input type="text" name="quote[0][picking_rate]" class="form-control picking_rate input_num" value="1" autocomplete="off" style="width: 90px;" readonly="true">
                                    </td>
                                    <td><span class="picking_amount"></span></td>
                                    <td><span class="picking_price_no_tax"></span></td>
                                    <td><span class="picking_price_tax"></span></td>
                                    <td><span class="picking_amount_no_tax"></span></td>
                                    <td><span class="picking_amount_tax"></span></td>

                                    <td>
                                        <input type="text" name="quote[0][sale_num]" class="form-control sale_num input_num" value="" required autocomplete="off" style="width: 90px;"> 
                                    </td>
                                    <td>                                
                                        <input type="text" name="quote[0][sale_price]" class="form-control sale_price input_num" value="" required autocomplete="off" style="width: 90px;">
                                    </td>
                                    <td>
                                        <select name="quote[0][sale_currency]" class="form-control sale_currency">
                                            <option value="1" selected>￥</option>
                                            <option value="2">$</option>
                                            <option value="3">€</option>
                                        </select>   
                                    </td>
                                    <td>
                                        <input type="text" name="quote[0][sale_rate]" class="form-control sale_rate input_num" value="1" autocomplete="off" style="width: 90px;" readonly="true">
                                    </td>
                                    <td><span class="sale_amount"></span></td>
                                    <td><span class="sale_price_no_tax"></span></td>
                                    <td><span class="sale_price_tax"></span></td>
                                    <td><span class="sale_amount_no_tax"></span></td>
                                    <td><span class="sale_amount_tax"></span></td>
     
                                    <td><span class="profit_no_tax"></span></td>
                                    <td><span class="profit_tax"></span></td>
                                    <td><span class="profit_rate"></span></td>
                                    
                                    <td style="vertical-align: middle;">
                                        <a class="btn btn-danger btn-xs add-quote-row-del">删除</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>    
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-info add-new-quote">新增报价</button>
                <button type="button" class="btn btn-primary add-quote-success" data-type="1">确认</button>
            </div>
        </div>
    </div>
</div>