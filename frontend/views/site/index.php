<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Ecommerce Dashboard';
\yii\web\YiiAsset::register($this);
?>
<div class="container">

    <div class="content text-center">
        <!-- Add this at the top of your view or layout file -->
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="/">Products</a>
            <a href="/cart-item/index" class="d-flex align-items-center">
                <i class="fas fa-shopping-cart">
                    <span class="text-danger text-sm" id="cart-count"><?= $this->params['cartCount'] ?></span>
                </i>
            </a>
        </nav>
        <hr class="mb-4">
    </div>
    <div class="row">
        <?php foreach ($products as $product) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <?= Html::img(Yii::getAlias('@web')  . $product->image, ['class' => 'card-img-top img-fluid', 'style' => 'height:200px; object-fit:cover;']); ?>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $product->product_name ?></h5>
                        <p class="card-text flex-grow-1"><?= $product->description ?></p>
                        <div class="d-flex justify-content-between align-items-end mt-auto">
                            <p class="font-weight-bold text-muted"><?= $product->price ?></p>
                            <div class="cart-control" data-id="<?= $product->ID ?>">
                                <input type="number" value="1" min="1" class="quantity form-control"
                                       data-id="<?= $product->ID ?>" style="display:none;"/>
                                <a href="<?= Url::to(['/cart-item/add']) ?>" data-id="<?= $product->ID ?>"
                                   class="btn btn-primary add-to-cart">Add
                                    to Cart</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>





