<?php

namespace app\component;

use app\models\ServiceApiLog;
use app\component\HttpClient;
use yii;

//阿里大于 短信平台
class Sms
{
    /**
     * 错误码
     * @var integer
     */
    public static $errcode = 0;
	
	public static $err_array = array();
	
	/**
	   以下是新版本
     * 发送短信接口  //用的是阿里大于的 短信平台
     * @param string $mobile 手机号
     * @param string $content 对于不同内容传不同的值，比如是商家提醒，传入商家名称；比如是验证码就传入验证码0123；
     * @param string $sign 标识不同模板，比如是验证码模板不用传值，比如是 发货通知就传入1   
     * @param integer $accessWay 增补参数，如果为空不用传值
     * @return boolean 发送是否成功
     */ 
    public static function send($mobile, $content, $sign = 0, $accessWay = 1) 
    {
		$word = "[". date('Y-m-d H:i:s') ."] [mobile: ".$mobile."] [content: ".$content."] [sign: ".$sign."] [accessWay: ".$accessWay."] \r\n";
		(new ServiceApiLog())->fileLog($word,'sms_uses');
			
        if (!$mobile){
            self::$errcode = 50014;//手机号不能为空
            return false;
        }
		
		if (!$content){
            self::$errcode = 50023;//内容不能为空
            return false;
        }
		
		$smsParamMap = array();
		switch ($sign)
		{
			case 0:  //发送验证码
				$templateSign = 1;
				$smsParamMap = array('code'=>$content);
				break;  
			case 1:  //  发货通知 
				$templateSign = 2;
				$smsParamMap = array('order_sn'=>$content);
				break;
			case 2://  订单提醒  
				$templateSign = 3;
				$smsParamMap = array('supplier_name'=>$content);
				break;
			case 3://  商家退货通知  
				$templateSign = 4;
				$smsParamMap = array('supplier_name'=>$content);
				break;
			case 4://  审核通知   
				$templateSign = 5;
				$smsParamMap = array('phone'=>$mobile,'con'=>$content);
				break;
			default: 
				$templateSign = 1;
				$smsParamMap = array('code'=>$content);
		}
		
		$data = array(
			'telephone'=>$mobile,
			'templateSign'=>$templateSign,
			'smsParamMap'=>$smsParamMap,
		);
		
		$m = new HttpClient('json');
		$url = Yii::$app->params['javaApiAddr'].'/messageCenter/sms/send';
		//var_dump($url);
		//var_dump($data);
		$u = $m->httpRequest($url, $data);
		
		$result = json_decode($u,true);
		
		if(!empty($result) && $result['code']==10000){
			return true;
		}else{
			$word = "[". date('Y-m-d H:i:s') ."] [error: ".$u."] \r\n";
			(new ServiceApiLog())->fileLog($word,'sms_error');
		
			//返回错误码
			self::$errcode = 50004;//错误提示
			
			//返回信息 json 格式
			self::$err_array = $result;//错误提示
			return false;
		}
		
		/*require_once dirname(__DIR__) . '/vendor/message/TopSdk.php'; 
		//$sms = new \sms_sender(); 
		$c = new \TopClient;
		
		//$c = new TopClient;
		$c ->appkey = "24468693";
		$c ->secretKey = "0658ee7d85d6ca02559ff22ca7ee0728" ;
		$req = new \AlibabaAliqinFcSmsNumSendRequest;
		$req ->setExtend( "" );
		$req ->setSmsType( "normal" );
		switch ($sign)
		{
			case 0:  //发送验证码
			  
			  $req ->setSmsFreeSignName( "环球大爱" );
			  $req ->setSmsParam( "{code:'$content'}" );
			  $req ->setRecNum( "$mobile" );
			  $req ->setSmsTemplateCode( "SMS_85480076" );
			  break;  
			case 1:  //  发货通知 
			  $req ->setSmsFreeSignName( "环球大爱" );  
			  $req ->setSmsParam( "{order_sn:'$content'}" );
			  $req ->setRecNum( "$mobile" );  //手机
			  $req ->setSmsTemplateCode( "SMS_75880153" );
			  break;  
			case 2://  订单提醒  
			  $req ->setSmsFreeSignName( "环球大爱" );
			  $req ->setSmsParam( "{supplier_name:'$content'}" );
			  $req ->setRecNum( "$mobile" );
			  $req ->setSmsTemplateCode( "SMS_75765144" );
			  break;
			case 3://  商家退货通知   
			  $req ->setSmsFreeSignName( "环球大爱" );
			  $req ->setSmsParam( "{supplier_name:'$content'}" );
			  $req ->setRecNum( "$mobile" );
			  $req ->setSmsTemplateCode( "SMS_75810133" );
			  break;
			case 4://  审核通知   
			  $req ->setSmsFreeSignName( "环球大爱" ); 
			  $req ->setSmsParam( "{phone:'$mobile',con:'$content'}" );
			  $req ->setRecNum( "$mobile" );
			  $req ->setSmsTemplateCode( "SMS_85175012" );
			  break;
			default: 
			  $req ->setSmsFreeSignName( "环球大爱" );
			  $req ->setSmsParam( "{code:'$content'}" );
			  $req ->setRecNum( "$mobile" );
			  $req ->setSmsTemplateCode( "SMS_85480076" );
		}
		//print_r($sign);
		//exit;
		$resp = $c ->execute( $req );
		
		$result=$resp->result->success;//返回值
		
		if($result == true) {
			return true;
		} else {
			$e = json_encode($resp);
			$word = "[". date('Y-m-d H:i:s') ."] [error: ".$e."] \r\n";
			(new ServiceApiLog())->fileLog($word,'sms_error');
		
			//返回错误码
			self::$errcode = 50004;//错误提示
			
			//返回信息 json 格式
			$result_json = json_encode($resp);
			self::$err_array = json_decode($result_json,true);//错误提示
			
			
			return false;
		} 
		*/
	}
	
	public static function check($mobile,$day='20170728') 
    {
        if (!$mobile)
        {
            self::$errcode = 50014;//手机号不能为空
            return false;
        }
		
		require_once dirname(__DIR__) . '/vendor/message/TopSdk.php'; 
		//$sms = new \sms_sender(); 
		$c = new \TopClient;
		
		//$c = new TopClient;
		$c ->appkey = "24468693";
		$c ->secretKey = "0658ee7d85d6ca02559ff22ca7ee0728" ;
		$req = new \AlibabaAliqinFcSmsNumQueryRequest;
		
		//$req->setBizId("1234^1234");
		$req->setRecNum((string)$mobile);
		$req->setQueryDate($day);
		$req->setCurrentPage("1");
		$req->setPageSize("20");
		$resp = $c->execute($req);
		//var_dump($resp);
		
		$h = '';
		if(!empty($resp->values) && isset($resp->values->fc_partner_sms_detail_dto)){
			foreach($resp->values->fc_partner_sms_detail_dto as $v){
				$h .= '<br/>==========START===========<br/>';
				if(!empty($v)){
					foreach($v as $kk=>$vv){
						$h .= '<p>'.$kk.': '.$vv.'</p>';
					}
				}
				$h .= '==========END============';
			}
			//var_dump($resp->values);
		}
		echo $h;
		/*$result=$resp->result->success;//返回值
		
		if($result == true) {
			return true;
		} else {
			self::$errcode = 50004; 
			return false;
		}*/
		return true;
	}
}
