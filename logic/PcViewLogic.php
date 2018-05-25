<?php
namespace app\logic;

use Yii;


class PcViewLogic{

	/**
	 * @Author pwr at 2018-04-12
	 * @name createPageUrl
	 * @parameter $m：控制器名；$f：方法名；$g：get参数数组集合
	 * @todo 创建页面链接
	 */
	public static function createPageUrl($m='',$f='',$g=array()){
		$url = '/pc';
		if($m!=''){
			$url .= '/'.$m;
			if($f!=''){
				$url .= '/'.$f;
			}
		}
		
		if(!empty($g)){
			$url .= '?';
			$i = 1;
			foreach($g as $k=>$v){
				if($k!=''){
					if($i>1){
						$url .= '&';
					}
					$url .= $k.'='.$v;
					$i++;
				}
			}
		}
		return $url;
	}
}
