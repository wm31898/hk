<?php

namespace app\controllers;

//use app\models\ServiceApiLog;
use Yii;
use app\component\ErrorCode;
use app\component\L;
use app\component\Helpers;
use yii\web\Controller;
use app\logic\AdminUserLogic;
use app\models\AdminUser;

/**
 * @Author pwr at 2017-05-27
 * @name AdminApiController
 * @todo 后台接口公共类
*/
class AdminApiController extends Controller
{
    // 关闭视图布局
    public $layout = false;

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

        // java接口地址
        $this->javaApiAddr = Yii::$app->params['javaApiAddr'];
        
        //设定接口开始访问时间
        $this->start_time = time();
    }
    
    public function json($arr, $output = true)
    {
        //开启API慢响应日志
        /*if(Yii::$app->params['openApiSlowLog']){
            $ot = time()-$this->start_time;
            if($ot>2 && $this->start_time>0){
                $c = json_encode($_REQUEST);
                $body = file_get_contents('php://input');
                $word = "[". date('Y-m-d H:i:s') ."] [Timeout: ".$ot."] [URL: ".Yii::$app->request->getUrl()."] [REQUEST: ".$c."] [BODY: ".$body."]\r\n";
                (new ServiceApiLog())->fileLog($word,'api_timeout');
            }
        }*/
        
        $content = json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (! $output) {
            return $content;
        }

        // 跨域处理
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        $allow_origin = [
            'http://devxyadmin.wufu360.com',//开发环境
            'http://testxyadmin.wufu360.com:8034',//测试环境
            'http://xyadminpre.aiwufu.com',//线上预发布
			'http://xyadmin.aiwufu.com',//线上环境
			'http://admin.wufuedu.com',//线上环境（新域名）
        ];
        if (in_array($origin, $allow_origin)) {
            header('Access-Control-Allow-Origin: ' . $origin);    
        }

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
        //$this->checkPermission();//原始的检查校验
        //$this->vaidPermission();
        return true;
    }


    /*  //隐藏
    protected function checkPermission()
    {
        $module = Yii::$app->controller->module->id;
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $userAccount = self::$request->post('userAccount', '');
        $token = self::$request->post('token', '');
        $ipAddr = self::$request->userIP;

        //上传图片接口跳过验证
        if($controller=='default' && $action=='upload-image' && $token!=''){
            return true;
        }

        $path = "/$module/$controller/$action";
        $postData = compact('token', 'ipAddr','userAccount');
		$postData['timestamp'] = date('YmdHis',time());
		$postData['requestId'] = time();
		$postData = json_encode($postData);

        if (Yii::$app->params['useRedisCache']) {
            $cacheKey = Helpers::genCacheKey($token, 'permission');
            $data = Yii::$app->cacheRedis->get($cacheKey);
            if ($data === false) {
                $data = json_decode($this->curlPost($this->javaApiAddr . '/userCenter/user/valid', $postData), true);
                Yii::$app->cacheRedis->set($cacheKey, $data, 60);
                //$d = ['servicePath'=>$this->javaApiAddr . '/userCenter/user/valid', 'parameter'=>$postData, 'returnData'=>json_encode($data)];
                //$log = new ServiceApiLog();
                //$log->addReceiveLog($d);
                //$log->fileLog(json_encode($data), 'user_valid');
            }
        } else {
            $data = json_decode($this->curlPost($this->javaApiAddr . '/userCenter/user/valid', $postData), true);
        }
		//var_dump($data);die();
        isset($data['code']) or $this->errorResult(10339);
        $data['code'] == '10000' or $this->json(['code' => $data['code'], 'msg' => $data['msg']]);

		if(!isset($data['data']['userInfo'])){
			$this->errorResult(10339);
		}
		
		if(!isset($data['data']['userInfo']['userId']) || !isset($data['data']['userInfo']['userName']) || !isset($data['data']['userInfo']['loginAccount']) || !isset($data['data']['roleType'])){
			$this->errorResult(10339);//返回值验证
		}
		
        // user_type 1:代理商 2:商家 3:大后台管理员
        $this->user['user_id'] = $data['data']['userInfo']['userId'];
        $this->user['user_name'] = $data['data']['userInfo']['userName'];
        $this->user['login_account'] = $data['data']['userInfo']['loginAccount'];
        $this->user['user_type'] = $data['data']['roleType'];
        if ($this->user['user_type'] == 2) {
            $this->user['supplier_id'] = $data['data']['userInfo']['supplierId'];
        }
        //if (in_array($this->user['user_type'], [3, 4]))
        //    in_array($path, $data['data']['accessibleList']) or $this->errorResult(10340);
    }*/

    //2017-11-10  修改者   wolf
    protected function vaidPermission(){
        //vaidToken
        $module = Yii::$app->controller->module->id;
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $userAccount = self::$request->post('userAccount', '');
        $token = self::$request->post('token', '');
        //$ipAddr = self::$request->userIP;

        $adm = new AdminUserLogic();
        $path = "/$module/$controller/$action";
        //如果是登录状态
        if($path == '/admin/admin/login' && $token=='' || $path == '/admin/admin/dropcache' || $path == '/admin/admin/vaild' || $path == '/admin/default/upload-image') {
            return true;
        }
        //print_r($path.'---'.$token);exit;
        $dataarr['userAccount'] = $userAccount;
        $dataarr['token'] = $token;

        if (Yii::$app->params['useRedisCache']) { //是否缓存状态
            $data = $adm->vaidToken($dataarr);//校验token
        } else {
            return false;//没有开启缓存
        }

        //var_dump($data['code']);die();
        isset($data['code']) or $this->errorResult(10339);
        $data['code'] == '10000' or $this->json(['code' => $data['code'], 'msg' => $data['msg']]);

        $this->user['login_account'] = $userAccount;
        if($data['user_id']!='') {
            $this->user['user_id'] = $data['user_id'];
        }
        //print_r($data);exit;
    }

    /**
     * POST提交数据
     * @param $fields string|array raw|form-data
     * @param $header array HTTP头
     * @param $timeout integer 服务端处理超时（秒）
     * @return mixed
     */
    protected function curlPost($url, $fields = '', $header = ['Content-Type: application/json; charset=utf-8'], $timeout = 3)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
