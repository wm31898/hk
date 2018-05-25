<?php
namespace app\logic;

use Yii;
use app\models\Goods;
use app\models\GoodsType;

class GoodsLogic // extends MyLogic
{
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name getGoodsList
	 * @todo 获取商品列表
	*/
	public function getGoodsList($where=array(),$page=1,$row=10,$getCount=0){
		$data = array();
		$type_name_array = array();
		$m = new Goods();
		$list = $m->getGoodsList($where,$page,$row,$getCount,'id desc','id');
		if($getCount==1){
			$data = $list;
		}
		else if(!empty($list)){
			foreach($list as $v){
				/*$v['image_url'] = '';
				if($v['image']!=''){
					$v['image_url'] = Yii::$app->params['imageUrl'].$v['image'];
				}
				$v['type_name'] = '';
				if($v['cate_id']>0){
					if(isset($type_name_array[$v['cate_id']]) && $type_name_array[$v['cate_id']]!=''){
						$v['type_name'] = $type_name_array[$v['cate_id']];
					}else{
						$c_data = $this->getGoodsTypeData($v['cate_id']);
						if(!empty($c_data)){
							$v['type_name'] = $c_data['type_name'];
							$type_name_array[$v['cate_id']] = $c_data['type_name'];
						}
					}
				}
				$data[] = $v;*/
				$d = $this->getGoodsData($v['id']);
				if(!empty($d)){
					unset($d['description']);
					$data[] = $d;
				}
			}
		}
		return $data;
	}
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name getGoodsData
	 * @todo 商品详情
	*/
	public function getGoodsData($id){
		$id = (int)$id;
		$data = array();
		if($id>0){
			$m = new Goods();
			$d = $m->getGoodsById($id);
			if(!empty($d)){
				$d['image_url'] = '';
				if($d['image']!=''){
					$d['image_url'] = Yii::$app->params['imageUrl'].$d['image'];
				}
				$d['type_name'] = '';
				if($d['cate_id']>0){
					$c_data = $this->getGoodsTypeData($d['cate_id']);
					if(!empty($c_data)){
						$d['type_name'] = $c_data['type_name'];
					}
				}
				$data = $d;
			}
		}

		return $data;
	}
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name getGoodsTypeList
	 * @todo 获取商品分类列表
	*/
	public function getGoodsTypeList($where=array(),$page=1,$row=10,$getCount=0){
		$data = array();
		$m = new GoodsType();
		$list = $m->getGoodsTypeList($where,$page,$row,$getCount);
		if($getCount==1){
			$data = $list;
		}
		else if(!empty($list)){
			foreach($list as $v){
				$d = $this->getGoodsTypeData($v['id']);
				if(!empty($d)){
					$data[] = $d;
				}
			}
			
		}
		return $data;
	}
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name getGoodsTypeData
	 * @todo 商品分类详情
	*/
	public function getGoodsTypeData($id){
		$id = (int)$id;
		$data = array();
		if($id>0){
			$m = new GoodsType();
			$d = $m->getGoodsTypeById($id);
			if(!empty($d)){
				$data = $d;
			}
		}

		return $data;
	}
}
