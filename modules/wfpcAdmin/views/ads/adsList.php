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
            <form class="form-inline" action="/wfpcAdmin/ads/ads-list">
                <span>輪播圖ID：</span><input class="margin-r-10" placeholder="輪播圖ID" type="text" name="id" value="<?php echo $get_data['id']>0 ? $get_data['id']:''; ?>">
                <!--<span>类型：</span>
                <select class="margin-r-10" name="type">
                    <?php
                        $type_list = array(2=>'全部',0=>'普通輪播圖',1=>'視頻輪播圖');
                        foreach($type_list as $k=>$v){
                            if(isset($get_data['type']) && $get_data['type']==$k){
                                echo '<option value="'.$k.'" selected="selected">'.$v.'</option>';
                            }else{
                                echo '<option value="'.$k.'">'.$v.'</option>';
                            }
                        }
                    ?>
                </select>
                
                <span>开始時間：</span>
                <span class="margin-r-10">
                    <i class="icon-calendar bigger-110"></i>
                    <input type="text" class="datetime-picker" name="start_time" value="<?php echo $get_data['start_time']>0 ? $get_data['start_time']:''; ?>" readonly>
                </span>
                
                <span>结束時間：</span>
                <span class="margin-r-10">
                    <i class="icon-calendar bigger-110"></i>
                    <input type="text" class="datetime-picker" name="end_time" value="<?php echo $get_data['end_time']>0 ? $get_data['end_time']:''; ?>" readonly>
                </span>-->
                
                <a class="btn btn-success btn-sm" href="javascript:;" onClick="$(this).parent('form').submit();">查詢<i class="icon-search icon-on-right bigger-110"></i></a>
                <a class="btn btn-purple btn-sm" href="/wfpcAdmin/ads/ads-list">清除<i class="icon-undo icon-on-right bigger-110"></i></a>
                <a class="btn btn-primary btn-sm" href="/wfpcAdmin/ads/ads-add">添加輪播圖<i class="icon-pencil icon-on-right bigger-110"></i></a>
            </form>
        </div>
    </div>
</div>

<h3 class="header smaller lighter blue">廣告圖列表</h3>

<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>廣告ID</th>
                <th>廣告標題</th>
                <th>廣告圖</th>
                <!--<th><i class="icon-time bigger-110 hidden-480"></i>發佈時間</th>
                <th><i class="icon-time bigger-110 hidden-480"></i>失效時間</th>-->
                <th>排序</th>
                <th>狀態</th>
                <th>操作</th>
            </tr>
        </thead>

        <tbody>
        <?php
            if(!empty($data['adsList'])){
                foreach($data['adsList'] as $v){
        ?>
                <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['title']; ?></td>
                    <td><?php if($v['image_url']!=''){ echo '<img src="'.$v['image_url'].'" width="192" height="56">'; }else{ echo '暫無'; } ?></td>
                    <!--<td><?php echo date('Y-m-d H:i:s',$v['publish_time']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['end_time']); ?></td>-->
                    <td><?php echo $v['sort']; ?></td>
                    <td class="is_publish_td"><?php echo $v['is_publish']==1 ? '已發佈':'未發佈'; ?></td>
                    <td>
						<a class="btn btn-xs btn-info" href="/wfpcAdmin/ads/ads-details?id=<?php echo $v['id']; ?>"><i class="icon-edit bigger-120"></i></a>
						<a class="btn btn-xs btn-danger" href="javascript:;" onClick="html_confirm('是否要删除該輪播圖？',delData,<?php echo $v['id']; ?>,$(this));"><i class="icon-trash bigger-120"></i></a>
						<a class="btn btn-xs btn-success is_publish_button <?php echo $v['is_publish']==1 ? 'hide':''; ?>" href="javascript:;" title="發佈" ads_id="<?php echo $v['id']; ?>" ads_is_publish="1" onClick="html_confirm('是否要發佈該輪播圖？',doPublish,$(this));"><i class="icon-arrow-up bigger-120"></i></a>
						<a class="btn btn-xs btn-warning is_publish_button <?php echo $v['is_publish']==1 ? '':'hide'; ?>" href="javascript:;" title="下架" ads_id="<?php echo $v['id']; ?>" ads_is_publish="0" onClick="html_confirm('是否要下架該輪播圖？',doPublish,$(this));"><i class="icon-arrow-down bigger-120"></i></a>
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
     * @todo 輪播圖删除
     */
	function delData(id,i){
		if(id>0){
			$.ajax({
			   url: '/wfpcAdmin/ads/ads-delete',
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
			html_alert('缺少輪播圖ID');
		}
	}
	
	/**
     * @Author pwr at 2018-04-09
     * @name doPublish
     * @todo 輪播圖發佈和下架
     */
	function doPublish(i){
		var id = $(i).attr('ads_id');
		var is_publish = $(i).attr('ads_is_publish');
		if(id>0){
			$.ajax({
			   url: '/wfpcAdmin/ads/ads-publish',
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