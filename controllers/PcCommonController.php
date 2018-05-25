<?php

namespace app\controllers;

//use app\models\ServiceApiLog;
use Yii;
use app\component\ErrorCode;
use app\component\L;
use app\component\Helpers;
use yii\web\Controller;
//use app\logic\AdminUserLogic;
//use app\models\AdminUser;
use  yii\web\Session;

/**
 * @Author pwr at 2018-01-26
 * @name AdminCommonController
 * @todo 后台控制器公共类
*/
class PcCommonController extends Controller
{
    // 关闭视图布局
    public $layout = 'main';

    // 关闭csrf验证
    public $enableCsrfValidation = false;

    // user数组
    public $user = [];

    // 请求数据
    public static $request = null;

    // java接口地址
    public $javaApiAddr = '';
    
    public $start_time = 0;

    public function init()
    {
        // 请求对象
        self::$request = Yii::$app->request;
    }
    
    public function json($arr, $output = true){
        $content = json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (! $output) {
            return $content;
        }

        // 跨域处理
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        $allow_origin = array();
        if (in_array($origin, $allow_origin)) {
            header('Access-Control-Allow-Origin: ' . $origin);    
        }
		header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');
        exit($content);
    }

    /***
     * add by china
     * 正确时返回
     * @param $result
     * @param bool $output
     * @return string
     */
    public function successResult($result, $output = true)
    {
        $arr['data'] = $result;
        $arr['code'] = ErrorCode::NORMAL;
        return $this->json($arr, $output);
    }

    /***
     * add by china
     * 出错时返回方法
     * @param $result
     * @param bool $output
     * @return string
     */
    public function errorResult($result, $output = true)
    {
        $arr = [];
        if (is_numeric($result))
        {
            $arr['code'] = intval($result);
            $arr['msg'] = L::t($result);
        }elseif (is_array($result))
        {
            $arr = $result;
        }
        if (!isset($arr['code']))
        {
            $arr['code'] = intval(ErrorCode::UNKNOWN_ERROR_TYPE);
            $arr['msg'] = is_string($result)?$result:L::t(ErrorCode::UNKNOWN_ERROR_TYPE);
        }
        return $this->json($arr, $output);
    }

    public function beforeAction($action)
    {
        return true;
    }
}
