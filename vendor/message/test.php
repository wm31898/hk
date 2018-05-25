<?php
    include "TopSdk.php";
	//include "top/TopClient.php";
    date_default_timezone_set('Asia/Shanghai'); 
   // $httpdns = new HttpdnsGetRequest;
//    $client = new ClusterTopClient("4272","0ebbcccfee18d7ad1aebc5b135ffa906");
//    $client->gatewayUrl = "http://api.daily.taobao.net/router/rest";
//    var_dump($client->execute($httpdns,"6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805"));


$c = new TopClient;
//$appkey = "24468693"; 
//$secret = "0658ee7d85d6ca02559ff22ca7ee0728"; 

//调试OK  
/*$c ->appkey = '24468693' ;
$c ->secretKey = '0658ee7d85d6ca02559ff22ca7ee0728' ;
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req ->setExtend( "" );
$req ->setSmsType( "normal" );
$req ->setSmsFreeSignName( "阿里大于测试专用" );
$req ->setSmsParam( "{name:'日月'}" );
$req ->setRecNum( "13794415612" );
//$req ->setSmsTemplateCode( "SMS_71356194" );//测试模板
$req ->setSmsTemplateCode( "SMS_71490077" );//正式运营
$resp = $c ->execute( $req );*/

$c = new TopClient;
$c ->appkey = "24468693";
$c ->secretKey = "0658ee7d85d6ca02559ff22ca7ee0728" ;
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req ->setExtend( "" );
$req ->setSmsType( "normal" );
$req ->setSmsFreeSignName( "环球大爱" );
$req ->setSmsParam( "{phone:'13794415612',code:'5560'}" );
$req ->setRecNum( "13794415612" );
$req ->setSmsTemplateCode( "SMS_71525092" );
$resp = $c ->execute( $req );

print_r($resp);

?>