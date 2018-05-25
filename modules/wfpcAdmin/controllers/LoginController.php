<?php

namespace app\modules\wfpcAdmin\controllers;

use yii;
use yii\web\Controller;
use app\controllers\AdminCommonController;
use app\logic\AdminUserLogic;
use app\models\AdminUser;

/**
 * Default controller for the `wfpcAdmin` module
 */
class LoginController extends AdminCommonController//Controller
{
	public $layout = false;

    /**
     * Created by PhpStorm.
     * User: wolf
     * Date: 2018/01/30
     * Time: 9:35
     * 后台登录的页面
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        $user_id = $session->readSession('user_id');
        $userid = isset($user_id) && $user_id>0 ? (int)$user_id : 0;//用户名
        $params = array('userid'=>$userid);//用于在前台判断是否登录的变量

        if ($userid>0) {
            header('Location: home/index');//是否登录状态
        }
        return $this->render('index',$params);
    }
	
	public function actionAjaxlogin(){

        $session = Yii::$app->session;
		$request = Yii::$app->request->post();
        $username = isset($request['username']) && $request['username']!='' ? (string)$request['username'] : '';//用户名
        //return $this->errorResult($session->readSession('authcode'));//
		if($username == '' ){
             return $this->errorResult('用户不能为空');//用户不能为空
        }
		
		$pwd = isset($request['pwd']) && $request['pwd']!='' ? (string)$request['pwd'] : '';//用户名
		if($pwd == '' ){
             return $this->errorResult('密码不能为空');//密码不能为空
        }

        //
        //$authcode = '';
        $authcode = $session->get('authcode');
        //$authcode = $session->readSession('authcode');
        //return $this->errorResult($authcode);//不能为空
        $yzm = isset($request['yzm']) && $request['yzm']!='' ? (string)$request['yzm'] : '';//验证码
        if($yzm == '') {
            return $this->errorResult('验证码不能为空');//不能为空
        }

        if($authcode != $yzm) {
            return $this->errorResult('验证码不正确');//
        }

		/*$timestamp = isset($request['timestamp']) && $request['timestamp']!='' ? (string)$request['timestamp'] : '';//时间戳
		if($timestamp == '' ){
             return $this->errorResult(50023);//当前时间不能为空
        }*/

		//组装数组
		$arr_name = [
            'login_account' => $username,
            'is_delete' => 0
         ];
        $m = new AdminUser();
        //$data = $adm->loginUser($arr_name,$timestamp);
		$data_arr = array();
        $data_arr = $m->getAdminuserByUser($arr_name);//查询该账号相关信息 用于查询账号、密码、是否禁用等等
		
		if(empty($data_arr) || $data_arr == '' || $data_arr == null ) {
			return $this->errorResult('该账号不存在');//该账号不存在
		} 

		//if($data_arr['is_delete'] == 1) {
		//	return $this->errorResult(50007);//该账号已删除
		//}

		if ( $data_arr['password']  != md5($pwd)  ) {
			return $this->errorResult('账号密码错误');//账号密码错误
		}

        //$arr_name['user_id'] = $data_arr['id'];
		//登录校验  并且生成token
		$data = array (
			'code' => '10000',
			'msg'=> '登录成功'
		);
		//$session = Yii::$app->session;
        $data_array = [
            'user_id'=>$data_arr['id'],
            'login_account'=>$data_arr['login_account'],
            'role_id'=>$data_arr['role_id'],
            'penultimate_login_date'=>$data_arr['penultimate_login_date'],
            'user_name'=>$data_arr['user_name']
        ];
		$session->set('user_data', $data_array);

		$da = array(
		    'last_login_date' => time(),//当前时间
            'penultimate_login_date'=>$data_arr['last_login_date'] //上次登录的时间
        );
        $result =$m->updateAdminUserById($data_arr['id'],$da);


        /*$session->writeSession('user_id',$data_arr['id']);//存到session里
        $session->writeSession('login_account',$data_arr['login_account']);//存到session里
        $session->writeSession('role_id',$data_arr['role_id']);//存到session里
        $session->writeSession('user_name',$data_arr['user_name']);//存到session里*/

		return $this->successResult($data);
		//return $data_arr;
	}

    //登录退出
	function actionAjaxlogout(){
        $session = Yii::$app->session;
        /*$session->destroySession('user_id');
        $session->destroySession('login_account');
        $session->destroySession('role_id');
        $session->destroySession('user_name');*/
        //print_r(123);exit;
        $session->remove('user_data');
        //header('Location: login');//是否登录状态
    }
}
