<?php
namespace app\logic;

use Yii;
use app\models\Ads;

class AdsLogic // extends MyLogic
{
	
	/**
	 * @Author pwr at 2018-02-05
	 * @name getAdsList
	 * @todo 获取列表
	*/
	public function getAdsList($where=array(),$page=1,$row=10,$getCount=0,$order='sort desc, id desc',$admin_list=0){
		$data = array();
		$m = new Ads();
		$list = $m->getAdsIdList($where,$page,$row,$getCount,$order);
		if($getCount==1){
			$data = $list;
		}
		else if(!empty($list)){
			foreach($list as $v){
				$d = $this->getAdsData($v['id']);
				if(!empty($d)){
					unset($d['description']);
	                unset($d['editor_id']);
	                unset($d['editor_name']);
	                unset($d['add_time']);
	                unset($d['is_delete']);
					$data[] = $d;
				}
			}
		}
		return $data;
	}
	
	/**
	 * @Author pwr at 2018-02-05
	 * @name getAdsData
	 * @todo 广告轮播图详情
	*/
	public function getAdsData($id){
		$id = (int)$id;
		$data = array();
		if($id>0){
			$m = new Ads();
			$d = $m->getAdsById($id);
			if(!empty($d)){
				$d['image_url'] = '';
				if($d['image']!=''){
					$d['image_url'] = Yii::$app->params['imageUrl'].$d['image'];
				}
				$data = $d;
			}
		}

		return $data;
	}
	
	
}
