<?php
	include_once 'aliyun-php-sdk-core/Config.php';
    use vod\Request\V20170321 as vod;

	
	$video_id = '46438090be53476a8b19ce57f69b3d59';
	$regionId = 'cn-shanghai';
	$access_key_id = 'LTAIDwwtOI03DBYX';
	$access_key_secret = 'twdJOX1eMuAkbkPoHYcT5yAQpyJkOt';
	
	
	$profile = DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
	$client = new DefaultAcsClient($profile);
	
	function testGetVideoPlayAuth($client, $regionId,$video_id) {
		$request = new vod\GetVideoPlayAuthRequest();
		$request->setAcceptFormat('JSON');
		$request->setRegionId($regionId);
		$request->setVideoId($video_id);            //视频ID
		$response = $client->getAcsResponse($request);
		return $response;
    }
	
	$d = testGetVideoPlayAuth($client, $regionId,$video_id);
	var_dump($d);
	
	$playauth = '';
	if(isset($d->PlayAuth) && $d->PlayAuth!=''){
		$playauth = $d->PlayAuth;
	}
	
	/*try {
        $d = testGetVideoPlayAuth($client, $regionId,$video_id);
		var_dump($d);
		
		die('ok');
    } catch (Exception $e) {
        echo $e->getMessage();
    }*/
	
	//html szb484t85bdwgo5vjemqptb6kao21yvbiiu1k6tznpp7jrqgyxpmcksxlk55niyi
	
	//die();//F:\wamp64\www\video_sdk\aliyun-openapi-php-sdk\index.php
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport"   content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
<link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/1.9.2/skins/default/index.css" />
<script type="text/javascript" src="https://g.alicdn.com/de/prismplayer/1.9.2/prism.js"></script>
</head>
<body>
<div class="prism-player" id="J_prismPlayer"></div>
<script>var player = new prismplayer({id: "J_prismPlayer",autoplay: true,width: "1920px",height: "1280px",vid: "<?php echo $video_id; ?>",playauth: "<?php echo $playauth; ?>",});</script>
</body>
</html>