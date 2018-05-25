<?php
    use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/daterangepicker.css" />
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/datetimepicker.css" />
<div class="widget-box">
	<div class="alert alert-info">
		已發佈商品數量：<span id="publish_count"><?php echo $publish_count; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;未發佈商品數量：<span id="no_publish_count"><?php echo $no_publish_count; ?></span>
		<button class="close" data-dismiss="alert">
			<i class="icon-remove"></i>
		</button>
	</div>
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
            <form class="form-inline" action="/wfpcAdmin/article/article-list">
                <span>文章ID：</span><input class="margin-r-10" placeholder="文章ID" type="text" name="id" value="<?php echo isset($get_data['id']) && $get_data['id']>0 ? $get_data['id']:''; ?>">
				<span>文章標題：</span><input class="margin-r-10" placeholder="文章標題" type="text" name="title" value="<?php echo isset($get_data['title']) && $get_data['title']!='' ? $get_data['title']:''; ?>">
                <span>文章分類：</span>
                <select class="margin-r-10" name="cate_id">
					<option value="0">全部</option>
                    <?php
                        if(!empty($cate_list)){
							foreach($cate_list as $v){
								if(isset($get_data['cate_id']) && $get_data['cate_id']==$v['id']){
									echo '<option value="'.$v['id'].'" selected="selected">'.$v['title'].'</option>';
								}else{
									echo '<option value="'.$v['id'].'">'.$v['title'].'</option>';
								}
							}
						}
                    ?>
                </select>
                
                <a class="btn btn-success btn-sm" href="javascript:;" onClick="$(this).parent('form').submit();">查詢<i class="icon-search icon-on-right bigger-110"></i></a>
                <a class="btn btn-purple btn-sm" href="/wfpcAdmin/article/article-list">清除<i class="icon-undo icon-on-right bigger-110"></i></a>
                <a class="btn btn-primary btn-sm" href="/wfpcAdmin/article/article-add">添加文章<i class="icon-pencil icon-on-right bigger-110"></i></a>
            </form>
        </div>
    </div>
</div>

<h3 class="header smaller lighter blue">文章列表</h3>

<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>文章ID</th>
                <th>文章標題</th>
                <th>文章分類</th>
                <th>發佈狀態</th>
                <th><i class="icon-time bigger-110 hidden-480"></i>更新時間</th>
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
                    <td><?php echo $v['title']; ?></td>
                    <td><?php echo $v['cate_name']; ?></td>
                    <td class="is_publish_td"><?php echo $v['is_publish']==1?'已發佈':'未發佈'; ?></td>
                    <td><?php echo $v['update_time']>0 ? date('Y-m-d H:i:s',$v['update_time']) : '暫無'; ?></td>
                    <td><?php echo $v['sort']; ?></td>
                    <td>
						<a class="btn btn-xs btn-info" href="/wfpcAdmin/article/article-details?id=<?php echo $v['id']; ?>"><i class="icon-edit bigger-120"></i></a>
						<a class="btn btn-xs btn-danger" href="javascript:;" onClick="html_confirm('是否要删除該文章？',delData,<?php echo $v['id']; ?>,$(this));"><i class="icon-trash bigger-120"></i></a>
						<a class="btn btn-xs btn-success is_publish_button <?php echo $v['is_publish']==1 ? 'hide':''; ?>" href="javascript:;" title="發佈" ads_id="<?php echo $v['id']; ?>" article_is_publish="1" onClick="html_confirm('是否要發佈該文章？',doPublish,$(this));"><i class="icon-arrow-up bigger-120"></i></a>
						<a class="btn btn-xs btn-warning is_publish_button <?php echo $v['is_publish']==1 ? '':'hide'; ?>" href="javascript:;" title="下架" ads_id="<?php echo $v['id']; ?>" article_is_publish="0" onClick="html_confirm('是否要下架該文章？',doPublish,$(this));"><i class="icon-arrow-down bigger-120"></i></a>
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
     * @todo 文章删除
     */
	function delData(id,i){
		if(id>0){
			$.ajax({
			   url: '/wfpcAdmin/article/article-delete',
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
			html_alert('缺少文章ID');
		}
	}
	
	/**
     * @Author pwr at 2018-04-10
     * @name doPublish
     * @todo 文章發佈和下架
     */
	function doPublish(i){
		var id = $(i).attr('ads_id');
		var is_publish = $(i).attr('article_is_publish');
		if(id>0){
			$.ajax({
			   url: '/wfpcAdmin/article/article-publish',
			   data: {'id':id,'is_publish':is_publish},
			   type: "Post",
			   //dataType: "json",
			   //cache: false,//上传文件无需缓存
			   //processData: false,//用于对data参数进行序列化处理 这里必须false
			   //contentType: false, //必须
			   success: function (result) {
				   if(result.code==10000){
						//$(i).parents("tr").remove();
						$(i).parent().find('.is_publish_button').removeClass('hide');
						$(i).addClass('hide');
						if(is_publish==1){
							$(i).parent().parent('td').parent('tr').find('.is_publish_td').html('已發佈');
						}else{
							$(i).parent().parent('td').parent('tr').find('.is_publish_td').html('未發佈');
						}
						
						getPublishCount();
				   }else{
					   html_alert('操作失敗:'+result.code);
				   }
			   },
			})
		}else{
			html_alert('缺少商品ID');
		}
	}
	
	/**
     * @Author pwr at 2018-04-10
     * @name getPublishCount
     * @todo 文章發佈數量
     */
	function getPublishCount(){
		$.ajax({
		   url: '/wfpcAdmin/article/get-publish-count',
		   data: {},
		   type: "Get",
		   //dataType: "json",
		   //cache: false,//上传文件无需缓存
		   //processData: false,//用于对data参数进行序列化处理 这里必须false
		   //contentType: false, //必须
		   success: function (result) {
			   if(result.code==10000){
					$('#publish_count').html(result.data.publish_count);
					$('#no_publish_count').html(result.data.no_publish_count);
			   }else{
				   //html_alert('操作失敗:'+result.code);
			   }
		   },
		})
	}
</script>