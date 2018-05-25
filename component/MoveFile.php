<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/4
 * Time: 14:05
 */

namespace app\component;


use yii\base\Behavior;
use yii;
class MoveFile extends Behavior
{
	public $uploadPath;

	public $uploadUrl;

	public function MoveTemporaryFile($file, $alias=null)
	{
		$temp_file = Yii::getAlias("@temp_uploads_path").'/'.$file;
		if (!file_exists($temp_file))
		{
			return false;
		}
		if (!$this->uploadPath) return false;
		if ($alias===null)
			$alias = date("/m/d/");
		$new = $alias.$file;
		if (DirectoryHelp::create_dir(dirname($this->uploadPath.$new)) && rename($temp_file, $this->uploadPath.$new))
		{
			@unlink($temp_file);
			return ($this->uploadUrl?$this->uploadUrl:Yii::getAlias("@goods_uploads_url")).$new;
		}
		return false;
	}
}