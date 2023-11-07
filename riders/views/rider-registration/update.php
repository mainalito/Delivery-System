<?php

use common\models\User;
use kartik\file\FileInput;
use riders\assets\AppAsset;
use riders\models\Vehicle;
use yidas\yii\fontawesome\FontawesomeAsset;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */
/** @var User $user */
/** @var array $documentTypes */

$this->title = 'Update Rider Information: ' . $model->FirstName;

$this->params['breadcrumbs'][] = ['label' => $model->FirstName, 'url' => ['view', 'ID' => isCurrentUser()]];
$this->params['breadcrumbs'][] = 'Update';
AppAsset::register($this);
// FontawesomeAsset::register($this);
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'IdentificationNumber')->textInput(['maxlength' => true, 'type' => 'number', 'disabled' => true]) ?>

                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                </div>
                <div class="col-md-4">
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

            <div class="row">
                <div class="col">
                    <?php
                    foreach ($documentTypes as $index => $docType) {
                        $mimeTypesArray = Json::decode($docType->DocumentMimeType);
                        $mimeTypesString = implode(',', $mimeTypesArray); // Convert the array to a comma-separated string for the 'accept' attribute

                        $attribute = $docType->Multiple ? 'Uploadfiles[' . $docType->ID . '][]' : 'Uploadfile[' . $docType->ID . ']';
                        $multiple = $docType->Multiple ? true : false; // Can be just (bool)$docType->Multiple
                        $options = ['multiple' => $multiple,'accept'=>$mimeTypesString];
                        $pluginOptions = [
                            'showUpload' => false,
                            'showPreview' => false,
                            'showRemove' => true,

                            // 'allowedFileExtensions' => $mimeTypesString,
                        ];

                        echo $form->field($model, $attribute)->widget(FileInput::class, [
                            'options' => $options,
                            'pluginOptions' => $pluginOptions,
                        ])->label($docType->DocumentName);
                    }
                    ?>

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