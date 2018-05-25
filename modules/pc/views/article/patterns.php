<?php
    use yii\widgets\LinkPager;
	use app\logic\PcViewLogic;
	use app\component\Tools;
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['pcCssUrl']; ?>/old-model.css">
<hr class="head-line">
<div class="container">
	<?php
		$h = '';
		if(!empty($data['list'])){
			foreach($data['list'] as $k=>$v){
				$h .= '<div class="old-module">';
				
				if($k%2>0){
					$h .= '<div class="right-block old-text">';
					$h .= '<h4 title="'.$v['title'].'">'.Tools::subStr($v['title'], 0, 8).'</h4>';
					$h .= '<p class="old-info">'.Tools::subStr($v['excerpt'], 0, 399).'</p>';
					$h .= '</div>';
					if($v['image_url']!=''){
						$h .= '<div class="old-img"><img src="'.$v['image_url'].'" width="870" height="280"></div>';
					}else{
						$h .= '<div class="old-img"><img src="'.Yii::$app->params['pcImageUrl'].'/old-img1.jpg" width="870" height="280"></div>';
					}
				}else{
					if($v['image_url']!=''){
						$h .= '<div class="old-img"><img src="'.$v['image_url'].'" width="870" height="280"></div>';
					}else{
						$h .= '<div class="old-img"><img src="'.Yii::$app->params['pcImageUrl'].'/old-img1.jpg" width="870" height="280"></div>';
					}
					$h .= '<div class="right-block old-text">';
					$h .= '<h4 title="'.$v['title'].'">'.Tools::subStr($v['title'], 0, 8).'</h4>';
					$h .= '<p class="old-info">'.Tools::subStr($v['excerpt'], 0, 399).'</p>';
					$h .= '</div>';
				}
				
				$h .= '</div>';
			}
		}
		echo $h;
	?>
	<nav aria-label="Page navigation" class="navigation">
		<?php echo LinkPager::widget(['pagination'=>$pages,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','maxButtonCount'=>5]); ?>
	</nav>
</div>