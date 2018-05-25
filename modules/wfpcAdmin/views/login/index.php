<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>環球大愛-香港官網後台管理系統 登錄</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="<?php echo Yii::$app->params['adminCssUrl']; ?>/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />-->

		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/ace.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/ace-rtl.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/html5shiv.js"></script>
		<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container" style="width: 406px;">
							<div class="center" >
								<h1>
									<span class="white">環球大愛-香港官網-管理系統</span>
								</h1>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
                                                請輸入妳的登錄信息
											</h4>

											<div class="space-6"></div>

											<form enctype="multipart/form-data" onSubmit="but_onlick();return false;">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" id="username" name="username" class="form-control" placeholder="賬號" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" id="pwd" name="pwd" class="form-control" placeholder="密碼" />
															<i class="icon-lock"></i>
														</span>
													</label>

                                                    <label class="block clearfix">
														<span class="block input-icon input-icon-right" >
                                                            <div style="float: left;"><input type="text" id="yzm" name="yzm" class="form-control" style="width: 180px;" placeholder="驗證碼" /></div>
                                                            <div style="float: right;"><img id="captcha_img" border='1' src="/wfpcAdmin/captcha/index?r=" onclick="document.getElementById('captcha_img').src='/wfpcAdmin/captcha/index?r='+Math.random()" style="width:100px; height:34px; cursor:pointer;" /></div>

														</span>
                                                    </label>


                                                    <label class="block clearfix">
														<span id="span_id"></span>
                                                    </label>

													<div class="space"></div>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="icon-key"></i>
                                                            登錄
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->
									</div><!-- /widget-body -->
								</div><!-- /login-box -->

							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

		<script src="<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery-2.1.0.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<![endif]-->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<script type="text/javascript">
		function but_onlick () {
		
			var username = $("#username").val();
    		var pwd = $("#pwd").val();
            var yzm = $("#yzm").val();
			if(username == '') {
			//	alert('用户不能为空');
                $("#span_id").html('用戶不能爲空');
                $("#span_id").css("color","red");
                var username = document.getElementById("username");
                username.focus();//焦点事件
                username.select();
				return ;
			} 
			
			if(pwd == '') {
                $("#span_id").html('密碼不能爲空');
                $("#span_id").css("color","red");
                var pwd = document.getElementById("pwd");
                pwd.focus();//焦点事件
                pwd.select();
				return ;
			}

            if(yzm == '') {
                $("#span_id").html('驗證碼不能爲空');
                $("#span_id").css("color","red");
                var yzm = document.getElementById("yzm");
                yzm.focus();//焦点事件
                yzm.select();
                return ;
            }

            var t= {
					username: username,
					pwd: pwd,
                    yzm:yzm
				};
			$.ajax({
				type: "post",
				url: "/wfpcAdmin/login/ajaxlogin", 
				//data:JSON.stringify(t), //将对象转为为json字符串  
				data : t ,
         		//dataType:"json",  
				//contentType:"application/text", //这个必须，不然后台接受时会出现乱码现象  
				//dataType: "text",
				success: function(result) {                    //r为返回值
					//alert(result.code);
					console.log(result.code);
					if (result.code == '10000') {
                        $("#span_id").html('登錄成功');
                        $("#span_id").css("color","blue");
                        window.location.href = "/wfpcAdmin/home";
                    } else {
                        $("#span_id").html(result.msg);
                        $("#span_id").css("color","red");
						$('#captcha_img').click();
                    }

					//
					/*if(result.trim() == "y") {              //y为 url跳转网頁中传回的值。
						window.location.href = "跳转界面";
					} else {
						alert(r);
					}*/
				}
			});
			
		}
		</script>

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery-1.10.2.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo Yii::$app->params['adminJsUrl']; ?>/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
	</body>
</html>