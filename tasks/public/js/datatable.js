datatable = { };

(function () {

function schemabuild(fid)
{
  var tableconfig = { };
  tableconfig.type = 1;     // 1 创建; 2 编辑; 3 恢复

  var queryUrl='';          //
  var succUrl ='';          //
  var fieldsData = null;    //

  function $$(id)
  {
    return $('#' + fid + '_' + id);
  }

  function GetFieldsConfig()
  {
    var fields = {};
    $$('fieldconfig_table tbody tr').each(function() {
      var fielddef = $(this).data('fielddef');
      if (fielddef == null || fielddef == undefined || fielddef.name == undefined)
        return;
      fields[fielddef.name] = fielddef;
    });

    return fields;
  }

  function showError(errmsg, error)
  {
    errmsg = "提交失败, 错误信息: " + errmsg + "。";

    var title = {
      table_id : "数据表id",
      title    : "标题",
      host     : "数据库地址",
      port     : "数据库端口",
      username : "数据库用户名",
      passwd   : "数据库密码",
      dbname   : "数据库名",
      tablename: "数据表名",
      description: "详细说明",
      readers  : "读权限用户",
      writers  : "写权限用户",
      keyfield : "主键字段名",
      sortfield: "默认排序字段名",
      groupfield:"分组字段名",
      fields : "字段配置"
    };

    if (error) {
      var i = 0;
      for (var name in error) {
        i++;
        errmsg += i + ". " + title[name] + ": " + error[name] + ";";
      }
    }

    $$('submit_msg').text(errmsg).css('display', 'inline');
  }

  // 提交数据
  function Submit()
  {
    $$('submit_msg').hide();
    var bu = $$('button_submit').ladda();
    var config = {
      table_id : $$('table_id').val(),
      title    : $.trim($$('title').val()),
      host     : $.trim($$('host').val()),
      port     : $.trim($$('port').val()),
      username : $.trim($$('username').val()),
      passwd   : $.trim($$('passwd').val()),
      dbname   : $.trim($$('dbname').val()),
      tablename: $.trim($$('tablename').val()),
      description: $.trim($$('description').val()),
      readers  : $$('readers').val(),
      writers  : $$('writers').val(),
      keyfield : $$('keyfield').val(),
      sortfield: $$('sortfield').val(),
      groupfield:$$('groupfield').val(),
      fields : GetFieldsConfig()
    };

    if (config.readers == null)
      config.readers = [];
    if (config.writers == null)
      config.writers = [];
    if (config.keyfield == null)
      config.keyfield = [];
    if (config.sortfield == null)
      config.sortfield = [];
    if (config.groupfield == null)
      config.groupfield = [];

    bu.ladda('start');
    var url = '';
    if (tableconfig.type == 1) { // new
      url = '/api/dbmanager/create/0';
    } else if (tableconfig.type == 2) { // update
      url = '/api/dbmanager/update/0';
    } else if (tableconfig.type == 3) {
      url = '/api/dbmanager/rollback/0'
    }

    $.ajax({
      type: "POST",
      url: url,
      data: { data: JSON.stringify(config) },
      dataType: 'json',
      success: function (data) {
        if (data.errcode !== null && data.errcode !== undefined && data.errcode != 0) {
          showError(data.errmsg, data.error);
          return;
        }

        $$('submit_msg').text("提交成功!");
        $$('submit_msg').css('display', 'inline');

        if (tableconfig.success)
          tableconfig.success();

        setTimeout(function(){
          tableconfig.Reset();
          bu.prev().trigger("click");
        }, 1500);
      },
      error: function () {
        $$('submit_msg').text("提交失败，请重试!");
        $$('submit_msg').css('display', 'inline');
      },
      complete: function () {
        bu.ladda('stop');
      }
    });
  };

  function UpdateFieldOptions(fields)
  {
      var html = '';
      for (var fname in fields) {
        html += '<option value="' + fname + '">' + fname + '</option>';
      }

      var kval = $$('keyfield').val();
      $$('keyfield').html(html).val(kval).trigger('chosen:updated');

      var sval = $$('sortfield').val();
      $$('sortfield').html(html).val(sval).trigger('chosen:updated');

      var gval = $$('groupfield').val();
      $$('groupfield').html(html).val(gval).trigger('chosen:updated');

      $$('fieldconfig_name').html(html).val('');

      var fielddefs = GetFieldsConfig();
      $$('fieldconfig_name option').each(function () {
        var val = $(this).val();
        if (fielddefs[val] != undefined && fielddefs[val].name == val) {
          $(this).attr('style', 'display:none');
        }
      });
  }

  function UpdateFieldBySelect(id, fields)
  {
      var html = '';
      for (var i = 0; i < fields.length; i++)
        html += '<option value="' + fields[i] + '">' + fields[i] + '</option>';
      $$(id).html(html).val(fields).trigger('chosen:updated');
  }

  function GetTableSchemaByConfig(host, port, user, passwd, dbname, tablename)
  {
    var url = host + ':' + port + ':' + user + ':' + passwd + ':' + dbname + ':' + tablename;
    if (url == queryUrl || url == succUrl)
      return;

    queryUrl = url;
    $.ajax({
      url : '/api/dbmanager/schema',
      data: {host:host,port:port,user:user,passwd:passwd,dbname:dbname,table:tablename},
      dataType: "json",

      success: function (data) {
        var host      = $.trim($$('host').val());
        var port      = $.trim($$('port').val());
        var user      = $.trim($$('username').val());
        var passwd    = $.trim($$('passwd').val());
        var dbname    = $.trim($$('dbname').val());
        var tablename = $.trim($$('tablename').val());

        if (host != data.host || port != data.port || user != data.user ||
            passwd != data.passwd || dbname != data.dbname || tablename != data.table) {
          return;
        }

        succUrl = host + ':' + port + ':' + user + ':' + passwd + ':' + dbname + ':' + tablename;
        if (data.errcode !== undefined && data.errcode !== null && data.errcode != 0) {
          toastr['error'](data.errmsg, '数据库配置错误');
          fieldsData = null;
          return;
        }

        UpdateFieldOptions(data.fields);

        fieldsData = data.fields;
      },
      complete: function() {
        queryUrl = '';
      }
    });
  }

  // 获取数据表的schema
  function GetTableSchema()
  {
    var host      = $.trim($$('host').val());
    var port      = $.trim($$('port').val());
    var user      = $.trim($$('username').val());
    var passwd    = $.trim($$('passwd').val());
    var dbname    = $.trim($$('dbname').val());
    var tablename = $.trim($$('tablename').val());

    if (host.length < 2 || port.length < 3 || user.length < 2 ||
        passwd.length < 2 || dbname.length < 2 || tablename.length < 2)
      return;

    GetTableSchemaByConfig(host, port, user, passwd, dbname, tablename);
  }


  function FieldSelectName()
  {
    var name = $$('fieldconfig_name').val();

    if (name == null || name == undefined || name.length <= 0)
      return;
    if (fieldsData == null || Object.getOwnPropertyNames(fieldsData).length <= 0)
      return;

    var el = 0;
    var order = 0;
    for (el in fieldsData) {
      order++;
      if (fieldsData[el].name != name)
        continue;
      break;
    }

    var field = fieldsData[el];

    $$('fieldconfig_def').val(field.default_val);
    $$('fieldconfig_order').val(order);
    $$('fieldconfig_desc').val(field.comment);
    if (field.type == 'int') {
      if (field.extra == 'auto_increment')
        $$('fieldconfig_type').val("10");
      else
        $$('fieldconfig_type').val("11");
    } else if (field.type == 'string') {
      $$('fieldconfig_type').val("30");
    } else if (field.type == 'date') {
      $$('fieldconfig_type').val("20");
    } else if (field.type == 'datetime') {
      $$('fieldconfig_type').val("21");
    } else if (field.type == 'float') {
      $$('fieldconfig_type').val("13");
    } else {
      $$('fieldconfig_type').val("30");
    }
  }

  function Reset()
  {
    queryUrl = '';
    succUrl ='';
    fieldsData = null;

    // 基本配置清除
    $$('table_id').val("").parent().parent().hide();
    $$('title').val("");
    $$('host').val("");
    $$('port').val("");
    $$('username').val("");
    $$('passwd').val("");
    $$('dbname').val("");
    $$('tablename').val("");
    $$('readers').val([]).trigger("chosen:updated");
    $$('writers').val([]).trigger("chosen:updated");
    $$('keyfield').val("").html('<option value=""></option>').trigger("chosen:updated");
    $$('sortfield').val("").html('<option value=""></option>').trigger("chosen:updated");
    $$('groupfield').val("").html('<option value=""></option>').trigger("chosen:updated");

    // tableconfig清除
    $$('fieldconfig_table tbody').html("");
    $$('fieldconfig_table').trigger('footable_initialize');
    $$('fieldconfig_table').parent().parent().hide();
    $$('fieldconfig_label').text($$('fieldconfig_label').attr('data-label'));

    $$('description').val("");

    // tableconfig表单重置
    $$('fieldconfig_name').html('<option disabled="disabled">请先填写数据库配置</option>').val("");
    $$('fieldconfig_title').val("");
    $$('fieldconfig_order').val("");
    $$('fieldconfig_type').val("0");
    $$('fieldconfig_hide').prop('checked', false);
    $$('fieldconfig_islist').prop('checked', false);
    $$('fieldconfig_need').prop('checked', false);
    $$('fieldconfig_def').val("");
    $$('fieldconfig_desc').val("");
    $$('fieldconfig_extend').hide();
    $$('fieldconfig_int_extend').hide();
    $$('fieldconfig_min').val("");
    $$('fieldconfig_max').val("");
    $$('fieldconfig_str_extend').hide();
    $$('fieldconfig_minlen').val("");
    $$('fieldconfig_maxlen').val("");
    $$('fieldconfig_remoteurl').val("").hide();

    $$('fieldconfig_dict_key').val("");
    $$('fieldconfig_dict_name').val("");

    $$('fieldconfig_dict').append("");
    $$('fieldconfig_dict').data('dict', []);
    $$('fieldconfig_dict').parent().parent().parent().hide();
    $$('fieldconfig_dict_lable').text($$('fieldconfig_dict_lable').attr('data-label'));
    $$('submit_msg').hide();
  }

  tableconfig.Init = function()
  {
    // 设置提交按钮的事件
    $$('button_submit').ladda().click(Submit);
    $$('button_close').click(Reset);
    $$('keyfield').chosen({
      no_results_text: "请先填写数据库配置",
      placeholder_text_multiple: " ",
      width:"100%"
    });

    $$('sortfield').chosen({
      no_results_text: "请先填写数据库配置",
      placeholder_text_multiple: " ",
      width:"100%"
    });

    $$('groupfield').chosen({
      no_results_text: "请先填写数据库配置",
      placeholder_text_multiple: " ",
      width:"100%"
    });

    $$('fieldconfig_show').chosen({
      placeholder_text_multiple: " ",
      width:"100%"
    });

    $$('writers').ajaxChosen({
      dataType: 'json',
      type: 'GET',
      url:'/api/user/search'
    },
    {
      loadingImg: 'js/plugins/chosen-ajax-addition/loading.gif',
    },
    {
      no_results_text: "找不到对应用户",
      placeholder_text_multiple: " ",
      width:"644px"
    });

    $$('readers').ajaxChosen({
      dataType: 'json',
      type: 'GET',
      url:'/api/user/search'
    },
    {
      loadingImg: 'js/plugins/chosen-ajax-addition/loading.gif',
    },
    {
      no_results_text: "找不到对应用户",
      placeholder_text_multiple: " ",
      width:"644px"
    });

    $$('fieldconfig_name').val("");

    toastr.options = {
      closeButton: true,
      debug: false,
      progressBar: false,
      preventDuplicates: false,
      positionClass: 'toast-top-right',
      onclick: null,
      showDuration: "400",
      hideDuration: "1000",
      timeOut: "7000",
      extendedTimeOut: "1000",
      showEasing: 'swing',
      hideMethod: 'fadeOut',
      escapeHtml: true,
      hideEasing: 'linear',
      showMethod: 'fadeIn',
      hideMethod: 'fadeOut'
    };

    $$('host').blur(GetTableSchema);
    $$('port').blur(GetTableSchema);
    $$('username').blur(GetTableSchema);
    $$('passwd').blur(GetTableSchema);
    $$('dbname').blur(GetTableSchema);
    $$('tablename').blur(GetTableSchema);
    $$('keyfield_chosen input').focus(GetTableSchema);
    $$('fieldconfig_name').focus(GetTableSchema);

    $$('tableconfig').validate();
    $$('fieldconfig_table').footable();

    $$('fieldconfig_name').change(FieldSelectName);

    $$('fieldconfig_add_dict').click(function () { tableconfig.AddDict(); });
    $$('fieldconfig_add_fieldrow').click(function () { tableconfig.AddFieldRow(); });
  };

  function DelFieldRow($tr)
  {
    var fielddef = $tr.data('fielddef');
    $$('fieldconfig_name option').each(function() {
      var $this = $(this);

      if ($this.val() == fielddef.name)
        $this.attr('style', '');
    });

    $next = $tr.next();
    if ($next.hasClass('footable-row-detail'))
      $next.remove();
    $tr.remove();

    var $table = $$('fieldconfig_table');
    $table.trigger('footable_initialize');

    if ($($table.children('tbody')[0]).children('tr').length == 0) {
      $table.parent().parent().hide();
      $$('fieldconfig_label').text($$('fieldconfig_label').attr('data-label'));
    }
  }

  function EditFieldRow($tr)
  {
    var fielddef = $tr.data('fielddef');
    $$('fieldconfig_name').val(fielddef.name);
    $$('fieldconfig_title').val(fielddef.title);
    $$('fieldconfig_order').val(fielddef.order);
    $$('fieldconfig_def').val(fielddef.def);
    $$('fieldconfig_desc').val(fielddef.desc);

    $$('fieldconfig_hide').prop('checked', fielddef.ishide);
    $$('fieldconfig_islist').prop('checked', fielddef.islist);
    $$('fieldconfig_need').prop('checked', fielddef.need);

    var dict = fielddef.dict;
    if (fielddef.dict) {
      for (var i = 0; i < dict.length; i++) {
        var $li = $('<li class="search-choice">');
        $li.data('dict', {key:dict[i].key, name:dict[i].name});

        var $span = $('<span></span>');
        $span.text(dict[i].key + ":" + dict[i].name);
        $li.append($span);

        var $a = $('<a class="search-choice-close"></a>');
        $a.click(function() {
          var val = $li.data('dict');
          var dict = $$('fieldconfig_dict').data('dict');
          var newdict = [];
          for (var i = 0; i < dict.length; i++) {
            if (dict[i].key != val.key)
              newdict.push(dict[i]);
          }

          $$('fieldconfig_dict').data('dict', newdict);
          $li.remove();
        });

        $li.append($a);
        $$('fieldconfig_dict').append($li);
      }

      if (fielddef.dict.length > 0)
        $$('fieldconfig_dict').parent().parent().parent().show();

      $$('fieldconfig_dict').data('dict', fielddef.dict);
    }

    $$('fieldconfig_type').val(fielddef.type);

    DelFieldRow($tr);
  }

  function AddFieldRowByContext(fielddef)
  {
    var $tr = $('<tr></tr>');
    $tr.data('fielddef', fielddef);

    $tr.append('<td>' + fielddef.order + '</td>');

    var $name = $('<td></td>');
    $name.text(fielddef.name);
    $tr.append($name);

    var $title = $('<td></td>');
    $title.text(fielddef.title);
    $tr.append($title);

    var $type = $('<td></td>');
    var $typename = $('<span class="label label-primary"></span>');
    $typename.text(GetTypename(fielddef.type));
    $type.append($typename);

    if (fielddef.ishide) {
      var $hide = $('<span class="label label-danger">隐藏</span>');
      $type.append($hide);
    }

    if (fielddef.islist) {
      var $list = $('<span class="label label-warning">列表</span>');
      $type.append($list);
    }

    if (fielddef.need) {
      var $list = $('<span class="label label-warning">必填</span>');
      $type.append($list);
    }

    $tr.append($type);

    var $def = $('<td></td>');
    $def.text(fielddef.def);
    $tr.append($def);

    var $extend = $('<td></td>');
    $tr.append($extend);

    var $dict = $('<td></td>');
    if (fielddef.dict && fielddef.dict.length > 0) {
      var $dictdiv = $('<div class="chosen-container chosen-container-multi"></div>');
      var $dictul  = $('<ul class="chosen-choices" style="border-width:0px;"></ul>');

      for (var i = 0; i < fielddef.dict.length; i++) {
          var $vli = $('<li class="search-choice">');
          var $vspan = $('<span></span>');
          $vspan.text(fielddef.dict[i].key + ":" + fielddef.dict[i].name);
          $vli.append($vspan);

          $dictul.append($vli);
      }

      $dictdiv.append($dictul);
      $dict.append($dictdiv);
    }

    $tr.append($dict);

    var $desc = $('<td></td>');
    $desc.text(fielddef.desc);
    $tr.append($desc);

    var $opt = $('<td></td>');
    var $delb = $('<a class="btn btn-xs btn-danger"><strong>删除</strong></a>');

    $delb.click(function () { DelFieldRow($tr); });
    $opt.append($delb);

    var $editb = $('<a class ="btn btn-xs btn-primary"><strong>编辑</strong></a>');
    $editb.click(function () { EditFieldRow($tr); });
    $opt.append($editb);
    $tr.append($opt);

    $$('fieldconfig_table tbody').prepend($tr);
  }

  function FieldTableReset()
  {
    $$('fieldconfig_name').val("");
    $$('fieldconfig_title').val("");
    $$('fieldconfig_order').val("");
    $$('fieldconfig_def').val("");
    $$('fieldconfig_desc').val("");
    $$('fieldconfig_type').val("");
    $$('fieldconfig_hide').prop('checked', false);
    $$('fieldconfig_islist').prop('checked', false);
    $$('fieldconfig_need').prop('checked', false);

    $$('fieldconfig_extend').hide();
    $$('fieldconfig_int_extend').hide();
    $$('fieldconfig_min').val("");
    $$('fieldconfig_max').val("");
    $$('fieldconfig_str_extend').hide();
    $$('fieldconfig_minlen').val("");
    $$('fieldconfig_maxlen').val("");
    $$('fieldconfig_remoteurl').val("").hide();

    $$('fieldconfig_dict_key').val("");
    $$('fieldconfig_dict_name').val("");
    $$('fieldconfig_dict').html("");
    $$('fieldconfig_dict').data('dict', []);
    $$('fieldconfig_dict').parent().parent().parent().hide();
    $$('fieldconfig_dict_lable').text($$('fieldconfig_dict_lable').attr('data-label'));
  }

  function BuildFieldTable(fielddefs)
  {
    $$('fieldconfig_table').parent().parent().show(0, function () {
      $$('fieldconfig_label').text("");

      for (var i in fielddefs) {
        AddFieldRowByContext(fielddefs[i]);

        $$('fieldconfig_name option').each(function() {
          if ($(this).val() == fielddefs[i].name) {
            $(this).attr('style', 'display:none');
          }
        });
      }

      $$('fieldconfig_table').trigger('footable_initialize');

      FieldTableReset();
    });
  }

  function GetTypename(typeid)
  {
    var typename = "";
    $$('fieldconfig_type option').each(function () {
      if ($(this).attr("value") == typeid)
        typename = $(this).text();
    });

    return typename;
  }

  tableconfig.AddFieldRow = function ()
  {
    var fielddef = {
      name  : $$('fieldconfig_name').val(),
      title : $.trim($$('fieldconfig_title').val()),
      order : $.trim($$('fieldconfig_order').val()),
      def   : $.trim($$('fieldconfig_def').val()),
      desc  : $.trim($$('fieldconfig_desc').val()),
      ishide: $$('fieldconfig_hide').is(':checked'),
      islist: $$('fieldconfig_islist').is(':checked'),
      need  : $$('fieldconfig_need').is(':checked'),
      dict  : $$('fieldconfig_dict').data('dict'),
      type  : $$('fieldconfig_type').val(),
    };

    // var list = $$('fieldconfig_listvalue').manifest('values');
    if (fielddef.name == null || fielddef.name == undefined || fielddef.name.length <= 0)
      return;
    if (fielddef.order.match(/^[0-9]+$/) == null)
      return;

    $$('fieldconfig_table').parent().parent().show(0, function () {
      $$('fieldconfig_label').text("");

      AddFieldRowByContext(fielddef);

      $$('fieldconfig_name option').each(function() {
        if ($(this).val() == fielddef.name) {
          $(this).attr('style', 'display:none');
        }
      });

      $$('fieldconfig_table').trigger('footable_initialize');

      FieldTableReset();
    });
  }

  tableconfig.AddDict = function()
  {
    var key = $.trim($$('fieldconfig_dict_key').val());
    var name= $.trim($$('fieldconfig_dict_name').val());
    var dict= $$('fieldconfig_dict').data('dict');

    if (dict == null || dict == undefined || !$.isArray(dict)) {
      dict = [];
      $$('fieldconfig_dict').data('dict', dict);
    }

    if (key == null || key == undefined || name == null || name == undefined)
      return;
    if (key.length == 0 || name.length == 0)
      return;

    for (var i = 0; i < dict.length; i++) {
      if (dict[i].key == key) {
        dict[i].name = name;
        $$('fieldconfig_dict li').each(function() {
          $this = $(this);
          if ($this.data('dict').key == key)
            $this.children('span').text(key + ":" + name);
        });

        $$('fieldconfig_dict_key').val("");
        $$('fieldconfig_dict_name').val("");
        return;
      }
    }

    var $li = $('<li class="search-choice">');
    $li.data('dict', {key:key, name:name});

    var $span = $('<span></span>');
    $span.text(key + ":" + name);
    $li.append($span);

    var $a = $('<a class="search-choice-close"></a>');
    $a.click(function() {
      var val = $li.data('dict');
      var dict = $$('fieldconfig_dict').data('dict');
      var newdict = [];
      for (var i = 0; i < dict.length; i++) {
        if (dict[i].key != val.key)
          newdict.push(dict[i]);
      }

      $$('fieldconfig_dict').data('dict', newdict);
      $li.remove();

      if (newdict.length == 0) {
        $$('fieldconfig_dict').parent().parent().parent().hide();
        $$('fieldconfig_dict_lable').text($$('fieldconfig_dict_lable').attr('data-label'));
      }
    });

    $li.append($a);

    $$('fieldconfig_dict').parent().parent().parent().show();
    $$('fieldconfig_dict_lable').text("");

    $$('fieldconfig_dict').append($li);
    $$('fieldconfig_dict_key').val("");
    $$('fieldconfig_dict_name').val("");

    dict.push({key:key, name:name});
  }

  // 重置整个表单
  tableconfig.Reset = Reset;

  function SetConfig(config)
  {
    $$('title').val(config.title);
    $$('host').val(config.host);
    $$('port').val(config.port);
    $$('username').val(config.username);
    $$('passwd').val(config.passwd);
    $$('dbname').val(config.dbname);
    $$('tablename').val(config.tablename);
    $$('description').val(config.description);

    if (config.readers != undefined && config.readers != null) {
      $$('readers').html("");
      for (var i = 0; i < config.readers.length; i++) {
        var $opt = $('<option></option>');
        $opt.attr("value", config.readers[i]);
        $opt.text(config.readers[i]);
        $$('readers').append($opt);
      }
      $$('readers').val(config.readers).trigger("chosen:updated");
    }

    if (config.writers != undefined && config.writers != null) {
      $$('writers').html("");
      for (var i = 0; i < config.writers.length; i++) {
        var $opt = $('<option></option>');
        $opt.attr("value", config.writers[i]);
        $opt.text(config.writers[i]);
        $$('writers').append($opt);
      }
      $$('writers').val(config.writers).trigger("chosen:updated");
    }

    if (config.keyfield != undefined && config.keyfield != null)
      UpdateFieldBySelect('keyfield', config.keyfield);
    if (config.sortfield != undefined && config.sortfield!= null)
      UpdateFieldBySelect('sortfield', config.sortfield);
    if (config.groupfield != undefined && config.groupfield != null)
      UpdateFieldBySelect('groupfield', config.groupfield);

    GetTableSchemaByConfig(config.host, config.port, config.username,
                           config.passwd, config.dbname, config.tablename);

    BuildFieldTable(config.fields);
  }

  tableconfig.Edit = function (config, readonly)
  {
    if (config.table_id == null || config.table_id == undefined)
      return false;

    tableconfig.type = 2;
    Reset();

    $$('table_id').parent().parent().show();
    $$('table_id').val(config.table_id);

    SetConfig(config);

    if (readonly)
      $('#' + tableconfig.ModalId() + ' button.ladda-button').hide();

    setTimeout(function(){
      $(window).trigger("resize");
    }, 100)
  }

  tableconfig.RollBack = function (config, readonly)
  {
    tableconfig.Edit(config, readonly);
    tableconfig.type = 3;
    $$('button_submit .ladda-label').text('回滚配置');
  }

  tableconfig.Clone = function (config)
  {
    tableconfig.type = 1;
    Reset();

    SetConfig(config);
    setTimeout(function(){
      $(window).trigger("resize");
    }, 100)
  }

  tableconfig.ModalId = function()
  {
    return fid + '_modal';
  }

  tableconfig.Create = function()
  {
    tableconfig.type = 1;
    Reset();

    setTimeout(function(){
      $(window).trigger("resize");
    }, 100)
  }

  var modalid = tableconfig.ModalId();
  var modalobj = document.getElementById(modalid);
  if (!modalobj) {
    var obj = $('#tableconfig_div').clone();
    obj.find('[id]').each(function () {
      var $this = $(this);
      var id = $this.attr('id');
      $this.attr('id', fid + '_' + id);
    });

    obj.attr('id', modalid);
    obj.css('display', 'none');

    $('body').append(obj);

    tableconfig.Init();
  }

  return tableconfig;
}

function formbuild(id, def)
{
  var obj = { };

  var formid = id;
  var fielddef = def;
  obj.type = 1; // 1 创建; 2 编辑; 3 恢复

  function BuildSelect(dict)
  {
      var $select = $('<select class="form-control"></select>');
      for (var i = 0; i < dict.length; i++) {
        var $opt = $('<option></option>');
        $opt.attr("value", dict[i].key);
        $opt.text(dict[i].name);
        $select.append($opt);
      }

      return $select;
  }

  function ResetItem(prop)
  {
    var id = '#' + formid + '_' + prop.name;

    if (prop.dict !== undefined && prop.dict != null && prop.dict.length > 0) {
      $(id).val("").trigger('chosen:updated');
    } else if (prop.islist && prop.type != 40 && prop.type != 50) {
      $(id).val("").manifest('remove');
    } else if (prop.type == 10) { // 自增量
      $(id).val("");
    } else if (prop.type == 11) { // 整数
      $(id).val("");
    } else if (prop.type == 12) { // 无符号整数
      $(id).val("");
    } else if (prop.type == 13) { // 浮点数
      $(id).val("");
    } else if (prop.type == 20) { // 日期
      $(id).val("");
    } else if (prop.type == 21) { // 日期时间
      $(id).val("");
    } else if (prop.type == 22) { // 时间戳
      $(id).val("");
    } else if (prop.type == 23) { // 修改时间
      $(id).val("");
    } else if (prop.type == 24) { // 创建时间
      $(id).val("");
    } else if (prop.type == 30) { // 字符串
      $(id).val("");
    } else if (prop.type == 31) { // Json
      $(id).val("");
    } else if (prop.type == 32) { // 长文本
      $(id).val("");
    } else if (prop.type == 40) { // 用户名
      $(id).val([]).trigger('chosen:updated');
    } else if (prop.type == 41) { // 修改者
      $(id).val("");
    } else if (prop.type == 42) { // 创建者
      $(id).val("");
    } else if (prop.type == 50) { // 自动补全
      $(id).val([]).trigger('chosen:updated');
    } else { // 未知
      return null;
    }
  }

  function CreateChosenOptions($obj, values)
  {
    if (!values)
      return;

    $obj.html("");
    if ($.isArray(values)) {
      for (var i = 0; i < values.length; i++) {
        var $opt = $('<option></option>').attr("value", values[i]).text(values[i]);
        $obj.append($opt);
      }
    } else {
        $obj.append($('<option></option>').attr("value", values).text(values));
    }
    $obj.val(values).trigger('chosen:updated');
  }

  function SetItemValue(prop, value)
  {
    var id = '#' + formid + '_' + prop.name;

    if (prop.dict !== undefined && prop.dict != null && prop.dict.length > 0) {
      $(id).val(value).trigger('chosen:updated');
    } else if (prop.islist && prop.type != 40 && prop.type != 50) {
      $(id).manifest('remove').manifest('add', value);
    } else if (prop.type == 10) { // 自增量
      $(id).val(value);
    } else if (prop.type == 11) { // 整数
      $(id).val(value);
    } else if (prop.type == 12) { // 无符号整数
      $(id).val(value);
    } else if (prop.type == 13) { // 浮点数
      $(id).val(value);
    } else if (prop.type == 20) { // 日期
      $(id).val(value);
    } else if (prop.type == 21) { // 日期时间
      $(id).val(value);
    } else if (prop.type == 22) { // 时间戳
      $(id).val(value);
    } else if (prop.type == 23) { // 修改时间
      $(id).val(value);
    } else if (prop.type == 24) { // 创建时间
      $(id).val(value);
    } else if (prop.type == 30) { // 字符串
      $(id).val(value);
    } else if (prop.type == 31) { // Json
      $(id).data('jsoneditor').set(value);
    } else if (prop.type == 32) { // 长文本
      $(id).val(value);
    } else if (prop.type == 40) { // 用户名
      CreateChosenOptions($(id), value);
    } else if (prop.type == 41) { // 修改者
      $(id).val(value);
    } else if (prop.type == 42) { // 创建者
      $(id).val(value);
    } else if (prop.type == 50) { // 自动补全
      CreateChosenOptions($(id), value);
    } else { // 未知
      return null;
    }
  }

  function GetItemValue(prop)
  {
    var id = '#' + formid + '_' + prop.name;

    if (prop.dict !== undefined && prop.dict != null && prop.dict.length > 0) {
      return $(id).val();
    } else if (prop.islist && prop.type != 40 && prop.type != 50) {
      var ret = $(id).manifest('values');
      return ret ? ret : [];
    } else if (prop.type == 10) { // 自增量
      return $(id).val();
    } else if (prop.type == 11) { // 整数
      return $(id).val();
    } else if (prop.type == 12) { // 无符号整数
      return $(id).val();
    } else if (prop.type == 13) { // 浮点数
      return $(id).val();
    } else if (prop.type == 20) { // 日期
      return $(id).val();
    } else if (prop.type == 21) { // 日期时间
      return $(id).val();
    } else if (prop.type == 22) { // 时间戳
      return $(id).val();
    } else if (prop.type == 23) { // 修改时间
      return $(id).val();
    } else if (prop.type == 24) { // 创建时间
      return $(id).val();
    } else if (prop.type == 30) { // 字符串
      return $(id).val();
    } else if (prop.type == 31) { // Json
      var ret = null;
      try {
        ret = $(id).data('jsoneditor').get();
      } catch (e) {
        ret = null;
      }
      return ret;
    } else if (prop.type == 32) { // 长文本
      return $(id).val();
    } else if (prop.type == 40) { // 用户名
      return $(id).val();
    } else if (prop.type == 41) { // 修改者
      return $(id).val();
    } else if (prop.type == 42) { // 创建者
      return $(id).val();
    } else if (prop.type == 50) { // 自动补全
      return $(id).val();
    } else { // 未知
      return null;
    }
  }

  function AddItemEvent(prop)
  {
    var id = '#' + formid + '_' + prop.name;

    if (prop.dict !== undefined && prop.dict != null && prop.dict.length > 0) {
      $(id).chosen({placeholder_text_multiple:" ", placeholder_text:" ", width: "100%"});
    } else if (prop.islist && prop.type != 40 && prop.type != 50) {
      $(id).manifest({separator: ' '}).focus(function() {
        $(id).manifest('container').addClass('mf_container_focus');
      }).blur(function () {
        $(id).manifest('container').removeClass('mf_container_focus');
      });
    } else if (prop.type == 10) { // 自增量
    } else if (prop.type == 11) { // 整数
    } else if (prop.type == 12) { // 无符号整数
    } else if (prop.type == 13) { // 浮点数
    } else if (prop.type == 20) { // 日期
      $(id).inputmask({mask:'9999-99-99'});
    } else if (prop.type == 21) { // 日期时间
      $(id).inputmask({mask:'9999-99-99 99:99:99'});
    } else if (prop.type == 22) { // 时间戳
      $(id).inputmask({mask:'9999-99-99 99:99:99'});
    } else if (prop.type == 23) { // 修改时间
      $(id).inputmask({mask:'9999-99-99 99:99:99'});
    } else if (prop.type == 24) { // 创建时间
      $(id).inputmask({mask:'9999-99-99 99:99:99'});
    } else if (prop.type == 30) { // 字符串
    } else if (prop.type == 31) { // Json
      var obj = document.getElementById(formid + '_' + prop.name);
      var editor = new JSONEditor(obj, {hideMenu: true, mode: 'code'});
      $(obj).data("jsoneditor", editor);
      editor.setText("{}");
    } else if (prop.type == 32) { // 长文本
    } else if (prop.type == 40) { // 用户名
      $(id).val([]).ajaxChosen(
        {dataType:'json',type:'GET',url:'/api/user/search'},
        {loadingImg: 'js/plugins/chosen-ajax-addition/loading.gif'},
        {no_results_text:"找不到对应用户",placeholder_text_multiple:" ",placeholder_text:" ",width:"100%"}
      );
    } else if (prop.type == 41) { // 修改者
    } else if (prop.type == 42) { // 创建者
    } else if (prop.type == 50) { // 自动补全
      $(id).val([]).ajaxChosen(
        {dataType:'json',type:'GET',url:'/api/user/search'},
        {loadingImg: 'js/plugins/chosen-ajax-addition/loading.gif'},
        {no_results_text:"找不到对应用户",placeholder_text_multiple:" ",placeholder_text:" ",width:"100%"}
      );
    } else { // 未知
      return null;
    }
  }

  function CreateItem(prop)
  {
    var itemid = formid + '_' + prop.name;
    var $div = $('<div class="form-group"></div>');

    var $label = $('<label class="col-sm-2 control-label"></label>');
    $label.text(prop.title);
    $div.append($label);

    var $input_div = $('<div class="col-sm-9"></div>');
    var $input_obj = null;
    if (prop.dict !== undefined && prop.dict != null && prop.dict.length > 0) {
      $input_obj = BuildSelect(prop.dict);
    } else if (prop.islist && prop.type != 40 && prop.type != 50) {
      $input_obj = $('<input type="text">');
    } else if (prop.type == 10) { // 自增量
      $input_obj = $('<input type="text" class="form-control" disabled placeholder="系统自动分配">');
    } else if (prop.type == 11) { // 整数
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 12) { // 正整数
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 13) { // 浮点数
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 20) { // 日期
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 21) { // 日期时间
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 22) { // 时间戳
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 23) { // 修改时间
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 24) { // 创建时间
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 30) { // 字符串
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 31) { // Json
      $input_obj = $('<div style="width:100%;height:300px;"></div>');
    } else if (prop.type == 32) { // 长文本
      $input_obj = $('<textarea class="form-control" rows="4" style="max-width:100%;"></textarea>');
    } else if (prop.type == 40) { // 用户名
      $input_obj = $('<select class="form-control"><option></option></select>');
    } else if (prop.type == 41) { // 修改者
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 42) { // 创建者
      $input_obj = $('<input type="text" class="form-control">');
    } else if (prop.type == 50) { // 自动补全
      $input_obj = $('<select class="form-control"><option></option></select>');
    } else { // 未知
      return null;
    }

    if (prop.islist && $input_obj.is("select"))
      $input_obj.attr("multiple", "multiple");

    $input_obj.attr("id", itemid);
    $input_div.append($input_obj);

    if (prop.desc != undefined && prop.desc != null && prop.desc.length > 0)
      $input_div.append($('<span class="help-block m-b-none"></span>').text(prop.desc));

    $div.append($input_div);

    return $div;
  }

  function showError(errmsg, error)
  {
    errmsg = "提交失败, 错误信息: " + errmsg + "。";

    if (error) {
      var i = 0;
      for (var name in error) {
        i++;
        errmsg += i + ". " + fielddef.fields[name].name + ": " + error[name] + ";";
      }
    }

    $('#' + formid + "_submitmsg").text(errmsg).css('display', 'inline');
  }


  // 提交数据
  function Submit()
  {
    var url = '';
    $('#' + formid + "_submitmsg").hide();
    var bu = $('#' + formid + "_submitbutton").ladda();

    if (obj.type == 1) { // new
      url = '/api/dbmanager/create/' + schema.table_id;
    } else if (obj.type == 2) {
      url = '/api/dbmanager/update/' + schema.table_id;
    } else if (obj.type == 3) {
      url = '/api/dbmanager/rollback/' + schema.real_schema.table_id;
    }

    bu.ladda('start');

    $.ajax({
      type: "POST",
      url: url,
      data: { data: JSON.stringify(obj.values()) },
      dataType: 'json',
      success: function (data) {
        if (data.errcode !== null && data.errcode !== undefined && data.errcode != 0) {
          showError(data.errmsg, data.error);
          return;
        }

        $('#' + formid + "_submitmsg").text("提失成功!").css('display', 'inline');

        if (obj.success)
          obj.success();

        setTimeout(function(){
          obj.Reset();
          bu.prev().trigger("click");
        }, 1500);
      },

      error: function () {
        $('#' + formid + "_submitmsg").text("提交失败，请重试!").css('display', 'inline');
      },
      complete: function () {
        bu.ladda('stop');
      }
    });
  };

  function BuildForm()
  {
    var fields = fielddef.fields;
    var $form = $('<form class="form-horizontal"></form>');

    $form.attr("id", formid);

    for (var i in fields) {
      var $obj = CreateItem(fields[i]);
      if ($obj)
        $form.append($obj);
    }

    $form.append('<div class="hr-line-dashed"></div>');

    var $subdiv = $('<div class="col-sm-10 col-sm-offset-2"></div>');
    var $button_close = $('<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>');
    $button_close.attr("id", formid + "_closbutton");
    $subdiv.append($button_close);

    var $button_submit = $('<button class="ladda-button btn btn-primary" data-style="slide-left"></button>');
    $button_submit.attr("id", formid + "_submitbutton");
    $button_submit.append('<span class="ladda-label">提交</span>');
    $button_submit.append('<span class="ladda-spinner"></span>');
    $button_submit.append('<div class="ladda-progress" style="width: 0px;"></div>');
    $subdiv.append($button_submit);
    var $msg = $('<p class="text-danger" style="display:none;"></p>');
    $msg.attr("id", formid + "_submitmsg");
    $subdiv.append($msg);

    $button_submit.click(Submit);

    $form.append($subdiv);

    return $form;
  }

  obj.ModalId = function ()
  {
    return formid + '_modal';
  }

  function BuildModal()
  {
    var modalid = obj.ModalId();
    var modalobj = document.getElementById(modalid);
    if (modalobj)
      return $(modalobj);

    var $modal = $('<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true"></div>');
    $modal.attr("id", formid + "_modal");

    var $mod_content = $('<div class="modal-dialog modal-lg"></div>');
    var $content = $('<div class="modal-content"></div>');
    $mod_content.append($content);

    var $header = $('<div class="modal-header" style="padding-bottom:0px;"></div>');
    $header.append('<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>');

    var $title = $('<h2 style="text-align:left;"></h2>');
    $title.text(fielddef.title);
    $header.append($title);

    $content.append($header);

    var $footer = $('<div class="modal-footer" style="text-align:left;"></div>');
    var $inbox  = $('<div class="ibox"></div>');
    $inbox.append(BuildForm());
    $inbox.append('<div style="min-height:60px;"></div>');

    $footer.append($inbox);
    $content.append($footer);
    $modal.append($mod_content);

    $('body').append($modal);

    for (var i in fielddef.fields)
      AddItemEvent(fielddef.fields[i]);

    return $modal;
  }

  obj.build = function (id, def)
  {
    formid = id;
    fielddef = def;
    return BuildModal();
  }

  obj.Reset = function ()
  {
    var model = BuildModal();

    for (var i in fielddef.fields)
      ResetItem(fielddef.fields[i]);
    return model;
  }

  obj.Edit = function (values, readonly)
  {
    var model = BuildModal();
    for (var i in fielddef.fields)
      SetItemValue(fielddef.fields[i], values[fielddef.fields[i].name]);

    if (fielddef.keyfield) {
      for (var i = 0; i < fielddef.keyfield.length; i++) {
        var id = '#' + formid + '_' + fielddef.keyfield[i];
        $(id).attr('disabled', 'disabled');
      }
    }
    obj.type = 2;

    if (readonly)
      $('#' + obj.ModalId() + ' button.ladda-button').hide();

    return model;
  }

  obj.RollBack = function (config, readonly)
  {
    obj.Edit(config, readonly);
    obj.type = 3;
    $('#' + formid + '_' + 'submitbutton .ladda-label').text('回滚配置');
  }

  obj.Clone = function (values)
  {
    var model = BuildModal();
    for (var i in fielddef.fields) {
      if (fielddef.fields[i].type == 10)
        continue;

      SetItemValue(fielddef.fields[i], values[fielddef.fields[i].name]);
    }
    obj.type = 1;

    return model;
  }

  obj.values = function ()
  {
    var values = { };
    for (var i in fielddef.fields) {
      var val = GetItemValue(fielddef.fields[i]);
      values[fielddef.fields[i].name] = val;
    }

    return values;
  }

  BuildModal();

  return obj;
}
var schema = null; // schema的配置
var reqseq = 0;

var totalnum  = 0;
var currPage  = 1;
var args      = "";
var totalPage = 1;
var datalist  = null;

var options = {
  pagecount:25,
  options:[],
  orderby:"",
  desc:"",
};

var LoadPageByNo = null;

function UserRight(data)
{
  if (schema.table_id != 0 && schema.table_id != 1)
    data = schema;
  if (!data)
    return 0;

  if (data.creater == window.login_user)
    return 2;
  if (data.writers && data.writers.length > 0) {
    for (var i = 0; i < data.writers.length; i++) {
      if (data.writers[i] == 'ALL' || data.writers[i] == window.login_user)
        return 2;
    }
  }

  if (data.readers && data.readers.length > 0) {
    for (var i = 0; i < data.readers.length; i++) {
      if (data.readers[i] == 'ALL' || data.readers[i] == window.login_user)
        return 1;
    }
  }

  return 0;
}

function BuildPagination(curr)
{
  var max = curr + 2;
  var min = curr - 2;

  if (min <= 1) {
    min = 1;
    max = min + 4;
  }

  if (max > totalPage) {
    max = totalPage;
    min = (max - 4) <= 0 ? 1 : max - 4;
  }

  var $ul = $('#datalist_pagination');
  $ul.html("");

  var $prev = $('<li class="paginate_button previous"></li>');
  if (curr == 1)
    $prev.addClass('disabled');
  var $prev_a = $('<a><i class="fa fa-chevron-left"></i></a>');
  $prev_a.click(LoadPrevPage);
  $prev.append($prev_a);
  $ul.append($prev);

  for (; min <= max; min++) {
    var $li = $('<li class="paginate_button"></li>');
    if (min == curr)
      $li.addClass('active');

    var $a = $('<a></a>');
    $a.text(min);
    $a.attr('href', '#' + min);
    $a.data('pageno', "" + min);
    $a.click(function () {
      var pageNo = $(this).data('pageno');
      var $ul = $('#datalist_pagination').children().each(function() {
        var $this = $(this);
        if ($this.hasClass('previous')) {
          if (pageNo > 1)
            $this.removeClass('disabled');
          if (pageNo <= 1)
            $this.addClass('disabled');
        }

        if ($this.hasClass('next')) {
          if (pageNo < totalPage)
            $this.removeClass('disabled');
          if (pageNo >= totalPage)
            $this.addClass('disabled');
        }

        $(this).removeClass('active');
      });

      LoadPageByNo(pageNo, true, false);
      $(this).parent().addClass('active');
    });

    $li.append($a);
    $ul.append($li);
  }

  var $next = $('<li class="paginate_button next"></li>');
  if (curr == totalPage)
    $next.addClass('disabled');
  var $next_a = $('<a><i class="fa fa-chevron-right"></i></a>');

  $next_a.click(LoadNextPage);
  $next.append($next_a);
  $ul.append($next);
}

function BuildTable()
{
  var $table = $('#datalist_table');
  $table.html("");
  var $thead = $('<thead></thead>');

  var $tr = $('<tr></tr>');
  var first = true;
  for (var i in schema.fields) {
    var prop = schema.fields[i];
    var $th = $('<th></th>');
    $th.text(prop.title && prop.title.length > 0 ? prop.title : prop.name);

    if (!prop.ishide && first) {
      $th.attr('data-toggle', "true");
      first = false;
    }

    if (prop.ishide) {
      $th.attr("data-hide", "all");
    } else {
      var found = false;
      if (schema.keyfield) {
        for (var j = 0; j < schema.keyfield.length; j++) {
          if (schema.keyfield[j] == prop.name) {
            found = true;
            break;
          }
        }
      }

      if (!found)
        $th.attr("data-breakpoints", "xs sm")
    }
    $tr.append($th);
  }

  $tr.append('<th>操作</th>');
  $thead.append($tr);

  $table.append($thead);
  $table.append('<tbody></tbody>');
  $table.append('<tfoot><tr><td colspan="100" class="footable-visible"></td></tr></tfoot>');

  $table.footable().on('footable_row_expanded', function (e) {
    var funcs = $(e.row).data('trigger_functions');
    if (funcs != undefined && funcs != null) {
      for (var i = 0; i < funcs.length; i++)
        funcs[i]();
      // $(e.row).data('trigger_functions', null);
    }
  });
  BuildPagination(1);
}

function SetNum(total, beg, end)
{
  $('#datalist_databeg').text(beg);
  $('#datalist_dataend').text(end);
  $('#datalist_datatotal').text(total);
}

function ConverValue(dict, value, type)
{
  if (dict !== undefined && dict != null && dict.length > 0) {
    for (var i = 0; i < dict.length; i++) {
      if (dict[i].key == value)
        return dict[i].name;
    }
  }

  if (type == 22 && value) {
    var d = new Date(parseInt(value) * 1000);
    return d.getFullYear() + '-' +  (d.getMonth() + 1) + '-' + d.getDate()
           + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
  }

  return value;
}

function historyKey(data)
{
  var key = data[schema.keyfield[0]];
  for (var i = 1; i < schema.keyfield.length; i++)
    key += ":" + data[schema.keyfield[i]];
  return key;
}

function BuildHistoryAction(index, $opt, data)
{
  var real = schema.real_schema;
  var right = UserRight(real);

  var $editb = $('<a class="btn btn-xs btn-outline btn-primary"><strong>修改前</strong></a>');
  $editb.click(function () {
    var modal = null;
    if (real.table_id == 0) {
      modal = schemabuild('tableconfig_edit_old_' + data.__his_old_content.table_id);
    } else {
      modal = formbuild('tableconfig_edit_old_' + reqseq + '_' + index, real);
    }

    modal.success = function () { LoadPageByNo(currPage, false, true); };
    modal.RollBack(data.__his_old_content, right != 2);
    $('#' + modal.ModalId()).modal('show');
  });

  if (data.__his_old_content)
    $opt.append($editb);

  $editb = $('<a class="btn btn-xs btn-outline btn-danger"><strong>修改后</strong></a>');
  $editb.click(function () {
    var modal = null;
    if (real.table_id == 0) {
      modal = schemabuild('tableconfig_edit_new_' + data.__his_new_content.table_id);
    } else {
      modal = formbuild('tableconfig_edit_new_' + reqseq + '_' + index, real);
    }

    modal.success = function () { LoadPageByNo(currPage, false, true); };
    modal.RollBack(data.__his_new_content, right != 2);
    $('#' + modal.ModalId()).modal('show');
  });

  if (data.__his_new_content)
    $opt.append($editb);
}

function BuildAction(index, $opt, data)
{
  var $del_c= $('<div class="dropdown" style="display:inline"></div>');
  var $delb = $('<a class="btn btn-xs btn-outline btn-danger" data-toggle="dropdown" aria-expanded="false"><strong>删除</strong></a>');

  $del_c.append($delb);
  var $delu = $('<ul class="dropdown-menu dropdown-user"style="padding-top:10px;padding-bottom:10px;"></ul>');
  var $deln = $('<li style="display:inline"><a style="display:inline;">取消</a></li>');
  $delu.append($deln);
  var $dely = $('<li style="display:inline"></li>')
  var $delyb= $('<a style="display:inline;"><span class="text-danger">确认</span></a>');
  $dely.append($delyb);
  $delu.append($dely);
  $del_c.append($delu);

  $delyb.click(function () {
    $.ajax({
      type: "POST",
      url: '/api/dbmanager/delete/' + schema.table_id,
      data: { data: JSON.stringify(data) },
      dataType: 'json',
      success: function (data) {
        if (data.errcode !== null && data.errcode !== undefined && data.errcode != 0) {
          toastr['error']('删除失败', data.errmsg);
          return;
        }

        toastr['success']('', '删除成功');
        LoadPageByNo(currPage, false, true);

        $('#datalist_table').data('footable').removeRow($tr);
      },

      error: function (xhr, errcode, errmsg) {
        toastr['error']('删除失败', errmsg);
      },

      complete: function () {
      }
    });
  });

  var right = UserRight(data);
  if (right == 2)
    $opt.append($del_c);

  var $cloneb = $('<a class="btn btn-xs btn-outline btn-warning"><strong>复制</strong></a>');
  $cloneb.click(function () {
    var modal = null;
    if (schema.table_id == 0) {
      modal = schemabuild('tableconfig_clone_' + data.table_id);
    } else {
      modal = formbuild('tableconfig_clone_' + reqseq + '_' + index, schema);
    }

    modal.Clone(data);
    modal.success = function () { LoadPageByNo(currPage, false, true); };

    $('#' + modal.ModalId()).modal('show');
  });

  if ((right == 2 || right == 1) && schema.table_id != 1)
    $opt.append($cloneb);

  var title = (right == 2) ? "编辑" : "查看";
  var $editb = $('<a class="btn btn-xs btn-outline btn-primary"><strong>' + title + '</strong></a>');
  $editb.click(function () {
    var modal = null;
    if (schema.table_id == 0) {
      modal = schemabuild('tableconfig_edit_' + data.table_id);
    } else {
      modal = formbuild('tableconfig_edit_' + reqseq + '_' + index, schema);
    }

    modal.success = function () { LoadPageByNo(currPage, false, true); };
    modal.Edit(data, right == 2 ? false : true);
    $('#' + modal.ModalId()).modal('show');
  });

  if (right == 2 || right == 1)
    $opt.append($editb);

  if (schema.table_id != 1 && schema.keyfield && schema.keyfield.length > 0) {
    var $infob = $('<a class="btn btn-xs btn-outline btn-success"><strong>日志</strong></a>');
    $infob.attr("href", '/database/history/' + schema.table_id + '/' + historyKey(data));
    if (right == 2 || right == 1)
      $opt.append($infob);
  }

  if (schema.table_id == 0) {
    var $infob = $('<a class="btn btn-xs btn-outline btn-success"><strong>数据</strong></a>');
    $infob.attr("href", '/database/' + data.table_id);
    if (right == 2 || right == 1)
      $opt.append($infob);
  }

  if (right == 2 && schema.table_id == 2) {
    var $setting = $('<a class="btn btn-xs btn-outline btn-success"><strong>配置</strong></a>');
    $setting.attr("href", "/setting/" + data.config_id);
    $opt.append($setting);
  }
}

function BuildDataRow(index, data)
{
  var $tr = $('<tr></tr>');

  var funcs = [];
  for (var i in schema.fields) {
    var prop = schema.fields[i];
    var $td = $('<td></td>');
    if (prop.islist) {
      if (data[prop.name] && data[prop.name].length > 0) {
        for (var j = 0; j < data[prop.name].length; j++)
          $td.append($('<span class="label"></span>').text(ConverValue(prop.dict, data[prop.name][j], prop.type)));
      }
    } else if (prop.type == 10) { // 自增量
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 11) { // 整数
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 12) { // 无符号整数
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 13) { // 浮点数
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 20) { // 日期
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 21) { // 日期时间
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 22) { // 时间戳
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 23) { // 修改时间
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 24) { // 创建时间
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 30) { // 字符串
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 31) { // Json
      var id = 'datalist_row_' + reqseq + '_' + index + '_' + prop.name;
      var $div = $('<div></div>');
      $div.addClass(id);
      funcs.push((function(json, id) {
        return function () {
          if ($(id).children().length != 0)
            return;

          console.log("new " + id);
          var newjf = new JsonFormater({
            dom: id,
            singleTab: "  ",
            tabSize: 1,
            imgCollapsed: "/img/Collapsed.gif",
            imgExpanded: "/img/Expanded.gif",
            quoteKeys:false
          });

          newjf.doFormat(json);
          newjf.collapseLevel(2);
        };
      })(data[prop.name], '#datalist_table .footable-row-detail .' + id));

      $td.append($div);
    } else if (prop.type == 32) { // 长文本
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 40) { // 用户名
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 41) { // 修改者
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 42) { // 创建者
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else if (prop.type == 50) { // 自动补全
      $td.text(ConverValue(prop.dict, data[prop.name], prop.type));
    } else { // 未知
      $td.text(ConverValue(prop.dict, data[prop.name], -1));
    }

    $tr.append($td);
    if (funcs.length > 0)
      $tr.data('trigger_functions', funcs);
  }

  var $opt = $('<td></td>');
  if (schema.table_id != 1) {
    BuildAction(index, $opt, data);
  } else {
    BuildHistoryAction(index, $opt, data);
  }

  $tr.append($opt);
  $tr.data('dbdata', data);

  return $tr;
}

function BuildTableData()
{
  if (datalist.total != undefined) {
    totalnum  = datalist.total;
    totalPage = Math.ceil(totalnum / options.pagecount);
  }

  var beg = parseInt(datalist.offset) + 1;
  var end = parseInt(datalist.offset) + datalist.list.length;
  if (end > totalnum)
    end = totalnum;
  if (beg > end)
    beg = end;
  SetNum(totalnum, beg, end);

  var $tbody = $($('#datalist_table tbody')[0]);

  $tbody.html("");
  var now = (new Date).getTime();
  for (var i = 0; i < datalist.list.length; i++) {
    $tbody.append(BuildDataRow(i, datalist.list[i]));
  }
  console.log("append end: " + (new Date).getTime() + "spend " + ((new Date).getTime() - now));

  $('#datalist_table').trigger('footable_initialize');
}

LoadPageByNo = function (page, noflushpage, force, func)
{
  var pageno = page;
  if (pageno > totalPage)
    pageno = totalPage;
  if (pageno < 1)
    pageno = 1;

  var offset = (pageno - 1) * options.pagecount;
  var params = {
    offset: offset,
    count: options.pagecount,
    options: options.options,
    orderby: options.orderby,
    desc: options.desc,
    gettotal: (pageno == 1 ? 1 : 0)
  };

  var paramstr = JSON.stringify(params);
  if (paramstr == args && force == false) // 是当前页; 不需要请求了
    return;

  console.log("load page " + pageno);
  currPage = parseInt(pageno);
  args = paramstr;

  reqseq++;
  var seq = reqseq;

  $.ajax({
    url: '/api/dbmanager/get/' + schema.table_id,
    type: 'GET',
    dataType: 'json',
    data: {
      offset: offset,
      count: options.pagecount,
      options: options.options,
      orderby: options.orderby,
      desc: options.desc,
      gettotal: (pageno == 1 ? 1 : 0)
    },
    success: function (data) {
      if (seq != reqseq) {
        return;
      }

      if ((data.errcode != null || data.errcode != undefined) && data.errcode != 0) { // 发生了错误
        toastr['error']("请求接口错误", data.errmsg);
        return;
      }

      datalist = data;
      BuildTableData();

      if (!noflushpage)
        BuildPagination(pageno);
    },
    error: function (xhr, status, err) {
      toastr['error']("请求接口错误", err);
    },
    complete: function() {
      if (func)
        func();
      console.log("currpage " + currPage);
    }
  });

  if (!noflushpage)
    BuildPagination(pageno);
}

function LoadNextPage()
{
  if (currPage >= totalPage)
    return;
  console.log("2: currPage " + currPage + 1);
  return LoadPageByNo(currPage + 1, false, false);
}

function LoadPrevPage()
{
  if (currPage == 0)
    return;
  return LoadPageByNo(currPage - 1);
}

function BuildFieldSelect(id, fields)
{
  var $select = $('#' + id);

  $select.html("");
  for (var i in fields) {
    var $opt = $('<option></option>');
    $opt.attr("value", fields[i].name);
    $opt.text(fields[i].title && fields[i].title.length > 0 ? fields[i].title : fields[i].name);
    $select.append($opt);
  }
}

function AddFilter()
{
  var field = $('#adv_search_field').val();
  var title = $('#adv_search_field option:selected').text();

  var op    = $('#adv_search_op').val();
  var opname= $('#adv_search_op option:selected').text();

  var val   = $.trim($('#adv_search_value').val());

  if (title.length == 0 || opname.length == 0 || val.length == 0)
    return;

  var $li   = $('<li></li>');
  $li.append($('<span class="label label-primary"></span>').text(title));
  $li.append($('<span class="label label-warning"></span>').text(opname));
  $li.append($('<span class="label"></span>').text(val));

  var $bu   = $('<button class="btn btn-danger btn-xs">删除</button>');
  $bu.click(function () { $li.remove(); });
  $li.append($bu);

  $li.data('filteroption', {name: field, op: op, value: val});

  $('#adv_search_filters').append($li);

  $('#adv_search_value').val("");
}

function SetFilter()
{
  var opts = [];

  $('#adv_search_filters li').each(function () {
    var opt = $(this).data('filteroption');
    if (opt)
      opts.push(opt);
  });

  options.options = opts;
  options.desc = $('#adv_search_order').val();
  options.orderby = $('#adv_search_order_field').val();
}

datatable.Init = function (config, firstpage, opts)
{
  schema = config;
  options.options = opts;

  $('#datalist_search_field').focus(function() {
    $('#datalist_search_value').addClass('form-control_focus');
  }).blur(function() {
    $('#datalist_search_value').removeClass('form-control_focus');
  });

  $('#datalist_search_value').focus(function() {
    $('#datalist_search_field').addClass('form-control_focus');
  }).blur(function() {
    $('#datalist_search_field').removeClass('form-control_focus');
  });

  // 修改一页大小配置
  $('#datalist_pageno').change(function() {
    options.pagecount = $('#datalist_pageno').val();
    LoadPageByNo(1, false, false);
  }).val(options.pagecount);

  // 按页码跳转按钮
  $('#datalist_go_button').click(function() {
    var pageno = $('#datalist_go_pageno').val();
    if (pageno.match(/^[0-9]+$/) == null) {
      $('#datalist_go_pageno').val("");
      return;
    }

    LoadPageByNo(pageno, false, false);
  });

  // 搜索按钮
  $('#datalist_search_button').click(function () {
    var field = $('#datalist_search_field').val();
    var value = $.trim($('#datalist_search_value').val());

    var op = null;
    if (field.length != 0 && value.length != 0) {
      for (var i in config.fields) {
        if (config.fields[i].name == field) {
          op = "LIKE";
          break;
        }
      }
    }

    options.options = [];
    if (op)
      options.options = [ { name:field, op: op, value: value } ];

    LoadPageByNo(1, false, false);
  });

  // 重置按钮
  $('#datalist_search_reset').click(function () {
    options.options = [],
    options.orderby = "",
    options.desc    = "",
    options.pagecount = 25;

    $('#datalist_pageno').val(25);
    $('#datalist_search_value').val("");

    LoadPageByNo(1, false, false);
  });

  // 创建字段列表下拉框
  BuildFieldSelect('datalist_search_field', config.fields);
  BuildFieldSelect('adv_search_field', config.fields);
  BuildFieldSelect('adv_search_order_field', config.fields);

  // 高级搜索配置
  // 清空按钮
  $('#adv_search_clear').click(function () {
    $('#adv_search_value').val("");
    $('#adv_search_filters').html("");
    $('#adv_search_order').val("");
    $('#adv_search_order_field').val("");
  });

  // 搜索按钮
  $('#adv_search_button').click(function () {
    SetFilter();

    LoadPageByNo(1, false, false);
    $('#adv_search_close').trigger('click');
  });

  // 添加搜索条件按钮
  $('#adv_search_add').click(function () {
    AddFilter();
  });

  $('#adv_search_field').val("");
  $('#adv_search_op').val("");
  $('#adv_search_value').val("");

  BuildTable();

  if (firstpage) {
      currPage = 1;
      datalist = firstpage;
      options.pagecount = datalist.count;
      $('#datalist_pageno').val(datalist.count);
      BuildTableData();
      BuildPagination(1);
  } else {
    LoadPageByNo(1, false, false, init);
  }

  var newmodal = null;
  $('#datalist_creater').click(function () {
    if (schema.table_id != 0 && UserRight() != 2)
      return;

    if (newmodal == null) {
      if (schema.table_id == 0) {
        newmodal = schemabuild('tableconfig_new_' + schema.table_id);
      } else {
        newmodal = formbuild('tableconfig_new_' + schema.table_id, schema);
      }
    }
    newmodal.success = function () { LoadPageByNo(currPage, false, true); };
    $('#' + newmodal.ModalId()).modal('show');
  });

  if (schema.table_id != 0 && UserRight() != 2) {
    $('#datalist_creater').attr("disabled", "disabled").css("opacity", "0").css("width", "0px");
  }

  if (schema.table_id == 0 || schema.table_id == 2 || UserRight() != 2) {
    $('#datalist_modify_schema').hide();
  } else {
    var editmodal = null;
    $('#datalist_modify_schema').click(function () {
      if (editmodal == null) {
        editmodal = schemabuild('tableconfig_modify_' + schema.table_id);
        editmodal.Edit(schema);
        editmodal.success = function () {
    	      location.reload();
        };
      }
      editmodal.success = function () { LoadPageByNo(currPage, false, true); };
      $('#' + editmodal.ModalId()).modal('show');
    }).show();
  }

  if (schema.table_id == 1 && options) // 隐藏选项
    $('.ibox-title').hide();
}
})();

$(document).ready(function () {
  if (window.tableschema && window.firstpage) {
    datatable.Init(window.tableschema, window.firstpage, window.options);
  }
});
