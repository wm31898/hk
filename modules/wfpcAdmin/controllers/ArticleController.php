<?php
namespace app\modules\wfpcAdmin\controllers;

use yii;
use yii\web\Controller;
use app\controllers\AdminCommonController;
use yii\data\Pagination;
use app\component\L;

use app\logic\ArticleLogic;
use app\models\Article;
use app\models\ArticleCate;

/**
 * Default controller for the `wfpcAdmin` module
 */
class ArticleController extends AdminCommonController//Controller
{
    public $page_js = array();//加载视图额外js

    /**
     * @Author pwr at 2018-02-08
     * @name actionArticleList
     * @todo 文章列表
     */
    public function actionArticleList(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;
		$title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 10;
		$publish_count = 0;
		$no_publish_count = 0;
        
        $l = new ArticleLogic();
        $where['is_delete'] = 0;
        if($cate_id>0){
            $where['cate_id'] = $cate_id;
        }
		if($title!=''){
            $where['like_'] = array(
				array('like','title',$title),
			);
        }
        if($id>0){
            $where = array('id'=>$id,'is_delete'=>0);
        }
        $count = $l->getArticleList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getArticleList($where,$page,$pageSize,0,'sort desc, id desc');
        }
        
		//发布数量获取
		$publish_count = $l->getArticleList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
		$no_publish_count = $l->getArticleList(array('is_delete'=>0,'is_publish'=>0),1,1,1);
		
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
        //返回请求参数
        $get_data = array('id'=>$id,'cate_id'=>$cate_id,'title'=>$title);
		
