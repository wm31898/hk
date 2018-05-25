<!-- 日历插件css -->
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/datetimepicker.css" />
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/upload-plug-in/index.css" />
<div class="page-header">
	<h1>編輯頁面</h1>
</div>
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" action="/wfpcAdmin/home/submit-form" method="post" role="form" enctype="multipart/form-data" onsubmit="return checkForm();">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">內容1</label>
				<div class="col-sm-9">
					<input placeholder="內容1" class="col-xs-10 col-sm-5" type="text" name="title1" value="<?php echo $data['text1']; ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">內容2</label>
				<div class="col-sm-9">
					<input placeholder="內容2" class="col-xs-10 col-sm-5" type="text" name="title2" value="<?php echo $data['text2']; ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly">搜索获取</label>

				<div class="col-sm-9">
					<input readonly="" class="col-xs-10 col-sm-5 search_text" value="" type="text" onClick="html_document($('#search_body').html(),'搜索商家',setSearchVal)">
					<input name="search_val" value="0" type="hidden">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">下拉框</label>
				<div class="col-sm-9">
					<select class="col-sm-5" id="form-field-select-1">
						<option value="">請選擇</option>
						<option value="1">数据1</option>
						<option value="2">数据2</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly"> Readonly field </label>

				<div class="col-sm-9">
					<input readonly="" class="col-xs-10 col-sm-5" id="form-input-readonly" value="This text field is readonly!" type="text">
					<span class="help-inline col-xs-12 col-sm-7">
						<label class="middle">
							<input class="ace" id="id-disable-check" type="checkbox">
							<span class="lbl"> Disable it!</span>
						</label>
					</span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right">Input with Icon</label>

				<div class="col-sm-9">
					<span class="input-icon">
						<input id="form-field-icon-1" type="text">
						<i class="icon-leaf blue"></i>
					</span>

					<span class="input-icon input-icon-right">
						<input id="form-field-icon-2" type="text">
						<i class="icon-leaf green"></i>
					</span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-6">Tooltip and help button</label>

				<div class="col-sm-9">
					<input data-rel="tooltip" id="form-field-6" placeholder="Tooltip on hover" title="" data-placement="bottom" data-original-title="Hello Tooltip!" type="text">
					<span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="提示內容20180131" title="" data-original-title="提示標題">?</span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">日期選擇</label>
				<div class="col-sm-9">
					<i class="icon-calendar bigger-110"></i>
					<input type="text" class="datetime-picker" name="end_time" value="<?php echo $data['day']; ?>" readonly>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">文本框</label>
				<div class="col-sm-9">
					<textarea class="col-xs-10 col-sm-5" placeholder="Default Text" name="content1">文本框</textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">文本框</label>
				<div class="col-sm-9">
					<script id="editor" name="content" type="text/plain" style="width:80%; height:300px;"><?php echo stripslashes($data['content']); ?></script>
				</div>
			</div>
			
			<!--<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">圖片上传</label>
				<div class="col-sm-9">
					<div class="dropzone" field-name="images[]"></div>
				</div>
			</div>-->
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">圖片上传1</label>
				<div class="col-sm-9">
					<div class="img-box full">
						<section class=" img-section">
							<p class="up-p">作品圖片：<span class="up-span">最多可以上传2张圖片，马上上传</span></p>
							<div class="z_photo upimg-div clear" >
								<input class="z_upload_url" value="/wfpcAdmin/default/upload-image" type="hidden"><!-- 上传接口URL -->
								<input class="z_field_name" value="images[]" type="hidden"><!-- 提交表單时候的字段名 -->
								<input class="z_max_files" value="2" type="hidden"><!-- 控制最大上传圖片數量 -->
								<!--<section class="up-section fl">
									<span class="up-span"></span>
									<span class="close-upimg"><i class="icon-trash bigger-110"></i></span>
									<img class="up-img" src="http://wftest.oss-cn-shenzhen.aliyuncs.com/wftzimg/1517760000/15177942373988.jpeg">
									<input name="images[]" value="wftzimg/1517760000/15177942373988.jpeg" type="hidden">
								</section>
								<section class="up-section fl">
									<span class="up-span"></span>
									<span class="close-upimg"><i class="icon-trash bigger-110"></i></span>
									<img class="up-img" src="http://wftest.oss-cn-shenzhen.aliyuncs.com/wftzimg/1517760000/15177930889925.jpeg">
									<input name="images[]" value="wftzimg/1517760000/15177930889925.jpeg" type="hidden">
								</section>-->
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
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">圖片上传2</label>
				<div class="col-sm-9">
					<div class="img-box full">
						<section class=" img-section">
							<p class="up-p">作品圖片：<span class="up-span">最多可以上传1张圖片，马上上传</span></p>
							<div class="z_photo upimg-div clear" >
								<input class="z_upload_url" value="/wfpcAdmin/default/upload-image" type="hidden"><!-- 上传接口URL -->
								<input class="z_field_name" value="images2[]" type="hidden"><!-- 提交表單时候的字段名 -->
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
			
			
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" type="button" onClick="$('form').submit();">
						<i class="icon-ok bigger-110"></i>
						提交表單
					</button>

					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="reset">
						<i class="icon-undo bigger-110"></i>
						刷新
					</button>
					
					<button class="btn" type="reset" onClick="checkAjax('提示')">
						提示
					</button>
					
					<button class="btn" type="reset" onClick="html_confirm('提示2')">
						提示2
					</button>
				</div>
			</div>
		</form>
		
		<!-- 弹框搜索版块的內容 -->
		<div id="search_body" style="display: none;">
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly">条件</label>
					<div class="col-sm-9">
						<input placeholder="搜索关键词" class="col-sm-5 margin-r-10 search_key" value="" type="text">
						<a class="btn btn-xs btn-success" href="javascript:;">Search<i class="icon-search icon-on-right bigger-110"></i></a>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly">结果</label>
					<div class="col-sm-9">
						<select class="col-sm-5 search_val">
							<option value="">請選擇</option>
							<option value="1">数据1</option>
							<option value="2">数据2</option>
							<option value="2">数据3</option>
							<option value="2">数据6</option>
							<option value="2">数据7</option>
							<option value="2">数据8</option>
							<option value="2">数据9</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<!-- END 弹框搜索版块的內容 -->
		
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
		$('[data-rel=tooltip]').tooltip({container:'body'});
		$('[data-rel=popover]').popover({container:'body'});
		//日期输入框组件
		$('.datetime-picker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', autoclose: true});

		var ue = UE.getEditor('editor', { 'allowDivTransToP':false, });
	});

	function checkForm(){
		alert('ok');
		return true;
	}
	
	function setSearchVal(){
		var v = $('#dialog-html-document .search_val').val();
		var h = $('#dialog-html-document .search_val').find("option:selected").text();
		if(v>0){
			$('.search_text').val(h);
			$("input[name='search_val']").val(v);
		}else{
			$('.search_text').val('');
			$("input[name='search_val']").val('');
		}
	}
</script>