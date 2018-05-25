<?php
    use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/daterangepicker.css" />
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/datetimepicker.css" />
<div class="widget-box">
    <div class="widget-header widget-header-small">
        <h5 class="lighter">列表操作</h5>
        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
            <i class="icon-chevron-up"></i>
        </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <form class="form-inline" action="/wfpcAdmin/goods/goods-type-list">
                <span>分類ID：</span><input class="margin-r-10" placeholder="分類ID" type="text" name="id" value="<?php echo isset($get_data['id']) && $get_data['id']>0 ? $get_data['id']:''; ?>">
                <span>分類名：</span><input class="margin-r-10" placeholder="分類名" type="text" name="type_name" value="<?php echo isset($get_data['type_name']) && $get_data['type_name']!='' ? $get_data['type_name']:''; ?>">
                <a class="btn btn-success btn-sm" href="javascript:;" onClick="$(this).parent('form').submit();">查詢<i class="icon-search icon-on-right bigger-110"></i></a>
                <a class="btn btn-purple btn-sm" href="/wfpcAdmin/goods/goods-type-list">清除<i class="icon-undo icon-on-right bigger-110"></i></a>
                <a class="btn btn-primary btn-sm" href="/wfpcAdmin/goods/goods-type-add">添加商品分類<i class="icon-pencil icon-on-right bigger-110"></i></a>
            </form>
        </div>
    </div>
</div>

<h3 class="header smaller lighter blue">商品分類列表</h3>

<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>分類ID</th>
                <th>分類名</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
        </thead>

        <tbody>
        <?php
            if(!empty($data['list'])){
                foreach($data['list'] as $v){
        ?>
                <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['type_name']; ?></td>
                    <td><?php echo $v['sort']; ?></td>
                    <td>
						<a class="btn btn-xs btn-info" href="/wfpcAdmin/goods/goods-type-details?id=<?php echo $v['id']; ?>"><i class="icon-edit bigger-120"></i></a>
						<a class="btn btn-xs btn-danger" href="javascript:;" onClick="html_confirm('是否要删除該商品分類？',delData,<?php echo $v['id']; ?>,$(this));"><i class="icon-trash bigger-120"></i></a>
                    </td>
                </tr>
        <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>
<?php echo LinkPager::widget(['pagination'=>$pages,'nextPageLabel'=>'下一頁','prevPageLabel'=>'上一頁', 'firstPageLabel'=>'首頁','lastPageLabel'=>'尾頁','maxButtonCount'=>5]); ?>

<!-- 当前頁面需要加载的js -->
<?php
    if(isset($this->context->page_js)){
        $this->context->page_js = array(
            '/date-time/bootstrap-datepicker.min.js',
            '/date-time/bootstrap-timepicker.min.js',
            '/date-time/moment.min.js',
            '/date-time/daterangepicker.min.js',
            '/date-time/bootstrap-datetimepicker.js',
        );
    }
?>
<script type="text/javascript">
    $(function () {
        //日期区间输入框组件
        /*$('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function(){
            $(this).next().focus();
        });*/
        
        //日期输入框组件
        $('.datetime-picker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', autoclose: true});
    });
	
	/**
     * @Author pwr at 2018-02-08
     * @name delData
     * @todo 商品分類删除
     */
	function delData(id,i){
		if(id>0){
			$.ajax({
			   url: '/wfpcAdmin/goods/goods-type-delete',
			   data: {'id':id},
			   type: "Post",
			   //dataType: "json",
			   //cache: false,//上传文件无需缓存
			   //processData: false,//用于对data参数进行序列化处理 这里必须false
			   //contentType: false, //必须
			   success: function (result) {
				   if(result.code==10000){
						$(i).parents("tr").remove();
				   }else{
					   html_alert('操作失敗:'+result.code);
				   }
			   },
			})
		}else{
			html_alert('缺少商品ID');
		}
	}
</script>