<?php

use riders\models\RiderRegistration;
use riders\models\Status;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var RiderRegistration $model */

$this->title = $model->FirstName . ' '. $model->LastName;
$this->params['breadcrumbs'][] = ['label' => 'Riders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IdentificationNumber',
            ['label' => 'Customer Name', 'value' => function ($model) {
                return $model->FirstName . ' ' . $model->LastName;
            }],
            ['label'=>'Vehicle','value'=>function ($model){
                return $model->vehicle->Type;
            }],
            'VehicleRegistration',
            'PhoneNumber',
            'Email',

            [
                'label'=>'Status',
                'format'=>'raw',
                'value'=>function ($model) {
                    if ($model->Status == 1) {
                        return Html::tag('span', @$model->status->Status, ['class'=>'badge badge-success']);
                    } elseif ($model->Status == 2) {
                        return Html::tag('span', @$model->status->Status, ['class'=>'badge badge-danger']);
                    }
                    else{
                        return Html::tag('span', 'New', ['class' => 'badge badge-primary']);

                    }
                }
            ],
        ],
    ]) ?>
    <div class="products-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'Status')->dropDownList(ArrayHelper::map(Status::find()->all(),'ID','Status')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>


</div>
