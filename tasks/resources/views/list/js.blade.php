<script src="/js/jquery-2.2.1.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/footable/footable.all.min.js"></script>
<script src="/js/inspinia.min.js"></script>
<script src="/js/plugins/isloading/jquery.isloading.min.js"></script>
<script src="/js/plugins/toastr/toastr.min.js"></script>
<script src="/js/plugins/pace/pace.min.js"></script>
<script src="/js/plugins/ladda/spin.min.js"></script>
<script src="/js/plugins/ladda/ladda.min.js"></script>
<script src="/js/plugins/ladda/ladda.jquery.min.js"></script>
<script src="/layer/layer.js"></script>
<script src="/js/plugins/DatePicker/WdatePicker.js"></script>
<script src="/js/assign.js"></script>

@if (isset($jsdepends) && ($jsdepends & 4) != 0)
<script src="/js/plugins/jsonformater/jsonFormater.js"></script>
@endif

@if (isset($jsdepends) && ($jsdepends & 1) != 0)
<script src="/js/uploadimage.js"></script>
<script src="/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
@endif

@if (isset($jsdepends) && ($jsdepends & 2) != 0)
<script src="/js/plugins/json-editor/jsoneditor.js"></script>
@endif

