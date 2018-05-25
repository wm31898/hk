<?php
namespace app\modules\wfpcAdmin\controllers;

use yii;
use yii\web\Controller;
use app\controllers\AdminCommonController;
use yii\data\Pagination;
use app\component\L;
use app\models\AdminUser;
use app\logic\GoodsLogic;
use app\logic\ArticleLogic;
use app\logic\NewsLogic;

/**
 * Default controller for the `wfpcAdmin` module
 */
class HomeController extends AdminCommonController//Controller
{
	public $page_js = array();//加载视图额外js
	
    /**
     * @Author pwr at 2018-04-08
     * @name actionIndex
     * @todo 官网后台首页
     */
    public function actionIndex(){
		//商品发布数量获取
		$l = new GoodsLogic();
		$goods_publish_count = $l->getGoodsList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
		
		//文章发布数量获取
		$l = new ArticleLogic();
		$article_publish_count = $l->getArticleList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
		
		//新闻发布数量获取
		$l = new NewsLogic();
		$news_publish_count = $l->getNewsList(array('is_delete'=>0,'is_publish'=>1),1,1,1);
		$r = array('goods_publish_count'=>$goods_publish_count,'article_publish_count'=>$article_publish_count,'news_publish_count'=>$news_publish_count,'user'=>$this->user);
		return $this->render('index',$r);
    }
	
	/**
     * @Author pwr at 2018-04-08
     * @name actionHomeList
     * @todo 列表规范
     */
    public function actionHomeList(){		
    	$pages = new Pagination(['totalCount' =>100, 'pageSize' =>5]);
		$r = array('pages'=>$pages,'test'=>111);
		return $this->render('homeList',$r);
    }
	
	/**
     * @Author pwr at 2018-04-08
     * @name actionHomeTwo
     * @todo 编辑页规范
     */
	public function actionHomeTwo(){
		$data = array(
			'text1'=>'内容1',
			'text2'=>'输入框内容222',
			'content'=>'<p>文本框内容111</p>',
			'day'=>'2018-01-01 09:30:00',
		);
		$r = array('data'=>$data);
        return $this->render('homeTwo',$r);
    }
	
	


    /*
     * 修改密码页面
     *  wolf 创建2018-04-09
     * */
    public function actionPsw(){
        return $this->render('psw');
    }

    /*
     * 密码校验
     * wolf 创建2018-04-09
     * */
    public function actionValid () {
        $request = Yii::$app->request->post();
        $old_psw = isset($request['old_psw']) && $request['old_psw']!='' ? (string)$request['old_psw'] : '';//密码
        if( $old_psw == '' ) {
            return $this->errorResult('对不起，原始密码不能为空!');//
        }

        if($this->user['user_id'] < 0  ) {
            return $this->errorResult('对不起，请重新登录!');//密码不能为空
        }
        //组装数组
        $arr_list = [
            'id' => $this->user['user_id']
        ];
        $m = new AdminUser();
        //$data = $adm->loginUser($arr_name,$timestamp);
        $data_arr = array();
        $data_arr = $m->getAdminuserByUser($arr_list);//查询该账号相关信息 用于查询账号、密码、是否禁用等等

        if(empty($data_arr) || $data_arr == '' || $data_arr == null ) {
            return $this->errorResult('对不起，信息错误');//
        }

        //if($data_arr['is_delete'] == 1) {
        //	return $this->errorResult(50007);//该账号已删除
        //}

        if ( $data_arr['password']  != md5($old_psw)  ) {
            return $this->errorResult('原始密码不准确');//密码错误
        }

        $sure_psw = isset($request['sure_psw']) && $request['sure_psw']!='' ? (string)$request['sure_psw'] : '';
        if( $sure_psw == '' ) {
            return $this->errorResult('对不起，确认密码不能为空!');//
        }
        $l = new AdminUser();
        $update_data = array(
            'password'=>md5($sure_psw),
        );
        $u = $l->updateAdminUserById($this->user['user_id'],$update_data);
        if($u>0){
            $data = array (
                'code' => '10000',
                'msg'=> '修改成功'
            );
        } else {
            return $this->errorResult('对不起，修改失败!');//操作失败
        }

        return $this->successResult($data);
    }


	public function actionMyTest()
    {
		$session = Yii::$app->session;
		//$session->set('user_id', 5);
		//$u = $session->set('user_data',array('id'=>10,'name'=>'admin'));
		$u = $session->get('user_data');
		var_dump($u);
		//$user_id = $session->readSession('user_id');
		///$login_account = $session->readSession('login_account');
		//var_dump($user_id);
		//var_dump($login_account);
		//session_start();
		//$_SESSION['user_data'] = array('id'=>10,'name'=>'admin');
		var_dump($_SESSION);
		
		//$cache = Yii::$app->cacheRedis;
		//$data = $cache->get('f17aa6e9bbff040e505e3eec435314abe0c3b');
		//var_dump($data);
		die('ok');

		//$a = Yii::$app->params['adminCssUrl'];
		//$a2 = Yii::$app->params['adminJsUrl'];
		//var_dump($a);
		//var_dump($a2);
		//die();
    }
	
	
	/**
	 * @Author pwr at 2018-02-01
	 * @name actions
	 * @todo 定义captcah验证码，和默认错误展示页面 注意：方法名为actions
	 */
    /*public function actions()
    {
        return [
        //验证码action
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? '123456' : '9870',
                'backColor'=>0x000000,//背景颜色
                'maxLength' => 5, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 3,//间距
                'height'=>34,//高度
                'width' => 90,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4        //设置字符偏移量 有效果
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
		
		
		模板页面添加：	
		
		<?php use yii\captcha\Captcha; ?>
		<!-- 验证码输出，调用Captcha类下的widget方法，需传入必要的配置信息，name属性必须要传入，captchaAction属性指定是哪个控制器下的哪个方法，site/captcha就是上文我们在SiteController的actions中定义的验证码方法（其实在SiteCOntroller中的actions定义的，可以不添加该项，因为默认是SiteController，如果是在其他控制器中定义的，则必须添加该项）。imageOptions可以制定一些html标签属性属性，template指定模板，这里只输出img标签，故只用了{image} -->
		<?=Captcha::widget(['name'=>'captcha-img','captchaAction'=>'/wfpcAdmin/home/captcha','imageOptions'=>['id'=>'captcha-img', 'title'=>'换一个', 'style'=>'cursor:pointer;'],'template'=>'{image}']);?>
		
    }*/
}
