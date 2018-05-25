<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FanweAdmin */

$this->title = 'Create Fanwe Admin';
$this->params['breadcrumbs'][] = ['label' => 'Fanwe Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fanwe-admin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
