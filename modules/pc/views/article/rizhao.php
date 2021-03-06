<?php
    use yii\widgets\LinkPager;
	use app\logic\PcViewLogic;
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['pcCssUrl']; ?>/sunshine_center.css">
<hr class="head-line">
<div class="container">
	<?php
		$h = '';
		if(!empty($data['list'])){
			foreach($data['list'] as $v){
				$h .= '<div class="sunshine-module">';
				if($v['image_url']!=''){
					$h .= '<img class="sunshine-img" src="'.$v['image_url'].'" width="1200" height="560">';
				}else{
					$h .= '<img class="sunshine-img" src="'.Yii::$app->params['pcImageUrl'].'/20180408_1_15.jpg" width="1200" height="560">';
				}
				$h .= '<div class="sunshine-text"><span>'.$v['title'].'</span><br><a class="sunshine-info" href="'.pcViewLogic::createPageUrl('article','details',array('id'=>$v['id'])).'">查看详情</a></div>';
				$h .= '</div>';
			}
		}
		echo $h;
	?>
	<nav aria-label="Page navigation" class="navigation">
		<?php echo LinkPager::widget(['pagination'=>$pages,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','maxButtonCount'=>5]); ?>
	</nav>
</div>