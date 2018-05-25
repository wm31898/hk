<?php
namespace app\modules\pc\controllers;

use yii;
use yii\web\Controller;
use app\controllers\PcCommonController;
use yii\data\Pagination;
use app\component\L;

use app\logic\ArticleLogic;

/**
 * Default controller for the `pc` module
 */
class ArticleController extends PcCommonController//Controller
{
    public $page_js = array();//加载视图额外js
	public $title = '';
	public $details_cate = '';//文章详情对应的分类ID，控制栏目选择中情况
	
	/**
     * @Author pwr at 2018-04-11
     * @name actionIndex
     * @todo 日照中心列表
     */
    public function actionIndex(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $cate_id = 1;
        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 10;
        
        $l = new ArticleLogic();
        $where = array('is_delete'=>0,'is_publish'=>1,'cate_id'=>$cate_id);
        $count = $l->getArticleList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getArticleList($where,$page,$pageSize,0,'sort desc, id desc');
        }
		//var_dump($data);die();
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data);
        //调用视图
        return $this->render('rizhao',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }
	
	/**
     * @Author pwr at 2018-04-11
     * @name actionProvidePatterns
     * @todo 养老模式
     */
    public function actionProvidePatterns(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $cate_id = 2;
        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 10;
        
        $l = new ArticleLogic();
        $where = array('is_delete'=>0,'is_publish'=>1,'cate_id'=>$cate_id);
        $count = $l->getArticleList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getArticleList($where,$page,$pageSize,0,'sort desc, id desc');
        }
		//var_dump($data);die();
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data);
        //调用视图
        return $this->render('patterns',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

	/**
     * @Author pwr at 2018-04-11
     * @name actionProvideBase
     * @todo 养老基地
     */
    public function actionProvideBase(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $cate_id = 3;
        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 10;
        
        $l = new ArticleLogic();
        $where = array('is_delete'=>0,'is_publish'=>1,'cate_id'=>$cate_id);
        $count = $l->getArticleList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getArticleList($where,$page,$pageSize,0,'sort desc, id desc');
        }
		
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize]);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data);
        //调用视图
        return $this->render('base',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

    /**
     * @Author pwr at 2018-02-08
     * @name actionDetails
     * @todo 文章编辑详情
     */
    public function actionDetails(){
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
		//var_dump($data);die();
		if(!empty($data)){
			
			$this->details_cate = $data['cate_id'];
			
			//生成返回参数
			$r = array('data'=>$data);
			//调用视图
			return $this->render('details',$r);
		}else{
			header('Location: http://'.$_SERVER['SERVER_NAME'].'/');//错误返回首页
			die();
		}
    }
    
	
}