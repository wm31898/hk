<?php
	use app\logic\PcViewLogic;
?>
<hr class="headLine" />
<div class="container">
    <div class="breadcrumb">
        <span class="breadcrumb-title"><?php echo $data['cate_id']==1?'<a href="'.pcViewLogic::createPageUrl('article').'">日照中心</a>':'<a href="'.pcViewLogic::createPageUrl('article','provide-base').'">养老基地</a>'; ?></span>
        <span class="breadcrumb-title">></span>
        <span class="breadcrumb-active"><?php echo $data['title']; ?></span>
    </div>
</div>
<div class="sd_banner">
<?php
	if($data['image_url']!=''){
		echo '<img width="1200" height="560" src="'.$data['image_url'].'" alt="'.$data['title'].'">';
	}else{
		echo '<img width="1200" height="560" src="'.Yii::$app->params['pcImageUrl'].'/sunshine_details_03.jpg" alt="'.$data['title'].'">';
	}
?>
	<!--<div class="sd_banner-title">
        <h3>
			<?php echo $data['title']; ?>
			<?php //echo $data['publish_time']>0?'<p><span>'.date('Y.m.d').'</span><b>•</b><label>浏览204</label></p>':'' ?>
			<?php echo $data['publish_time']>0?'<p><span>'.date('Y.m.d H:i:s',$data['publish_time']).'</span></p>':'' ?>
        </h3>
    </div>-->
</div>
<div class="sd_contA">
    <div class="sd_body">
		<?php
			echo $data['content'];
		?>
        <!--<div class="sd_head">
            <hr />
            <h3>五福带您领略迷人的养老风光，走进星级养老服务</h3>
            <hr />
        </div>
        <p>刚刚过去的1、2月，游学院的一众摄友踏上了精彩纷呈的摄影创作之旅。北国寒意未退的同时，南方已迎来春风，我们精选了部分线路的精彩作品，大家将欣赏到云南多彩春色、坝上雪原风光、哈尔滨雪乡童话世界、斯里兰卡旅拍异域风情，让我们跟随他们的镜头，领略旅途中摄影的乐趣！</p>
        <h4>内容图片的标题</h4>
        <p>汇集东北雪国经典冬季银色风光，把大城市和林区小屯串联起来，城市冰雪世界和纯自然林区雪景囊括其中：哈尔滨冰城、童话雪乡、原始雪谷、雾凇岛、羊草山、雪屋……纯玩的轻摄影户外体验，品味东北浓浓的热炕头文化。</p>
        <img width="750" height="400" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/sunshine_details_07.jpg" alt="">
        <img width="750" height="400" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/sunshine_details_10.jpg" alt="">
        <img width="750" height="400" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/sunshine_details_13.jpg" alt="">
        <h4>内容图片的标题</h4>
        <p>汇集东北雪国经典冬季银色风光，把大城市和林区小屯串联起来，城市冰雪世界和纯自然林区雪景囊括其中：哈尔滨冰城、童话雪乡、原始雪谷、雾凇岛、羊草山、雪屋……纯玩的轻摄影户外体验，品味东北浓浓的热炕头文化。</p>
        <img width="750" height="400" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/sunshine_details_07.jpg" alt="">
        <img width="750" height="400" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/sunshine_details_10.jpg" alt="">
        <img width="750" height="400" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/sunshine_details_13.jpg" alt="">-->
    </div>
</div>