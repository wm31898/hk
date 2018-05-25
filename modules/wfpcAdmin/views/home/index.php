<?php
	use yii\widgets\LinkPager;
?>
<div class="alert alert-info">
    歡迎使用環球大愛-香港官網後台管理系統
	<button class="close" data-dismiss="alert">
		<i class="icon-remove"></i>
	</button>
</div>
	
	
<div>
	<div class="infobox infobox-green">
		<div class="infobox-icon">
			<i class="icon-bar-chart"></i>
		</div>
		<div class="infobox-data">
			<span class="infobox-data-number"><?php echo $article_publish_count; ?></span>
			<div class="infobox-content">文章發布數</div>
		</div>
	</div>

	<div class="infobox infobox-blue  ">
		<div class="infobox-icon">
			<i class="icon-comments"></i>
		</div>
		<div class="infobox-data">
			<span class="infobox-data-number"><?php echo $news_publish_count; ?></span>
			<div class="infobox-content">新聞發布數</div>
		</div>
	</div>

	<div class="infobox infobox-pink  ">
		<div class="infobox-icon">
			<i class="icon-shopping-cart"></i>
		</div>
		<div class="infobox-data">
			<span class="infobox-data-number"><?php echo $goods_publish_count; ?></span>
			<div class="infobox-content">商品發布數</div>
		</div>
	</div>

	<div class="infobox infobox-red  ">
		<div class="infobox-icon">
			<i class="icon-group"></i>
		</div>
		<div class="infobox-data">
			<span class="infobox-data-number" style="font-size: 14px;"><?php echo isset($user['penultimate_login_date']) && $user['penultimate_login_date']>0 ? date('Y-m-d H:i:s',$user['penultimate_login_date']) : '暫無'; ?></span>
			<div class="infobox-content">上次登錄時間</div>
		</div>
	</div>
</div>