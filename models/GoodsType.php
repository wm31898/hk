<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wfpc_goods_type".
 *
 * @property string $id
 * @property string $type_name
 * @property string $pid
 * @property integer $is_delete
 * @property string $sort
 * @property string $icon
 */
class GoodsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wfpc_goods_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name'], 'required'],
            [['pid', 'is_delete', 'sort'], 'integer'],
            [['type_name', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
            'pid' => 'Pid',
            'is_delete' => 'Is Delete',
            'sort' => 'Sort',
            'icon' => 'Icon',
        ];
    }
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name getGoodsTypeById
	 * @todo 获取商品分类详情
	 */
	public function getGoodsTypeById($id){
		$id = (int)$id;
		if($id<=0){
			return array();
		}
		
		$data = false;
		//if(Yii::$app->params['useRedisCache']){
			$key = 'getGoodsTypeById_'.$id;
			$cache = Yii::$app->cache;
			//$cache = Yii::$app->cacheRedis;
			//$cache = Yii::$app->cacheMemcache;
			$data = $cache->get($key);
		//}
		
		if($data==false || (isset($_GET['noRedisCache']) && $_GET['noRedisCache']=='y')){
			$data = $this->find()->where(['id'=>$id])->asArray()->one();
			if(!empty($data)){
				$cache->set($key, $data,Yii::$app->params['redisCacheTimeH']);
			}
		}
		
		return $data;
	}
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name getGoodsTypeList
	 * @todo 获取商品分类列表
	 */
	public function getGoodsTypeList($where=array(),$page=1,$row=10,$getCount=0,$order='sort desc, id desc'){
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
	 * @Author pwr at 2018-04-08
	 * @name updateGoodsTypeById
	 * @todo 更新商品分类
	 */
	public function updateGoodsTypeById($id,$data=array()){
		$u = -1;
		if($id>0 && !empty($data)){
			$u = $this->updateAll($data, 'id='.$id);
			
			//清缓存
			//if(Yii::$app->params['useRedisCache']){
				$key = 'getGoodsTypeById_'.$id;
				$cache = Yii::$app->cache;
				//$cache = Yii::$app->cacheRedis;
				//$cache = Yii::$app->cacheMemcache;
				$data = $cache->delete($key);
			//}
		}
		
		return $u;
	}
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name addGoodsType
	 * @todo 添加商品分类
	 */
	public function addGoodsType($data=array()){
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
