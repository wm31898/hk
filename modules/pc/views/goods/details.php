<?php
	use app\logic\PcViewLogic;
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['pcCssUrl']; ?>/goods_details.css">
<hr class="head-line">
<div class="breadcrumb-bg">
    <div class="breadcrumb">
        <span class="breadcrumb-title"><a href="<?php echo pcViewLogic::createPageUrl('goods'); ?>">产品中心</a></span>
        <span class="breadcrumb-title">></span>
        <span class="breadcrumb-active"><?php echo $data['name']; ?></span>
    </div>
</div>
<div class="goods">
	<?php
		if($data['image_url']!=''){
			echo '<img src="'.$data['image_url'].'" width="500" height="400">';
		}else{
			echo '<img src="'.Yii::$app->params['pcImageUrl'].'/goods_icon.png" width="500" height="400">';
		}
	?>
    <div class="goods-introduce">
        <h4><?php echo $data['name']; ?></h4>
        <p><?php echo $data['excerpt']; ?></p>
		<?php
			if($data['link_url']!=''){
				echo '<a href="'.$data['link_url'].'"><button class="btn-goods" >立即购买</button></a>';
			}
		?>
    </div>
</div>
<div class="goods-container">
    <div class="goods-info">
		<?php echo $data['description']; ?>
        <!--<img src="<?php echo Yii::$app->params['pcImageUrl']; ?>/goods_info.png">
        <p>山间风景独好。登高望远，云淡风清，丝丝清爽带走了所有的烦忧。淡淡的浮云山间飘荡，天地间绘出一幅精彩的水墨，让人不得不感佩大自然的神奇造化。</p>
        <p>登山有一个好处，置身山间，满目苍翠，两眼舒爽，两腿受罪，身受疲乏，心被陶醉，抛弃杂务，累也不累！！</p>
        <p>站在山顶，任谁似乎都变得洒脱了，有点仙风道骨的意思。刘禹锡说“山不在高，有仙则名”，其实不对，仙多半是被山所吸引，流连于青山的秀美，洒脱，才抛弃俗念，隐于山间，享受着大自然的恩赐，过期了自己写意的人生。</p>
        <img src="<?php echo Yii::$app->params['pcImageUrl']; ?>/goods_info.png">
        <p>山间风景独好。登高望远，云淡风清，丝丝清爽带走了所有的烦忧。淡淡的浮云山间飘荡，天地间绘出一幅精彩的水墨，让人不得不感佩大自然的神奇造化。</p>
        <p>登山有一个好处，置身山间，满目苍翠，两眼舒爽，两腿受罪，身受疲乏，心被陶醉，抛弃杂务，累也不累！！</p>
        <p>站在山顶，任谁似乎都变得洒脱了，有点仙风道骨的意思。刘禹锡说“山不在高，有仙则名”，其实不对，仙多半是被山所吸引，流连于青山的秀美，洒脱，才抛弃俗念，隐于山间，享受着大自然的恩赐，过期了自己写意的人生。</p>
        <img src="<?php echo Yii::$app->params['pcImageUrl']; ?>/goods_info.png">
        <img src="<?php echo Yii::$app->params['pcImageUrl']; ?>/goods_info.png">
        <img src="<?php echo Yii::$app->params['pcImageUrl']; ?>/goods_info.png">
        <p>山间风景独好。登高望远，云淡风清，丝丝清爽带走了所有的烦忧。淡淡的浮云山间飘荡，天地间绘出一幅精彩的水墨，让人不得不感佩大自然的神奇造化。</p>
        <p>登山有一个好处，置身山间，满目苍翠，两眼舒爽，两腿受罪，身受疲乏，心被陶醉，抛弃杂务，累也不累！！</p>
        <p>站在山顶，任谁似乎都变得洒脱了，有点仙风道骨的意思。刘禹锡说“山不在高，有仙则名”，其实不对，仙多半是被山所吸引，流连于青山的秀美，洒脱，才抛弃俗念，隐于山间，享受着大自然的恩赐，过期了自己写意的人生。</p>-->
    </div>
</div>