<?php

namespace app\modules\wfpcAdmin\controllers;

use yii;
use yii\web\Controller;
use app\controllers\AdminCommonController;
use app\component\Alioss;
use app\models\UploadForm;

/**
 * Default controller for the `wfpcAdmin` module
 */
class DefaultController extends AdminCommonController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	/**
	 * @Author pwr at 2018-01-31
	 * @name actionUploadImage
	 * @todo 商学院上传图片
	 */
    public function actionUploadImage(){
		$request = Yii::$app->request->post();
		$folder_type = isset($request['folder_type']) && $request['folder_type']>0 ? (int)$request['folder_type'] : 0;
		$folder_name = array('wftzimg','wftzads','wftzother');
		if(isset($folder_name[$folder_type]) && $folder_name[$folder_type]!=''){
			$fm = $folder_name[$folder_type];
		}else{
			$fm = 'wftzother';
		}
		$f_n = isset($request['f_n']) && $request['f_n']!='' ? (string)$request['f_n'] : 'image';
		//缩略图：http://img.aiwufu.com/goods/1496246400/14963049456221.jpeg?x-oss-process=image/resize,m_fixed,h_100,w_100
		$m = new Alioss();
		//var_dump($_FILES[$f_n]);die();
		if(!empty($_FILES) && !empty($_FILES[$f_n])){
			$t = explode('/',$_FILES[$f_n]['type']);
			if($t[1]=='octet-stream' && $f_n=='upfile'){
				$ft = explode('.',$_FILES[$f_n]['name']);
				$t[1] = (string)$ft[1];
			}else if(!in_array($t[1],array('jpeg','png','gif'))){
				return $this->errorResult(31008);
			}
			
			if(Yii::$app->params['useOss']){
				$type = $t[1];
				$filePath = $_FILES[$f_n]['tmp_name'];
				$object = $fm.'/'.strtotime(date('Y-m-d',time())).'/'.time().rand(1000,9999).'.'.$type;
				$u = $m->uploadFile($object, $filePath);
				if(!empty($u) && $u['info']['url']!=''){
					$r = array(
						'path'=>$object,
						'url'=>Yii::$app->params['imageUrl'].$object,
					);
					return $this->successResult($r);
				}else{
					return $this->errorResult(31006);
				}
			}else{
				$model = new UploadForm();
				$u = $model->upload($f_n,$fm.'/'.strtotime(date('Y-m-d',time())));
				if(!empty($u) && $u['code']==200 && !empty($u['files']) && isset($u['files'][0]['data'])){
					unset($u['files'][0]['data']['tempName']);
					return $this->successResult($u['files'][0]['data']);
				}else{
					return $this->errorResult(31006);
				}
			}
			
		}
		else if(!empty($_FILES) && !empty($_FILES['images']) && !empty($_FILES['images']['type']) && is_array($_FILES['images']['type'])){
			$r = array();
			if(Yii::$app->params['useOss']){
				foreach($_FILES['images']['type'] as $k=>$v){
					$t = explode('/',$v);
					if(!in_array($t[1],array('jpeg','png','gif'))){
						return $this->errorResult(31008);
					}
					$type = $t[1];
					$filePath = $_FILES['images']['tmp_name'][$k];
					$object = $fm.'/'.strtotime(date('Y-m-d',time())).'/'.time().rand(1000,9999).'.'.$type;
					$u = $m->uploadFile($object, $filePath);
					if(!empty($u) && $u['info']['url']!=''){
						$r[] = array(
							'path'=>$object,
							'url'=>Yii::$app->params['imageUrl'].$object,
						);	
					}
				}
			}else{
				$model = new UploadForm();
				$u = $model->upload('images',$fm.'/'.strtotime(date('Y-m-d',time())));
				if(!empty($u) && $u['code']==200 && !empty($u['files'])){
					foreach($u['files'] as $v){
						unset($v['data']['tempName']);
						$r[] = $v['data'];
					}
					return $this->successResult($r);
				}else{
					return $this->errorResult(31006);
				}
			}
			
			if(!empty($r)){
				return $this->successResult($r);
			}else{
				return $this->errorResult(31006);
			}
		}
		else{
			return $this->errorResult(31007);
		}
		die('ok');
	}
}
