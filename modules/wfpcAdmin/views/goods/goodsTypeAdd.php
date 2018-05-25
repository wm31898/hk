<!-- 日历插件css -->
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/datetimepicker.css" />
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/upload-plug-in/index.css" />
<div class="page-header">
	<h1>商品分類添加</h1>
</div>
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" action="/wfpcAdmin/goods/goods-type-add" method="post" role="form" enctype="multipart/form-data" onsubmit="return checkForm();">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">商品分類名<span class="red">*</span></label>
				<div class="col-sm-9">
					<input placeholder="商品分類名" class="col-xs-10 col-sm-5" type="text" name="type_name" value="">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">排序</label>
				<div class="col-sm-9">
					<input class="col-xs-10 col-sm-5" type="text" name="sort" value="">
				</div>
			</div>
			
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" type="button" onClick="$('form').submit();">
						<i class="icon-ok bigger-110"></i>提交表單
					</button>
					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="reset">
						<i class="icon-undo bigger-110"></i>刷新
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
	if(isset($this->context->page_js)){
		$this->context->page_js = array(
			'/date-time/bootstrap-datepicker.min.js',//日期组件js
			'/date-time/bootstrap-timepicker.min.js',//日期组件js
			'/date-time/moment.min.js',//日期组件js
			'/date-time/daterangepicker.min.js',//日期组件js
			'/date-time/bootstrap-datetimepicker.js',//日期组件js
			'/ueditor/ueditor.config.js',//ueditor组件js
			'/ueditor/ueditor.all.min.js',//ueditor组件js
			'/ueditor/lang/zh-cn/zh-cn.js',//ueditor组件js
			'/dropzone.min.js',//ueditor组件js
			'/upload-plug-in/imgup.js',//上传圖片组件js
		);
	}
?>
<script type="text/javascript">
	jQuery(function($) {
		//日期输入框组件
		$('.datetime-picker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', autoclose: true});
		
		//var ue = UE.getEditor('editor', { 'allowDivTransToP':false, });
	});
	
	function checkForm(){
		if($("input[name='type_name']").val()==''){
			html_alert('請输入商品分類名');
			$("input[name='type_name']").focus();
			return false;
		}
		return true;
	}
</script>