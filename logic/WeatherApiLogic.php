<?php
namespace app\logic;

use Yii;
use app\component\HttpClient;


class WeatherApiLogic{

	/**
	 * @Author pwr at 2018-03-26
	 * @name getWeather
	 * @todo 获取天气信息
	 */
	public function getWeather($address=array()){
		$data = false;
		$d = $this->createWeatherData();
		if(!empty($d)){
			foreach($d as $wd){
				if(!$data && $wd['capital']=='香港'){
					$wd['city_name'] = '香港';
					$data = $wd;
				}
				if(!empty($address) && isset($address['province']) && $address['province']==$wd['capital']){
					if(isset($address['city']) && $address['city']!=''){
						$wd['city_name'] = $address['city'];
					}
					$data = $wd;
				}
			}
		}
		
        return $data;
	}
	
	/**
	 * @Author pwr at 2018-03-26
	 * @name createWeatherData
	 * @todo 创建天气信息
	 */
	public function createWeatherData(){
		$data = false;
		$key = 'wufutz_getWeather';
		$cache = Yii::$app->cache;
		//$cache = Yii::$app->cacheRedis;
		//$cache = Yii::$app->cacheMemcache;
		$data = $cache->get($key);
		
		if($data==false || (isset($_GET['noRedisCache']) && $_GET['noRedisCache']=='y')){
			$l = new HttpClient();
			$d = $l->httpRequest('http://flash.weather.com.cn/wmaps/xml/china.xml');
			libxml_disable_entity_loader(true);
			$values = json_decode(json_encode(simplexml_load_string($d, 'SimpleXMLElement', LIBXML_NOCDATA)), true); 
			//var_dump($d);
			if(isset($values['city']) && !empty($values['city'])){
				foreach($values['city'] as $v){
					if(isset($v['@attributes']) && !empty($v['@attributes'])){
						$wd = array(
							'capital'=>$v['@attributes']['quName'],
							'py_capital'=>$v['@attributes']['pyName'],
							'city_name'=>$v['@attributes']['cityname'],
							'detailed'=>$v['@attributes']['stateDetailed'],
							'tem1'=>$v['@attributes']['tem1'],
							'tem2'=>$v['@attributes']['tem2'],
							'wind_state'=>$v['@attributes']['windState'],
						);
						$data[] = $wd;
					}
				}
			}
			if(!empty($data)){
				$cache->set($key, $data,Yii::$app->params['redisCacheTimeH']);
			}
		}
        return $data;
	}
	
	/**
	 * @Author pwr at 2018-03-26
	 * @name getAddress
	 * @todo 获取地理信息
	 */
	public function getAddress($ip){
		$return_data = array('province'=>'','city'=>'');
		if($ip!=''){
			$data = false;
			$key = 'wufutz_iplookup_'.md5($ip);
			$cache = Yii::$app->cache;
			$data = $cache->get($key);
			if($data==false || (isset($_GET['noRedisCache']) && $_GET['noRedisCache']=='y')){
				$l = new HttpClient();
				$data = $l->httpRequest('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$ip);
			}
			if(!empty($data) && $data!=''){
				//写入缓存
				$cache->set($key, $data,Yii::$app->params['redisCacheTimeH']);
				
				//解析json
				$d2 = json_decode($data,true);
				if(!empty($d2) && isset($d2['province']) && $d2['province']!=''){
					$return_data['province'] = $d2['province'];
					if(isset($d2['city']) && $d2['city']!=''){
						$return_data['city'] = $d2['city'];
					}
				}
			}
		}
		
		return $return_data;
	}
	
}
