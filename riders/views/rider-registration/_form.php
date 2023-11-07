<?php

use kartik\file\FileInput;
use riders\assets\RiderAsset;
use riders\models\Vehicle;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $documentTypes */


?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'IdentificationNumber')->textInput(['maxlength' => true, 'type' => 'number']) ?>
    </div>
</div>
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
        ])->widget(\kartik\select2\Select2::class, [
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
        <?= $form->field($model, 'PhoneNumber')->widget(\borales\extensions\phoneInput\PhoneInput::class, [
            'jsOptions' => [
                'preferredCountries' => ['ug', 'ke', 'rw'],
            ]
        ]) ?>
       
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        foreach ($documentTypes as $index => $docType) {
            $mimeTypesArray = Json::decode($docType->DocumentMimeType);
            $mimeTypesString = implode(',', $mimeTypesArray); // Convert the array to a comma-separated string for the 'accept' attribute

            $attribute = $docType->Multiple ? 'Uploadfiles[' . $docType->ID . '][]' : 'Uploadfile[' . $docType->ID . ']';
            $multiple = $docType->Multiple ? true : false; // Can be just (bool)$docType->Multiple
            $options = ['multiple' => $multiple,];
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