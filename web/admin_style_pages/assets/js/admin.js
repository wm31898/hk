/**
*
* Copyright 2018 Twitter Inc.
*
*/

jQuery(function($) {

});

/**
 * @Author pwr at 2018-01-31
 * @name html_alert
 * @todo 全局系統提示弹框
 * @参数 m：提示框内容；t：提示框标题（默认：系統提示）
 */
function html_alert(m,t){
	$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
		_title: function(title) {
			var $title = this.options.title || '&nbsp;'
			if( ("title_html" in this.options) && this.options.title_html == true )
				title.html($title);
			else title.text($title);
		}
	}));
	
	//配置内容信息
	$( "#dialog-html-alert .alert-info" ).html(m);
	
	//配置标题
	var alert_title = '系統提示';
	if(!t && typeof(t)!="undefined" && t!=0){
		alert_title = t;
	}
	
	$( "#dialog-html-alert" ).removeClass('hide').dialog({
		resizable: false,
		modal: true,
		title: "<div class='widget-header'><h4 class='smaller'><i class='icon-bell-alt green'></i>"+alert_title+"</h4></div>",
		title_html: true,
		buttons: [
			{
				text: "確認",
				"class" : "btn btn-primary btn-xs",
				click: function() {
					$( this ).dialog( "close" ); 
				} 
			}
		]
	});
}

/**
 * @Author pwr at 2018-01-31
 * @name html_confirm
 * @todo 全局操作提示框
 * @参数 m：提示框内容；fun：確認后操作的方法；fun_data：操作方法传参数；fun_data2：操作方法传参数2；
 */
function html_confirm(m,fun,fun_data,fun_data2){
	$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
		_title: function(title) {
			var $title = this.options.title || '&nbsp;'
			if( ("title_html" in this.options) && this.options.title_html == true )
				title.html($title);
			else title.text($title);
		}
	}));
	
	//配置内容信息
	$( "#dialog-confirm .alert-info span" ).html(m);
	
	//配置标题
	var alert_title = '系統操作提示';
	
	$( "#dialog-confirm" ).removeClass('hide').dialog({
		resizable: false,
		modal: true,
		title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i>"+alert_title+"</h4></div>",
		title_html: true,
		buttons: [
			{
				html: "確認",
				"class" : "btn btn-danger btn-xs",
				click: function() {
					$( this ).dialog( "close" );
					fun(fun_data,fun_data2);
				}
			}
			,
			{
				html: "<i class='icon-remove bigger-110'></i>&nbsp; 關閉",
				"class" : "btn btn-xs",
				click: function() {
					$( this ).dialog( "close" );
				}
			}
		]
	});
}

/**
 * @Author pwr at 2018-02-05
 * @name html_document
 * @todo 全局html搜索弹框
 * @参数 m：提示框内容；fun：確認后操作的方法；fun_data：操作方法传参数；fun_data2：操作方法传参数2；
 */
function html_document(m,t,fun,fun_data,fun_data2){
	$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
		_title: function(title) {
			var $title = this.options.title || '&nbsp;'
			if( ("title_html" in this.options) && this.options.title_html == true )
				title.html($title);
			else title.text($title);
		}
	}));
	
	//配置内容信息
	$( "#dialog-html-document .alert" ).html(m);
	
	//配置标题
	var alert_title = '搜索框';
	if(typeof(t)!="undefined" && t!=0 && t!=''){
		alert_title = t;
	}
	
	$( "#dialog-html-document" ).removeClass('hide').dialog({
		width: 500,
		height: 300,
		resizable: false,
		modal: true,
		title: "<div class='widget-header'><h4 class='smaller'><i class='icon-bell-alt green'></i>"+alert_title+"</h4></div>",
		title_html: true,
		buttons: [
			{
				html: "確認",
				"class" : "btn btn-danger btn-xs",
				click: function() {
					$( this ).dialog( "close" );
					fun(fun_data,fun_data2);
				}
			}
			,
			{
				html: "<i class='icon-remove bigger-110'></i>&nbsp; 關閉",
				"class" : "btn btn-xs",
				click: function() {
					$( this ).dialog( "close" );
				}
			}
		]
	});
}

//退出登录
function logout_onlick() {
	html_confirm('是否退出？',do_logout);
}

function do_logout(){
	$.ajax({
		type: "post",
		url: "/wfpcAdmin/login/ajaxlogout",
		//dataType: "text",
		success: function(result) {                    //r为返回值
			console.log('成功退出');
			window.location.href = "/wfpcAdmin/login";
		}
	});
}