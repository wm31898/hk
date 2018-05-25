



<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="language" content="en" />
        <meta name="keywords" content="Yii2+模板“ description=">
<link href="http://www.kkh86.com/it/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="http://www.kkh86.com/it/assets/css/highlight/solarized_light.css" rel="stylesheet">
<link href="http://www.kkh86.com/it/assets/css/style.css" rel="stylesheet">
<script src="http://www.kkh86.com/it/assets/js/jquery.js"></script>
<script src="http://www.kkh86.com/it/assets/bootstrap/js/bootstrap.js"></script>
<script src="http://www.kkh86.com/it/assets/js/jssearch.js"></script>    <title>模板 - 先试下出个页面 - Yii2框架学习 - KK之家</title>
<style type="text/css">
.nimg{border:1px solid #000;}
</style>
</head>
<body>

<div class="wrap">
    <nav id="w614" class="navbar-inverse navbar-fixed-top navbar" role="navigation"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w614-collapse"><span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span></button><a class="navbar-brand" href="/it/index.html">返回大纲</a></div><div id="w614-collapse" class="collapse navbar-collapse"><ul id="w615" class="navbar-nav nav"><li><a href="/">KK之家</a></li></ul><div class="navbar-form navbar-left" role="search">
  <div class="form-group">
    <input id="searchbox" type="text" class="form-control" placeholder="Search">
  </div>
</div>
</div></nav>
    <div id="search-resultbox" style="display: none;" class="modal-content">
        <ul id="search-results">
        </ul>
    </div>

    
<style>
.submenu a{text-indent:2em}
.ds-thread{margin-top:30px; border-top:2px solid #CCC;}
#help div{float:left;}
#help,#commentBox{clear:both;}
</style>

<div class="row">
    <div class="col-md-2">
                <div id="navigation" class="list-group"><a class="list-group-item" href="#navigation-602" data-toggle="collapse" data-parent="#navigation">啊……那个 <?php

echo $name;

echo $age;

?><b class="caret"></b></a><div id="navigation-602" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-pre-desc.html">介绍</a>
<a class="list-group-item" href="./guide-pre-install.html">下载安装</a>
<a class="list-group-item" href="./guide-pre-folders.html">程序目录</a></div>
<a class="list-group-item active" href="#navigation-603" data-toggle="collapse" data-parent="#navigation">先试下出个页面 <b class="caret"></b></a><div id="navigation-603" class="submenu panel-collapse collapse in"><a class="list-group-item" href="./guide-show-page-controller.html">控制器</a>
<a class="list-group-item active" href="./guide-show-page-tpl.html">模板</a></div>
<a class="list-group-item" href="#navigation-604" data-toggle="collapse" data-parent="#navigation">第一层内功 <b class="caret"></b></a><div id="navigation-604" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-base-desc.html">介绍</a>
<a class="list-group-item" href="./guide-base-alias.html">别名</a>
<a class="list-group-item" href="./guide-base-create-object.html">创建一个类</a>
<a class="list-group-item" href="./guide-base-configure-object.html">配置一个类</a>
<a class="list-group-item" href="./guide-base-config.html">配置文件</a>
<a class="list-group-item" href="./guide-base-component.html">了解组件</a>
<a class="list-group-item" href="./guide-base-load-class.html">加载一个类</a>
<a class="list-group-item" href="./guide-base-object.html">基类</a>
<a class="list-group-item" href="./guide-base-base-component.html">组件类</a>
<a class="list-group-item" href="./guide-base-add-component.html">添加组件</a>
<a class="list-group-item" href="./guide-base-filter.html">过滤器</a>
<a class="list-group-item" href="./guide-base-summary.html">小结</a></div>
<a class="list-group-item" href="#navigation-605" data-toggle="collapse" data-parent="#navigation">URL <b class="caret"></b></a><div id="navigation-605" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-url-access.html">URL访问</a>
<a class="list-group-item" href="./guide-url-params.html">获取请求参数</a>
<a class="list-group-item" href="./guide-url-generate.html">生成网址</a>
<a class="list-group-item" href="./guide-url-rewrite.html">实现伪静态</a></div>
<a class="list-group-item" href="#navigation-606" data-toggle="collapse" data-parent="#navigation">请求处理 <b class="caret"></b></a><div id="navigation-606" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-rh-request-component.html">请求组件</a>
<a class="list-group-item" href="./guide-rh-response-component.html">响应组件</a>
<a class="list-group-item" href="./guide-rh-cookie.html">Cookie</a>
<a class="list-group-item" href="./guide-rh-session.html">Session</a>
<a class="list-group-item" href="./guide-rh-header.html">Header</a></div>
<a class="list-group-item" href="#navigation-607" data-toggle="collapse" data-parent="#navigation">数据库+AR模型 <b class="caret"></b></a><div id="navigation-607" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-db-config.html">基本配置</a>
<a class="list-group-item" href="./guide-db-query.html">Query查询</a>
<a class="list-group-item" href="./guide-db-cud.html">增删改</a>
<a class="list-group-item" href="./guide-db-ar-base.html">AR模型</a>
<a class="list-group-item" href="./guide-db-ar-query.html">AR查询器</a>
<a class="list-group-item" href="./guide-db-ar-relation.html">AR模型关系定义</a>
<a class="list-group-item" href="./guide-db-ar-select.html">AR模型查询优化</a>
<a class="list-group-item" href="./guide-db-ar-join.html">AR模型联表查询</a></div>
<a class="list-group-item" href="#navigation-608" data-toggle="collapse" data-parent="#navigation">用户登录 <b class="caret"></b></a><div id="navigation-608" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-login-identity.html">实现IdentityInterface接口</a>
<a class="list-group-item" href="./guide-login-login.html">登录</a>
<a class="list-group-item" href="./guide-login-auto-auth.html">自动检测登录</a>
<a class="list-group-item" href="./guide-login-user-info.html">获取用户信息</a>
<a class="list-group-item" href="./guide-login-logic.html">了解登录逻辑</a>
<a class="list-group-item" href="./guide-login-after-login.html">访问行为追踪</a></div>
<a class="list-group-item" href="#navigation-609" data-toggle="collapse" data-parent="#navigation">第二层内功 <b class="caret"></b></a><div id="navigation-609" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-base2-form-model.html">表单模型</a>
<a class="list-group-item" href="./guide-base2-validators.html">表单模型-验证器</a>
<a class="list-group-item" href="./guide-base2-form-scenarios.html">表单模型-多场景</a>
<a class="list-group-item" href="./guide-base2-log.html">日志</a>
<a class="list-group-item" href="./guide-base2-action.html">Action</a>
<a class="list-group-item" href="./guide-base2-captcha.html">验证码</a>
<a class="list-group-item" href="./guide-base2-pagination.html">分页</a>
<a class="list-group-item" href="./guide-_todo.html">==下面还没写==</a>
<a class="list-group-item" href="./guide-_todo.html">==下面还没写==</a>
<a class="list-group-item" href="./guide-_todo.html">==下面还没写==</a>
<a class="list-group-item" href="./guide-_todo.html">App的启动</a>
<a class="list-group-item" href="./guide-_todo.html">模块</a>
<a class="list-group-item" href="./guide-_todo.html">缓存</a></div>
<a class="list-group-item" href="#navigation-610" data-toggle="collapse" data-parent="#navigation">视图（还没写） <b class="caret"></b></a><div id="navigation-610" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-_todo.html">各页面自定标题</a>
<a class="list-group-item" href="./guide-_todo.html">模板里渲染模板</a>
<a class="list-group-item" href="./guide-_todo.html">模板小部件Widget</a>
<a class="list-group-item" href="./guide-_todo.html">注册资源</a>
<a class="list-group-item" href="./guide-_todo.html">注册资源包</a>
<a class="list-group-item" href="./guide-_todo.html">资源包版本自动更新</a>
<a class="list-group-item" href="./guide-_todo.html">注册meta</a></div>
<a class="list-group-item" href="#navigation-611" data-toggle="collapse" data-parent="#navigation">Migration（还没写） <b class="caret"></b></a><div id="navigation-611" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-_todo.html">介绍</a>
<a class="list-group-item" href="./guide-_todo.html">初尝迁移</a>
<a class="list-group-item" href="./guide-_todo.html">数据库操作</a>
<a class="list-group-item" href="./guide-_todo.html">事务迁移</a></div>
<a class="list-group-item" href="#navigation-612" data-toggle="collapse" data-parent="#navigation">控制台应用（还没写） <b class="caret"></b></a><div id="navigation-612" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-_todo.html">控制器</a>
<a class="list-group-item" href="./guide-_todo.html">配置文件</a>
<a class="list-group-item" href="./guide-_todo.html">添加参数</a>
<a class="list-group-item" href="./guide-_todo.html">标准输出</a>
<a class="list-group-item" href="./guide-_todo.html">标准错误输出</a>
<a class="list-group-item" href="./guide-_todo.html">进度百分比输出</a></div>
<a class="list-group-item" href="#navigation-613" data-toggle="collapse" data-parent="#navigation">少用的（还没写） <b class="caret"></b></a><div id="navigation-613" class="submenu panel-collapse collapse"><a class="list-group-item" href="./guide-_todo.html">Gii</a></div></div>    </div>
    <div class="col-md-9 guide-content" role="main">
        <div id="articleContent"><h1>先试下出个页面 - 模板 <span id=""></span><a href="#" class="hashlink">&para;</a></h1><ul>
<li><p>作者：KK</p>
</li>
<li><p>发表日期：2016.12.8</p>
</li>
</ul>
<hr />
<div id="config""></div>
<h3>基本使用 <span id=""></span><a href="#" class="hashlink">&para;</a></h3><p>Yii2默认是不用模板引擎的，模板目录则是<code>views</code> 目录</p>
<p>比如上一篇文章中叫你创建了<code>test</code>控制器，则在这个views目录下也建一个<code>test</code>目录，里面创建一个 <code>index.php</code> ，输入一些你想测试的显示内容</p>
<p>这样就部署好一个页面模板了，接下来要显示它，在test控制器的方法里执行</p>
<pre><code class="hljs php language-php"><span class="hljs-keyword">return</span> <span class="hljs-variable">$this</span>-&gt;renderPartial(<span class="hljs-string">'index'</span>);
</code></pre>
<p>就可以输出页面了</p>
<ul>
<li>明白了吧，控制器ID叫test的话，<code>$this-&gt;renderPartial('index')</code>的时候就会自动去views目录根据控制器ID找到test目录，再找指定的index.php来输出</li>
</ul>
<hr />
<h3>本质上不叫输出，而叫渲染，返回个HTML字符串而已 <span id="html"></span><a href="#html" class="hashlink">&para;</a></h3><p>把test方法的代码改成这样试试：</p>
<pre><code class="hljs php language-php"><span class="hljs-variable">$content</span> = <span class="hljs-variable">$this</span>-&gt;renderPartial(<span class="hljs-string">'index'</span>);
file_put_contents(<span class="hljs-string">'D:/a.html'</span>, <span class="hljs-variable">$content</span>); <span class="hljs-comment">// 具体的文件路径自己拟定</span>
<span class="hljs-keyword">return</span> <span class="hljs-string">'输出内容'</span>;
</code></pre>
<p>访问后会看到“输出内容”，再打开<strong>D:/a.html</strong>，发现里面有HTML内容</p>
<p>因为$content就是这个HTML字符串，<code>renderPartial</code>方法返回的就是根据index.php这个模板渲染后的一个字符串</p>
<p>所以概念上来说renderPartial不是输出模板，而是渲染模板，不过我们有时候交流方便直接说输出模板而已，这样其实大家都知道是把渲染结果return给框架</p>
<p>那其实<code>echo $this-&gt;renderPartial('index');</code>也是可以输出页面的</p>
<hr />
<h3>注册变量 <span id=""></span><a href="#" class="hashlink">&para;</a></h3><p>要传递一个叫做<strong>name</strong>和<strong>age</strong>的变量给模板，控制器要在renderPartial里传入<code>第二个参数</code>，比如这样:</p>
<pre><code class="hljs php language-php"><span class="hljs-keyword">return</span> <span class="hljs-variable">$this</span>-&gt;renderPartial(<span class="hljs-string">'index'</span>, [
	<span class="hljs-string">'name'</span> =&gt; <span class="hljs-string">'小明'</span>,	<span class="hljs-comment">//注册name变量给模板，就是$name</span>
	<span class="hljs-string">'age'</span> =&gt; <span class="hljs-string">'15'</span>,	<span class="hljs-comment">//你懂的</span>
]);
</code></pre>
<p>那模板就可以直接调用输出了</p>
<pre><code class="hljs php language-php"><span class="hljs-keyword">echo</span> <span class="hljs-variable">$name</span>;
<span class="hljs-keyword">echo</span> <span class="hljs-variable">$age</span>;
</code></pre>
<hr />
<h3>Layout（模板布局) <span id="layout"></span><a href="#layout" class="hashlink">&para;</a></h3><p>现在许多流程框架都有一个叫“模板布局“的概念，不管叫什么，反正它们通常都是要实现同一个普遍的网站需求：<code>大部分页面都使用相同的页眉和页脚</code></p>
<p>在yii里是这样解决的，<code>在views里有个layouts文件夹</code>,你在里面创建一个叫<code>common.php</code>的文件（这就是模板）,编写以下代码:</p>
<pre><code class="hljs xml language-html"><span class="hljs-tag">&lt;<span class="hljs-title">div</span>&gt;</span>页眉<span class="hljs-tag">&lt;/<span class="hljs-title">div</span>&gt;</span>
<span class="php"><span class="hljs-preprocessor">&lt;?php</span> <span class="hljs-keyword">echo</span> <span class="hljs-variable">$content</span>; <span class="hljs-preprocessor">?&gt;</span></span>
<span class="hljs-tag">&lt;<span class="hljs-title">div</span>&gt;</span>页脚<span class="hljs-tag">&lt;/<span class="hljs-title">div</span>&gt;</span>
</code></pre>
<p>然后将test方法改成这样：</p>
<pre><code class="hljs php language-php"><span class="hljs-keyword">public</span> <span class="hljs-function"><span class="hljs-keyword">function</span> <span class="hljs-title">actionTest</span><span class="hljs-params">()</span></span>{
	<span class="hljs-variable">$this</span>-&gt;layout = <span class="hljs-string">'common'</span>;
	<span class="hljs-keyword">return</span> <span class="hljs-variable">$this</span>-&gt;render(<span class="hljs-string">'index'</span>);
}
</code></pre>
<p>好了，刷新页面你会发现类似我这样的页面输出:</p>
<p><img class="nimg" src="img/tpl1.jpg" /></p>
<p>估计你也懂了，<code>views/layouts/common.php</code> 这个模板定义了各页面的页眉和页脚内容，通过<code>echo $content</code>把中间部分输出就可以了，但这里要注意，需要用 <code>render</code> 方法才可以使用layout布局，如果你改成</p>
<pre><code class="hljs php language-php"><span class="hljs-variable">$this</span>-&gt;renderPartial(<span class="hljs-string">'index'</span>)
</code></pre>
<p>就会不使用layout的，比如特定的活动页面或别的页面不使用公共页眉页脚才用<code>renderPartial</code></p>
<p>但你可能会疑惑是不是每次render前都要设置 <code>$this-&gt;layout</code>属性呢？</p>
<p>其实不用的，这个layout属性的默认值是<code>main</code>,如果你不设置它，它就会以<code>views/layouts/main.php</code>作为模板布局（官方已经放好这个文件了，你拿着改也可以），接下来你可以尝试着去掉<code>$this-&gt;layout</code>的赋值，直接render，就会以自带的main这个layout作为布局进行渲染了</p>
<p>如果你想整个控制器所有action进行render的时候都统一用另一个layout的话可以重写父类的属性声明<code>public $layout = 'common';</code>这样来定义</p>
<p>而如果要整个站点都用另一个layout都可以，以后再说，因为涉及配置文件的知识</p>
</div>		
		<hr/>
		<div id="help" data-index="1"></div>

        <div id="commentBox"></div>
        <div class="toplink"><a href="#" class="h1" title="go to top"><span class="glyphicon glyphicon-arrow-up"></a></div>
    </div>
</div>

<script type="text/javascript">
$(function(){
	showDuoshuoComment('先试下出个页面 - 模板', 'http://www.kkh86.comd:/web/kk/mylife/web/it/yii2/guide-show-page-tpl.html', '6f9671f589c58ab48484aabce9026cde');
});
</script>
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1257037572'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1257037572%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
</div>

<footer class="footer">
	<p class="pull-left">&copy; KK 2017</p>&nbsp;
	<p class="pull-right">
			</p>
    Powered by <a href="http://www.yiiframework.com/" rel="external">Yii Framework</a></footer>

<script src="/it/assets/js/help.js?v=1487471819"></script>
<script type="text/javascript">jQuery(document).ready(function () {
    var shiftWindow = function () { scrollBy(0, -50) };
    if (location.hash) setTimeout(shiftWindow, 1);
    window.addEventListener("hashchange", shiftWindow);
var element = document.createElement("script");
element.src = "./jssearch.index.js";
document.body.appendChild(element);

var searchBox = $('#searchbox');

// search when typing in search field
searchBox.on("keyup", function(event) {
    var query = $(this).val();

    if (query == '' || event.which == 27) {
        $('#search-resultbox').hide();
        return;
    } else if (event.which == 13) {
        var selectedLink = $('#search-resultbox a.selected');
        if (selectedLink.length != 0) {
            document.location = selectedLink.attr('href');
            return;
        }
    } else if (event.which == 38 || event.which == 40) {
        $('#search-resultbox').show();

        var selected = $('#search-resultbox a.selected');
        if (selected.length == 0) {
            $('#search-results').find('a').first().addClass('selected');
        } else {
            var next;
            if (event.which == 40) {
                next = selected.parent().next().find('a').first();
            } else {
                next = selected.parent().prev().find('a').first();
            }
            if (next.length != 0) {
                var resultbox = $('#search-results');
                var position = next.position();

//              TODO scrolling is buggy and jumps around
//                resultbox.scrollTop(Math.floor(position.top));
//                console.log(position.top);

                selected.removeClass('selected');
                next.addClass('selected');
            }
        }

        return;
    }
    $('#search-resultbox').show();
    $('#search-results').html('<li><span class="no-results">No results</span></li>');

    var result = jssearch.search(query);

    if (result.length > 0) {
        var i = 0;
        var resHtml = '';

        for (var key in result) {
            if (i++ > 20) {
                break;
            }
            resHtml = resHtml +
            '<li><a href="' + result[key].file.u.substr(3) +'"><span class="title">' + result[key].file.t + '</span>' +
            '<span class="description">' + result[key].file.d + '</span></a></li>';
        }
        $('#search-results').html(resHtml);
    }
});

// hide the search results on ESC
$(document).on("keyup", function(event) { if (event.which == 27) { $('#search-resultbox').hide(); } });
// hide search results on click to document
$(document).bind('click', function (e) { $('#search-resultbox').hide(); });
// except the following:
searchBox.bind('click', function(e) { e.stopPropagation(); });
$('#search-resultbox').bind('click', function(e) { e.stopPropagation(); });

});</script></body>
</html>