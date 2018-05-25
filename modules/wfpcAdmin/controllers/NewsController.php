<?php
namespace app\modules\wfpcAdmin\controllers;

use yii;
use yii\web\Controller;
use app\controllers\AdminCommonController;
use yii\data\Pagination;
use app\component\L;

use app\logic\NewsLogic;
use app\models\News;
use app\models\NewsCate;

/**
 * Default controller for the `wfpcAdmin` module
 */
class NewsController extends AdminCommonController//Controller
{
    public $page_js = array();//加载视图额外js

    /**
     * @Author pwr at 2018-02-08
     * @name actionNewsList
     * @todo 新闻列表
     */
    public function actionNewsList(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        //$id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;

        $start_time = isset($request['start_time']) && $request['start_time']!='' ? (string)$request['start_time'] : '';
        $start_time = trim(strip_tags($start_time));
        $end_time = isset($request['end_time']) && $request['end_time']!='' ? (string)$request['end_time'] : '';
        $end_time = trim(strip_tags($end_time));

        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 10;
        //print_r($title);exit;
        $l = new NewsLogic();
        $where['is_delete'] = 0;
        if($cate_id>0){
            $where['cate_id'] = $cate_id;
        }
        if($start_time!='' && strtotime($start_time)>0){
            $where['max_'][] = array('>=','publish_time',strtotime($start_time));
        }
         if($end_time!='' && strtotime($end_time)>0){
            $where['max_'][] = array('<','publish_time',strtotime($end_time));
        }
        /*if($title!=''){
            $where = array('title'=>$title,'is_delete'=>0);
        }*/

        if($title!=''){
            $where['like_'][] = array('like','title',$title);
        }
        $count = $l->getNewsList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getNewsList($where,$page,$pageSize,0,'sort desc, id desc');
        }


        $publish_count = $l->getNewsList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
        $no_publish_count = $l->getNewsList(array('is_delete'=>0,'is_publish'=>0),1,1,1);

        //var_dump($data);die();
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
        //返回请求参数
        $get_data = array('title'=>$title,'cate_id'=>$cate_id);
		
