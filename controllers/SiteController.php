<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
	public $layout = false;
	
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        die('site index');
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}
