<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */

$this->title = $model->FirstName;

\yii\web\YiiAsset::register($this);
?>
<div class="rider-registration-view">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>-->
<!--        --><?php //= Html::a('Update', ['update', 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
<!--        --><?php //= Html::a('Delete', ['delete', 'ID' => $model->ID], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
<!--    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IdentificationNumber',
            ['label' => 'Rider Full Name', 'value' => fn()=>
                 $model->FirstName . ' ' . $model->LastName
            ],
            ['label'=>'Vehicle','value'=>fn()=> $model->vehicle->Type,
            ],
            'VehicleRegistration',
            [
                'label' => 'Status',
                'format' => 'raw',
                'attribute' => 'Status', // Attribute used for sorting and filtering
                'value' => function ($model) {
                    if ($model->Status == 1) {
                        return Html::tag('span', @$model->status->Status, ['class' => 'badge badge-success']);
                    } elseif ($model->Status == 2) {
                        return Html::tag('span', @$model->status->Status, ['class' => 'badge badge-danger']);
                    }
                    return @$model->status->Status;
                },
            ],

            'Email:email',
            'PhoneNumber',

        ],
    ]) ?>

</div>
