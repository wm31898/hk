<?php
	use app\logic\PcViewLogic;
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['pcCssUrl']; ?>/news_details.css">
<hr class="head-line">
<div class="container">
    <div class="breadcrumb">
        <span class="breadcrumb-title"><a href="<?php echo pcViewLogic::createPageUrl('news'); ?>">新闻中心</a></span>
        <span class="breadcrumb-title">></span>
        <span class="breadcrumb-active">文章标题</span>
    </div>
    <div class="news-content">
        <div class="news-title"><?php echo $data['title']; ?></div>
        <div class="news-title-date">
            <span>时间:</span>
            <?php if($data['publish_time']!=0) { ?>
            <span><?php echo date('Y年m月d日 H:i:s', $data['publish_time']); ?></span>
            <?php } else { ?>
                <span>暂无</span>
            <?php } ?>
        </div>
        <hr class="splitLine">
        <!--<div>
            <img class="news-img" src="<?php /*echo Yii::$app->params['pcImageUrl']; */?>/20180408_1_15.jpg">
            <div class="news-text">
                <p>山间风景独好。登高望远，云淡风清，丝丝清爽带走了所有的烦忧。淡淡的浮云山间飘荡，天地间绘出一幅精彩的水墨，让人不得不感佩大自然的神奇造化。
                    登山有一个好处，置身山间，满目苍翠，两眼舒爽，两腿受罪，身受疲乏，心被陶醉，抛弃杂务，累也不累！！</p>
                <p>站在山顶，任谁似乎都变得洒脱了，有点仙风道骨的意思。刘禹锡说“山不在高，有仙则名”，其实不对，仙多半是被山所吸引，流连于青山的秀美，洒脱，才抛弃俗念，隐于山间，享受着大自然的恩赐，过期了自己写意的人生。</p>
            </div>
            <img class="news-img" src="<?php /*echo Yii::$app->params['pcImageUrl']; */?>/20180408_1_15.jpg">
            <img class="news-img" src="<?php /*echo Yii::$app->params['pcImageUrl']; */?>/20180408_1_15.jpg">
            <div class="news-text">
                <p>山间风景独好。登高望远，云淡风清，丝丝清爽带走了所有的烦忧。淡淡的浮云山间飘荡，天地间绘出一幅精彩的水墨，让人不得不感佩大自然的神奇造化。
                    登山有一个好处，置身山间，满目苍翠，两眼舒爽，两腿受罪，身受疲乏，心被陶醉，抛弃杂务，累也不累！！</p>
                <p>站在山顶，任谁似乎都变得洒脱了，有点仙风道骨的意思。刘禹锡说“山不在高，有仙则名”，其实不对，仙多半是被山所吸引，流连于青山的秀美，洒脱，才抛弃俗念，隐于山间，享受着大自然的恩赐，过期了自己写意的人生。</p>
            </div>
        </div>-->

        <div class="news-text"><?php echo $data['content']; ?></div>

        <hr class="splitLine">
        <div>
			<?php
				if(!empty($prev_article) && isset($prev_article[0]['id']) && $prev_article[0]['id']>0){
					$pd = $prev_article[0];
					echo '<a class="article-link" href="'.PcViewLogic::createPageUrl('news','details',array('id'=>$pd['id'] )).'">上一篇：<span>'.$pd['title'].'</span></a>';
				}
				
				if(!empty($next_article) && isset($next_article[0]['id']) && $next_article[0]['id']>0){
					$nd = $next_article[0];
					echo '<a class="article-link" href="'.PcViewLogic::createPageUrl('news','details',array('id'=>$nd['id'] )).'">下一篇：<span>'.$nd['title'].'</span></a>';
				}
			?>
        </div>
    </div>
</div>