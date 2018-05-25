<?php
    use yii\widgets\LinkPager;
	use app\logic\PcViewLogic;
	use app\component\Tools;
?>
<div class="ac_banner" style="background-image: url('<?php echo Yii::$app->params['pcImageUrl']; ?>/products.jpg');"></div>
<div class="container">
	<div class="jy-nav">
		<ul>
			<?php
				if(!empty($cate_list)){
					foreach($cate_list as $v){
						if($get_data['cate_id']==$v['id']){
							echo '<li class="cur"><a>'.$v['type_name'].'</a></li>';
						}else{
							echo '<li><a href="'.pcViewLogic::createPageUrl('goods','',array('c'=>$v['id'])).'">'.$v['type_name'].'</a></li>';
						}
					}
				}
			?>
		</ul>
	</div>
	<div class="jy-nav-tab product-container">
		<div class="tab-item cur">
			<?php
				$h = '';
				if(!empty($data['list'])){
					$list_count = count($data['list']);
					foreach($data['list'] as $k=>$v){
						if(in_array($k,array(0,3,6))){
							$h .= '<div class="cbody">';
							$h .= '<div class="content-chanpin">';
							$h .= '<ul class="clearfix">';
						}
						$h .= '<li>';
						$h .= '<a href="'.pcViewLogic::createPageUrl('goods','details',array('id'=>$v['id'])).'">';
						if($v['image_url']!=''){
							$h .= '<div class="li-img"><img width="380" height="300" src="'.$v['image_url'].'" /></div>';
						}else{
							$h .= '<div class="li-img"><img width="380" height="300" src="'.Yii::$app->params['pcImageUrl'].'/20180408_1_38.jpg" /></div>';
						}
						$h .= '<div class="li-text"><h4 title="'.$v['name'].'">'.Tools::subStr($v['name'], 0, 16).'</h4><p>'.Tools::subStr($v['excerpt'], 0, 48).'</p></div>';
						$h .= '</a>';
						$h .= '</li>';
						if(in_array($k,array(2,5,8)) || $k==($list_count-1)){
							$h .= '</ul>';
							$h .= '</div>';
							$h .= '</div>';
						}
					}
				}
				echo $h;
			?>
			<nav aria-label="Page navigation" class="navigation">
				<?php echo LinkPager::widget(['pagination'=>$pages,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','maxButtonCount'=>5]); ?>
			</nav>
		</div>
	</div>
</div>