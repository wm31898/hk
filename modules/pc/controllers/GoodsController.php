<?php
namespace app\modules\pc\controllers;

use yii;
use yii\web\Controller;
use app\controllers\PcCommonController;
use yii\data\Pagination;
use app\component\L;

use app\logic\GoodsLogic;
use app\models\Goods;
use app\models\GoodsType;

/**
 * Default controller for the `pc` module
 */
class GoodsController extends PcCommonController//Controller
{
    public $page_js = array();//加载视图额外js

    /**
     * @Author pwr at 2018-04-08
     * @name actionIndex
     * @todo 商品列表
     */
    public function actionIndex(){
        $request = Yii::$app->request->get();
        $page = isset($request['page']) && $request['page']>0 ? (int)$request['page'] : 1;
        $cate_id = isset($request['c']) && $request['c']>0 ? (int)$request['c'] : 0;
        $data = array(
            'pageCount'=>0,
            'list'=>array(),
        );
        $pageSize = 9;
        
        $l = new GoodsLogic();
		
		//商品分类列表
		$cate_list = $l->getGoodsTypeList(array('is_delete'=>0),1,3);
		if($cate_id==0 && !empty($cate_list)){
			foreach($cate_list as $v){
				$cate_id = $v['id'];
				break;
			}
		}
		
        $where['is_delete'] = 0;
        $where['is_publish'] = 1;
        if($cate_id>0){
            $where['cate_id'] = $cate_id;
        }
        $count = $l->getGoodsList($where,1,1,1);
        if($count>0){
            $data['pageCount'] = ceil($count/$pageSize);
            $data['list'] = $l->getGoodsList($where,$page,$pageSize,0,'sort desc, id desc');
        }
		//var_dump($data);die();
		
        //翻页类
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' =>$pageSize,'defaultPageSize'=>9]);
		
		//返回请求参数
        $get_data = array('cate_id'=>$cate_id);
		
        //生成返回参数
        $r = array('pages'=>$pages,'data'=>$data,'cate_list'=>$cate_list,'get_data'=>$get_data);
        //调用视图
        return $this->render('index',$r);

        //return $this->successResult($data);
        //die('AdsList');
    }

    /**
     * @Author pwr at 2018-04-08
     * @name actionDetails
     * @todo 商品编辑详情
     */
    public function actionDetails(){
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
			//返回请求参数
			$get_data = array('id'=>$id);
			//生成返回参数
			$r = array('data'=>$data,'get_data'=>$get_data);
			//调用视图
			return $this->render('details',$r);
		}else{
			header('Location: http://'.$_SERVER['SERVER_NAME'].'/');//错误返回首页
			die();
		}
    }
    
	
}