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
			<form class="form-inline">
				<span>作者：</span><input class="margin-r-10" placeholder="作者" type="text">
				<span>文章名：</span><input class="margin-r-10" placeholder="文章名" type="text">
				<span>类型：</span>
				<select class="margin-r-10">
					<option value="0">請選擇</option>
					<option value="1">数据1</option>
					<option value="2">数据2</option>
					<option value="3">数据3</option>
				</select>
				
				<span>开始時間：</span>
				<span class="margin-r-10">
					<i class="icon-calendar bigger-110"></i>
					<input type="text" class="datetime-picker" name="atart_time" value="" readonly>
				</span>
				
				<span>结束時間：</span>
				<span class="margin-r-10">
					<i class="icon-calendar bigger-110"></i>
					<input type="text" class="datetime-picker" name="end_time" value="" readonly>
				</span>
				
				<button class="btn btn-purple btn-sm" type="button">Search<i class="icon-search icon-on-right bigger-110"></i></button>
			</form>
		</div>
	</div>
</div>

<h3 class="header smaller lighter blue">文章列表</h3>

<div class="table-responsive">
	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Domain</th>
				<th>Price</th>
				<th class="hidden-480">Clicks</th>

				<th>
					<i class="icon-time bigger-110 hidden-480"></i>
					Update
				</th>
				<th class="hidden-480">Status</th>

				<th>操作</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>
					<a href="#">ace.com</a>
				</td>
				<td>$45</td>
				<td class="hidden-480">3,330</td>
				<td>Feb 12</td>

				<td class="hidden-480">
					<span class="label label-sm label-warning">Expiring</span>
				</td>

				<td>
					<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
						<button class="btn btn-xs btn-success">
							<i class="icon-ok bigger-120"></i>
						</button>

						<button class="btn btn-xs btn-info">
							<i class="icon-edit bigger-120"></i>
						</button>

						<button class="btn btn-xs btn-danger">
							<i class="icon-trash bigger-120"></i>
						</button>

						<button class="btn btn-xs btn-warning">
							<i class="icon-flag bigger-120"></i>
						</button>
					</div>
				</td>
			</tr>

			<tr>
				<td>
					<a href="#">base.com</a>
				</td>
				<td>$35</td>
				<td class="hidden-480">2,595</td>
				<td>Feb 18</td>

				<td class="hidden-480">
					<span class="label label-sm label-success">Registered</span>
				</td>

				<td>
					<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
						<button class="btn btn-xs btn-success">
							<i class="icon-ok bigger-120"></i>
						</button>

						<button class="btn btn-xs btn-info">
							<i class="icon-edit bigger-120"></i>
						</button>

						<button class="btn btn-xs btn-danger">
							<i class="icon-trash bigger-120"></i>
						</button>

						<button class="btn btn-xs btn-warning">
							<i class="icon-flag bigger-120"></i>
						</button>
					</div>
				</td>
			</tr>
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
</script>