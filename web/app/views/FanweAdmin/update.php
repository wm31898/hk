<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FanweAdmin */

$this->title = 'Update Fanwe Admin: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fanwe Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fanwe-admin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
