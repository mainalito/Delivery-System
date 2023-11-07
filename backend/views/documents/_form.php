<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Documents $model */
/** @var yii\widgets\ActiveForm $form */
 // Use these keys to define the actual MIME types for validation
 $actualMimeTypes = [
    'image' => ['image/jpeg', 'image/png', 'image/gif'],
    'word'  => ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    'excel' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
];
?>

<div class="documents-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'DocumentName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DocumentMimeType')->checkBoxList([
    'Image' => 'Image',
    'Word'  => 'Word',
    'Excel' => 'Excel',
])->label('Allowed MIME Types'); ?>


    <?= $form->field($model, 'Multiple')->dropDownList([1=> 'Yes',0=> 'No']) ?>

    <?= $form->field($model, 'Required')->dropDownList([1=> 'Yes',0=> 'No']) ?>

  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
