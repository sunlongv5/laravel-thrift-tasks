<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userModalLabel">编辑基本资料</h4>
            </div>
            <div class="modal-body">
                <div class="box-section">
                    <div class="section-content base-edit-content">
                        <div class="row">
                            <div class="col-xs-2" style="width: 17%;">
                                <div class="form-group">    
                                    <label>来源：</label>                                  
                                    <select name="base-source" class="base-source" >
                                        @foreach (Config('config.customer_source') as $k=>$v)
                                            @if ($userInfo->source == $k) 
                                                <option value="{{$k}}" selected>{{$v}}</option>
                                            @else
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>      
                            </div>
                            
                            <div class="col-xs-2" style="width: 25%;">  
                                <div class="form-group">
                                    <label>线上渠道来源：</label>
                                    <input type="text" name="base-adtag" class="base-adtag" value="{{$userInfo->adtag}}">
                                </div>
                            </div>
                            
                            <div class="col-xs-2" style="width: 18%;">
                                <div class="form-group">
                                    <label>客户级别：</label>
                                    <select name="base-grade" class="base-grade" >
                                        @foreach (Config('config.customer_grade') as $k=>$v)
                                            @if ($userInfo->grade == $k) 
                                                <option value="{{$k}}" selected>{{$v}}</option>
                                            @else
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-2" style="width: 18%;">
                                <div class="form-group">
                                    <label>当前状态：</label>
                                    <select name="base-status" class="base-status" >
                                        @foreach (Config('config.customer_status') as $k=>$v)
                                            @if ($userInfo->status == $k) 
                                                <option value="{{$k}}" selected>{{$v}}</option>
                                            @else
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <label style="float: left;">账号信息：</label>

                                <div style="float: left; width: 90%;">
                                    <div class="col-xs-3" style="width: 25%;">
                                        <div class="form-group">
                                            <label>手机：</label>
                                            <input type="text" name="base-mobile" class="base-mobile" value="{{$userInfo->mobile}}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-3" style="width: 25%;">
                                        <div class="form-group">
                                            <label>邮箱：</label>
                                            <input type="text" name="base-email" class="base-email" value="{{$userInfo->email}}">
                                        </div>
                                    </div>

                                    <div class="col-xs-3" style="width: 25%;">
                                        <div class="form-group">
                                            <label>微信：</label>
                                            <input type="text" name="base-wechat" class="base-wechat" value="{{$userInfo->wechat}}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-3" style="width: 25%;">
                                        <div class="form-group">
                                            <label>QQ：</label>
                                            <input type="text" name="base-qq" class="base-qq" value="{{$userInfo->qq}}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary user_edit">确认</button>
            </div>
        </div>
    </div>
</div>