		//文章分类列表
		$cate_list = $l->getArticleCateList(array('is_delete'=>0),1,50);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'get_data'=>$get_data,'cate_list'=>$cate_list,'publish_count'=>$publish_count,'no_publish_count'=>$no_publish_count);
        //调用视图
        return $this->render('articleList',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

    /**
     * @Author pwr at 2018-02-08
     * @name actionArticleDetails
     * @todo 文章编辑详情
     */
    public function actionArticleDetails(){
        $request = Yii::$app->request->get();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $data = array();
        
        $l = new ArticleLogic();
        if($id>0){
            $d = $l->getArticleData($id);
            if(!empty($d) && $d['is_delete']==0){
                $data = $d;
            }
        }
        
		if(!empty($data)){
			$l = new ArticleLogic();
			$cate_list = $l->getArticleCateList(array('is_delete'=>0),1,50);
			
			//返回请求参数
			$get_data = array('id'=>$id);
			//生成返回参数
			$r = array('data'=>$data,'get_data'=>$get_data,'cate_list'=>$cate_list);
			//调用视图
			return $this->render('articleEdit',$r);
		}else{
			$r = array('tips'=>'請求失敗','jump_url'=>'/wfpcAdmin/article/article-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
		}
    }
    
    /**
     * @Author pwr at 2018-02-08
     * @name actionArticleEdit
     * @todo 文章更新
     */
    public function actionArticleEdit(){
        $request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        //$is_delete = isset($request['is_delete']) && $request['is_delete']>0 ? (int)$request['is_delete'] : 0;
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
		$tag_title = isset($request['tag_title']) && $request['tag_title']!='' ? (string)$request['tag_title'] : '';
        $tag_title = trim(strip_tags($tag_title));
		$excerpt = isset($request['excerpt']) && $request['excerpt']!='' ? (string)$request['excerpt'] : '';
        $excerpt = trim(strip_tags($excerpt));
        $content = isset($request['content']) && $request['content']!='' ? (string)$request['content'] : '';
        $image = isset($request['image']) && $request['image']!='' ? (string)$request['image'] : '';
        $image = trim(strip_tags($image));
		$home_image = isset($request['home_image']) && $request['home_image']!='' ? (string)$request['home_image'] : '';
        $home_image = trim(strip_tags($home_image));
        $publish_time = isset($request['publish_time']) && $request['publish_time']!='' ? (string)$request['publish_time'] : '';
        $publish_time = trim(strip_tags($publish_time));

        if($id>0){
            $m = new Article();
            $check = $m->getArticleById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'title'=>$title,
					'tag_title'=>$tag_title,
					'excerpt'=>$excerpt,
					'content'=>$content,
					'cate_id'=>$cate_id,
					'sort'=>$sort,
					'image'=>$image,
					'home_image'=>$home_image,
					'update_time'=>time(),
				);
				if($publish_time !='' && strtotime($publish_time)>0){
					$update_data['publish_time'] = strtotime($publish_time);
				}
				//var_dump($update_data);die();
                $u = $m->updateArticleById($id,$update_data);
				//var_dump($u);
                //return $this->successResult(array('u'=>$u));
				$r = array('tips'=>'更新成功','jump_url'=>'/wfpcAdmin/article/article-list');
				return $this->render('/default/success',$r);
            }else{
				$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/article/article-list','msg'=>L::t(30001));
                return $this->render('/default/error',$r);
            }
        }else{
			$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/article/article-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
        }
    }
    
    /**
     * @Author pwr at 2018-02-08
     * @name actionArticleAdd
     * @todo 文章添加
     */
    public function actionArticleAdd(){
        $request = Yii::$app->request->post();
		if(empty($request)){
			//$getArticleCateList
			$l = new ArticleLogic();
			$cate_list = $l->getArticleCateList(array('is_delete'=>0),1,50);
			return $this->render('articleAdd',array('cate_list'=>$cate_list));
		}
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
		$tag_title = isset($request['tag_title']) && $request['tag_title']!='' ? (string)$request['tag_title'] : '';
        $tag_title = trim(strip_tags($tag_title));
		$excerpt = isset($request['excerpt']) && $request['excerpt']!='' ? (string)$request['excerpt'] : '';
        $excerpt = trim(strip_tags($excerpt));
        $content = isset($request['content']) && $request['content']!='' ? (string)$request['content'] : '';
        $image = isset($request['image']) && $request['image']!='' ? (string)$request['image'] : '';
        $image = trim(strip_tags($image));
		$home_image = isset($request['home_image']) && $request['home_image']!='' ? (string)$request['home_image'] : '';
        $home_image = trim(strip_tags($home_image));
        $publish_time = isset($request['publish_time']) && $request['publish_time']!='' ? (string)$request['publish_time'] : '';
        $publish_time = trim(strip_tags($publish_time));

        if($title!=''){
            $update_data = array(
                'title'=>$title,
                'tag_title'=>$tag_title,
                'excerpt'=>$excerpt,
                'content'=>$content,
                'cate_id'=>$cate_id,
                'sort'=>$sort,
                'image'=>$image,
                'home_image'=>$home_image,
                'create_time'=>time(),
            );
            if($publish_time !='' && strtotime($publish_time)>0){
                $update_data['publish_time'] = strtotime($publish_time);
            }
            $m = new Article();
            $u = $m->addArticle($update_data);
			if($u>0){
				$r = array('tips'=>'添加成功','jump_url'=>'/wfpcAdmin/article/article-list');
				return $this->render('/default/success',$r);
			}else{
				$r = array('tips'=>'添加失败','jump_url'=>'/wfpcAdmin/article/article-list','msg'=>L::t(30999));
				return $this->render('/default/error',$r);
			}
        }else{
			$r = array('tips'=>'添加失败','jump_url'=>'/wfpcAdmin/article/article-list','msg'=>L::t(30001));
			return $this->render('/default/error',$r);
        }
    }
    
	/**
     * @Author pwr at 2018-02-08
     * @name actionArticleDelete
     * @todo 文章删除
     */
	public function actionArticleDelete(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		if($id>0){
            $m = new Article();
            $check = $m->getArticleById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_delete'=>1,
					'update_time'=>time(),
				);
                $u = $m->updateArticleById($id,$update_data);
				$this->successResult(array('u'=>$u));
            }else{
				$this->errorResult(30001);
            }
        }else{
			$this->errorResult(30001);
        }
	}
	
    /**
     * @Author pwr at 2018-02-08
     * @name actionArticleCateList
     * @todo 文章分类列表
     */
    public function actionArticleCateList(){
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
        
        $l = new ArticleLogic();
        $where['is_delete'] = 0;
		if($title!=''){
			$where['like_'][] = array('like','title',$title);
		}
        if($id>0){
            $where = array('id'=>$id,'is_delete'=>0);
        }
        $count = $l->getArticleCateList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getArticleCateList($where,$page,$pageSize,0,'sort desc, id desc');
        }
        //var_dump($data);die();
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
        //返回请求参数
        $get_data = array('id'=>$id,'title'=>$title);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'get_data'=>$get_data);
        //调用视图
        return $this->render('articleCateList',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

	/**
     * @Author pwr at 2018-02-08
     * @name actionArticleCateDetails
     * @todo 文章分类编辑详情
     */
    public function actionArticleCateDetails(){
        $request = Yii::$app->request->get();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $data = array();
        
        $l = new ArticleLogic();
        if($id>0){
            $d = $l->getArticleCateData($id);
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
			return $this->render('articleCateEdit',$r);
		}else{
			$r = array('tips'=>'請求失敗','jump_url'=>'/wfpcAdmin/article/article-cate-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
		}
    }
	
	/**
     * @Author pwr at 2018-02-08
     * @name actionArticleCateEdit
     * @todo 文章分类更新
     */
    public function actionArticleCateEdit(){
        $request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $is_delete = isset($request['is_delete']) && $request['is_delete']>0 ? (int)$request['is_delete'] : 0;
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $pid = isset($request['pid']) && $request['pid']>0 ? (int)$request['pid'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
		$brief = isset($request['brief']) && $request['brief']!='' ? (string)$request['brief'] : '';
        $brief = trim(strip_tags($brief));
        $icon = isset($request['icon']) && $request['icon']!='' ? (string)$request['icon'] : '';
        $icon = trim(strip_tags($icon));

        if($id>0){
            $m = new ArticleCate();
            $check = $m->getArticleCateById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'title'=>$title,
					'brief'=>$brief,
					'pid'=>$pid,
					'sort'=>$sort,
					'icon'=>$icon,
				);
                if($is_delete==1){
                    $update_data = array('is_delete'=>1,'editor_id'=>0,'editor_name'=>'');
                }
				//var_dump($update_data);die();
                $u = $m->updateArticleCateById($id,$update_data);
				//var_dump($u);
                //return $this->successResult(array('u'=>$u));
				$r = array('tips'=>'更新成功','jump_url'=>'/wfpcAdmin/article/article-cate-list');
				return $this->render('/default/success',$r);
            }else{
				$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/article/article-cate-list','msg'=>L::t(30001));
                return $this->render('/default/error',$r);
            }
        }else{
			$r = array('tips'=>'更新失敗','jump_url'=>'/wfpcAdmin/article/article-cate-list','msg'=>L::t(30001));
            return $this->render('/default/error',$r);
        }
    }
	
	/**
     * @Author pwr at 2018-02-08
     * @name actionArticleCateAdd
     * @todo 文章分类添加
     */
    public function actionArticleCateAdd(){
        $request = Yii::$app->request->post();
		if(empty($request)){
			return $this->render('articleCateAdd',array());
		}
        $sort = isset($request['sort']) && $request['sort']>0 ? (int)$request['sort'] : 0;
        $pid = isset($request['pid']) && $request['pid']>0 ? (int)$request['pid'] : 0;
        $title = isset($request['title']) && $request['title']!='' ? (string)$request['title'] : '';
        $title = trim(strip_tags($title));
		$brief = isset($request['brief']) && $request['brief']!='' ? (string)$request['brief'] : '';
        $brief = trim(strip_tags($brief));
        $icon = isset($request['icon']) && $request['icon']!='' ? (string)$request['icon'] : '';
        $icon = trim(strip_tags($icon));

        if($title!=''){
            $update_data = array(
				'title'=>$title,
				'brief'=>$brief,
				'pid'=>$pid,
				'sort'=>$sort,
				'icon'=>$icon,
			);
			
            $m = new ArticleCate();
            $u = $m->addArticleCate($update_data);
			if($u>0){
				$r = array('tips'=>'添加成功','jump_url'=>'/wfpcAdmin/article/article-cate-list');
				return $this->render('/default/success',$r);
			}else{
				$r = array('tips'=>'添加失败','jump_url'=>'/wfpcAdmin/article/article-cate-list','msg'=>L::t(30999));
				return $this->render('/default/error',$r);
			}
        }else{
			$r = array('tips'=>'添加失败','jump_url'=>'/wfpcAdmin/article/article-cate-list','msg'=>L::t(30001));
			return $this->render('/default/error',$r);
        }
    }
	
	/**
     * @Author pwr at 2018-02-08
     * @name actionArticleCateDelete
     * @todo 文章分类删除
     */
	public function actionArticleCateDelete(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
		if($id>0){
            $m = new ArticleCate();
            $check = $m->getArticleCateById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_delete'=>1,
				);
                $u = $m->updateArticleCateById($id,$update_data);
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
     * @name actionArticlePublish
     * @todo 文章发布
     */
	public function actionArticlePublish(){
		$request = Yii::$app->request->post();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $is_publish = isset($request['is_publish']) && $request['is_publish']==1 ? 1 : 0;
		if($id>0){
            $m = new Article();
            $check = $m->getArticleById($id);
            if(!empty($check) && $check['is_delete']==0){
                $update_data = array(
					'is_publish'=>$is_publish,
					'update_time'=>time(),
				);
                $u = $m->updateArticleById($id,$update_data);
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
     * @todo 文章发布数量获取
     */
	public function actionGetPublishCount(){
		//$request = Yii::$app->request->post();
		$l = new ArticleLogic();
		$publish_count = $l->getArticleList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
		$no_publish_count = $l->getArticleList(array('is_delete'=>0,'is_publish'=>0),1,1,1);
		
		$this->successResult(array('publish_count'=>$publish_count,'no_publish_count'=>$no_publish_count));
	}
	
	
}