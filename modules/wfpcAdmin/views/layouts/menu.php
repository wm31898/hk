<?php
	//管理后台菜单数组
	$wfpc_admin_menu = array(
		array(
			'v'=>'後台首頁',
			'c'=>array(),
			'i'=>'icon-home',
			'l'=>array('c'=>'home','a'=>'index'),
		),
		
		array(
			'v'=>'站點管理',
			'c'=>array(
				array('v'=>'輪播圖管理','l'=>array('c'=>'ads','a'=>'ads-list'),'include'=>array('ads/ads-details'=>'輪播圖編輯','ads/ads-add'=>'輪播圖添加')),
			),
			'i'=>'icon-desktop',
			'l'=>array(),
		),
		array(
			'v'=>'文章管理',
			'c'=>array(
				array('v'=>'文章列表','l'=>array('c'=>'article','a'=>'article-list'),'include'=>array('article/article-details'=>'文章編輯','article/article-add'=>'文章添加')),
				//array('v'=>'文章分類管理','l'=>array('c'=>'article','a'=>'article-cate-list'),'include'=>array('article/article-cate-details'=>'文章分類編輯','article/article-cate-add'=>'文章分類添加')),
			),
			'i'=>'icon-bar-chart',
			'l'=>array(),
		),
		array(
			'v'=>'新聞管理',
			'c'=>array(
				array('v'=>'新聞列表','l'=>array('c'=>'news','a'=>'news-list'),'include'=>array('news/news-details'=>'新聞編輯','news/news-add'=>'新聞添加')),
				array('v'=>'新聞分類列表','l'=>array('c'=>'news','a'=>'news-cate-list'),'include'=>array('news/news-cate-details'=>'新聞分類编輯','news/news-cate-add'=>'新聞分類添加')),
			),
			'i'=>'icon-comments',
			'l'=>array(),
		),
		array(
			'v'=>'商品管理',
			'c'=>array(
				array('v'=>'商品列表','l'=>array('c'=>'goods','a'=>'goods-list'),'include'=>array('goods/goods-details'=>'商品编輯','goods/goods-add'=>'商品添加')),
				array('v'=>'商品分類列表','l'=>array('c'=>'goods','a'=>'goods-type-list'),'include'=>array('goods/goods-type-details'=>'商品分類编輯','goods/goods-type-add'=>'商品分類添加')),
			),
			'i'=>'icon-shopping-cart',
			'l'=>array(),
		),
		/*array(
			'v'=>'菜单管理',
			'c'=>array(
				array('v'=>'二级目录4','l'=>array('c'=>'home','a'=>'home-one')),
			),
			'i'=>'icon-edit',
			'l'=>array('c'=>'home','a'=>'home-three'),
		),
		array(
			'v'=>'模板规范',
			'c'=>array(
				array('v'=>'列表规范','l'=>array('c'=>'home','a'=>'home-list'),'include'=>array()),
				array(
					'v'=>'編輯頁规范',
					'l'=>array('c'=>'home','a'=>'home-two'),
					'include'=>array('home/home-five'=>'編輯','home/home-four'=>'添加')//其它子頁面，例如編輯頁面，添加頁面
				),
			),
			'i'=>'icon-dashboard',
			'l'=>array(),
		),*/
	);
	
	/**
	 * @Author pwr at 2018-01-29
	 * @name cleateMenu
	 * @todo 创建后台菜单和面包屑
	*/
	function cleateMenu($wfpc_admin_menu){
		$h = '';//菜单html
		$breadcrumb_html = '';//面包屑html
		$breadcrumb = array();//面包屑数组
		$root_url = '/wfpcAdmin';
		
		//目录html创建
		foreach($wfpc_admin_menu as $v){
			$on_f_link = 0;
			$on_s_link = 0;
			$ch = '';
			if(!empty($v['l'])){
				$first_link = $root_url.'/'.$v['l']['c'].'/'.$v['l']['a'];
				if($v['l']['c']==Yii::$app->controller->id && $v['l']['a']==Yii::$app->controller->action->id){
					$on_f_link = 1;
					$breadcrumb[] = array('v'=>$v['v'],'l'=>array());
				}
				$fh = '<a href="'.$first_link.'"><i class="'.$v['i'].'"></i><span class="menu-text">'.$v['v'].'</span></a>';
			}else{
				if(!empty($v['c'])){
					$ch .= '<ul class="submenu">';
					foreach($v['c'] as $v2){
						$on_s_link = 0;
						$second_link = '';
						if(!empty($v2['l'])){
							$second_link = 'href="'.$root_url.'/'.$v2['l']['c'].'/'.$v2['l']['a'].'"';
							if($v2['l']['c']==Yii::$app->controller->id && $v2['l']['a']==Yii::$app->controller->action->id){
								$on_s_link = 1;
								$on_f_link = 2;
								$breadcrumb[] = array('v'=>$v2['v'],'l'=>array());
							}
						}
						
						if(isset($v2['include']) && !empty($v2['include'])){
							$k = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
							if(isset($v2['include'][$k]) && $v2['include'][$k]!=''){
								$on_s_link = 2;
								$on_f_link = 2;
								$breadcrumb[] = array('v'=>$v2['v'],'l'=>$v2['l']);
								$breadcrumb[] = array('v'=>$v2['include'][$k],'l'=>array());
							}
						}
						
						if($on_s_link==1){
							$ch .= '<li class="active"><a href="#" class="active"><i class="icon-double-angle-right"></i>'.$v2['v'].'</a></li>';
						}
						else if($on_s_link==2){
							$ch .= '<li class="active"><a '.$second_link.' class="active"><i class="icon-double-angle-right"></i>'.$v2['v'].'</a></li>';
						}
						else{
							$ch .= '<li><a '.$second_link.'><i class="icon-double-angle-right"></i>'.$v2['v'].'</a></li>';
						}
						
					}
					$ch .= '</ul>';
				}
				$fh = '<a class="dropdown-toggle" href="#"><i class="'.$v['i'].'"></i><span class="menu-text">'.$v['v'].'</span></a>';
			}
			
			
			if($on_f_link==1){
				$h .= '<li class="active">';
			}else if($on_f_link==2){
				$h .= '<li class="active open">';
			}else{
				$h .= '<li>';
			}
			$h .= $fh;
			$h .= $ch;
			$h .= '</li>';
		}
		
		//面包屑html创建
		if(!empty($breadcrumb)){
			foreach($breadcrumb as $k=>$v){
				$link = '';
				if(!empty($v['l'])){
					$link = $root_url.'/'.$v['l']['c'].'/'.$v['l']['a'].'"';
				}
				if($k == count($breadcrumb)-1){
					$breadcrumb_html .= '<li class="active">'.$v['v'].'</li>';
				}else{
					$breadcrumb_html .= '<li><a href="'.$link.'">'.$v['v'].'</a></li>';
				}
			}
		}
		
		return array('menu_html'=>$h,'breadcrumb_html'=>$breadcrumb_html);
	}
	
	$create_menu = cleateMenu($wfpc_admin_menu);
?>

<script type="text/javascript">
	try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
</script>

<ul class="nav nav-list">
	<?php echo $create_menu['menu_html']; ?>
</ul>

<!-- /.nav-list -->

<div class="sidebar-collapse" id="sidebar-collapse">
	<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
</div>

<script type="text/javascript">
	try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
</script>