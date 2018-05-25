<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FanweAdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fanwe Admins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fanwe-admin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Fanwe Admin', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'adm_name',
            'adm_password',
            'is_effect',
            'is_delete',
            // 'role_id',
            // 'login_time',
            // 'login_ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
