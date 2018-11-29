<div class="row wrapper border-bottom white-bg page-heading">
  <a class="navbar-minimalize minimalize-styl-2 btn btn-primary pull-left" style="margin-left:0px;margin-top:18px;" href="#"><i class="fa fa-bars"></i> </a>
  <div class="col-lg-10" style="padding-left:0px;">
    <h2>{{ $title }}</h2>
    <ol class="breadcrumb">
      @for ($i = 0; $i < count($paths); $i++)
        @if ($i != count($paths) - 1)
          <li><a href="{{ $paths[$i]["href"] }}">{{ $paths[$i]["title"] }}</a></li>
        @else
          <li class="active"><a>{{ $paths[$i]["title"] }}</a></li>
        @endif
      @endfor
    </ol>
    
    @if (isset($com_name))
    <div style="margin-top: 10px;">
        <p>公司名称：{{$com_name}}</p>
    </div>
    @endif
  </div>

  <style>
    .show-msg{float: right; width: 120px; margin-top: 20px;}
    .show-msg-details{display: none; position: absolute; top: 40px; right: 0px; width: 500px; height:240px; border: 1px solid #e7eaec; background: #fff; z-index: 2; padding-left: 0px; overflow: auto; overflow-x: hidden;}
    .show-msg-details li{list-style: none; padding: 5px 10px; height: 35px; line-height: 20px; border-bottom: 1px solid #e7eaec;}
    .show-msg-details li:hover{background: #e7eaec;}
    .show-msg-details li p{float: left;}
  </style>

  <div  class="show-msg">  
    <a href="javascript:;">
      <i class="fa fa-bell-o"></i>
      <span>系统通知</span>
      ( <span style="color:#ffa200;">{{$systemMsg['count']}}</span> )
    </a> 

    <div style="padding: 10px;">
      <ul class="show-msg-details">
        @if (!empty($systemMsg['list']))
          @foreach ($systemMsg['list'] as $v)
                  <?php
                      if(!isset($v['next_time'])) continue;
                  ?>
            <li>
              <input type="hidden" name="show-content" class="show-content" value="{{date('Y-m-d H:i:s', isset($v['next_time'])?$v['next_time']:'0')}}">
              <input type="hidden" name="msg-log-status" class="msg-log-status" value="{{$v['status']}}">     
              <p class="show-title" style="width: 120px;">跟进事项：<span class="show-subject">{{$v['next_details']}}</span></p>
              <p class="send-time" style="width: 200px;">推送时间：<span class="show-time">{{date('Y-m-d H:i:s', $v['create_time'])}}</span></p>
              <p style="width: 140px;">
                <a class="btn btn-xs btn-info msg-view" data-uid="{{$v['user_id']}}" data-mid="{{$v['msg_log_id']}}">查看</a>
                <a class="btn btn-xs btn-danger msg-del" data-uid="{{$v['user_id']}}" data-mid="{{$v['msg_log_id']}}">删除</a>
                @if ($v['status'] == 1) 
                  <a class="btn btn-xs btn-primary msg-read" data-uid="{{$v['user_id']}}" data-mid="{{$v['msg_log_id']}}">标记已读</a>
                @endif
              </p>
            </li>
          @endforeach
        @else
          <li style="text-align: center;">暂无通知</li>
        @endif
      </table>
    </div>
  </div>
</div>

<script>
  $('.show-msg').mouseover(function(){
    $('.show-msg-details').show();
  }).mouseout(function(){
    $('.show-msg-details').hide();
  })

  // 查看
  $('.msg-view').click(function(){
    var user_id = $(this).data('uid');
    var mid = $(this).data('mid');
    var show_subject = $(this).parent().siblings('.show-title').children('.show-subject').text();
    var show_content = $(this).parent().siblings('.show-content').val();
    var show_time = $(this).parent().siblings('.send-time').children('.show-time').text();
    var status = $(this).parent().siblings('.msg-log-status').val();

    var content = '<div class="form-group">'+
                      '<p style="word-break:break-all;">下次跟进事项：'+show_subject+'</p>'+
                      '<p>下次跟进时间：'+show_content+'</p>'+
                      '<p>消息推送时间：'+show_time+'</p>'+
                  '</div>';

    layer.open({
      area: ['500px', '300px'],
      title: '查看系统通知',
      content: content,
      btn: [],
      cancel: function(index, layero){ // 关闭按钮添加事件
        if (status == 1) {
          $.ajax({
              url : '/ajax/ajaxReadMsgLog',
              type: 'post',
              data: {user_id : user_id, mid : mid},
              success : function (resp) {
                  if (resp.err_code == 0) {
                      setTimeout(function(){
                          location.reload();
                      }, 1000);
                  }

                  layer.msg(resp.err_msg);
                  return false;
              },
              error : function (err) {
                  console.log(err)
              }
          })
        } else {
          layer.close(index);
        }
      },
    })
  })

  // 删除
  $('.msg-del').click(function(){
    var user_id = $(this).data('uid');
    var mid = $(this).data('mid');

    layer.open({
      title: '删除系统通知',
      content: '确定删除该条系统通知吗？',
      btn : ['确认', '取消'],
      btn1 : function (index) {
          $.ajax({
              url : '/ajax/ajaxDelMsgLog',
              type: 'post',
              data: {user_id : user_id, mid : mid},
              success : function (resp) {
                  if (resp.err_code == 0) {
                      layer.msg(resp.err_msg);
                      setTimeout(function(){
                          location.reload();
                      }, 1000);
                  }

                  layer.msg(resp.err_msg);
                  return false;
              },
              error : function (err) {
                  console.log(err)
              }
          })
      },
      btn2 : function () {
          layer.close(index);
      },
    })
  })

  // 标记
  $('.msg-read').click(function(){
    var user_id = $(this).data('uid');
    var mid = $(this).data('mid');

    layer.open({
      title: '标记系统通知',
      content: '确定标记该条系统通知吗？',
      btn : ['确认', '取消'],
      btn1 : function (index) {
          $.ajax({
              url : '/ajax/ajaxReadMsgLog',
              type: 'post',
              data: {user_id : user_id, mid : mid},
              success : function (resp) {
                  if (resp.err_code == 0) {
                      layer.msg(resp.err_msg);
                      setTimeout(function(){
                          location.reload();
                      }, 1000);
                  }

                  layer.msg(resp.err_msg);
                  return false;
              },
              error : function (err) {
                  console.log(err)
              }
          })
      },
      btn2 : function () {
          layer.close(index);
      },
    })
  })
</script>


