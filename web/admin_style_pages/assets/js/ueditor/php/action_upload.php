<?php

function setLog($content, $filename='') {
    empty($filename) && $filename = "log_". date('Y_m_d') .".log";
    if(is_array($content) || is_object($content)) $content = json_encode($content);
    $content = "[". date('Y-m-d H:i:s') ."] {$content}\r\n";
    $op = file_put_contents("/data/PRG/php/var/log/{$filename}", $content, FILE_APPEND);
    return $op;
}

function postPic($url,$params)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $ret = @curl_exec($ch);
	
	//var_dump(curl_error($ch));//打印curl错误

    curl_close ($ch);
    return $ret;
}

function uploadFile($file_name){
    $return = array('code' => 10000, 'message' => '返回成功', 'data' => array());
    //$url = "http://apitest.wufu360.com/admin/goods/upload-image";
    $url = 'http://'.$_SERVER['HTTP_HOST'].'/wfpcAdmin/default/upload-image';
    //$log_filename = 'backend_upload_'. date('Y_m_d') .".log";
	$token = '';
	if(isset($_COOKIE['token']) && $_COOKIE['token']!=''){
		$token = $_COOKIE['token'];
	}
	//var_dump($_COOKIE);
    $new_file = dirname($_FILES[$file_name]['tmp_name']) . DIRECTORY_SEPARATOR . $_FILES[$file_name]['name'];
    rename($_FILES[$file_name]['tmp_name'], $new_file);

	if (class_exists('CURLFile')) {  
        $upload_data = array(
			$file_name =>new CURLFile($new_file),
			'f_n' =>$file_name,
			'folder_type' =>2,
			'token' =>$token,
		);  
    } else {  
        $upload_data = array(
			$file_name =>'@'.$new_file,
			'f_n' =>$file_name,
			'folder_type' =>2,
			'token' =>$token,
		);
    }  
    

    $upload = postPic($url, $upload_data);
	//var_dump($upload);
	//die();
    if( !$upload ) {
        //setLog("图片服务器访问失败，原文件名：{$_FILES[$file_name]['name']}", $log_filename);
        $return['code'] = 1104;
        $return['message'] = '图片服务器访问失败';
    } else {
        $upload = json_decode($upload, true);

        if ($upload['code'] != 10000) {
            //setLog("图片服务器访问成功但上传失败，上传接口返回：". json_encode($upload), $log_filename);
            $return['code'] = 1104;
            $return['message'] = 'code:'.$upload['code'] .' msg:'.$upload['msg'];
        } else {
            $return['data'] = $upload['data'];
            $return['data']['size'] = $_FILES[$file_name]['size'];
            $return['data']['original'] = $_FILES[$file_name]['name'];
			$i_type = implode('.',$_FILES[$file_name]['name']);
            $return['data']['type'] = (string)$i_type[1];
        }
    }
    return $return;
}
$op = uploadFile('upfile');

if( $op['code'] != 10000 ) {
    echo json_encode(array(
        "state" => $op['code'],
        'message' => $op['message'],
        'op' => $op,
    ));
} else {
	echo json_encode(array(
		"state" => 'SUCCESS',
		"url" => $op['data']['url'],
		"title" => $op['data']['path'],
		"original" => $op['data']['original'],
		"type" => $op['data']['type'],
		"size" => $op['data']['size'],
	));
}
exit();