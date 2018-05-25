<?php
    use yii\widgets\LinkPager;
	use app\logic\PcViewLogic;
	use app\component\Tools;
?>
<div class="bannerAll">
	<div  id="b04" class="bannerA">
        <ul class="">
			<?php
				$h = '';
				if(!empty($abs_array)){
					foreach($abs_array as $v){
						$h .= '<li class="images">';
						if($v['link']!=''){
							$h .= '<a href="'.$v['link'].'"><img src="'.$v['image_url'].'" /></a>';
						}else{
							$h .= '<img src="'.$v['image_url'].'" />';
						}
						$h .= '</li>';
					}
				}else{
					$h = '<li class="images"><img src="'.Yii::$app->params['pcImageUrl'].'/20180408_1_02.jpg" /></li>';
				}
				echo $h;
			?>
        </ul>
    </div>
    <div class="site-all" style="display: none;">
        <div class="cbody">
            <div class="site clearfix">
                <div class="site-l fl">
                    <div class="site-lt">
                        <h4><span>香港</span></h4>
                    </div>
                    <div class="site-lb">
                        <p><?php echo date('Y年 m月d日',time()); ?></p>
                    </div>
                </div>
                <div class="site-r fl clearfix">
                    <div class="site-rimg fl">
                        <img width="46" height="46" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/20180408_1_43.png" />
                    </div>
                    <div class="site-rtext fl">
                        <h4>晴</h4>
                        <p>25°~28°</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-news-all">
    <div class="catalogue">
        <div class="cbody">
            <h3>NEWS</h3>
            <h4>新聞中心</h4>
        </div>
    </div>
    <div class="cbody">
        <div class="content-news">
            <div class="content-news-t">
                <ul class="clearfix">
					<?php
						$h = '';
						if(!empty($news_array)){
							foreach($news_array as $v){
								$h .= '<li><a href="'.pcViewLogic::createPageUrl('news','details',array('id'=>$v['id'])).'">';
								$h .= '<div class="li-conta">';
								if($v['image_url']!=''){
									$h .= '<div class="img"><img width="380" height="480" src="'.$v['image_url'].'" /></div>';
								}else{
									$h .= '<div class="img"><img width="380" height="480" src="'.Yii::$app->params['pcImageUrl'].'/20180408_1_05.jpg" /></div>';
								}
								$h .= '<div class="text"><p>'.$v['title'].'</p></div>';
								$h .= '</div>';
								$h .= '<div class="li-contb"><h3>'.$v['title'].'</h3><p>'.$v['excerpt'].'</p><span>'.date('Y.m.d',$v['publish_time']).'</span></div>';
								$h .= '</a></li>';
							}
						}
						echo $h;
					?>
                    <!--<li>
                        <a href="">
                            <div class="li-conta">
                                <div class="img"><img width="380" height="480" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/20180408_1_05.jpg" /></div>
                                <div class="text">
                                    <p>深圳国际创客周天安云谷分会场活动 智能硬件创新论坛圆满举办</p>
                                </div>
                            </div>
                            <div class="li-contb">
                                <h3>深圳国际创客周天安云谷分会场活动智能硬件创新论坛圆满举办</h3>
                                <p>这与在家时没法比，每天忙的不亦乐乎，交了很多新朋友，你看我现在红光满面，精神焕发，我都不想住别墅了。</p>
                                <span>2018.03.18</span>
                            </div>
                        </a>
                    </li>-->
                </ul>
            </div>
            <div class="content-news-b">
                <a class="sim-button button21" href="<?php echo pcViewLogic::createPageUrl('news'); ?>">了解更多</a>
            </div>
        </div>
    </div>
</div>

