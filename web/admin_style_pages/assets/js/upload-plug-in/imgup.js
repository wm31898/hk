$(function(){
	var delParent;
	var defaults = {
		fileType : ["jpg","png","bmp","jpeg","gif"],   // 上传文件的类型
		fileSize : 1024 * 1024 * 10,              // 上传文件的大小 10M
		maxFiles : 5
	};
		
	/*点击图片的文本框*/
	$(".file").change(function(){
		var imgContainer = $(this).parents(".z_photo"); //存放图片的父亲元素
		var setMaxFiles = imgContainer.find(".z_max_files").val();
		var maxFiles = defaults.maxFiles;
		if(setMaxFiles>0){
			maxFiles = setMaxFiles;
		}
		
		var fileList = $(this).prop('files'); //获取的图片文件
		console.log(fileList+"======filelist=====");
		
		var input = $(this).parent();//文本框的父亲元素
		var imgArr = [];
		//遍历得到的图片文件
		var numUp = imgContainer.find(".up-section").length;
		var totalNum = numUp + fileList.length;  //总的数量
		if(fileList.length > maxFiles || totalNum > maxFiles ){
			html_alert('上传图片数目不可以超过'+maxFiles+'张，请重新选择');  //一次选择上传超过5个 或者是已经上传和这次上传的到的总数也不可以超过5个
		}
		else if(numUp < maxFiles){
			//fileList = validateUp(fileList);
			var return_fileList = validateUp(fileList,imgContainer);
			console.log(return_fileList);
			console.log(return_fileList.length);
			//console.log(return_fileList.);
			//alert(return_fileList[);
		}
		setTimeout(function(){
             $(".up-section").removeClass("loading");
		 	 $(".up-img").removeClass("up-opcity");
		 },450);
		
		//input内容清空
		$(this).val("");
	});
   
    $(".z_photo").delegate(".close-upimg","click",function(){
			html_confirm('是否要删除该图片？',removeUpSection,$(this));
	});
	
	function removeUpSection(i){
		$(i).parent('.up-section').parent('.z_photo').find('.z_file').show();
		$(i).parent('.up-section').remove();
	}
		
	function validateUp(files,imgContainer){
		var arrFiles = [];//替换的文件数组
		for(var i = 0, file; file = files[i]; i++){
			//获取文件上传的后缀名
			var newStr = file.name.split("").reverse().join("");
			if(newStr.split(".")[0] != null){
					var type = newStr.split(".")[0].split("").reverse().join("");
					//console.log(type+"===type===");
					if(jQuery.inArray(type, defaults.fileType) > -1){
						// 类型符合，可以上传
						if (file.size >= defaults.fileSize) {
							html_alert(file.size);
							html_alert('您这个"'+ file.name +'"文件大小过大');	
						} else {
							// 在这里需要判断当前所有文件中
							//var FileController = "http://dv.wufutz.com/wfpcAdmin/default/upload-image"; // 接收上传文件的后台地址 
							var FileController = imgContainer.find(".z_upload_url").val(); // 接收上传文件的后台地址
							
							if(typeof(FileController)!="undefined" && FileController!=''){
								// FormData 对象
								var formFile = new FormData();
								formFile.append("image", file);                           // 文件对象

								var data = formFile;
								$.ajax({
								   url: FileController,
								   data: data,
								   type: "Post",
								   //dataType: "json",
								   cache: false,//上传文件无需缓存
								   processData: false,//用于对data参数进行序列化处理 这里必须false
								   contentType: false, //必须
								   success: function (result) {
									   //console.log(result);
									   if(result.code==10000){
											//html_alert("上传完成");
											arrFiles.push(result.data);
											createImgContainer(result.data,imgContainer)
									   }else{
										   html_alert('上传失败 错误码:'+result.code);
									   }
								   },
								})	
							}else{
								html_alert('缺少上传路径');	
							}
						}
					}else{
						html_alert('您这个"'+ file.name +'"上传类型不符合');	
					}
				}else{
					html_alert('您这个"'+ file.name +'"没有类型, 无法识别');	
				}
		}
		return arrFiles;
	}
	
	//展示图片
	function createImgContainer(data,imgContainer){
		var z_field_name = imgContainer.find('.z_field_name').val();
		var h = '<section class="up-section fl">';
			h +='	<span class="up-span"></span>';
			//h +='	<img class="close-upimg" src="img/a7.png"><img class="up-img" src="'+data.url+'">';
			h +='	<span class="close-upimg"><i class="icon-trash bigger-110"></i></span><img class="up-img" src="'+data.url+'">';
			h +='	<input name="'+z_field_name+'" value="'+data.path+'" type="hidden">';
			h +='</section>';
		imgContainer.prepend(h);
		
		//检查隐藏按钮
		var setMaxFiles = imgContainer.find(".z_max_files").val();
		var maxFiles = defaults.maxFiles;
		if(setMaxFiles>0){
			maxFiles = setMaxFiles;
		}
		numUp = imgContainer.find(".up-section").length;
		if(numUp >= maxFiles){
			imgContainer.find('.z_file').hide();
		}
	}
})
