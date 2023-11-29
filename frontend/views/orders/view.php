<?php

use frontend\models\Orders;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Orders $model */

$this->title = 'Order No: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$datePlaced = date('F j, Y', strtotime($model->confirmed_at));
?>
<div class="container-fluid">
    <div class="row">
        <?php if ($model->RiderConfirmation == 1 && in_array($model->status, [Orders::STATUS_COMPLETED, Orders::STATUS_SHIPPED])) : ?>
        <div class="col-md-6">
            <?php else : ?>
            <div class="col-md-12">
                <?php endif; ?>
                <div class="card rounded-lg shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="row">
                            <div class="col-md-6">
                                <h4><?= Html::encode($this->title) ?></h4>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="row">
                                    <div class="col">
                                        <p class="text mb-0">
                                            <i class="fas fa-boxes"></i>
                                            Total Cost - Ksh:
                                            <strong><?= Html::encode(number_format($totalCost, 2)) ?></strong>
                                        </p>
                                    </div>
                                    <?php if(Orders::STATUS_PAID) : ?>
                                    <div class="col">
                                        <?= Html::a('View Delivery Details', ['view-delivery-details', 'id' => base64_encode($model->ID)], ['class' => 'btn btn-warning ml-3', 'id' => 'viewDeliveryDetailsBtn', 'onclick' => 'showModal(event, this.href)']) ?>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="text-muted mb-0">
                                <i class="fas fa-boxes"></i>
                                Number of Items: <strong><?= Html::encode($numberOfProducts) ?></strong>
                            </p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar-alt"></i>
                                Date Placed: <strong><?= Html::encode($datePlaced) ?></strong>
                            </p>
                        </div>
                        <hr>
                        <?php foreach ($products as $product) : ?>
                        <?php
                            $name = $product->product_name;
                            $description = $product->description;
                            $price = number_format($product->price);
                            $imageUrl = Yii::$app->params['backendUrl'] . $product->image;
                            ?>
                        <div class="media mb-3 shadow-sm">
                            <div class="row no-gutters">
                                <div class="col-md-4 col-lg-4">
                                    <!-- Display the product image -->
                                    <?= Html::img($imageUrl, ['class' => 'w-50 ']) ?>
                                </div>
                                <div class="col-md-8 col-lg-8">
                                    <div class="media-body">
                                        <h5 class="media-heading"><?= Html::encode($name) ?></h5>
                                        <p>
                                            <i class="fas fa-info-circle"></i>
                                            Description: <?= Html::encode($description) ?>
                                        </p>
                                        <p>
                                            <i class="fas fa-tag"></i>
                                            Price: Ksh <?= Html::encode($price) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php if ($model->RiderConfirmation == 1 && in_array($model->status, [Orders::STATUS_COMPLETED, Orders::STATUS_SHIPPED])) : ?>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Courier</div>
                    <div class="card-body table-responsive">
                        <?= DetailView::widget([
                                    'model' => $riderInformation,
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
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div id="deliveryDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4>Delivery Details</h4>
            <!-- Content will be loaded here -->
        </div>
    </div>
    <style>
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        /* Could be more or less, depending on screen size */
        border-radius: 10px;
        /* Curved corners */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .loading {
        text-align: center;
        padding: 20px;
    }

    .error {
        color: red;
        text-align: center;
        padding: 20px;
    }
    </style>
    <script>
    // Define the showModal function
    function showModal(event, url) {
        event.preventDefault();

        var modal = document.getElementById('deliveryDetailsModal');
        var modalContent = $('.modal-content');
        modalContent.html('<div class="loading">Loading...</div>'); // Loading message
        modal.style.display = 'block';

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                modalContent.html(response);
            },
            error: function() {
                modalContent.html('<div class="error">Error loading content.</div>');
            }
        });
    }


    // Close modal logic
    var span = document.getElementsByClassName('close')[0];
    span.onclick = function() {
        var modal = document.getElementById('deliveryDetailsModal');
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        var modal = document.getElementById('deliveryDetailsModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
    </script>