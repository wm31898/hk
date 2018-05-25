<?php
namespace app\modules\pc\controllers;

use yii;
use yii\web\Controller;
use app\controllers\PcCommonController;
use yii\data\Pagination;
use app\component\L;

use app\logic\NewsLogic;
use app\models\News;
use app\models\NewsCate;
/**
 * Default controller for the `pc` module
 */
class NewsController extends PcCommonController//PcCommonController Controller
{
	// 关闭视图布局
    //public $layout = false;
	
    /**
	 * @Author pwr at 2018-04-11
	 * @name actionIndex
	 * @todo 新闻列表
	 */
    public function actionIndex(){
		//die('Home Index');

        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        //$id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $cate_id = isset($request['cate_id']) && $request['cate_id']>0 ? (int)$request['cate_id'] : 0;

        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 5;
        //print_r($title);exit;
        $l = new NewsLogic();
        //先列出新闻分类
        $cate_list=array();
        $cate_list = $l->getNewsCateList(array('is_delete'=>0),1,4,0,'sort desc, id desc');

        $where['is_delete'] = 0;
        $where['is_publish'] = 1;

        $get_data = array();
        if($cate_id>0){
            $where['cate_id'] = $cate_id;
        } else {
            //$where['cate_id'] = 1;
            //$where['like_'][] = array('like','title','新闻中心');
            //$cate_id = 1;
            if (!empty($cate_list)) { //如果新闻分类id的表存在
                $cate_id = $cate_list[0]['id'];
                $where['cate_id'] = $cate_list[0]['id'];
            } else {
                $cate_id=0;//新闻分类id不存在就设置为0
            }
        }

        $count = $l->getNewsList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getNewsList($where,$page,$pageSize,0,'sort desc, id desc');
        }
        //var_dump($data);die();
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize,'defaultPageSize'=>5]);
        //返回请求参数

        $get_data = array('cate_id'=>$cate_id);


        //print_r($cate_list);exit;
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'get_data'=>$get_data,'cate_list'=>$cate_list);
        //调用视图
        return $this->render('index',$r);

        //return $this->render('index');
    }
	
	/**
	 * @Author pwr at 2018-04-11
	 * @name actionDetails
	 * @todo 新闻详情
	 */
    public function actionDetails(){
		//die('Home Index');
        $request = Yii::$app->request->get();
        $id = isset($request['id']) && $request['id']>0 ? (int)$request['id'] : 0;
        $data = array();
        $l = new NewsLogic();
        if($id>0){
            $d = $l->getNewsData($id);
            if(!empty($d) && $d['is_delete']==0){
                $data = $d;
            }else {
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/');//错误返回首页
                die();
            }
        } else {
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/');//错误返回首页
            die();
        }

        if(!empty($data)){
            //查询上-篇文章
			$prev_article = $l->getNewsList(array('is_delete'=>0,'is_publish'=>1,'max_'=>array(array('<', 'id', $id))),1,1,0,'id desc');

            //查询下-篇文章
			$next_article = $l->getNewsList(array('is_delete'=>0,'is_publish'=>1,'max_'=>array(array('>', 'id', $id))),1,1,0,'id asc');

            $r = array('data'=>$data,'prev_article' => $prev_article,'next_article'=>$next_article );
            //调用视图
            return $this->render('details',$r);
        }else{
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/');//错误返回首页
			die();
        }


    }
}
