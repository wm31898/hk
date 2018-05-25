<!-- 日历插件css -->
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/datetimepicker.css" />
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/upload-plug-in/index.css" />
<div class="page-header">
	<h1>新聞編輯</h1>
</div>
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" action="/wfpcAdmin/news/news-edit" method="post" role="form" enctype="multipart/form-data" onsubmit="return checkForm();">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">新聞標題<span class="red">*</span></label>
				<div class="col-sm-9">
					<input placeholder="新聞標題" class="col-xs-10 col-sm-5" type="text" name="title" value="<?php echo $data['title']; ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">新聞分類</label>
				<div class="col-sm-9">
					<select class="col-sm-5" name="cate_id">
						<option value="0">請選擇</option>
						<?php
	                        if(!empty($cate_list)){
								foreach($cate_list as $v){
									if($data['cate_id']==$v['id']){
										echo '<option value="'.$v['id'].'" selected="selected">'.$v['title'].'</option>';
									}else{
										echo '<option value="'.$v['id'].'">'.$v['title'].'</option>';
									}
								}
							}
	                    ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">顯示日期</label>
				<div class="col-sm-9">
					<i class="icon-calendar bigger-110"></i>
					<input type="text" class="datetime-picker" name="publish_time" value="<?php echo $data['publish_time']>0?date('Y-m-d H:i:s',$data['publish_time']):''; ?>" readonly>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">列表圖<br/>(380px*480px)</label>
				<div class="col-sm-9">
					<div class="img-box full">
						<section class=" img-section">
							<!--<p class="up-p">作品圖片：<span class="up-span">最多可以上传2张圖片，马上上传</span></p>-->
							<div class="z_photo upimg-div clear" >
								<input class="z_upload_url" value="/wfpcAdmin/default/upload-image" type="hidden"><!-- 上传接口URL -->
								<input class="z_field_name" value="image" type="hidden"><!-- 提交表單时候的字段名 -->
								<input class="z_max_files" value="1" type="hidden"><!-- 控制最大上传圖片數量 -->
								<?php
									if($data['image']!=''){
								?>
									<section class="up-section fl">
										<span class="up-span"></span>
										<span class="close-upimg"><i class="icon-trash bigger-110"></i></span>
										<img class="up-img" src="<?php echo $data['image_url']; ?>">
										<input name="image" value="<?php echo $data['image']; ?>" type="hidden">
									</section>
								<?php	
									}
								?>
								<section class="z_file fl" <?php if($data['image_url']!=''){ echo 'style="display: none;"'; } ?>>
									<img src="<?php echo Yii::$app->params['adminCssUrl']; ?>/upload-plug-in/img/a11.png" class="add-img">
									<input type="file" name="file" class="file" value="" accept="image/jpg,image/jpeg,image/png,image/bmp" multiple />
								</section>
							</div>
						</section>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">新聞概述</label>
				<div class="col-sm-9">
					<textarea placeholder="新聞概述" class="col-xs-10 col-sm-5" name="excerpt"><?php echo $data['excerpt']; ?></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">新聞內容</label>
				<div class="col-sm-9">
					<script id="editor" name="content" type="text/plain" style="min-width:80%; min-height:300px;"><?php echo $data['content']; ?></script>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">排序</label>
				<div class="col-sm-9">
					<input class="col-xs-10 col-sm-5" type="text" name="sort" value="<?php echo $data['sort']; ?>">
				</div>
			</div>
			
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input name="id" value="<?php echo $data['id']; ?>" type="hidden">
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
		////$('[data-rel=tooltip]').tooltip({container:'body'});
		////$('[data-rel=popover]').popover({container:'body'});
		//日期输入框组件
		$('.datetime-picker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', autoclose: true});
		
		var ue = UE.getEditor('editor', { 'allowDivTransToP':false, });
	});
	
	function checkForm(){
		if($("input[name='title']").val()==''){
			html_alert('請輸入新聞標題');
			$("input[name='title']").focus();
			return false;
		}
		return true;
	}
</script>