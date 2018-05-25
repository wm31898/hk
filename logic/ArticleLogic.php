<?php
namespace app\logic;

use Yii;
use app\models\Article;
use app\models\ArticleCate;

class ArticleLogic // extends MyLogic
{
	
	/**
	 * @Author pwr at 2018-02-08
	 * @name getArticleList
	 * @todo 获取文章列表
	*/
	public function getArticleList($where=array(),$page=1,$row=10,$getCount=0,$order='id desc',$admin_list=0){
		$data = array();
		$m = new Article();
		$list = $m->getArticleIdList($where,$page,$row,$getCount,$order);
		if($getCount==1){
			$data = $list;
		}
		else if(!empty($list)){
			foreach($list as $v){
				$d = $this->getArticleData($v['id']);
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
	 * @name getArticleData
	 * @todo 文章详情
	*/
	public function getArticleData($id){
		$id = (int)$id;
		$data = array();
		if($id>0){
			$m = new Article();
			$d = $m->getArticleById($id);
			if(!empty($d)){
				$d['image_url'] = '';
				if($d['image']!=''){
					$d['image_url'] = Yii::$app->params['imageUrl'].$d['image'];
				}
				$d['home_image_url'] = '';
				if($d['home_image']!=''){
					$d['home_image_url'] = Yii::$app->params['imageUrl'].$d['home_image'];
				}
				$d['cate_name'] = '';
				if($d['cate_id']>0){
					$c_data = $this->getArticleCateData($d['cate_id']);
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
	 * @name getArticleCateList
	 * @todo 获取文章分类列表
	*/
	public function getArticleCateList($where=array(),$page=1,$row=10,$getCount=0,$order='sort desc, id desc',$admin_list=0){
		$data = array();
		$m = new ArticleCate();
		$list = $m->getArticleCateIdList($where,$page,$row,$getCount,$order);
		if($getCount==1){
			$data = $list;
		}
		else if(!empty($list)){
			foreach($list as $v){
				$d = $this->getArticleCateData($v['id']);
				if(!empty($d)){
					$data[] = $d;
				}
			}
		}
		return $data;
	}
	
	/**
	 * @Author pwr at 2018-02-08
	 * @name getArticleCateData
	 * @todo 文章分类详情
	*/
	public function getArticleCateData($id){
		$id = (int)$id;
		$data = array();
		if($id>0){
			$m = new ArticleCate();
			$d = $m->getArticleCateById($id);
			if(!empty($d)){
				$d['icon_url'] = '';
				if($d['icon']!=''){
					$d['icon_url'] = Yii::$app->params['imageUrl'].$d['icon'];
				}
				$data = $d;
			}
		}

		return $data;
	}
}
