<?php
// +----------------------------------------------------------------------
// | Fanwe 方维o2o商业系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 云淡风轻(97139915@qq.com)
// +----------------------------------------------------------------------

class sms_sender
{
	var $sms;
	
	public function __construct()
    { 	
		//$sms_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."sms where is_effect = 1");
		//if($sms_info)
		//{
			//$sms_info['config'] = unserialize($sms_info['config']);
			
			$sms_info=array('id'=>10 , 'name'=>'方维短信平台' ,'description'=>'' ,'class_name'=> 'FW' ,'server_url'=>'http://sms.fanwe.com/' ,'user_name'=>'sfshfww' ,'password'=> '888888','config'=>'','is_effect'=>'1');
			
			require_once "FW_sms.php";
            
			$sms_class = "FW_sms";
			$this->sms = new $sms_class($sms_info);
		//}
    }
    
	public function test(){
		
		print_r('asdfsadf');
		exit;
	}
	
	
	public function sendSms($mobiles,$content,$is_adv = 0)
	{
		if(!is_array($mobiles)) 
			$mobiles = preg_split("/[ ,]/i",$mobiles);
		
		if(count($mobiles) > 0 )
		{
			if(!$this->sms)
			{
				$result['status'] = 0;
			}
			else
			{
				$result = $this->sms->sendSms($mobiles,$content,$is_adv);
			}
		}
		else
		{
			$result['status'] = 0;
			$result['msg'] = "没有发送的手机号";
		}
		
		return $result;
	}
}
?>