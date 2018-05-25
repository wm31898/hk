<?php
namespace app\logic;

use Yii;
use app\models\News;
use app\models\NewsCate;

class NewsLogic // extends MyLogic
{
	
	/**
	 * @Author pwr at 2018-02-08
	 * @name getNewsList
	 * @todo 获取文章列表
	*/
	public function getNewsList($where=array(),$page=1,$row=10,$getCount=0,$order='sort desc,id desc',$admin_list=0){
		$data = array();
		$m = new News();
		$list = $m->getNewsList($where,$page,$row,$getCount,$order);
		if($getCount==1){
			$data = $list;
		}
		else if(!empty($list)){
			foreach($list as $v){
				$d = $this->getNewsData($v['id']);
				if(!empty($d)){
					unset($d['content']);
					$data[] = $d;
				}
			}
		}
		return $data;
	}
	
	/**
	 * @Author pwr at 2018-02-08
	 * @name getNewsData
	 * @todo 文章详情
	*/
	public function getNewsData($id){
		$id = (int)$id;
		$data = array();
		if($id>0){
			$m = new News();
			$d = $m->getNewsById($id);
			if(!empty($d)){
				$d['image_url'] = '';
				if($d['image']!=''){
					$d['image_url'] = Yii::$app->params['imageUrl'].$d['image'];
				}
				$d['cate_name'] = '';
				if($d['cate_id']>0){
					$c_data = $this->getNewsCateData($d['cate_id']);
					if(!empty($c_data)){
						$d['cate_name'] = $c_data['title'];
					}
				}
				$data = $d;
			}
		}

		return $data;
	}
	
	/**
	 * @Author pwr at 2018-02-08
	 * @name getNewsCateList
	 * @todo 获取文章分类列表
	*/
	public function getNewsCateList($where=array(),$page=1,$row=10,$getCount=0,$order='sort desc,id desc',$admin_list=0){
		$data = array();
		$m = new NewsCate();
		$list = $m->getNewsCateList($where,$page,$row,$getCount,$order);
		if($getCount==1){
			$data = $list;
		}
		else if(!empty($list)){
			foreach($list as $v){
				$d = $this->getNewsCateData($v['id']);
				if(!empty($d)){
					$data[] = $d;
				}
			}
		}
		return $data;
	}
	
	/**
	 * @Author pwr at 2018-02-08
	 * @name getNewsCateData
	 * @todo 文章分类详情
	*/
	public function getNewsCateData($id){
		$id = (int)$id;
		$data = array();
		if($id>0){
			$m = new NewsCate();
			$d = $m->getNewsCateById($id);
			if(!empty($d)){
				$d['icon_url'] = '';
				/*if($d['icon']!=''){
					$d['icon_url'] = Yii::$app->params['imageUrl'].$d['icon'];
				}*/
				$data = $d;
			}
		}

		return $data;
	}
}
