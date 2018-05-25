<?php
/**
 * Created by PhpStorm.
 * User: china
 * Date: 2016/5/14
 * Time: 13:42
 */

namespace app\component;

class CommonFun
{
	
	public static function teamEncrypt($key){
		return md5(base64_encode(sha1($key)));
	}
	
	//生成24位唯一号码
	public static function CreateUniqueId()
	{
		//订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
		$order_id_main = date('YmdHis') . rand(10000000, 99999999);
		//订单号码主体长度
		$order_id_len = strlen($order_id_main);
		$order_id_sum = 0;
		for ($i = 0; $i < $order_id_len; $i++) {
			$order_id_sum += (int)(substr($order_id_main, $i, 1));
		}
		return $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
	}

	//生成12位唯一号码
	public static function CreateServerId()
	{
		//订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
		$order_id_main = date('si') . rand(10000000, 99999999);
		//订单号码主体长度
		$order_id_len = strlen($order_id_main);
		$order_id_sum = 0;
		for ($i = 0; $i < $order_id_len; $i++) {
			$order_id_sum += (int)(substr($order_id_main, $i, 1));
		}
		return $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
	}

	/***
	 * 生成活动的CODE
	 * @return string
	 */
	public static function CreateSerialCode()
	{
		$code = self::createGUid();
		$code = explode("-", $code);
		$code = substr($code[0], 1) . $code[3]. substr($code[4], 0, -1);
		return $code;
	}

	/***
	 * 生成当前机唯一的UID
	 * @return string
	 */
	public static function createGUid()
	{
		if (function_exists('com_create_guid')) {
			return com_create_guid();
		} else {
			mt_srand((double)microtime() * 10000);
			$charId = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = chr(123)  //{
				. substr($charId, 0, 8) . $hyphen
				. substr($charId, 8, 4) . $hyphen
				. substr($charId, 12, 4) . $hyphen
				. substr($charId, 16, 4) . $hyphen
				. substr($charId, 20, 12)
				. chr(125);  //}
			return $uuid;
		}
	}


	/***
	 * 生成n位随机数
	 * @param int $n
	 * @return string
	 */
	public static function RandomNumbers($n = 6)
	{
		$key = '';
		$pattern = '1234567890'; //字符池
		for ($i = 0; $i < $n; $i++) {
			$key .= $pattern{mt_rand(0, strlen($pattern) - 1)};//生成php随机数
		}
		return $key;
	}

	/***
	 * @author china
	 * 生成sign签名加密串
	 * @param $time
	 * @param $nostr
	 * @return mixed
	 */
	public static function createSign($time, $nostr)
	{
		$key = "yZfZddiIeQ7lBU7WMWi4Du2fO6BmI7UqQLhsWmNnViO";
		return md5(md5($key.$time).$nostr);
	}

	/***
	 * @author china
	 * 生成n位英文加数字的随机位
	 * @param int $length
	 * @return string
	 */
	public static function createNonceStr($length = 6) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}

	/**************************************************************
	 *
	 *  使用特定function对数组中所有元素做处理
	 *  @param  string  &$array     要处理的字符串
	 *  @param  string  $function   要执行的函数
	 *  @return boolean $apply_to_keys_also     是否也应用到key上
	 *  @access public
	 *
	 *************************************************************/
	public static function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
	{
		static $recursive_counter = 0;
		if (++$recursive_counter > 1000) {
			die('possible deep recursion attack');
		}
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				self::arrayRecursive($array[$key], $function, $apply_to_keys_also);
			} elseif( is_numeric($value)) {
				$array[$key] = $value;
			}else{
				$array[$key] = $function($value);
			}

			if ($apply_to_keys_also && is_string($key)) {
				$new_key = $function($key);
				if ($new_key != $key) {
					$array[$new_key] = $array[$key];
					unset($array[$key]);
				}
			}
		}
		$recursive_counter--;
	}
	/**************************************************************
	 *
	 *  将数组转换为JSON字符串（兼容中文）
	 *  @param  array   $array      要转换的数组
	 *  @return string      转换得到的json字符串
	 *  @access public
	 *  json_encode($str,JSON_UNESCAPED_UNICODE)这个都可以
	 *************************************************************/
	public static function JSON($array) {
		self::arrayRecursive($array, 'urlencode', true);
		$json = json_encode($array);
		return urldecode($json);
	}

	public static function url_safe_b64encode($string)
	{
		$data = base64_encode($string);
		$data = str_replace(['+','/','='], ['-','_',''],$data);
		return $data;
	}

	public static function url_safe_b64decode($string)
	{
		$data = str_replace(['-','_'], ['+','/'], $string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	public static function getHost()
	{
		if (count($_SERVER) && isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_SCHEME']) )
		{
			return $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];
		}
		return null;
	}

	public static function assetsURL()
	{
		//return 'http://activity.vpk100.com/';

		return 'http://'.(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'activity.vpk100.com');
	}
	public static function assetsPath()
	{
		return \Yii::$app->basePath.'/web/';
	}

}