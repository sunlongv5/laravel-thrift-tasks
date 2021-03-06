<script>
    function merge(set1, set2) {
        for (var key in set2) {
            set1[key] = set2[key];
        }
        return set1;
    }

    function updateField(url, field, value) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {field: field, value: value, '_method': 'put', token: '{{csrf_token()}}'},
            success: function (res) {
                if (res.status == 200) {
                    $('#configDialog .modal-body')[0].innerHTML = '状态更新成功.';
                    $('#configDialog').modal('show');
                    return false;
                } else {
                    $('#configDialog .modal-body')[0].innerHTML = res.msg;
                    $('#configDialog').modal('show');
                    return false;
                }
            },
            error: function () {
                $('#configDialog .modal-body')[0].innerHTML = '网络或系统异常,请稍后再试!';
                $('#configDialog').modal('show');
            }
        });
    }

    function updateData(url, data, method, callback, require_confirm) {
        var modal = $('.modal.fade.in');
        if (modal.size() == 0 && require_confirm !== false) {
            var flag = confirm('确认执行该操作 ?');
            if (!flag) {
                return false;
            }
        }
        $.ajax({
            type: 'POST',
            url: url,
            data: merge(data, {token: '{{csrf_token()}}', _method: method}),
            success: function (res) {
                if (callback) {
                    callback(res);
                } else {
                    $('#configDialog .modal-body')[0].innerHTML = res.msg;
                    $('#configDialog').modal('show');
                }
                return false;
            },
            error: function () {
                $('#configDialog .modal-body')[0].innerHTML = '网络或系统异常,请稍后再试!';
                $('#configDialog').modal('show');
            }
        });
    }
</script>

<!-- Modal -->
<div class="modal fade" id="configDialog" tabindex="-1" role="dialog" aria-labelledby="configDialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">消息</h4>
            </div>
            <div class="modal-body">

                ...

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal"
                        onclick="javascript: location.reload()"> 确认
                </button>
            </div>
        </div>
    </div>
</div>