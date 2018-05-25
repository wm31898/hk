<!-- 日历插件css -->
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/datetimepicker.css" />
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/upload-plug-in/index.css" />
<div class="page-header">
	<h1>輪播圖添加</h1>
</div>
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" action="/wfpcAdmin/ads/ads-add" method="post" role="form" enctype="multipart/form-data" onsubmit="return checkForm();">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">標題<span class="red">*</span></label>
				<div class="col-sm-9">
					<input placeholder="標題" class="col-xs-10 col-sm-5" type="text" name="title" value="">
				</div>
			</div>
			
			<!--<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">简述</label>
				<div class="col-sm-9">
					<textarea class="col-xs-10 col-sm-5" name="description"></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">类型</label>
				<div class="col-sm-9">
					<select class="col-sm-5" name="type">
						<?php
	                        $type_list = array(0=>'普通輪播圖',1=>'视频輪播圖');
	                        foreach($type_list as $k=>$v){
	                            echo '<option value="'.$k.'">'.$v.'</option>';
	                        }
	                    ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">發佈日期</label>
				<div class="col-sm-9">
					<i class="icon-calendar bigger-110"></i>
					<input type="text" class="datetime-picker" name="publish_time" value="" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">结束日期</label>
				<div class="col-sm-9">
					<i class="icon-calendar bigger-110"></i>
					<input type="text" class="datetime-picker" name="end_time" value="" readonly>
				</div>
			</div>-->
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">廣告圖<br/>(1920px*560px)</label>
				<div class="col-sm-9">
					<div class="img-box full">
						<section class=" img-section">
							<!--<p class="up-p">作品圖片：<span class="up-span">最多可以上传2张圖片，马上上传</span></p>-->
							<div class="z_photo upimg-div clear" >
								<input class="z_upload_url" value="/wfpcAdmin/default/upload-image" type="hidden"><!-- 上传接口URL -->
								<input class="z_field_name" value="image" type="hidden"><!-- 提交表單时候的字段名 -->
								<input class="z_max_files" value="1" type="hidden"><!-- 控制最大上传圖片數量 -->
								<section class="z_file fl">
									<img src="<?php echo Yii::$app->params['adminCssUrl']; ?>/upload-plug-in/img/a11.png" class="add-img">
									<input type="file" name="file" class="file" value="" accept="image/jpg,image/jpeg,image/png,image/bmp" multiple />
								</section>
							</div>
						</section>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">點擊鏈接</label>
				<div class="col-sm-9">
					<input placeholder="點擊鏈接" class="col-xs-10 col-sm-5" type="text" name="link" value="">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">排序</label>
				<div class="col-sm-9">
					<input class="col-xs-10 col-sm-5" type="text" name="sort" value="">
				</div>
			</div>

			<!--<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">视频鏈接</label>
				<div class="col-sm-9">
					<input placeholder="视频鏈接" class="col-xs-10 col-sm-5" type="text" name="video_url" value="">
				</div>
			</div>-->
			
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
		//$('[data-rel=tooltip]').tooltip({container:'body'});
		//$('[data-rel=popover]').popover({container:'body'});
		//日期输入框组件
		$('.datetime-picker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', autoclose: true});
		
		//var ue = UE.getEditor('editor', { 'allowDivTransToP':false, });
	});
	
	function checkForm(){
		if($("input[name='title']").val()==''){
			html_alert('請输入輪播圖標題');
			$("input[name='title']").focus();
			return false;
		}
		return true;
	}
</script>