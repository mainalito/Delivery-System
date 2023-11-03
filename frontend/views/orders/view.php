<?php

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
    <div class="card rounded-lg shadow">
        <div class="card-header bg-primary text-white">
            <div class="row">
                <div class="col-md-6">
                    <h4><?= Html::encode($this->title) ?></h4>

                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <p class="text mb-0">
                        <i class="fas fa-boxes"></i>
                        Total Cost - Ksh: <strong><?= Html::encode(number_format($totalCost, 2)) ?></strong>
                    </p>
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
                <div class="card mb-3 shadow-sm">
                    <div class="row no-gutters">
                        <div class="col-md-4 col-lg-4">
                            <!-- Display the product image -->
                            <?= Html::img($imageUrl, ['class' => 'w-50']) ?>
                        </div>
                        <div class="col-md-8 col-lg-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= Html::encode($name) ?></h5>
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