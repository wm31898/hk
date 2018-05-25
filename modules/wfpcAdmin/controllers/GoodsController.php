<?php
namespace app\modules\wfpcAdmin\controllers;

use yii;
use yii\web\Controller;
use app\controllers\AdminCommonController;
use yii\data\Pagination;
use app\component\L;

use app\logic\GoodsLogic;
use app\models\Goods;
use app\models\GoodsType;

/**
 * Default controller for the `wfpcAdmin` module
 */
class GoodsController extends AdminCommonController//Controller
{
    public $page_js = array();//加载视图额外js

    /**
     * @Author pwr at 2018-04-08
     * @name actionGoodsList
     * @todo 商品列表
     */
    public function actionGoodsList(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;
		$name = isset($request['name']) && $request['name']!='' ? (string)$request['name'] : '';
        $name = trim(strip_tags($name));
		$publish_count = 0;
		$no_publish_count = 0;
        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 10;
        
        $l = new GoodsLogic();
        $where['is_delete'] = 0;
        if($cate_id>0){
            $where['cate_id'] = $cate_id;
        }
		if($name!=''){
            $where['like_'] = array(
				array('like','name',$name),
			);
        }
        if($id>0){
            $where = array('id'=>$id,'is_delete'=>0);
        }
        $count = $l->getGoodsList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getGoodsList($where,$page,$pageSize,0,'sort desc, id desc');
        }
		
		//发布数量获取
		$publish_count = $l->getGoodsList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
		$no_publish_count = $l->getGoodsList(array('is_delete'=>0,'is_publish'=>0),1,1,1);
		
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
        //返回请求参数
        $get_data = array('id'=>$id,'cate_id'=>$cate_id,'name'=>$name);
		
