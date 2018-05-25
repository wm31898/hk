$(function(){
    /* 引入头部与底部模块 */
	//$("#header").load("../components/header.html");
    //$("#fooder").load("../components/fooder.html");

    /* 日照菜单 */
    $(".jy-nav ul li").on("click",function () {
        $(this).addClass("cur").siblings().removeClass("cur");
        $(this).parents(".jy-nav").siblings(".jy-nav-tab").find(".tab-item").eq($(this).index()).addClass("cur").siblings().removeClass("cur");
    })

    /* 核心团队hover */
    $(".ac-contB ul li").hover(function () {
        $(this).find('.li-text').stop().animate({"top":"0px"})
    },function () {
        $(this).find('.li-text').stop().animate({"top":"-426px"})
    })
    /* 招贤纳士 */
    $(".recruit-details").on("click",function () {
        $('.recruit-details').removeClass("active");
        $(this).siblings(".recruit-ul-item").css("display")=="block"? $(this).text("详情").removeClass("active"): $(this).text("收起").addClass("active");
        $(this).siblings(".recruit-ul-item").slideToggle()
            .parents('.clearfix').siblings('.clearfix').children('.recruit-ul-item').hide();
    })
})