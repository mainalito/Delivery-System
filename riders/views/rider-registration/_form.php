<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="rider-registration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Vehicle')->textInput() ?>

    <?= $form->field($model, 'VehicleRegistration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PhoneNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdentificationNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
