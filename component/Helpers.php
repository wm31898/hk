<?php

namespace app\component;

/**
 * 帮助类
 * 
 * @author  Jason <873808813@qq.com>
 */
class Helpers
{
    public static function genRand($len = 10)
    {
        $rand = '';
        $str = '0123456789abcdefghijklmnopqrstuvwxyz';
        $strlen = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $rand .= $str{rand(0,$strlen - 1)};
        }
        return $rand;
    }

    public static function genVerifyCode($len = 4)
    {
        $rand = '';
        $str = '0123456789';
        $strlen = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $rand .= $str{rand(0,$strlen - 1)};
        }
        return $rand;
    }

    /**
     * 通过用户id生成app显示的ID号
     * @param string|integer 用户id
     * @return string
     */
    public static function genUuidById($uid)
    {
        return '1' . str_pad($uid, 8, '0', STR_PAD_LEFT);
    }

    /**
     * 生成缓存key
     * @param string|array $code
     * @param string $prefix
     * @return string
     */
    public static function genCacheKey($code, $prefix = 'permission')
    {
        return $prefix . substr(md5(serialize($code)), 0, 6);
    }
}
