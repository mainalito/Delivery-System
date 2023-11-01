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
    <script type="text/javascript">
        var mapToken = '<?= Yii::$app->params['mapToken'] ?>';
        mapboxgl.accessToken = mapToken;

        mapboxgl.accessToken = '<?= Yii::$app->params['mapToken'] ?>';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [-74.5, 40],
            zoom: 9
        });

        let customerAddress = '<?=$customerAddress?>';
        alert(encodeURIComponent(customerAddress))

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                let riderLat = position.coords.latitude;
                let riderLng = position.coords.longitude;

                // Geocode the customer's address to get its coordinates
                fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(customerAddress)}.json?access_token=${mapboxgl.accessToken}`)
                    .then(response => response.json())
                    .then(data => {
                        const customerCoordinates = data.features[0].geometry.coordinates;

                        // Add customer location marker to the map
                        new mapboxgl.Marker().setLngLat(customerCoordinates).addTo(map);

                        // Add rider's marker to the map
                        new mapboxgl.Marker({color: "red"}).setLngLat([riderLng, riderLat]).addTo(map);

                        // ... [code to fetch and display directions if desired]

                        // Center the map around the customer's location or adjust as needed
                        map.flyTo({center: customerCoordinates});
                    });
            }, function (error) {
                console.error("Error obtaining geolocation", error);
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
        }


    </script>

</div>
