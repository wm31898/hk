<?php

return [
    //'projectName' => 'wftz',//项目名-用作缓存key前缀
    'adminEmail' => 'admin@example.com',
    'imageUrl' => 'http://wftest.oss-cn-shenzhen.aliyuncs.com/',//'http://newwufu.oss-cn-shenzhen.aliyuncs.com/',//图片URL路径
    //'imageUrl' => 'http://dv.wufuxg.com/web/uploads/',//上图片URL
    'openApiSlowLog' => true,//开启api慢响应日志
    'useRedisCache' => false,//开启redis缓存
    'redisCacheTime' => 60,//缓存时间
    'redisCacheTimeH' => 3600,//缓存时间（小时）
    'redisCacheTimeD' => 86400,//缓存时间（天）
    'appCheckToken' => true,//开启api token验证
    'checkSign' => true,
    //'appApiUrl' => 'http://devxyapi.wufu360.com/',

    // 路径
    'basePath' => dirname(__DIR__),
    'webPath' => dirname(__DIR__) . '/web',
    'adminWebPath' => dirname(__DIR__) . '/web/admin_style_pages/assets',
	
	'adminCssUrl' => '/web/admin_style_pages/assets/css',//管理后台css文件路径
    'adminJsUrl' => '/web/admin_style_pages/assets/js',//管理后台js文件路径
	'pcCssUrl' => '/web/pc_style/css',//pc版块css文件路径
    'pcJsUrl' => '/web/pc_style/js',//pc版块js文件路径
    'pcImageUrl' => '/web/pc_style/images',//pc版块图片文件路径
    
    // alivideo配置
    'alivideo' => [
        'region_id' => 'cn-shanghai',
        'access_key_id' => 'LTAIDwwtOI03DBYX',
        'access_key_secret' => 'twdJOX1eMuAkbkPoHYcT5yAQpyJkOt',
    ],
	
	// alioss配置 新
	'useOss' => true,//上传图片方法判断是否使用oss类 注意：要更新imageUrl图片URL路径
	'alioss' => [
        'access_id' => 'LTAIqM1yei0xXdQ7',
        'access_secret' => '0T01csJF2SvRsFybw9X1g8s6dGxDO9',
        'endpoint' => 'http://oss-cn-shenzhen.aliyuncs.com',//oss-cn-qingdao.aliyuncs.com
        'bucket' => 'wftest',//'wufutest',
    ],   
];
