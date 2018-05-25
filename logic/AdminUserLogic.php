<?php
namespace app\logic;

use Yii;
use app\models\AdminUser;

class AdminUserLogic // extends MyLogic
{
	
	/**
	 * @Author wolf at 2018-01-30
	 * @name getAdminUserList
	 * @todo 获取列表
	*/
	public function getAdminUserList($where=array(),$page=1,$row=10,$getCount=0,$order='id desc',$admin_list=0){
		$data = array();
		$m = new AdminUser();
		$list = $m->getAdminUserIdList($where,$page,$row,$getCount,$order);
		if($getCount==1){
			$data = $list;
		}
		else if(!empty($list)){
			foreach($list as $v){
				$d = $this->getAdminUserData($v['id']);
                unset($d['role_id']);
                unset($d['password']);
                unset($d['create_date']);
				$data[] = $d;
			}
		}
		return $data;
	}
	
	/**
	 * @Author wolf at 2018-01-30
	 * @name getAdminUserData
	 * @todo 获取详情
	*/
	public function getAdminUserData($id){
		$m = new AdminUser();
		$dealData = $m->getAdminUserById($id);

		return $dealData;
	}


}