<div class="content-rizhao-all">
    <div class="catalogue">
        <div class="cbody">
            <h3>RIZHAO CENTER</h3>
            <h4>日照中心</h4>
        </div>
    </div>
    <div class="cbody">
        <div class="content-rizhao">
            <div class="rizhaoall">

                <div class="rizhaoBigall">
                    <ul class="rizhaoBig clearfix">
						<?php
							$h = '';
							if(!empty($rz_array)){
								foreach($rz_array as $v){
									$h .= '<li titlename="'.$v['tag_title'].'">';
									if($v['home_image_url']!=''){
										$h .= '<div class="li-img"><img src="'.$v['home_image_url'].'" /></div>';
									}else{
										$h .= '<div class="li-img"><img src="'.Yii::$app->params['pcImageUrl'].'/20180408_1_15.jpg" /></div>';
									}
									$h .= '<div class="li-text">';
									$h .= '<h3>'.$v['title'].'</h3>';
									$h .= '<p>'.$v['excerpt'].'</p>';
									$h .= '<a class="sim-button button21" href="'.pcViewLogic::createPageUrl('article','details',array('id'=>$v['id'])).'">查看詳情</a>';
									$h .= '</div>';
									$h .= '</li>';
								}
							}
							echo $h;
						?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="content-yanlao-all">
    <div class="catalogue">
        <div class="cbody">
            <h3>PENSION MODE</h3>
            <h4>養老模式</h4>
        </div>
    </div>
    <div class="cbody">
        <div class="content-yanlao">
            <ul>
				<?php
					$h = '';
					if(!empty($ylms_array)){
						foreach($ylms_array as $k=>$v){
							$class_l = array('fl','fr');
							if($k%2>0){
								$class_l = array('fr','fl');
							}
							$h .= '<li><a class="clearfix">';
							if($v['image_url']!=''){
								$h .= '<div class="li-img '.$class_l[0].'"><img width="870" height="280" src="'.$v['image_url'].'" /></div>';
							}else{
								$h .= '<div class="li-img '.$class_l[0].'"><img width="870" height="280" src="'.Yii::$app->params['pcImageUrl'].'/20180408_1_26.jpg" /></div>';
							}
							$h .= '<div class="li-text '.$class_l[1].'"><h4 title="'.$v['title'].'">'.Tools::subStr($v['title'], 0, 8).'</h4><p>'.Tools::subStr($v['excerpt'], 0, 399).'</p></div>';
							$h .= '</a></li>';
						}
					}
					echo $h;
				?>
            </ul>
        </div>
		<div class="content-news-b">
			<a class="sim-button button21" href="<?php echo pcViewLogic::createPageUrl('article','provide-patterns'); ?>">了解更多</a>
		</div>
    </div>
</div>

<div class="content-jidi-all">
    <div class="catalogue">
        <div class="cbody">
            <h3>OLD AGE BASE</h3>
            <h4>養老基地</h4>
        </div>
    </div>
    <div class="cbody">
        <div class="content-jidi">
            <ul>
			<?php
				if(!empty($yljd_array[0])){
					$ylms_data = $yljd_array[0];
					//$patten = array("\r\n", "\n", "\r");
					//先替换掉\r\n,然后是否存在\n,最后替换\r
					$ylms_data['excerpt'] = str_replace(array("\r\n", "\r", "\n"), '<br/>', $ylms_data['excerpt']);
			?>
                <li class="clearfix">
                    <div class="li-text fl">
                        <h4><span>“<?php echo $ylms_data['title']; ?>”</span><?php echo $ylms_data['tag_title']; ?></h4>
                        <p><?php echo $ylms_data['excerpt']; ?></p>
                        <a class="sim-button button21" href="<?php echo pcViewLogic::createPageUrl('article','details',array('id'=>$ylms_data['id'])); ?>">查看詳情</a>
                    </div>
                    <div class="li-img fr">
					<?php
						if($ylms_data['home_image_url']!=''){
							echo '<img width="585" height="460" src="'.$ylms_data['home_image_url'].'" />';
						}else{
							echo '<img width="585" height="460" src="'.Yii::$app->params['pcImageUrl'].'/20180408_1_36.jpg" />';
						}
					?>
					</div>
                </li>
			<?php } ?>
            </ul>
        </div>
    </div>
</div>

<div class="content-chanpin-all">
    <div class="catalogue">
        <div class="cbody">
            <h3>PRODUCT CENTER</h3>
            <h4>產品中心</h4>
        </div>
    </div>
    <div class="cbody">
        <div class="content-chanpin">
            <ul class="clearfix">
				<?php
					$h = '';
					if(!empty($goods_array)){
						foreach($goods_array as $v){
							$h .= '<li><a href="'.pcViewLogic::createPageUrl('goods','details',array('id'=>$v['id'])).'">';
							if($v['image_url']!=''){
								$h .= '<div class="li-img"><img width="380" height="300" src="'.$v['image_url'].'" /></div>';
							}else{
								$h .= '<div class="li-img"><img width="380" height="300" src="'.Yii::$app->params['pcImageUrl'].'/20180408_1_38.jpg" /></div>';
							}
							$h .= '<div class="li-text"><h4 title="'.$v['name'].'">'.Tools::subStr($v['name'], 0, 16).'</h4><p>'.Tools::subStr($v['excerpt'], 0, 48).'</p></div>';
							$h .= '</a></li>';
						}
					}
					echo $h;
				?>
                <!--<li>
                    <a href="">
                        <div class="li-img"><img width="380" height="304" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/20180408_1_38.jpg" /></div>
                        <div class="li-text">
                            <h4>标题文案最多显示一行</h4>
                            <p>在灌水季去拍哈尼族创造的大地雕塑艺术</p>
                        </div>
                    </a>
                </li>-->
            </ul>
        </div>
		<div class="content-news-b">
			<a class="sim-button button21" href="<?php echo pcViewLogic::createPageUrl('goods'); ?>">了解更多</a>
		</div>
    </div>
</div>