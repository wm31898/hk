<?php
/**
 * Created by PhpStorm.
 * 字典翻译工具类
 * User: china
 * Date: 2017/5/15
 * Time: 13:25
 */

namespace app\component;

class L
{
    private static $dictionary = [
		//系统公共版块
		10000 => '正常输出',
		10001 => '数据格式错误',
        
		//前端版块
		20000 => '参数不完整',
		
		//后台版块
		30000 => '没有权限进行操作',
        30001 => '请求信息错误',
		
        30999 => '系统操作失败',
		
        90001 => 'sign不存在',
        90002 => 'sign校验失败',
        90003 => 'timestamp参数不存在',
        90004 => 'timestamp参数超时',
    ];

    public static function t($code)
    {
        return isset(self::$dictionary[$code])?self::$dictionary[$code]:$code;
    }

    public function __invoke($code)
    {
        return isset(self::$dictionary[$code]) ? self::$dictionary[$code] : $code;
    }
}
