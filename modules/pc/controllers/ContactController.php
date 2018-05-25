<?php

namespace app\modules\pc\controllers;

use yii;
use yii\web\Controller;
use app\controllers\PcCommonController;
use yii\data\Pagination;
use app\component\L;

/**
 * Default controller for the `pc` module
 */
class ContactController extends PcCommonController//PcCommonController Controller
{
	// 关闭视图布局
    //public $layout = false;
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(){
		//die('Home Index');
        return $this->render('/home/contact');
    }
}
