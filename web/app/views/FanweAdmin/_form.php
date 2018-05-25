<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FanweAdmin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fanwe-admin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'adm_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adm_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_effect')->textInput() ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <?= $form->field($model, 'role_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'login_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'login_ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
