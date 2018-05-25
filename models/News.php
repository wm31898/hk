<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wfpc_news".
 *
 * @property string $id
 * @property string $title
 * @property string $image
 * @property string $content
 * @property string $cate_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_delete
 * @property string $click_count
 * @property string $sort
 * @property string $publish_time
 * @property integer $is_publish
 * @property string $excerpt
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wfpc_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['content'], 'string'],
            [['cate_id', 'create_time', 'update_time', 'is_delete', 'click_count', 'sort', 'publish_time', 'is_publish'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'image' => 'Image',
            'content' => 'Content',
            'cate_id' => 'Cate ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'is_delete' => 'Is Delete',
            'click_count' => 'Click Count',
            'sort' => 'Sort',
            'publish_time' => 'Publish Time',
            'is_publish' => 'Is Publish',
            'excerpt' => 'Excerpt',
        ];
    }
	
	/**
	 * @Author pwr at 2018-04-08
	 * @name getNewsById
	 * @todo 获取新闻详情
	 */
	public function getNewsById($id){
		$id = (int)$id;
		if($id<=0){
			return array();
		}
		
		$data = false;
		//if(Yii::$app->params['useRedisCache']){
			$key = 'getNewsById_'.$id;
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
	 * @name getNewsIdList
	 * @todo 获取新闻ID列表
	 */
	public function getNewsList($where=array(),$page=1,$row=10,$getCount=0,$order='sort desc'){
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
	 * @name updateNewsById
	 * @todo 更新新闻
	 */
	public function updateNewsById($id,$data=array()){
		$u = -1;
		if($id>0 && !empty($data)){
			$u = $this->updateAll($data, 'id='.$id);
			
			//清缓存
			//if(Yii::$app->params['useRedisCache']){
				$key = 'getNewsById_'.$id;
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
	 * @name addNews
	 * @todo 添加新闻
	 */
	public function addNews($data=array()){
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
