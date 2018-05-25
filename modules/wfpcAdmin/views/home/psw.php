<!-- 日历插件css -->
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/datetimepicker.css" />
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/upload-plug-in/index.css" />
<div class="page-header">
    <h1>修改密碼頁面</h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal" method="post" role="form" enctype="multipart/form-data" onsubmit="checkForm(); return false;">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">原始密碼</label>
                <div class="col-sm-9">
                    <input placeholder="原始密碼" class="col-xs-10 col-sm-5" type="password" id="old_psw" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">新的密碼</label>
                <div class="col-sm-9">
                    <input placeholder="新的密碼" class="col-xs-10 col-sm-5" type="password" id="new_psw" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">確認密碼</label>
                <div class="col-sm-9">
                    <input placeholder="確認密碼" class="col-xs-10 col-sm-5" type="password" id="sure_psw" value="">
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="button" onClick="$('form').submit();">
                        <i class="icon-ok bigger-110"></i>
                        修改密碼
                    </button>

                    &nbsp; &nbsp; &nbsp;


                    <span id="span_id"></span>
                    <!--<button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        刷新
                    </button>

                    <button class="btn" type="reset" onClick="checkAjax('提示')">
                        提示
                    </button>

                    <button class="btn" type="reset" onClick="html_confirm('提示2')">
                        提示2
                    </button>-->
                </div>
            </div>
        </form>


        <!-- END 弹框搜索版块的內容 -->

    </div>
</div>
<?php
if(isset($this->context->page_js)){
    $this->context->page_js = array(
        '/date-time/bootstrap-datepicker.min.js',//日期组件js
        '/date-time/bootstrap-timepicker.min.js',//日期组件js
        '/date-time/moment.min.js',//日期组件js
        '/date-time/daterangepicker.min.js',//日期组件js
        '/date-time/bootstrap-datetimepicker.js',//日期组件js
        '/ueditor/ueditor.config.js',//ueditor组件js
        '/ueditor/ueditor.all.min.js',//ueditor组件js
        '/ueditor/lang/zh-cn/zh-cn.js',//ueditor组件js
        '/upload-plug-in/imgup.js',//上传圖片组件js
    );
}
?>
<script type="text/javascript">
    jQuery(function($) {
        //$('[data-rel=tooltip]').tooltip({container:'body'});
        //$('[data-rel=popover]').popover({container:'body'});
        //日期输入框组件
        $('.datetime-picker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', autoclose: true});

        //var ue = UE.getEditor('editor', { 'allowDivTransToP':false, });
    });

    //表單提交
    function checkForm(){
        var old_psw = $('#old_psw').val();
        var new_psw = $('#new_psw').val();
        var sure_psw = $('#sure_psw').val();
        if(old_psw == '') {
            alert('原始密碼不能爲空!');
            document.getElementById('old_psw').focus();
            return false;
        }
        if(new_psw == '') {
            alert('新的密碼不能爲空!');
            document.getElementById('new_psw').focus();
            return false;
        }
        if(sure_psw == '') {
            alert('確認密碼不能爲空!');
            document.getElementById('sure_psw').focus();
            return false;
        }

        if(new_psw != sure_psw ) {
            alert('新密碼與確認密碼不壹致!');
            document.getElementById('sure_psw').focus();
            return false;
        }

        //新密码不能修改为原始密码
        if( old_psw == sure_psw  ) {
            alert('新密碼不能與原始密碼壹致!');
            document.getElementById('sure_psw').focus();
            return false;
        }

        var t= {
            old_psw: old_psw,
            new_psw: new_psw,
            sure_psw: sure_psw,

        };
        $.ajax({
            type: "post",
            url: "/wfpcAdmin/home/valid",
            //data:JSON.stringify(t), //将对象转为为json字符串
            data : t ,
            success: function(result) {                    //r为返回值

                if (result.code == '10000') {
                    $("#span_id").html('修改成功');
                    $("#span_id").css("color","blue");
                    window.location.href = "/wfpcAdmin/home";
                } else {
                    //$("#span_id").html(result.msg);
                    alert(result.msg);
                }

            }
        });

        //return true;
    }

    function setSearchVal(){
        var v = $('#dialog-html-document .search_val').val();
        var h = $('#dialog-html-document .search_val').find("option:selected").text();
        if(v>0){
            $('.search_text').val(h);
            $("input[name='search_val']").val(v);
        }else{
            $('.search_text').val('');
            $("input[name='search_val']").val('');
        }
    }
</script>