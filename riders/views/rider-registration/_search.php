<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistrationSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="rider-registration-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'FirstName') ?>

    <?= $form->field($model, 'LastName') ?>

    <?= $form->field($model, 'Vehicle') ?>

    <?= $form->field($model, 'VehicleRegistration') ?>

    <?php // echo $form->field($model, 'Email') ?>

    <?php // echo $form->field($model, 'PhoneNumber') ?>

    <?php // echo $form->field($model, 'IdentificationNumber') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
