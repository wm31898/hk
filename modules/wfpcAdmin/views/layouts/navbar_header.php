<div class="navbar-header pull-left">
	<a href="#" class="navbar-brand">
		<small>
            環球大愛-香港官網後台管理系統
		</small>
	</a><!-- /.brand -->
</div><!-- /.navbar-header -->

<div class="navbar-header pull-right" role="navigation">
	<ul class="nav ace-nav">
		<li class="light-blue">
			<a data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
				<!--<img class="nav-user-photo" src="/admin_style_pages/assets/avatars/user.jpg" alt="Jason's Photo" />-->
				<span class="user-info">
					<small>歡迎光臨,</small>
					<?php $session = Yii::$app->session;
                    $login_account = $session->get('user_data');
                    echo $login_account['login_account'];
                    ?>
				</span>

				<i class="icon-caret-down"></i>
			</a>

			<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
				<li>
					<a href="/wfpcAdmin/home/psw">
						<i class="icon-cog"></i>
                        修改密碼
					</a>
				</li>

				<!--<li>
					<a href="javascript:;">
						<i class="icon-user"></i>
						个人资料
					</a>
				</li>-->

				<li class="divider"></li>

				<li>
					<a href="javascript:;" onclick="logout_onlick()">
						<i class="icon-off"></i>
						退出
					</a>
				</li>
			</ul>
		</li>
	</ul><!-- /.ace-nav -->
</div><!-- /.navbar-header -->