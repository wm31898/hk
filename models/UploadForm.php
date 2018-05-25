<?php
namespace app\models;

use yii;
use yii\base\Model;
use yii\web\UploadedFile;

use yii\imagine\Image;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, bmp, jpeg', 'maxFiles' => 4],
        ];
    }
    
	/**
	 * @author pwr at 2017-05-05
	 * @todo   上传图片操作
	 */
    public function upload($inputName='UploadForm[imageFiles]',$url='',$thumbConfig=array()){
		//返回值初始化
		$data = array('code'=>1000,'files'=>array(),'error'=>'');
		
		if(empty(Yii::$app->params['imageUrl'])){
			$data['error'] = '配置文件params imageUrl缺失';
			return $data;
		}
		
		//$fullUrl = Yii::$app->basePath.'/web/uploads/';
		$fullUrl = 'web/uploads/';
		if($url!=''){
			$url .= '/';
			$fullUrl .= $url;
		}
		//生成上传图片文件夹
		if(!$this->createDir($fullUrl)){
			$data['error'] = '上传文件路径错误：'.$fullUrl;
			return $data;
		}
		//赋值
		$this->imageFiles = UploadedFile::getInstancesByName($inputName);
		//交验赋值和function rules()是否一致
        if($this->validate()){
            foreach ($this->imageFiles as $file) {
				$baseName = $file->baseName .time().rand(1000,9999);
				$f = MD5($baseName).'.'.$file->extension;
                $doUpload = $file->saveAs($fullUrl.$f);
				if($doUpload){
					//缩略图生成
					$thumbData = array();
					if(!empty($thumbConfig)){
						foreach($thumbConfig as $v){
							$thumbFiles = $this->createThumbnail($url.$f,(int)$v[0], (int)$v[1]);
							if($thumbFiles){
								$thumbData[] = array(
									'path'=>$thumbFiles,
									'url'=>Yii::$app->params['imageUrl'].$thumbFiles,
									'error'=>'',
								);
							}else{
								$thumbData[] = array(
									'path'=>'',
									'url'=>'',
									'error'=>'生成缩略图失败：'.(int)$v[0].'-'.(int)$v[1],
								);
							}
						}
					}
					
					$data['files'][] = array(
						'code'=>200,
						'data'=>array(
							'name'=>$file->name,
							'tempName'=>$file->tempName,
							'type'=>$file->type,
							'size'=>$file->size,
							'path'=>$url.$f,
							'url'=>Yii::$app->params['imageUrl'].$url.$f,
							'thumbData'=>$thumbData,
						),
						'error'=>'',
					);
				}else{
					$data['files'][] = array(
						'code'=>1000,
						'data'=>array(),
						'error'=>$file->error,
					);
				}
            }
			$data['code'] = 200;
            return $data;
        }else{
			$data['error'] = $this->getErrors();
			return $data;
        }
    }
	
	/**
	 * @author pwr at 2017-05-05
	 * @todo   生成上传图片文件夹
	 */
	function createDir($aimUrl) {
        $aimUrl = str_replace('', '/', $aimUrl);
        $aimDir = '';
        $arr = explode('/', $aimUrl);
        $result = true;
        foreach ($arr as $str) {
            $aimDir .= $str . '/';
            if (!file_exists($aimDir)) {
                $result = mkdir($aimDir);
            }
        }
        return $result;
    }
	
	/**
	 * @author pwr at 2017-05-05
	 * @todo   缩略图处理
	 */
	function createThumbnail($file,$width, $height){
		$baseP = Yii::$app->basePath.'/web/uploads/';
		$u = false;
		if($file!='' && $width>0 && $height>0){
			$oFile = $baseP.$file;
			if(file_exists($oFile)){
				$d = explode('.',$file);
				$newName = $d[0].'_'.$width.'x'.$height.'.'.$d[1];
				$nFile = $baseP.$newName;
				Image::thumbnail($oFile,$width,$height)->save($nFile);
				$u = $newName;
			}
		}
		return $u;
	}
	
}