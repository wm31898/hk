<?php

namespace app\models;

use Yii;
use app\logic\AdminUserLogic;
/**
 * This is the model class for table "xy_admin_user".
 *
 * @property integer $id
 */
class AdminUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wfpc_admin_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [  ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * 用户相关查询
     * @Author wolf at 2017-10-30
     * @name getAdminUserByUser
     * $arr_data 查询的数组 例如  ['id' => 12 ]
     * @todo 用于登录查询和多条件查询使用
     */
    public function getAdminuserByUser($arr_data){
        //查询登录
        $data = $this->find()->where($arr_data)->asArray()->one();

        return $data;
    }

    /**
     * @Author wolf at 2017-10-31
     * @name getAdminUserById
     * @todo 获取详情
     */
    public function getAdminUserById($id){
        $id = (int)$id;
        if($id<=0){
            return array();
        }

        $data = false;
        if(Yii::$app->params['useRedisCache']){
            $key = 'getAdminUserById_'.$id;
            $cache = Yii::$app->cacheRedis;
            //$cache = Yii::$app->cacheMemcache;
            $data = $cache->get($key);
        }

        if($data==false || (isset($_GET['noRedisCache']) && $_GET['noRedisCache']=='y')){
            $data = $this->find()->where(['id'=>$id])->asArray()->one();
            if(Yii::$app->params['useRedisCache']){
                $cache->set($key, $data,Yii::$app->params['redisCacheTimeH']);
            }
        }

        return $data;
    }


	/**
	 * @Author wolf at 2017-10-30
	 * @name getAdminUserIdList
	 * @todo 获取用户ID列表
	 */
	public function getAdminUserIdList($where=array(),$page=1,$row=10,$getCount=0,$order='id desc'){
		$offset = (int)($page-1)*$row;
		$query = $this->find()->select('id');
		if(!empty($where)){
			if(isset($where['max_'])){
				foreach($where['max_'] as $v){
					$query->andFilterWhere($v);
				}
				unset($where['max_']);
			}
			if(isset($where['like_'])){
				foreach($where['like_'] as $v){
					$query->andFilterWhere($v);
				}
				unset($where['like_']);
			}
			$query->andFilterWhere($where);
		}
		
		if($getCount==1){
			$data = $query->asArray()->count();
		}else{
			$query->orderBy($order);
			$query->offset($offset)->limit($row);
			$data = $query->asArray()->all();
		}
		//var_dump($data);
		//die();
		return $data;
	}
	
	/**
	 * @Author wolf at 2017-10-30
	 * @name updateAdminUserById
	 * @todo 更新用户信息
	 */
	public function updateAdminUserById($id,$data=array()){
		$u = -1;
		if($id>0 && !empty($data)){
			$u = $this->updateAll($data, 'id='.$id);
			
			//清缓存
			if(Yii::$app->params['useRedisCache']){
				$key = 'getAdminUserById_'.$id;
				$cache = Yii::$app->cacheRedis;
				//$cache = Yii::$app->cacheMemcache;
				$data = $cache->delete($key);
			}
		}
		
		return $u;
	}
	
	/**
	 * @Author wolf at 2017-10-30
	 * @name addAdminUser
	 * @todo 添加用户信息
	 */
	public function addAdminUser($data=array()){
		$u = -1;
        if(!empty($data)){
            $m = new self();
            foreach($data as $k=>$v){
                $m->$k = $v;
            }
            $e = $m->save();
            if($e){
                $u = $m->id;
            }else{
                $u = $e;
            }
        }
		
		return $u;
	}
	
}