		//商品分类列表
		$cate_list = $l->getGoodsTypeList(array('is_delete'=>0),1,50);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'get_data'=>$get_data,'cate_list'=>$cate_list,'publish_count'=>$publish_count,'no_publish_count'=>$no_publish_count);
        //调用视图
        return $this->render('goodsList',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

    /**
     * @Author pwr at 2018-04-08
     * @name actionGoodsDetails
     * @todo 商品编辑详情
     */
    public function actionGoodsDetails(){
        $request = Yii::$app->request->get();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $data = array();
        
        $l = new GoodsLogic();
        if($id>0){
            $d = $l->getGoodsData($id);
            if(!empty($d) && $d['is_delete']==0){
                $data = $d;
            }
        }
        //var_dump($data);die();
		if(!empty($data)){
			$l = new GoodsLogic();
			$cate_list = $l->getGoodsTypeList(array('is_delete'=>0),1,50);
			
			//返回请求参数
			$get_data = array('id'=>$id);
			//生成返回参数
			$r = array('data'=>$data,'get_data'=>$get_data,'cate_list'=>$cate_list);
			//调用视图
			return $this->render('goodsEdit',$r);
		}else{
			$r = array('tips'=>'請求失敗','jump_url'=>'/wfpcAdmin/goods/goods-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
		}
    }
    
    /**
     * @Author pwr at 2018-04-08
     * @name actionGoodsEdit
     * @todo 商品更新
     */
    public function actionGoodsEdit(){
        $request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        //$is_delete = isset($request['is_delete']) && $request['is_delete']>0 ? (int)$request['is_delete'] : 0;
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;
        $name = isset($request['name']) && $request['name']!='' ? (string)$request['name'] : '';
        $name = trim(strip_tags($name));
        $description = isset($request['description']) && $request['description']!='' ? (string)$request['description'] : '';
        $excerpt = isset($request['excerpt']) && $request['excerpt']!='' ? (string)$request['excerpt'] : '';
        $excerpt = trim(strip_tags($excerpt));
		$image = isset($request['image']) && $request['image']!='' ? (string)$request['image'] : '';
        $image = trim(strip_tags($image));
		$link_url = isset($request['link_url']) && $request['link_url']!='' ? (string)$request['link_url'] : '';
        $link_url = trim(strip_tags($link_url));

        if($id>0){
            $m = new Goods();
            $check = $m->getGoodsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'name'=>$name,
					'excerpt'=>$excerpt,
					'description'=>$description,
					'cate_id'=>$cate_id,
					'image'=>$image,
					'link_url'=>$link_url,
					'update_time'=>time(),
				);
				//var_dump($update_data);die();
                $u = $m->updateGoodsById($id,$update_data);
				//var_dump($u);
                //return $this->successResult(array('u'=>$u));
				$r = array('tips'=>'更新成功','jump_url'=>'/wfpcAdmin/goods/goods-list');
				return $this->render('/default/success',$r);
            }else{
				$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/goods/goods-list','msg'=>L::t(30001));
                return $this->render('/default/error',$r);
            }
        }else{
			$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/goods/goods-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
        }
    }
    
    /**
     * @Author pwr at 2018-04-08
     * @name actionGoodsAdd
     * @todo 商品添加
     */
    public function actionGoodsAdd(){
        $request = Yii::$app->request->post();
		if(empty($request)){
			//$getGoodsTypeList
			$l = new GoodsLogic();
			$cate_list = $l->getGoodsTypeList(array('is_delete'=>0),1,50);
			return $this->render('goodsAdd',array('cate_list'=>$cate_list));
		}
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;
        $name = isset($request['name']) && $request['name']!='' ? (string)$request['name'] : '';
        $name = trim(strip_tags($name));
        $description = isset($request['description']) && $request['description']!='' ? (string)$request['description'] : '';
        $excerpt = isset($request['excerpt']) && $request['excerpt']!='' ? (string)$request['excerpt'] : '';
        $excerpt = trim(strip_tags($excerpt));
		$image = isset($request['image']) && $request['image']!='' ? (string)$request['image'] : '';
        $image = trim(strip_tags($image));
		$link_url = isset($request['link_url']) && $request['link_url']!='' ? (string)$request['link_url'] : '';
        $link_url = trim(strip_tags($link_url));

        if($name!=''){
            $update_data = array(
					'name'=>$name,
					'excerpt'=>$excerpt,
					'description'=>$description,
					'cate_id'=>$cate_id,
					'image'=>$image,
					'link_url'=>$link_url,
					'create_time'=>time(),
				);
			//var_dump($update_data);
			//die();
            $m = new Goods();
            $u = $m->addGoods($update_data);
			if($u>0){
				$r = array('tips'=>'添加成功','jump_url'=>'/wfpcAdmin/goods/goods-list');
				return $this->render('/default/success',$r);
			}else{
				$r = array('tips'=>'添加失败','jump_url'=>'/wfpcAdmin/goods/goods-list','msg'=>L::t(30999));
				return $this->render('/default/error',$r);
			}
        }else{
			$r = array('tips'=>'添加失败','jump_url'=>'/wfpcAdmin/goods/goods-list','msg'=>L::t(30001));
			return $this->render('/default/error',$r);
        }
    }
    
	/**
     * @Author pwr at 2018-04-08
     * @name actionGoodsDelete
     * @todo 商品删除
     */
	public function actionGoodsDelete(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		if($id>0){
            $m = new Goods();
            $check = $m->getGoodsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_delete'=>1,
					'update_time'=>time(),
				);
                $u = $m->updateGoodsById($id,$update_data);
				$this->successResult(array('u'=>$u));
            }else{
				$this->errorResult(30001);
            }
        }else{
			$this->errorResult(30001);
        }
	}
	
    /**
     * @Author pwr at 2018-04-08
     * @name actionGoodsTypeList
     * @todo 商品分类列表
     */
    public function actionGoodsTypeList(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		$type_name = isset($request['type_name']) && $request['type_name']!='' ? (string)$request['type_name'] : '';
        $type_name = trim(strip_tags($type_name));

        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 10;
        
        $l = new GoodsLogic();
        $where['is_delete'] = 0;
		if($type_name!=''){
			$where['like_'][] = array('like','type_name',$type_name);
		}
        if($id>0){
            $where = array('id'=>$id,'is_delete'=>0);
        }
        $count = $l->getGoodsTypeList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getGoodsTypeList($where,$page,$pageSize,0,'sort desc, id desc');
        }
        //var_dump($data);die();
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
        //返回请求参数
        $get_data = array('id'=>$id,'type_name'=>$type_name);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'get_data'=>$get_data);
        //调用视图
        return $this->render('goodsTypeList',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

	/**
     * @Author pwr at 2018-04-08
     * @name actionGoodsTypeDetails
     * @todo 商品分类编辑详情
     */
    public function actionGoodsTypeDetails(){
        $request = Yii::$app->request->get();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $data = array();
        
        $l = new GoodsLogic();
        if($id>0){
            $d = $l->getGoodsTypeData($id);
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
			return $this->render('goodsTypeEdit',$r);
		}else{
			$r = array('tips'=>'請求失敗','jump_url'=>'/wfpcAdmin/goods/goods-type-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
		}
    }
	
	/**
     * @Author pwr at 2018-04-08
     * @name actionGoodsTypeEdit
     * @todo 商品分类更新
     */
    public function actionGoodsTypeEdit(){
        $request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $type_name = isset($request['type_name']) && $request['type_name']!='' ? (string)$request['type_name'] : '';
        $type_name = trim(strip_tags($type_name));

        if($id>0){
            $m = new GoodsType();
            $check = $m->getGoodsTypeById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'type_name'=>$type_name,
					'sort'=>$sort,
				);
				//var_dump($update_data);die();
                $u = $m->updateGoodsTypeById($id,$update_data);
				//var_dump($u);
                //return $this->successResult(array('u'=>$u));
				$r = array('tips'=>'更新成功','jump_url'=>'/wfpcAdmin/goods/goods-type-list');
				return $this->render('/default/success',$r);
            }else{
				$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/goods/goods-type-list','msg'=>L::t(30001));
                return $this->render('/default/error',$r);
            }
        }else{
			$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/goods/goods-type-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
        }
    }
	
	/**
     * @Author pwr at 2018-04-08
     * @name actionGoodsTypeAdd
     * @todo 商品分类添加
     */
    public function actionGoodsTypeAdd(){
        $request = Yii::$app->request->post();
		if(empty($request)){
			return $this->render('goodsTypeAdd',array());
		}
		$sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $type_name = isset($request['type_name']) && $request['type_name']!='' ? (string)$request['type_name'] : '';
        $type_name = trim(strip_tags($type_name));

        if($type_name!=''){
            $update_data = array(
				'type_name'=>$type_name,
				'sort'=>$sort,
			);
			//var_dump($update_data);die();
            $m = new GoodsType();
            $u = $m->addGoodsType($update_data);
			if($u>0){
				$r = array('tips'=>'添加成功','jump_url'=>'/wfpcAdmin/goods/goods-type-list');
				return $this->render('/default/success',$r);
			}else{
				$r = array('tips'=>'添加失败','jump_url'=>'/wfpcAdmin/goods/goods-type-list','msg'=>L::t(30999));
				return $this->render('/default/error',$r);
			}
        }else{
			$r = array('tips'=>'添加失败','jump_url'=>'/wfpcAdmin/goods/goods-type-list','msg'=>L::t(30001));
			return $this->render('/default/error',$r);
        }
    }
	
	/**
     * @Author pwr at 2018-04-08
     * @name actionGoodsTypeDelete
     * @todo 商品分类删除
     */
	public function actionGoodsTypeDelete(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		if($id>0){
            $m = new GoodsType();
            $check = $m->getGoodsTypeById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_delete'=>1,
				);
                $u = $m->updateGoodsTypeById($id,$update_data);
				$this->successResult(array('u'=>$u));
            }else{
				$this->errorResult(30001);
            }
        }else{
			$this->errorResult(30001);
        }
	}
	
	/**
     * @Author pwr at 2018-04-10
     * @name actionGoodsPublish
     * @todo 商品发布
     */
	public function actionGoodsPublish(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $is_publish = isset($request['is_publish']) && $request['is_publish']==1 ? 1 : 0;
		if($id>0){
            $m = new Goods();
            $check = $m->getGoodsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_publish'=>$is_publish,
					'update_time'=>time(),
				);
                $u = $m->updateGoodsById($id,$update_data);
				$this->successResult(array('u'=>$u,'is_publish'=>$is_publish));
            }else{
				$this->errorResult(30001);
            }
        }else{
			$this->errorResult(30001);
        }
	}
	
	/**
     * @Author pwr at 2018-04-10
     * @name actionGetPublishCount
     * @todo 商品发布数量获取
     */
	public function actionGetPublishCount(){
		//$request = Yii::$app->request->post();
		$l = new GoodsLogic();
		$publish_count = $l->getGoodsList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
		$no_publish_count = $l->getGoodsList(array('is_delete'=>0,'is_publish'=>0),1,1,1);
		
		$this->successResult(array('publish_count'=>$publish_count,'no_publish_count'=>$no_publish_count));
	}
	
	
}