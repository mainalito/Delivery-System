<?php

use common\models\User;
use riders\models\Vehicle;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */
/** @var User $user */

$this->title = 'Update Rider Information: ' . $model->FirstName;
$this->params['breadcrumbs'][] = ['label' => 'Rider Registrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FirstName, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'IdentificationNumber')->textInput(['maxlength' => true, 'type' => 'number', 'disabled' => true]) ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true, 'disabled' => true]) ?>
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
                            'disabled' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'VehicleRegistration')->textInput(['maxlength' => true, 'disabled' => true]) ?>
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
    </div>
</div>