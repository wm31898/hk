<div class="well">
	<h1 class="grey lighter smaller">
		<span class="green bigger-125">
			<i class="icon-ok green"></i>
		</span>
		<?php echo isset($tips) && $tips!='' ? $tips:'操作成功'; ?>
	</h1>
	<hr />
	<h3 class="lighter smaller"><span id="jump_time"><?php echo isset($jump_time) && $jump_time>0 ? $jump_time:3; ?></span>秒后自动跳转</h3>

	<div class="center">
		<!--<a href="#" class="btn btn-grey"><i class="icon-arrow-left"></i>Go Back</a>-->
		<a href="<?php echo isset($jump_url) && $jump_url!=''?$jump_url:'/wfpcAdmin/'; ?>" class="btn btn-primary"><i class="icon-dashboard"></i>立即跳转</a>
	</div>
</div>

<script>
	var url = '<?php echo isset($jump_url) && $jump_url!=''?$jump_url:'/wfpcAdmin/'; ?>';
	var u = '';
	jQuery(function($) {
		u = window.setInterval(function() {
			var t = $('#jump_time').html();
			t = t*1;
			if(t<=1){
				clearInterval(u);
				//html_alert(url);
				window.location = url;
			}else{
				$('#jump_time').html(t-1);
			}
		}, 1000);
	});
</script>