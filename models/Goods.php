<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wfpc_goods".
 *
 * @property string $id
 * @property string $name
 * @property integer $is_delete
 * @property integer $is_publish
 * @property string $cate_id
 * @property string $image
 * @property string $excerpt
 * @property string $description
 * @property string $create_time
 * @property string $update_time
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wfpc_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'image', 'excerpt', 'description'], 'required'],
            [['is_delete', 'is_publish', 'cate_id', 'create_time', 'update_time'], 'integer'],
            [['description'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
            [['excerpt'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_delete' => 'Is Delete',
            'is_publish' => 'Is Publish',
            'cate_id' => 'Cate ID',
            'image' => 'Image',
            'excerpt' => 'Excerpt',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name getGoodsById
	 * @todo 获取商品详情
	 */
	public function getGoodsById($id){
		$id = (int)$id;
		if($id<=0){
			return array();
		}
		
		$data = false;
		//if(Yii::$app->params['useRedisCache']){
			$key = 'getGoodsById_'.$id;
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
	 * @name getGoodsIdList
	 * @todo 获取商品ID列表
	 */
	public function getGoodsList($where=array(),$page=1,$row=10,$getCount=0,$order='id desc',$what='id,name,is_delete,is_publish,cate_id,image,excerpt,create_time,update_time,link_url'){
		$offset = (int)($page-1)*$row;
		$query = $this->find()->select($what);
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
	 * @name updateGoodsById
	 * @todo 更新商品
	 */
	public function updateGoodsById($id,$data=array()){
		$u = -1;
		if($id>0 && !empty($data)){
			$u = $this->updateAll($data, 'id='.$id);
			
			//清缓存
			//if(Yii::$app->params['useRedisCache']){
				$key = 'getGoodsById_'.$id;
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
	 * @name addGoods
	 * @todo 添加商品
	 */
	public function addGoods($data=array()){
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