		$l = new NewsLogic();
		$cate_list = $l->getNewsCateList(array('is_delete'=>0),1,50,10,'sort desc,id desc');
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'get_data'=>$get_data,'cate_list'=>$cate_list,'publish_count'=>$publish_count,'no_publish_count'=>$no_publish_count);
        //调用视图
        return $this->render('newsList',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

    /**
     * @Author pwr at 2018-02-08
     * @name actionNewsDetails
     * @todo 新闻编辑详情
     */
    public function actionNewsDetails(){
        $request = Yii::$app->request->get();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $data = array();
        
        $l = new NewsLogic();
        if($id>0){
            $d = $l->getNewsData($id);
            if(!empty($d) && $d['is_delete']==0){
                $data = $d;
            }
        }
        
		if(!empty($data)){
			$l = new NewsLogic();
			$cate_list = $l->getNewsCateList(array('is_delete'=>0),1,50);
			
			//返回请求参数
			$get_data = array('id'=>$id);
			//生成返回参数
			$r = array('data'=>$data,'get_data'=>$get_data,'cate_list'=>$cate_list);
			//调用视图
			return $this->render('newsEdit',$r);
		}else{
			$r = array('tips'=>'请求失敗','jump_url'=>'/wfpcAdmin/news/news-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
		}
    }
    
    /**
     * @Author pwr at 2018-02-08
     * @name actionNewsEdit
     * @todo 新闻更新
     */
    public function actionNewsEdit(){
        $request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        //$is_delete = isset($request['is_delete']) && $request['is_delete']>0 ? (int)$request['is_delete'] : 0;
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
		$excerpt = isset($request['excerpt']) && $request['excerpt']!='' ? (string)$request['excerpt'] : '';
        $excerpt = trim(strip_tags($excerpt));
        $content = isset($request['content']) && $request['content']!='' ? (string)$request['content'] : '';
        $image = isset($request['image']) && $request['image']!='' ? (string)$request['image'] : '';
        $image = trim(strip_tags($image));
        $publish_time = isset($request['publish_time']) && $request['publish_time']!='' ? (string)$request['publish_time'] : '';
        $publish_time = trim(strip_tags($publish_time));

        if($id>0){
            $m = new News();
            $check = $m->getNewsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'title'=>$title,
					'excerpt'=>$excerpt,
					'content'=>$content,
					'cate_id'=>$cate_id,
					'sort'=>$sort,
					'image'=>$image,
					'update_time'=>time(),
				);
				if($publish_time !='' && strtotime($publish_time)>0){
					$update_data['publish_time'] = strtotime($publish_time);
				}
				//var_dump($update_data);die();
                $u = $m->updateNewsById($id,$update_data);
				//var_dump($u);
                //return $this->successResult(array('u'=>$u));
				$r = array('tips'=>'更新成功','jump_url'=>'/wfpcAdmin/news/news-list');
				return $this->render('/default/success',$r);
            }else{
				$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/news/news-list','msg'=>L::t(30001));
                return $this->render('/default/error',$r);
            }
        }else{
			$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/news/news-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
        }
    }
    
    /**
     * @Author pwr at 2018-02-08
     * @name actionNewsAdd
     * @todo 新闻添加
     */
    public function actionNewsAdd(){
        $request = Yii::$app->request->post();
		if(empty($request)){
			//$getNewsCateList
			$l = new NewsLogic();
			$cate_list = $l->getNewsCateList(array('is_delete'=>0),1,50);
			return $this->render('newsAdd',array('cate_list'=>$cate_list));
		}
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
		$excerpt = isset($request['excerpt']) && $request['excerpt']!='' ? (string)$request['excerpt'] : '';
        $excerpt = trim(strip_tags($excerpt));
        $content = isset($request['content']) && $request['content']!='' ? (string)$request['content'] : '';
        $image = isset($request['image']) && $request['image']!='' ? (string)$request['image'] : '';
        $image = trim(strip_tags($image));
        $publish_time = isset($request['publish_time']) && $request['publish_time']!='' ? (string)$request['publish_time'] : '';
        $publish_time = trim(strip_tags($publish_time));

        if($title!=''){
            $update_data = array(
                'title'=>$title,
                'excerpt'=>$excerpt,
                'content'=>$content,
                'cate_id'=>$cate_id,
                'sort'=>$sort,
                'image'=>$image,
                'create_time'=>time(),
            );
            if($publish_time !='' && strtotime($publish_time)>0){
                $update_data['publish_time'] = strtotime($publish_time);
            }
            $m = new News();
            $u = $m->addNews($update_data);
			if($u>0){
				$r = array('tips'=>'添加成功','jump_url'=>'/wfpcAdmin/news/news-list');
				return $this->render('/default/success',$r);
			}else{
				$r = array('tips'=>'添加失敗','jump_url'=>'/wfpcAdmin/news/news-list','msg'=>L::t(30999));
				return $this->render('/default/error',$r);
			}
        }else{
			$r = array('tips'=>'添加失敗','jump_url'=>'/wfpcAdmin/news/news-list','msg'=>L::t(30001));
			return $this->render('/default/error',$r);
        }
    }
    
	/**
     * @Author pwr at 2018-02-08
     * @name actionNewsDelete
     * @todo 新闻删除
     */
	public function actionNewsDelete(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		if($id>0){
            $m = new News();
            $check = $m->getNewsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_delete'=>1,
					'update_time'=>time(),
				);
                $u = $m->updateNewsById($id,$update_data);
				$this->successResult(array('u'=>$u));
            }else{
				$this->errorResult(30001);
            }
        }else{
			$this->errorResult(30001);
        }
	}


    /**
     * @Author wolf at 2018-04-10
     * @name actionAdsPublish
     * @todo 发布
     */
    public function actionNewsPublish(){
        $request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $is_publish = isset($request['is_publish']) && $request['is_publish']==1 ? 1 : 0;
        if($id>0){
            $m = new News();
            $l = new NewsLogic();
            $check = $m->getNewsById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
                    'is_publish'=>$is_publish,
                );
                $u = $m->updateNewsById($id,$update_data);

                //重新统计
                $publish_count = $l->getNewsList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
                $no_publish_count = $l->getNewsList(array('is_delete'=>0,'is_publish'=>0),1,1,1);

                $this->successResult(array('u'=>$u,'is_publish'=>$is_publish,'ok_count'=>$publish_count,'no_count'=>$no_publish_count));
            }else{
                $this->errorResult(30001);
            }
        }else{
            $this->errorResult(30001);
        }
    }


    /**
     * @Author pwr at 2018-02-08
     * @name actionNewsCateList
     * @todo 新闻分类列表
     */
    public function actionNewsCateList(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		$title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));

        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 10;


        $l = new NewsLogic();
        $where['is_delete'] = 0;
		if($title!=''){
			$where['like_'][] = array('like','title',$title);
		}
        if($id>0){
            $where = array('id'=>$id,'is_delete'=>0);
        }
        $count = $l->getNewsCateList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getNewsCateList($where,$page,$pageSize,0,'sort desc, id desc');
        }
        //var_dump($data);die();
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
        //返回请求参数
        $get_data = array('id'=>$id,'title'=>$title);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'get_data'=>$get_data);
        //调用视图
        return $this->render('newsCateList',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

	/**
     * @Author pwr at 2018-02-08
     * @name actionNewsCateDetails
     * @todo 新闻分类编辑详情
     */
    public function actionNewsCateDetails(){
        $request = Yii::$app->request->get();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $data = array();
        
        $l = new NewsLogic();
        if($id>0){
            $d = $l->getNewsCateData($id);
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
			return $this->render('newsCateEdit',$r);
		}else{
			$r = array('tips'=>'请求失敗','jump_url'=>'/wfpcAdmin/news/news-cate-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
		}
    }
	
	/**
     * @Author pwr at 2018-02-08
     * @name actionNewsCateEdit
     * @todo 新闻分类更新
     */
    public function actionNewsCateEdit(){
        $request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $is_delete = isset($request['is_delete']) && $request['is_delete']>0 ? (int)$request['is_delete'] : 0;
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $pid = isset($request['pid']) && $request['pid']>0 ? (int)$request['pid'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
		//$brief = isset($request['brief']) && $request['brief']!='' ? (string)$request['brief'] : '';
        //$brief = trim(strip_tags($brief));
        //$icon = isset($request['icon']) && $request['icon']!='' ? (string)$request['icon'] : '';
        //$icon = trim(strip_tags($icon));

        if($id>0){
            $m = new NewsCate();
            $check = $m->getNewsCateById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'title'=>$title,
					'pid'=>$pid,
					'sort'=>$sort,
				);
                if($is_delete==1){
                    $update_data = array('is_delete'=>1,'editor_id'=>0,'editor_name'=>'');
                }
				//var_dump($update_data);die();
                $u = $m->updateNewsCateById($id,$update_data);
				//var_dump($u);
                //return $this->successResult(array('u'=>$u));
				$r = array('tips'=>'更新成功','jump_url'=>'/wfpcAdmin/news/news-cate-list');
				return $this->render('/default/success',$r);
            }else{
				$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/news/news-cate-list','msg'=>L::t(30001));
                return $this->render('/default/error',$r);
            }
        }else{
			$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/news/news-cate-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
        }
    }
	
	/**
     * @Author pwr at 2018-02-08
     * @name actionNewsCateAdd
     * @todo 新闻分类添加
     */
    public function actionNewsCateAdd(){
        $request = Yii::$app->request->post();
		if(empty($request)){
			return $this->render('newsCateAdd',array());
		}
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $pid = isset($request['pid']) && $request['pid']>0 ? (int)$request['pid'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
        //$icon = isset($request['icon']) && $request['icon']!='' ? (string)$request['icon'] : '';
        //$icon = trim(strip_tags($icon));

        if($title!=''){
            $update_data = array(
				'title'=>$title,
				'pid'=>$pid,
				'sort'=>$sort,
				//'icon'=>$icon,
			);
			
            $m = new NewsCate();
            $u = $m->addNewsCate($update_data);
			if($u>0){
				$r = array('tips'=>'添加成功','jump_url'=>'/wfpcAdmin/news/news-cate-list');
				return $this->render('/default/success',$r);
			}else{
				$r = array('tips'=>'添加失敗','jump_url'=>'/wfpcAdmin/news/news-cate-list','msg'=>L::t(30999));
				return $this->render('/default/error',$r);
			}
        }else{
			$r = array('tips'=>'添加失敗','jump_url'=>'/wfpcAdmin/news/news-cate-list','msg'=>L::t(30001));
			return $this->render('/default/error',$r);
        }
    }
	
	/**
     * @Author pwr at 2018-02-08
     * @name actionNewsCateDelete
     * @todo 新闻新闻分类删除
     */
	public function actionNewsCateDelete(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		if($id>0){
            $m = new NewsCate();
            $check = $m->getNewsCateById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_delete'=>1,
				);
                $u = $m->updateNewsCateById($id,$update_data);
				$this->successResult(array('u'=>$u));
            }else{
				$this->errorResult(30001);
            }
        }else{
			$this->errorResult(30001);
        }
	}
}