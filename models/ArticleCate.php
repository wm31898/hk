<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wfpc_article_cate".
 *
 * @property string $id
 * @property string $title
 * @property string $brief
 * @property string $pid
 * @property integer $is_delete
 * @property string $sort
 * @property string $icon
 */
class ArticleCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wfpc_article_cate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['pid', 'is_delete', 'sort'], 'integer'],
            [['title', 'brief','icon'], 'string', 'max' => 255],
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
            'brief' => 'Brief',
            'pid' => 'Pid',
            'is_delete' => 'Is Delete',
            'sort' => 'Sort',
            'icon_url' => 'Icon Url',
        ];
    }
	
	/**
	 * @Author pwr at 2018-02-08
	 * @name getArticleCateById
	 * @todo 获取文章分类详情
	 */
	public function getArticleCateById($id){
		$id = (int)$id;
		if($id<=0){
			return array();
		}
		
		$data = false;
		//if(Yii::$app->params['useRedisCache']){
			$key = 'getArticleCateById_'.$id;
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
	 * @Author pwr at 2018-02-08
	 * @name getArticleCateIdList
	 * @todo 获取文章分类ID列表
	 */
	public function getArticleCateIdList($where=array(),$page=1,$row=10,$getCount=0,$order='id desc'){
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
	 * @Author pwr at 2018-02-08
	 * @name updateArticleCateById
	 * @todo 更新文章分类
	 */
	public function updateArticleCateById($id,$data=array()){
		$u = -1;
		if($id>0 && !empty($data)){
			$u = $this->updateAll($data, 'id='.$id);
			
			//清缓存
			//if(Yii::$app->params['useRedisCache']){
				$key = 'getArticleCateById_'.$id;
				$cache = Yii::$app->cache;
				//$cache = Yii::$app->cacheRedis;
				//$cache = Yii::$app->cacheMemcache;
				$data = $cache->delete($key);
			//}
		}
		
		return $u;
	}
	
	/**
	 * @Author pwr at 2018-02-08
	 * @name addArticleCate
	 * @todo 添加文章分类
	 */
	public function addArticleCate($data=array()){
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
