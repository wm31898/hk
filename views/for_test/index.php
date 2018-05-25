<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?php /*<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>*/ ?>

	<input name="UploadForm[imageFiles][]" multiple="" accept="image/*" aria-invalid="false" type="file">
	
	<input name="UploadFiles[]" multiple="" accept="image/*" aria-invalid="false" type="file">
    <button>Submit</button>

<?php ActiveForm::end() ?>