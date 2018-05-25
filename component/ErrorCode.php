<?php
/**
 * Created by PhpStorm.
 * 平台错误码
 * User: china
 * Date: 2017/5/15
 * Time: 13:18
 */

namespace app\component;


class ErrorCode
{
    const NORMAL = 10000;

    /***
     * 未定义错误输出
     */
    const UNKNOWN_ERROR_TYPE = 99999;


    /***
     * 以下为会员错误输出
     */
    const USER_PASSWORD_INVALID = 10001;


    /***
     * end
     */

    /***
     * 以下为订单错误输出
     */
    const ORDER_INVALID = 20001;
    const CART_ID_INVALID = 20002;
    const ORDER_CREATE_INVALID = 20003;
    const ORDER_SHIP_ID_INVALID = 20004;
    const ORDER_CACHE_INVALID = 20005;
    const ORDER_ITEM_INSERT_INVALID = 20006;
    /***
     * end
     */

    /***
     * 以下为商品错误输出
     */
    const GOODS_INVALID = 30001;

    /**
     * end
     */
}