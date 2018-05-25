<?php

namespace app\modules\pc\controllers;

use yii;
use yii\web\Controller;
use app\controllers\PcCommonController;
use yii\data\Pagination;
use app\component\L;

use app\logic\AdsLogic;
use app\logic\NewsLogic;
use app\logic\ArticleLogic;
use app\logic\GoodsLogic;
use app\logic\WeatherApiLogic;

/**
 * Default controller for the `pc` module
 */
class HomeController extends PcCommonController//PcCommonController Controller
{
	// 关闭视图布局
    //public $layout = false;
    public $title = '';
	
    /**
	 * @Author pwr at 2018-03-26
	 * @name actionIndex
	 * @todo PC版首页
	 */
    public function actionIndex(){
		//$this->title = '测试';
		
		//轮播图
		$l = new AdsLogic();
        $where = array(
			'is_delete'=>0,
			'is_publish'=>1,
		);
        $abs_array = $l->getAdsList($where,1,3);
		//var_dump($abs_array);die('Home Index');
		
		//新闻
		$l = new NewsLogic();
		$where = array(
			'is_delete'=>0,
			'is_publish'=>1,
		);
        $news_array = $l->getNewsList($where,1,3,0,'sort desc,id desc');
		//var_dump($news_array);die();
		
		//文章
		$l = new ArticleLogic();
        $rz_array = $l->getArticleList(array('is_delete'=>0,'is_publish'=>1,'cate_id'=>1),1,3,0,'sort desc, id desc');
        $ylms_array = $l->getArticleList(array('is_delete'=>0,'is_publish'=>1,'cate_id'=>2),1,3,0,'sort desc, id desc');
        $yljd_array = $l->getArticleList(array('is_delete'=>0,'is_publish'=>1,'cate_id'=>3),1,1,0,'sort desc, id desc');

		//产品
		$l = new GoodsLogic();
		$goods_array = $l->getGoodsList(array('is_delete'=>0,'is_publish'=>1),1,3,0,'sort desc, id desc');
		//var_dump($goods_array);die();
		
		$r = array('abs_array'=>$abs_array,'news_array'=>$news_array,'rz_array'=>$rz_array,'ylms_array'=>$ylms_array,'yljd_array'=>$yljd_array,'goods_array'=>$goods_array);
        return $this->render('index',$r);
    }
	
	/**
	 * @Author pwr at 2018-03-26
	 * @name actionGetWeather
	 * @todo 获取天气信息
	 */
	public function actionGetWeather(){
		if(isset($_SERVER['HTTP_X_FORWORD_FOR']) && $_SERVER['HTTP_X_FORWORD_FOR']!=''){
			$ip_data = array('c_ip'=>$_SERVER['HTTP_X_FORWORD_FOR'],'type'=>'HTTP_X_FORWORD_FOR');
		}
		else if(isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']!=''){
			$ip_data = array('c_ip'=>$_SERVER['HTTP_CLIENT_IP'],'type'=>'HTTP_CLIENT_IP');
		}
		else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']!=''){
			$ip_data = array('c_ip'=>$_SERVER['REMOTE_ADDR'],'type'=>'REMOTE_ADDR');
		}
		//var_dump($ip_data);
		
		$l = new WeatherApiLogic();
		$address = $l->getAddress($ip_data['c_ip']);
		$d = $l->getWeather($address);
		if(!empty($d)){
			$d['user_ip'] = $ip_data;
			$d['user_address'] = $address;
			return $this->successResult($d);
		}
		return $this->errorResult('获取天气信息失败');
		/*
		IP获取地址信息JS例子
		$.getScript("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=120.197.37.122", function(){
		  //alert("Script loaded and executed.");
		  
			if (remote_ip_info.ret == '1'){   
				alert('<BR>国家：'+remote_ip_info.country+'<BR>省份：'+remote_ip_info.province+'<BR>城市：'+remote_ip_info.city+'<BR>区：'+remote_ip_info.district+'<BR>ISP：'+remote_ip_info.isp+'<BR>类型：'+remote_ip_info.type+'<BR>其他：'+remote_ip_info.desc);   
			} else {   
				alert('错误', '没有找到匹配的 IP 地址信息！');
			}
		  
		});
		*/
		
		
        return $this->render('index');
    }
	
	
	/**
     * @Author pwr at 2018-04-12
     * @name actionError
     * @todo 错误页面
     */
	public function actionError(){
		header('Location: http://'.$_SERVER['SERVER_NAME'].'/');
		die();
	}
}
