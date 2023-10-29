<?php

use riders\models\Vehicle;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="rider-registration-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'IdentificationNumber')->textInput(['maxlength' => true, 'type' => 'number']) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'Vehicle', [
//                'template' => '{label}<div class="input-group"><div class="input-group-prepend">
//                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
//                          </div>{input}{hint}{error}</div>'
            ])->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(Vehicle::find()->all(), 'ID', 'Type'),
                'language' => 'en',
                'options' => [
                    'placeholder' => 'Select Vehicle',
                    'id' => 'approve-status',
                    'size' => \kartik\select2\Select2::SMALL,
                    'multiple' => false,
                    'required' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'VehicleRegistration')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'PhoneNumber')->widget(\borales\extensions\phoneInput\PhoneInput::className(), [
                'jsOptions' => [
                    'preferredCountries' => ['ug', 'ke', 'rw'],
                ]
            ]) ?>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['id' => 'ghost', 'class' => 'btn btn-primary float-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>