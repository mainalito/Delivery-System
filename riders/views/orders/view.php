<?php

/** @var array $cartItems * */
/** @var $model UserAddress * */
/** @var $order Orders * */

/** @var yii\web\View $this */

use backend\models\ConfirmationStatus;
use frontend\models\Orders;
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap" defer></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />


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
            <!--             Check if the order is paid but not confirmed by the rider-->
            <?php
            if ($order->status == Orders::STATUS_PAID && $order->RiderConfirmation != 1) :
            ?>
                <!-- Assign Rider -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">Acknowledge Delivery</div>
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($order, 'RiderConfirmation')->dropDownList(ArrayHelper::map(ConfirmationStatus::find()->all(), 'ID', 'Status'), ['prompt' => 'Select Confirmation Status'])->label(false) ?>
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
            <?php else : ?>
                <!-- Show a confirmation message -->
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Order Confirmed!</h4>
                    <p>You have already confirmed order number <?= Html::encode($order->ID) ?>.</p>
                    <hr>
                    <p class="mb-0">Thank you for confirming the delivery. Your acknowledgement has been recorded.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiY2hhbGl0byIsImEiOiJjbDY1ZmoybmgwNWlmM2JxZ29wbzN2Y2dxIn0.7xk12C-uVClh4uSRva0x0w';
        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v12', // style URL
            center: [-1.3914732517370227, 36.75985297670989], // starting position [lng, lat]
            zoom: 9 // starting zoom
        });
    </script>

</div>