<?php
    use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/daterangepicker.css" />
<link rel="stylesheet" href="<?php echo Yii::$app->params['adminCssUrl']; ?>/datetimepicker.css" />
<div class="widget-box">
    <div class="alert alert-info">
        已發布新聞數量：<span id="ok_span"><?php echo $publish_count; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;未發布新聞數量：<span id="op_span"><?php echo $no_publish_count; ?></span>
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
            <form class="form-inline" action="/wfpcAdmin/news/news-list">
                <span>新聞標題：</span><input class="margin-r-10" placeholder="新聞標題" type="text" name="title" value="<?php echo isset($get_data['title']) && $get_data['title']!='' ? $get_data['title']:''; ?>">
                <span>新聞分類：</span>
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
                
                <!--<span>开始時間：</span>
                <span class="margin-r-10">
                    <i class="icon-calendar bigger-110"></i>
                    <input type="text" class="datetime-picker" name="start_time" value="<?php /*echo isset($get_data['start_time']) && $get_data['start_time']>0 ? $get_data['start_time']:''; */?>" readonly>
                </span>
                
                <span>结束時間：</span>
                <span class="margin-r-10">
                    <i class="icon-calendar bigger-110"></i>
                    <input type="text" class="datetime-picker" name="end_time" value="<?php /*echo isset($get_data['end_time']) && $get_data['end_time']>0 ? $get_data['end_time']:''; */?>" readonly>
                </span>-->
                
                <a class="btn btn-success btn-sm" href="javascript:;" onClick="$(this).parent('form').submit();">查詢<i class="icon-search icon-on-right bigger-110"></i></a>
                <a class="btn btn-purple btn-sm" href="/wfpcAdmin/news/news-list">清除<i class="icon-undo icon-on-right bigger-110"></i></a>
                <a class="btn btn-primary btn-sm" href="/wfpcAdmin/news/news-add">添加新聞<i class="icon-pencil icon-on-right bigger-110"></i></a>
            </form>
        </div>
    </div>
</div>

<h3 class="header smaller lighter blue">新聞列表</h3>

<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>新聞ID</th>
                <th>新聞標題</th>
                <th>新聞分類</th>
                <th>新聞圖</th>
                <!--<th><i class="icon-time bigger-110 hidden-480"></i>添加時間</th>-->
                <th><i class="icon-time bigger-110 hidden-480"></i>發布時間</th>
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
					<td><?php if($v['image_url']!=''){ echo '<img src="'.$v['image_url'].'" width="95" height="145">'; }else{ echo '暫無'; } ?></td>
                    <!--<td><?php /*echo date('Y-m-d H:i:s',$v['create_time']); */?></td>-->
                    <td><?php  echo $v['publish_time']!=0  ? date('Y-m-d H:i:s',$v['publish_time']):'暫無'; ?></td>
                    <td><?php echo $v['sort']; ?></td>
                    <td>
						<a class="btn btn-xs btn-info" href="/wfpcAdmin/news/news-details?id=<?php echo $v['id']; ?>"><i class="icon-edit bigger-120"></i></a>
						<a class="btn btn-xs btn-danger" href="javascript:;" onClick="html_confirm('是否要刪除該新聞？',delData,<?php echo $v['id']; ?>,$(this));"><i class="icon-trash bigger-120"></i></a>
						<a class="btn btn-xs btn-success is_publish_button <?php echo $v['is_publish']==1 ? 'hide':''; ?>" href="javascript:;" title="發布" ads_id="<?php echo $v['id']; ?>" ads_is_publish="1" onClick="html_confirm('是否要發布該新聞？',doPublish,$(this));"><i class="icon-arrow-up bigger-120"></i></a>
						<a class="btn btn-xs btn-warning is_publish_button <?php echo $v['is_publish']==1 ? '':'hide'; ?>" href="javascript:;" title="下架" ads_id="<?php echo $v['id']; ?>" ads_is_publish="0" onClick="html_confirm('是否要下架該新聞？',doPublish,$(this));"><i class="icon-arrow-down bigger-120"></i></a>
                    </td>
                </tr>
        <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>
<?php echo LinkPager::widget(['pagination'=>$pages,'nextPageLabel'=>'下壹頁','prevPageLabel'=>'上壹頁', 'firstPageLabel'=>'首頁','lastPageLabel'=>'尾頁','maxButtonCount'=>5]); ?>

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
     * @todo 新闻删除
     */
	function delData(id,i){
		if(id>0){
			$.ajax({
			   url: '/wfpcAdmin/news/news-delete',
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
			html_alert('缺少新聞ID');
		}
	}

    /**
     * @Author pwr at 2018-04-09
     * @name doPublish
     * @todo 轮播圖發佈和下架
     */
    function doPublish(i){
        var id = $(i).attr('ads_id');
        var is_publish = $(i).attr('ads_is_publish');
        if(id>0){
            $.ajax({
                url: '/wfpcAdmin/news/news-publish',
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
                        $('#ok_span').html(result.data.ok_count);//刷新统计發佈的新闻數量
                        $('#op_span').html(result.data.no_count);//刷新统计發佈的新闻數量
                        //console.log(result.data.no_count);
                        if(is_publish==1){
                            $(i).parent().parent('td').parent('tr').find('.is_publish_td').html('已發布');
                        }else{
                            $(i).parent().parent('td').parent('tr').find('.is_publish_td').html('未發布');
                        }
                    }else{
                        html_alert('操作失敗:'+result.code);
                    }
                },
            })
        }else{
            html_alert('缺少輪播圖ID');
        }
    }
</script>