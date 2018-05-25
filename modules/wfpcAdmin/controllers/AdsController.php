<?php
namespace app\modules\wfpcAdmin\controllers;

use yii;
use yii\web\Controller;
use app\controllers\AdminCommonController;
use yii\data\Pagination;
use app\component\L;

use app\logic\AdsLogic;
use app\models\Ads;

/**
 * Default controller for the `wfpcAdmin` module
 */
class AdsController extends AdminCommonController//Controller
{
    public $page_js = array();//加载视图额外js

    /**
     * @Author pwr at 2017-06-05
     * @name actionAdsList
     * @todo 轮播图管理列表
     */
    public function actionAdsList(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $type = isset($request['type']) && in_array($request['type'], array(0,1)) ? (int)$request['type'] : 2;

        $start_time = isset($request['start_time']) && $request['start_time']!='' ? (string)$request['start_time'] : '';
        $start_time = trim(strip_tags($start_time));
        $end_time = isset($request['end_time']) && $request['end_time']!='' ? (string)$request['end_time'] : '';
        $end_time = trim(strip_tags($end_time));

        $data = array(
            'pageCount'=>0,
            'adsList'=>array(),
        );
        $pageSize = 10;
        
        //广告轮播图
        $l = new AdsLogic();
        $where['is_delete'] = 0;
        if(in_array($type, array(0,1))){
            $where['type'] = $type;
        }
        if($start_time!='' && strtotime($start_time)>0){
            $where['max_'][] = array('>=','publish_time',strtotime($start_time));
        }
         if($end_time!='' && strtotime($end_time)>0){
            $where['max_'][] = array('<','end_time',strtotime($end_time));
        }
        if($id>0){
            $where = array('id'=>$id,'is_delete'=>0);
        }

        $count = $l->getAdsList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['adsList'] = $l->getAdsList($where,$page,$pageSize);
        }
        //var_dump($data);die();
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
        //返回请求参数
        $get_data = array('id'=>$id,'type'=>$type,'start_time'=>$start_time,'end_time'=>$end_time);
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'get_data'=>$get_data);
        //调用视图
        return $this->render('adsList',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

    /**
     * @Author pwr at 2018-02-05
     * @name actionAdsDetails
     * @todo 轮播图编辑详情
     */
    public function actionAdsDetails(){
        $request = Yii::$app->request->get();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $data = array();
        
        $l = new AdsLogic();
        if($id>0){
            $d = $l->getAdsData($id);
            if(!empty($d) && $d['is_delete']==0){
                $data = $d;
            }
        }
        
		if(!empty($data)){
			//返回请求参数
			$get_data = array('id'=>$id);
			//生成返回参数
			$r = array('data'=>$data,'get_data'=>$get_data);
			//调用视图
			return $this->render('adsEdit',$r);
		}else{
			$r = array('tips'=>'請求失敗','jump_url'=>'/wfpcAdmin/ads/ads-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
		}
    }
    
    /**
     * @Author pwr at 2017-06-05
     * @name actionAdsEdit
     * @todo 轮播图更新
     */
    public function actionAdsEdit(){
        $request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
        $image = isset($request['image']) && $request['image']!='' ? (string)$request['image'] : '';
        $image = trim(strip_tags($image));
        $link = isset($request['link']) && $request['link']!='' ? (string)$request['link'] : '';
        $link = trim(strip_tags($link));

        if($id>0){
            //广告轮播图
            $m = new Ads();
            $check = $m->getAdsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
                    'title'=>$title,
                    'image'=>$image,
                    'sort'=>$sort,
                    'link'=>$link,
                );
				//var_dump($update_data);die();
                $u = $m->updateAdsById($id,$update_data);
				//var_dump($u);
                //return $this->successResult(array('u'=>$u));
				$r = array('tips'=>'更新成功','jump_url'=>'/wfpcAdmin/ads/ads-list');
				return $this->render('/default/success',$r);
            }else{
				$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/ads/ads-list','msg'=>L::t(30001));
                return $this->render('/default/error',$r);
            }
        }else{
			$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/ads/ads-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
        }
        //die('AdsList');
    }
    
    /**
     * @Author pwr at 2017-06-05
     * @name actionAdsAdd
     * @todo 轮播图添加
     */
    public function actionAdsAdd(){
        $request = Yii::$app->request->post();
		if(empty($request)){
			return $this->render('adsAdd');
		}
        $type = isset($request['type']) && $request['type']>0 ? (int)$request['type'] : 0;//类型(0=链接;1=商品;2=商品分类)
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $target_id = isset($request['target_id']) && $request['target_id']>0 ? (int)$request['target_id'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
        $description = isset($request['description']) && $request['description']!='' ? (string)$request['description'] : '';
        $description = trim(strip_tags($description));
        $image = isset($request['image']) && $request['image']!='' ? (string)$request['image'] : '';
        $image = trim(strip_tags($image));
        $publish_time = isset($request['publish_time']) && $request['publish_time']!='' ? (string)$request['publish_time'] : '';
        $publish_time = trim(strip_tags($publish_time));
        $end_time = isset($request['end_time']) && $request['end_time']!='' ? (string)$request['end_time'] : '';
        $end_time = trim(strip_tags($end_time));
        $link = isset($request['link']) && $request['link']!='' ? (string)$request['link'] : '';
        $link = trim(strip_tags($link));


        if($title!=''){
            $update_data = array(
                'title'=>$title,
                'description'=>$description,
                'image'=>$image,
                'editor_id'=>0,
                'editor_name'=>'',
                'add_time'=>time(),
            );
            if($publish_time !='' && strtotime($publish_time)>0){
                $update_data['publish_time'] = strtotime($publish_time);
            }
            if($end_time !='' && strtotime($end_time)>0){
                $update_data['end_time'] = strtotime($end_time);
            }
            if(in_array($type,array(0,1,2))){
                $update_data['type'] = $type;
            }
            if($target_id>0){
                $update_data['target_id'] = $target_id;
            }
            if($sort>0){
                $update_data['sort'] = $sort;
            }
            if($link != ''){
                $update_data['link'] = $link;
            }
            $m = new Ads();
            $u = $m->addAds($update_data);
            //return $this->successResult(array('u'=>$u));
			$r = array('tips'=>'更新成功','jump_url'=>'/wfpcAdmin/ads/ads-list');
			return $this->render('/default/success',$r);
        }else{
			$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/ads/ads-list','msg'=>L::t(30001));
			return $this->render('/default/error',$r);
        }
        die('AdsList');
    }
    
    /**
     * @Author pwr at 2018-02-09
     * @name actionAdsDelete
     * @todo 轮播图删除
     */
	public function actionAdsDelete(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		if($id>0){
            $m = new Ads();
            $check = $m->getAdsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_delete'=>1,
				);
                $u = $m->updateAdsById($id,$update_data);
				$this->successResult(array('u'=>$u));
            }else{
				$this->errorResult(30001);
            }
        }else{
			$this->errorResult(30001);
        }
	}
	
	/**
     * @Author pwr at 2018-04-09
     * @name actionAdsPublish
     * @todo 轮播图发布
     */
	public function actionAdsPublish(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $is_publish = isset($request['is_publish']) && $request['is_publish']==1 ? 1 : 0;
		if($id>0){
            $m = new Ads();
            $check = $m->getAdsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_publish'=>$is_publish,
				);
                $u = $m->updateAdsById($id,$update_data);
				$this->successResult(array('u'=>$u,'is_publish'=>$is_publish));
            }else{
				$this->errorResult(30001);
            }
        }else{
			$this->errorResult(30001);
        }
	}
}