<!-- 全局操作提示弹框 -->
<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		<i class="icon-hand-right blue bigger-120"></i>&nbsp; <span></span>
	</div>
</div>

<!-- 全局html提示弹框 -->
<div id="dialog-html-alert" class="hide">
	<div class="alert alert-info bigger-110"></div>
</div>

<!-- 全局html搜索弹框 -->
<div id="dialog-html-document" class="hide">
	<div class="alert alert-info bigger-110"></div>
</div>

<script type="text/javascript">
	if("ontouchend" in document) document.write("<script src='<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery.mobile.custom.min.js'>"+"<"+"script>");
</script>
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/bootstrap.min.js"></script>
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/excanvas.min.js"></script>
<![endif]-->

<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery-ui-1.10.3.full.min.js"></script>
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery.slimscroll.min.js"></script>
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery.easy-pie-chart.min.js"></script>
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery.sparkline.min.js"></script>

<!-- ace scripts -->
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/ace-elements.min.js"></script>
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/ace.min.js"></script>
<!-- inline scripts related to this page -->

<!-- 后台自定义js -->
<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/admin.js"></script>
<?php
	if(isset($this->context->page_js) && !empty($this->context->page_js)){
		foreach($this->context->page_js as $v){
			echo '<script src="'.Yii::$app->params['adminJsUrl'].$v.'"></script>';
		}
	}
?>