<?php
/**
 * 常用工具类
 * Created by PhpStorm.
 * User: china
 * Date: 2017/5/15
 * Time: 17:32
 */

namespace app\component;

use yii;
class Tools
{

    public static function CreatePaySn()
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
    /***
     * 格式化一维数组
     * @param $arr
     * @return array
     */
    public static function parseArray($arr)
    {
        if (!is_array($arr))
        {
            $arr = explode(",", $arr);
        }
        $new_arr = [];
        foreach ($arr as $item)
        {
            if ($item)
                $new_arr[] = $item;
        }
        return $new_arr;
    }

    /***
     * 清除不显示的字段
     * @param $arr
     * @param $fields
     * @return mixed
     */
    public static function parseFields($arr, $fields = [])
    {
        if (empty($fields))
            return $arr;

        foreach ($arr as $k=>$v)
        {
            if (!in_array($k, $fields))
            {
                unset($arr[$k]);
            }
        }
        return $arr;
    }

    /***
     * 礼品卡计算
     * @param $current_price
     * @param $balance_price
     * @param $number
     * @param $ratio
     * @return float
     */
    public static function calculateCoupon($current_price, $balance_price, $number, $ratio)
    {
        return round((($current_price-$balance_price)*$number)*($ratio/100), 2);
    }

    /**
     * 返回平台params参数
     * @param $key
     * @return string
     */
    public static function systemParams($key)
    {
        $params = Yii::$app->params;
        return isset($params[$key])?$params[$key]:'';
    }

    /***
     * 生成订单号
     * @return string
     */
    public static function CreateOrderSN()
    {
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
        $order_id_main = substr(date('YmdHis'), 2) . rand(10, 99);
        //订单号码主体长度
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        return $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
    }

    public static function ImageUrl($path)
    {
        return $path;
    }

    public static function dateFormat($time)
    {
        return date("Y-m-d H:i:s", $time);
    }

    public static function subStr($str, $start=0, $length=15, $charset="utf-8", $suffix=true)
    {
        if(function_exists("mb_substr"))
        {
            $slice =  mb_substr($str, $start, $length, $charset);
            if($suffix&$slice!=$str) return $slice."…";
            return $slice;
        }
        elseif(function_exists('iconv_substr')) {
            return iconv_substr($str,$start,$length,$charset);
        }
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
        if($suffix&&$slice!=$str) return $slice."…";
        return $slice;
    }
}