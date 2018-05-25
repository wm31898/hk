<?php

namespace app\component;

use Yii;
use OSS\OssClient;
use OSS\Core\OssException;

define('OSS_ACCESS_ID', Yii::$app->params['alioss']['access_id']);
define('OSS_ACCESS_SECRET', Yii::$app->params['alioss']['access_secret']);
define('OSS_ENDPOINT', Yii::$app->params['alioss']['endpoint']);
define('OSS_BUCKET', Yii::$app->params['alioss']['bucket']);

/**
 * AliOSS
 * 
 * @author  Jason <873808813@qq.com>
 */
class Alioss
{
    public static $client = null;

    /**
     * 上传文件
     *
     * Alioss::uploadFile('uploads/new.jpg', __DIR__ . '/t.jpg');
     * 
     * @param string $object 服务端文件相对路径
     * @param string $filePath 本地文件路径
     * @return array|string 正确返回数组，错误返回字符串提示信息
     */
    public static function uploadFile($object, $filePath)
    {
        try {
            self::$client = (self::$client === null) ? new OssClient(OSS_ACCESS_ID, OSS_ACCESS_SECRET, OSS_ENDPOINT) : self::$client;
            return self::$client->uploadFile(OSS_BUCKET, $object, $filePath);
        } catch (OssException $e) {
            return $e->getMessage();
        }
    }

    public static function getObject($object)
    {
        try {
            self::$client = (self::$client === null) ? new OssClient(OSS_ACCESS_ID, OSS_ACCESS_SECRET, OSS_ENDPOINT) : self::$client;
            return self::$client->getObject(OSS_BUCKET, $object);
        } catch (OssException $e) {
            return $e->getMessage();
        }
    }

    public static function putObject($object, $content)
    {
        try {
            self::$client = (self::$client === null) ? new OssClient(OSS_ACCESS_ID, OSS_ACCESS_SECRET, OSS_ENDPOINT) : self::$client;
            return self::$client->putObject(OSS_BUCKET, $object, $content);
        } catch (OssException $e) {
            return $e->getMessage();
        }
    }
}
