<?php

/** @var array $cartItems * */
/** @var $model UserAddress * */

/** @var yii\web\View $this */

use backend\models\ConfirmationStatus;
use riders\models\UserAddress;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

$this->title = 'Cart';
$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$customerAddress = $model->Address . ", " . \frontend\models\Counties::findOne($model->County)->name . ", " . \frontend\models\SubCounties::findOne($model->Subcounty)->Name;

?>

<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap"
        defer
></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet'/>


<div class="container fluid">
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">
            <!-- User Address -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    User Details
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'Customer Name',
                                'value' => function ($model) {
                                    return \common\models\User::findOne($model->UserID)->username;
                                },
                            ],
                            'Address',
                            [
                                'attribute' => 'County',
                                'value' => function ($model) {
                                    return \frontend\models\Counties::findOne($model->County)->name;
                                },
                            ], [
                                'attribute' => 'Subcounty',
                                'value' => function ($model) {
                                    return \frontend\models\SubCounties::findOne($model->Subcounty)->Name;
                                },
                            ],
                            'PhoneNumber',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">

            <!-- Rider Assigned -->
            <?php if (!is_null($order->Rider)) : ?>
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Rider Assigned</div>
                    <div class="card-body table-responsive">
                        <?= DetailView::widget([
                            'model' => $riderAssigned,
                            'attributes' => [
                                [
                                    'attribute' => 'Name',
                                    'value' => function ($model) {
                                        return $model->FirstName . $model->LastName;
                                    }
                                ],
                                [
                                    'attribute' => 'IdentificationNumber',
                                    'value' => function ($model) {
                                        return $model->IdentificationNumber;
                                    }
                                ],
                                [
                                    'attribute' => 'Email',
                                    'value' => function ($model) {
                                        return $model->Email;
                                    }
                                ],
                                [
                                    'attribute' => 'PhoneNumber',
                                    'value' => function ($model) {
                                        return $model->PhoneNumber;
                                    }
                                ],
                                [
                                    'attribute' => 'Vehicle',
                                    'value' => function ($model) {
                                        return $model->vehicle->Type;
                                    }
                                ],
                                [
                                    'attribute' => 'VehicleRegistration',
                                    'value' => function ($model) {
                                        return $model->VehicleRegistration;
                                    }
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Assign Rider -->
            <div class="card">
                <div class="card-header bg-warning text-dark">Acknowledge Delivery</div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($order, 'RiderConfirmation')->dropDownList(ArrayHelper::map(ConfirmationStatus::find()->all(), 'ID', 'Status'))->label(false) ?>
                    <div class="form-group">
                        <?= Html::submitButton("Submit", [
                            'class' => 'btn btn-primary btn-block',
                            'data' => [
                                'confirm' => 'Are you are sure you want to proceed?',
                                'method' => 'post',
                            ]
                        ]); ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="map" style="width: 100%; height: 500px;"></div>
   <script>
       let googleApiKey = 'AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao';
       fetch(`https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent('kisumu')}&key=${googleApiKey}`)
           .then(response => response.json())
           .then(data => {
               if(data.results && data.results.length > 0) {
                   let location = data.results[0].geometry.location;
                   // Use location.lat and location.lng for the exact coordinates
               }
           });

   </script>

</div>
