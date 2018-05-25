<?php
	use app\logic\PcViewLogic;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title><?php echo isset($this->context->title) && $this->context->title!=''?$this->context->title:'環球大愛國際投資控股有限公司'; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['pcCssUrl']; ?>/HeadFooder.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['pcCssUrl']; ?>/common.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['pcCssUrl']; ?>/index.css">
    <!-- 轮播图样式 -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->params['pcCssUrl']; ?>/flexslider.css">

    <script src="<?php echo Yii::$app->params['pcJsUrl']; ?>/jquery.min.js"></script>
    <!-- 轮播图插件-->
    <!--<script src="<?php echo Yii::$app->params['pcJsUrl']; ?>/jquery.flexslider-min.js"></script>-->
    <script src="<?php echo Yii::$app->params['pcJsUrl']; ?>/unslider.min.js"></script>


    <script src="<?php echo Yii::$app->params['pcJsUrl']; ?>/introduce.js"></script>

    <script src="<?php echo Yii::$app->params['pcJsUrl']; ?>/index.js"></script>
</head>
<body>
<div id="header">
	<!-- 头部start -->
	<div class="jy-top">
		<div class="cbody">
			<p>聯絡加傳真號：2352 3000</p>
		</div>
	</div>
	<div class="jy-header">
		<div class="cbody clearfix">
			<h1 class="logo fl" style="padding-top: 25px; height: 95px;"><img src="<?php echo Yii::$app->params['pcImageUrl']; ?>/jy-logo.png" /></h1>
			<div class="head-r fr">
				<div class="nav">
					<ul>
						<li <?php echo Yii::$app->controller->id=='home'?'class="cur"':''; ?>><a href="<?php echo pcViewLogic::createPageUrl('home'); ?>">首頁</a></li>
						<li <?php echo Yii::$app->controller->id=='about'?'class="cur"':''; ?>><a href="<?php echo pcViewLogic::createPageUrl('about'); ?>">關於我們</a></li>
						<li <?php echo Yii::$app->controller->id=='news'?'class="cur"':''; ?>><a href="<?php echo pcViewLogic::createPageUrl('news'); ?>">新聞中心</a></li>
						<li <?php echo Yii::$app->controller->id=='article' && (Yii::$app->controller->action->id=='index' || (Yii::$app->controller->action->id=='details' && $this->context->details_cate==1))?'class="cur"':''; ?>><a href="<?php echo pcViewLogic::createPageUrl('article'); ?>">日照中心</a></li>
						<li <?php echo Yii::$app->controller->id=='article' && Yii::$app->controller->action->id=='provide-patterns'?'class="cur"':''; ?>><a href="<?php echo pcViewLogic::createPageUrl('article','provide-patterns'); ?>">养老模式</a></li>
						<li <?php echo Yii::$app->controller->id=='article' && (Yii::$app->controller->action->id=='provide-base' || (Yii::$app->controller->action->id=='details' && $this->context->details_cate==3))?'class="cur"':''; ?>><a href="<?php echo pcViewLogic::createPageUrl('article','provide-base'); ?>">養老基地</a></li>
						<li <?php echo Yii::$app->controller->id=='goods'?'class="cur"':''; ?>><a href="<?php echo pcViewLogic::createPageUrl('goods'); ?>">產品中心</a></li>
						<li <?php echo Yii::$app->controller->id=='contact'?'class="cur"':''; ?>><a href="<?php echo pcViewLogic::createPageUrl('contact'); ?>">聯繫我們</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
    <!-- 头部end -->
</div>

<?= $content ?>

<div id="fooder">
	<!-- 底部start -->
    <div class="jy-fooder">
    	<div class="cbody">
    		<div class="jy-fooder-t clearfix">
    			<div class="jy-fooder-ta fl">
    				<dl>
    					<dt>聯繫方式</dt>
    					<dd>名稱：環球大愛國際投資控股有限公司</dd>
    					<dd>地址：香港九龍 尖沙咀東 科学館道一號 康宏廣場 (南座) 12樓 1206室</dd>
    					<dd>電話：(852) 2352 3337</dd>
    					<dd>電郵：service@hqda.com.hk</dd>
    				</dl>
    			</div>
    			<!--<div class="jy-fooder-tb fl">
    				<dl>
    					<dt>关于五福</dt>
    					<dd><a href="<?php echo pcViewLogic::createPageUrl('about'); ?>">五福简介</a></dd>
    					<dd><a href="<?php echo pcViewLogic::createPageUrl('contact'); ?>">加入五福</a></dd>
    					<dd><a href="<?php echo pcViewLogic::createPageUrl('contact'); ?>">联系我们</a></dd>
    				</dl>
    			</div>
    			<div class="jy-fooder-tc fr">
    				<h4>扫描关注五福公众号</h4>
    				<div class="erweima"><img width="110" height="110" src="<?php echo Yii::$app->params['pcImageUrl']; ?>/erweima_07.png" /></div>
    			</div>-->
    		</div>
    		<div class="jy-fooder-b">
    			<p>環球大愛國際投資控股有限公司版權所有</p>
    			<!--<p>©2018 911查詢　<a href="http://www.miitbeian.gov.cn" target="_blank" style="color: #fff;">蜀ICP备17044362号-1</a>　公网安备11011502002530</p>-->
    		</div>
    	</div>
    </div>
    <!-- 底部end -->
</div>
</body>
<?php if(Yii::$app->controller->id=='home'){ ?>
<script type="text/javascript">
$(document).ready(function() {
	/* 天气请求 */
    var tqUrl = <?php echo $url = '"http://'.$_SERVER['HTTP_HOST'].'"'; ?>;
	
	// 开发环境
    //var tqUrl = "http://devwufutz.wufu360.com";

    // 测试环境
    //var tqUrl = "http://testwufutz.wufu360.com:8034";
    function getTime(){
        var mydate = new Date();
        var str = "" + mydate.getFullYear() + " 年 ";
        str += (mydate.getMonth()+1) + " 月 ";
        str += mydate.getDate() + " 日 ";
        return str;
    }

    $.ajax({
        type : "GET",
        url : tqUrl+"/pc/home/get-weather",
        success : function(result) {
            if(result.code == 10000){
                // console.log(result.data);
                var data = result.data;
                var site = $(".site");
                site.find(".site-lt span").html(data.city_name);
                //site.find(".site-lb p").html(getTime());
                site.find(".site-rtext h4").html(data.detailed);
                site.find(".site-rtext p").html(data.tem2 +"°~"+data.tem1 +"°");
            }
        }
    });
});
</script>
<?php } ?>
</html>
<?php $this->endBody() ?>