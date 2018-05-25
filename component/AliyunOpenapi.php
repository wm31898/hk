<?php

namespace app\component;
use Yii;

include_once dirname(__DIR__).'/vendor/aliyuncs/aliyun-openapi-php-sdk/aliyun-php-sdk-core/Config.php';
use vod\Request\V20170321 as vod;


class AliyunOpenapi{
	
	//public $video_id = '46438090be53476a8b19ce57f69b3d59';
	public $region_id = '';
	public $access_key_id = '';
	public $access_key_secret = '';
	public $error_message = '';
	public $client = '';
	
	function  __construct(){
		$this->region_id = Yii::$app->params['alivideo']['region_id'];
		$this->access_key_id = Yii::$app->params['alivideo']['access_key_id'];
		$this->access_key_secret = Yii::$app->params['alivideo']['access_key_secret'];
		$profile = \DefaultProfile::getProfile($this->region_id, $this->access_key_id, $this->access_key_secret);
		$this->client = new \DefaultAcsClient($profile);
	}
	
	
	/**
	 * @Author pwr at 2017-11-16
	 * @name getVideoPlayAuth
	 * @todo 获取播放凭证
	 */
	public function getVideoPlayAuth($video_id){
		$response = array();
		try{
			$request = new vod\GetVideoPlayAuthRequest();
			$request->setAcceptFormat('JSON');
			$request->setRegionId($this->region_id);
			$request->setVideoId($video_id);//视频ID
			$response = $this->client->getAcsResponse($request);
		}catch (\Exception $e) {
			$this->error_message = $e->getMessage();
		}
		return $response;
    }
	
	/**
	 * @Author pwr at 2017-11-16
	 * @name getVideoPlayAuth
	 * @todo 获取视频信息
	 */
	public function getVideoInfo($video_id){
		$response = array();
		try{
			$request = new vod\GetVideoInfoRequest();
			$request->setAcceptFormat('JSON');
			$request->setRegionId($this->region_id);
			$request->setVideoId($video_id);//视频ID
			$response = $this->client->getAcsResponse($request);
		}catch (\Exception $e) {
			$this->error_message = $e->getMessage();
		}
		return $response;
	}
	
	/**
	 * @Author pwr at 2017-11-16
	 * @name getVideoList
	 * @todo 获取视频列表
	 */
	public function getVideoList(){
		$response = array();
		try{
			$request = new vod\GetVideoListRequest();
			$request->setAcceptFormat('JSON');
			$request->setRegionId($this->region_id);
			$response = $this->client->getAcsResponse($request);
		}catch (\Exception $e) {
			$this->error_message = $e->getMessage();
		}
		return $response;
	}
}
?>