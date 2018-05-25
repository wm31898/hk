<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="utf-8" />
		<title>環球大愛-香港官網後台管理系統</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- basic styles -->
		<link href="<?php echo Yii::$app->params['adminCssUrl']; ?>/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/font-awesome.min.css" />
		
		<!-- dropzone多圖上传插件 -->
		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/dropzone.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/jquery-ui-1.10.3.full.min.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/ace.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/ace-rtl.min.css" />
		
		<!-- 管理后台自定义样式 -->
		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/wfpc-admin-style.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery-2.1.0.js"></script>
		
		<!-- ace settings handler -->
		<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/ace-extra.min.js"></script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/html5shiv.js"></script>
		<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<?php include Yii::$app->params['basePath'].'/modules/wfpcAdmin/views/layouts/navbar_header.php'; ?>
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>
				
				<div class="sidebar" id="sidebar">
					<?php include Yii::$app->params['basePath'].'/modules/wfpcAdmin/views/layouts/menu.php'; ?>
				</div>

				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="/wfpcAdmin">首頁</a>
							</li>
							<?php echo $create_menu['breadcrumb_html'];//在wfpcAdmin/views/layouts/menu.php里面创建 ?>
						</ul><!-- .breadcrumb -->
					</div>

					<div class="page-content">
						<?= $content ?>
					</div><!-- /.page-content -->
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<?php include Yii::$app->params['basePath'].'/modules/wfpcAdmin/views/layouts/footer.php'; ?>
	</body>
</html>
<?php $this->endBody() ?>