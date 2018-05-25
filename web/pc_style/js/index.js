
$(document).ready(function(e) {
    //轮播特效
    /*$('#slider').flexslider({
        animation : 'slide',
        controlNav : true,
        directionNav : false,
        animationLoop : true,
        pauseOnAction:false,
        slideshow: true,
        useCSS : false,
        slideshowSpeed: 3000,
        playText: 'Play',
randomize: true
    });*/
    var unslider04 = $('#b04').unslider({

        dots: true

    }),

    data04 = unslider04.data('unslider');


    /* 主页新闻块hover */
    $(".content-news-t li").hover(function () {
        var h = $(this).find('.li-contb').height();
        $(this).children('a').stop().animate({"top":-h+"px"})
        $(this).find('.text').stop().animate({"bottom":"480px"})
    },function () {
        $(this).children('a').stop().animate({"top":"0px"})
        $(this).find('.text').stop().animate({"bottom":"0px"})
    });

    /* 天气请求 
    // 开发环境
    var tqUrl = "http://devwufutz.wufu360.com";

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
                site.find(".site-lb p").html(getTime());
                site.find(".site-rtext h4").html(data.detailed);
                site.find(".site-rtext p").html(data.tem2 +"°~"+data.tem1 +"°");
            }
        }
    });*/
});

/* 日照轮播 */

$(function(){
    //设置全局变量

    var oDiv = $(".rizhaoall"),
        cur = 0,
        timer = null,
        rizhaoBig = oDiv.find(".rizhaoBig"),
        imgLen = rizhaoBig.find("li").length,
        liList =  rizhaoBig.find("li"),
        liWidth = rizhaoBig.find("li").width(),
        rizhaoBigHtml = rizhaoBig.html(),
        nameArr = [];

    liList.each(function (index,item) {
        nameArr.push($(this).attr("titlename"))
    });
    if(nameArr.length>1){
        rizhaoBig.html(rizhaoBigHtml+rizhaoBigHtml);
        rizhaoBig.width(imgLen*2*1000);
        var rizhaoTitle = $("<div class='rizhao-title'></div>");
        oDiv.prepend(rizhaoTitle);
        for(var i = 0; i<nameArr.length; i++){
            var newA = $("<a>"+nameArr[i]+"</a>");
            rizhaoTitle.append(newA);
        }
        rizhaoTitle.find("a").eq(0).addClass("active");
        var rizhaoNav = $("<div class='rizhao-nav'></div>");
        rizhaoNav.html('<li><a class="nav-prev">Previous</a><li><a class="nav-next">Previous</a>');
        oDiv.prepend(rizhaoNav);
    }else {
        rizhaoBig.parents(".content-rizhao").css({"padding":"0"});
        rizhaoBig.find("li").css({"width":"1000px","margin-left": "100px"});
        return;
    }

    //当鼠标移到向左和向右的图标上关闭定时器，离开时则重置定时器
    $(".nav-prev,.nav-next").hover(function(){
        clearInterval( timer );
    },function(){
        //changeImg( );
    });

    //当鼠标移到图片上关闭定时器，离开时则重置定时器
    rizhaoBig.hover(function(){
        clearInterval( timer );
    },function(){
        //changeImg( );
    });

    //点击向左图标根据cur进行上一个图片处理
    $(".nav-prev").click(function(){
        cur = cur>0 ? (--cur) : (imgLen-1);
        changeTo( cur );
    });

    //点击向右图标根据cur进行上一个图片处理
    $(".nav-next").click(function(){
        cur = cur< (imgLen-1)  ? (++cur) : 0;
        changeTo( cur );
    });

    //为下方的圆点按钮绑定事件
    rizhaoTitle.find("a").hover(function(){
        clearInterval(timer);
        var index = $(this).index();
        cur = index;
        changeTo(cur);
    },function(){
        //changeImg();
    });

    //封装图片自动播放函数
    /*function changeImg(){
        clearInterval( timer );
        timer = setInterval(function(){
            if( cur<imgLen ){
                cur++;

            }else{
                cur=0;
                rizhaoBig.css({ "left" : 0 });
            }
            changeTo( cur );
        },3000);
    }*/

    //调用函数
    //changeImg();

    //图片切换函数
    function changeTo( num ){
        var go = num*1000;
        rizhaoBig.stop().animate({ "left" : -go+"px" },500);
        if(num<imgLen){
            rizhaoTitle.find("a").removeClass("active").eq(num).addClass("active");
        }else{
            rizhaoTitle.find("a").removeClass("active").eq(0).addClass("active")
        }
    }

});