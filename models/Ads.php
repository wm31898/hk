<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wfpc_ads".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $editor_id
 * @property string $editor_name
 * @property string $add_time
 * @property string $publish_time
 * @property string $end_time
 * @property string $target_id
 * @property string $link
 * @property integer $type
 * @property integer $is_delete
 * @property integer $sort
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wfpc_ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['title', 'description', 'image', 'editor_name', 'link'], 'required'],
            [['editor_id', 'add_time', 'publish_time', 'end_time', 'target_id', 'type', 'is_delete', 'sort'], 'integer'],
            [['title', 'editor_name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['image', 'link'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'editor_id' => 'Editor ID',
            'editor_name' => 'Editor Name',
            'add_time' => 'Add Time',
            'publish_time' => 'Publish Time',
            'end_time' => 'End Time',
            'target_id' => 'Target ID',
            'link' => 'Link',
            'type' => 'Type',
            'is_delete' => 'Is Delete',
            'sort' => 'Sort',
        ];
    }
	
	/**
	 * @Author pwr at 2017-09-08
	 * @name getAdsById
	 * @todo 获取广告轮播图详情
	 */
	public function getAdsById($id){
		$id = (int)$id;
		if($id<=0){
			return array();
		}
		
		// 如果数据没有变化,可能用的是缓存
		$data = false;
		$key = 'getAdsById_'.$id;
		$cache = Yii::$app->cache;
		//$cache = Yii::$app->cacheRedis;
		//$cache = Yii::$app->cacheMemcache;
		$data = $cache->get($key);
		if($data==false || (isset($_GET['noRedisCache']) && $_GET['noRedisCache']=='y')){
			$data = $this->find()->where(['id'=>$id])->asArray()->one();
			if(!empty($data)){
				$cache->set($key, $data,Yii::$app->params['redisCacheTimeH']);
			}
		}
		return $data;
	}
	
	/**
	 * @Author pwr at 2017-09-08
	 * @name getAdsIdList
	 * @todo 获取广告轮播图ID列表
	 */
	public function getAdsIdList($where=array(),$page=1,$row=10,$getCount=0,$order='id desc'){
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
	 * @Author pwr at 2017-09-08
	 * @name updateAdsById
	 * @todo 更新广告轮播图信息
	 */
	public function updateAdsById($id,$data=array()){
		$u = -1;
		if($id>0 && !empty($data)){
			$u = $this->updateAll($data, 'id='.$id);
			
			//清缓存
			//if(Yii::$app->params['useRedisCache']){
				$key = 'getAdsById_'.$id;
				$cache = Yii::$app->cache;
				//$cache = Yii::$app->cacheRedis;
				//$cache = Yii::$app->cacheMemcache;
				$data = $cache->delete($key);
			//}
		}
		
		return $u;
	}
	
	/**
	 * @Author pwr at 2017-09-08
	 * @name addAds
	 * @todo 添加广告轮播图信息
	 */
	public function addAds($data=array()){
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
